<?
require_once("controller/controller.php");
require_once("view/View.php");
require_once("model/Model.php");
if(isset($_GET['del']))
{
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		Controller::db_query("DELETE FROM prijave WHERE id='$id'");
	}
}
else if(isset($_GET['edit']))
{
	if($_GET['edit']=='1')
	{
		echo'
		<form method="GET">
		<table>
		    <tr>
			   <td>Ime i prezime:</td>
			   <td>'.$_GET['ime'].'</td>
			</tr>
			<tr>
			   <td>Startni broj:</td>
			   <td> <input type="number" name="broj" value="'.$_GET['broj'].'"></td>
			</tr>
			<tr>
			   <td></td>
			   <td align="right"><input type="submit" value="Pošalji"></td>
			</tr>
		</table>
		<input type="hidden" name="edit" value="2">
		<input type="hidden" name="runner_id" value="'.$_GET['runner_id'].'">
		<input type="hidden" name="tip" value="'.$_GET['type'].'">
		<input type="hidden" name="id" value="'.$_GET['id'].'">
		</form>
		';
	}
	else if($_GET['edit']=='2')
	{
		foreach($_GET as $k=>$p)$$k=$p;
		Controller::db_query("UPDATE prijave SET broj='$broj' WHERE id='$id';");
		Controller::go_to("prijave.php?type=".$tip);
	}
}
else View::show_registered_runners($_GET['type']);
?>

<br><br><br>
<form action="index.php"><input type="submit" value="Početna"></form>