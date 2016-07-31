<?
include('controller/Controller.php');
if(isset($_GET['kolo']))
{
	
	$godina=$_GET['godina'];
	$kolo=$_GET['kolo'];
	$informacije=$_GET['informacije'];
	Controller::db_query("INSERT INTO kolo_informacije VALUES ('', '$kolo', '$godina', '$informacije');");
	
}
?>