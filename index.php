<meta charset="UTF-8">
<head>
<link href="style.css" rel="stylesheet" type="text/css"  media="screen" />
 <?
 if(isset($_GET['vrijeme']) || isset($_GET['brojevi']))
	 echo'<script type="text/javascript" src="js/jq.js"></script>';
 ?>
 
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
{
	Controller::controll_user_interface();
	View::time_user_interface();
	//JQuery
}
else if(isset($_GET['brojevi']))
{
	Controller::controll_user_interface();
	echo'
	   <input type="number" name="broj" placeholder="261" id="broj" style="width:45%;height:40%;font-size:450%;"><br><br><br>
	   <button onclick="myFunction2()" style="height:10%;width:30%;font-size:300%;">Ušao</button>
	   <div id="usli"></div>
	';
}
else if(isset($_GET['glavni']))
{
	View::show_live_results();
}
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
		   <input type="hidden" name="tip" value="1">
		   <input type="hidden" name="kratka" value="2">
		</form>
		<br>
		<form action="prijave.php" method="GET">
		    <button class="p" name="klik" type="submit">Pregled prijava</button>
			<input type="hidden" name="type"  value="1">
		</form>
		';
}
else if(isset($_GET['duga']))
{
		Controller::controll_user_interface();
		View::print_headline("Prijava za dugu");
		if(isset($_GET['pretraga']))
		{
			echo('Odabir trkaca: <br>');
			View::ispis_trkaca($ime,2);
		}
		
		echo'Pretraga:<br>
		<form method="GET" action="index.php">
		   <input type="text" name="ime" placeholder="Ime"/>
		   <input type="submit" value="Pretraži" name="pretraga"/>
		   <input type="hidden" name="tip" value="2">
		   <input type="hidden" name="duga" value="2">
		</form>
		<br>
		<form action="prijave.php" method="GET">
		    <button class="p" name="klik" type="submit">Pregled prijava</button>
			<input type="hidden" name="type"  value="2">
		</form>
		';
}
else if(isset($_GET['utrka']))
{
	Controller::controll_user_interface();
	Controller::db_query("INSERT INTO `prijave` (`id`,`id_trkaca`,`tip`,`broj`) VALUES (NULL,'$runner_id','$tip','$bid_num');");
	echo'<script>alert("Uspješna prijava.");</script>';
	echo'<script>document.location="index.php";</script>';
}
else
{
	Controller::controll_user_interface();
	View::role_function();
}
?></div>
<script>
 function myFunction()
 {
 $.get( "vrijeme.php", function( data ) {
 // alert( "Data Loaded: " + data );
  document.getElementById('vrijeme').innerHTML=data;
});
 }
 function myFunction2()
 {
	 
	 var broj2=document.getElementById('broj').value;
	 $.get("brojevi.php?broj="+broj2,function(data){
		 var broj=document.getElementById('broj').value;
		 //alert(data);
		 document.getElementById('usli').innerHTML=data;
	 });
 }
 
 function myFunction3()
 {
	 $.get("vrijeme.php?erase=1",function(data){
		
		 document.getElementById('vrijeme').innerHTML=data;
	 });
 }
 </script>
</body><br><br>
<form><input type="submit" value="Povratak"></form>