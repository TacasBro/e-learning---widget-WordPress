<?php
session_start();       
        //udana walidacja flaga
        $wszystko_ok=true;
        //sprawdzamy informacje o wydziale
        $nazwa_e_materialu=$_POST['nazw_e_materialu'];
         // pobranie danych z formularza
        if((empty($nazwa_e_materialu))){
            $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
       
        }
        $sprawdz = '/^[a-zA-ZążśźęćńółĄŻŚŹĘĆŃÓŁ\s]+$/u';;
        
        // ereg() sprawdza dopasowanie wzorca do ciągu
        // zwraca true jeżeli tekst pasuje do wyrażenia
        if(!preg_match($sprawdz, $nazwa_e_materialu)) 
        {
            $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
         
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
                    $rezultat=$polaczenie->query("SELECT rodzaj_e_materialu FROM rodzaj_e_materialu WHERE rodzaj_e_materialu='$nazwa_e_materialu'");
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania

                    $ilosc_rows=$rezultat->num_rows;// zwrócenie ilości wystąpien w bazie
                    if($ilosc_rows>0){
                        $wszystko_ok=false; //ustawienie flagi
                        echo "  Nazwa tego materiału istniej już w bazie  " ; // jezeli istaniej w bazie wyświetl na ekranie
                    }
                

                
                }
                if($wszystko_ok==true){
                    //dodajemy do bazy jeśli wszystkie dane sa poprawne 
                if($polaczenie->query("INSERT INTO rodzaj_e_materialu VALUES (NULL,'$nazwa_e_materialu')"))
                        {
                            
                            echo"Dodano do bazy  ";
                            exit();
                        }
                    else{
                        throw new Exception($polaczenie->erro);
                        }
                } else{
                    echo " Przepraszamy nie poprawne dane !!! ";
                }
                $polaczenie->close();
        }
        catch(Exception $e){
            echo "<spna style='color:red;'>Błąd serwer przepraszamy</span>";
        }      
        
    





?>