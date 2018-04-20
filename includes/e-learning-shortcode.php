
<style>

.frmSearch {margin:5px 5px;padding:1;border-radius:4px;}
#dziedzina-list{float:left;list-style:none;margin-left:0px;padding:0;width:33%;position:absolute;}
#dziedzina-list li{padding: 2px 10px;list-style:none; background: #ffffff; border-bottom: #D6D5D5 2px solid;}
#dziedzina-list li:hover{background:#eeeeee;cursor: pointer;}
#rodzaj-list{float:left;list-style:none;margin-left:33%;padding:0;width:33%;position:absolute;}
#rodzaj-list li{padding: 2px 10px;list-style:none; background: #ffffff; border-bottom: #D6D5D5 2px solid;}
#rodzaj-list li:hover{background:#eeeeee;cursor: pointer;}
#search-box{ width: 40%;
    padding: 6px 2px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;}
    #search-rodzaj{ width: 40%;       
        padding: 6px 2px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;  
    }
    .stro{
        -webkit-appearance: button;
        background: none repeat scroll 0 0 #0033a0;
        border-color: #aaaaaa #bbbbbb #bbbbbb;
        border-radius: 3px;
        color: #fcfcfc;
        font-size: 10px;
    padding: 3px 15px;
    }




.material{
    border-bottom: 3px solid #ffffff;margin: 2px 0px;padding:4;  
    font-size:15px;  
    margin:10px 5px;
    width:100%;
  
}

label{
        font-size:16px;
        margin:6px 2px;
        font-weight: bold !important; 
        
}
.dziedzina_szukaj{
     background-color: #0033a0; /* Green */
    border: none;
    color: white;
    padding: 5px 30px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 4px;
}
.dziedzina_szukaj:hover {
    background-color: #3377e3; /* Green */
    color: white;
}
</style>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
	$("#search-box").keyup(function(){
		$.ajax({
		type: "POST",
	url: "../wp-content/plugins/e-learning/includes/serch.php",
    //  url: "serch.php",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#search-box").css("background","#FFF");
		},
		success: function(data){
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#search-box").css("background","#FFF");
		}
		});
	});
});
$(document).ready(function(){
	$("#search-rodzaj").keyup(function(){
		$.ajax({
		type: "POST",
		url: "../wp-content/plugins/e-learning/includes/serch1.php",
     // url: "serch1.php",
		data:'keyword_rodzaj='+$(this).val(),
		beforeSend: function(){
			$("#search-rodzaj").css("background","#FFF");
		},
		success: function(data){
			$("#suggesstion-rodzaj").show();
			$("#suggesstion-rodzaj").html(data);
			$("#search-rodzaj").css("background","#FFF");
		}
		});
	});
});

function selectDziedzina(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
}
function selectRodzaj(val) {
$("#search-rodzaj").val(val);
$("#suggesstion-rodzaj").hide();
}
</script>

<div class="frmSearch">
<input type="text" id="search-box" class="nazwa_dziedziny" placeholder="Dziedzina..." />
<input type="text" id="search-rodzaj" class="nazwa_rodzaju" placeholder="Rodzaj..." />
<button type="button" class="dziedzina_szukaj">Szukaj</button>
<div id="suggesstion-box"></div>
<div id="suggesstion-rodzaj"></div>
</div>

<script>
    $(document).ready(function () {
        $('.dziedzina_szukaj').click(function () {            
            var nazwa_dziedziny =  $('.nazwa_dziedziny').val();   
            var nazwa_rodzaju =  $('.nazwa_rodzaju').val();   
            $.ajax({
               url      : '../wp-content/plugins/e-learning/includes/dziedzina.php',
               // url      : 'dziedzina.php',
                method   : 'post', 
                data     : {nazwa_dziedziny : nazwa_dziedziny, nazwa_rodzaju: nazwa_rodzaju},
                success  : function(data){
                              // now update user record in table 
                              
                       //   alert(data); 
                       $(".stronicowanie").hide();  
                       $(".material").hide();                      
                            $(".wynik").html(data); 
                       
                           }
                         
            });        
        });

    });
    </script>
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
                    $results_per_page = 4;
                    $page = ''; 
                    $rezultat=$polaczenie->query("SELECT prowadzacy.imie_prowadzacego, prowadzacy.nazwisko_prowadzacego, e_materialy.nazwa, e_materialy.rodzaj, e_materialy.dziedzina, e_materialy.opis FROM e_materialy, prowadzacy, e_materialy_prowadzacy WHERE e_materialy.id_e_materialu=e_materialy_prowadzacy.id_e_materialu and e_materialy_prowadzacy.id_prowadzacego=prowadzacy.id_prowadzacego");
                    $number_of_results = mysqli_num_rows($rezultat);
                    $number_of_pages = ceil($number_of_results/$results_per_page);
                   
                    if (!isset($_POST['page'])) {
                        $page = 1;
                      } else {
                        $page = $_POST['page'];
                      }
                      $this_page_first_result = ($page-1)*$results_per_page;
                    $rezultat=$polaczenie->query("SELECT prowadzacy.imie_prowadzacego, prowadzacy.nazwisko_prowadzacego, e_materialy.nazwa, e_materialy.rodzaj, e_materialy.dziedzina, e_materialy.opis FROM e_materialy, prowadzacy, e_materialy_prowadzacy WHERE e_materialy.id_e_materialu=e_materialy_prowadzacy.id_e_materialu and e_materialy_prowadzacy.id_prowadzacego=prowadzacy.id_prowadzacego LIMIT $this_page_first_result,$results_per_page");         
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                    
                    $index=0;
                    echo "<div class='all_materialy'>";
                    while($r = mysqli_fetch_array($rezultat)) {               
                        
                     echo"<div class='material'>
                     <div class='autor'>    <label>Autor: </label>$r[0] $r[1]</div>
                     <div class='nazwa'>    <label>Nazwa: </label>$r[2]</div>
                     <div class='dziedzina'>    <label>Dziedzina: </label>$r[4]</div>
                     <div class='rodzaj'>    <label>Rodzaj: </label>$r[3]</div>
                 
                     <div class='opis'>    <label>Opis: </label>$r[5]</div>
                    
                     
                     </div>";

                    } 
                   
                      echo "</div>"; 
                      echo"<div class=stronicowanie >";
                      for ($page=1;$page<=$number_of_pages;$page++) {
                        //  echo"<from action=# method='post'>";
                         // echo" <input type='hidden' name='page' value='$page'>";
                        //  echo " <input type='submit'  value='$page'>";
                        //  echo"</from>";
                       //  echo "<a href='all_add.php?page=$page'>$page</a>";  
                       
                        echo" <button class='stro' data-role='stronicowanie_button' value='$page' data-id='$page'>$page</button>"         ;
                        }
                        echo"</div>";
                    }               
                    $polaczenie->close();               
        }  catch(Exception $e){
            echo 'Błąd serwer przepraszamy';
            echo "informacja".$e;
        }   
       
         echo "<div class='wynik'></div>";
        
?>

<script>
$(document).ready(function(){
            //  append values in input fields
          $(document).on('click','.stro[data-role=stronicowanie_button]',function(){
            var page = $(this).val();
          //  var id  = $(this).data('id');      
         
            $.ajax({
                url      : '../wp-content/plugins/e-learning/includes/str.php',
                method   : 'post', 
                data     : {page : page},
                success  : function(response){                             
                            
                            //alert(response);
                            // $('#'+id).children('td[data-target=imie_up]').text(imie_up);
                            // $('#'+id).children('td[data-target=nazwisko_up]').text(nazwisko_up);
                            // $('#'+id).children('td[data-target=jednostka_up]').text(jednostka_up);
                            // $('#'+id).children('td[data-target=stanowisko_up]').text(stanowisko_up);
                            // $('#'+id).children('td[data-target=mail_up]').text(mail_up);
                            // $('#'+id).children('td[data-target=strona_up]').text(strona_up);                            
                           // $('#modal_osoba').modal('toggle');
                           $(".all_materialy").html(response);
                          // $(".all_materialy").load("str.php");    
                           }
                         
            });
         
         });
        
    });
</script>