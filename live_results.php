<?
require_once("View/view.php");
require_once("Model/model.php");
require_once("Controller/controller.php");




View::show_reload_button();
View::print_headline("Rezultati duga");
Model::model_the_results(2);
View::print_headline("Rezultati kratka");
Model::model_the_results(1);
?>