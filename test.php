<?php
require_once "inc/config.php";
include "inc/constants.php";
if ($stmt = $mysqli->prepare("SELECT a.mag_title, a.mag_issue,a.mag_published_date,a.mag_image_path, b.mag_type from edu_magazine a inner join edu_mag_type b on a.mag_type_id = b.mag_type_id where a.mag_status=? and b.mag_type_status= ? ")) {
		
	 $stmt->bind_param("ss", $param_status, $param_status2);
		 // Set parameters 
	 $param_status = $active;
	 $param_status2 = $active;
	 
	 $stmt->execute();
	 $result = $stmt->get_result();
		 /* bind variables to prepared statement */
	// $stmt->bind_result($mag_title, $mag_issue, $mag_published_date, $mag_image_path, $mag_type);
	// $result = $stmt->fetch();
	 foreach($result as $row)
	{
		echo $row['mag_title'];
	}
	} 

?>