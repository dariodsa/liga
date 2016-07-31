<meta charset="UTF-8">
<?
include('controller/Controller.php');
$data=Controller::db_result("SELECT * FROM trkaci ORDER BY ime");
$broj=1;
foreach($data as $pod)
{
	//print_r($pod);
	//echo("".$pod["id"].",".$pod["ime"].",".$pod["spol"].",".$pod["godina"]."\n");
	
	echo json_encode($pod);
}
?>