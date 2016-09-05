<?
$korisnik="root";//"akvetera_wp1";
$lozinka="";//"IL#N^paXwP3!0";
$baza="liga";//"akvetera_wp1";
//$con = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8', $user, $pass);
$con=new PDO('mysql:host=localhost;dbname='.$baza.';charset=utf8',$korisnik,$lozinka);
$con->exec("set names utf8");
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$bp=mysql_connect("localhost",$korisnik,$lozinka);
mysql_select_db($baza,$bp) or die( "Greška kod povezivanja na bazu!");
mysql_query("SET NAMES utf8"); 
?>