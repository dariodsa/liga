<meta charset="UTF-8">
<?
include('controller/Controller.php');
if(isset($_GET['ime']))
{
	$data=Controller::db_result("SELECT * FROM trkaci WHERE IME='".$_GET['ime']."' AND GODINA='".$_GET['godina']."'");
	echo"<pre>";
	print_r($data);
	echo"</pre>";
	echo($data[0]["ime"]);
	$ime=$_GET['ime'];
	$spol=$_GET['spol'];
	$godina=$_GET['godina'];
	echo(count($data));
	echo($data);
	if(count($data)==0)
	{
	  Controller::db_query("INSERT INTO trkaci VALUES ('', '$ime', '$spol', '$godina');");
	}
	if(isset($_GET['broj']) && isset($_GET['type']))
	{
		$type=$_GET['type'];
		$broj=$_GET['broj'];
		$data_pom=Controller::db_result("SELECT * FROM trkaci WHERE ime='$ime' AND spol='$spol' AND godina='$godina'");
		$trkac_id=$data_pom[0]["id"];
		Controller::db_query("INSERT INTO prijave VALUES ('', '$trkac_id', '$type', '$broj');");
		echo"<script>document.location='index.php';</script>";
	}
}
else if(isset($_GET['dod']))
{
	echo'
      <form method="GET">
	       <table>
			  <tr>
				<td>Prezime i ime</td>
				<td><input type="text" name="ime" placeholder="Prezime i ime"></td>
			  </tr>
			  <tr>
				<td>Spol</td>
				<td>
				   <select name="spol">
				       <option value="M">M</option>
					   <option value="Ž">Ž</option>
					</select>
				</td>
			  </tr>
			  <tr>
			    <td>Godina rođenja</td>
				<td><input type="text" name="godina" placeholder="1987"></td>
			  </tr>
			  <tr>
				<td>Startni broj</td>
				<td><input type="text" name="broj" placeholder="261"></td>
			  </tr>
			  <tr>
			     <td></td>
				 <td align="right"><input type="submit" value="Dodaj" ></td>
			  </tr>
		   </table>
		   <input type="hidden" value='.$_GET["type"].' name="type">
	  </form>
	';
}
?>