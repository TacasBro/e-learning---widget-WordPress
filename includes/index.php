<html>
<head>
<TITLE>E-materiały</TITLE>
<head>
<style>
body{
    margin: 5px;}
.frmSearch {margin:5px 5px;padding:1;border-radius:4px;}
#dziedzina-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;}
#dziedzina-list li{padding: 10px; background: #ffffff; border-bottom: #888888 3px solid;}
#dziedzina-list li:hover{background:#eeeeee;cursor: pointer;}
#search-box
{ width: 15%;
    padding: 6px 2px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;}
    #search-rodzaj{
        padding: 6px 2px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;  
    }



.material{
    border-bottom: 3px solid #888888;margin: 2px 0px;padding:4;  
    font-size:15px;  
    margin:10px 5px;
    width:25%;
  
}

label{
        font-size:16px;
        margin:10px 5px;
        font-weight: bold; 
        
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
 <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$("#search-box").keyup(function(){
		$.ajax({
		type: "POST",
		url: "serch.php",
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

function selectDziedzina(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
}
</script>
</head>
<body>
<div class="frmSearch">
<input type="text" id="search-box" class="nazwa_dziedziny" placeholder="Dziedzina..." />
<input type="text" id="search-rodzaj" class="nazwa_rodzaju" placeholder="Rodzaj..." />
<button type="button" class="dziedzina_szukaj">Szukaj</button>
<div id="suggesstion-box"></div>
</div>
</body>
</html>
<script>
    $(document).ready(function () {
        $('.dziedzina_szukaj').click(function () {            
            var nazwa_dziedziny =  $('.nazwa_dziedziny').val();   
            $.ajax({
                url      : 'dziedzina.php',
                method   : 'post', 
                data     : {nazwa_dziedziny : nazwa_dziedziny},
                success  : function(data){
                              // now update user record in table 
                              
                       //   alert(data);   
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
                 
                    $rezultat=$polaczenie->query("SELECT e_materialy.nazwa, e_materialy.rodzaj, e_materialy.dziedzina, e_materialy.opis FROM e_materialy");         
                    if(!$rezultat)throw new Exception($polaczenie->erro);// wyłapanie wyjątku z błędem zapytania
                    
                    $index=0;
                    while($r = mysqli_fetch_array($rezultat)) { 
                     echo"<div class='material'>
                     <div class='nazwa'>    <label>Nazwa e-materiału: </label>$r[0]</div>
                     <div class='rodzaj'>  <label>Rodzaj e-materiału: </label>$r[1]</div>
                     <div class='dziedzina'>   <label>Dziedzina: </label> $r[2]</div>
                     <div class='opis'>   <label>Opis: </label>$r[3]</div>
                     </div>";   
                    } 
                   
                    }               
                    $polaczenie->close();               
        }  catch(Exception $e){
            echo 'Błąd serwer przepraszamy';
            echo "informacja".$e;
        }   
       
         echo "<div class='wynik'></div>";
?>
