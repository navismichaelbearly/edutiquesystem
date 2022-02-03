<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
// Initialize the session


date_default_timezone_set('Asia/Singapore');
 

 
// Include config file
require_once "inc/config.php";
include "inc/constants.php";
 


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
		  <div class="row">
            <div class="col-lg-12 col-md-12">
			      
                       <div>
                            <h6 class="panel-title">Bulk User Upload</h6><br>
                       </div>
					
                       <form action="/action_page.php">
					   <div class="row">
					       <div class="col-lg-4 col-md-4">
					            <label for="Starting From">Starting From</label><br>
					            <input type ="text" class="form-control" id="Starting From" name="Starting From" required>
					       </div>
					       <div class="col-lg-4 col-md-4">
					           <label for="Ending From">Ending From</label><br>
					  
					            <input type="text" class="form-control" id="Ending From" name="Ending From" required>
						   </div>
					       <div class="col-lg-4 col-md-4">
					            <label for="Country">Country</label><br>
					            <input type="text" class="form-control" id="Country" name="Country" required>
					       </div>
					  </div>
					  
					  <div class="row">
					       <div class="col-lg-4 col-md-4">
					           <label for="School Name">School Name</label>
					           <input type="text" class="form-control"  id="School Name" name="School Name" required><br>
					       </div>
					       <div class="col-lg-4 col-md-4">
							  <label for="Level">Level</label><br>
							  
							  <input type="text" class="form-control" id="Level" name="Level" required>
					       </div>
					  
					       <div class="col-lg-4 col-md-4">
							  <label for="Class">Class</label>
							  <input type="text" class="form-control" id="Class" name="Class" required>
					       </div>
					 </div>
					  
					  
					 <div class="row">
					      <div class="col-lg-8 col-md-8">
							  Address<br>
							  <textarea name="" class="form-control"></textarea>
					      </div>
					      <div class="col-lg-4 col-md-4">
							  <label for="Postal Code">Postal Code</label><br>
							   <input type="text" class="form-control" id="Postal Code" name="Postal Code" required>
					      </div>
					</div>
					<div class="row">
					    <div class="col-lg-12 col-md-12">
					 
							  <label for="Product">Product</label><br>
							  <input type="text" class="form-control" id="Product" name="Product"  class="form-control" required>
					 
					  
					  
							  Issues
							  <textarea name="" class="form-control"></textarea>
							   Skills
							  <textarea name="" class="form-control"></textarea>
							  Articles
							  <textarea name="" class="form-control"></textarea>
					  </div>
				   </div>
				
				   </form>
					  
					  
				   <br>



                 <form>
	             <div class="row">
					  <div class="col-lg-3 col-md-3">
                          <input type="text" class="form-control" id="first_name" placeholder="First Name" required>
						  <span id="first_name-info" class="info"></span>
		              </div>
					  <div class="col-lg-3 col-md-3">
                          <input type="text" class="form-control" id="last_name" placeholder="Last Name" required>
						  <span id="last_name-info" class="info"></span>
		              </div>
		              <div class="col-lg-2 col-md-2">
		                   <input type="text" class="form-control" id="email" placeholder="Email Address" required>
						   <span id="email-info" class="info"></span>
		             </div>
					 <div class="col-lg-2 col-md-2">
		                   <select name="user_id" id="user_id" class="form-control" required>
							  
							  <option value="<?php echo $admtchconst;?>">Teacher</option>
							  <option value="<?php echo $admstdconst;?>">Student</option>
                          </select>
						  <span id="user_id-info" class="info"></span>
		             </div>
					 <div class="col-lg-2 col-md-2">
    	               <input type="button" class="add-row form-control btn btn-lg btn-success btn-block" value="Add Row" id="adduser">
		             </div>
		        </div>
               </form><br><br><input type="button" class="form-control btn btn-lg btn-success btn-block" value="Upload Users" id="uploaduser" ><br><br>
          <div id="dataTableshow"></div>
		
 
		  

					 
					  
		  </div>
        </div> 
     </div>
	 

        <!-- jQuery -->
       <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function () {
			$('#adduser').click(function() {   // onload jQuery Ajax Call in PHP Script 
			
			   var usertest = 1;
			   var fname = $("#first_name").val();
			   var lname = $("#last_name").val();
			   var user_type = $("#user_id").val();
			   var email = $("#email").val();
               if (fname == "") {
					$("#first_name-info").html("Please enter the first name.");
					$("#first_name").addClass("input-error");
					 return false;
			  }
			  else if(lname == ""){
					 $("#last_name-info").html("Please enter last name.");
					 $("#last_name").addClass("input-error");
					 return false;
			 }
               else if(user_type == ""){
					 $("#user_id-info").html("Please select the user type.");
					 $("#user_id").addClass("input-error");
					 return false;
			 }	
              else if(email == ""){
					 $("#email-info").html("Please enter an email.");
					 $("#email").addClass("input-error");
					 return false;
			 }
              var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;    
			if(!regex.test(email)){    
			    $("#email-info").html("Email id is invalid.");
			    $("#email").addClass("input-error");   
			    return false;    
			}   			 
               $.ajax({
				type: 'POST',
				url: 'user-registrationlist.php',
				data: {usertest:usertest, fname:fname, lname:lname,user_type:user_type,email:email },
				cache: false,
				success: function(data){
				    $("#dataTableshow").html(data);
					
				  
				}
			  });
            });
			
			$('#uploaduser').click(function() {
			  alert("All users has been added successfully");
			});
			
		});

</script>
</body>
</html>

