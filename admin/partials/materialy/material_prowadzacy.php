                    
   <?php   
   session_start();
        $id_e_materialu=$_POST['id_e_materialu'];
        $id_prowadzacego=$_POST['select'];
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
                $rezultat=$polaczenie->query("SELECT id_e_materialu, id_prowadzacego FROM e_materialy_prowadzacy WHERE id_e_materialu='$id_e_materialu' and id_prowadzacego='$id_prowadzacego'");
                if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania

                $ilosc_rows=$rezultat->num_rows;// zwrócenie ilości wystąpien w bazie
                if($ilosc_rows>0){
                    $flaga=false; //ustawienie flagi
                    echo "Ta pozycja już istniej w bazie"; 
                  
                }
            }
                if($flaga==true){
                if($polaczenie->query("INSERT INTO e_materialy_prowadzacy VALUES (null,'$id_e_materialu','$id_prowadzacego')"))
                        {
                            echo "dodano do tabeli";
                        }
                     
            }
            $polaczenie->close();
        }  catch(Exception $e){
                    echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
                    echo "informacja".$e;
                }
                
    

?>

 
