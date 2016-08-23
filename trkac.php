<?
include('header.php');
include('controller/Controller.php');
if(!isset($_GET['id']))exit();
$id=$_GET['id'];

$data=Controller::db_result("SELECT * FROM trkaci WHERE id=$id");

$trkac=$data[0];
foreach($data as $trkac){}
echo($trkac['ime']."<br>");
echo($trkac['godina']."<br>");

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
if(isset($data_nasip[0]))echo"PB: Nasip duga  ".$data_nasip[0]["vrijeme"]." -->".$data_nasip[0]["broj_kola"].". kolo ".$data_nasip[0]["date"]."<br>";
if(isset($data_maksimir[0]))echo"PB: Maksimir duga  ".$data_maksimir[0]["vrijeme"]." -->".$data_maksimir[0]["broj_kola"].". kolo ".$data_maksimir[0]["date"]."<br>";
if(isset($data_nasip_2[0]))echo"PB: Nasip kratka  ".$data_nasip_2[0]["vrijeme"]." -->".$data_nasip_2[0]["broj_kola"].". kolo ".$data_nasip_2[0]["date"]."<br>";
if(isset($data_maksimir_2[0]))echo"PB: Maksimir kratka  ".$data_maksimir_2[0]["vrijeme"]." -->".$data_maksimir_2[0]["broj_kola"].". kolo ".$data_maksimir_2[0]["date"]."<br>";
$data=Controller::db_result("SELECT * FROM rezultati_duga WHERE id_trkaca=$id");
$data2=Controller::db_result("SELECT * FROM rezultati_kratka WHERE id_trkaca=$id");
echo("Broj nastupa: ".(count($data)+count($data2))."<br>");


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
foreach($godine as $pod)
{
	$god=$pod["godina"];
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
}
/*---------Nasip-------------------*/
$br=1;//broj grafa
include("graf_gornji_dio.php");
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

/*--------Maksimir*/
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

echo"var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));";
echo"var chart2 = new google.visualization.LineChart(document.getElementById('curve_chart2'));";
echo"chart.draw(data, options);";
echo"chart2.draw(data2, options2);}</script>";


echo'<div id="curve_chart" style="width: 900px; height: 500px"></div><br>';
echo'<div id="curve_chart2" style="width: 900px; height: 500px"></div>';

include('footer.php');
?>
       
</html>

	