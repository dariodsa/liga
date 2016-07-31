<?
include('header.php');
include('controller/Controller.php');

	$data=Controller::db_result("SELECT * FROM godine");
	$broj=1;
	//print_r($data);
	foreach($data as $pod)
	{
		echo"$broj. <a href=poredak.php?godina=".$pod["godina"].">".$pod["godina"]."</a><br>";
		++$broj;
		
	}
include('footer.php');
?>