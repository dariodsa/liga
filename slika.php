<?
include('header.php');
require_once('view/View.php');
require_once('model/Model.php');
require_once('Controller/controller.php');


if(isset($_POST["submit"])) {
    $target_file = "slike_trkaca/".$_POST['id'].".png";
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
	if($uploadOk)
	{
		 if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
		 {
			echo"<script>document.location.href='trkac.php?id=".$_POST['id']."';</script>";
		 } 
		 else 
		 {
            echo "Sorry, there was an error uploading your file.";
		 }
	}
}



if(!isset($_GET['id']))die("Nema id varijable");
$id=$_GET['id'];



View::print_headline("Postavi sliku");
View::image_upload_form($id);


include('footer.php');
?>