<?
include('header.php');
include('controller/Controller.php');
if(!isset($_GET['kolo']) || !isset($_GET['godina']))exit();
$kolo=$_GET['kolo'];
$godina=$_GET['godina'];
$trkaci=array();
$data=Controller::db_result("SELECT * FROM trkaci");
foreach($data as $podatak)
{
     $trkaci[$podatak["id"]]=$podatak["ime"];
}
$informacije=Controller::db_result("SELECT * FROM kolo_informacije  WHERE broj=$kolo AND godina=$godina");
echo($informacije[0]["text"]);
$rezultat=Controller::db_result("SELECT * FROM rezultati_duga  WHERE broj_kola=$kolo AND date=$godina ORDER BY vrijeme ASC");
echo"<table>";
echo'
    <tr>
		<td></td>
		<td>Prezime i ime</td>
		<td>Vrijeme</td>
		<td>Bodovi</td>
	</tr>
';
$broj=1;
foreach($rezultat as $podatak)
{
    if($podatak["id_trkaca"]==0){echo($podatak["vrijeme"]);continue;}
	echo"<tr>";
	echo"<td>$broj.</td>";
	echo"<td>";echo($trkaci[$podatak["id_trkaca"]]);echo"</td>";
	echo"<td>";echo($podatak["vrijeme"]);echo"</td>";
	echo"<td>";echo($podatak["bodovi"]);echo"</td>";
	echo"</tr>";
	++$broj;
}
echo"</table>";
include('footer.php');
?>