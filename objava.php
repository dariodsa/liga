<?
require_once('view/View.php');
require_once('model/Model.php');
require_once('controller/Controller.php');

$broj_kola=Model::get_round_number();

//Controller::controll_user_interface();
echo($broj_kola);
//Model::get_results($broj_kola,1);
//Model::get_results($broj_kola,2);

Controller::db_query("DELETE  FROM status WHERE 1");
Controller::db_query("DELETE  FROM brojevi WHERE 1");
Controller::db_query("DELETE  FROM vremena WHERE 1");
Controller::db_query("DELETE  FROM prijave WHERE 1");
echo"<script>alert('Rezultati su objavljeni.'); document.location='index2.php';</script>";
?>