<?php

$id_last = $_GET['id'];

require_once "../connect.php";

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
		$rezultat = $polaczenie->query("SELECT * FROM realizacja where id_realizacji='$id_last'");
		if (!$rezultat) throw new Exception($polaczenie->erro); // wyłapanie wyjątku z błędem zapytania
	echo"<div id='container'>";
	echo "<div class='line'>";
		echo "<table class='table table-sm'>";
		echo "<tr>";
		echo "<th>Lp.</th>";
		echo "<th>Nazwa projektu</th>";
		echo "<th>Liczba godzin</th>";
		echo "<th>Start kursu</th>";
		echo "<th>Koniec kursu</th>";
		echo "<th>Opis</th>";
		echo "<th></th>";
		echo "</tr>";
		$index = 0;
		while ($r = mysqli_fetch_array($rezultat))
		{
			$index++;
			echo "<tr>";
			echo "<td>" . $index . "</td>";
			echo "<td>" . $r[1] . "</td>";
			echo "<td>" . $r[2] . "</td>";
			echo "<td>" . $r[3] . "</td>";
			echo "<td>" . $r[4] . "</td>";
			echo "<td>" . $r[5] . "</td>";
			echo "<td>
			
			</td>";   
			echo "</tr>";
		}
			
				echo "</table>";
				echo" <button  class='btn btn-secondary' id='wstecz'>Wróć do realizacji</button>";
				echo"</div>";
				echo "<div class='line'>";
				
				// tabele z prowadzacymi
				
				echo "<div class='form-row'>";
				
				echo " <div class='form-group col-md-6' >";
			
				echo"<div id='prowadzacy'>";
				echo "Dodaj prowadzącego:";
				$rezultat2 = $polaczenie->query("SELECT r.id_real_prow,w.imie_prowadzacego, w.nazwisko_prowadzacego FROM realizacja_prowadzacy r, prowadzacy w where r.id_prowadzacego=w.id_prowadzacego and r.id_realizacji='$id_last'");
				echo "<table class='table table-sm'>";
				echo "<tr>";
				echo "<th>Lp.</th>";
				echo "<th>Imie </th>";
				echo "<th>Nazwisko </th>";
				echo "<th></th>";
				echo "</tr>";
				$index = 0;
				while ($r = mysqli_fetch_array($rezultat2))
				{
					$index++;
					echo "<tr>";
					echo "<td>" . $index . "</td>";
					echo "<td>" . $r[1] . "</td>";
					echo "<td>" . $r[2] . "</td>";
					echo "<td><button type='submit' class='delete_prowadzacy_real' value='$r[0]'><img src='img/delete.png'></button></td>";
					echo "</tr>";
				}		
				echo "</table>";
		//combobox z prowadzacym
		
		
		$rezultat1 = $polaczenie->query("SELECT id_prowadzacego,imie_prowadzacego,nazwisko_prowadzacego FROM prowadzacy");
		echo "<form id='form1'class='form' name='form' method='post' >";
		echo "<div class='form-row'>";
		echo " <div class='form-group col-md-6' >";
		echo " <select name='select' class='form-control' >";
		while ($r1 = mysqli_fetch_array($rezultat1))
		{
			echo " <option value='$r1[0]'>$r1[1] $r1[2]</option>";
		}

		echo "</select>";
		echo"</div>";
		echo " <div class='form-group col-md-6' >";
		echo "<input type='hidden' name='id_realizacji' value='$id_last'>";
		echo "<button type='button' class=' btn btn-primary' id='add_real_prow'>Wybierz prowadzącego</button>";
		echo "</form>";
		echo"</div>";
		echo"</div>";
		echo"</div>";
		echo"</div>";
	
		


		// tabele z e_materialy
		
	
		
		echo " <div class='form-group col-md-6' >";
		echo "Dodaj E-Materiał: ";
		echo"<div id='e_material'>";
		$rezultat2 = $polaczenie->query("SELECT r.id_e_mate_real,w.nazwa, w.rodzaj FROM realizacja_e_materialy r, e_materialy w where r.id_e_materialu=w.id_e_materialu and r.id_realizacji='$id_last'");
		echo "<table class='table table-sm'>";
		echo "<tr>";
		echo "<th>Lp.</th>";
		echo "<th>Nazwa</th>";
		echo "<th>Rodzaj E-Materiału</th>";
		echo "<th></th>";
		echo "</tr>";
		$index = 0;
		while ($r = mysqli_fetch_array($rezultat2))
		{
			$index++;
			echo "<tr>";
			echo "<td>" . $index . "</td>";
			echo "<td>" . $r[1] . "</td>";
			echo "<td>" . $r[2] . "</td>";
			echo "<td><button type='submit' class='delete_e_materialy_realizacja' value='$r[0]'><img src='img/delete.png'></button></td>";
			echo "</tr>";
		}

		echo "</table>";

		 //combobox z e_materialem
		
		
	
		 $rezultat1 = $polaczenie->query("SELECT id_e_materialu,nazwa,rodzaj FROM e_materialy");
		 echo "<form id='form2'class='form' name='form' method='post' >";
		 echo "<div class='form-row'>";
		 echo " <div class='form-group col-md-6' >";
		 echo " <select name='select_e_materialy'class='form-control'>";
		 while ($r1 = mysqli_fetch_array($rezultat1))
		 {
			 echo " <option value='$r1[0]'>$r1[1] $r1[2]</option>";
		 }
 
		 echo "</select>";
		 echo"</div>";
		 echo " <div class='form-group col-md-6' >";
		 echo "<input type='hidden' name='id_realizacji' value='$id_last'>";
		 echo "<button type='button'id='add_e_materi_real' class=' btn btn-primary' >Wybierz E-materiały</button>";
		 echo "</form>";
		 
		 echo"</div>";
		echo"</div>";
		echo"</div>";
		echo"</div>";
		echo"</div>";
		echo"</div>";
		
		
	//kierunek
	echo "<div class='line'>";

	echo "<div class='form-row'>";
	
	echo " <div class='form-group col-md-4' >";
	echo"<div id='kierunek'>";
	echo "Dodaj Kierunek:";
		$rezultat2 = $polaczenie->query("SELECT r.id_real_kieru,k.nazwa_kierunku FROM realizacja_kierunek r, kierunek k where r.id_kierunku=k.id_kierunku and r.id_realizacji='$id_last'");
		echo "<table class='table table-sm'>";
		echo "<tr>";
		echo "<th>Lp.</th>";
		echo "<th>Nazwa kierunku</th>";		
		echo "<th>Akcja</th>";
		echo "</tr>";
		$index = 0;
		while ($r = mysqli_fetch_array($rezultat2))
		{
			$index++;
			echo "<tr>";
			echo "<td>" . $index . "</td>";
			echo "<td>" . $r[1] . "</td>";			
			echo "<td><button type='submit' class='delete_kierunek_real' value='$r[0]'><img src='img/delete.png'></button></td>";
			echo "</tr>";
		}

        echo "</table>";
	
		$rezultat1 = $polaczenie->query("SELECT id_kierunku,nazwa_kierunku FROM kierunek");
		echo "<form id='form_kierunek'class='form' name='form' method='post' >";
		echo "<div class='form-row'>";
		echo " <div class='form-group col-md-6' >";
		echo " <select name='nazwa_kierunku' class='form-control'>";
		while ($r1 = mysqli_fetch_array($rezultat1))
		{
			echo " <option value='$r1[0]'>$r1[1] </option>";
		}

		echo "</select>";
		echo"</div>";
		echo " <div class='form-group col-md-6' >";
		echo "<input type='hidden' name='id_realizacji' value='$id_last'>";
		echo "<button type='button'id='add_real_kierunek' class=' btn btn-primary' >Wybierz kierunek</button>";
        echo "</form>";
		echo"</div>";
		echo"</div>";
		echo"</div>";
		echo"</div>";
		////////
		echo " <div class='form-group col-md-4' >";
		echo"<div id='rodzaj_zajec'>";
		echo "Wybierz rodzaj zajęć:";
		$rezultat3 = $polaczenie->query("SELECT
        tabela.id_rodzaj_real,  rodzaj.nazwa_zajec, rodzaj.liczba_godzin FROM rodzaj_zajec rodzaj, rodzaj_zajec_realizacja tabela where tabela.id_rodzaj_zajec=rodzaj.id_rodzaj_zajec and tabela.id_realizacji='$id_last'");
		echo "<table class='table table-sm'>";
		echo "<tr>";
		echo "<th>Lp.</th>";
		echo "<th>Rodzaj zajęć</th>";
		echo "<th>Liczba godzin</th>";
		echo "<th></th>";
		echo "</tr>";
		$index = 0;
		while ($r = mysqli_fetch_array($rezultat3))
		{
			$index++;
			echo "<tr>";
			echo "<td>" . $index . "</td>";
			echo "<td>" . $r[1] . "</td>";
			echo "<td>" . $r[2] . "</td>";
			echo "<td><button type='submit' class='delete_rodzaj_zajec' value='$r[0]'> <img src='img/delete.png'></button></td>";
			echo "</tr>";
		}
		echo "</table>";
        ///select z rodzajem zajec
		$rezultat1 = $polaczenie->query("SELECT * FROM 	rodzaj_zajec");
		echo "<form id='from_rodzaj_zajec' name='rodzaj_zajec' method='post' >";
		echo "<div class='form-row'>";
		echo " <div class='form-group col-md-6' >";
		echo " <select name='rodzaj_zajec_select'class='form-control'>";
		while ($r1 = mysqli_fetch_array($rezultat1))
		{
            echo " <option value='$r1[0]'>$r1[1] Godzin: $r1[2] </option>";           
		}

		echo "</select>";
		echo"</div>";
		echo " <div class='form-group col-md-6' >";
		echo "<input type='hidden' name='id_realizacji' value='$id_last'>";    
		   
		echo "<button type='button'id='add_real_rodzaj_zajec'class=' btn btn-primary'>Wybierz rodzaj zajęć</button>";
        echo "</form>";
        //////// tabela z rodzajem zajec
		echo"</div>";
		echo"</div>";
		echo"</div>";
		echo"</div>";
	
		
		/// wybór platformy
		echo " <div class='form-group col-md-4' >";
		
			echo"<div id='platforma'>";
		echo "Wybierz Platforme:";
		$rezultat4 = $polaczenie->query("SELECT tabela.id_real_plat,nazwa.nazwa_platformy FROM platforma nazwa, realizacja_platforma tabela where nazwa.id_platformy=tabela.id_platformy and tabela.id_realizacji='$id_last'");
		echo "<table class='table table-sm'>";
		echo "<tr>";
		echo "<th>Lp.</th>";
		echo "<th>Rodzaj platformy</th>";		
		echo "<th></th>";
		echo "</tr>";
		$index = 0;
		while ($r = mysqli_fetch_array($rezultat4))
		{
			$index++;
			echo "<tr>";
			echo "<td>" . $index . "</td>";
			echo "<td>" . $r[1] . "</td>";
			
			echo "<td><button type='submit' class='delete_rodzaj_platformy' value='$r[0]'><img src='img/delete.png'></button></td>";
			echo "</tr>";
		}
		echo "</table>";
		$rezultat1 = $polaczenie->query("SELECT * FROM 	platforma");
	
		echo "<form id='form_platform' name='platforma' method='post' >";
		echo "<div class='form-row'>";
		echo " <div class='form-group col-md-6' >";
		echo " <select name='rodzaj_platformy'class='form-control'>";
		while ($r1 = mysqli_fetch_array($rezultat1))
		{
            echo " <option value='$r1[0]'> $r1[1]  </option>";           
		}

		echo "</select>";
		echo"</div>";
		echo " <div class='form-group col-md-6' >";
        echo "<input type='hidden' name='id_realizacji' value='$id_last'>";       
		echo "<button type='button'id='add_platforme' class=' btn btn-primary'>Wybiesz platforme</button>";
        echo "</form>";
        //////// tabela z platforma
       
		echo"</div>";
		echo"</div>";
		echo"</div>";
		echo"</div>";
		echo"</div>";
		echo"</div>";
		echo"</div>";
		echo"</div>";
		echo"</div>";

	}

	$polaczenie->close();
}

catch(Exception $e)
{
	echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
	echo "informacja" . $e;
}

?>

<html>
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <link rel="Stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="Stylesheet" type="text/css" href="css/style_realizacja.css" />
    
<script>
    //dodawanie prowadzacego
$(document).ready(function () {
        $('#add_real_prow').click(function () {
            $.ajax({
                type: "POST",
                url: "realizacja_prowadzacy.php",
                data: $("#form1").serialize(),
                success: function (data) { 
					alert(data);                      
					$("#container").load(document.URL);
             
					
                }


            });
        });
	});
</script>

<script>
    //dodawnie rodzaju zajec
$(document).ready(function () {
        $('#add_real_rodzaj_zajec').click(function () {
            $.ajax({
                type: "POST",
                url: "rodzaj_zajec_realizacja.php",
                data: $("#from_rodzaj_zajec").serialize(),
                success: function (data) {                    
					alert(data);     
					$("#container").load(document.URL);
                }


            });
        });       

    });
</script>
<script>
    //dodawanie prowadzacego

	
	$(document).ready(function () {
        $('#add_e_materi_real').click(function () {
            $.ajax({
                type: "POST",
                url: "realizacja_e_materialy.php",
                data: $("#form2").serialize(),
                success: function (data) { 
					alert(data);                      
                 $("#container").load(document.URL);
					
                }


            });
        });
	});
	 //dodawanie kierunku
$(document).ready(function () {
        $('#add_real_kierunek').click(function () {
            $.ajax({
                type: "POST",
                url: "realizacja_kierunek.php",
                data: $("#form_kierunek").serialize(),
                success: function (data) { 
					alert(data);                      
					$("#container").load(document.URL);
					
                }


            });
        });
	});
		$(document).ready(function () {
        $('#add_platforme').click(function () {
            $.ajax({
                type: "POST",
                url: "realizacja_platforma.php",
                data: $("#form_platform").serialize(),
                success: function (data) {
					alert(data);                 
                  	$("#container").load(document.URL);
					
                }


            });
        });       

    });
</script>
<script>  
//usuwanie prowadzacego
    $(document).ready(function () {
        $('.delete_prowadzacy_real').click(function () {
            if (window.confirm('Napewno chcesz usunąć?'))
                var clickBtnValue1 = $(this).val();
                 var ajaxurl = 'funkcja_delete.php',
                data = { 'action_del_prowadzacy': clickBtnValue1 };
              $.post(ajaxurl, data, function (response) {
                // Response div goes here.
				
              	$("#container").load(document.URL);
                return false;
            });
        });
		//usuwanie kierunku
	
        $('.delete_kierunek_real').click(function () {
            if (window.confirm('Napewno chcesz usunąć?'))
                var clickBtnValue1 = $(this).val();
                 var ajaxurl = 'funkcja_delete.php',
                data = { 'action_del_kierunek': clickBtnValue1 };
              $.post(ajaxurl, data, function (response) {
                // Response div goes here.
				
				$("#container").load(document.URL);
                return false;
            });
        });
		$('.delete_e_materialy_realizacja').click(function () {
            if (window.confirm('Napewno chcesz usunąć?'))
                var clickBtnValue1 = $(this).val();
                 var ajaxurl = 'funkcja_delete.php',
                data = { 'delete_realizacja_material': clickBtnValue1 };
              $.post(ajaxurl, data, function (response) {
                // Response div goes here.
				
				$("#container").load(document.URL);
                return false;
            });
        });
        // usuwanie rodzaju zajec 
        $('.delete_rodzaj_zajec').click(function () {
            if (window.confirm('Napewno chcesz usunąć?'))
                var clickBtnValue2 = $(this).val();
                 var ajaxurl = 'funkcja_delete.php',
                data = { 'action_del_rodzaj_zajec': clickBtnValue2 };
              $.post(ajaxurl, data, function (response) {
                // Response div goes here.
                
				$("#container").load(document.URL);
                return false;
            });
        });
		$('.delete_rodzaj_platformy').click(function () {
            if (window.confirm('Napewno chcesz usunąć?'))
                var clickBtnValue2 = $(this).val();
                 var ajaxurl = 'funkcja_delete.php',
                data = { 'action_del_rodzaj_platformy': clickBtnValue2 };
              $.post(ajaxurl, data, function (response) {
                // Response div goes here.
				
				$("#container").load(document.URL);
					
                return false;
            });
        });
		$('#button_delete_all').click(function () {
            if (window.confirm('Napewno chcesz usunąć?'))
                var clickBtnValue2 = $(this).val();
                 var ajaxurl = 'funkcja_delete.php',
                data = { 'delete_realizacja': clickBtnValue2 };
              $.post(ajaxurl, data, function (response) {
                // Response div goes here.
				
				//window.location.href = "../wp-content/plugins/e-learning/admin/partials/realizacja/add_realizacja.php";
				windows.close();
					
                return false;
            });
        });
		$('#wstecz').click(function () {
            if (window.confirm('Czy napewno chcesz wrócić ?'))
                
                // Response div goes here.
				
				window.close();
					
                return false;
          
        });


    });
</script>




</html>
