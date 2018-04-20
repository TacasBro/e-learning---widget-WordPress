<?php
 
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
                   {
                    $rezultat=$polaczenie->query("SELECT k.id_kierunku,k.nazwa_kierunku,w.nazwa_wydzialu,w.id_wydzialu FROM kierunek k, wydzial w WHERE w.id_wydzialu=k.id_wydzialu");
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                    echo "Kierunek:";
                    echo "<table class='table table-sm'>"; 
                    echo "<tr>";
                        echo "<th>Lp.</th>";
                        echo "<th>Nazwa kierunku</th>";    
                        echo "<th>Nazwa wydzialu</th>";                    
                        echo "<th></th>";
                    echo "</tr>";
                    $index=0;
                    while($r = mysqli_fetch_array($rezultat)) { 
                        $index++;
                        echo "<tr id='$r[0]'>"; 
                            echo "<td>".$index."</td>"; 
                            echo "<td data-target='nazwa_kierunk'>".$r[1]."</td>"; 
                            echo "<td data-target='nazwa_wydzalu'>".$r[2]."</td>";                          
                            echo "<td>                             
                            <button id='up_kierunek' data-role='update_kierunek' data-id='$r[0]'><img src='../wp-content/plugins/e-learning/admin/partials/pozostale/img/edit.png'></button>  
                            <button type='submit' class='button_usun_kierunek' value='$r[0]'><img src='../wp-content/plugins/e-learning/admin/partials/pozostale/img/delete.png'></button>       
                            </td>";
                           
                        echo "</tr>"; 
                    } 
                    echo "</table>"; 
                }
                    echo <<<END
                    
                
                <div class='form-row'>
                    <form class='form' method='post' >
                        <div>
                        
                            <input type='text' id='nazwa_kierunku' name='nazwa_kierunku' class='form-control' width="100%"  placeholder="Nazwa kierunku" />
                        </div>
                
                      
END;
                        $rezultat1 = $polaczenie->query("SELECT * FROM 	wydzial");
                        echo " <select name='wydzial'id='wydzial_id' class='form-control'>";
                        echo"<option>Wybór...</option>";
                        while ($r1 = mysqli_fetch_array($rezultat1))
                        {
                            echo " <option value='$r1[0]'> $r1[1]  </option>";           
                        }
                
                        echo "</select>";
                        echo <<<END
                    
                 
                    <div class='form-group col-md-4'>
                        <input type='hidden' id='kierunek_id'class='form-control'>
                        <button type='button' id='button_add_kierunek' class='btn btn-primary' >Dodaj kierunek</button>  
                        <button style='display: none;' type='button' id='button_up_kierunek'class='btn btn-primary' >Aktualizuj pozycję</button>        
                    </div>
                        </form>
                </div>
                   
             

                   
END;


                    }               
                    $polaczenie->close();               
        }  catch(Exception $e){
            echo 'Błąd serwer przepraszamy';
            echo "informacja".$e;
        }     
?>



<script>
$(document).ready(function(){
    
        //  append values in input fields
          $(document).on('click','#up_kierunek[data-role=update_kierunek]',function(){
            var id  = $(this).data('id');
            var nazwa_kierunku  = $('#'+id).children('td[data-target=nazwa_kierunk]').text(); 
            $('#nazwa_kierunku').val(nazwa_kierunku);
            $("#button_up_kierunek").show();
            $("#button_add_kierunek").hide();     
            $('#kierunek_id').val(id);
          //  $('#kierunek_modal').modal('toggle');
          });

          $('#button_up_kierunek').click(function(){
            var id  = $('#kierunek_id').val(); 
           var nazwa_kierunku =  $('#nazwa_kierunku').val(); 
           var wydzial =  $('#wydzial_id').val(); 
            $.ajax({
                url      : '../wp-content/plugins/e-learning/admin/partials/pozostale/up_date_kieunek.php',
                method   : 'post', 
                data     : {wydzial : wydzial ,nazwa_kierunku : nazwa_kierunku , id: id},
                success  : function(response){
                              // now update user record in table 
                            alert(response);
                            $("#kierunek").load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_kierunek.php");
                              //$('#kierunek_modal').modal('toggle');
                           }
            });
         });
    });
</script>

<script>
    $(document).ready(function () {
        $('.button_usun_kierunek').click(function () {
            if (window.confirm('Napewno chcesz usunąć?'))
                var clickBtnValue = $(this).val();
                 var ajaxurl = '../wp-content/plugins/e-learning/admin/partials/pozostale/funkcja_delete_pozostale.php',
                data = { 'delete_kierunek': clickBtnValue };
            $.post(ajaxurl, data, function (response) {
                // Response  goes here.
               // location.reload();
                $("#kierunek").load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_kierunek.php");
                return false;
            });
        });

    });

    $(document).ready(function () {   
        $('#button_add_kierunek').click(function () {                     
                        $.ajax({
                            type: "POST",
                            url: "../wp-content/plugins/e-learning/admin/partials/pozostale/funkcja_add_kierunek.php",
                            data: $("form").serialize(),
                            success: function (data) {
                                alert(data); 
                              
                                $("#kierunek").load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_kierunek.php"); 
                           // window.location.reload(); 
                            }


                        });
                    });
                });
    

</script>
