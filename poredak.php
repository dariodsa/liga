<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css" media="print">
  @page { size: landscape; }
</style>
<?
include('controller/Controller.php');
include('model/Model.php');
include('view/View.php');
echo'<input type="button" onClick="window.print()" value="Isprintaj" >';

function cmp($a, $b)
{
	if(!isset($a->zbroj))print_r($a);
	if(!isset($b->zbroj))print_r($b);
	return ($a->zbroj < $b->zbroj);
}

if(!isset($_GET['godina']))exit();
$godina=$_GET['godina'];
$trkaci=array();
if($_GET['tip']=='1')$data=Controller::db_result("SELECT trkaci.*, count(*) as broj_rezultata
FROM rezultati_duga
INNER JOIN trkaci ON trkaci.id=rezultati_duga.id_trkaca
group by trkaci.id
order by trkaci.ime");
else $data=Controller::db_result("SELECT trkaci.*, count(*) as broj_rezultata
FROM rezultati_kratka
INNER JOIN trkaci ON trkaci.id=rezultati_kratka.id_trkaca
group by trkaci.id
order by trkaci.ime");
$i=0;
foreach($data as $podatak)
{
     //print_r($podatak);
	 $trk=new Trkac($podatak["id"],$podatak["ime"],$podatak["spol"],$podatak["godina"]);
	 /*$trk->id=$podatak["id"];
	 $trk->ime=$podatak["ime"];
	 $trk->godina=$podatak["godina"];
	 $trk->spol=$podatak["spol"];
	 $trk->zbroj=0;*/
	 $trkaci[$podatak["id"]]=$trk;
	 
}
$tip=$_GET['tip'];
echo"<center>";
if($tip==2)View::print_headline("Kratka staza");
else View::print_headline("Duga staza");
echo"</center>";
if($tip=='1')$tip="duga";
else $tip="kratka";
$rezultat=Controller::db_result("SELECT id,id_trkaca,broj_kola,bodovi FROM rezultati_$tip  WHERE date=$godina AND id_trkaca!='0'");
//echo(count($rezultat));
/*
 * Postavljanje rezultat uz trkace
*/
foreach($rezultat as $podatak)
{
	//echo"<pre>";print_r($podatak);echo"</pre>";
	$trkaci[$podatak["id_trkaca"]]->bodovi[$podatak["broj_kola"]]=$podatak["bodovi"];
}
/*
* Određivanje zbroja za određene cikluse kroz ligu ( Nasip proljece, Nasip zime,Maksimir proljece i jesen)
*/
$model=new Model();
foreach($trkaci as $data)
{
    //echo"<pre>";print_r($data);echo"</pre>";
	//if(isset($data->zbroj)==false)continue;
	$trkaci[$data->id]->zbroj=$data->dodaj_rezultat($data->bodovi,$data->bodovi2);
	$trkaci[$data->id]->kategorija=($data->spol).$model->odredi_kategoriju($_GET['godina'],$data->godina);
}

/*
Kreiram pomocno polje za sortiranje, za optimizaciju
*/
$polje_id=array();
foreach($trkaci as $data)
{
	$t=new Trkac();
	$t->zbroj=$data->zbroj;
	$t->id=$data->id;
	$polje_id[$data->id]=$t;
}

echo'<table border="1">';
echo'
    <tr>
	   <td colspan="2"></td>
	   <td colspan="2">Kategorija</td>
	   <td colspan="8" align=center>Sava (proljeće)</td>
	   <td colspan="8" align=center>Maksimir (proljeće)</td>
	   <td colspan="5">Maksimir (jesen)</td>
	   <td colspan="5">Nasip (jesen)</td>
	   <td >Ukupno</td>
	</tr>
	<tr>
	   <td colspan="2"></td>
	   <td colspan="2"></td>
	   <td>1.</td><td>2.</td><td>3.</td><td>4.</td><td>5.</td><td>6.</td><td>7.</td><td>8.</td><td>9.</td><td>10.</td>
	   <td>11.</td><td>12.</td><td>13.</td><td>14.</td><td>15.</td><td>16.</td><td>17.</td><td>18.</td><td>19.</td><td>20.</td><td>21.</td><td>22.</td><td>23.</td><td>24.</td>
	   <td>25.</td>
	   <td>26.</td>
	   <td></td>
	</tr>
';
usort($polje_id, "cmp");
$redni_broj=1;
$poredak_kategorije=array("PO"=>"po");
foreach($polje_id as $podatak_pom)
{
    //if($podatak["id_trkaca"]==0){echo($podatak["vrijeme"]);continue;}
	$podatak=$trkaci[$podatak_pom->id];
	if($podatak->zbroj==0)continue;
	if(!isset($podatak_kategorije[(string)$podatak->kategorija]))$podatak_kategorije[(string)$podatak->kategorija]=0;
	
	echo"<tr>";
	echo"<td align=center>";echo($redni_broj);echo".</td>";
	echo"<td align=center><a href=trkac.php?id=$podatak->id>";echo($podatak->ime);echo"</a></td>";
	echo"<td align=center>";echo($podatak->kategorija);echo"</td>";
	echo"<td align=center>";echo(($podatak_kategorije[(string)$podatak->kategorija]+1));echo".</td>";
	$podatak_kategorije[(string)$podatak->kategorija]++;
	$i=0;
	for($i=1;$i<=26;++$i)
	{
		if(!isset($podatak->bodovi[$i]))$pod=""; //echo"<td align=center>$pod";echo"</td>";
		else $pod=$podatak->bodovi[$i];
		$pod=round($pod,2);
		if($podatak->bodovi2[$i]==0 && isset($podatak->bodovi[$i]))echo'<td align=center ><s>'.$pod.'</s></td>';
		else if($podatak->bodovi2[$i]!=0 && isset($podatak->bodovi[$i]))echo"<td align=center>$pod</td>";
		else echo"<td></td>";
		 
	}
	echo"<td align=center>";echo(round($podatak->zbroj,3));echo"</td>";
	echo"</tr>";
	++$redni_broj;
}
echo"</table>";
?>