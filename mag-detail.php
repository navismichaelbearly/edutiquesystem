<?php
session_start();
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
        

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
		  .multiselect {
			  width: 200px;
			}
			
			.selectBox {
			  position: relative;
			}
			
			.selectBox select {
			  width: 100%;
			  font-weight: bold;
			}
			
			.overSelect {
			  position: absolute;
			  left: 0;
			  right: 0;
			  top: 0;
			  bottom: 0;
			}
			
			#checkboxes {
			  display: none;
			  background: #FFFFFF;
              box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.15);
			  padding:10px 10px;
			}
			
			#checkboxes label {
			  display: block;
			}
			
			#checkboxes label:hover {
			  background-color: #fff;
			}
			
			#checkboxes2 {
			  display: none;
			  background: #FFFFFF;
              box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.15);
			  padding:10px 10px;
			}
			
			#checkboxes2 label {
			  display: block;
			}
			
			#checkboxes2 label:hover {
			  background-color: #fff;
			}
		</style>
        <script>
		    var expanded = false;

			function showCheckboxes() {
			  var checkboxes = document.getElementById("checkboxes");
			  if (!expanded) {
				checkboxes.style.display = "block";
				expanded = true;
			  } else {
				checkboxes.style.display = "none";
				expanded = false;
			  }
			}
			
			function showCheckboxes2() {
			  var checkboxes2 = document.getElementById("checkboxes2");
			  if (!expanded) {
				checkboxes2.style.display = "block";
				expanded = true;
			  } else {
				checkboxes2.style.display = "none";
				expanded = false;
			  }
			}
		</script>
        <link rel="stylesheet" href="magfile/base.min.css"/>
         <link rel="stylesheet" href="magfile/fancy.min.css"/>
        <link rel="stylesheet" href="magfile/main.css"/>
        <script src="magfile/compatibility.min.js"></script>
        <script src="magfile/theViewer.min.js"></script>
        <script>
              try{
                 theViewer.defaultViewer = new theViewer.Viewer({});
              }catch(e){}
        </script>
        <link rel="stylesheet" href="assets/css/main11.css?version=1" />
        <!--<link rel="stylesheet" href="assets/css/html5sticky.css?version=1" -->/>
    </head>
    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar-inverse navbar-fixed-top" role="navigation">
                <!--<div class="navbar-header">
                    <a class="navbar-brand" href="index.html">Startmin</a>
                </div>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <ul class="nav navbar-nav navbar-left navbar-top-links">
                    <li><a href="#"><i class="fa fa-home fa-fw"></i> Website</a></li>
                </ul>

                <ul class="nav navbar-right navbar-top-links">
                    <li class="dropdown navbar-inverse">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell fa-fw"></i> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-comment fa-fw"></i> New Comment
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> Message Sent
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-tasks fa-fw"></i> New Task
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> secondtruth <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>-->
                <!-- /.navbar-top-links -->

                 <?php include 'inc/sidebar.php'; ?>
                </nav> 

            <div id="page-wrapper">
                
                
                <div class="container-fluid">
                     <div class="row">
                        <div class="col-lg-9">
                                    
                                    <div class="row show-grid" style="padding:0px 150px;">
                                        test
                        </div>
                         <div class="col-lg-3">
                               test2
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
        <!--<script>!window.jQuery && document.write(unescape('%3Cscript src="assets/js/jquery1.6.2.js"%3E%3C/script%3E'))</script>

    <script src="assets/js/respond.min.js"></script>
    <script src="assets/js/modernizr.custom.23610.js"></script>
    <script src="assets/js/html5sticky.js"></script>
    <script src="assets/js/prettyDate.js"></script-->>

    </body>
</html>
