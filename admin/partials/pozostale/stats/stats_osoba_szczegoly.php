<html>
<head>
<link rel="Stylesheet" type="text/css" href="css/style.css" />
        <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <link rel="Stylesheet" type="text/css" href="css/bootstrap.min.css" />
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
  </head>
  
<body>
<div style="margin:50px;" class="tabela">
<?php  
      
      $id_prowadzacego_stats=$_POST['id_prowadzacego_stats'];  
      $id_realizacji_stats=$_POST['id_realizacji_stats']; 
       require_once "connect.php";// pobranie danych potrzebnych do połączenia z bazą
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
                    $rezultat=$polaczenie->query("SELECT DISTINCT  realizacja.nazwa_projektu from realizacja,realizacja_prowadzacy,prowadzacy where realizacja.id_realizacji=realizacja_prowadzacy.id_realizacji and prowadzacy.id_prowadzacego=realizacja_prowadzacy.id_prowadzacego and prowadzacy.id_prowadzacego=$id_prowadzacego_stats and realizacja.id_realizacji=$id_realizacji_stats");  
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania                  
                                      
                    $index=0;
                    while($r = mysqli_fetch_array($rezultat)) { 
                        $index++;
                        echo "<tr>";                   
                        echo "<td> Nazwa prowadzonego projektu: " . $r[0] . "</td>";          
                        echo "</tr>"; 
                    } 
                    echo "</table>"; 
                    
                    // wyłapanie wyjątku z błędem zapytania
                   }
                   $polaczenie->close();
            }catch(Exception $e)
                   {
                      
                   }     
     

?>
</div>     

<div style="margin:50px; border: 2px dotted gray;" class="tabela">
<label>Informacje związane z daną osobą</label>
<div style="margin:50px;" class="tabela">
<label>Projekt które prowadzi dana osoba:</label>
<?php  
      
      $id_prowadzacego_stats=$_POST['id_prowadzacego_stats'];  
      $id_realizacji_stats=$_POST['id_realizacji_stats']; 
   
       require_once "connect.php";// pobranie danych potrzebnych do połączenia z bazą
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
                    $rezultat=$polaczenie->query("SELECT DISTINCT  realizacja.nazwa_projektu,realizacja.liczba_godzin, realizacja.start_kursu, realizacja.koniec_kursu, realizacja.opis, realizacja.id_realizacji from realizacja,realizacja_prowadzacy,prowadzacy where realizacja.id_realizacji=realizacja_prowadzacy.id_realizacji and prowadzacy.id_prowadzacego=realizacja_prowadzacy.id_prowadzacego and prowadzacy.id_prowadzacego=$id_prowadzacego_stats and realizacja.id_realizacji=$id_realizacji_stats");  
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania                  
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
                        echo "<tr id='$r[0]'>"; 
                        echo "<td>" . $index . "</td>";
                        echo "<td>" . $r[0] . "</td>";
                        echo "<td>" . $r[1] . "</td>";
                        echo "<td>" . $r[2] . "</td>";
                        echo "<td>" . $r[3] . "</td>";
                        echo "<td>" . $r[4] . "</td>";     
                                 
                          
                        echo "</tr>"; 
                    } 
                    echo "</table>"; 
                                
                    
                    // wyłapanie wyjątku z błędem zapytania
                   }
                   $polaczenie->close();
            }catch(Exception $e)
                   {
                      
                   }     
     

?>
</div> 
<div style="margin:50px;" class="tabela">
<label>Wykorzystywane materiały:</label>
<?php  
      
  
       require_once "connect.php";// pobranie danych potrzebnych do połączenia z bazą
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
                    $rezultat=$polaczenie->query("SELECT DISTINCT  e_materialy.rodzaj,e_materialy.nazwa,e_materialy.dziedzina,e_materialy.rodzaj_certyfikatu,e_materialy.data_utworzenia,e_materialy.data_modyfikacji,e_materialy.nr_wersji,e_materialy.opis from realizacja,realizacja_prowadzacy,prowadzacy,realizacja_e_materialy,e_materialy where realizacja.id_realizacji=realizacja_prowadzacy.id_realizacji and prowadzacy.id_prowadzacego=realizacja_prowadzacy.id_prowadzacego and realizacja.id_realizacji=realizacja_e_materialy.id_realizacji and e_materialy.id_e_materialu=realizacja_e_materialy.id_e_materialu and prowadzacy.id_prowadzacego=$id_prowadzacego_stats and realizacja.id_realizacji=$id_realizacji_stats");    
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania                  
                    echo "<table class='table table-sm'>"; 
                    echo "<tr>";
                    echo "<th>Lp.</th>";
                    echo "<th>Nazwa</th>";
                    echo "<th>Rodzaj</th>";
                    echo "<th>Dziedzina</th>";
                    echo "<th>Certyfika</th>";
                    echo "<th>Data utowrzenia</th>";  
                    echo "<th>Data modyfikacji</th>"; 
                    echo "<th>Wersja</th>";   
                    echo "<th>Opis</th>";                      
                    echo "</tr>";                    
                    $index=0;
                    while($r = mysqli_fetch_array($rezultat)) { 
                        $index++;
                        echo "<tr>"; 
                        echo "<td>".$index."</td>"; 
                        echo "<td>".$r[0]."</td>"; 
                        echo "<td>".$r[1]."</td>"; 
                        echo "<td>".$r[2]."</td>"; 
                        echo "<td>".$r[3]."</td>";      
                        echo "<td>".$r[4]."</td>";    
                        echo "<td>".$r[5]."</td>"; 
                        echo "<td>".$r[6]."</td>";      
                        echo "<td>".$r[7]."</td>";                       
                          
                        echo "</tr>"; 
                    } 
                    echo "</table>"; 
                                
                    
                    // wyłapanie wyjątku z błędem zapytania
                   }
                   $polaczenie->close();
            }catch(Exception $e)
                   {
                      
                   }     
     

?>

</div>
<div class="row">
<div class="col-sm-4">
<div style="margin:50px;" class="tabela">
<label>W ramach jakiego kierunku:</label>
<?php  

       require_once "connect.php";// pobranie danych potrzebnych do połączenia z bazą
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
                    $rezultat=$polaczenie->query("SELECT DISTINCT  kierunek.nazwa_kierunku, wydzial.nazwa_wydzialu from wydzial, kierunek, realizacja_kierunek, realizacja,realizacja_prowadzacy,prowadzacy where realizacja.id_realizacji=realizacja_prowadzacy.id_realizacji and prowadzacy.id_prowadzacego=realizacja_prowadzacy.id_prowadzacego and realizacja.id_realizacji=realizacja_kierunek.id_realizacji and kierunek.id_kierunku=realizacja_kierunek.id_kierunku and wydzial.id_wydzialu=kierunek.id_wydzialu and prowadzacy.id_prowadzacego=$id_prowadzacego_stats and realizacja.id_realizacji=$id_realizacji_stats");    
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania                  
                    echo "<table class='table table-sm'>"; 
                    echo "<tr>";
                    echo "<th>Lp.</th>";
                    echo "<th>Nazwa kierunku</th>";
                    echo "<th>Nazwa wydziału</th>";
                                        
                    echo "</tr>";                    
                    $index=0;
                    while($r = mysqli_fetch_array($rezultat)) { 
                        $index++;
                        echo "<tr id='$r[0]'>"; 
                        echo "<td>".$index."</td>"; 
                        echo "<td>".$r[0]."</td>"; 
                        echo "<td>".$r[1]."</td>";               
                          
                        echo "</tr>"; 
                    } 
                    echo "</table>"; 
                                
                    
                    // wyłapanie wyjątku z błędem zapytania
                   }
                   $polaczenie->close();
            }catch(Exception $e)
                   {
                      
                   }     
     

?>
</div>
</div>
<div class="col-sm-4">
<div style="margin:50px;" class="tabela">
<label>W sposób realizacji zajęć:</label>
<?php  

       require_once "connect.php";// pobranie danych potrzebnych do połączenia z bazą
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
                    $rezultat=$polaczenie->query("SELECT DISTINCT  rodzaj_zajec.nazwa_zajec, rodzaj_zajec.liczba_godzin from rodzaj_zajec_realizacja,rodzaj_zajec, realizacja_kierunek, realizacja,realizacja_prowadzacy,prowadzacy where realizacja.id_realizacji=realizacja_prowadzacy.id_realizacji and prowadzacy.id_prowadzacego=realizacja_prowadzacy.id_prowadzacego and realizacja.id_realizacji=rodzaj_zajec_realizacja.id_realizacji and rodzaj_zajec_realizacja.id_rodzaj_zajec=rodzaj_zajec.id_rodzaj_zajec and prowadzacy.id_prowadzacego=$id_prowadzacego_stats and realizacja.id_realizacji=$id_realizacji_stats");    
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania                  
                    echo "<table class='table table-sm'>"; 
                    echo "<tr>";
                    echo "<th>Lp.</th>";
                    echo "<th>Rodzaj zajęć</th>";
                    echo "<th>Liczba godzin</th>";
                                        
                    echo "</tr>";                    
                    $index=0;
                    while($r = mysqli_fetch_array($rezultat)) { 
                        $index++;
                        echo "<tr id='$r[0]'>"; 
                        echo "<td>".$index."</td>"; 
                        echo "<td>".$r[0]."</td>"; 
                        echo "<td>".$r[1]."</td>";               
                          
                        echo "</tr>"; 
                    } 
                    echo "</table>"; 
                                
                    
                    // wyłapanie wyjątku z błędem zapytania
                   }
                   $polaczenie->close();
            }catch(Exception $e)
                   {
                      
                   }     
     

?>
</div>
</div>

<div class="col-sm-4">
<div style="margin:50px;" class="tabela">
<label>Wykorzystywana platforma:</label>
<?php  

       require_once "connect.php";// pobranie danych potrzebnych do połączenia z bazą
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
                    $rezultat=$polaczenie->query("SELECT DISTINCT  platforma.nazwa_platformy from platforma,realizacja_platforma, realizacja,realizacja_prowadzacy,prowadzacy where realizacja.id_realizacji=realizacja_prowadzacy.id_realizacji and prowadzacy.id_prowadzacego=realizacja_prowadzacy.id_prowadzacego and realizacja.id_realizacji=realizacja_platforma.id_realizacji and platforma.id_platformy=realizacja_platforma.id_platformy and prowadzacy.id_prowadzacego=$id_prowadzacego_stats and realizacja.id_realizacji=$id_realizacji_stats");   
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania                  
                    echo "<table class='table table-sm'>"; 
                    echo "<tr>";
                    echo "<th>Lp.</th>";
                    echo "<th>Nazwa platformy</th>";                                               
                    echo "</tr>";                    
                    $index=0;
                    while($r = mysqli_fetch_array($rezultat)) { 
                        $index++;
                        echo "<tr id='$r[0]'>"; 
                        echo "<td>".$index."</td>"; 
                        echo "<td>".$r[0]."</td>";                                
                        echo "</tr>"; 
                    } 
                    echo "</table>"; 
                                
                    
                    // wyłapanie wyjątku z błędem zapytania
                   }
                   $polaczenie->close();
            }catch(Exception $e)
                   {
                      
                   }     
     

?>
</div>

</div>


</div>
</div>    
<a href="http://www.htm2pdf.co.uk">Save this page as PDF</a>                                                   
</body>
</html>

<script>

    $(document).ready(function () {   
        $('.button_szczegoly').click(function () {                     
                        $.ajax({
                            type: "POST",
                            url: "stats_szczegoly_.php",
                            data: $(".form_szczegoly").serialize(),
                            success: function (data) {
                                alert(data); 
                               // location.reload();
                               $("#osoba").load("add_osoba.php");
                           // window.location.reload(); 
                            }


                        });
                    });
                });
    

</script>


