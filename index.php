<meta charset="UTF-8">
<?
require_once('controller/Controller.php');
require_once('model/Model.php');
$duga=0;
$kratka=0;
foreach($_GET as $k=>$p)
{
		$$k=$p;
}
if(isset($_GET['prijava']))
{
	print_r($_GET);
	foreach($_GET as $k=>$p)
	{
		$$k=$p;
	}
	//provjera i autentifikacija
	echo"<script>document.location='index.php?uloga=1';</script>";
}
else if(isset($_GET['uloga']) && $_GET['uloga']=='1')
{
	echo("Odabir uloga");
	echo'
	   <form action="index.php" method="GET">
	       <input type="submit" name="vrijeme" value="Mjerim vrijeme">
		   <input type="submit" name="brojevi" value="Bilježim brojeve kako ulaze">
		   <input type="submit" name="glavni" value="Ispravljam moguće pogreške i nadgledam">
		   <input type="submit" name="kratka" value="Prijave_kratke">
		   <input type="submit" name="duga" value="Prijave_duge">
	   </form>
	';
}
else if(isset($_GET['vrijeme']))
{}
else if(isset($_GET['brojevi']))
{}
else if(isset($_GET['glavni']))
{}
else if((isset($_GET['kratka']) && $_GET['kratka']!='0') || (isset($_GET['duga']) && $_GET['duga']!='0'))
{
		
		if(isset($pretraga))
		{
			Model::ispis_trkaca($ime);
		}
		echo('Odabir trkaca');
		echo'
		<form method="GET" action="index.php">
		<input type="text" name="ime" placeholder="Ime"/>
		<input type="submit" value="Pretraži" name="pretraga"/>
		<input type="hidden" name="kratka" value='.$kratka.'>
		<input type="hidden" name="duga" value='.$duga.'>
		</form>
		';
}
else{echo'
<meta charset="UTF-8">
<form action="index.php" method="GET">
<table >
	<tr>
		<td>Korisničko ime: </td>
		<td><input type="text" placeholder="Ime" name="ime"/></td>
	</tr>
	<tr>
		<td>Lozinka:</td>
		<td><input type="password" placeholder="Lozinka" name="lozinka"/></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value="Prijava"></td>
	</tr>
	<input type="hidden" value="nika" name="prijava"/>
</table>
</form>';}
?>