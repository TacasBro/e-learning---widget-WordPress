
<?php  
        
	if(isset($_POST['nazwa_materialu']))//sprawdza czy są zarezerwowane miejsce w pamięci 
	{
        //udana walidacja flaga
        $wszystko_ok=true;

        //sprawdzamy informacje o wydziale
        //bool ereg(string pattern, string string [, array regs])
        // pobranie danych z formularza
        $nazwa_materialu=$_POST['nazwa_materialu'];
        $rodzaj=$_POST['rodzaj'];
        $dziedzina=$_POST['dziedzina'];
        $certyfikat=$_POST['certyfikat'];
        $data_utworzenia=$_POST['data_utworzenia'];
        $data_modyfikacji=$_POST['data_modyfikacji'];
        $nr_wersji=$_POST['nr_wersji'];
        $opis=$_POST['opis'];
      

        //sprawdzamy poprawność imienia
        //if(!(preg_match ('/^[0-9]+$/', $liczba_godzin)))
        if(empty($nazwa_materialu)){
            $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
            $_SESSION['error_nazwa_materialu']="Pole jest puste ";
        }    
       
       
        if(empty($rodzaj)){
            $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
            $_SESSION['error_rodzaj']="Pole jest puste";
        }
      
        if(empty($dziedzina)){
            $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
            $_SESSION['error_dziedzina']="Pole jest puste";
        }      
       
        if(empty($certyfikat)){
            $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
            $_SESSION['error_certyfikat']="Pole jest puste";
        }     
        if(empty($data_utworzenia)){
            $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
            $_SESSION['error_data_utworzenia']="Pole jest puste";
        }    
       
       
        if(empty($data_modyfikacji)){
          $data_modyfikacji=$data_utworzenia;
        }
      
        if(empty($nr_wersji)){
            $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
            $_SESSION['error_nr_wersji']="Pole jest puste";
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
                    $rezultat=$polaczenie->query("SELECT nazwa, rodzaj from e_materialy where nazwa='$nazwa_materialu'and rodzaj='$rodzaj'");
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania

                    $ilosc_rows=$rezultat->num_rows;// zwrócenie ilości wystąpien w bazie
                    if($ilosc_rows>0){
                        $wszystko_ok=false; //ustawienie flagi
                        $_SESSION['error_opis']="Ta pozycja już istniej w bazie"; // jezeli istaniej w bazie wyświetl na ekranie
                    }
                

                
                }
                if($wszystko_ok==true){
                    //dodajemy do bazy jeśli wszystkie dane sa poprawne 
                if($polaczenie->query("INSERT INTO e_materialy VALUES (NULL,'$rodzaj','$nazwa_materialu','$dziedzina','$certyfikat','$data_utworzenia','$data_modyfikacji','$nr_wersji','$opis')"))
                        {
                            $id=$polaczenie->insert_id;          
                           header("Location:add_ematerial_cd.php?id=$id");
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

    <div class='tabela_ematerialy'>
        <form class="form" method="post">
        <div class="form-row">
        <div  div class="form-group col-md-3" >
           Nazwa:
            <br/>
            <input  type="text" class="form-control" name="nazwa_materialu" />
            <?php
			if (isset($_SESSION['error_nazwa_materialu']))
			{
				echo '<div class="error">'.$_SESSION['error_nazwa_materialu'].'</div>';
				unset($_SESSION['error_nazwa_materialu']);
			}
		?>
            </div>
            <div  div class="form-group col-md-3" >
            Rodzaj:
            <br/>
            <input  class="form-control"  type="text" name="rodzaj" />
            <?php
			if (isset($_SESSION['error_rodzaj']))
			{
				echo '<div class="error">'.$_SESSION['error_rodzaj'].'</div>';
				unset($_SESSION['error_rodzaj']);
			}
		?>
            </div>
            <div  div class="form-group col-md-3" >
             Dziedzina:
            <br/>
            <input class="form-control"  type="text" name="dziedzina" />
            <?php
			if (isset($_SESSION['error_dziedzina']))
			{
				echo '<div class="error">'.$_SESSION['error_dziedzina'].'</div>';
				unset($_SESSION['error_dziedzina']);
			}
		?>
            </div>
            <div  div class="form-group col-md-3" >
             Rodzaj certyfikatu:
            <br/>
            <input class="form-control"  type="text" name="certyfikat" />
            <?php
			if (isset($_SESSION['error_certyfikat']))
			{
				echo '<div class="error">'.$_SESSION['error_certyfikat'].'</div>';
				unset($_SESSION['error_certyfikat']);
			}
		?>
            </div>
            </div>
            <div class="form-row">
            <div  div class="form-group col-md-3" >
             Data utowrzenia:
             </br>
            <input class="form-control"  type="date" name="data_utworzenia" />
            <?php
			if (isset($_SESSION['error_data_utworzenia']))
			{
				echo '<div class="error">'.$_SESSION['error_data_utworzenia'].'</div>';
				unset($_SESSION['error_data_utworzenia']);
			}
		?>
            </div>
            <div  div class="form-group col-md-3" >
            Data modyfikacji:
             </br>
            <input class="form-control"  type="date" name="data_modyfikacji" />
            
            </div>
            <div  div class="form-group col-md-3" >
            Wersja:
            <br/>
            <input class="form-control"  type="text" name="nr_wersji" />
            <?php
			if (isset($_SESSION['error_nr_wersji']))
			{
				echo '<div class="error">'.$_SESSION['error_nr_wersji'].'</div>';
				unset($_SESSION['error_nr_wersji']);
			}
		?>
            </div>
            <div  div class="form-group col-md-3" >
            Opis:
             </br>
             <textarea class="form-control"   rows="1" cols="50" name="opis">
             </textarea>
             </div>         
                
            <input style="margin-bottom:15px;" type="submit" class="btn btn-primary" value="Dodaj Materiał"</input>
            </div> 
        </form>

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
                $rezultat=$polaczenie->query("SELECT * FROM e_materialy ");
                $number_of_results = mysqli_num_rows($rezultat);
                $number_of_pages = ceil($number_of_results/$results_per_page);
                if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                if (!isset($_GET['page'])) {
                    $page = 1;
                  } else {
                    $page = $_GET['page'];
                  }
                  $this_page_first_result = ($page-1)*$results_per_page;
                  $rezultat=$polaczenie->query("SELECT * FROM e_materialy");
                echo "<table class='table table-sm'>";     
                echo "<tr>";
                    echo "<th>Lp.</th>";
                    echo "<th>Rodzaj</th>";
                    echo "<th>Nazwa</th>";
                
                    echo "<th>Dziedzina</th>";
                    echo "<th>Certyfika</th>";
                    echo "<th>Data utowrzenia</th>";  
                    echo "<th>Data modyfikacji</th>"; 
                    echo "<th>Wersja</th>";   
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
                        echo "<td>".$r[6]."</td>"; 
                        echo "<td>".$r[7]."</td>";      
                        echo "<td>".$r[8]."</td>";                   
                        
                        echo "<td>";                                                                 
                        echo "<button type='button' class='edit' name='id' value='$r[0]'><img src='../wp-content/plugins/e-learning/admin/partials/materialy/img/edit.png'></button>
                        <button type='button' class='button_delete_material' value='$r[0]'><img src='../wp-content/plugins/e-learning/admin/partials/materialy/img/delete.png'></button> ";     
                           
                        echo "</td>";
                        echo "<td> ";                            
                      
                } 
                echo "</form>"; 
                echo "</table>"; 
                echo"</div>";
                }               
                $polaczenie->close();               
    }  catch(Exception $e){
        echo "Błąd serwer przepraszamy";
    } 
    // echo"<div class=stronicowanie >";
    // for ($page=1;$page<=$number_of_pages;$page++) {
        
    //       echo "<a  href='add_ematerialy.php?page=$page'>$page</a> ";
          
    //     }
    //     echo"</div>";
?>
<script>
    $(document).ready(function () {
        $('.button_delete_material').click(function () {
            if (window.confirm('Napewno chcesz usunąć?'))
                var clickBtnValue = $(this).val();
                 var ajaxurl = '../wp-content/plugins/e-learning/admin/partials/materialy/funkcja_delete.php',
                data = { 'delete_material': clickBtnValue };
            $.post(ajaxurl, data, function (response) {
                // Response div goes here.
                
                $("body").load(document.URL);
             
            });
        });

    });
    </script>
    <script>
    $(document).ready(function () {
        $('.edit').click(function () {            
                var clickBtnValue = $(this).val();                
                window.open("../wp-content/plugins/e-learning/admin/partials/materialy/add_ematerial_cd.php?id="+clickBtnValue+"","","toolbar=yes,scrollbars=yes,resizable=yes,width=1000,height=700");
                return false;        
        });

    });
    </script>