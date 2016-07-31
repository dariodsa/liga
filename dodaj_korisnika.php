<meta charset="UTF-8">
<?
include('controller/Controller.php');
if(isset($_GET['ime']))
{
	$data=Controller::db_result("SELECT * FROM trkaci WHERE IME='".$_GET['ime']."' AND GODINA='".$_GET['godina']."'");
	echo"<pre>";
	print_r($data);
	echo"</pre>a";
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
}
else if(isset($_GET['dod']))
{
	echo'
      <form method="GET">
	       <table>
			  <tr>
				<td>Ime i prezime</td>
				<td><input type="text" name="ime" placeholder="Ime i prezime"></td>
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
			     <td></td>
				 <td align="right"><input type="submit" value="Dodaj" ></td>
			  </tr>
		   </table>
	  </form>
	';
}
?>