                    
   <?php   
   
        $id_realizacji=$_POST['id_realizacji'];
        $rodzaj_zajec=$_POST['rodzaj_zajec_select'];
        
        $flaga=true;     
    require_once "../connect.php";// pobranie danych potrzebnych do połączenia z bazą
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
                $rezultat=$polaczenie->query("SELECT * FROM rodzaj_zajec_realizacja WHERE 	id_rodzaj_zajec='$rodzaj_zajec' and id_realizacji='$id_realizacji'");
                $ilosc_godzin_zajecia=$polaczenie->query("SELECT liczba_godzin FROM rodzaj_zajec WHERE 	id_rodzaj_zajec='$rodzaj_zajec'");
                $ilosc_godzin_realizacja=$polaczenie->query("SELECT liczba_godzin FROM realizacja WHERE 	id_realizacji='$id_realizacji'");
                while($a= mysqli_fetch_array($ilosc_godzin_zajecia)){
                    $liczba_zajecia=$a[0];
                }
                while($b= mysqli_fetch_array($ilosc_godzin_realizacja)){
                    $liczba_realizacja=$b[0];
                }    
                $koncowa_ilosc_godzin=$liczba_zajecia+$liczba_realizacja;
                if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                
                $ilosc_rows=$rezultat->num_rows;// zwrócenie ilości wystąpien w bazie
                if($ilosc_rows>0){
                    $flaga=false; //ustawienie flagi
                    echo "Ta pozycja już istniej w bazie"; 
                  
                }
            }
                if($flaga==true){
                if($polaczenie->query("INSERT INTO rodzaj_zajec_realizacja VALUES (null,'$rodzaj_zajec','$id_realizacji')"))
                        {if($polaczenie->query("UPDATE realizacja set liczba_godzin='$koncowa_ilosc_godzin' where id_realizacji='$id_realizacji'"))
                            {
                               
                            }
                            echo "Dodano rodzaj zajęć do projektu";
                        }
                     
            }
            $polaczenie->close();
        }  catch(Exception $e){
                    echo "Błąd serwer przepraszamy";
             
                }
                
    

?>

 
