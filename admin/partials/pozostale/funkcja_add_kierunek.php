<?php
session_start();       
        //udana walidacja flaga
        $wszystko_ok=true;
        //sprawdzamy informacje o wydziale
        $nazwa_kierunku=$_POST['nazwa_kierunku'];
        $wydzial=$_POST['wydzial'];
        $sprawdz = '/^[a-zA-ZążśźęćńółĄŻŚŹĘĆŃÓŁ\s-]+$/u';
         // pobranie danych z formularza
        if((empty($nazwa_kierunku))){
            $wszystko_ok=false;    
            echo "Pole nazwa kierunku nie może być puste";                     //sprawdzenie czy pole jest puste
         
        }elseif(!preg_match($sprawdz, $nazwa_kierunku)) 
        {
            $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
           echo"Nazwa kierunku zawiera niedozwolone znaki";
        }
        
      
        
        // ereg() sprawdza dopasowanie wzorca do ciągu
        // zwraca true jeżeli tekst pasuje do wyrażenia
        
        
          
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
                    $rezultat=$polaczenie->query("SELECT nazwa_kierunku, id_wydzialu FROM kierunek WHERE nazwa_kierunku='$nazwa_kierunku' and id_wydzialu='$wydzial'");
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania

                    $ilosc_rows=$rezultat->num_rows;// zwrócenie ilości wystąpien w bazie
                    if($ilosc_rows>0){
                        $wszystko_ok=false; //ustawienie flagi
                        echo "  Ta pozycja istnieje  już w bazie  "; // jezeli istaniej w bazie wyświetl na ekranie
                    }
                

                
                }
                if($wszystko_ok==true){
                    //dodajemy do bazy jeśli wszystkie dane sa poprawne 
                if($polaczenie->query("INSERT INTO kierunek VALUES (NULL,'$wydzial','$nazwa_kierunku')"))
                        {
                            
                            echo" Dodano do bazy ";
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