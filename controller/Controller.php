<?
include('./baza.php');

class Controller
{
      private $data;
	  private $runners;
	  public function Controller($data,$runners)
	  {
		  $this->data=$data;
		  $this->runners=$runners;
	  }
	  public function find($id)
	  {
		  $low=0;
		  $midd=0;
		  $high=count($this->runners)-1;
		  while($low<=$high)
		  {
			  $midd=($low+$high)/2;
			  if($this->runners[$midd]["id"]==$id)return $this->runners[$midd];
			  else if($this->runners[$midd]["id"]>$id)$high=$midd-1;
			  else $low=$midd+1;
		  }
		  return $this->runners[$low];
	  }
	  public static function go_to($link)
	  {
		  echo"<script>document.location='$link';</script>";
	  }
	  public static function points_long($vrijeme)
	  {
		  //(1520/G27)^2*100
		  sscanf($vrijeme, "%d:%d",$minutes, $seconds);
		  
		  if($minutes*60+$seconds==0)
			  $ukupno=0;
		  else 
			  $ukupno=1520/($minutes*60+$seconds);
		  
		  return round((($ukupno*$ukupno)*100),2);
	  }
	  public static function db_result($query)
	  {
	      $rezultat=mysql_query($query);
		  $data=array();
		  if($rezultat)
		  {
		    $i=0;
			while($row=mysql_fetch_assoc($rezultat))
			{
			  $data[$i]=$row;
				++$i;
			  if($sve=false)return 1;
			}
			$len=mysql_num_rows($rezultat);
	      }
	      else echo'Error:<br/>&nbsp; '.mysql_error().'';
	      if($sve=false)return 0;
	      return $data;
	  }
	  public static function db_query($query)
	  {
	      $rezultat=mysql_query($query);
		  if($rezultat)
		  {
		     return 1;
		  }
		  else 
		  {
		     echo("Error: ".mysql_error());
			 die();
		     return 0;
		  }
	  }
	  public static function controll_user_interface()
	  {
		  if(!isset($_SESSION["ime"]))
		  {
			  View::login_form();
			  die();
		  }
		  $ime=$_SESSION["ime"];
		  $data=Controller::db_result("SELECT * FROM korisnici WHERE username='$ime'");
		  if(count($data)==0)
		  {
			  View::login_form();
			  die();
		  }
      }
	  public static function db_result_tray($query)
	  {
	      $rezultat=mysql_query("SELECT * FROM trkaci ORDER BY ime");
		  $data=array();
		  $ans=array();
		  if($rezultat)
		  {
		    $i=0;
			while($row=mysql_fetch_assoc($rezultat))
			{
			  if((strlen(strstr(strtolower($row["ime"]),strtolower($query)))>0))
			  {
				  $data[$i]=$row;
				++$i;
			  }
			  if($sve=false)return 1;
			}
			$len=mysql_num_rows($rezultat);
	      }
	      else echo'Error:<br/>&nbsp; '.mysql_error().'';
	      if($sve=false)return 0;
	      return $data;
	  }
}
?>