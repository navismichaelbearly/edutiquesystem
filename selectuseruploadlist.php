
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

if($_POST['userUpload'] != '')
{
  
 if ($stmt = $mysqli->prepare("SELECT startdate,enddate,country,school,address,postalcode,level,class,product,issue,skill,article,firstname,lastname,userid,email,usertype FROM edu_temp_user_upload ")) {
    
      // $stmt->bind_param("ssss", $param_status, $param_user_id, $param_calPage, $param_totPages);
	 
    
	 
	 $stmt->execute();
	 /* bind variables to prepared statement */
	 $stmt->bind_result($startdate,$enddate,$country,$school,$address,$postalcode,$level,$class,$product,$issue,$skill,$article,$firstname,$lastname,$userid,$email,$usertype);
	 $sr =1;
	 /* fetch values */
	 while ($stmt->fetch()) {
	      
		 	
		  $newstrDate = date("d M Y", strtotime($startdate));
		  $newendDate = date("d M Y", strtotime($enddate));		
	      echo "<table class='tablebod'><tr>";
		       echo "<td> <span class='normaltext'>" . $newstrDate . "</span></td>";
			   echo "<td> <span class='normaltext'>" . $newendDate . "</span></td>";
			   echo "<td> <span class='normaltext'>" . $country . "</span></td>";
			   echo "<td> <span class='normaltext'>" . $school . "</span></td>";
			   echo "<td> <span class='normaltext'>" . $address . "</span></td>";
			   echo "<td> <span class='normaltext'>" . $postalcode . "</span></td>";
			   echo "<td> <span class='normaltext'>" . $level . "</span></td>";
			   echo "<td> <span class='normaltext'>" . $class . "</span></td>";
			   echo "<td> <span class='normaltext'>" . $product . "</span></td>";
			   echo "<td> <span class='normaltext'>" . $issue . "</span></td>";
			   echo "<td> <span class='normaltext'>" . $skill . "</span></td>";
			   echo "<td> <span class='normaltext'>" . $article . "</span></td>";
			   echo "<td> <span class='normaltext'>" . $firstname . "</span></td>";
			   echo "<td> <span class='normaltext'>" . $lastname . "</span></td>";
			   echo "<td> <span class='normaltext'>" . $userid . "</span></td>";
			   echo "<td> <span class='normaltext'>" . $email . "</span></td>";
			   echo "<td> <span class='normaltext'>" . $usertype . "</span></td>";
		  echo "</tr>";	 
		  echo "</table><br>";
					$sr++;
	}
 }						
 
}
?>
