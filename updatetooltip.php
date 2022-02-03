
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

if($_POST['tooltipvalue'] != '')
{
  
 /*  update query for tooltip */
 $stmt = $mysqli->prepare("UPDATE edu_users SET tooltip = ? WHERE user_id = ?");
 /* Bind parameters */
 $stmt->bind_param("ss", $param_tooltip,$param_uid);
 /* Set parameters */
 $param_tooltip = 1;
 $param_uid = $_SESSION["id"];
 if($stmt->execute()){
 }
 else {
	   echo "Oops! Something went wrong. Please try again later.";
 }			
 
}
?>
