<?php
       
       require_once "connect.php";;// pobranie danych potrzebnych do połączenia z bazą
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
                   
                    $rezultat=$polaczenie->query("SELECT * FROM rodzaj_e_materialu ");
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania

                    echo "<table cellpadding=\"2\" border=1>"; 
                    echo "<tr>";
                        echo "<th>Lp.</th>";
                        echo "<th>Nazwa Materiału</th>";                        
                        echo "<th>Aktualizuj</th>";
                        echo "<th>Usuń</th>";
                    echo "</tr>";
                    $index=0;
                    while($r = mysqli_fetch_array($rezultat)) { 
                        $index++;
                        echo "<tr>"; 
                            echo "<td>".$index."</td>"; 
                            echo "<td>".$r[1]."</td>";                           
                            echo "<td>                             
                            <button type='submit' class='button_update_material' value='$r[0]'>Aktualizuj pozycję</button>     
                            </td>";
                            echo "<td>                             
                            <button type='submit' class='button_delete_material' value='$r[0]'>Usuń pozycję</button>     
                            </td>";
                        echo "</tr>"; 
                    } 
                    echo "</table>"; 
                    }               
                    $polaczenie->close();               
        }  catch(Exception $e){
            echo '<span style="color:red;">Błąd serwer przepraszamy</span>';
            echo "informacja".$e;
        }     
?>

<form class="form" method="post" >
    <div>
        <label>Nazwa E-Materialu</label>
        <input type="text" name="nazw_e_materialu"   placeholder="Zwykły tekst" />
    </div>
     <div>
    <button type='submit' class='button_add_material' >Dodaj</button>     
    </div>
</form>



<script>
    $(document).ready(function () {
        $('.button_delete_material').click(function () {
            if (window.confirm('Napewno chcesz usunac?'))
                var clickBtnValue = $(this).val();
                 var ajaxurl = '../wp-content/plugins/e-learning/admin/partials/pozostale/funkcja_delete_pozostale.php',
                data = { 'delete_material': clickBtnValue };
            $.post(ajaxurl, data, function (response) {
                // Response div goes here.
                
                window.location.reload();
                return false;
            });
        });

    });

    $(document).ready(function () {   
        $('.button_add_material').click(function () {                     
                        $.ajax({
                            type: "POST",
                            url: "../wp-content/plugins/e-learning/admin/partials/pozostale/funkcja_add_material.php",
                            data: $("form").serialize(),
                            success: function (data) {
                                alert(data); 
                           // window.location.reload(); 
                            }


                        });
                    });
                });
    

</script>
