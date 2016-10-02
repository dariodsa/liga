<meta charset="UTF-8">
<?
class View 
{
     public static function login_form()
	 {
		 echo'
			<meta charset="UTF-8">
			<form action="index2.php" method="GET">
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
		 <form action="index2.php" method="GET">
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
		 $data=Controller::db_result("SELECT * FROM status");
		 if(count($data)==0)
		 {
			 /*
			 * Obrazac za prijavu detalja lige
			 */
			 View::register_race_form();
		 }
		 else
		 {
			/*
			* Ispis detalja lige
			*/
			echo($data[0]["text"]);
			echo"<br>";
			View::show_reload_button();
			View::print_headline("Rezultati duga");
			Model::model_the_results(2,1);
			View::print_headline("Rezultati kratka");
			Model::model_the_results(1,1);
		 }
		 /*
		 * Objava rezultata
		 */
		 echo'<br><input type="button" onclick="fun()" value="Objavi rezultate">';
		 echo'<script>function fun()
				{
					document.location="objava.php";
				}
			 </script>';
	 }
	 public static function show_best_results($tip) 
	 {
		 if($tip==1)
		 {
			 $data=Controller::db_result("SELECT id_trkaca,vrijeme,date FROM rezultati_duga WHERE ((broj_kola>='1' AND broj_kola<='8') OR (broj_kola>='22' AND broj_kola<='26'))");
		 }
		 else 
		 {
			 $data=Controller::db_result("SELECT id_trkaca,vrijeme,date FROM rezultati_duga WHERE ((broj_kola>='9' AND broj_kola<='21'))");
		 }
		 $data=Model::get_unique_results($data);
		 $data3=array();//mora biti prazan jer ga ne koristim, pogledaj kontruktor
		 $trkaci=Controller::db_result("SELECT * FROM trkaci");
		 $con=new Controller($data3,$trkaci);
		 $poredak=1;
		 echo"<table border=1>";
		 foreach($data as $pom)
		 {
			 $runner=$con->find($pom["id_trkaca"]);
			 echo"<tr>";
			 echo"<td>$poredak.</td>";
			 echo"<td>".($runner["ime"])."</td>";
			 echo"<td>".$pom["vrijeme"]."</td>";
			 echo"<td>".$pom["date"]."</td>";
			 echo"</tr>";
			 ++$poredak;
		 }
		 echo"</table>";
	 }
	 public static function show_reload_button()
	 {
		 echo'
			<button onclick="location.reload();">Osvježi</button><br>
		 ';
		 return;
	 }
	 public static function register_race_form()
	 {
		 echo'
		     <form method="POST">
				Suci: <input type=text" name="suci"><br>
				Vrijeme: <input type="text" name="vrijeme"><br>
				Kolo: <input type="number" name="kolo" min="1" max="26">
				<input name="register_race_form" type="submit" value="Pošalji">
			 </form>
		 ';
		 return;
	 }
	 public static function set_results_check_form()
	 {
		 echo'
		     Tip: <select name="tip" id="tip">
				<option value="0">Kratka</option>
				<option value="1">Duga</option>
			  </select>
			  <br>
			 Godina: <input type="number" name="godina" placeholder="2015" id="godina"><br>
			 Kolo: <select name="kolo" id="kolo">
						<option value="1">1.kolo</option>
						<option value="2">2.kolo</option>
						<option value="3">3.kolo</option>
						<option value="4">4.kolo</option>
						<option value="5">5.kolo</option>
						<option value="6">6.kolo</option>
						<option value="7">7.kolo</option>
						<option value="8">8.kolo</option>
						<option value="9">9.kolo</option>
						<option value="10">10.kolo</option>
						<option value="11">11.kolo</option>
						<option value="12">12.kolo</option>
						<option value="13">13.kolo</option>
						<option value="14">14.kolo</option>
						<option value="15">15.kolo</option>
						<option value="16">16.kolo</option>
						<option value="17">17.kolo</option>
						<option value="18">18.kolo</option>
						<option value="19">19.kolo</option>
						<option value="20">20.kolo</option>
						<option value="21">21.kolo</option>
						<option value="22">22.kolo</option>
						<option value="23">23.kolo</option>
						<option value="24">24.kolo</option>
						<option value="25">25.kolo</option>
						<option value="26">26.kolo</option>
					</select>
					<br>
				    <button name="button1" onclick="nadi()" >Pogledaj</button>
					<br>
					<div id="rez">
					</div>
		';
		echo'
		   <script>
		      
			  function nadi()
			 {
				 var godina=document.getElementById("godina").value;
				 var tip=document.getElementById("tip").value;
				 var kolo=document.getElementById("kolo").value;
				 if(tip=="0")
				 {
					 $.get("rezultati.php?kolo="+kolo+"&godina="+godina,function(data){
					document.getElementById("rez").innerHTML=data;
					});
				 }
				 else
				 {
					 $.get("rezultati.php?kolo="+kolo+"&godina="+godina+"&tip=2",function(data){
					document.getElementById("rez").innerHTML=data;
					});
				 }
			 }
		   </script>
		   
		';
	 }
	 public static function image_upload_form($id="")
	 {
		 echo' 
		   <form method="POST" enctype="multipart/form-data">
		      
			  <input type="file" value="Slika" name="fileToUpload">
			  <input type="hidden" value="'.$id.'" name="id"><br><br>
			  <input type="submit" value="Pošalji" name="submit">
		   
		   </form>
		 ';
		 return;
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
		 
		 $stats=Model::get_prerace_stats();
		 
		 echo"Statistika:<br>";
		 echo"Broj prijava za kratku: ".($stats["krz"]+$stats["krm"])." (".$stats["krz"].",".$stats["krm"].")<br>";
		 echo"Broj prijava za dugu: ".($stats["duz"]+$stats["dum"])." (".$stats["duz"].",".$stats["dum"].")<br>";
		 echo"Ukupno ".($stats["duz"]+$stats["dum"]+$stats["krz"]+$stats["krm"])." (".($stats["duz"]+$stats["krz"]).",".($stats["dum"]+$stats["krm"]).")<br>";
		 //echo'<form action="prijave.php"><input value="Povratak na listu" type="submit"><input type="hidden" name="type" value="'.$type.'"></form>';
		 return;
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
		echo'<form action="index2.php" method="GET">';
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
