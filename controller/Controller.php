<?
include('./baza.php');

class Controller
{
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
		     return 0;
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