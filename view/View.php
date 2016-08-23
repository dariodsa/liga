<meta charset="UTF-8">
<?
class View 
{
     public static function login_form()
	 {
		 echo'
			<meta charset="UTF-8">
			<form action="index.php" method="GET">
			<table>
				<tr>
					<td>Korisničko ime: </td>
					<td><input type="text" placeholder="Ime" name="ime"/></td>
				</tr>
				<tr>
					<td>Lozinka:</td>
					<td><input type="password" placeholder="Lozinka" name="lozinka" size="35"/></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Prijava"></td>
				</tr>
				<input type="hidden" value="nika" name="prijava"/>
			</table>
			</form>';
	 }
	 public static function role_function()
	 {
		
		 echo'
		 <form action="index.php" method="GET">
		   <table height="100%" width="100%">
		     <tr>
		       <td align="center"><button type="submit" name="kratka" value="Prijave_kratke" id="button"> Prijava kratka</td>
			   <td align="center"><button type="submit" name="duga" value="Prijave_duge" id="button">Prijava duga</td>
			 </tr>
			 <tr>
			   <td align="center"><button type="submit" name="vrijeme" value="Mjerim vrijeme" id="button">Mjerim vrijeme</td>
			   <td align="center"><button type="submit" name="brojevi" value="Bilježim brojeve kako ulaze" id="button">Bilježim brojeve kako ulaze</td>
			 </tr>
			 <tr>
  			  <td colspan="2" align="center"><button type="submit" name="glavni" value="Ispravljam moguće pogreške i nadgledam" id="button">Ispravljam moguće pogreške i nadgledam</td>
			 </tr>
			 </table>  
		   </form>
		 ';
	 }
	 public static function show_live_results()
	 {
		 
	 }
	 public static function show_reload_button()
	 {
		 echo'
			<button onclick="location.reload();">Osvježi</button><br>
		 ';
	 }
	 public static function show_registered_runners($type)
	 {
		 $data=Controller::db_result("SELECT * FROM prijave WHERE tip='$type'");
		 $runners=Controller::db_result("SELECT id,godina,ime FROM trkaci ORDER BY id");
		 $con=new Controller($data,$runners);
		 echo"<table>";
		 foreach($data as $pom)
		 {
			 echo"<tr>";
			 $runner=$con->find($pom["id_trkaca"]);
			 
			 echo"<td>".$runner["ime"]."(".$runner["godina"].")</td><td>".$pom["broj"]."</td>\n";
			 echo"<td><a href=".'"'."prijave.php?edit=1&type=$type&runner_id=".$pom["id_trkaca"]."&ime=".$runner["ime"]."&id=".$pom["id"]."&broj=".$pom["broj"].'"'.">Edit</td>\n";
			 echo"<td><a href=prijave.php?type=$type&del=1&id=".$pom["id"].">Delete</a></td>\n";
			 echo"</tr>";
		 }
		 echo"</table>";
		 //echo'<form action="prijave.php"><input value="Povratak na listu" type="submit"><input type="hidden" name="type" value="'.$type.'"></form>';
	 }
	 public static function time_format($num)
	 {
		 $ans="";
		 if($num>60)
		 {
			 $ans.=''.floor(($num)/60);
			 $num=$num%60;
		 }
		 $ans.=':'.floor(($num));
		 return $ans;
	 }
	 public static function time_user_interface()
	 {
		 echo'<table height="75%" width="80%">';
		 echo'<tr height="45%"><td>
	      <button onclick="myFunction()" id="button2">Vrijeme</button> </td><td width="15%"></td><td>&nbsp;&nbsp;&nbsp;
		
			';
		 echo'
			<button onclick="myFunction3()" id="button2">Reset</button></td>
			<tr><td><div id="vrijeme"></div></td></tr>
		 ';
		 echo'</table>';
		
	 }
	 public static function ispis_trkaca($name,$type)
	 {
		echo'<form action="index.php" method="GET">';
		echo' <select name="runner_id">';
		$data=Model::list_of_runners($name,$type);
		foreach($data as $k)
		{
			echo'<option value='.$k["id"].'>';
			echo($k["ime"]."(".$k["godina"].")");
			echo'</option>';
		}
		echo' </select><br>
			  Startni broj:<br> <input type="number" name="bid_num" placeholder="268"><br><br>
		      <input type="submit" value="Prijavi" name="utrka">
			  <input type="hidden" value="'.$type.'" name="tip">
			  </form>
		 ';
		 echo('<br><a href="dodaj_korisnika.php?dod=1">Dodajte novog trkača</a><br>');
	 }
	 public static function print_headline($string)
	 {
		 echo"
		   <h3>$string</h3>
		 ";
	 }
}
?>