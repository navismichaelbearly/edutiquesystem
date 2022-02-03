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
    </head>
    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar-inverse navbar-fixed-top" role="navigation">
               
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
                
                
                <div class="container-fluid">
                     <div class="row">
                        <div class="col-lg-12">
                                    
                                    <div class="row show-grid" style="padding:0px 150px;">
                                        <iframe src="<?php echo $_REQUEST['pth'] ?>" style="width:100%; height:600px;" frameborder="0" allowfullscreen></iframe>                                   

                                       
                                    </div>
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
        

    </body>
</html>
