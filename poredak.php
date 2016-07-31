<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css" media="print">
  @page { size: landscape; }
</style>
<?
include('controller/Controller.php');
include('model/Model.php');
echo'<input type="button" onClick="window.print()" class="btn btn-primary " value="Isprintaj" >';
function cmp($a, $b)
{
	if(!isset($a->zbroj))print_r($a);
	if(!isset($b->zbroj))print_r($b);
	return ($a->zbroj < $b->zbroj);
}

if(!isset($_GET['godina']))exit();
$godina=$_GET['godina'];
$trkaci=array();
$data=Controller::db_result("SELECT * FROM trkaci");
$i=0;
foreach($data as $podatak)
{
     $trk=new Trkac($podatak["id"],$podatak["ime"],$podatak["spol"],$podatak["godina"]);
	 $trk->id=$podatak["id"];
	 $trk->ime=$podatak["ime"];
	 $trk->godina=$podatak["godina"];
	 $trk->spol=$podatak["spol"];
	 $trk->zbroj=0;
	 $trkaci[$podatak["id"]]=$trk;
	 
}
$rezultat=Controller::db_result("SELECT * FROM rezultati_duga  WHERE date=$godina");
/*
 * Postavljanje rezultat uz trkace
*/
foreach($rezultat as $podatak)
{
	//print_r($podatak);
	if($podatak["id_trkaca"]==0)continue;
	$trkaci[$podatak["id_trkaca"]]->bodovi[$podatak["broj_kola"]]=$podatak["bodovi"];
	
}
/*
* Određivanje zbroja za određene cikluse kroz ligu ( Nasip proljece, Nasip zime,Maksimir proljece i jesen)
*/
$model=new Model();
foreach($trkaci as $data)
{
    if($data->id==0)continue;
	$trkaci[$data->id]->zbroj=$data->dodaj_rezultat($data->bodovi,$data->bodovi2);
	$trkaci[$data->id]->kategorija=($data->spol).$model->odredi_kategoriju($_GET['godina'],$data->godina);
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
usort($trkaci, "cmp");
$redni_broj=1;
$poredak_kategorije=array("PO"=>"po");
foreach($trkaci as $podatak)
{
    //if($podatak["id_trkaca"]==0){echo($podatak["vrijeme"]);continue;}
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
		if($podatak->bodovi2[$i]==0 && isset($podatak->bodovi[$i]))echo'<td align=center style="background-color:gray">'.$pod.'</td>';
		else if($podatak->bodovi2[$i]!=0 && isset($podatak->bodovi[$i]))echo"<td align=center>$pod</td>";
		else echo"<td></td>";
		 
	}
	echo"<td align=center>";echo($podatak->zbroj);echo"</td>";
	echo"</tr>";
	++$redni_broj;
}
echo"</table>";
?>