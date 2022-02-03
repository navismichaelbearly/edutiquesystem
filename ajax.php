<?php

session_start();
require_once "inc/config.php";
include "inc/constants.php";


  
$confirm_password = $_POST['confirm_password'];
if($confirm_password != '')
{
 $stmt = $mysqli->prepare("UPDATE edu_users SET user_password = ?, first_time_password_change=? WHERE user_id = ?");
	/* Bind parameters, s - string, b - blob, i - int, etc */
	$stmt->bind_param("sss", $param_password,$param_first_time_password_change,$param_uid);
	// Set parameters
	$param_password = password_hash($confirm_password, PASSWORD_DEFAULT);
	$param_first_time_password_change =1;
    $param_uid = $_SESSION["id"];
	if($stmt->execute()){
	   $success= "success";
	   echo json_encode($success);
	}
	else {
	   echo "Oops! Something went wrong. Please try again later.";
	}				
}


?>