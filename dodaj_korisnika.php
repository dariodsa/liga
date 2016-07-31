<?
include('controller/Controller.php');
if(isset($_GET['ime']))
{
	$data=Controller::db_result("SELECT * FROM trkaci WHERE IME='".$_GET['ime']."' AND GODINA='".$_GET['godina']."'");
	echo"<pre>";
	print_r($data);
	echo"</pre>a";
	echo($data[0]["ime"]);
	$ime=$_GET['ime'];
	$spol=$_GET['spol'];
	$godina=$_GET['godina'];
	echo(count($data));
	echo($data);
	if(count($data)==0)
	{
	  Controller::db_query("INSERT INTO trkaci VALUES ('', '$ime', '$spol', '$godina');");
	}
}
?>