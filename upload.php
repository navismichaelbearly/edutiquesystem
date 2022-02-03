
<?php
session_start(); /*Session Start*/
/* Checks if user is logged in to the system if not then it will be redirected to login page - security */
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

/* include files */
require_once "inc/config.php";
include "inc/constants.php";
include 'inc/functions.php';

if($_FILES["file"]["name"] != '')
{
 /* Select query to get image path */
 $stmt = $mysqli->prepare("SELECT user_image_path FROM  edu_users WHERE user_id = ?");
 /* Bind parameters */
 $stmt->bind_param("s", $param_uid);
 /* Set parameters */
 $param_uid = $_SESSION["id"];
 $stmt->execute();
 $stmt->bind_result($user_image_path);
 $stmt->fetch();	
 $stmt->close();
 
 if($user_image_path !=""){
	/* delete image from the folder */
    $user_image_path = 'upload/' .$user_image_path;
	if (file_exists($user_image_path)) {
		unlink($user_image_path);
	}
 }
 /* create random name for image and upload it to the folder */ 
 $test = explode('.', $_FILES["file"]["name"]);
 $ext = end($test);
 $name = rand(100, 999) .$_SESSION["id"]. '.' . $ext;
 $location = './upload/' . $name;  
 move_uploaded_file($_FILES["file"]["tmp_name"], $location);
 /* update query to save image path */
 $stmt = $mysqli->prepare("UPDATE edu_users SET user_image_path = ? WHERE user_id = ?");
 /* Bind parameters */
 $stmt->bind_param("ss", $param_user_image_path,$param_uid);
 /* Set parameters */
 $param_user_image_path = $name;
 $param_uid = $_SESSION["id"];
 if($stmt->execute()){
    sqlLoginsert($profilepicupdateLog);
	/* select image path */   
	$stmt = $mysqli->prepare("SELECT user_image_path FROM  edu_users WHERE user_id = ?");
	/* Bind parameters */
	$stmt->bind_param("s", $param_uid);
	/* Set parameters */
	$param_uid = $_SESSION["id"];
	$stmt->execute();
	$stmt->bind_result($user_image_path);
	$stmt->fetch();	
	$location = './upload/' . $user_image_path;
	echo '<img src="'.$location.'" height="150" width="225" class="img-thumbnail" />';
 }
 else {
	   echo "Oops! Something went wrong. Please try again later.";
 }			
 
}
?>
