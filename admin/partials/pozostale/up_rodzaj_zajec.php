<?php
session_start();       
        //udana walidacja flaga
        $wszystko_ok=true;
        //sprawdzamy informacje o wydziale
        $nazwa_zajec=$_POST['nazwa_zajec_up'];
        $liczba_godzin=$_POST['liczba_up'];
        $id = $_POST['id'];
        $sprawdz = '/^[a-zA-ZążśźęćńółĄŻŚŹĘĆŃÓŁ\s-]+$/u';
        // pobranie danych z formularza
       if((empty($nazwa_zajec))){
           $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
           echo "Pole rodzaj zajęc nie może być puste ";
       }elseif($liczba_godzin<0){
           $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
           echo " Liczba godzin musi być dodatnia  ";
       }elseif((empty($liczba_godzin))){
           $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
           echo " Pole z liczbą godzin nie może być puste ";
       }     
       
       // ereg() sprawdza dopasowanie wzorca do ciągu
       // zwraca true jeżeli tekst pasuje do wyrażenia
       elseif(!preg_match($sprawdz, $nazwa_zajec)) 
       {
           $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
           echo "Pole nazwa zajęć zawiera niedozwolone znaki";
       }
       
        
          
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
                    //sprawdzenie czy takie same dane istnieja w bazie danych
                    $rezultat=$polaczenie->query("SELECT nazwa_zajec, liczba_godzin FROM rodzaj_zajec WHERE nazwa_zajec='$nazwa_zajec' and liczba_godzin='$liczba_godzin'");
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania

                    $ilosc_rows=$rezultat->num_rows;// zwrócenie ilości wystąpien w bazie
                    if($ilosc_rows>0){
                        $wszystko_ok=false; //ustawienie flagi
                        echo "Ta pozycja istnieje  już w bazie  "; // jezeli istaniej w bazie wyświetl na ekranie
                    }
                

                
                }
                if($wszystko_ok==true){
                    //dodajemy do bazy jeśli wszystkie dane sa poprawne 
                if($polaczenie->query("UPDATE rodzaj_zajec SET nazwa_zajec='$nazwa_zajec' ,liczba_godzin='$liczba_godzin'WHERE id_rodzaj_zajec='$id'"))
                        {
                            
                            echo 'Pomyślnie zakutalizowano';
                            exit();
                        }
                    else{
                        throw new Exception($polaczenie->erro);
                        }
                } 
                $polaczenie->close();
        }
        catch(Exception $e){
            echo "<spna style='color:red;'>Błąd serwer przepraszamy</span>";
        }      
        
    





?>