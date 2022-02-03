
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

if($_POST['userId'] != '')
{
  
 if ($stmt = $mysqli->prepare("SELECT noti_title,noti_published_date,noti_content FROM edu_noti where noti_status=? and user_id=? limit ?,?")) {
    
       $stmt->bind_param("ssss", $param_status, $param_user_id, $param_calPage, $param_totPages);
	 // Set parameters 
	 $param_status = $active;
	 $param_user_id = $_POST['userId'];
	 $param_totPages = $_POST['totPages'];
	 $param_calPage = $_POST['calPage'];
    
	 
	 $stmt->execute();
	 /* bind variables to prepared statement */
	 $stmt->bind_result($col1, $col2,$col3);
	 $sr =1;
	 /* fetch values */
	 while ($stmt->fetch()) {
	      
		 	
		  $newDate = date("d M Y", strtotime($col2));		
	      echo "<table class='tablebod'><tr>";
		       echo "<td> <span class='normaltext'>" . $col1 . "</span></td>";
		  echo "</tr>";	   
		  echo "<tr>";	   
			   echo "<td class='normaltext'> " . $newDate . "</td>";
		  
		  echo "</tr>";
		  echo "<tr><td class='normaltext'>" . $col3 . "</td></tr></table><br>";
					$sr++;
	}
 }						
 
}
?>
