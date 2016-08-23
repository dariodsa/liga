<?
include('header.php');
include('controller/Controller.php');
if(!isset($_GET['ime']))echo'
    <form action="trazi_trkace.php" method="GET">
		<input type="text" name="ime">
		
		<input value="Traži" type="submit">
	</form>
	';
else
{
	$data=Controller::db_result("SELECT ime,id,godina FROM trkaci ORDER BY ime");
	$broj=1;
	foreach($data as $pod)
	{
		if((strlen(strstr(strtolower($pod["ime"]),strtolower($_GET['ime'])))>0))
		{
			echo"$broj. <a href=trkac.php?id=".$pod["id"].">".$pod["ime"]."(".$pod["godina"].")</a><br>";
			++$broj;
		}
	}
}
include('footer.php');
?>