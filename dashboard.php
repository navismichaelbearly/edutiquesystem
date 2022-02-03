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
                        <div class="col-lg-12">
                            <h3 class="page-header" style="color:#3F3A60">Welcome back, <?php echo $_SESSION["fname"];?>! </h3>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                 
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                     Announcements/Notifications
                                    <div class="pull-right">
                                        <div class="btn-group">
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body" >
                                    <!-- display data from Ajax call -->
                                    <div id="dataTableshow"></div>
                                    <div align="center"><a href="announcement.php" style="color:#0F96E8">view more</a></div>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                     Question Portal
                                    <div class="pull-right">
                                        <div class="btn-group">
                                            <!--<button type="button" class="btn btn-default btn-xs">-->
                                                <a href="question-portal-list.php" class="btn btn-default btn-xs">New Question</a> 

                                            <!--</button>-->
                                        </div>
                                    </div>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <!-- display data from Ajax call -->
                                    <div id="dataTableshow1"></div>
                                    <div align="center"><a href="question-portal-list.php" style="color:#0F96E8">view more</a></div>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                            
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
                                    <!--<div id='calendar'></div>-->
									
                                    
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
        
        
       
       <!-- Modal popup form to change password -->
       <div class="modal fade" id="myModal" role="dialog">
           <div class="modal-dialog">
    
              <!-- Modal content-->
              <div class="modal-content">
                  <!--<div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Change Your Password</h4>
                      <p class="normaltext"><?php echo $passwordStrengthtext;?>.</p>
                  </div>-->
                  <div class="modal-body">
                      <h4 class="modal-title">Change Your Password</h4>
                      <p class="normaltext"><?php echo $passwordStrengthtext;?>.</p>
                      <form role="form" action="" method="post"  >
                            <fieldset>
                                <label>New Password</label>
                                <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                                    <input class="form-control" placeholder="New Password" name="new_password" type="password" id="new_password"  >
                                    <span id="new_password-info" class="info"></span>
                                    <span class="help-block"><?php echo $new_password_err; ?></span>
                                </div>
                                <label>Confirm New Password</label>
                                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                    <input class="form-control" placeholder="Confirm Password" name="confirm_password" id="confirm_password" type="password"  >
                                    <span id="confirm_password-info" class="info"></span>
                                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                                </div>
                                <input type="hidden" name="keytoken" value="<?php echo $keytoken;?>">  
                                <input type="hidden" name="email" value="<?php echo $email;?>">
                                <input type="hidden" name="passaction" value="reset">
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Change Password" id="chagepass"  >
                            </fieldset>
                        </form>
                 </div>
                  <!--<div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 </div>-->
             </div>
      
         </div>
      </div>

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
		<script>
		$(document).ready(function () {
		     $(window).on('load', function() { // onload jQuery Ajax Calls in PHP Script
						var userId = '<?php echo $_SESSION["id"];?>';
					    var totPages = 2;
						var calPage = 0;
						var compAct = "";
					   $.ajax({
								type: 'POST',
								url: 'selectannouncementlist.php',
								data: {userId:userId,totPages:totPages,calPage:calPage},
								cache: false,
								success: function(data){
								   $("#dataTableshow").html(data);
								  
								}
					});
			        var userId = '<?php echo $_SESSION["id"];?>';
			        var totPages = 2;
			        var calPage = 0;
			        var dashVar = 1;
					var qpId = '';
					var sendMessage ='';
                    $.ajax({
				           type: 'POST',
				           url: 'data/selectQuestionportallist.php',
				          data: {userId:userId,totPages:totPages,calPage:calPage,dashVar:dashVar,qpId:qpId,sendMessage:sendMessage},
				          cache: false,
				          success: function(data){
				                 $("#dataTableshow1").html(data);
				  
				          }
			      });
		    });	
			// display popup on page load
			var wrapperVar = document.getElementById("wrapper");
			<?php if($first_time_password_change ==0){?>
					$(window).on('load', function() {
							$('#myModal').modal({
                                      backdrop: 'static',
                                      keyboard: true, 
                                     show: true
							 });		 
						    wrapperVar.classList.add("wrappervar");						 
                
					});	
			<?php } 
			      if( ( $tooltip == 0 ) && ( $first_time_password_change == 1 ) ) {?>
				       if (window.innerWidth < 768) {
				          $("#testsidemenu").addClass("in");
				         // $('#testsidemenu').setAttribute("aria-expanded","true");
						 //$('.tooltipcls').attr('data-html', true);
                         //$('.tooltipcls').attr('data-placement', "bottom");
						  $(window).on("load", function(){
                               $('[data-toggle="tooltip"]').tooltip().mouseover();   
                          });
					      var mainelement = document.getElementById("testback");
					      mainelement.classList.add("darkback");
					      $('body').css('overflow', 'hidden');
					      document.getElementById("page-wrapper").classList.add("darkback2");
					   }
			           $(window).on("load", function(){
                               $('[data-toggle="tooltip"]').tooltip().mouseover();   
                       });
					   var mainelement = document.getElementById("testback");
					   mainelement.classList.add("darkback");
					   $('body').css('overflow', 'hidden');
					   document.getElementById("page-wrapper").classList.add("darkback2");
					   //wrapperVar.classList.add("wrappervar");
					 
					   $(".tooltipcls, .tooltip").mouseleave(function(){
							$('[data-toggle="tooltip"]').tooltip().mouseover();
					   });
  
					   $('body').on('click', function (e) {
                               $('[data-toggle="tooltip"]').each(function () {
                                         // hide any open tooltip when the anywhere else in the body is clicked
                                         $(this).tooltip('hide');
							             $.ajax({
										         type: 'POST',
										         url: 'updatetooltip.php',
										         data: {tooltipvalue:1},
										         cache: false,
										         success: function(data){
										                //alert('Password has been updated successfully');
										                window.location='dashboard.php';
										   
										         }
									    });event.preventDefault();
                              });
                      });
			<?php }?>		   
			
			$('#chagepass').click(function() {
			  $(".info").html("");
			  $("inputBox").removeClass("input-error");
			  var new_password = $("#new_password").val();
			  var confirm_password = $("#confirm_password").val();
			  
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
			
			// confirm password and jQuery Ajax Call in PHP Script 
			if(confirm_password == new_password) { 
			  $.ajax({
				type: 'POST',
				url: 'ajax-change-pass.php',
				data: {confirm_password:confirm_password},
				cache: false,
				success: function(data){
				   alert('Password has been updated successfully');
				   window.location='dashboard.php';
				   
				}
			 });event.preventDefault();
		  
			}
			
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
		
		 document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');
		
			var calendar = new FullCalendar.Calendar(calendarEl, {
			  headerToolbar: {
				left: 'title',
				center: '',
				//right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
				right: 'prev,next'
			  },
			  initialDate: '2021-10-01',
			  navLinks: true, // can click day/week names to navigate views
			  businessHours: true, // display business hours
			  editable: true,
			  selectable: true,
			  events: [
				{
				  title: '',
				  start: '2021-10-03T00:00:00',
				  constraint: 'businessHours',
				  color: 'grey'
				},
				{
				  title: '',
				  start: '2021-10-13T00:00:00',
				  constraint: 'availableForMeeting', // defined below
				  color: 'orange'
				},
				{
				  title: '',
				  start: '2021-10-18T00:00:00',
				  color: 'green'
				},
				{
				  title: '',
				  start: '2021-10-29T20:00:00',
				  color: 'yellow'
				},
		
				// areas where "Meeting" must be dropped
				{
				  groupId: 'availableForMeeting',
				  start: '2020-09-11T10:00:00',
				  end: '2020-09-11T16:00:00',
				  display: 'background'
				},
				{
				  groupId: 'availableForMeeting',
				  start: '2020-09-13T10:00:00',
				  end: '2020-09-13T16:00:00',
				  display: 'background'
				},
		
				// red areas where no events can be dropped
				{
				  start: '2020-09-24',
				  end: '2020-09-28',
				  overlap: false,
				  display: 'background',
				  color: '#ff9f89'
				},
				{
				  start: '2020-09-06',
				  end: '2020-09-08',
				  overlap: false,
				  display: 'background',
				  color: '#ff9f89'
				}
			  ]
			});
		
			calendar.render();
		  });
		</script> 

    </body>
</html>
