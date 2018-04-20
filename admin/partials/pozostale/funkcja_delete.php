<?php
session_start();
 
    if (isset($_POST['action_del_prowadzacy'])) {
        $id_dele=$_POST['action_del_prowadzacy'];   
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
                        $wynik = $polaczenie->query("Delete from realizacja_prowadzacy where id_real_prow='$id_dele'");
                        if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                    }
                    $polaczenie->close();
             }catch(Exception $e)
                    {
                        echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
                        echo "informacja".$e;
                    }     
        } 
        if (isset($_POST['action_del_rodzaj_zajec'])) {
            $id_dele=$_POST['action_del_rodzaj_zajec'];   
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
                        {    $ilosc_godzin_zajecia=$polaczenie->query("select a.liczba_godzin FROM rodzaj_zajec a, rodzaj_zajec_realizacja b where a.id_rodzaj_zajec=b.id_rodzaj_zajec and                           b.id_rodzaj_real='$id_dele'");
                            $ilosc_godzin_realizacja=$polaczenie->query("select a.liczba_godzin FROM realizacja a, rodzaj_zajec_realizacja b where a.id_realizacji=b.id_realizacji and b.id_rodzaj_real='$id_dele'");
                            $index_tabeli=$polaczenie->query("select a.id_realizacji FROM realizacja a, rodzaj_zajec_realizacja b where a.id_realizacji=b.id_realizacji and b.id_rodzaj_real='$id_dele'");
                            while($a= mysqli_fetch_array($ilosc_godzin_realizacja)){
                                $liczba_zajecia=$a[0];
                            }
                            while($b= mysqli_fetch_array($ilosc_godzin_zajecia)){
                                $liczba_realizacja=$b[0];
                            }    
                            while($c= mysqli_fetch_array($index_tabeli)){
                                $index=$c[0];
                            }  
                            $koncowa_ilosc_godzin=$liczba_zajecia-$liczba_realizacja;            
                            $wynik = $polaczenie->query("Delete from rodzaj_zajec_realizacja where id_rodzaj_real='$id_dele'");
                            $polaczenie->query("UPDATE realizacja set liczba_godzin='$koncowa_ilosc_godzin' where id_realizacji='$index'");
                            if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                        } $polaczenie->close();
                 }catch(Exception $e)
                        {
                            echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
                            echo "informacja".$e;
                        }     
            } 
            if (isset($_POST['action_del_rodzaj_platformy'])) {
                $id_dele=$_POST['action_del_rodzaj_platformy'];   
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
                                $wynik = $polaczenie->query("Delete from realizacja_platforma where id_real_plat='$id_dele'");
                                echo "usunieto z bazy";
                               // wyłapanie wyjątku z błędem zapytania
                            } $polaczenie->close();
                     }catch(Exception $e)
                            {
                                echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
                                echo "informacja".$e;
                            }     
                } 
                if (isset($_POST['action_del_kierunek'])) {
                    $id_dele=$_POST['action_del_kierunek'];   
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
                                    $wynik = $polaczenie->query("Delete from realizacja_kierunek where id_real_kieru='$id_dele'");
                                    echo "usunieto z bazy";
                                   // wyłapanie wyjątku z błędem zapytania
                                } $polaczenie->close();
                         }catch(Exception $e)
                                {
                                    echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
                                    echo "informacja".$e;
                                }     
                    } 
                    if (isset($_POST['delete_realizacja'])) {
                        $id_dele=$_POST['delete_realizacja'];   
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
                                        $wynik = $polaczenie->query("Delete from realizacja where id_realizacji='$id_dele'");
                                        echo "usunieto z bazy";
                                       // wyłapanie wyjątku z błędem zapytania
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
                                            $wynik = $polaczenie->query("Delete from e_materialy where id_e_materialu='$id_dele'");
                                            echo "usunieto z bazy";
                                           // wyłapanie wyjątku z błędem zapytania
                                        } $polaczenie->close();
                                 }catch(Exception $e)
                                        {
                                            echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
                                            echo "informacja".$e;
                                        }     
                            } 
                            if (isset($_POST['delete_prowadzacy_material'])) {
                                $id_dele=$_POST['delete_prowadzacy_material'];   
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
                                                $wynik = $polaczenie->query("Delete from e_materialy_prowadzacy where id_prowadzacego='$id_dele'");
                                                echo "usunieto z bazy";
                                               // wyłapanie wyjątku z błędem zapytania
                                            } $polaczenie->close();
                                     }catch(Exception $e)
                                            {
                                                echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
                                                echo "informacja".$e;
                                            }     
                                } 
                                if (isset($_POST['delete_realizacja_material'])) {
                                    $id_dele=$_POST['delete_realizacja_material'];   
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
                                                    $wynik = $polaczenie->query("Delete from realizacja_e_materialy where id_e_mate_real='$id_dele'");
                                                    echo "usunieto z bazy";
                                                   // wyłapanie wyjątku z błędem zapytania
                                                } $polaczenie->close();
                                         }catch(Exception $e)
                                                {
                                                    echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
                                                    echo "informacja".$e;
                                                }     
                                    } 
                                   
?>