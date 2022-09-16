
<?php
ini_set('memory_limit', '40M'); 
ini_set('max_execution_time', 80000); 
ini_set('post_max_size', '40M'); 
ini_set('upload_max_filesize', '40M');

session_start(); /*Session Start*/
/* Checks if user is logged in to the system if not then it will be redirected to login page - security */
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

/* include files */
require_once "../inc/config.php";
include "../inc/constants.php";
include '../inc/functions.php';

 
/*$response = array( 
    'status' => 0, 
    'message' => 'Form submission failed, please try again.' 
); */


// If form is submitted 
if(isset($_POST['author']) || isset($_POST['word_count']) || isset($_POST['file']) || isset($_POST['description']) || isset($_POST['difficulty_level']) || isset($_POST['fiction']) || isset($_POST['audio_support']) || isset($_POST['topic_words']) || isset($_POST['text_type'])  || isset($_POST['theme']) || isset($_POST['issue_no']) || isset($_POST['art_year']) || isset($_POST['content'])  || isset($_POST['mag_type'])){ 
    // Get the submitted form data 
    $author = $_POST['author']; 
    $word_count = $_POST['word_count']; 
	$description = $_POST['description']; 
	$difficulty_level = $_POST['difficulty_level']; 
	$fiction = $_POST['fiction']; 
	$audio_support = $_POST['audio_support']; 
	$topic_words = $_POST['topic_words']; 
	$text_type = $_POST['text_type']; 
	$genre = 'test'; 
	$theme = $_POST['theme']; 
	$art_year = $_POST['art_year']; 
	$content = $_POST['content']; 
	$title = addslashes($_POST["title"]); 
	$mag_type = $_POST['mag_type']; 
	$newDate = date("Y-m-d", strtotime($art_year));	
	$issue_no=explode(" ",$_POST['issue_no']);
	if (!file_exists('../magazine/'.$issue_no[0].'/'.$issue_no[1])) {
    mkdir('../magazine/'.$issue_no[0].'/'.$issue_no[1], 0777, true);
	$uploadDir = '../magazine/'.$issue_no[0].'/'.$issue_no[1].'/'; 
    }else{
	 $uploadDir = '../magazine/'.$issue_no[0].'/'.$issue_no[1].'/';
	}
    
    // Check whether submitted data is not empty 
    if(!empty($title) ){ 
	   
        $stmt = $mysqli->prepare("Select mag_id from edu_magazine where mag_type_id=? and mag_status=? and mag_issue=?");
		/* Bind parameters */
		$stmt->bind_param("sss", $param_mag_type_id,$param_mag_status,$param_mag_issue);
		/* Set parameters */
		$param_mag_type_id = $_POST["mag_type"];
		$param_mag_status = $active;
		$param_mag_issue = $issue_no[1];
		$stmt->execute();
		$stmt->bind_result($mag_id);
		$stmt->fetch();
		$stmt->close();
		
		$stmt = $mysqli->prepare("Select mag_type_id from edu_mag_type where mag_type=?");
		/* Bind parameters */
		$stmt->bind_param("s", $param_mag_type);
		/* Set parameters */
		$param_mag_type = $issue_no[0];
		$stmt->execute();
		$stmt->bind_result($mag_type_idnew);
		$stmt->fetch();
		$stmt->close();
		
		if($mag_id ==''){
		   $stmt = $mysqli->prepare("INSERT into edu_magazine (mag_title,mag_issue,mag_published_date, mag_status, mag_type_id, mag_image_path) 
						values(?,?,?,?,?,?)");
			$stmt->bind_param("ssssss", $param_mag_title, $param_mag_issue, $param_mag_published_date, $param_mag_status, $param_mag_type_id, $param_mag_image_path);
			$param_mag_title = $_POST['theme'];
			$param_mag_issue= $issue_no[1];
			$param_mag_published_date =$todaysDate;
			$param_mag_status =$active;
			$param_mag_type_id = $mag_type_idnew;
			$param_mag_image_path='';
			$stmt->execute();
		    $lastmag_id = $stmt->insert_id;
			$mag_id_all = $lastmag_id;
		}else {
		   $mag_id_all = $mag_id;
		}
		$stmt = $mysqli->prepare("SELECT essay_type_id FROM edu_essay_type where essay_type_status=? and essay_type=?");
		/* Bind parameters */
		$stmt->bind_param("ss", $param_essay_type_status,$param_essay_type);
		/* Set parameters */
		$param_essay_type_status = $active;
		$param_essay_type = $_POST['text_type'];
		$stmt->execute();
		$stmt->bind_result($essay_type_id);
		$stmt->fetch();
		$stmt->close();
		if($essay_type_id ==''){
		   $stmt = $mysqli->prepare("INSERT into edu_essay_type (essay_type,essay_type_status) 
						values(?,?)");
			$stmt->bind_param("ss", $param_essay_type, $param_essay_type_status);
			$param_essay_type = $_POST['text_type'];
			$param_essay_type_status =$active;
			$stmt->execute();
		    $lastessay_type = $stmt->insert_id;
			$essay_type_id_all = $lastessay_type;
		}else {
		   $essay_type_id_all = $essay_type_id;
		}
		
	   $uploadStatus = 1; 
             
            // Upload file 
            $uploadedFile = ''; 
            if(!empty($_FILES["file"]["name"])){ 
                 
                // File path config 
                $fileName = basename($_FILES["file"]["name"]); 
                $targetFilePath = $uploadDir . $fileName; 
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
                 
                // Allow certain file formats 
                $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg'); 
                if(in_array($fileType, $allowTypes)){ 
                    // Upload file to the server 
                    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
                        $uploadedFile = 'magazine/'.$issue_no[0].'/'.$issue_no[1].'/' . $fileName; 
                    }else{ 
                        $uploadStatus = 0; 
                        $response['message'] = 'Sorry, there was an error uploading your file.'; 
                    } 
                }else{ 
                    $uploadStatus = 0; 
                    $response['message'] = 'Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.'; 
                } 
            } 
			
			if($uploadStatus == 1){ 
                // Include the database config file 
                $stmt = $mysqli->prepare("INSERT into edu_article_dummy (article_title,article_published_date,mag_id,article_status,essay_type_id,article_path,article_image,article_content, 	article_style,audio_path,art_year,theme,genre,topic_words,audio_support ,fiction,difficulty_level,description,word_count ,author,issue_no, last_modified) 
						values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");	
		  $stmt->bind_param("ssssssssssssssssssssss", $param_article_title,$param_article_published_date,$param_mag_id,$param_article_status,$param_essay_type_id,$param_article_path,$param_article_image,$param_article_content, 	$param_article_style,$param_audio_path,$param_art_year,$param_theme,$param_genre,$param_topic_words,$param_audio_support ,$param_fiction,$param_difficulty_level,$param_description,$param_word_count ,$param_author,$param_issue_no,$param_last_modified);  
		  $param_article_title = addslashes($_POST["title"]); ;
		  $param_article_published_date = $todaysDate;
		  $param_mag_id = $mag_id_all;
		  $param_article_status = $active;
		  $param_essay_type_id = $essay_type_id_all;
		  $param_article_path ='';
		  if($fileName==''){
		  $param_article_image =$_POST['imagPATH'];
		  }else{
		  $param_article_image =$uploadedFile;
		  }
		  $param_article_content =$content;	
		  $param_article_style ='';
		  $param_audio_path ='';
		  $param_art_year = $newDate;
		  $param_theme = $_POST['theme'];
		  $param_genre = 'test';
		  $param_topic_words = $_POST['topic_words'];
		  $param_audio_support = $_POST['audio_support'];
		  $param_fiction = $_POST['fiction'];
		  $param_difficulty_level = $_POST['difficulty_level'];
		  $param_description = $_POST['description'];
		  $param_word_count = $_POST['word_count'];
		  $param_author = $_POST['author'];
		  $param_issue_no = $_POST['issue_no'];
		   $param_last_modified = $todaysDate;
		  $stmt->execute();
		  $lastarticle_id = $stmt->insert_id;
		  
		  $stmt->close();         
               /* if($stmt->execute()){ 
                    $response['status'] = 1; 
                    $response['message'] = 'Form data submitted successfully!'; 
                }
				 $stmt->close(); */ 
            } 
        // Validate email 
		
		
		
		//-----------------audi upload------------------------------
		 $userdir = "mp3/songs/";
		 $uploadDir = '../magazine/'.$issue_no[0].'/'.$issue_no[1].'/';
		if($_POST['testFile'] ==1){
     for($i=0; $i<count($_FILES['my_file']['name']); $i++) {
       /*  $file_name = $_FILES["my_file"]["name"][$i];
		  $tmp_name = $_FILES["my_file"]['tmp_name'][$i];
		  $file_array = explode(".", $file_name);
		  $file_extension = end($file_array);
		  
		  $location = 'template/' . $file_name;
		  if(move_uploaded_file($tmp_name, $location))
		  {*/
    $target_file = $uploadDir . basename($_FILES["my_file"]["name"][$i]);
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    
	



            if (!file_exists($uploadDir)){
             mkdir($uploadDir, 0777, true);
            }
        if (move_uploaded_file($_FILES["my_file"]["tmp_name"][$i], $target_file)) {

            // your mysql connect code or you have to be included external file with $connect variable or just rename it 
            $file_audio_new = $_FILES["my_file"]["name"][$i];
             $uploadedFile11 = 'magazine/'.$issue_no[0].'/'.$issue_no[1].'/' . $file_audio_new; 
             
             $stmt = $mysqli->prepare("INSERT into edu_article_audio_dummy (article_id,path) 
						values(?,?)");	
		   $stmt->bind_param("ss", $param_article_id,$param_path);  
		   $param_article_id = $lastarticle_id;
		   $param_path =$uploadedFile11;
		   if($stmt->execute()){
             
           } else {

             //echo "Sorry, there was an error uploading your file.\n";
           }

       }
		
		//----------------------audio uplod end ---------------------
        
    }
    } 
	
    } 
}
echo $lastarticle_id;

 
// Return response 
//echo json_encode($lastarticle_id);
?>
