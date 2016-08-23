<?
include('controller/Controller.php');
if(isset($_GET['ime']))
{
	echo"SELECT * FROM trkaci WHERE IME='".$_GET['ime']."";
	echo(html_entity_decode($_GET['ime']));
	
	$data=Controller::db_result("SELECT * FROM trkaci WHERE IME='".$_GET['ime']."' AND (spol='Ž' OR spol='M') ORDER BY godina ASC;");
	$id_trkaca=0;
	$id_trkaca=$data[0]["id"];//$_GET['id_trkaca'];
	echo($id_trkaca);
	$broj_kola=$_GET['broj_kola'];
	$vrijeme=$_GET['vrijeme'];
	$bodovi=$_GET['bodovi'];
	$date=$_GET['date'];
	echo(count($data));
	echo($data);
	if(true)
	{
	  Controller::db_query("INSERT INTO rezultati_kratka VALUES ('', '$id_trkaca', '$broj_kola', '$vrijeme','$bodovi','$date');");
	}
}
?>