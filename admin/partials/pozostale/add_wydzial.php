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
                   
                    $rezultat=$polaczenie->query("SELECT * FROM wydzial ");
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                    echo "Wydział:";
                    echo "<table class='table table-sm'>"; 
                    echo "<tr>";
                        echo "<th>Lp.</th>";
                        echo "<th>Nazwa wydziału</th>";                        
                        echo "<th></th>";
                    echo "</tr>";
                    $index=0;
                    while($r = mysqli_fetch_array($rezultat)) { 
                        $index++;
                        echo "<tr id='$r[0]'>"; 
                            echo "<td>".$index."</td>"; 
                            echo"<td data-target='wydzial_up'>".$r[1]."</td>  ";         
                            echo "<td>                             
                            <button id='load_wydzial' data-role='update_wydzial' data-id='$r[0]'><img src='../wp-content/plugins/e-learning/admin/partials/realizacja/img/edit.png'></button> 
                            <button type='submit' class='button_delete_wydzial' value='$r[0]'><img src='../wp-content/plugins/e-learning/admin/partials/realizacja/img/delete.png'></button>   
                            </td>";
                          
                        echo "</tr>"; 
                    } 
                    echo "</table>"; 
                    }               
                    $polaczenie->close();               
        }  catch(Exception $e){
            echo 'Błąd serwer przepraszamy';
            echo "informacja".$e;
        }     
?>




<div class="form-row">
    <form class="form_wydzial" method="post" >
        <div >   
            <input type="text" name="nazwa_wydzialu" id="wydzial_up_form" class="form-control"  placeholder="Nazwa wydziału" />
        </div>
        <div >    
            <input type="hidden" id="userId" class="form-control">
            <button type='button' id='button_add_wydzial' class="btn btn-primary" >Dodaj wydział</button>  
            <button style="display: none;" type='button' id='button_up_wydzial'class="btn btn-primary" >Aktualizuj pozycję</button>      
        </div>
    </form>
</div>
  




<script>
    $(document).ready(function () {
        $('.button_delete_wydzial').click(function () {
            if (window.confirm('Napewno chcesz usunąć?'))
                var clickBtnValue = $(this).val();
                 var ajaxurl = '../wp-content/plugins/e-learning/admin/partials/pozostale/funkcja_delete_pozostale.php',
                data = { 'delete_wydzial': clickBtnValue };
            $.post(ajaxurl, data, function (response) {
                // Response div goes here.
                
               // location.reload();
               $('#wydzial').load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_wydzial.php");
               $("#kierunek").load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_kierunek.php");
                return false;
            });
        });

    });
    </script>
        <script>
    $(document).ready(function () {   
        $('#button_add_wydzial').click(function () {                     
                        $.ajax({
                            type: "POST",
                            url: "../wp-content/plugins/e-learning/admin/partials/pozostale/funkcja_add_wydzial.php",
                            data: $(".form_wydzial").serialize(),
                            success: function (data) {
                                alert(data); 
                               // location.reload();
                               $('#wydzial').load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_wydzial.php");
                               $("#kierunek").load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_kierunek.php");
                            }


                        });
                    });
                });
    

</script>

    <script>
$(document).ready(function(){
    
        //  append values in input fields
          $(document).on('click','#load_wydzial[data-role=update_wydzial]',function(){
            var id  = $(this).data('id');
            var wydzial_up  = $('#'+id).children('td[data-target=wydzial_up]').text();   
            $('#wydzial_up_form').val(wydzial_up);
            $('#userId').val(id);
            $('#button_up_wydzial').show();
            $('#button_add_wydzial').hide();
          });

          $('#button_up_wydzial').click(function(){
            var id  = $('#userId').val(); 
           var wydzial_up =  $('#wydzial_up_form').val(); 
            $.ajax({
                url      : '../wp-content/plugins/e-learning/admin/partials/pozostale/up_date_wydzial.php',
                method   : 'post', 
                data     : {wydzial_up : wydzial_up , id: id},
                success  : function(response){
                              // now update user record in table 
                              
                            alert(response);                         
                            $("#wydzial").load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_wydzial.php");
                            $("#kierunek").load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_kierunek.php");
                           }
                         
            });
         
         });
        
    });
</script>

