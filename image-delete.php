
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

if($_POST['file'] != '')
{
 /* delete image from the folder */
 $user_image_path = 'upload/' .$_POST['file'];
 if (file_exists($user_image_path)) {
    unlink($user_image_path);
  }
 
 /* delete image path from the table using update query */
 $stmt = $mysqli->prepare("UPDATE edu_users SET user_image_path = ? WHERE user_id = ?");
 /* Bind parameters */
 $stmt->bind_param("ss", $param_user_image_path,$param_uid);
 /* Set parameters */
 $param_user_image_path = null;
 $param_uid = $_SESSION["id"];
 if($stmt->execute()){
    sqlLoginsert($profilepicremoveLog);
 }
 else {
	   echo "Oops! Something went wrong. Please try again later.";
 }			
 
}
?>
