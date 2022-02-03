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

if($_POST['magTitle'] != "")
{
 foreach ($_POST['magTitle'] as $key => $value) {
  $value;  
 }
 $magVar ="order by a.mag_title ".$value;
}else if($_POST['magDate'] != ""){
  foreach ($_POST['magDate'] as $key => $value) {
    $value;  
  }
   $magVar ="order by a.mag_published_date ".$value;
}
else{
  $magVar = " ";
}

if($_POST['mag'] != '')
{
  if ($stmt = $mysqli->prepare("SELECT a.mag_title, a.mag_issue,a.mag_published_date,a.mag_image_path, b.mag_type from edu_magazine a inner join edu_mag_type b on a.mag_type_id = b.mag_type_id where a.mag_status=? and b.mag_type_status= ? ".$magVar)) {
		
	 $stmt->bind_param("ss", $param_status, $param_status2);
		 // Set parameters 
	 $param_status = $active;
	 $param_status2 = $active;
	 
	 $stmt->execute();
		 /* bind variables to prepared statement */
	 $stmt->bind_result($mag_title, $mag_issue, $mag_published_date, $mag_image_path, $mag_type);
	 $sr =1;
	 
	 while ($stmt->fetch()) {
	     if($mag_type=='i-Magazine') {$mag_type= 'i';}
	     echo  "<div class='col-md-2-5 normaltext' align='center'><a href='magzine-detail.php'><img src='images/".$mag_image_path."' width='200' height='265' style='border:1px solid #CCCCCC'></a><br><br>".$mag_type.$mag_issue."<br>".$mag_title."</div>";
		
		 $sr++;
	 }
        	
	}
}




?>