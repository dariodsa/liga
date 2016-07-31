<?
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
if(isset($_GET['uloga']) && $_GET['uloga']=='1')
{
	echo("Odabir uloga");
	echo'
	   <form action="index.php" method="GET">
	       <input type="submit" name="vrijeme" value="Mjerim vrijeme">
		   <input type="submit" name="brojevi" value="Bilježim brojeve kako ulaze">
		   <input type="submit" name="glavni" value="Ispravljam moguće pogreške i nadgledam">
		   <input type="submit" name="kratka" value="Prijave kratke">
		   <input type="submit" name="duga" value="Prijave duge">
	   </form>
	';
}
if(isset($_GET['vrijeme']))
{}
if(isset($_GET['brojevi']))
{}
if(isset($_GET['glavni']))
{}
if(isset($_GET['kratka']) || isset($_GET['duga']))
{
		echo("jkl");
}
?>
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
</form>