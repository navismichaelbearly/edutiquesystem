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
        
        <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">

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
			  .tdclass{
				  padding: 5px 8px;
			  }
			   @media (min-width: 1200px) {
				   .modal-xlg {
					  width: 50%; 
				   }
				}
		</style>
        
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
                            <h3 id="grid-responsive-resets" class="headertext">Schools / Organisations</h3>
                            <div class="row">
                                <div class="col-lg-8" align="right">
                                      <span class='normaltext'>Show:</span>
                                      <span> 
                                           <select id="selectYear" name="selectYear"  class="selectheadback" style="font:'Poppins'!important;">
                                                     <!--<option value=" ">year</option>-->
                                                    <option class="selectoptionback"   value="2021"><span style="font:'Poppins'!important;">2021</span></option>
                                                    <option class="selectoptionback" value="2022">2022</option>
                                                    <option class="selectoptionback" value="2023">2023</option>
                                           </select>
                                      </span>
                                      <span class='normaltext'>Show:</span>
                                      <span> 
                                           <select id="selectStatus" name="selectStatus" class="selectheadback" style="font-family:'Poppins'!important;">
                                                             <!--<option value=" ">Status</option>-->
                                                            <option class="selectoptionback" value="Active" style="font-family:'Poppins'!important;"><span style="font-family:'Poppins'!important;">Active</span></option>
                                                            <option class="selectoptionback" value="Inactive">Inactive</option>
                                           </select>
                                      </span>
                                      <span class='normaltext'>Show:</span>
                                      <span> 
                                           <select id="selectCountry" name="selectCountry" class="selectheadback">
                                                            <!--<option value=" ">Country</option>-->                                                            
                                                            <option class="selectoptionback" value="All">All</option>
                                                            <option class="selectoptionback" value="Taiwan">Taiwan</option>
                                                            <option class="selectoptionback" value="Singapore">Singapore</option>
                                          </select>
                                      </span>
                                        
                                      <div id="dateFromserver"></div>
                                </div>
                                <div class="col-lg-4 buttontoppad">
                                      <button type="button" class="btn btn-default btn-xs btn-lg btn-success" data-toggle="modal" data-target="#myModal">Add New Users</button>
                                      &nbsp;&nbsp;
                                      <button type="button" class="btn btn-default btn-xs btn-lg btn-success" >Add Manually</button>
                                </div>
                            </div>  
                            <h3 id="grid-responsive-resets" class="headertext">Individual Subscribers</h3>
                            <div class="row">
                                <div class="col-lg-6" align="right">
                                      <span class='normaltext'>Show:</span>
                                      <span> 
                                           <select id="selectYearis" name="selectYearis"  class="selectheadback" >
                                                     <!--<option value=" ">year</option>-->
                                                    <option class="selectoptionback" value="2021">2021</option>
                                                    <option class="selectoptionback" value="2022">2022</option>
                                                    <option class="selectoptionback" value="2023">2023</option>
                                           </select>
                                      </span>
                                      <span class='normaltext'>Show:</span>
                                      <span> 
                                           <select id="selectStatusis" name="selectStatusis" class="selectheadback" >
                                                             <!--<option value=" ">Status</option>-->
                                                            <option class="selectoptionback" value="Active">Active</option>
                                                            <option class="selectoptionback" value="Inactive">Inactive</option>
                                           </select>
                                      </span>
                                      <table id='example1' class='table table-striped table-bordered' style='width:100%'>
                                        <thead>
                                            <tr>
                                                <th>Country</th>
                                                <th>No.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<tr>	   
			                                <td class='normaltext'>Malaysia </td>
			                                <td class='normaltext'>35 </td>
                                        </tr>
                                        <tr>	   
			                                <td class='normaltext'>Singapore </td>
			                                <td class='normaltext'>200 </td>
                                        </tr>
                                        <tr>	   
			                                <td class='normaltext'>Taiwan </td>
			                                <td class='normaltext'>20 </td>
                                        </tr>
                                        </tbody>
                                     </table>      
                                </div>
                                <div class="col-lg-6 buttontoppad">
                                      <button type="button" class="btn btn-default btn-xs btn-lg btn-success" data-toggle="modal" data-target="#myModal">Add New Users</button>
                                      &nbsp;&nbsp;
                                      <button type="button" class="btn btn-default btn-xs btn-lg btn-success" >Add Manually</button>
                                </div>
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
                      <h4 class="modal-title" align="center">Add New Bulk Users</h4><br>
                      <div id="bulkuserfirst" align="center">
                          <p class="normaltext" align="center"><?php echo $uploadUsertext;?>.</p>
                          <button type="button" class="btn btn-lg btn-success btn-block" id="uploadFile" style="width:200px;">Upload File</button>
                          
                          <p class="normaltext" align="center" style="margin-top:10px;"><?php echo $downTemp;?>.</p>
                          <button type="button" class="btn btn-lg btn-success btn-block" style="width:200px;" data-toggle="modal" data-target="#myModal1" >Add Manually</button>
                      </div>
                      <div id="bulkusersecond">
                          <p class="normaltext">Upload .CSV file:</p>
                          <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data"  >
                                <fieldset>
                                         <div class="form-group">
                                                <span id="uploaded_image" ></span>
                                                <input type="file" id="file" class="FileUpload form-control"   required />
                                                <div class="dropZoneOverlay form-group"><br /><br />
                                                    Drag and drop files here <br />
                                                    <img src="images/imgupload.png">
                                                </div>
                                           
                                             <!--<input type="file"  name="file" id="file" class="form-control"  required >
                                             <input type='hidden' name="action" value="uploadfiles" />-->
                               
                                         </div> 
                                         <div class="form-group" align="center">
                                             <input type="button" class="btn btn-lg btn-success btn-block" value="Add" id="uploadcsv" style="width:150px;">
                                         </div>
                               </fieldset>
                          </form>
                      </div>                   
                     
                 </div>
                  <!--<div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 </div>-->
             </div>
      
         </div>
      </div>
      
      <!-- Modal popup form to add user manually -->
      <div class="modal fade" id="myModal1" role="dialog">
           <div class="modal-dialog modal-xlg">
    
              <!-- Modal content-->
              <div class="modal-content">
                  <!--<div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Change Your Password</h4>
                      <p class="normaltext"><?php echo $passwordStrengthtext;?>.</p>
                  </div>-->
				  
				  
				  <div class="modal-body">
				      <div class="row"> 
					      <div align="center"><h4 class="modal-title">Add new users</h4></div>
						  <form role="form" action="" method="post"  >
                          <fieldset>
                          <div class="col-lg-6"> 
                              
                                        <label>Name</label>
                                        <input class="form-control" placeholder="Name" name="Name" type="text" id="Name"  ><br>
								        <div id="new_chq"></div>
								        <input type="hidden" value="1" id="total_chq">
								        <input type="button" class="btn btn-lg btn-success btn-block add" value="+" id="Add" style="background-color:#e7e7e7; color:#333; border:none">
                                        <br>
                                        <label>Country</label>
								        <select name="user_id" id="user_id" class="form-control" required>
							            <option value="">Singapore</option>
							            <option value="">Malaysia</option>
							            <option value="">China</option>
							            </select><br>
							            <label>School/Organisation</label><br>
							            <select name="user_id" id="user_id" class="form-control" required>
							            <option value="">Section A</option>
							            <option value="">Section B</option>
							            <option value="">Section C</option>
								        </select><br>
								        <label>Address</label><br>
								        <input class="form-control" placeholder="Address" name="address" id="address" type="address" >
								        <label>Postal Code: </label><br>
								        <label>Singapore</label>
								        <table>
								           <tr>
								              <td>
								                  <input class="form-control" placeholder="Postal Code" name="postal code" id="postal code" >
								              </td>
								           </tr>
								        </table>
								        <br>
								        <label>Level</label><br>
								        <table cellspacing="10">
								            <tr>
								               <td width="70%" class="tdclass">
												   <select name="user_id" id="user_id" class="form-control" required>
													   <option value="">Level A</option>
													   <option value="">Level B</option>
													   <option value="">Level C</option>	  
												   </select>
								               </td>
								               <td width="30%" class="tdclass">
								                  <input class="form-control" placeholder="Level" name="level" id="level" type="level" >
								               </td>
								            </tr>
								        </table>
								        <br>
							
								        <label>Class</label><br>
								        <select name="user_id" id="user_id" class="form-control" required>
											<option value="">Class A</option>
											<option value="">Class B</option>
											<option value="">Class C</option>
								        </select><br>
								        <label>Subscribed Products</label><br>
								        <input type="checkbox" id="issue" name="issue" value="issue">
								        <label for="by issue"> By Issue</label><br>
								        <table>
								             <tr>
								                <td width="25%" class="tdclass">
								                   <select name="user_id" id="user_id" class="form-control" required>
														<option value="">Issue</option>
														<option value="">I magazine</option>
														<option value="">inspire</option>
								                   </select>
								                 </td>
								                <td width="25%" class="tdclass">
								                    <input class="form-control" placeholder="Issue" name="Issue" id="issue" type="issue" >
								                </td>
								                <td width="25%">
								                    <input type="hidden" value="1" id="total_addissue">
													<input type="button" class="btn btn-lg btn-success btn-block addissue" value="+" id="Add"  style="background-color:#e7e7e7; color:#333;border:none"  >
								                </td> 
								                <td width="25%" class="tdclass">&nbsp;</td>
								             </tr>
								        </table>
								        <br>
								        <label for="by issue"> By Article</label><br>
								        <table cellspacing="10">
								           <tr>
								               <td width="40%" class="tdclass" >
								                  <input class="form-control" placeholder="No." name="No." id="No." type="No." >
								               </td>
								               <td width="60%">
								                  <select name="user_id" id="user_id" class="form-control" required>
								                      <optgroup label = "Inspire/I-Think">
															<option value="">Descriptive</option>
															<option value="">Expository</option>
															<option value="">Argumentative</option>
															<option value="">Personal Recount</option>
															<option value="">Hybrid</option>
															<option value="">Reflective/Personal Response</option>
													  </optgroup>		
								                      <optgroup label = "I Magazine">
															<option value="">Intermediate</option>
															<option value="">Advanced</option>  
								                      </optgroup>
								                 </select>
								               </td>
								           </tr>
								       </table>
								       <br>
								       <label for="by issue"> By Skill</label><br>
								       <table cellspacing="10">
										   <tr>
											  <td width="40%" class="tdclass" >
												 <input class="form-control" placeholder="No." name="No." id="No." type="No." >
											  </td>
											  <td width="60%">
												 <select name="user_id" id="user_id" class="form-control" required>
													<option value="">Listening Comprehension</option>
													<option value="">Oral</option>
													<option value="">Reading Comprehension</option>
													<option value="">Language Editing</option>
													<option value="">Argumentative Essay</option>
													<option value="">Descriptive Essay</option>
													<option value="">Expository Essay</option>
													<option value="">Personal Re-Count Essay</option>
													<option value="">Situational Writing</option>
												  </select>
											   </td>
										   </tr>
								       </table>
								       				  
						  </div>
                          <div class="col-lg-6">
						         <label for="by issue"> Teacher IC:</label><br>
								 <input class="form-control" placeholder="Teacher IC" name="Teacher IC" id="Teacher IC" type="Teacher IC" ><br>
								 <label for="by issue"> Email:</label><br>
								 <input class="form-control" placeholder="Email" name="Email" id="Email" type="Email" ><br>
								 <label for="by issue"> EL Teacher</label><br>
								 <input class="form-control" placeholder="EL Teacher" name="EL Teacher" id="EL Teacher" type="EL Teacher" ><br>
								 <label for="by issue"> Email:</label><br>
								 <input class="form-control" placeholder="Email" name="Email" id="Email" type="Email" ><br>
								 <label for="start date">Start Date:</label> <br>
								 <input type="text" class="form-control"  id="startdate" name="startdate" placeholder="Start Date" onfocus="(this.type='date')"><br>
								 <label for="end date">End  Date:</label><br> 
								 <input type="text" class="form-control"  id="enddate" name="enddate" placeholder="End Date" onfocus="(this.type='date')">	<br>
                                 <input type="button" class="btn btn-lg btn-success btn-block add" value="Submit" id="submit" >							   
						  </div>
                          </fieldset>
                          </form>    
                     </div>
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

        <!-- Custom Theme JavaScript -->
        <script src="js/startmin.js"></script>
        
        <script src=" https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap.min.js"></script>
        <script>
		    
               $(document).ready(function(){
			      
			      
				  $('#example1').dataTable({
						"bPaginate": true,
						"bLengthChange": false,
						"bFilter": false,
						"bInfo": true,
						"bAutoWidth": false 
				  });
                  $(window).on('load', function() { // onload jQuery Ajax Calls in PHP Script
						var testPass = 1;
						var countryVal ='All';
						var subsStatus = '<?php echo $active; ?>';
						var yearVal ='<?php echo date("Y"); ?>';
					   $.ajax({
								type: 'POST',
								url: 'selectsubscriberlist.php',
								data: {testPass:testPass,countryVal:countryVal,subsStatus:subsStatus,yearVal:yearVal},
								cache: false,
								success: function(data){
								   $("#dateFromserver").html(data);
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
				 
				 
				 
				   $('#selectYear').on('change', function () {
                    var testPass = 1;
					var countryVal = ''; 
					var subsStatus = '';
					var yearVal = $(this).val();
					   $.ajax({
								type: 'POST',
								url: 'selectsubscriberlist.php',
								data: {testPass:testPass,countryVal:countryVal,subsStatus:subsStatus,yearVal:yearVal},
								cache: false,
								success: function(data){
								   $("#dateFromserver").html(data);
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
				
				   $('#selectStatus').on('change', function () {
                    var testPass = 1;
					var countryVal = ''; 
					var subsStatus = $(this).val();
					var yearVal ='';
					   $.ajax({
								type: 'POST',
								url: 'selectsubscriberlist.php',
								data: {testPass:testPass,countryVal:countryVal,subsStatus:subsStatus,yearVal:yearVal},
								cache: false,
								success: function(data){
								   $("#dateFromserver").html(data);
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
				 
				   $('#selectCountry').on('change', function () {
                    var testPass = 1;
					var countryVal = $(this).val(); 
					var subsStatus = '';
					var yearVal ='';
					   $.ajax({
								type: 'POST',
								url: 'selectsubscriberlist.php',
								data: {testPass:testPass,countryVal:countryVal,subsStatus:subsStatus,yearVal:yearVal},
								cache: false,
								success: function(data){
								   $("#dateFromserver").html(data);
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
				
				 
				 $("#bulkusersecond").hide();
				 $("#uploadFile").click(function(){
				           $("#bulkuserfirst").hide();
                           $("#bulkusersecond").show();
                 });
				 
				  $("#uploadcsv").click(function(){
				 //$(document).on('submit', '#uploadcsv', function(){
                   var name = document.getElementById("file").files[0].name;
                   var form_data = new FormData();
                   var ext = name.split('.').pop().toLowerCase();
				   /*Image Validation - checks for the type and size*/
                   if(jQuery.inArray(ext, ['csv']) == -1){
                      alert("Invalid File. Upload only CSV file");
					  return false;
                   }
                   var oFReader = new FileReader();
                   oFReader.readAsDataURL(document.getElementById("file").files[0]);
                   var f = document.getElementById("file").files[0];
                   var fsize = f.size||f.fileSize;
                   if((fsize > 100000000)){
                      alert("Image File Size should be less than 100MB");
                   }
                   else{
                       form_data.append("file", document.getElementById('file').files[0]);
					   
					   /* jQuery Ajax Call in PHP Script */
                       $.ajax({
                               url:"uploadbulkuser.php",
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
	                                  window.location='subscriber-list.php';
                               }
                       });
                   }
                 });
              });
             
			  function drag_start(event) {
                var style = window.getComputedStyle(event.target, null);
                var str = (parseInt(style.getPropertyValue("left")) - event.clientX) + ',' + (parseInt(style.getPropertyValue("top")) - event.clientY) + ',' + event.target.id;
                event.dataTransfer.setData("Text", str);
              }

              function drop(event) {
                var offset = event.dataTransfer.getData("Text").split(',');
                var dm = document.getElementById(offset[2]);
                dm.style.left = (event.clientX + parseInt(offset[0], 10)) + 'px';
                dm.style.top = (event.clientY + parseInt(offset[1], 10)) + 'px';
                event.preventDefault();
                return false;
              }

              function drag_over(event) {
                event.preventDefault();
                return false;
             }
					
$('.add').on('click', add);
    

function add() {
  var new_chq_no = parseInt($('#total_chq').val()) + 1;
  var new_input = "<input type='text' id='new_" + new_chq_no + "' class='form-control'><br>";

  $('#new_chq').append(new_input);
  
  $('#total_chq').val(new_chq_no);
}

$('.addissue').on('click', addissue);
    

function addissue() {
  var new_addissue_no = parseInt($('#total_addissue').val()) + 1;
  var new_input_addissue = "<tr><td class='tdclass'><select name='user_id' id='user_id' class='form-control' required><option value=''>Issue</option><option value=''>I magazine</option><option value=''>inspire</option></select></td><td class='tdclass'><input type='text' id='new_" + new_addissue_no + "' class='form-control'></td><td>&nbsp;</td><td>&nbsp;</td></tr>";

  $('#new_addissue').append(new_input_addissue);
  
  $('#total_addissue').val(new_addissue_no);
}

		</script>

    </body>
</html>
