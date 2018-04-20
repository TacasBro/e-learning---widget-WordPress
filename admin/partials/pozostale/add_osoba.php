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
                    $results_per_page = 7;
                    $page = ''; 
                    $rezultat=$polaczenie->query("SELECT * FROM prowadzacy ");
                    $number_of_results = mysqli_num_rows($rezultat);
                    $number_of_pages = ceil($number_of_results/$results_per_page);
                    if (!isset($_GET['page'])) {
                        $page = 1;
                      } else {
                        $page = $_GET['page'];
                      }
                      $this_page_first_result = ($page-1)*$results_per_page;
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                    $rezultat=$polaczenie->query("SELECT * FROM prowadzacy");
                    echo "Osoba:";
                    echo "<table class='table table-sm'>"; 
                    echo "<tr>";
                        echo "<th>Lp.</th>";
                        echo "<th>Imie </th>";
                        echo "<th>Nazwisko </th>";
                        echo "<th>Jednostka organizacyjna</th>";
                        echo "<th>Stanowisko</th>";                     
                        echo "<th>Adres E-mail</th>";
                        echo "<th>Strona WWW</th>";
                        echo "<th></th>";
                    echo "</tr>";
                    
                    $index=0;
                    while($r = mysqli_fetch_array($rezultat)) { 
                        $index++;
                        echo "<tr id='$r[0]'>"; 
                            echo "<td>".$index."</td>"; 
                            echo"<td data-target='imie_up'>".$r[1]."</td>"; 
                            echo"<td data-target='nazwisko_up'>".$r[2]."</td>";
                            echo"<td data-target='jednostka_up'>".$r[3]."</td>";  
                            echo"<td data-target='stanowisko_up'>".$r[4]."</td>";                           
                            echo"<td data-target='mail_up'>".$r[5]."</td>"; 
                            echo"<td data-target='strona_up'>".$r[6]."</td>"; 
                            echo "<td>                             
                            <button id='up_osba' data-role='update_osoba' data-id='$r[0]'><img src='../wp-content/plugins/e-learning/admin/partials/pozostale/img/edit.png'></button> 
                            <button type='submit' class='button_delete_osoba' value='$r[0]'><img src='../wp-content/plugins/e-learning/admin/partials/pozostale/img/delete.png'></button>     
                            <button type='submit' class='stats_osoba' value='$r[0]'>Szczegóły</button> 
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
        // echo"<div class=stronicowanie >";
        // for ($page=1;$page<=$number_of_pages;$page++) {
            
        //    // echo "<a href='admin.php?page=e-learning=$page'>$page</a>";
        //     echo "<a href='all_add.php?page=$page'>$page</a>";    
       
        //   }
        //   echo"</div>";
         
?>



<form class="form" method="post" >
<div class="form-row">
    <div  class="form-group col-md-4">
        <label >Imie </label>
        <input type="text" name="imie_prowadzacego" id="imie_up" class="form-control"   placeholder="Imie..." />
    </div>
    <div class="form-group col-md-4">
        <label>Nazwisko </label>
        <input type="text" name="nazwisko_prowadzacego"id="nazwisko_up" class="form-control" placeholder="Nazwisko..." />
    </div>    
    <div class="form-group col-md-4">
        <label>Jednostka organizacyjna</label>
        <input type="text"name="stanowisko" class="form-control"id="jednostka_up"  placeholder="Jednostka..." />
    </div>
    </div>
    <div class="form-row">
   
    <div class="form-group col-md-4">
        <label>Stanowisko</label>
        <input type="text" name="jednosta_organizacyjna"id="stanowisko_up" class="form-control"  placeholder="Stanowisko..." />
    </div>
    <div class="form-group col-md-4">
        <label>Email</label>
        <input type="text"name="e_mail"  class="form-control"id="mail_up" placeholder="Email..." />
    </div>
    <div class="form-group col-md-4" >
        <label>URL</label>
        <input type="text"name="strona_www" class="form-control" id="strona_up" placeholder="http://..." />
    </div>
    </div>     
            <input type="hidden" id="userId" class="form-control">
   
    <div style="margin-bottom: 15px;">
    <button type='button' id='button_add' class="btn btn-primary" >Dodaj osobę</button> 
    <button style="display: none;" type='button' id='button_up'class="btn btn-primary" >Aktualizuj pozycję</button>        
    </div>


  
    
</form>



<script>
    $(document).ready(function () {
        $('.button_delete_osoba').click(function () {
            if (window.confirm('Napewno chcesz usunąć?'))
                var clickBtnValue = $(this).val();
                 var ajaxurl = '../wp-content/plugins/e-learning/admin/partials/pozostale/funkcja_delete_pozostale.php',
                data = { 'delete_osoba': clickBtnValue };
            $.post(ajaxurl, data, function (response) {
                // Response div goes here.
               // location.reload();
                $("#osoba").load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_osoba.php");
                return false;
            });
        });

    });

    $(document).ready(function () {
        $('.stats_osoba').click(function () {            
                var clickBtnValue = $(this).val();                
                window.open("../wp-content/plugins/e-learning/admin/partials/pozostale/stats/stats_osoba.php?id="+clickBtnValue+"", "MsgWindow", "toolbar=no,scrollbars=yes,resizable=yes,width=1000,height=700");
            return false;        
        });

    });


    $(document).ready(function () {   
        $('#button_add').click(function () {                     
                        $.ajax({
                            type: "POST",
                            url: "../wp-content/plugins/e-learning/admin/partials/pozostale/funkcja_add_osoba.php",
                            data: $("form").serialize(),
                            success: function (data) {
                                alert(data); 
                               // location.reload();
                               $("#osoba").load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_osoba.php");
                           // window.location.reload(); 
                            }


                        });
                    });
                });
    

$(document).ready(function(){
            //  append values in input fields
          $(document).on('click','#up_osba[data-role=update_osoba]',function(){
            var id  = $(this).data('id');
            var imie_up  = $('#'+id).children('td[data-target=imie_up]').text();   
            $('#imie_up').val(imie_up);
            var nazwisko_up  = $('#'+id).children('td[data-target=nazwisko_up]').text(); 
            $('#nazwisko_up').val(nazwisko_up);
            var jednostka_up  = $('#'+id).children('td[data-target=jednostka_up]').text(); 
            $('#jednostka_up').val(jednostka_up);       
            var stanowisko_up  = $('#'+id).children('td[data-target=stanowisko_up]').text(); 
            $('#stanowisko_up').val(stanowisko_up);       
            var mail_up  = $('#'+id).children('td[data-target=mail_up]').text();   
            $('#mail_up').val(mail_up);
            var strona_up  = $('#'+id).children('td[data-target=strona_up]').text();   
            $('#strona_up').val(strona_up);            
            $('#userId').val(id);
            $("#button_up").show();
            $("#button_add").hide();
            // $('#modal_osoba').modal('toggle');
          });

          $('#button_up').click(function(){
            var id  = $('#userId').val(); 
           var imie_up =  $('#imie_up').val(); 
           var nazwisko_up =  $('#nazwisko_up').val(); 
           var jednostka_up =  $('#jednostka_up').val(); 
           var stanowisko_up =  $('#stanowisko_up').val(); 
           var mail_up =  $('#mail_up').val(); 
           var strona_up =  $('#strona_up').val(); 
            $.ajax({
                url      : '../wp-content/plugins/e-learning/admin/partials/pozostale/up_osoba.php',
                method   : 'post', 
                data     : {imie_up : imie_up ,
                    nazwisko_up : nazwisko_up ,
                    jednostka_up : jednostka_up ,
                    stanowisko_up : stanowisko_up ,
                    mail_up : mail_up ,
                    strona_up : strona_up ,
                     id: id},
                success  : function(response){                             
                            
                            alert(response);
                            // $('#'+id).children('td[data-target=imie_up]').text(imie_up);
                            // $('#'+id).children('td[data-target=nazwisko_up]').text(nazwisko_up);
                            // $('#'+id).children('td[data-target=jednostka_up]').text(jednostka_up);
                            // $('#'+id).children('td[data-target=stanowisko_up]').text(stanowisko_up);
                            // $('#'+id).children('td[data-target=mail_up]').text(mail_up);
                            // $('#'+id).children('td[data-target=strona_up]').text(strona_up);                            
                           // $('#modal_osoba').modal('toggle');
                           $("#osoba").load("../wp-content/plugins/e-learning/admin/partials/pozostale/add_osoba.php");
                              
                           }
                         
            });
         
         });
        
    });
</script>
