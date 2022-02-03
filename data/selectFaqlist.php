<?php
session_start(); /*Session Start*/

/* Checks if user is logged in to the system if not then it will be redirected to login page - security */
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

/* include files */
require_once "../inc/config.php";
include "../inc/constants.php";


if($_POST['faqType'] != '')
{
  if ($stmt = $mysqli->prepare("SELECT title,content,faq_id from edu_faq where status=? and faq_type=?")) {
		
	 $stmt->bind_param("ss", $param_status, $param_faq_type);
		 // Set parameters 
	 $param_status = $active;
	 $param_faq_type = $_POST['faqType'];
	 
	 $stmt->execute();
		 /* bind variables to prepared statement */
	 $stmt->bind_result($col1, $col2, $col3);
	 $sr =1;
	 echo "<div class='pageTitlenew'>FAQs for ".$_POST['faqType']." <a href='editFAQ.php?faqType=".$_POST['faqType']."' style='float:right;font-size:12px; text-decoration:none'>Edit</a></div><br>";
	 while ($stmt->fetch()) {
	     echo  "<div class='boxFAQ'><div class='faqTitle'>".$col1."</div><div class='faqContent'>";
		 echo  $col2."</div></div><br>";
		 $sr++;
	 }
        	
	}
}




?>