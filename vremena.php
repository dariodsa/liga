<?
require_once("View/view.php");
require_once("Model/model.php");
require_once("Controller/controller.php");

$data=Controller::db_result("SELECT * FROM vremena");
$size=count($data);
echo("Zadnja 4 vremena:<br>");
for($i=$size-1;$i>=0 && $size-5<$i;--$i)
{
	echo($data[$i]["broj"]);
	echo("<br>");
}
?>