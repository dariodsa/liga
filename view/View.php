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
		 echo("Odabir uloga");
		 echo'
		 <form action="index.php" method="GET">
		   <table height="100%" width="100%">
		     <tr>
		       <td align="center"><button type="submit" name="kratka" value="Prijave_kratke"> Prijava kratka</td>
			   <td align="center"><button type="submit" name="duga" value="Prijave_duge">Prijava duga</td>
			 </tr>
			 <tr>
			   <td align="center"><button type="submit" name="vrijeme" value="Mjerim vrijeme">Mjerim vrijeme</td>
			   <td align="center"><button type="submit" name="brojevi" value="Bilježim brojeve kako ulaze">Bilježim brojeve kako ulaze</td>
			 </tr>
			 <tr>
  			  <td colspan="2" align="center"><button type="submit" name="glavni" value="Ispravljam moguće pogreške i nadgledam">Ispravljam moguće pogreške i nadgledam</td>
			 </tr>
			 </table>  
		   </form>
		 ';
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
			  </form>
		 ';
	 }
	 public static function print_headline($string)
	 {
		 echo"
		   <h3>$string</h3>
		 ";
	 }
}
?>