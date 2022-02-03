<?php

/* posted variables from Ajax call */
$email = $_POST['email'];

if($email ==""){
	session_start(); /*Session Start*/
	/* Checks if user is logged in to the system if not then it will be redirected to login page - security */
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: login.php");
		exit;
	}
}

/* include files */
require_once "inc/config.php";
include "inc/constants.php";
include 'inc/functions.php';

/* posted variables from Ajax call */
$confirm_password = $_POST['confirm_password'];


if($confirm_password != '')
{
 
 if($email !=""){
	/* update password query */ 
	$stmt = $mysqli->prepare("UPDATE edu_users SET user_password = ? WHERE user_email = ?");
	/* Bind parameters */
    $stmt->bind_param("ss", $param_password,$param_email);
	$param_password = password_hash($confirm_password, PASSWORD_DEFAULT);
    $param_email = $email;
	
	$stmt2 = $mysqli->prepare("INSERT INTO edu_log (log_entry, log_entry_date, log_entry_status, user_id) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("ssss", $param_log_entry, $param_log_entry_date, $param_log_entry_status, $param_user_id);
    $param_log_entry = $passwordupdateLog;
	$param_log_entry_date = $todaysDate;
	$param_log_entry_status = $active;
	$param_user_id = $_SESSION["id"];
	$stmt2->execute();
 }
 else {
	   /* update password query */
	   $stmt = $mysqli->prepare("UPDATE edu_users SET user_password = ?, first_time_password_change=? WHERE user_id = ?");
	   /* Bind parameters */
       $stmt->bind_param("sss", $param_password,$param_first_time_password_change,$param_uid);
	   /* Set parameters */
	   $param_password = password_hash($confirm_password, PASSWORD_DEFAULT);
	   $param_first_time_password_change =1;
	   $param_uid = $_SESSION["id"];	   
 }
 
 if($stmt->execute()){
    sqlLoginsert($passwordupdateLog);
	if($email !=""){
	   /* delete temporary keytoken requested by the user to change password */
	   $stmt = $mysqli->prepare("DELETE FROM edu_password_reset_temp WHERE email = ?");
	   $stmt->bind_param("s", $param_email);
       $param_email = $email;
	   $stmt->execute();
	}
 }
 else {
	   echo "Oops! Something went wrong. Please try again later.";
 }				
}


?>