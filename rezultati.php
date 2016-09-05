<?
//include('header.php');
require_once('controller/Controller.php');
require_once('model/Model.php');
require_once('view/View.php');
if(!isset($_GET['kolo']) || !isset($_GET['godina']))exit();
$kolo=$_GET['kolo'];
$godina=$_GET['godina'];
$tip=isset($_GET['tip'])?'duga':'kratka';
$tip_2=isset($_GET['tip'])?'Duga':'Kratka';
$trkaci=array();
$data=Controller::db_result("SELECT * FROM trkaci");
foreach($data as $podatak)
{
     $trkaci[$podatak["id"]]=$podatak["ime"];
}
$informacije=Controller::db_result("SELECT * FROM kolo_informacije  WHERE broj=$kolo AND godina=$godina");
$rezultat=Controller::db_result("SELECT * FROM rezultati_".$tip."  WHERE broj_kola=$kolo AND date=$godina ORDER BY vrijeme ASC");
echo'<div style="margin-left:150px">';
View::print_headline($tip_2." <br>".$_GET['kolo'].".kolo, ".$_GET['godina']);
if(isset($informacije[0]["text"]))echo($informacije[0]["text"]);
if(count($rezultat)==0)
{
	echo"Nemam podatke o toj trci. :-(";
	return;
}
echo'<div><br><table style="margin-left:110px;">';
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
    if($podatak["id_trkaca"]==0)
	{
		/*
		 To nije dobro, ali ajde
		*/
		//echo($podatak["vrijeme"]);
		continue;
	}
	echo"<tr>";
	echo"<td>$broj.</td>";
	echo"<td>";echo($trkaci[$podatak["id_trkaca"]]);echo"</td>";
	echo"<td>";echo($podatak["vrijeme"]);echo"</td>";
	echo"<td>";echo($podatak["bodovi"]);echo"</td>";
	echo"</tr>";
	++$broj;
}
echo"</table>";
//include('footer.php');
?>