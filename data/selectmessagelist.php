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
if($_POST['messageId'] != '')
{
	$stmt = $mysqli->prepare("SELECT id,message_title FROM edu_messages where status=? and from_id=? and parent_msg_id=? and message_type=?");
	/* Bind parameters */
	$stmt->bind_param("ssss", $param_status,$param_from_id,$param_parent_msg_id,$param_message_type);
	/* Set parameters */
	
	$param_status = $active;
	$param_from_id = $_SESSION["id"];
	$param_parent_msg_id = 0;
	$param_message_type = $nontech;
	$stmt->execute();
	$stmt->bind_result($id,$message_title);
	 $sr =1;
	 echo "<table id='example' class='table table-striped table-bordered' style='width:100%'>
	 
                                        <thead>
                                            <tr>
                                                <th>Ref No.</th>
                                                <th>Message Title</th>
												
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>	
										";								
	 // fetch values 
	 while ($stmt->fetch()) {
	      
		  echo "<tr><td class='normaltext'>" . $id . "</td>";
		 
		  
		  echo "<td class='normaltext'>" . $message_title . "</td><td><a href='selectdetailmessagelog.php?mId=$id'>View Details</a>
		  <input type='hidden' value='" . $id . "' id='msgID'>&nbsp;&nbsp;&nbsp;&nbsp;
		  <img src='images/delete.png' width='20' height='20' id='msgDel'></td>"; 
		  
		  	$sr++;
	 }
	 echo "</tbody></table>";
}

if($_POST['messageDltid'] != '')
{

$stmt = $mysqli->prepare("delete FROM edu_messages where status=? and (id=? or parent_msg_id=?)");

$stmt->bind_param("sss", $param_status,$param_msg_id,$param_parent_msg_id);
$param_status = $active;
$param_msg_id = $_POST['messageDltid'];
$param_parent_msg_id = $_POST['messageDltid'];
$stmt->execute();
$stmt->close();


}
?>
