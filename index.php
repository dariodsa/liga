<meta charset="UTF-8">
<head>
<link href="style.css" rel="stylesheet" type="text/css"  media="screen" />
</head>
<body>
 <div id="body">
<?
session_start();
require_once('controller/Controller.php');
require_once('model/Model.php');
require_once('view/View.php');
$duga=0;
$kratka=0;
foreach($_GET as $k=>$p)
{
	$$k=$p;
}
if(isset($_GET['prijava']))
{
	$data=Controller::db_result("SELECT * FROM korisnici WHERE username='$ime' AND password='$lozinka'");
	if(count($data)>0)
	{
		$_SESSION["ime"]=$ime;
		echo"<script>document.location='index.php?uloga=1';</script>";
	}
	else View::login_form();
}
else if(isset($_GET['uloga']) && $_GET['uloga']=='1')
{
	Controller::controll_user_interface();
	View::role_function();
    
}
else if(isset($_GET['vrijeme']))
{}
else if(isset($_GET['brojevi']))
{}
else if(isset($_GET['glavni']))
{}
else if(isset($_GET['kratka']))
{
		Controller::controll_user_interface();
		View::print_headline("Prijava za kratku");
		if(isset($_GET['pretraga']))
		{
			echo('Odabir trkaca: <br>');
			View::ispis_trkaca($ime,1);
		}
		
		echo'Pretraga:<br>
		<form method="GET" action="index.php">
		<input type="text" name="ime" placeholder="Ime"/>
		<input type="submit" value="Pretraži" name="pretraga"/>
		<input type="hidden" name="kratka" value='.$kratka.'>
		<input type="hidden" name="duga" value='.$duga.'>
		</form>
		';
}
else if(isset($_GET['utrka']))
{
	Controller::db_query("INSERT INTO `prijave` (`id`,`id_trkaca`,`tip`,`broj`) VALUES (NULL,'$runner_id','1','$bid_num');");
	echo'<script>document.location="index.php";</script>';
}
else
{
	Controller::controll_user_interface();
	View::role_function();
}
?></div>
</body>
