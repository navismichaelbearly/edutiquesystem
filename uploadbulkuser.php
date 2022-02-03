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
if($_FILES["file"]["name"] != ''){

    $maketemp = "
     CREATE TABLE edu_temp_user_upload (
	  `startdate` datetime NULL,
	  `enddate` datetime NULL,
	  `country` varchar(255) NULL,
	  `school` varchar(255) NULL,
	  `address` text NULL,
	  `postalcode` varchar(255) NULL,
	  `level` varchar(255) NULL,
	  `class` varchar(255) NULL,
	  `product` varchar(255) NULL,
	  `issue` varchar(255) NULL,
	  `skill` varchar(255) NULL,
	  `article` varchar(255) NULL,
	  `firstname` varchar(255) NULL,
	  `lastname` varchar(255) NULL,
	  `userid` varchar(255) NULL,
	  `email` varchar(255) NULL,
	  `usertypeid` int(11) NULL,
	  `useridnew` int(11) NULL,
	  `schoolidnew` int(11) NULL,
	  `levelidnew` int(11) NULL,
	  `classidnew` int(11) NULL
     )
   "; 
   $stmt = $mysqli->prepare( $maketemp);
   $stmt->execute();
   $stmt->close();

   //mysql_query($maketemp, $connection) or die ("Sql error : ".mysql_error());
		
      
	
   $filename=$_FILES["file"]["tmp_name"];
   
   if($_FILES["file"]["size"] > 0)
	 {
      $file = fopen($filename, "r");
	  $flag = true;
      while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
            if($flag) { $flag = false; continue; }

            $stmt = $mysqli->prepare("INSERT into edu_temp_user_upload (startdate,enddate,country,school,address,postalcode,level,class,product,issue,skill,article,firstname,lastname,userid,email,usertypeid) 
	            	values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");	
			$stmt->bind_param("sssssssssssssssss", $param_startdate,$param_enddate,$param_country,$param_school,$param_address,$param_postalcode,$param_level,$param_class,$param_product,$param_issue,$param_skill,$param_article,$param_firstname,$param_lastname,$param_userid,$param_email,$param_usertype);
            /* Set parameters */
            if($emapData[0]!=""){
               $newstrDate = date("Y-m-d H:i:s", strtotime($emapData[0]));
            } else {
                    $newstrDate ="";
            }  
            if($emapData[1]!=""){
               $newendDate = date("Y-m-d H:i:s", strtotime($emapData[1]));
            } else {
                    $newendDate ="";
            } 
			
			if($emapData[16]== $studentText){
			   $usertypeID = $admstdconst;
			} else if($emapData[16]== $classteacherText){
			          $usertypeID = $admtchconst;
			} else if($emapData[16]== $proraminchargeText){
			          $usertypeID = $admprogtchconst;
			}
            $param_startdate =$newstrDate;
            $param_enddate =$newendDate;
            $param_country =$emapData[2];
            $param_school =$emapData[3];
            $param_address =$emapData[4];
            $param_postalcode =$emapData[5];
            $param_level =$emapData[6];
            $param_class =$emapData[7];
            $param_product =$emapData[8];
            $param_issue =$emapData[9];
            $param_skill =$emapData[10];
            $param_article =$emapData[11];
            $param_firstname =$emapData[12];
            $param_lastname =$emapData[13];
            $param_userid =$emapData[14];
            $param_email =$emapData[15];
            $param_usertype =$usertypeID;
            if($stmt->execute()){
			 $varSuccess=1;
            }
            else {
	               echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"subscriber-list.php\"
						</script>";
           }
		   
		   $stmt = $mysqli->prepare("SELECT username,user_email,user_id FROM  edu_users where username = ? or user_email=?");
		   /* Bind parameters */
		   $stmt->bind_param("ss", $param_username, $param_user_email);
		   /* Set parameters */
		   $param_username = $emapData[14];
		   $param_user_email = $emapData[15];
		   $stmt->execute();
		   $stmt->store_result();
		   $total_rows = $stmt->num_rows;
		   $stmt->bind_result($usernameCheck,$user_emailCheck, $user_idcheck);
		   $stmt->fetch();
		   $stmt->close();
		   
		   if($total_rows !=""){
		           $stmt = $mysqli->prepare("UPDATE edu_temp_user_upload SET useridnew=? where userid = ? or email=?");
				   /* Bind parameters */
				   $stmt->bind_param("sss", $param_useridnew, $param_userid, $param_email);
				   /* Set parameters */
				   if($user_idcheck !=""){
				      $param_useridnew= $user_idcheck;
				   } else {
				      $param_useridnew= $lastuser_id;
				   }				   
				   $param_userid= $emapData[14];
				   $param_email= $emapData[15];
				   $stmt->execute();
				   $stmt->fetch();
				   $stmt->close();
		   }
		   
		   
		   if($total_rows !=1)
		   {
		       $confirm_password ="Zxcv.mnbv@19";
			   $stmt = $mysqli->prepare("INSERT into edu_users (first_name,last_name,username,user_email,user_type_id,user_password,user_status, user_created_by, user_created_date) 
						values (?,?,?,?,?,?,?,?,?)");	
			   $stmt->bind_param("sssssssss", $param_first_name,$param_last_name,$param_username,$param_user_email,$param_user_type_id, $param_password, $param_user_status, $param_user_created_by, $param_user_created_date);  
			   $param_first_name = $emapData[12];
			   $param_last_name = $emapData[13];
			   $param_username = $emapData[14];
			   $param_user_email = $emapData[15];
			   $param_user_type_id = $usertypeID;			   
			   $param_password = password_hash($confirm_password, PASSWORD_DEFAULT);			   
			   $param_user_status = $active;
			   $param_user_created_by = $admintitle;
			   $param_user_created_date = $todaysDate;
			   if($stmt->execute()){
			      $lastuser_id = $stmt->insert_id;
				  $stmt = $mysqli->prepare("UPDATE edu_temp_user_upload SET useridnew=? where userid = ? or email=?");
				   /* Bind parameters */
				   $stmt->bind_param("sss", $param_useridnew, $param_userid, $param_email);
				   /* Set parameters */
				   $param_useridnew= $lastuser_id;				   
				   $param_userid= $emapData[14];
				   $param_email= $emapData[15];
				   $stmt->execute();
				   $stmt->fetch();
				   $stmt->close(); 
               }
			   
			   //$stmt->close();
		   }   
		   
		   
     }
	       
	 fclose($file);
	 
	 
	 
	 //throws a message if data successfully imported to mysql database from excel file
	 echo "<script type=\"text/javascript\">
			  alert(\"CSV File has been successfully Imported.\");
			  
		  </script>";
	        
			 

			 //close of connection
	//$stmt->close();
	
	
	
	$stmt = $mysqli->prepare("SELECT startdate,enddate,country,school,address,postalcode,level,class,product,issue,skill,article FROM  edu_temp_user_upload  limit ?");
   /* Bind parameters */
   $stmt->bind_param("s", $param_limit);
   /* Set parameters */
   $param_limit = 1;
   $stmt->execute();
   $stmt->bind_result($startdate,$enddate,$country,$school,$address,$postalcode,$level,$class,$product,$issue,$skill,$article);
   $stmt->fetch();
   $stmt->close(); 
   
   $stmt = $mysqli->prepare("UPDATE edu_temp_user_upload SET startdate=?,enddate=?,country=?,school=?,address=?,postalcode=?,level=?,class=?,product=?,issue=?,skill=?,article=?");
   /* Bind parameters */
   $stmt->bind_param("ssssssssssss", $param_startdate, $param_enddate, $param_country, $param_school, $param_address, $param_postalcode, $param_level, $param_class, $param_product, $param_issue, $param_skill, $param_article);
   /* Set parameters */
   $param_startdate= $startdate;
   $param_enddate= $enddate;
   $param_country= $country;
   $param_school= $school;
   $param_address= $address;
   $param_postalcode= $postalcode;
   $param_level= $level;
   $param_class= $class;
   $param_product= $product;
   $param_issue= $issue;
   $param_skill= $skill;
   $param_article= $article;   
   $stmt->execute();
   $stmt->fetch();
   $stmt->close(); 
   
   if($issue !=""){
      $prodTable = "edu_magazine";
	  $firstColumn ="mag_id";
	  $secColumn ="mag_issue";
	  $thirdColumn ="mag_status";
	  $secColumnvalue =$issue;
   }else if($skill !=""){
      $prodTable = "edu_activity";
	  $firstColumn ="activity_id";
	  $secColumn ="activity_title";
	  $thirdColumn ="activity_status";
	  $secColumnvalue =$skill;
   }else if($article !=""){
      $prodTable = "edu_article";
	  $firstColumn ="article_id";
	  $secColumn ="article_title";
	  $thirdColumn ="article_status";
	  $secColumnvalue =$article;
   }
   
   $stmt = $mysqli->prepare("SELECT school_id FROM  edu_school where school_name= ?");
   /* Bind parameters */
   $stmt->bind_param("s", $param_school_name);
   /* Set parameters */
   $param_school_name = $school;
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($school_id);
   $stmt->fetch();
   $numberofrowsSchool = $stmt->num_rows;
   $stmt->close();
   
   //if($numberofrowsSchool ==1){
	   $stmt = $mysqli->prepare("SELECT level_id FROM  edu_levels where school_id= ?");
	   /* Bind parameters */
	   $stmt->bind_param("s", $param_school_id);
	   /* Set parameters */
	   $param_school_id = $school_id;
	   $stmt->execute();
	   $stmt->store_result();
	   $stmt->bind_result($level_id);
	   $stmt->fetch();
	   $numberofrowslevel_id = $stmt->num_rows;
	   $stmt->close();
	   
	  // if($numberofrowslevel_id ==1){
		   $stmt = $mysqli->prepare("SELECT class_id FROM  edu_class where school_id= ? and level_id=?");
		   /* Bind parameters */
		   $stmt->bind_param("ss", $param_school_id,$param_level_id);
		   /* Set parameters */
		   $param_school_id = $school_id;
		   $param_level_id = $level_id;
		   $stmt->execute();
		   $stmt->store_result();
		   $stmt->bind_result($class_id);
		   $stmt->fetch();
		   $numberofrowsclassid = $stmt->num_rows;
		   $stmt->close();
	  // }
  // }
   
   $stmt = $mysqli->prepare("SELECT a.country_id FROM  edu_country a inner join edu_temp_user_upload b on a.country_name=b.country  WHERE a.country_status = ?");
   /* Bind parameters */
   $stmt->bind_param("s", $param_countrystatus);
   /* Set parameters */
   $param_uid = $_SESSION["id"];
   $param_countrystatus = $active;
   $stmt->execute();
   $stmt->bind_result($country_id);
   $stmt->fetch();
   $stmt->close();
   
   if($numberofrowsSchool !=1){
      $stmt = $mysqli->prepare("INSERT into edu_school (school_name,country_id,school_address,school_created_date,school_created_by,school_status,postal_code) 
	            	values(?,?,?,?,?,?,?)");	
	  $stmt->bind_param("sssssss", $param_school_name,$param_country_id,$param_school_address,$param_school_created_date,$param_school_created_by,$param_school_status,$param_postal_code);  
	  $param_school_name = $school;
	  $param_country_id = $country_id;
	  $param_school_address = $address;
	  $param_school_created_date = $todaysDate;
	  $param_school_created_by = $admintitle;
	  $param_school_status = $active;
	  $param_postal_code = $postalcode;
	  $stmt->execute();
	  $lastschool_id = $stmt->insert_id;
      $stmt->close();
	} 
	
	
	if($numberofrowslevel_id !=1){
      $stmt = $mysqli->prepare("INSERT into edu_levels (level,level_status,school_id) values(?,?,?)");	
	  $stmt->bind_param("sss", $param_level,$param_level_status,$param_school_id);  
	  $param_level = $level;
	  $param_level_status = $active;
	  if($school_id !=""){
	     $param_school_id = $school_id;
	  } else {
	     $param_school_id = $lastschool_id;
	  }
	  
	  $stmt->execute();	  
	  $lastlevel_id = $stmt->insert_id;
      $stmt->close();
	}
	
	if($numberofrowsclassid !=1){
      $stmt = $mysqli->prepare("INSERT into edu_class (class_name,school_id, level_id,class_status) values(?,?,?,?)");	
	  $stmt->bind_param("ssss", $param_class_name,$param_school_id,$param_level_id,$param_class_status);  
	  $param_class_name = $class;
	   if($school_id !=""){
	     $param_school_id = $school_id;
	  } else {
	     $param_school_id = $lastschool_id;
	  }
	  
	   if($level_id !=""){
	     $param_level_id = $level_id;
	  } else {
	     $param_level_id = $lastlevel_id;
	  }
	  $param_class_status = $active;
	  $stmt->execute();
	  $lastclass_id = $stmt->insert_id;
      $stmt->close();
	}
	
   
   $stmt = $mysqli->prepare("SELECT mag_type_id FROM  edu_mag_type where mag_type= ? and mag_type_status=?");
   /* Bind parameters */
   $stmt->bind_param("ss", $param_mag_type, $param_mag_type_status);
   /* Set parameters */
   $param_mag_type = $product;
   $param_mag_type_status = $active;
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($mag_type_id);
   $stmt->fetch();
   $stmt->close();
   
   $stmt = $mysqli->prepare("SELECT ".$firstColumn." FROM  ".$prodTable." where ".$secColumn."= ? and ".$thirdColumn."=?");
   /* Bind parameters */
   $stmt->bind_param("ss", $param_secColumn, $param_thirdColumn);
   /* Set parameters */
   $param_secColumn = $secColumnvalue;
   $param_thirdColumn = $active;
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($firstColumnitem);
   $stmt->fetch();
   $stmt->close();
   
   
   
   if($varSuccess ==1){
      $stmt = $mysqli->prepare("INSERT into edu_school_subscription (".$firstColumn.",school_id,school_subscription_status,subscription_start_date,subscription_end_date) 
	            	values(?,?,?,?,?)");	
	  $stmt->bind_param("sssss", $param_itemtype,$param_school_id,$param_school_subscription_status,$param_subscription_start_date,$param_subscription_end_date);  
	  $param_itemtype = $firstColumnitem;
	   if($school_id !=""){
	     $param_school_id = $school_id;
	  } else {
	     $param_school_id = $lastschool_id;
	  }
	  $param_school_subscription_status = $active;
	  $param_subscription_start_date = $startdate;
	  $param_subscription_end_date = $enddate;
	  $stmt->execute();
	  $lastedu_school_subscription_id = $stmt->insert_id;
      $stmt->close();
	  
	  
	  $stmt = $mysqli->prepare("UPDATE edu_temp_user_upload SET schoolidnew = ? , levelidnew = ?, classidnew = ?");
	  $stmt->bind_param("sss", $param_schoolidnew,$param_levelidnew,$param_classidnew);  
	  if($school_id !=""){
	        $param_schoolidnew = $school_id;
	  }else {
		    $param_schoolidnew = $lastschool_id;
	  }
	  if($level_id !=""){
	  	    $param_levelidnew = $level_id;
	  }else {
	  	    $param_levelidnew = $lastlevel_id;
	  }	
	  if($class_id !=""){
	        $param_classidnew = $class_id;
	  }else {
	        $param_classidnew = $lastclass_id;
	  }		
	  $stmt->execute();
      $stmt->close();
	  
	  $stmt = $mysqli->prepare("INSERT into edu_user_school_level_class (user_id,school_id,class_id,level_id) 
	            	SELECT useridnew, schoolidnew, classidnew, levelidnew FROM edu_temp_user_upload");
	  if($stmt->execute()){
	      $lastedu_user_school_level_class_id = $stmt->insert_id;
	      $stmt = $mysqli->prepare("INSERT into edu_subscription_info (user_school_lvl_class_id,school_subscription_id,usr_sch_cls_sch_subs_status) 
	            	SELECT user_school_lvl_class_id,user_id,level_id FROM edu_user_school_level_class");			  
		  $stmt->execute();
		  $stmt->close();
		  
		  $stmt = $mysqli->prepare("UPDATE edu_subscription_info SET school_subscription_id = ? , usr_sch_cls_sch_subs_status = ?"); 
		  $stmt->bind_param("ss",$param_school_subscription_id,$param_usr_sch_cls_sch_subs_status);
		  $param_school_subscription_id = $lastedu_school_subscription_id;
		  $param_usr_sch_cls_sch_subs_status = $active;
		  $stmt->execute();
		  $stmt->close();
	  
	  }
     // $stmt->close();
	 
	 	  
	}					
		 	
			
   }
}	 
?>		 