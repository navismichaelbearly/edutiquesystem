
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
if($_POST['compAct'] != "")
{
 $stages2 ="";
}
else{
  $stages2 = " and a.task_stages!=?";
}

if($_POST['taskstsatusVal'] == '')
{
 $stages ="";
}
else{
  $stages = " and a.task_stages=?";
}


if($_POST['userId'] != '')
{
  
 if ($stmt = $mysqli->prepare("SELECT b.article_title, a.due_date, a.task_stages,a.article_id,a.activity_id, a.peer_id FROM edu_user_task a inner join edu_article b on a.article_id = b.article_id where task_status=? and assigned_to=? ".$stages.$stages2." ORDER by a.task_stages DESC"  )) {
     if($_POST['taskstsatusVal'] == '' && $_POST['compAct'] == "" )
     {
       $stmt->bind_param("sss", $param_status, $param_user_id, $param_task_stages2);
	 // Set parameters 
	 $param_status = $active;
	 $param_user_id = $_POST['userId'];
	 $param_task_stages2 = $completed;
	 
    //$param_task_stages2 = $completed;
     }
     else if($_POST['taskstsatusVal'] != '' ){
       $stmt->bind_param("ssss", $param_status, $param_user_id, $param_task_stages, $param_task_stages2);
	   // Set parameters 
	   $param_status = $active;
	   $param_user_id = $_POST['userId'];
	   $param_task_stages = $_POST['taskstsatusVal'];
	   $param_task_stages2 = "";
     }
	 else if($_POST['compAct'] != ""){
       $stmt->bind_param("ss", $param_status, $param_user_id);
	   // Set parameters 
	   $param_status = $active;
	   $param_user_id = $_POST['userId'];
     }
	 
	 
	 $stmt->execute();
	 /* bind variables to prepared statement */
	 $stmt->bind_result($col1, $col2,$col3,$col4,$col5,$col6);
	 $sr =1;
	 /* fetch values */
	 while ($stmt->fetch()) {
	      if($col3 == $unopened){
		    $stages = $unopened;
		  }else if($col3 == $incomplete) {
		    $stages = $incomplete;
		  }else if($col3 == $completed) {
		    $stages = $completed;
		  }
		  else if($col3 == $overdue) {
		    $stages = $overdue;
		  }
		  
		  if($col4 != ""){
		    $title = $articleRead;
		  }else if($col5 != "") {
		    $title = $activity;
		  }else if($col6 != "") {
		    $title = $peerReview;
		  }	
		  $newDate = date("d M Y H:i", strtotime($col2));		
	      echo "<table class='tablebod'><tr>";
		       echo "<td>" . $title. " | <span class='normaltext'>" . $col1 . "</span></td>";
		  echo "</tr>";	   
		  echo "<tr>";	   
			   echo "<td class='normaltext normaltextsize'> Due Date: " . $newDate . "</td>";
		  
		  echo "</tr>";
		  echo "<tr align='right'><td><button class='".$stages."'>" . $col3 . "</button></td></tr></table><br>";
					$sr++;
	}
 }						
 
}
?>
