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
<label>Osoba prowadząca:</label>
<?php  
      
      $id=$_GET['id'];   
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
                    $rezultat=$polaczenie->query("SELECT * from prowadzacy where id_prowadzacego=$id");  
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania                  
                    echo "<table class='table table-sm'>"; 
                    echo "<tr>";
                        echo "<th>Lp.</th>";
                        echo "<th>Imie </th>";
                        echo "<th>Nazwisko </th>";
                        echo "<th>Stanowisko</th>";
                        echo "<th>Jednostka organizacyjna</th>";
                        echo "<th>Adres E-mail</th>";
                        echo "<th>Strona WWW</th>";                       
                    echo "</tr>";                    
                    $index=0;
                    while($r = mysqli_fetch_array($rezultat)) { 
                        $index++;
                        echo "<tr id='$r[0]'>"; 
                            echo "<td>".$index."</td>"; 
                            echo"<td data-target='imie_up'>".$r[1]."</td>"; 
                            echo"<td data-target='nazwisko_up'>".$r[2]."</td>"; 
                            echo"<td data-target='stanowisko_up'>".$r[3]."</td>"; 
                            echo"<td data-target='jednostka_up'>".$r[4]."</td>"; 
                            echo"<td data-target='mail_up'>".$r[5]."</td>"; 
                            echo"<td data-target='strona_up'>".$r[6]."</td>";                          
                          
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

<div style="margin:50px;" class="tabela">
<label>Projekty które prowadzi dana osoba:</label>
<?php  
      
      $id=$_GET['id'];   
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
                    $rezultat=$polaczenie->query("SELECT DISTINCT realizacja.nazwa_projektu,realizacja.liczba_godzin, realizacja.start_kursu, realizacja.koniec_kursu, realizacja.opis, realizacja.id_realizacji from realizacja,realizacja_prowadzacy,prowadzacy where realizacja.id_realizacji=realizacja_prowadzacy.id_realizacji and prowadzacy.id_prowadzacego=realizacja_prowadzacy.id_prowadzacego and prowadzacy.id_prowadzacego=$id");  
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania 
                    $ilosc_rows=$rezultat->num_rows; 
                    if($ilosc_rows==0)
                    {
                        echo"Brak prowadzonych projektów";
                    }
                    else{                 
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
                        echo "<td>
                        <form method='POST' action='stats_osoba_szczegoly.php'>
                        <input type='hidden' name='id_prowadzacego_stats' value='$id'>
                        <input type='hidden' name='id_realizacji_stats' value='$r[5]'>
                        <button type='submit' class='button_szczegoly' value='$r[5]'>Szczegóły</button>                        
                        </form>
                        </td>";                      
                          
                        echo "</tr>"; 
                    } 
                    echo "</table>"; 
                                
                    
                    // wyłapanie wyjątku z błędem zapytania
                   } 
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
      
      $id=$_GET['id'];   
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
                    $rezultat=$polaczenie->query("SELECT DISTINCT  e_materialy.rodzaj,e_materialy.nazwa,e_materialy.dziedzina,e_materialy.rodzaj_certyfikatu,e_materialy.data_utworzenia,e_materialy.data_modyfikacji,e_materialy.nr_wersji,e_materialy.opis from realizacja,realizacja_prowadzacy,prowadzacy,realizacja_e_materialy,e_materialy where realizacja.id_realizacji=realizacja_prowadzacy.id_realizacji and prowadzacy.id_prowadzacego=realizacja_prowadzacy.id_prowadzacego and realizacja.id_realizacji=realizacja_e_materialy.id_realizacji and e_materialy.id_e_materialu=realizacja_e_materialy.id_e_materialu and prowadzacy.id_prowadzacego=$id");  
                    if(!$rezultat)throw new Exception($polaczenie->erro);
                    $ilosc_rows=$rezultat->num_rows; 
                    if($ilosc_rows==0)
                    {
                        echo"Brak informacji";
                    }
                    else{  // wyłapanie wyjątku z błędem zapytania                  
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
                        echo "<tr id='$r[0]'>"; 
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
$id=$_GET['id'];   
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
                    $rezultat=$polaczenie->query("SELECT DISTINCT  kierunek.nazwa_kierunku, wydzial.nazwa_wydzialu from wydzial, kierunek, realizacja_kierunek, realizacja,realizacja_prowadzacy,prowadzacy where realizacja.id_realizacji=realizacja_prowadzacy.id_realizacji and prowadzacy.id_prowadzacego=realizacja_prowadzacy.id_prowadzacego and realizacja.id_realizacji=realizacja_kierunek.id_realizacji and kierunek.id_kierunku=realizacja_kierunek.id_kierunku and wydzial.id_wydzialu=kierunek.id_wydzialu and prowadzacy.id_prowadzacego=$id");  
                    if(!$rezultat)throw new Exception($polaczenie->erro);
                    if($ilosc_rows==0)
                    {
                        echo"Brak informacji";
                    }
                    else{// wyłapanie wyjątku z błędem zapytania                  
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
$id=$_GET['id'];   
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
                    $rezultat=$polaczenie->query("SELECT DISTINCT  rodzaj_zajec.nazwa_zajec, rodzaj_zajec.liczba_godzin from rodzaj_zajec_realizacja,rodzaj_zajec, realizacja_kierunek, realizacja,realizacja_prowadzacy,prowadzacy where realizacja.id_realizacji=realizacja_prowadzacy.id_realizacji and prowadzacy.id_prowadzacego=realizacja_prowadzacy.id_prowadzacego and realizacja.id_realizacji=rodzaj_zajec_realizacja.id_realizacji and rodzaj_zajec_realizacja.id_rodzaj_zajec=rodzaj_zajec.id_rodzaj_zajec and prowadzacy.id_prowadzacego=$id");  
                    if(!$rezultat)throw new Exception($polaczenie->erro);
                    if($ilosc_rows==0)
                    {
                        echo"Brak informacji";
                    }
                    else{// wyłapanie wyjątku z błędem zapytania                  
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
                                
                }
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
<label>Wykorzystywane platformy:</label>
<?php  
$id=$_GET['id'];   
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
                    $rezultat=$polaczenie->query("SELECT DISTINCT  platforma.nazwa_platformy from platforma,realizacja_platforma, realizacja,realizacja_prowadzacy,prowadzacy where realizacja.id_realizacji=realizacja_prowadzacy.id_realizacji and prowadzacy.id_prowadzacego=realizacja_prowadzacy.id_prowadzacego and realizacja.id_realizacji=realizacja_platforma.id_realizacji and platforma.id_platformy=realizacja_platforma.id_platformy and prowadzacy.id_prowadzacego=$id");  
                    if(!$rezultat)throw new Exception($polaczenie->erro);
                    if($ilosc_rows==0)
                    {
                        echo"Brak informacji";
                    }
                    else{// wyłapanie wyjątku z błędem zapytania                  
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
                }            
                    
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

<div style="margin:50px;" class="tabela">
<label>Utworzone E-materiały:</label>
<?php  
$id=$_GET['id'];   
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
                    $rezultat=$polaczenie->query("SELECT e_materialy.rodzaj,e_materialy.nazwa,e_materialy.dziedzina,e_materialy.rodzaj_certyfikatu,e_materialy.data_utworzenia,e_materialy.data_modyfikacji,e_materialy.nr_wersji,e_materialy.opis from e_materialy,e_materialy_prowadzacy,prowadzacy where e_materialy.id_e_materialu=e_materialy_prowadzacy.id_e_materialu and prowadzacy.id_prowadzacego=e_materialy_prowadzacy.id_prowadzacego and prowadzacy.id_prowadzacego=$id");  
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania     
                    $ilosc_rows=$rezultat->num_rows; 
                    if($ilosc_rows==0){
                        $wszystko_ok=false; //ustawienie flagi
                        echo "Brak utworzonych materiałów "; // jezeli istaniej w bazie wyświetl na ekranie
                    }else{          
                    echo "<table class='table table-sm'>"; 
                    echo "<tr>";
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
                }          
                    
                    // wyłapanie wyjątku z błędem zapytania
                   }
                   $polaczenie->close();
            }catch(Exception $e)
                   {
                      
                   }     
     

?>
</div>
</div>  
<a href="http://www.htm2pdf.co.uk">Save this page as PDF</a>                                                 
</body>
</html>

<script>



</script>


