<?php
session_start();
$imie_prowadzacego = $_POST['imie_up']; // pobranie danych z formularza
$nazwisko_prowadzacego = $_POST['nazwisko_up'];
$jednosta_organizacyjna = $_POST['jednostka_up'];
$stanowisko = $_POST['stanowisko_up'];
$email = $_POST['mail_up'];
$strona_www = $_POST['strona_up'];
$id=$_POST['id'];
$wszystko_ok = true;

$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

if (empty($imie_prowadzacego))
{
	$wszystko_ok = false; //sprawdzenie czy pole jest puste
	echo "Pole imie nie może być puste";
}
elseif (!(preg_match('/^[a-zA-ZążśźęćńółĄŻŚŹĘĆŃÓŁ\s-]+$/u', $imie_prowadzacego)))
{
	$wszystko_ok = false;
	echo"Pole imie zawiera niedozwolone znaki";
}

elseif (empty($nazwisko_prowadzacego))
{
	$wszystko_ok = false; //sprawdzenie czy pole
	echo"Pole nazwisko nie może być puste";
}
elseif (!(preg_match('/^[a-zA-ZążśźęćńółĄŻŚŹĘĆŃÓŁ\s-]+$/u', $nazwisko_prowadzacego)))
{
	$wszystko_ok = false;
	echo"Pole nazwisko zawiera niedozwolone znaki";
}

elseif (empty($jednosta_organizacyjna))
{
	$wszystko_ok = false; //sprawdzenie czy
	echo"Pole jednostka organizacyjna nie może być puste";
}

elseif (empty($stanowisko))
{
	$wszystko_ok = false; //sprawdzenie czy pole jest puste
	echo"Pole stanowisko nie może być puste";
}

// Sprawdź poprawność adresu email

elseif (empty($email))
{
	$wszystko_ok = false; //sprawdzenie czy pole jest puste
	echo"Pole Mail nie może być puste";
}elseif((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
{
    $wszystko_ok=false;
    echo"Pole E-mail zawiera niedozwolone znaki";
}
elseif ($strona_www=='Brak strony WWW')
{
	 //sprawdzenie czy pole jest puste
	$strona_www="Brak strony WWW";
}elseif(!(preg_match('_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iu', $strona_www)))
{
	$wszystko_ok = false;
	echo"Pole strona www zawiera niedozwolone znaki";
}
require_once "connect.php";

 // pobranie danych potrzebnych do połączenia z bazą

mysqli_report(MYSQLI_REPORT_STRICT); // wyłaczenie ostrzeżenie generowanych przez system php, natomiast wyświetlony zostaje wyjatek
try
{
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name); // połaczenie sie z bazą danych
	$polaczenie->query('SET NAMES utf8'); //kodowanie obsługa polski znaków
	$polaczenie->query('SET CHARACTER_SET utf8_general_ci');
	if ($polaczenie->connect_errno != 0) //
	{
		throw new Exception(mysqli_connect_errno()); // wyrzucenie wyjatku, brak połaczenie z baza
	}
	else
	{

		// sprawdzenie czy takie same dane istnieja w bazie danych

		// $rezultat = $polaczenie->query("SELECT imie_prowadzacego,nazwisko_prowadzacego,adres_email FROM prowadzacy WHERE imie_prowadzacego='$imie_prowadzacego' and nazwisko_prowadzacego='$nazwisko_prowadzacego'and adres_email='$email'");
		// if (!$rezultat) throw new Exception($polaczenie->erro); // wyłapanie wyjątku z błędem zapytania
		// $ilosc_rows = $rezultat->num_rows; // zwrócenie ilości wystąpien w bazie
		// if ($ilosc_rows > 0)
		// {
		// 	$wszystko_ok = false; //ustawienie flagi
		// 	echo "  Ta pozycja już istniej w bazie  ";
		// }

		if ($wszystko_ok == true)
		{

			// dodajemy do bazy jeśli wszystkie dane sa poprawne

			if ($polaczenie->query("UPDATE `prowadzacy` SET `imie_prowadzacego`='$imie_prowadzacego',`nazwisko_prowadzacego`='$nazwisko_prowadzacego',`jednostka_organizacyjna`='$jednosta_organizacyjna',`stanowisko`='$stanowisko',`adres_email`='$email',`adres_www`='$strona_www' WHERE  id_prowadzacego='$id'"))
			{
			    echo 'Pomyślnie zakutalizowano';
			}
			else
			{
				throw new Exception($polaczenie->error);
			}
		} 

		$polaczenie->close();
	}
}

catch(Exception $e)
{

	// echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
	// echo "informacja".$e;

}

?>
