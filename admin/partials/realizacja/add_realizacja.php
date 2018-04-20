
<?php  
   
	if(isset($_POST['nazwa_projektu']))//sprawdza czy są zarezerwowane miejsce w pamięci 
	{
        //udana walidacja flaga
        $wszystko_ok=true;

        //sprawdzamy informacje o wydziale
        //bool ereg(string pattern, string string [, array regs])
        // pobranie danych z formularza
        $nazwa_projektu=$_POST['nazwa_projektu'];
        $start_kursu=$_POST['start_kursu'];
        $koniec_kursu=$_POST['koniec_kursu'];
        $opis=$_POST['opis'];
      

        //sprawdzamy poprawność imienia
        //if(!(preg_match ('/^[0-9]+$/', $liczba_godzin)))
                
        if(empty($nazwa_projektu)){
            $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
            $_SESSION['error_nazwa_projektu']="Pole jest puste";
        }    
       
       
        if(empty($start_kursu)){
            $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
            $_SESSION['error_start_kursu']="Pole jest puste";
        }
      
        if(empty($koniec_kursu)){
            $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
            $_SESSION['error_koniec_kursu']="Pole jest puste";
        }      
       
        if(empty($opis)){
            $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
            $_SESSION['error_opis']="Pole jest puste";
        }     
		

        require_once "../wp-content/plugins/e-learning/admin/partials/connect.php";// pobranie danych potrzebnych do połączenia z bazą
        mysqli_report(MYSQLI_REPORT_STRICT);// wyłaczenie ostrzeżenie generowanych przez system php, natomiast wyświetlony zostaje wyjatek
        try{
                $polaczenie =new mysqli($host, $db_user, $db_password, $db_name); // połaczenie sie z bazą danych
                $polaczenie -> query ('SET NAMES utf8');//kodowanie obsługa polski znaków
                $polaczenie -> query ('SET CHARACTER_SET utf8_general_ci');
                if ($polaczenie->connect_errno!=0)  // 
                {
                    throw new Exception(mysqli_connect_errno());// wyrzucenie wyjatku, brak połaczenie z baza
                }
                else
                {
                    //sprawdzenie czy takie same dane istnieja w bazie danych
                    $rezultat=$polaczenie->query("SELECT nazwa_projektu, start_kursu, koniec_kursu, opis FROM realizacja WHERE nazwa_projektu='$nazwa_projektu' and start_kursu='$start_kursu'and koniec_kursu='$koniec_kursu' and opis='$opis'");
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania

                    $ilosc_rows=$rezultat->num_rows;// zwrócenie ilości wystąpien w bazie
                    if($ilosc_rows>0){
                        $wszystko_ok=false; //ustawienie flagi
                        $_SESSION['error_strona_www']="Ta pozycja już istniej w bazie"; // jezeli istaniej w bazie wyświetl na ekranie
                    }
                

                
                }
                if($wszystko_ok==true){
                    //dodajemy do bazy jeśli wszystkie dane sa poprawne 
                if($polaczenie->query("INSERT INTO realizacja VALUES (NULL,'$nazwa_projektu',0,'$start_kursu','$koniec_kursu','$opis')"))
                        {
                            $id=$polaczenie->insert_id;          
                           header("Location:add_realizacja_cd.php?id=$id");
                        }
                    else{
                      //  throw new Exception($polaczenie->erro);
                        }
                }
                $polaczenie->close();
                


        }
        catch(Exception $e){
            echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
            echo "informacja".$e;
        }      
        
    }

?>


   
    <div class='tabela_realizacja'>
        <form class="form" method="post">
        <div class="form-row">
        <div  div class="form-group col-md-3" >
           Nazwa projektu:
            <br/>
            <input type="text"class="form-control"  name="nazwa_projektu" />
            <?php
			if (isset($_SESSION['error_nazwa_projektu']))
			{
				echo '<div class="error">'.$_SESSION['error_nazwa_projektu'].'</div>';
				unset($_SESSION['error_nazwa_projektu']);
			}
		?>
             </div>
             <div  div class="form-group col-md-3" >
             Start kursu:
             </br>
            <input type="date" class="form-control"  name="start_kursu" />
            <?php
			if (isset($_SESSION['error_start_kursu']))
			{
				echo '<div class="error">'.$_SESSION['error_start_kursu'].'</div>';
				unset($_SESSION['error_start_kursu']);
			}
		?>
             </div>
             <div  div class="form-group col-md-3" >
            Koniec kursu:
             </br>
             
            <input type="date"  class="form-control"  name="koniec_kursu" />
            <?php
			if (isset($_SESSION['error_koniec_kursu']))
			{
				echo '<div class="error">'.$_SESSION['error_koniec_kursu'].'</div>';
				unset($_SESSION['error_koniec_kursu']);
			}
		?>
            </div>
            <div  div class="form-group col-md-3" >
            Opis:
             </br>
             <textarea  class="form-control"  rows="1" cols="50" name="opis">
             </textarea>
             <?php
			if (isset($_SESSION['error_opis']))
			{
				echo '<div class="error">'.$_SESSION['error_opis'].'</div>';
				unset($_SESSION['error_opis']);
			}
		?>
            </div>
            </div>           

            <input style="margin-bottom:15px;" type="submit"class="btn btn-primary" value="Dodaj projekt"</input>
            </form>      
     


    
   

    </html>
    <?php
   
     require_once "../wp-content/plugins/e-learning/admin/partials/connect.php";// pobranie danych potrzebnych do połączenia z bazą
     mysqli_report(MYSQLI_REPORT_STRICT);// wyłaczenie ostrzeżenie generowanych przez system php, natomiast wyświetlony zostaje wyjatek
     try{
             $polaczenie =new mysqli($host, $db_user, $db_password, $db_name); // połaczenie sie z bazą danych
             $polaczenie -> query ('SET NAMES utf8');//kodowanie obsługa polski znaków
             $polaczenie -> query ('SET CHARACTER_SET utf8_general_ci');
             if ($polaczenie->connect_errno!=0)  // 
             {
                 throw new Exception(mysqli_connect_errno());// wyrzucenie wyjatku, brak połaczenie z baza
             }
             else
             {
                $results_per_page = 10;
                $page = ''; 
                $rezultat=$polaczenie->query("SELECT * FROM realizacja ");                
                $number_of_results = mysqli_num_rows($rezultat);
                $number_of_pages = ceil($number_of_results/$results_per_page);
                if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                if (!isset($_GET['page'])) {
                    $page = 1;
                  } else {
                    $page = $_GET['page'];
                  }
                  $this_page_first_result = ($page-1)*$results_per_page;
                  $rezultat=$polaczenie->query("SELECT * FROM realizacja");
                echo "<table class='table table-sm'>";           
                echo "<tr>";
                    echo "<th>Lp.</th>";
                    echo "<th>Nazwa projektu</th>";
                    echo "<th>Liczba godzin</th>";
                    echo "<th>Start kursu</th>";
                    echo "<th>Koniec kursu</th>";
                    echo "<th>Opis</th>";                  
                    echo "<th></th>";
                echo "</tr>";
               
                $index=0;
                
                while($r = mysqli_fetch_array($rezultat)) { 
                    $index++;
                    echo "<tr>"; 
                        echo "<td>".$index."</td>"; 
                        echo "<td>".$r[1]."</td>"; 
                        echo "<td>".$r[2]."</td>"; 
                        echo "<td>".$r[3]."</td>"; 
                        echo "<td>".$r[4]."</td>";      
                        echo "<td>".$r[5]."</td>";                      
                        
                        echo "<td>";                                                                     
                        echo "<button type='button' class='edit_realizacja' name='id' value='$r[0]'><img src='../wp-content/plugins/e-learning/admin/partials/realizacja/img/edit.png'></button>
                        <button type='button' class='button_delete_realizacja' value='$r[0]'><img src='../wp-content/plugins/e-learning/admin/partials/realizacja/img/delete.png'></button>";     
                           
                        echo "</td>";
                        echo "</tr>"; 
                } 
                echo "</form>"; 
                echo "</table>"; 
                echo"</div>";
                }               
                $polaczenie->close();               
    }  catch(Exception $e){

    
    } 
    // echo"<div class=stronicowanie >";
    // for ($page=1;$page<=$number_of_pages;$page++) {
        
    //       echo "<a  href='add_realizacja.php?page=$page'>$page</a> ";
          
    //     }
    //     echo"</div>";
?>
<script>
    $(document).ready(function () {
        $('.button_delete_realizacja').click(function () {
            if (window.confirm('Napewno chcesz usunąć?'))
                var clickBtnValue = $(this).val();
                 var ajaxurl = '../wp-content/plugins/e-learning/admin/partials/realizacja/funkcja_delete.php',
                data = { 'delete_realizacja': clickBtnValue };
            $.post(ajaxurl, data, function (response) {
                // Response div goes here.
                $("body").load(document.URL);
             
               
            });
        });

    });
    </script>
    <script>
    $(document).ready(function () {
        $('.edit_realizacja').click(function () {            
                var clickBtnValue = $(this).val();                
                window.open("../wp-content/plugins/e-learning/admin/partials/realizacja/add_realizacja_cd.php?id="+clickBtnValue+"","","toolbar=yes,scrollbars=yes,resizable=yes,width=600,height=800");                
                return false;        
        });

    });
    </script>