<?php
session_start();
if (isset($_POST['delete_osoba'])) {
    $id_dele=$_POST['delete_osoba'];   
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
                    $wynik = $polaczenie->query("Delete from prowadzacy where id_prowadzacego='$id_dele'");
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                } $polaczenie->close();
         }catch(Exception $e)
                {
                    echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
                    echo "informacja".$e;
                }     
    } 
    if (isset($_POST['delete_wydzial'])) {
        $id_dele=$_POST['delete_wydzial'];   
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
                        $wynik = $polaczenie->query("Delete from wydzial where id_wydzialu='$id_dele'");
                        if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                    } $polaczenie->close();
             }catch(Exception $e)
                    {
                        echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
                        echo "informacja".$e;
                    }     
        } 
        if (isset($_POST['delete_material'])) {
            $id_dele=$_POST['delete_material'];   
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
                            $wynik = $polaczenie->query("Delete from rodzaj_e_materialu where id_rodzaj_e_materialu='$id_dele'");
                            if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                        } $polaczenie->close();
                 }catch(Exception $e)
                        {
                            echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
                            echo "informacja".$e;
                        }     
            } 
            if (isset($_POST['delete_platforma'])) {
                $id_dele=$_POST['delete_platforma'];   
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
                                $wynik = $polaczenie->query("Delete from platforma where id_platformy='$id_dele'");
                                if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                            } $polaczenie->close();
                     }catch(Exception $e)
                            {
                                echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
                                echo "informacja".$e;
                            }     
                } 
                if (isset($_POST['delete_zajecia'])) {
                    $id_dele=$_POST['delete_zajecia'];   
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
                                    $wynik = $polaczenie->query("Delete from rodzaj_zajec where id_rodzaj_zajec='$id_dele'");
                                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                                } $polaczenie->close();
                         }catch(Exception $e)
                                {
                                    echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
                                    echo "informacja".$e;
                                }     
                    } 
                    if (isset($_POST['delete_kierunek'])) {
                        $id_dele=$_POST['delete_kierunek'];   
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
                                        $wynik = $polaczenie->query("Delete from kierunek where id_kierunku='$id_dele'");
                                        if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                                    } $polaczenie->close();
                             }catch(Exception $e)
                                    {
                                        echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
                                        echo "informacja".$e;
                                    }     
                        } 
    
?>