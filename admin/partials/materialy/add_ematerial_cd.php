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
		$rezultat = $polaczenie->query("SELECT * FROM e_materialy where id_e_materialu='$id_last'");
		if (!$rezultat) throw new Exception($polaczenie->erro); // wyłapanie wyjątku z błędem zapytania
    	echo"<div id='container'>";
        echo "<div class='line'>";
    echo "<table class='table table-sm'>";
        echo "<tr>";
            echo "<th>Lp.</th>";
            echo "<th>Nazwa</th>";
            echo "<th>Rodzaj</th>";
            echo "<th>Dziedzina</th>";
            echo "<th>Certyfika</th>";
            echo "<th>Data utowrzenia</th>";  
            echo "<th>Data modyfikacji</th>"; 
            echo "<th>Wersja</th>";   
            echo "<th>Opis</th>";   
            echo "<th></th>";
        echo "</tr>";
        
        $index=0;
               while($r = mysqli_fetch_array($rezultat)) { 
            $index++;
            echo "<tr>"; 
                echo "<td>".$index."</td>"; 
                echo "<td>".$r[1]."</td>"; 
                echo "<td>".$r[2]."</td>"; 
                echo "<td>".$r[3]."</td>"; 
                echo "<td>".$r[4]."</td>";      
                echo "<td>".$r[5]."</td>";    
                echo "<td>".$r[6]."</td>"; 
                echo "<td>".$r[7]."</td>";      
                echo "<td>".$r[8]."</td>";  
                echo "<td>   
                </td>";  
			echo "</tr>";
		}
        echo "</table>";
        //echo" <button  class='btn btn-secondary' id='wstecz'>Wróć do realizacji</button>";
        echo"</div>";
        
        echo "<div class='line'>";
        echo "<div id='autor'>";
        echo "Dodaj Autora";
        echo "<div class='form-row'>";               
        echo " <div class='form-group col-md-6' >";
    
        
        //combobox z prowadzacym
      
        $rezultat2 = $polaczenie->query("SELECT w.id_prowadzacego,w.imie_prowadzacego, w.nazwisko_prowadzacego FROM e_materialy_prowadzacy r, prowadzacy w where r.id_prowadzacego=w.id_prowadzacego and r.id_e_materialu='$id_last'");
		echo "<table class='table table-sm'>";
		echo "<tr>";
		echo "<th>Lp.</th>";
		echo "<th>Imie </th>";
		echo "<th>Nazwisko </th>";
		echo "<th>Akcja</th>";
		echo "</tr>";
		$index = 0;
		while ($r = mysqli_fetch_array($rezultat2))
		{
			$index++;
			echo "<tr>";
			echo "<td>" . $index . "</td>";
			echo "<td>" . $r[1] . "</td>";
			echo "<td>" . $r[2] . "</td>";
			echo "<td><button type='submit' class='delete_prowadzacy_material' value='$r[0]'><img src='img/delete.png'></button></td>";
			echo "</tr>";
		}

        echo "</table>";
        echo"</div>";
        echo " <div   class='form-group col-md-6' >";
		$rezultat1 = $polaczenie->query("SELECT id_prowadzacego,imie_prowadzacego,nazwisko_prowadzacego FROM prowadzacy");
		echo "<form class='form_prowadzacy' name='form' method='post' >";
		echo " <select name='select' style='margin-bottom:15px; margin-left:15px;' class='form-control'>";
		while ($r1 = mysqli_fetch_array($rezultat1))
		{
			echo " <option value='$r1[0]'>$r1[1] $r1[2]</option>";
		}

		echo "</select>";
		echo "<input type='hidden' name='id_e_materialu' value='$id_last'>";
		echo "<button style=' margin-left:15px;' type='button' class=' btn btn-primary' id='add_mate_prowadz'>Dodaj Autora</button>";
        echo "</form>";
        echo"</div>";
        echo"</div>";
        echo"</div>";
        echo"</div>";        
        echo"</div>"; 
        // tabele z prowadzacymi
		
        $polaczenie->close();
    }
    
 } catch(Exception $e)
    {
        echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
        echo "informacja" . $e;
    }
    
    ?>
    
    <html>
    <head>
    
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <link rel="Stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="Stylesheet" type="text/css" href="css/style_realizacja.css" />
    
    
    
    <script>
     //dodawanie prowadzacego
$(document).ready(function () {
        $('#add_mate_prowadz').click(function () {
            $.ajax({
                type: "POST",
                url: "material_prowadzacy.php",
                data: $(".form_prowadzacy").serialize(),
                success: function (data) { 
					alert(data);                      
                    $("#container").load(document.URL);
					
                }


            });
        });
        $('.delete_prowadzacy_material').click(function () {
            if (window.confirm('Napewno chcesz usunac?'))
                var clickBtnValue1 = $(this).val();
                 var ajaxurl = 'funkcja_delete.php',
                data = { 'delete_prowadzacy_material': clickBtnValue1 };
              $.post(ajaxurl, data, function (response) {
                // Response div goes here.
				
                $("#container").load(document.URL);
                return false;
            });
        });
		$('#button_delete_all').click(function () {
            if (window.confirm('Napewno chcesz usunac?'))
                var clickBtnValue2 = $(this).val();
                 var ajaxurl = 'funkcja_delete.php',
                data = { 'delete_material': clickBtnValue2 };
              $.post(ajaxurl, data, function (response) {
                // Response div goes here.
				
				window.close();
					
                return false;
            });
        });

    });
    $('#wstecz').click(function () {
                   if (window.confirm('Napewno chcesz wrócić?'))
               
                // Response div goes here.
				
				window.location.href = "../wp-content/plugins/e-learning/admin/partials/materialy/add_ematerialy.php";
					
                return false;
        
    });

    </script>