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

if($_POST['artTitle'] != "")
{
 foreach ($_POST['artTitle'] as $key => $value) {
  $value;  
 }
 $magVar ="order by a.article_title ".$value;
}else if($_POST['artDate'] != ""){
  foreach ($_POST['artDate'] as $key => $value) {
    $value;  
  }
   $magVar ="order by a.article_published_date ".$value;
}
else{
  $magVar = " ";
}

if($_POST['mag'] != '')
{
  if ($stmt = $mysqli->prepare("SELECT a.article_path,a.article_title, a.article_published_date, b.mag_title, b.mag_issue,b.mag_published_date,b.mag_image_path, d.mag_type,a.article_image from edu_article a inner join edu_magazine b on a.mag_id=b.mag_id inner join edu_mag_type d on b.mag_type_id = d.mag_type_id where a.article_status=? and b.mag_status=? and d.mag_type_status= ? ".$magVar)) {
	
	
		
	 $stmt->bind_param("sss", $param_status, $param_status2, $param_status3);
		 // Set parameters 
	 $param_status = $active;
	 $param_status2 = $active;
	 $param_status3 = $active;
	 
	 $stmt->execute();
		 /* bind variables to prepared statement */
	 $stmt->bind_result($article_path,$article_title, $article_published_date, $mag_title, $mag_issue, $mag_published_date, $mag_image_path, $mag_type, $article_image);
	 $sr =1;
	 
	 while ($stmt->fetch()) {
	     if($mag_type=='i-Magazine') {$mag_type= 'i';}
	     echo  "<div class='col-md-2-5 normaltext' align='center'><a href='article-detail.php?pth=".$article_path."'><img src='".$article_image."' width='200' height='265' style='border:1px solid #CCCCCC'></a><br><br>".$article_title."<br>".$mag_type.$mag_issue."</div>";
		
		 $sr++;
	 }
        	
	}
}




?>