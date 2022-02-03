<?php
session_start(); /*Session Start*/
/* Checks if user is logged in to the system if not then it will be redirected to login page - security */
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

date_default_timezone_set('Asia/Singapore');

/* include files */
require_once "inc/config.php";
include "inc/constants.php";
include 'inc/functions.php';

/* Initialise PHP variables */
$current_password = $new_password = $confirm_password = "";
$current_password_err = $new_password_err = $confirm_password_err = "";

/* Query to fetch the user details. Inner Join query on tables edu_utype and edu_users */
$stmt = $mysqli->prepare("SELECT a.utype_id, a.user_type, b.user_image_path, b.first_name, b.last_name, b.user_password, b.user_email FROM edu_utype a inner join edu_users b WHERE a.user_type_id=b.user_type_id and b.user_id = ? and b.user_status = ?");
/* Bind parameters */
$stmt->bind_param("ss", $param_uid,$param_urstatus);
/* Set parameters */
$param_uid = $_SESSION["id"];
$param_urstatus = $active;
$stmt->execute();
$stmt->bind_result($uid, $utype, $imgpath, $fname, $lname, $pass, $uemail);
$stmt->fetch();
$stmt->close();

/* Checking if form has been submitted */
if($_SERVER["REQUEST_METHOD"] == "POST"){ 
  /* Password Validation */
  if(strlen(trim($_POST["new_password"])) < 8){
    $new_password_err = "Password must have atleast 8 characters.";
  } 
  elseif(!preg_match("#[0-9]+#",$_POST["new_password"])) {
         $new_password_err = "Your Password Must Contain At Least 1 Number!";
  } 
  elseif(!preg_match("#[A-Z]+#",$_POST["new_password"])) {
        $new_password_err = "Your Password Must Contain At Least 1 Capital Letter!";
  }
  elseif(!preg_match("#[a-z]+#",$_POST["new_password"])) {
        $new_password_err = "Your Password Must Contain At Least 1 Lowercase Letter!";
  }
  elseif(!preg_match('@[^\w]@',$_POST["new_password"])) {
        $new_password_err = "Your Password Must Contain At Least 1 Special Character!";
  }
  else{
       $new_password = trim($_POST["new_password"]);
  }
    
  /* Validate confirm password */
  $confirm_password = trim($_POST["confirm_password"]);
  if(empty($new_password_err) && ($new_password != $confirm_password)){
    $confirm_password_err = "Password did not match.";
  }
	
  $current_password = trim($_POST["current_password"]);
  if(password_verify($current_password, $pass)){
  } 
  else {
	    $current_password_err =  "Current Password is not valid.";
  }
    
  /* Checks if variables are free from errors */
  if(empty($new_password_err) && empty($confirm_password_err) && empty($current_password_err)){
    /* update password query */
	$stmt = $mysqli->prepare("UPDATE edu_users SET user_password = ? WHERE user_email = ?");
	/* Bind parameters */
	$stmt->bind_param("ss", $param_password,$param_useremail);
	/* Set parameters */
	$param_password = password_hash($new_password, PASSWORD_DEFAULT); /* password encryption */
    $param_useremail = $uemail;
	if($stmt->execute()){
	    sqlLoginsert($passwordupdateLog);
	   /* Redirecting to dashboard after updating the password */
	   echo "<script type='text/javascript'>alert('Password has been updated successfully');
                           window.location='dashboard.php';
                       </script>";
	}
	else {
	   echo "Oops! Something went wrong. Please try again later.";
	}				   
	
	/* Close statement */
	//$stmt->close();
	
   
        
        
  }
    
  // Close connection
  // $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Edutique System</title>
        
        <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="css/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="css/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/startmin.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="css/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        
    </head>
    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar-inverse navbar-fixed-top" role="navigation">
                
                <!-- toggle menu in mobile and tablet view -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                
                <!-- /.navbar-top-links -->

                 <?php include 'inc/sidebar.php'; ?>
            </nav> 

            <div id="page-wrapper">
                <div class="row">
                        <div class="col-lg-12 searchbar">
                            <div class="sidebar-search">
                                <div class="input-group custom-search-form">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Global Search" style="border:none; box-shadow:none">                                    
                                </div>
                            </div>
                        </div>
                        <!-- /.col-lg-12 -->
                </div>
                
                <div class="container-fluid">
                     <div class="row">
                        <div class="col-lg-12">
                            <h3 id="grid-responsive-resets" class="headertext">Account Setting</h3>
                            <br>
                            <h5 class="themecolor">Avatar</h5>
                            <table border="0" class="tablewidth" style="background-color:transparent">
                                <tr>  
                                    <td><span id="uploaded_image" class="logoprofile" style="background-image:url(upload/<?php echo $imgpath;?>)"></span></td>
                                    <td>
                                        <button style="margin:0px 0px" onClick="document.getElementById('file').click()" class="custbutton">Upload</button> 
                                        <input type="file" name="file" id="file" value="Upload" style="display:none" />
                                    </td>
                                    <td>
                                        <input type="hidden" value="<?php echo $imgpath;?>" name="delete_file" id="delete_file" />
                                        <input  type="button" value="Remove" onClick="delete_image()" class="custbutton"/>
                                    </td>
                                </tr>
                                <tr><td colspan="3" class="normaltext">Upload only png, jpg or jpeg file and File Size should be grater than 60KB and less than 100KB.</td></tr>
                            </table>
                            <br>
                            <h5 class="themecolor">Name</h5>
                            <div class="normaltext"><?php echo $fname." ".$lname;?></div><br>
                            <h5 class="themecolor">Change password</h5>
                            <div class="normaltext">
                                <?php echo $passwordStrengthtext;?><br>
                                <?php echo $passwordText;?><br><br>
                            </div>    
                            <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <fieldset>
                                    <label>Current Password</label>
                                    <div class="form-group <?php echo (!empty($current_password_err)) ? 'has-error' : ''; ?>">
                                        <input class="form-control formfield" placeholder="Current Password" name="current_password" type="password" >
                                        <span class="help-block"><?php echo $current_password_err; ?></span>
                                    </div>
                                    <label>New Password</label>
                                    <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                                        <input class="form-control formfield" placeholder="New Password" name="new_password" type="password" >
                                        <span class="help-block"><?php echo $new_password_err; ?></span>
                                    </div>
                                    <label>Confirm New Password</label>
                                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                        <input class="form-control formfield" placeholder="Confirm Password" name="confirm_password" type="password" >
                                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                                    </div>
                                    <input type="submit" class="btn btn-lg btn-success btn-block formfield" value="Change Password">
                                </fieldset>
                            </form>
                            <br><br>
                            <h4 class="themecolor"><a href="logout.php" style="color:#3f3a60">Logout</a></h4>        
                                    
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->
        <!-- <script src="js/raphael.min.js"></script>
        <script src="js/morris.min.js"></script>
        <script src="js/morris-data.js"></script>-->

        <!-- Custom Theme JavaScript -->
        <script src="js/startmin.js"></script>
        <script>
		    
               $(document).ready(function(){
                 $(document).on('change', '#file', function(){
                   var name = document.getElementById("file").files[0].name;
                   var form_data = new FormData();
                   var ext = name.split('.').pop().toLowerCase();
				   /*Image Validation - checks for the type and size*/
                   if(jQuery.inArray(ext, ['png','jpg','jpeg']) == -1){
                      alert("Invalid Image File. Upload only png, jpg or jpeg file");
                   }
                   var oFReader = new FileReader();
                   oFReader.readAsDataURL(document.getElementById("file").files[0]);
                   var f = document.getElementById("file").files[0];
                   var fsize = f.size||f.fileSize;
                   if((fsize > 100000) || (fsize < 60000)){
                      alert("Image File Size should be grater than 60KB and less than 100KB");
                   }
                   else{
                       form_data.append("file", document.getElementById('file').files[0]);
					   /* jQuery Ajax Call in PHP Script */
                       $.ajax({
                               url:"upload.php",
							   method:"POST",
							   data: form_data,
							   contentType: false,
							   cache: false,
							   processData: false,
							   beforeSend:function(){
                                         $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
                               },   
                               success:function(data){
                                      $('#uploaded_image').html(data);
	                                  window.location='account-setting.php';
                               }
                       });
                   }
                 });
              });
             
			 /* Function to delete uploaded image */
             function delete_image(){
                     var status = confirm("Are you sure you want to delete ?");  
                    if(status==true){
                       var file = $("#delete_file").val();
					   /* jQuery Ajax Call in PHP Script */
                       $.ajax({
                               type:"POST",
                               url:"image-delete.php",
                               data:{file:file},
                               success(html){
                                      alert('Your profile picture is deleted successfully');
	                                  window.location='account-setting.php';
                               }
                       });
                    }
                }

		</script>

    </body>
</html>
