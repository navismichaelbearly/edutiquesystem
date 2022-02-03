<?php

 
// Include config file
require_once "inc/config.php";
include "inc/constants.php";

// Define variables and initialize with empty values
$error = $email =$successmail= $new_password= $confirm_password ="";
$email_err = $new_password_err = $confirm_password_err = "";

if (isset($_REQUEST["keytoken"]) && isset($_REQUEST["email"]) && isset($_REQUEST["passaction"]) && ($_REQUEST["passaction"]=="reset") ){
  $keytoken = $_REQUEST["keytoken"];
  $email = $_REQUEST["email"];
  $curDate = date("Y-m-d H:i:s");
  
  // Prepare a select statement
  $stmt = $mysqli->prepare("SELECT email,keytoken,expdate FROM edu_password_reset_temp WHERE email = ? and keytoken = ?");
	/* Bind parameters */
	$stmt->bind_param("ss", $param_useremail,$param_keytoken);
	// Set parameters
    $param_useremail = $email;
    $param_keytoken = $keytoken;
	$stmt->execute();
	$stmt->store_result();
	
	/* Bind results */
	$stmt->bind_result($email,$keytoken,$expdate);
	
	/* Fetch the value */
	$stmt->fetch();
	$numberofrows = $stmt->num_rows;

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

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="css/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/startmin.css" rel="stylesheet">

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

        <div class="container">
            <div class="row login-panel">
              <div class="successmail"><?php echo $successmail;?></div>
              <div class="col-lg-6 col-md-6"><img src="images/Edutique-Logo-big.png" width="100%" style="padding:60px 0px">
              </div>
              <div class="col-lg-6 col-md-6">
                <div class="col-md-offset-4">
                    <div>
                       <?php 
                            // display error message if the link is invalid/expired					   
					        if($numberofrows!=1){
					            $error .= '<h2>Invalid Link</h2>
								<p>The link is invalid/expired. Either you did not copy the correct link
								from the email, or you have already used the key in which case it is 
								deactivated.</p>
								<p><a href="'.$sysURL.'forgot_password.php">
								Click here</a> to reset password.</p>';
					          
							 }
							 else {
							    if ($expdate >= $curDate){
					    ?>		 
                                    <div>
                                        <h6 class="panel-title ">Reset Password</h6>
                                         <p class="normaltext" style="padding:10px 0 0px 10px"><?php echo $passwordStrengthtext;?>.</p>
                                    </div>
                                    <div class="panel-body">
                                        <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="chagepass">
                                            <fieldset>
                                                <label>Enter New Password</label>
                                                <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                                                    <input class="form-control" placeholder="New Password" name="new_password" type="password"  id="new_password">
                                                    <span id="new_password-info" class="info"></span>
                                                    <span class="help-block"><?php echo $new_password_err; ?></span>
                                                </div>
                                                <label>Re-Enter New Password</label>
                                                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                                    <input class="form-control" placeholder="Confirm Password" name="confirm_password" type="password"  id="confirm_password" >
                                                    <span id="confirm_password-info" class="info"></span>
                                                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                                                </div>
                                                <input type="hidden" name="keytoken" value="<?php echo $keytoken;?>">  
                                                <input type="hidden" name="email" value="<?php echo $email;?>">
                                                <input type="hidden" name="passaction" value="reset">
                                                
                                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Reset Password">
                                            </fieldset>
                                        </form>
                                    </div>
                            <?php
							       }
								   else{
									    // display error message if the link is invalid/expired
									    $error .= "<h2>Link Expired</h2>
									    <p>The link is expired. You are trying to use the expired link which 
									    as valid only 24 hours (1 days after request).<br /><br /></p>";
                                  }
                                }
								if($error!=""){
								  echo "<br /><div class='error'>".$error."</div><br />";
								}	 
							?>        
                    </div>
                  </div> 
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="js/startmin.js"></script>
        <script>
		$(document).ready(function () {
	
			//Contact Form validation on click event
			$("#chagepass").on("submit", function () {
				var valid = true;
				$(".info").html("");
				$("inputBox").removeClass("input-error");
				
				var new_password = $("#new_password").val();
				var confirm_password = $("#confirm_password").val();
				var email = '<?php echo $email;?>';
				
				// password validation
				var password_regex1=/[a-z]/g;
				 var password_regex2=/([0-9])/;
				 var password_regex3=/[A-Z]/g;
				 var password_regex4=/[!@#$%^&*]/g;

				if (new_password == "") {
					$("#new_password-info").html("Please enter the new password.");
					$("#new_password").addClass("input-error");
					 return false;
				}
				else if(new_password.length<8){
					 $("#new_password-info").html("Password must have atleast 8 characters.");
					 $("#new_password").addClass("input-error");
					 return false;
				}
				else if(password_regex1.test(new_password)==false){
					 $("#new_password-info").html("Your Password Must Contain At Least 1 Lowercase Letter!");
					 $("#new_password").addClass("input-error");
					 return false;
				}
				else if(password_regex2.test(new_password)==false){
					 $("#new_password-info").html("Your Password Must Contain At Least 1 Number!");
					 $("#new_password").addClass("input-error");
					 return false;
				}
				else if(password_regex3.test(new_password)==false){
					 $("#new_password-info").html("Your Password Must Contain At Least 1 Capital Letter!");
					 $("#new_password").addClass("input-error");
					 return false;
				}
				else if(password_regex4.test(new_password)==false){
					 $("#new_password-info").html("Your Password Must Contain At Least 1 Special Character!");
					 $("#new_password").addClass("input-error");
					 return false;
				}
				if (confirm_password == "") {
					$("#confirm_password-info").html("Please confirm the password.");
					$("#confirm_password").addClass("input-error");
					return false;
				}
				else if (confirm_password != new_password) {
					$("#confirm_password-info").html("Password did not match.");
					$("#confirm_password").addClass("input-error");
					return false;
				}
				if(confirm_password == new_password) { 
					$.ajax({  
							type:"POST",  
							url:"ajax-change-pass.php",  
							data: {confirm_password:confirm_password, email:email},
							success:function(data){  
								  alert('Password has been updated successfully');
								  window.location='login.php';  
							}  
					});event.preventDefault();  
				}
				   

			});
       });	
		
		</script>

    </body>
</html>

