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

/* Initialise PHP variables */
$new_password= $confirm_password ="";
$new_password_err = $confirm_password_err = "";

/* Select Query to get first time password change variable */
$stmt = $mysqli->prepare("SELECT first_time_password_change, tooltip FROM  edu_users  WHERE user_id = ? and user_status = ?");
/* Bind parameters */
$stmt->bind_param("ss", $param_uid,$param_urstatus);
/* Set parameters */
$param_uid = $_SESSION["id"];
$param_urstatus = $active;
$stmt->execute();
$stmt->bind_result($first_time_password_change, $tooltip);
$stmt->fetch();
$stmt->close();

$stmt = $mysqli->prepare("SELECT b.article_title, a.due_date, a.task_stages,a.article_id,a.activity_id, a.peer_id FROM edu_user_task a inner join edu_article b on a.article_id = b.article_id where task_status=? and assigned_to=?");
$stmt->bind_param("ss", $param_status, $param_user_id);
// Set parameters 
$param_status = $active;
$param_user_id = $_SESSION["id"];
$stmt->execute();
$stmt->store_result();
$total_pages = $stmt->num_rows;
$stmt->fetch();
$stmt->close();

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of results to show on each page.
$num_results_on_page = 3;
// Calculate the page to get the results we need from our table.
$calc_page = ($page - 1) * $num_results_on_page;


	
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
        <style>
               select {
                      font-family: 'Poppins'!important;
                      color: #0F96E8;background: #fff;
	                  border:none;
                      }
              .selectheadback{ background-color:transparent; font-family: 'Poppins'!important; }

              .selectoptionback{ background-color:#fff !important; color:#707683; font-family: 'Poppins'!important; }
			  div.ex1 {
				  height: 590px;
				  overflow-y: scroll;
				  padding:20px;
				}
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

            <div id="page-wrapper" >
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
                    <br>                 
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                     To-Do List
                                    <div class="pull-right">
                                        <div class="btn-group">
                                               <select id="selectTaskstsatus" name="selectTaskstsatus"  class="selectheadback" >
                                                     <!--<option value=" ">year</option>-->
                                                    
                                                    <option class="selectoptionback" value="Unopened">Unopened</option>
                                                    <option class="selectoptionback" value="Incomplete">Incomplete</option>
                                                    <option class="selectoptionback" value="Completed">Completed</option>
                                                    <option class="selectoptionback" value="Overdue">Overdue</option>
                                           </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body" >
                                    <!-- display data from Ajax call -->
                                    <div id="dataTableshow" class="ex1"></div>
                                    <?php #include 'inc/pagination.php'; // pagination script included  ?>
                                    
                                    <!--<div align="center">
                                         <a style="color:#0F96E8" id="showCompletedactivities">Show Completed Activities</a>
                                         <a style="color:#0F96E8" id="hideCompletedactivities">Hide Completed Activities</a>
                                    </div>-->
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            
                            
                        </div>
                        <!-- /.col-lg-8 -->
                        <div class="col-lg-4">
                            <div class="panel panel-default">
                                <!--<div class="panel-heading">
                                     Calendar
                                </div>-->
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div id="element"></div>
									
                                    
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
								    <!-- check which user is logged in and show content appropriately -->
                                    <?php if($_SESSION["utypeid"]==$admconst){ echo " Message Log"; } elseif($_SESSION["utypeid"]==$admstdconst){ echo "Overall Progress";} ?>
                                </div>
                                <div class="panel-body">
                                <?php if($_SESSION["utypeid"]==$admconst){  } elseif($_SESSION["utypeid"]==$admstdconst){  ?>
                                         <canvas id="myChart" width="270" height="270"></canvas>
                                <?php   } ?> 
                                    
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                           
                        </div>
                        <!-- /.col-lg-4 -->
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
		<script type="text/javascript" src="canvasjs.js"></script>
		<!-- Custom Theme JavaScript -->
		<script src="js/startmin.js"></script>
        
		<script>
		$(document).ready(function () {
		     //$('#hideCompletedactivities').hide(); // hide button
			$(window).on("load", function(){ // onload jQuery Ajax Call in PHP Script
			   var userId = '<?php echo $_SESSION["id"];?>';
			   var totPages = '<?php echo $num_results_on_page;?>';
			   var calPage = '<?php echo $calc_page ;?>';
			   var compAct = "";
			    var taskstsatusVal ="";
               $.ajax({
				type: 'POST',
				url: 'selectTodolist.php',
				data: {userId:userId,totPages:totPages,calPage:calPage,compAct:compAct,taskstsatusVal:taskstsatusVal},
				cache: false,
				success: function(data){
				   $("#dataTableshow").html(data);
				  
				}
			  });
            });
			
			/*$('#showCompletedactivities').click(function() { // onclick jQuery Ajax Call in PHP Script
			   $('#showCompletedactivities').hide(); // hide button
			   $('#hideCompletedactivities').show(); // show button
			   var userId = '<?php echo $_SESSION["id"];?>';
			   var totPages = '<?php echo $num_results_on_page;?>';
			   var calPage = '<?php echo $calc_page ;?>';
			   var compAct = 1;
			    var taskstsatusVal ="";
			   $.ajax({
				type: 'POST',
				url: 'selectTodolist.php',
				data: {userId:userId,totPages:totPages,calPage:calPage,compAct:compAct,taskstsatusVal:taskstsatusVal},
				cache: false,
				success: function(data){
				   $("#dataTableshow").html(data);
				  
				}
			  });
			});
			
			$('#hideCompletedactivities').click(function() { // onclick jQuery Ajax Call in PHP Script
			   $('#showCompletedactivities').show(); // show button
			   $('#hideCompletedactivities').hide(); // hide button
			   var userId = '<?php echo $_SESSION["id"];?>';
			   var totPages = '<?php echo $num_results_on_page;?>';
			   var calPage = '<?php echo $calc_page ;?>';
			   var compAct = "";
			   var taskstsatusVal ="";
			   $.ajax({
				type: 'POST',
				url: 'selectTodolist.php',
				data: {userId:userId,totPages:totPages,calPage:calPage,compAct:compAct,taskstsatusVal:taskstsatusVal},
				cache: false,
				success: function(data){
				   $("#dataTableshow").html(data);
				  
				}
			  });
			});*/
			
			$('#selectTaskstsatus').on('change', function () {
                    var userId = '<?php echo $_SESSION["id"];?>';
			        var totPages = '<?php echo $num_results_on_page;?>';
			        var calPage = '<?php echo $calc_page ;?>';
			        var compAct = "";
					var taskstsatusVal = $(this).val();
					   $.ajax({
								type: 'POST',
								url: 'selectTodolist.php',
								data: {taskstsatusVal:taskstsatusVal,userId:userId,totPages:totPages,calPage:calPage,compAct:compAct},
								cache: false,
								success: function(data){
								  $("#dataTableshow").html(data);
								}
					 });
             });
			
		});
		</script>
		<!-- Essential JS 2 Calendar's dependent scripts -->
		<script src="https://cdn.syncfusion.com/ej2/ej2-base/dist/global/ej2-base.min.js" type="text/javascript"></script>
		<script src="https://cdn.syncfusion.com/ej2/ej2-calendars/dist/global/ej2-calendars.min.js" type="text/javascript"></script>
		<script>
		// initialize the Calendar component
		var calendar = new ej.calendars.Calendar();
										 
		// Render the initialized button.
		calendar.appendTo('#element')
		
        // display chart in donut format - progress report		
		window.onload=function(){//from w w w. j  a v  a 2 s . co  m
			   var data = {
						   labels: ["Completed","Incomplete","Unopened", "Overdue"],
						   datasets: [
								  {
								   data: [60, 5, 10, 25],
								   backgroundColor: ["#18ce67","#ffcc00", "#c2cfe0", "#ef7739"],
								  }]
			   };
			   Chart.pluginService.register({
					 beforeDraw: function(chart) {
						var width = chart.chart.width,
						height = chart.chart.height,
						ctx = chart.chart.ctx,
						type = chart.config.type;
						if (type == 'doughnut')
						{
						  var percent = Math.round((chart.config.data.datasets[0].data[0] * 100) /
						 (chart.config.data.datasets[0].data[0] +
						 chart.config.data.datasets[0].data[1]));
						 var oldFill = ctx.fillStyle;
						 var fontSize = ((height - chart.chartArea.top) / 100).toFixed(2);
						 ctx.restore();
						 ctx.font = fontSize + "em sans-serif";
						 ctx.textBaseline = "middle"
						 /*var text = percent + "%",*/
						 var text = "60%",
						 textX = Math.round((width - ctx.measureText(text).width) / 2),
						 textY = (height + chart.chartArea.top) / 2;
						 ctx.fillStyle = chart.config.data.datasets[0].backgroundColor[0];
						 ctx.fillText(text, textX, textY);
						 ctx.fillStyle = oldFill;
						 ctx.save();
					   }
				   }
			  });
				   
			  var myChart = new Chart(document.getElementById('myChart'), {
				  type: 'doughnut',
				  data: data,
				  options: {
							 rotation: 0,
							 cutoutPercentage: 85,
							 responsive: true,
							 legend: {
									  display: true,
									  position: 'bottom'
									 }
						   }
			 });
		}
		</script> 

    </body>
</html>
