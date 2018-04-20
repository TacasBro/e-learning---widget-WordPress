



<?php
require_once "connect.php";
$polaczenie =new mysqli($host, $db_user, $db_password, $db_name);

if(!empty($_POST["keyword_rodzaj"])) {

$result=$polaczenie->query("SELECT DISTINCT  rodzaj FROM e_materialy WHERE rodzaj like '" . $_POST["keyword_rodzaj"] . "%' ORDER BY rodzaj LIMIT 0,6");

if(!empty($result)) {
?>
<ul id="rodzaj-list">
<?php
foreach($result as $rodzaj) {
?>
<li onClick="selectRodzaj('<?php echo $rodzaj["rodzaj"]; ?>');"><?php echo $rodzaj["rodzaj"]; ?></li>
<?php } ?>
</ul>
<?php } } 
?>


