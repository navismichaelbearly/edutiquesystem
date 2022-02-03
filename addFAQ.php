<?php
/* to display errors */
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start(); /*Session Start*/
/* Checks if user is logged in to the system if not then it will be redirected to login page - security */
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
/* include files */
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
		
       <!-- <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>-->
        <link href='lib/main.css' rel='stylesheet' />
        <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
        <style> 
		       select {
                      font-family: 'Poppins'!important;
                      color: #0F96E8;background: #fff;
	                  border:none;
                      }
              .selectheadback{ background-color:transparent; font-family: 'Poppins'!important; }

              .selectoptionback{ background-color:#fff !important; color:#707683; font-family: 'Poppins'!important; }
			 
		</style>
        
    </head>
    <body oncontextmenu="return false;"  style="background-color:#f5f6f8" >

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

            <div id="page-wrapper" ><div id="testback"></div>
                <div class="row">
                        <div class="col-lg-12 searchbar toppad">
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
                    
                 
                    <form name="addNQform" id="addNQform">
					 <div class="row">
						 
                        <div class="col-lg-12">&nbsp;
						    
							<div >
                                <table style="background-color:transparent">
                                   <tr>
                                      <td class="pageTitlenew">FAQs for &nbsp;&nbsp;</td>
                                      <td>
                                          <!--<input type="text" name="faqfor[]"  class="form-control" placeholder="Stakeholder" required="required" id="faqfor">-->
                                          <select name="faqfor[]" required="required" id="faqfor" class="form-control" >
                                               <option>Select Stakeholder</option>
												 <?php
                                                        if ($stmt = $mysqli->prepare("SELECT id,faq_type FROM edu_faq_type where status=?")) {
                    
                                                                   $stmt->bind_param("s", $param_status);
                                                                 // Set parameters 
                                                                 $param_status = $active;
                                                                
                                                                 
                                                                 $stmt->execute();
                                                                 /* bind variables to prepared statement */
                                                                 $stmt->bind_result($faq_id, $faq_type);
                                                                 $sr =1;
                                                                 /* fetch values */
                                                                 while ($stmt->fetch()) {
                                                                            
                                                                      echo " <option value='".$faq_id."'>".$faq_type."</option>";
                                                                }
                                                         }				
                                                ?>
										 </select>
                                      </td>
                                   </tr>
                                 </table> 
                            </div><br>
                            <div id="dynamic_field">
                               <p>
                                  <input type="text" name="questiontext[]"   class="form-control" placeholder="Question" required="required">
                                  
                               </p>
					           <textarea class="form-control" rows="1"   name="messagetext[]"  placeholder="Answer" required></textarea><br>
                              
					         </div>
                             <button type="button" class="btn btn-lg btn-success btn-block " id="addNQ" name="addNQ" >Add a new question</button>
                              <!--<button class="btn btn-lg btn-success btn-block " id="saveNQ" >Save Changes</button>-->
                              <br><br> 
                             <div class="chatBox"><button  class="btn btn-default btn-xl" id="saveNQ" >Save Changes</button></div>
                             
						</div>
                        
                        <!-- /.col-lg-12 -->
                    </div>
                    </form>
                     
                     
                        
                        
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
		<script type="text/javascript" src="canvasjs.js"></script>
		<!-- Custom Theme JavaScript -->
		<script src="js/startmin.js"></script>
        <script src='lib/main.js'></script>
        <script src=" https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap.min.js"></script>
		<script>
		
		
		$(document).ready(function(){
		  
	      var i=1;
	      $('#addNQ').click(function(){
		     i++;
		
		     $('#dynamic_field').append('<div id="row'+i+'"><input type="text" name="faqfor[]" id="faqfor'+i+'" class="form-control faqfor_input" placeholder="Stakeholder" style="display:none;"><p><input type="text" name="questiontext[]"  class="form-control questiontext_input" placeholder="Question" required></p><textarea class="form-control" rows="1"   name="messagetext[]" placeholder="Answer" required></textarea><br></div>');
	         var $src = $('#faqfor'),
             $dst = $('#faqfor'+i);
		     $dst.val($src.val());
	      });
	    
	       
			//$('#saveNQ').click(function(){	
			$("#addNQform").on("submit", function () {
			 
          
				$.ajax({
					url:"data/insertNewFAQquestion.php",
					method:"POST",
					data: $('#addNQform').serialize(),
					success:function(data)
					{
						alert("FAQ Qustion and Answer added sucessfully");
						window.location='addFAQ.php';
						$('#addNQform')[0].reset();
					}
				});event.preventDefault();
				//}
			});
			
	
        });
		</script>
		
		
		

    </body>
</html>
