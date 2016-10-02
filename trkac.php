<?
error_reporting(0);
include('header.php');
include('controller/Controller.php');
if(!isset($_GET['id']))exit();
$id=$_GET['id'];

$data=Controller::db_result("SELECT * FROM trkaci WHERE id=$id");

$trkac=$data[0];

/*
Dohvati njegove PB i broj nastupa
*/
$data_nasip=Controller::db_result("SELECT * FROM rezultati_duga WHERE id_trkaca=$id AND ( (broj_kola>=1 AND broj_kola<=8) OR (broj_kola>=22)) ORDER BY vrijeme");
//print_r($data_nasip[0]);
$data_maksimir=Controller::db_result("SELECT * FROM rezultati_duga WHERE id_trkaca=$id AND ( (broj_kola>=9 AND broj_kola<=21)) ORDER BY vrijeme");

$data_nasip_2=Controller::db_result("SELECT * FROM rezultati_kratka WHERE id_trkaca=$id AND ( (broj_kola>=1 AND broj_kola<=8) OR (broj_kola>=22)) ORDER BY vrijeme");
//print_r($data_nasip[0]);
$data_maksimir_2=Controller::db_result("SELECT * FROM rezultati_kratka WHERE id_trkaca=$id AND ( (broj_kola>=9 AND broj_kola<=21)) ORDER BY vrijeme");
//print_r($data_maksimir[0]);
$nasip_duga="";
$nasip_kratka="";
$mak_kratka="";
$mak_duga="";
if(isset($data_nasip[0]))$nasip_duga=$data_nasip[0]["vrijeme"]." <br>".$data_nasip[0]["broj_kola"].". kolo ".$data_nasip[0]["date"].".<br>";
if(isset($data_maksimir[0]))$mak_duga=$data_maksimir[0]["vrijeme"]." <br>".$data_maksimir[0]["broj_kola"].". kolo ".$data_maksimir[0]["date"].".<br>";
if(isset($data_nasip_2[0]))$nasip_kratka=$data_nasip_2[0]["vrijeme"]." <br>".$data_nasip_2[0]["broj_kola"].". kolo ".$data_nasip_2[0]["date"].".<br>";
if(isset($data_maksimir_2[0]))$mak_kratka=$data_maksimir_2[0]["vrijeme"]." <br>".$data_maksimir_2[0]["broj_kola"].". kolo ".$data_maksimir_2[0]["date"].".<br>";
$data=Controller::db_result("SELECT * FROM rezultati_duga WHERE id_trkaca=$id");
$data2=Controller::db_result("SELECT * FROM rezultati_kratka WHERE id_trkaca=$id");
$broj_nastupa=(count($data)+count($data2));


$data=Controller::db_result("SELECT * FROM rezultati_duga WHERE id_trkaca=$id ORDER BY vrijeme");
foreach($data as $podatak)
{
     //echo($podatak["vrijeme"]." ".$podatak["bodovi"]."<br>");
}
/*
Potrebna obrada rezultata po duga naspip maks proljece i jesen best
*/

$godine=Controller::db_result("SELECT * FROM godine ORDER BY godina");
$best_rezultati_nasip=array();
$best_rezultati_maksimir=array();
$best_rezultati_nasip_k=array();
$best_rezultati_maksimir_k=array();
foreach($godine as $pod)
{
	$god=$pod["godina"];
	//DUGA ----------------------------------------
	$data2=Controller::db_result("SELECT * FROM rezultati_duga WHERE date=$god AND broj_kola>=1 AND broj_kola<=8 AND id_trkaca=$id ORDER BY vrijeme");
	if(isset($data2[0]))
		array_push($best_rezultati_nasip,$data2[0]["bodovi"],$god." - Proljece");
	$data2=Controller::db_result("SELECT * FROM rezultati_duga WHERE date=$god AND broj_kola>=22 AND broj_kola<=26 AND id_trkaca=$id ORDER BY vrijeme");
	if(isset($data2[0]))
		array_push($best_rezultati_nasip,$data2[0]["bodovi"],$god." - Jesen");
	
	$data2=Controller::db_result("SELECT * FROM rezultati_duga WHERE date=$god AND broj_kola>=9 AND broj_kola<=16 AND id_trkaca=$id ORDER BY vrijeme");
	if(isset($data2[0]))
		array_push($best_rezultati_maksimir,$data2[0]["bodovi"],$god." - Proljece");
	$data2=Controller::db_result("SELECT * FROM rezultati_duga WHERE date=$god AND broj_kola>=17 AND broj_kola<=21 AND id_trkaca=$id ORDER BY vrijeme");
	if(isset($data2[0]))
		array_push($best_rezultati_maksimir,$data2[0]["bodovi"],$god." - Jesen");
	//KRATKA ----------------------------------------
	$data2=Controller::db_result("SELECT * FROM rezultati_kratka WHERE date=$god AND broj_kola>=1 AND broj_kola<=8 AND id_trkaca=$id ORDER BY vrijeme");
	if(isset($data2[0]))
		array_push($best_rezultati_nasip_k,$data2[0]["bodovi"],$god." - Proljece");
	$data2=Controller::db_result("SELECT * FROM rezultati_kratka WHERE date=$god AND broj_kola>=22 AND broj_kola<=26 AND id_trkaca=$id ORDER BY vrijeme");
	if(isset($data2[0]))
		array_push($best_rezultati_nasip_k,$data2[0]["bodovi"],$god." - Jesen");
	
	$data2=Controller::db_result("SELECT * FROM rezultati_kratka WHERE date=$god AND broj_kola>=9 AND broj_kola<=16 AND id_trkaca=$id ORDER BY vrijeme");
	if(isset($data2[0]))
		array_push($best_rezultati_maksimir_k,$data2[0]["bodovi"],$god." - Proljece");
	$data2=Controller::db_result("SELECT * FROM rezultati_kratka WHERE date=$god AND broj_kola>=17 AND broj_kola<=21 AND id_trkaca=$id ORDER BY vrijeme");
	if(isset($data2[0]))
		array_push($best_rezultati_maksimir_k,$data2[0]["bodovi"],$god." - Jesen");
}
$spol_slika=$trkac['spol'][0]=='M'?"<img src=slike/mus.png>":"<img src=slike/zen.png>";

/*Korekcija slike profila*/

$data = getimagesize("slike_trkaca/".$id.".png");
$visina_slike=($data[1]/$data[0])*260;


echo"<br><table border=1 name=tablica id=table1  >
		<tr>
		  <td rowspan=2 colspan=2>
		     <img src=slike_trkaca/".$id.".png height=".$visina_slike." width=260";
			 echo'><br>';
			 echo"
			 <a href=slika.php?id=".$id." align=center>Postavi sliku</a>
		  </td>
		  <td>PB Nasip kratka:</td>
		  <td>".$nasip_kratka."</td>
		</tr>
		<tr>
		  <td>PB Maksimir kratka:</td>
		  <td>".$mak_kratka."</td>
		</tr>
		<tr>
		   <td>Ime i prezime:</td>
		   <td>".$trkac['ime']."</td>
		   <td>PB Nasip duga:</td>
		   <td>".$nasip_duga."</td>
		</tr>
		<tr>
		   <td>Godina rođenja:</td>
		   <td>".$trkac['godina']."</td>
		   <td>PB Maksimir duga:</td>
		   <td>".$mak_duga."</td>
		</tr>
		<tr>
		   <td>Spol:</td>
		   <td>".$spol_slika."</td>
		   <td>Broj nastupa:</td>
		   <td>".$broj_nastupa."</td>
		</tr>
		<tr >
		<td colspan=4 >
";

/*---------Nasip-------------------*/
if(count($best_rezultati_maksimir)>0 || count($best_rezultati_maksimir_k)>0 || count($best_rezultati_nasip)>0 || count($best_rezultati_nasip_k)>0)include("graf_gornji_dio.php");
if(count($best_rezultati_nasip_k)>0)
{
	$br=3;//broj grafa
	//include("graf_gornji_dio.php");
	echo'var data3 = google.visualization.arrayToDataTable([';
	echo"['Godina', 'Nasip']";
	$i=0;
	for($i=0;$i<count($best_rezultati_nasip_k);$i+=2)
	{
		if(true)echo(',');
		echo("['".$best_rezultati_nasip_k[$i+1]."',".$best_rezultati_nasip_k[$i]."]");
	}
	echo"]);

			var options3 = {
			  title: 'Nasip - Kratka',
			  curveType: 'function',
			  legend: { position: 'bottom' }
			};
	";
}
/*--------Maksimir*/
if(count($best_rezultati_maksimir_k)>0)
{
	$br=4;//broj grafa
	
	echo'var data4 = google.visualization.arrayToDataTable([';
	echo"['Godina', 'Maksimir']";
	$i=0;
	for($i=0;$i<count($best_rezultati_maksimir_k);$i+=2)
	{
		if(true)echo(',');
		echo("['".$best_rezultati_maksimir_k[$i+1]."',".$best_rezultati_maksimir_k[$i]."]");
	}
	echo"]);

			var options4 = {
			  title: 'Maksimir - Kratka',
			  curveType: 'function',
			  legend: { position: 'bottom' }
			};
	";
}





/*---------Nasip-------------------*/
if(count($best_rezultati_nasip)>0)
{
	$br=1;//broj grafa
	//include("graf_gornji_dio.php");
	echo'var data = google.visualization.arrayToDataTable([';
	echo"['Godina', 'Nasip']";
	$i=0;
	for($i=0;$i<count($best_rezultati_nasip);$i+=2)
	{
		if(true)echo(',');
		echo("['".$best_rezultati_nasip[$i+1]."',".$best_rezultati_nasip[$i]."]");
	}
	echo"]);

			var options = {
			  title: 'Nasip - Duga',
			  curveType: 'function',
			  legend: { position: 'bottom' }
			};
	";
}
/*--------Maksimir*/
if(count($best_rezultati_maksimir)>0)
{
	$br=2;//broj grafa
	echo'var data2 = google.visualization.arrayToDataTable([';
	echo"['Godina', 'Maksimir']";
	$i=0;
	for($i=0;$i<count($best_rezultati_maksimir);$i+=2)
	{
		if(true)echo(',');
		echo("['".$best_rezultati_maksimir[$i+1]."',".$best_rezultati_maksimir[$i]."]");
	}
	echo"]);

			var options2 = {
			  title: 'Maksimir - Duga',
			  curveType: 'function',
			  legend: { position: 'bottom' }
			};
	";
}
if(count($best_rezultati_nasip)>0)
{
	echo"var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));";
	echo"chart.draw(data, options);";
}
if(count($best_rezultati_maksimir)>0)
{
	echo"var chart2 = new google.visualization.LineChart(document.getElementById('curve_chart2'));";
	echo"chart2.draw(data2, options2);";
}
if(count($best_rezultati_nasip_k)>0)
{
	echo"var chart3 = new google.visualization.LineChart(document.getElementById('curve_chart3'));";
	echo"chart3.draw(data3, options3);";
}
if(count($best_rezultati_maksimir_k)>0)
{
	echo"var chart4 = new google.visualization.LineChart(document.getElementById('curve_chart4'));";
	echo"chart4.draw(data4, options4);";
}

echo"}</script>";
if(count($best_rezultati_nasip)>0)echo'<div id="curve_chart" style="width: 900px; height: 500px"></div><br>';
if(count($best_rezultati_maksimir)>0)echo'<div id="curve_chart2" style="width: 900px; height: 500px"></div>';
if(count($best_rezultati_nasip_k)>0)echo'<div id="curve_chart3" style="width: 900px; height: 500px"></div><br>';
if(count($best_rezultati_maksimir_k)>0)echo'<div id="curve_chart4" style="width: 900px; height: 500px"></div><br>';

echo'</td></tr></table>';
include('footer.php');
?>
       
</html>

	