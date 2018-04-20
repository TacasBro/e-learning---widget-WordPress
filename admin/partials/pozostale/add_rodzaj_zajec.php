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
                   
                    $rezultat=$polaczenie->query("SELECT * FROM rodzaj_zajec ");
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                    echo "Rodzaj zajęć:";
                    echo "<table class='table table-sm'>"; 
                    echo "<tr>";
                        echo "<th>Lp.</th>";
                        echo "<th>Nazwa zajęć</th>";    
                        echo "<th>Liczba godzin</th>";                     
                        echo "<th></th>";
                    echo "</tr>";
                    $index=0;
                    while($r = mysqli_fetch_array($rezultat)) { 
                        $index++;
                        echo "<tr id='$r[0]'>"; 
                            echo "<td>".$index."</td>"; 
                            echo"<td data-target='nazwa_zajec_up'>".$r[1]."</td>"; 
                            echo"<td data-target='liczba_up'>".$r[2]."</td>";                          
                            echo "<td>                             
                            <button id='up_zajecia' data-role='update_rodzaj_zajec' data-id='$r[0]' class='button_update_zajecia'><img src='../wp-content/plugins/e-learning/admin/partials/pozostale/img/edit.png'></button>   
                            <button type='submit' class='button_delete_zajecia' value='$r[0]'><img src='../wp-content/plugins/e-learning/admin/partials/pozostale/img/delete.png'></button>     
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


<div class="form-row">
<form class="form" method="post" >
    <div >       
        <input type="text" name="nazwa_zajec" class="form-control" id="nazwa_zajec_up"    placeholder="Rodzaj zajęć" />
    </div>
    <div >        
        <input type="number" name="liczba_godzin" id="liczba_up" class="form-control"   placeholder="Liczba godzin" />
    </div>
    <div>
    <input type="hidden" id="userId" class="form-control">
    <button type='button' id='button_add_zajecia' class="btn btn-primary" >Dodaj zajęcia </button>     
    <button style="display: none;" type='button' id='button_up_zajecia' class="btn btn-primary" >Aktualizuj pozycję</button> 
    </div>
</form>
</div>


<script>
    $(document).ready(function () {
        $('.button_delete_zajecia').click(function () {
            if (window.confirm('Napewno chcesz usunąć?'))
                var clickBtnValue = $(this).val();
                 var ajaxurl = '../wp-content/plugins/e-learning/admin/partials/pozostale/funkcja_delete_pozostale.php',
                data = { 'delete_zajecia': clickBtnValue };
            $.post(ajaxurl, data, function (response) {
                // Response div goes here.
                
               // location.reload();
                $("#nazwa_zajec").load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_rodzaj_zajec.php");
                return false;
            });
        });

    });
    </script>
        <script>

    $(document).ready(function () {   
        $('#button_add_zajecia').click(function () {                     
                        $.ajax({
                            type: "POST",
                            url: "../wp-content/plugins/e-learning/admin/partials/pozostale/funkcja_add_zajecia.php",
                            data: $(".form").serialize(),
                            success: function (data) {
                                alert(data); 
                               // location.reload();
                                $("#nazwa_zajec").load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_rodzaj_zajec.php");
                            }


                        });
                    });
                });
    

</script>
  <script>
$(document).ready(function(){
    
        //  append values in input fields
          $(document).on('click','#up_zajecia[data-role=update_rodzaj_zajec]',function(){
            var id  = $(this).data('id');
            var nazwa_zajec_up  = $('#'+id).children('td[data-target=nazwa_zajec_up]').text(); 
            var liczba_up  = $('#'+id).children('td[data-target=liczba_up]').text();     
            $('#nazwa_zajec_up').val(nazwa_zajec_up);
            $('#liczba_up').val(liczba_up);
            $('#userId').val(id);
            $("#button_up_zajecia").show();
            $("#button_add_zajecia").hide();
          });

          $('#button_up_zajecia').click(function(){
            var id  = $('#userId').val(); 
           var nazwa_zajec_up =  $('#nazwa_zajec_up').val(); 
           var liczba_up =  $('#liczba_up').val(); 
            $.ajax({
                url      : '../wp-content/plugins/e-learning/admin/partials/pozostale/up_rodzaj_zajec.php',
                method   : 'post', 
                data     : {nazwa_zajec_up : nazwa_zajec_up , liczba_up : liczba_up , id: id},
                success  : function(response){
                              // now update user record in table 
                            
                            alert(response);
                            
                            // $('#'+id).children('td[data-target=liczba_up]').text(liczba_up);
                            // $('#'+id).children('td[data-target=nazwa_zajec_up]').text(nazwa_zajec_up);
                            $("#nazwa_zajec").load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_rodzaj_zajec.php");
                              
                           }
                         
            });
         
         });
        
    });
</script>

