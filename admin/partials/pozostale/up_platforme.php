<?php
    
        //udana walidacja flaga
        $wszystko_ok=true;
        //sprawdzamy informacje o wydziale
        $nazwa_platformy=$_POST['platforma_up'];
        $id=$_POST['id'];
         // pobranie danych z formularza
         $sprawdz = '/^[a-zA-ZążśźęćńółĄŻŚŹĘĆŃÓŁ\s]+$/u';
         if((empty($nazwa_platformy))){
             $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
             echo"Pole nazwa platformy nie może być puste";
         }
        
         
         // ereg() sprawdza dopasowanie wzorca do ciągu
         // zwraca true jeżeli tekst pasuje do wyrażenia
         elseif(!preg_match($sprawdz, $nazwa_platformy)) 
         {
             $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
             echo"Pole nazwa platformy zawiera niedozwolone znaki";
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
                    $rezultat=$polaczenie->query("SELECT nazwa_platformy FROM platforma WHERE nazwa_platformy='$nazwa_platformy'");
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania

                    $ilosc_rows=$rezultat->num_rows;// zwrócenie ilości wystąpien w bazie
                    if($ilosc_rows>0){
                        $wszystko_ok=false; //ustawienie flagi
                        echo "Nazwa tej Platformy istniej już w bazie  "; // jezeli istaniej w bazie wyświetl na ekranie
                    }
                

                
                }
                if($wszystko_ok==true){
                    //dodajemy do bazy jeśli wszystkie dane sa poprawne 
                if($polaczenie->query("UPDATE platforma SET nazwa_platformy='$nazwa_platformy' WHERE id_platformy='$id'"))
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
            echo 'Błąd serwer przepraszamy';
        }      
        
    





?>