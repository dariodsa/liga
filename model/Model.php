<?
include('./baza.php');

class Model
{
      public $kategorije;
	  public function __construct()
	  {
		  $this->kategorije=Controller::db_result("SELECT min_godina,max_godina,naziv FROM kategorije");
	  }
	  public function odredi_kategoriju($trenutna_godina,$godina_rodenja)
	  {
		  $starost=$trenutna_godina-$godina_rodenja;
		  foreach($this->kategorije as $data)
		  {
			  if($data["min_godina"]<=$starost && $data["max_godina"]>=$starost)return $data["naziv"];
		  }
		  return "NEMAKATEGORIJE";
	  }
	  public static function list_of_runners($ime,$type)
	  {
		$data=Controller::db_result_tray($ime);
		return $data;
	  }
	  public static function find_times($id)
	  {
		  $times=Controller::db_result("SELECT * FROM vremena");
		  $data=Controller::db_result("SELECT * FROM brojevi");
		  $i=0;
		  
		  //echo($id);
		  foreach($data as $data_pom)
		  {
			  //echo"<pre>";echo($data_pom["broj"]);echo"</pre>";
			  if($data_pom["broj"]==$id)
			  {
				  return $times[$i]["vremena"];
			  }
			  ++$i;
		  }
		  
		  return "##:##";
	  }
	  public static function get_prerace_stats()
	  {
		  $data_pom=Controller::db_result("SELECT id,spol FROM trkaci");
		  $runners=array();
		  $ans=array();
		  foreach($data_pom as $pom)
		  {
			  $runners[$pom["id"]]=$pom["spol"];
		  }
		  $ans["krz"]=0;
		  $ans["krm"]=0;
		  $ans["dum"]=0;
		  $ans["duz"]=0;
		  $register=Controller::db_result("SELECT tip,id_trkaca FROM prijave");
		  foreach($register as $reg_pom)
		  {
			  if(!isset($runners[$reg_pom["id_trkaca"]]))continue;
			  if($runners[$reg_pom["id_trkaca"]]=="Ž" && $reg_pom["tip"]==1)$ans["krz"]++;
			  if($runners[$reg_pom["id_trkaca"]]=="M" && $reg_pom["tip"]==1)$ans["krm"]++;
			  if($runners[$reg_pom["id_trkaca"]]=="Ž" && $reg_pom["tip"]!=1)$ans["duz"]++;
			  if($runners[$reg_pom["id_trkaca"]]=="M" && $reg_pom["tip"]!=1)$ans["dum"]++;
		  }
		  return $ans;
	  }
	  public static function model_the_results($tip)
	  {
		  $times=Controller::db_result("SELECT * FROM vremena");
		  $bid=Controller::db_result("SELECT * FROM brojevi");
		  $data=Controller::db_result("SELECT * FROM prijave WHERE tip='".$tip."'");
		  $runners=Controller::db_result("SELECT * FROM trkaci ORDER BY id");
		  $con=new Controller($data,$runners);

		  //Construct array which connect bid with runner_id
		  $mapa=array();
		  $i=0;
		  foreach($data as $data_pom)
		  {
			  $mapa[$data_pom["broj"]][0]=$data_pom["id_trkaca"];
		  }
		  foreach($bid as $bid_pom)
		  {
			  $mapa[$bid_pom["broj"]][1]=$times[$i++]["vremena"];
			  
		  }
		  echo"<table border=1>";
		  $i=0;
		  $poredak=1;
		  foreach($bid as $bid_pom)
		  {
			 if(isset($mapa[$bid_pom["broj"]][0]))
			 {
				 $runner=($con->find($mapa[$bid_pom["broj"]][0]));
				 $vrijeme=isset($mapa[$bid_pom["broj"]][1])?$mapa[$bid_pom["broj"]][1]:'';
				 echo"<tr><td>$poredak.</td>";
				 echo "<td>".$runner["ime"]."</td><td>".$vrijeme."</td></tr>";
				 
			 	 ++$poredak;
			 }
			 ++$i;
		  }
		  echo"</table>";
		  return;
	  }
	  
}
class Trkac
{
	public $id;
	public $godina;
	public $spol;
	public $ime;
	public $bodovi;
	public $bodovi2;
	public $nasip1;
	public $maksimir1;
	public $maksimir2;
	public $naspi2;
	public $zbroj;
	public $kategorija;
	public function __construct($id1=0,$ime1="",$spol1="",$godina1="")
	{
		$this->id=$id1;
		$this->godina=$godina1;
		$this->spol=$spol1;
		$this->ime=$ime1;
		$this->bodovi=array();
		$this->bodovi2=array();
		$this->nasip1=array();
		$this->maksimir1=array();
		$this->maksimir2=array();
		$this->naspi2=array();
		$this->zbroj=0;
		$this->kategorija=-1;
		$i=0;
		for($i=0;$i<30;++$i)$this->bodovi2[$i]=0;
	}
	
	public function dodaj_rezultat($bodovi,$bodovi2)
	  {
	      //1-8 Nasip1
		  //9-16 Maksimir1
		  //17-21 Maksimir2
		  //22-26 Nasip2
		
		  $nasip1=array();
		  $nasip2=array();
		  $maksimir1=array();
		  $maksimir2=array();
		  $nas1=0;
		  $mak1=0;
		  $nas2=0;
		  $mak2=0;
		  $pok=0;
		  $pok1=0;
		  $pok2=0;
		  $pok3=0;
		  $kolo=0;
		  //print_r($bodovi);
		  //return 0;
		  for($kolo=1;$kolo<=26;++$kolo)
		  {
			  $bodovi2[$kolo]=0;
			  if(!isset($bodovi[$kolo]))continue;
			  $bod=$bodovi[$kolo];
			  if($kolo<=8 && $kolo>=1)
			  {
				  $nasip1[$pok]=new Rezultat($bod,$kolo);
				  ++$pok;
			  }
			  else if($kolo<=16 && $kolo>=9)
			  {
				  $maksimir1[$pok1]=new Rezultat($bod,$kolo);
				  ++$pok1;
			  }
			  else if($kolo<=21 && $kolo>=17)
			  {
				  $maksimir2[$pok2]=new Rezultat($bod,$kolo);
				  ++$pok2;
			  }
			  else if($kolo<=26 && $kolo>=22)
			  {
				  $nasip2[$pok3]=new Rezultat($bod,$kolo);
				  ++$pok3;
			  }
		  }
		  usort($nasip1,array("Trkac", "cmp2"));
		  usort($nasip2,array("Trkac", "cmp2"));
		  usort($maksimir1,array("Trkac", "cmp2"));
		  usort($maksimir2,array("Trkac", "cmp2"));
		  //Nasip1
		  $i=0;
		  $broj=1;
		  
		  for($i=$pok-1;$i>=0;--$i)
		  {
			  if($broj>5)break;
			  $this->bodovi2[$nasip1[$i]->kolo]=1;
			  $nas1+=$nasip1[$i]->bod;
			  ++$broj;
		  }
		  //Maksimir1
		  $i=0;
		  $broj=1;
		  for($i=$pok1-1;$i>=0;--$i)
		  {
			  if($broj>5)break;
			  $this->bodovi2[$maksimir1[$i]->kolo]=1;
			  $mak1+=$maksimir1[$i]->bod;
			  ++$broj;
		  }
		  //Nasip2
		  $i=0;
		  $broj=1;
		  for($i=$pok3-1;$i>=0;--$i)
		  {
			  if($broj>3)break;
			  $this->bodovi2[$nasip2[$i]->kolo]=1;
			  $nas2+=$nasip2[$i]->bod;
			  ++$broj;
		  }
		  //Maksimir2
		  $i=0;
		  $broj=1;
		  for($i=$pok2-1;$i>=0;--$i)
		  {
			  
			  if($broj>3)break;
			  $this->bodovi2[$maksimir2[$i]->kolo]=1;
			  $mak2+=$maksimir2[$i]->bod;
			  ++$broj;
		  }
		 
	      return $nas1+$nas2+$mak1+$mak2;
	  }
	  public static function cmp2($a, $b)
	  {
		 return ($a->bod > $b->bod);
	  }
	
}
class Rezultat
{
	public $bod;
	public $kolo;
	public function __construct($_bod,$_kolo)
	{
		$this->bod=$_bod;
		$this->kolo=$_kolo;
	}
}
?>