<?
include('header.php');
include('controller/Controller.php');
if(!isset($_GET['ime']))echo'
    <div style="margin-left:40px;">
	<form action="trazi_trkace.php" method="GET">
		<input type="text" name="ime" style="width:270px;">
			<br><br>
		<input value="Traži" type="submit">
	</form>
	</div>
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