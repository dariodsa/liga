<?
require_once("view/View.php");
require_once("model/Model.php");
require_once("controller/Controller.php");
if(isset($_GET['erase']))
{
	Controller::db_query("DELETE FROM vremena WHERE 1");
	Controller::db_query("DELETE FROM utrka WHERE 1");
	echo("Početno vrijeme je resetirano.");
	die();
}
$data=Controller::db_result("SELECT * FROM utrka ORDER BY VRIJEME");
if(count($data)==0)
{	
	echo' Vrijeme je krenulo.';
	Controller::db_query("INSERT INTO utrka VALUES ('',now(),'0');");
}
else
{
	$vrijeme=strtotime(date("Y-m-d H:i:s"));
	$pocetno=strtotime($data[0]["vrijeme"]);
	$razlika=$vrijeme-$pocetno;
	$razlika=View::time_format($razlika);
	//echo($razlika);
	Controller::db_query("INSERT INTO vremena VALUES ('','$razlika');");
}

$data=Controller::db_result("SELECT * FROM vremena");
$size=count($data);
echo("<br>Zadnja 4 vremena:<br>");
for($i=$size-1;$i>=0 && $size-5<$i;--$i)
{
	echo($data[$i]["vremena"]);
	echo("<br>");
}
?>