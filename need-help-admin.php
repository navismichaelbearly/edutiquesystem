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
    <body oncontextmenu="return false;" >

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
                    
                 
                    
					 <div class="row">
						 
                        <div class="col-lg-9" >&nbsp;
						    
							<div class="pageTitlenew">Frequently Asked Questions</div><br>
					       
					          <div class="row">
                                   <div class="col-lg-6"  >
					                    <a href="educator-faq.php" class="btn btn-lg btn-success btn-block stptbuttontoppad">For Educators</a>
                                   </div>
                                   <div class="col-lg-6"  >     
					                   <a href="student-faq.php" class="btn btn-lg btn-success btn-block stptbuttontoppad">For Students</a>
                                   </div>
                                   <div class="col-lg-6"  >
					                    <a href="parent-faq.php" class="btn btn-lg btn-success btn-block stptbuttontoppad">For Parents</a>
                                   </div>
                                   <div class="col-lg-6"  >     
					                   <a href="addFAQ.php" class="btn btn-lg btn-success btn-block stptbuttontoppad" style=" color:#888889;border:2px dashed #888889; background-color:#f5f6f8">+ Add New</a>
                                   </div>
                              </div>
							</div>
                        <div class="col-lg-3"  >
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                     
                     <div class="row">
                                <br><br>
                                <div class="col-lg-10">                                   
                                      <div class="pageTitlenew">Message Log </div>
                                      <div align="right">
                                          <span class='normaltext'>Show:</span>
                                          <span> 
                                               <select id="selectMessagelog" name="selectCountry" class="selectheadback" >
                                                                <!--<option value=" ">Country</option>-->                                                            
                                                                <option  style="font:'Britannic Bold' !important"  value="All" >All</option>
                                                                <option class="selectoptionback" value="Resolved">Resolved</option>
                                                                <option class="selectoptionback" value="Unresolved">Unresolved</option>
                                              </select>
                                          </span>
                                      </div>
                                        
                                      <div id="dataMessagelog"></div>
                                </div>
                                
                                
                                <div class="col-lg-2 buttontoppad">
                                       
                                </div>
                    </div>
                    <div class="row">              
                                <br><br>
                                <div class="col-lg-10" >                                   
                                      <div class="pageTitlenew">Tech Support Log </div>
                                      <div align="right">
                                          <span class='normaltext'>Show:</span>
                                          <span> 
                                               <select id="selectTechsup" name="selectCountry" class="selectheadback">
                                                                <!--<option value=" ">Country</option>-->                                                            
                                                                <option class="selectoptionback" value="All">All</option>
                                                                <option class="selectoptionback" value="Resolved">Resolved</option>
                                                                <option class="selectoptionback" value="Unresolved">Unresolved</option>
                                              </select>
                                          </span>
                                      </div>
                                        
                                      <div id="dataTechsuplog"></div>
                                </div>
                                <div class="col-lg-2 buttontoppad">
                                       
                                </div>
                       </div>  
                        
                        
                    <!-- /.row -->
                    <div class="chatBox" ><a href="live-chat.php" class="btn btn-default btn-xl">Chat with support</a></div>
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
		$(document).ready(function () {
                  $(window).on('load', function() { // onload jQuery Ajax Calls in PHP Script
						var messagelog = 'messagelog';
						var mesageVal ='All';
						var techsuplog = '';
					   $.ajax({
								type: 'POST',
								url: 'data/messageLoglist.php',
								data: {messagelog:messagelog,techsuplog:techsuplog,mesageVal:mesageVal},
								cache: false,
								success: function(data){
								   $("#dataMessagelog").html(data);
								   $('#example').dataTable({
										"bPaginate": true,
										"bLengthChange": false,
										"bFilter": false,
										"bInfo": true,
										"bAutoWidth": false 
								  });
								}
					 });
					 
					 var techsuplog = 'techsuplog';
						var mesageVal ='All';
						var messagelog = '';
					   $.ajax({
								type: 'POST',
								url: 'data/messageLoglist.php',
								data: {messagelog:messagelog,techsuplog:techsuplog,mesageVal:mesageVal},
								cache: false,
								success: function(data){
								   $("#dataTechsuplog").html(data);
								   $('#example1').dataTable({
										"bPaginate": true,
										"bLengthChange": false,
										"bFilter": false,
										"bInfo": true,
										"bAutoWidth": false 
								  });
								}
					 });
			        
		         });
				 
				 $('#selectMessagelog').on('change', function () {
                    var techsuplog = '';
					var messagelog = 'messagelog'; 
					var mesageVal = $(this).val();
					   $.ajax({
								type: 'POST',
								url: 'data/messageLoglist.php',
								data: {messagelog:messagelog,techsuplog:techsuplog,mesageVal:mesageVal},
								cache: false,
								success: function(data){
								   $("#dataMessagelog").html(data);
								   $('#example').dataTable({
										"bPaginate": true,
										"bLengthChange": false,
										"bFilter": false,
										"bInfo": true,
										"bAutoWidth": false 
								  });
								}
					 });
                   });
				   
				   $('#selectTechsup').on('change', function () {
                    var techsuplog = 'techsuplog';
					var messagelog = ''; 
					var mesageVal = $(this).val();
					   $.ajax({
								type: 'POST',
								url: 'data/messageLoglist.php',
								data: {messagelog:messagelog,techsuplog:techsuplog,mesageVal:mesageVal},
								cache: false,
								success: function(data){
								   $("#dataTechsuplog").html(data);
								   $('#example1').dataTable({
										"bPaginate": true,
										"bLengthChange": false,
										"bFilter": false,
										"bInfo": true,
										"bAutoWidth": false 
								  });
								}
					 });
                   });
				   
				   $(document).on("change", "#messStatuschange", function(){
				   //$('#messStatuschange').on('change', function () { 
					var messagelog = '<?php echo $nontech;?>'; 
					var mesageStatusval = $(this).val();
					   $.ajax({
								type: 'POST',
								url: 'data/updateMestechlogstatus.php',
								data: {messagelog:messagelog,mesageStatusval:mesageStatusval},
								cache: false,
								success: function(data){
								   window.location='need-help-admin.php';
								}
					 });
                   });
				   
				   $(document).on("change", "#techStatuschange", function(){
				   //$('#messStatuschange').on('change', function () { 
					var messagelog = '<?php echo $tech;?>'; 
					var techStatusval = $(this).val();
					   $.ajax({
								type: 'POST',
								url: 'data/updateMestechlogstatus.php',
								data: {messagelog:messagelog,techStatusval:techStatusval},
								cache: false,
								success: function(data){
								   window.location='need-help-admin.php';
								}
					 });
                   });
			  
		});
		</script>
		
		
		

    </body>
</html>
