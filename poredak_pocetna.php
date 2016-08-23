<?
include('header.php');
include('controller/Controller.php');

	$data=Controller::db_result("SELECT * FROM godine");
	$broj=1;
	//print_r($data);
	foreach($data as $pod)
	{
		echo"$broj. ".$pod["godina"]." <a href=poredak.php?godina=".$pod["godina"]."&tip=1>Duga</a>&nbsp;&nbsp;&nbsp;";
		echo"<a href=poredak.php?godina=".$pod["godina"]."&tip=2>Kratka</a><br>";
		++$broj;
		
	}
include('footer.php');
?>