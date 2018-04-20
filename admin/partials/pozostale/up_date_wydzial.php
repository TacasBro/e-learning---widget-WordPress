<?php
 $wydzial = $_POST['wydzial_up'];              
 $id = $_POST['id'];
 $wszystko_ok=true;  
 $sprawdz = '/^[a-zA-ZążśźęćńółĄŻŚŹĘĆŃÓŁ\s-]+$/u';
 // pobranie danych z formularza
if((empty($wydzial))){
    $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
 echo"Pole nazwa wydziału nie może być pusta";
}


// ereg() sprawdza dopasowanie wzorca do ciągu
// zwraca true jeżeli tekst pasuje do wyrażenia
elseif(!preg_match($sprawdz, $wydzial)) 
{
    $wszystko_ok=false;                         //sprawdzenie czy pole jest puste
  echo"Nazwa wydziału zawiera niedozwolone znaki";
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
            $rezultat=$polaczenie->query("SELECT nazwa_wydzialu FROM wydzial WHERE nazwa_wydzialu='$wydzial'");
            if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania

            $ilosc_rows=$rezultat->num_rows;// zwrócenie ilości wystąpien w bazie
            if($ilosc_rows>0){
                $wszystko_ok=false; //ustawienie flagi
                echo "Nazwa tego wydziału istniej już w bazie  "; // jezeli istaniej w bazie wyświetl na ekranie
            }
               
        }               
                
                //  query to update data {}
                if($wszystko_ok==true) {
               if($polaczenie->query( "UPDATE wydzial SET nazwa_wydzialu='$wydzial' WHERE id_wydzialu='$id'"))
               {
                
                echo 'Pomyślnie zakutalizowano';
                exit();
            }
            else{
                throw new Exception($polaczenie->erro);
                }
               
            }
                       
        $polaczenie->close();               
}  catch(Exception $e){
    echo 'Błąd serwer przepraszamy';
echo "informacja".$e;
}   
?>