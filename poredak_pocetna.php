<?
include('header.php');
include('controller/Controller.php');

	$data=Controller::db_result("SELECT * FROM godine");
	$broj=1;
	//print_r($data);
	foreach($data as $pod)
	{
		echo"".$pod["godina"].". <a href=poredak.php?godina=".$pod["godina"]."&tip=1>Duga</a>&nbsp;&nbsp;&nbsp;";
		echo"<a href=poredak.php?godina=".$pod["godina"]."&tip=2>Kratka</a><br>";
		++$broj;
		
	}
	echo"<br><a href=poredak_top_list.php?tip=1>Best of Nasip</a><br>";
	echo"<br><a  href=poredak_top_list.php?tip=2>Best of Maksimir</a><br>";
	include('footer.php');
?>