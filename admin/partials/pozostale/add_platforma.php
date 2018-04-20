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
                   
                    $rezultat=$polaczenie->query("SELECT * FROM platforma ");
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                    echo "Platforma:";
                    echo "<table class='table table-sm'>"; 
                    echo "<tr>";
                        echo "<th>Lp.</th>";
                        echo "<th>Nazwa Platformy</th>";                        
                        echo "<th></th>";
                    echo "</tr>";
                    $index=0;
                    while($r = mysqli_fetch_array($rezultat)) { 
                        $index++;
                        echo "<tr id='$r[0]'>"; 
                            echo "<td>".$index."</td>"; 
                            echo"<td data-target='platforma_up'>".$r[1]."</td>  ";                           
                            echo "<td>                             
                            <button type='submit' data-role='update' data-id='$r[0]'><img src='../wp-content/plugins/e-learning/admin/partials/pozostale/img/edit.png'></button> 
                            <button type='submit' class='button_delete_platforma' value='$r[0]'><img src='../wp-content/plugins/e-learning/admin/partials/pozostale/img/delete.png'></button>     
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
        <div>       
                <input type="text" id="platforma_up" name="nazwa_platformy" class="form-control"  width="100%" placeholder="Nazwa platformy" />
                <input type="hidden" id="userId" class="form-control" width="100%">
        </div>
            <div>
                <button type='button' id='button_add_platforma' class="btn btn-primary" >Dodaj Platformę</button>  
                <button style="display: none;" type='button' id='button_up_platforma'class="btn btn-primary" >Aktualizuj platformę</button>        
            </div> 
            </form>
</div>
      
    


<script>
    $(document).ready(function () {
        $('.button_delete_platforma').click(function () {
            if (window.confirm('Napewno chcesz usunąć?'))
                var clickBtnValue = $(this).val();
                 var ajaxurl = '../wp-content/plugins/e-learning/admin/partials/pozostale/funkcja_delete_pozostale.php',
                data = { 'delete_platforma': clickBtnValue };
            $.post(ajaxurl, data, function (response) {
                // Response  goes here.
              //  location.reload();
               $("#platforma").load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_platforma.php");
                return false;
            });
        });

    });
    </script>
                <script>

    $(document).ready(function () {   
        $('#button_add_platforma').click(function () {                     
                        $.ajax({
                            type: "POST",
                            url: "../wp-content/plugins/e-learning/admin/partials/pozostale/funkcja_add_platforma.php",
                            data: $("form").serialize(),
                            success: function (data) {
                                alert(data); 
                                //location.reload();
                               $("#platforma").load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_platforma.php"); 
                            }


                        });
                    });
                });
                </script>
                <script>
$(document).ready(function(){
    
        //  append values in input fields
          $(document).on('click','button[data-role=update]',function(){
            var id  = $(this).data('id');
            var platforma_up  = $('#'+id).children('td[data-target=platforma_up]').text();   
            $('#platforma_up').val(platforma_up);
            $('#userId').val(id);
            $("#button_up_platforma").show();
            $("#button_add_platforma").hide();
           
          });

          $('#button_up_platforma').click(function(){
            var id  = $('#userId').val(); 
           var platforma_up =  $('#platforma_up').val(); 
            $.ajax({
                url      : '../wp-content/plugins/e-learning/admin/partials/pozostale/up_platforme.php',
                method   : 'post', 
                data     : {platforma_up : platforma_up , id: id},
                success  : function(response){
                              // now update user record in table 
                              alert(response);
                              $("#platforma").load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_platforma.php"); 
                        
                           // location.reload();
                            //$('#'+id).children('td[data-target=platforma_up]').text(platforma_up);
                           // $('#modal_platforma').modal('toggle');
                              
                           }
                         
            });
         
         });
        
    });

    </script>