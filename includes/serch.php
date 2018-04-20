



<?php
require_once "connect.php";
$polaczenie =new mysqli($host, $db_user, $db_password, $db_name);

if(!empty($_POST["keyword"])) {

$result=$polaczenie->query("SELECT DISTINCT  dziedzina FROM e_materialy WHERE dziedzina like '" . $_POST["keyword"] . "%' ORDER BY dziedzina LIMIT 0,6");

if(!empty($result)) {
?>
<ul id="dziedzina-list">
<?php
foreach($result as $dziedzina) {
?>
<li onClick="selectDziedzina('<?php echo $dziedzina["dziedzina"]; ?>');"><?php echo $dziedzina["dziedzina"]; ?></li>
<?php } ?>
</ul>
<?php } } 
?>


