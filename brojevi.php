<?
require_once("View/view.php");
require_once("Model/model.php");
require_once("Controller/controller.php");
$broj=$_GET['broj'];


$bid=Controller::db_result("SELECT * FROM prijave WHERE broj='$broj'");
if(count($bid)==0)
{	echo("Broj ".$broj." nije prijavljen.");
    die();
}

$bid=Controller::db_result("SELECT * FROM brojevi WHERE broj='$broj'");
if(count($bid)>0)
{	echo("Broj ".$broj." je vec usao u cilj.");
    die();
}

Controller::db_query("INSERT INTO brojevi (ID,broj) VALUES ('','$broj')");
$data=Controller::db_result("SELECT * FROM brojevi");
$size=count($data);
echo("Zadnji 4 koji su ušli u cilj:<br>");
for($i=$size-1;$i>=0 && $size-5<$i;--$i)
{
	echo($data[$i]["broj"]);
	echo("<br>");
}
?>