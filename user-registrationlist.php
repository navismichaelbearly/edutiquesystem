<?php
/* include files */
require_once "inc/config.php";
include "inc/constants.php";


if($_POST['fname'] != '' && $_POST['lname'] != '' && $_POST['user_type'] != '' && $_POST['email'] != '')
{
		       $stmt = $mysqli->prepare("INSERT into edu_users_temp (fname,lname,user_type_id,email) 
	            	values(?,?,?,?)");	
			   $stmt->bind_param("ssss", $param_fname,$param_lname,$param_user_type,$param_email);  
			   $param_fname = $_POST['fname'];
			   $param_lname = $_POST['lname'];
			   $param_user_type = $_POST['user_type'];
			   $param_email = $_POST['email'];
               			   
		       if($stmt->execute()){
				   $stmt = $mysqli->prepare("SELECT b.fname,b.lname,b.user_type_id,b.email,a.user_type FROM edu_utype a inner join  edu_users_temp b on a.utype_id=b.user_type_id ");

   
   $stmt->execute();
   $stmt->bind_result($fname,$lname,$user_id,$email, $user_type); 
  
            
   
   $sr =1;
   echo  "<table border='1' width='100%'><thead><tr style='background-color: #3f3a60; color:#fff;'>";
   echo  "<th align='center'>First Name</th>";
   echo  "<th align='center'>Last Name</th>";
   echo  "<th align='center'>User Type</th>";
   echo  "<th align='center'>Email</th>";
    echo  "</thead></tr><tbody>";
    while ($stmt->fetch()) {
		
	     echo  "<tr><td width='20%'>".$fname."</td>";
		 echo  "<td width='20%'>".$lname."</td>";
		 echo  "<td width='20%'>".$user_type."</td>";
		 echo  "<td width='20%'>".$email."</td></tr>";
		
		 $sr++;
	 }
	  echo  "</tbody></table>";
   //$stmt->close();
					   }
				   }
			   
			   


			   				
			   


?>