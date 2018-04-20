<?php
     
     require_once "connect.php";// pobranie danych potrzebnych do połączenia z bazą
     $wynik="";
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
                    $results_per_page =4;
                    $page = ''; 
                    $rezultat=$polaczenie->query("SELECT prowadzacy.imie_prowadzacego, prowadzacy.nazwisko_prowadzacego, e_materialy.nazwa, e_materialy.rodzaj, e_materialy.dziedzina, e_materialy.opis FROM e_materialy, prowadzacy, e_materialy_prowadzacy WHERE e_materialy.id_e_materialu=e_materialy_prowadzacy.id_e_materialu and e_materialy_prowadzacy.id_prowadzacego=prowadzacy.id_prowadzacego ");
                    $number_of_results = mysqli_num_rows($rezultat);
                    $number_of_pages = ceil($number_of_results/$results_per_page);
                   
                    if (!isset($_POST['page'])) {
                        $page = 1;
                      } else {
                        $page = $_POST['page'];
                      }
                      $this_page_first_result = ($page-1)*$results_per_page;
                 
                    $rezultat=$polaczenie->query("SELECT prowadzacy.imie_prowadzacego, prowadzacy.nazwisko_prowadzacego, e_materialy.nazwa, e_materialy.rodzaj, e_materialy.dziedzina, e_materialy.opis FROM e_materialy, prowadzacy, e_materialy_prowadzacy WHERE e_materialy.id_e_materialu=e_materialy_prowadzacy.id_e_materialu and e_materialy_prowadzacy.id_prowadzacego=prowadzacy.id_prowadzacego LIMIT $this_page_first_result,$results_per_page");         
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                    
                    $index=0;
                   $wynik.= "<div class='stronicowanie'>";
                    while($r = mysqli_fetch_array($rezultat)) {               
                        
                      $wynik.="<div class='material'>
                     <div class='autor'>    <label>Autor: </label>$r[0] $r[1]</div>
                     <div class='nazwa'>    <label>Nazwa: </label>$r[2]</div>
                     <div class='dziedzina'>    <label>Dziedzina: </label>$r[4]</div>
                     <div class='rodzaj'>    <label>Rodzaj: </label>$r[3]</div>
                 
                     <div class='opis'>    <label>Opis: </label>$r[5]</div>
                    
                     
                     </div>";

                    } 
                    $wynik.= "</div>";
                    echo  $wynik;  
                    }               
                    $polaczenie->close();               
        }  catch(Exception $e){
            echo 'Błąd serwer przepraszamy';
            echo "informacja".$e;
        }   
       
        

?>
