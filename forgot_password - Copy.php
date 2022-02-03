<?php
 
/* include files */
require_once "inc/config.php";
include "inc/constants.php";
 
// Define variables and initialize with empty values
$email =$successmail= "";
$email_err = "";
	 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  // Check if username is empty
  /*if(empty(trim($_POST["email"]))){
    $email_err = "Please enter the registered email.";
  } 
  else{
      $email = trim($_POST["email"]);
	  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = "Invalid email format";
      }

  }*/
     
    
  // Validate credentials
  if(empty($email_err)){
    // Prepare a select statement
	$stmt = $mysqli->prepare("SELECT user_email FROM edu_users WHERE user_email = ? and user_status = ?");
	/* Bind parameters */
	$stmt->bind_param("ss", $param_useremail,$param_ustatus);
	// Set parameters
    $param_useremail = $email;
    $param_ustatus = $active;
	$stmt->execute();
	$stmt->store_result();
	
	/* Bind results */
	$stmt->bind_result($email);
	
	/* Fetch the value */
	$stmt->fetch();
	$numberofrows = $stmt->num_rows;
	
	/* Close statement */
	//$stmt->close();
	
    if($numberofrows==1){
		// create expiry date and random keytoken
	    $expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
		$expDate = date("Y-m-d H:i:s",$expFormat);
		$key = md5(2418*2+11);
		$addKey = substr(md5(uniqid(rand(),1)),3,10);
		$key = $key . $addKey;
		
        // Insert expiry date and random keytoken		
		$sql = "INSERT INTO edu_password_reset_temp (email, keytoken, expdate) VALUES (?, ?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_email, $param_key, $param_expDate);
            
            // Set parameters 
            $param_email = $email;
			$param_key = $key;
			$param_expDate = $expDate;
			
            // Attempt to execute the prepared statement
            if($stmt->execute()){
				// prepare mail content
			    $output='<p>Dear user,</p>';
				$output.='<p>Please click on the following link to reset your password.</p>';
				$output.='<p>-------------------------------------------------------------</p>';
				$output.='<p><a href="'.$sysURL.'reset-password.php?keytoken='.$key.'&email='.$email.'&passaction=reset" target="_blank">
				'.$sysURL.'reset-password.php?keytoken='.$key.'&email='.$email.'&passaction=reset</a></p>';		
				$output.='<p>-------------------------------------------------------------</p>';
				$output.='<p>Please be sure to copy the entire link into your browser.
				The link will expire after 1 day for security reason.</p>';
				$output.='<p>If you did not request this forgotten password email, no action 
				is needed, your password will not be reset. However, you may want to log into 
				your account and change your security password as someone may have guessed it.</p>';   	
				$output.='<p>Thanks,</p>';
				$output.='<p>Edutique Team</p>';
				$body = $output; 
				$subject = "Password Recovery - Edutique System";
					
				$email_to = $email;
				$fromserver = "vishal_s@powersoft.com.sg"; 
				require("PHPMailer/PHPMailerAutoload.php");
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->Host = "mail.powersoft.com.sg"; // Enter your host here
				$mail->SMTPAuth = true;
				$mail->Username = "vishal_s@powersoft.com.sg"; // Enter your email here
				$mail->Password = "Zxcv.mnbv@19"; //Enter your password here
				$mail->Port = 25;
				$mail->IsHTML(true);
				$mail->From = "vishal_s@powersoft.com.sg";
				$mail->FromName = "Edutique System";
				$mail->Sender = $fromserver; // indicates ReturnPath header
				$mail->Subject = $subject;
				$mail->Body = $body;
				$mail->AddAddress($email_to);
				if(!$mail->Send()){
					echo "Mailer Error: " . $mail->ErrorInfo;
				}
				else{
					   $successmail= "An email has been sent to you with instructions on how to reset your password.";
				}
			}
		}		
	}
	else {
	   $email_err = "Email ID not registered with the Edutique System. Please contact the Edutech Administrator";
	}
        
        
  }
    
    // Close connection
    $mysqli->close();
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
       <!-- Essential JS 2 Calendar's dependent material theme -->
            <link href="https://cdn.syncfusion.com/ej2/ej2-base/styles/material.css" rel="stylesheet" type="text/css" />
            <link href="https://cdn.syncfusion.com/ej2/ej2-buttons/styles/material.css" rel="stylesheet" type="text/css" />
            <link href="css/material.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
		
        
        <link href='lib/main.css' rel='stylesheet' />
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
                        <div>
                            <h6 class="panel-title ">Forgot Password</h6>
                             <p class="normaltext" style="padding:10px 0 0px 10px"><?php echo $forgotPasswordtextwithoutemail;?>.</p>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="sub">
                                <fieldset>
                                    <label>Enter Your Registered Email Address</label>
                                    <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                        <input class="form-control" placeholder="Enter Your Registered Email Address" id="em" name="email" type="text" value="<?php echo $email; ?>" ><span id="em-info" class="info"></span>
                                        <span class="help-block"><?php echo $email_err; ?></span>
                                    </div>
                                    
                                      
                                    
                                    <!-- Change this to a button or input when using this as a form -->
                                    
                                    <!--<input type="submit" class="btn btn-lg btn-success btn-block" value="Submit" >-->
                                    <button class="btn btn-default btn-xl btnAlign" id="msgid">Send Message</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                  </div> 
                </div>
            </div>
        </div>

        <script src="js/jquery.min.js"></script>

		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>

		<!-- Metis Menu Plugin JavaScript -->
		<script src="js/metisMenu.min.js"></script>

		<!-- Morris Charts JavaScript -->
		<!-- <script src="js/raphael.min.js"></script>
		<script src="js/morris.min.js"></script>
		<script src="js/morris-data.js"></script>-->
		<script type="text/javascript" src="canvasjs.js"></script>
		<!-- Custom Theme JavaScript -->
		<script src="js/startmin.js"></script>
        <script src='lib/main.js'></script>
        <script>
		$(document).ready(function () {
			$("#sub").on("submit", function () {
			  $(".info").html("");
			$("em").removeClass("input-error");
			  var em = $("#em").val();
			   var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

			  if (em == "") {
					$("#em-info").html("Please enter the email.");
					$("#em").addClass("input-error");
					 return false;
			   }else if(!filter.test(em)){
			  $("#em-info").html("Please enter the valid email.");
					$("#em").addClass("input-error");
					 return false;		 
			  }else{ 
			       $.ajax({
						type: 'POST',
						url: 'data/messageInsert.php',
						data: {messagetext:messagetext},
						cache: false,
						success: function(data){
						   alert('Your message is sent successfully. Admin will get back to you within 72 hours');
						   window.location='need-help.php';
						   
						}
				  });event.preventDefault();
			  }
			
			
			
		  });
		});
		
		</script>
    </body>
</html>

