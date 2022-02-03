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
				  padding: 5px 8px 5px 0px;
			  }
			  .divbottomspace { padding-bottom:8px;}
			  .date-selector-start {
				  position: relative;
				}
				
				.date-selector-start>input[type=date] {
				  text-indent: -500px;
				}
				
				.date-selector-end {
				  position: relative;
				}
				
				.date-selector-end>input[type=date] {
				  text-indent: -500px;
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
						  <form role="form" action="" method="post"  id="addUsermanually" name="addUsermanually">
                          <fieldset>
                          <div class="col-lg-6"> 
                              
                                        <label>Name</label>
                                        <div id="dynamic_field">
                                           <input class="form-control" placeholder="name" name="name[]" type="text"  id="name"   >
                                        </div>
                                        <br>
								        <!--<div id="new_chq"></div>
								        <input type="hidden" value="1" id="total_chq">-->
								        <input type="button" class="btn btn-lg btn-success btn-block add" value="+" id="addName" style="background-color:#e7e7e7; color:#333; border:none">
                                        <br>
                                        <label>Country</label>
										<select name="countryId" id="countryId" class="form-control country" >
                                        <option>Select Country</option>
										<?php
										      if ($stmt = $mysqli->prepare("SELECT country_id,country_name FROM edu_country where country_status=?")) {
    
												   $stmt->bind_param("s", $param_status);
												 // Set parameters 
												 $param_status = $active;
												
												 
												 $stmt->execute();
												 /* bind variables to prepared statement */
												 $stmt->bind_result($country_id, $country_name);
												 $sr =1;
												 /* fetch values */
												 while ($stmt->fetch()) {
													  		
													  echo " <option value='".$country_id."_".$country_name."'>".$country_name."</option>";
												}
											 }						
											 
										?>
							            </select><br><span id="countryId-info" class="info"></span><br>
							            <label>School/Organisation</label><br>
                                        

                                        <!--<input type="text" list="school_name" name="schoolName" class="form-control">
                                        <datalist id="school_name">
                                           
                                        </datalist>-->


							            <select name="schoolName" id="schoolName" class="form-control" >
                                        <option>Select School</option>
										 <?php
												if ($stmt = $mysqli->prepare("SELECT school_id,school_name FROM edu_school where school_status=?")) {
			
														   $stmt->bind_param("s", $param_status);
														 // Set parameters 
														 $param_status = $active;
														
														 
														 $stmt->execute();
														 /* bind variables to prepared statement */
														 $stmt->bind_result($school_id, $school_name);
														 $sr =1;
														 /* fetch values */
														 while ($stmt->fetch()) {
																	
															  echo " <option value='".$school_id."'>".$school_name."</option>";
														}
												 }				
										?>
										 </select><br><span id="schoolId-info" class="info"></span><br>
								        <label>Address</label><br>
								        <input class="form-control" placeholder="address" name="address" id="addressId" type="text" >
										<span id="addressId-info" class="info"></span><br>
								        <label>Postal Code: </label><br>
								        <label id="countryValue"></label>
								        <table>
								           <tr>
								              <td>
								                  <input class="form-control" placeholder="Postal Code" name="postalcode" id="postalCodeid" >
												  <span id="postalCodeid-info" class="info"></span><br>
								              </td>
								           </tr>
								        </table>
								        <br>
								        <label>Level</label><br>
								        <table cellspacing="10">
								            <tr>
								               <td width="70%" class="tdclass">
												   <select name="levelId" id="levelId" class="form-control" >
                                                   
												   <?php
												  /* if ($stmt = $mysqli->prepare("SELECT level_id,level FROM edu_levels where level_status=?")) {
    
												   $stmt->bind_param("s", $param_status);
												 // Set parameters 
												 $param_status = $active;
												 
												 $stmt->execute();
												 // bind variables to prepared statement 
												 $stmt->bind_result($level_id, $level);
												 $sr =1;
												 // fetch values
												 while ($stmt->fetch()) {
													  		
													  echo " <option rel=".$school_name." value='".$level_id."'>".$level."</option>";
												}
											 }	*/
												   ?>

													   <br><span id="levelId-info" class="info"></span><br>													   
												   </select>
								               </td>
								               <td width="30%" class="tdclass">
								                  <input class="form-control" placeholder="Level" name="level" id="level" type="level" >
								               </td>
								            </tr>
								        </table>
								        <br>
							
								        <label>Class</label><br>
								        <select name="classId" id="class_Id" class="form-control" >
                                        
										
											
											</select><br><span id="classId-info" class="info"></span><br>
								        </select><br>
								        <label>Subscribed Products</label><br>
								       <!-- <input type="checkbox" id="issue" name="issue" value="issue">-->
								        <label for="by issue"> By Issue</label><br>
								        
                                        <div class="row"  id="dynamic_field1">
                                        <div class="col-lg-6 divbottomspace">
                                             
                                                  <select name="issueId" id="issueId" class="form-control" >
                                                        
														<option >Select Issue</option>
														<?php
												          if ($stmt = $mysqli->prepare("SELECT mag_type_id,mag_type FROM edu_mag_type where mag_type_status=?")) {
    
												              $stmt->bind_param("s", $param_status);
															 // Set parameters 
															 $param_status = $active;
															
															 
															 $stmt->execute();
															 /* bind variables to prepared statement */
															 $stmt->bind_result($mag_type_id, $mag_type);
															 $sr =1;
															 /* fetch values */
															 while ($stmt->fetch()) {
																		
																  echo " <option value='".$mag_type_id."'>".$mag_type."</option>";
															}
											              }	
												   ?>
								                   </select>
                                              
                                         </div>
                                                   <div class="col-lg-6 divbottomspace"><input class="form-control" placeholder="Issue No." name="issueno" id="issueno" type="text" ></div></div>
                                                   <div class="row" id="new_addissue"></div>
								        
                                       <!-- <input type="button" class="btn btn-lg btn-success btn-block" value="+" id="addissue"  style="background-color:#e7e7e7; color:#333;border:none"  >--><br>
								        <label for="by issue"> By Article</label><br>
								        <table cellspacing="10">
								           <tr>
								               <td width="40%" class="tdclass" >
								                  <input class="form-control" placeholder="No." name="article_no" id="article_no" type="text" >
								               </td>
								               <td width="60%">
								                  <select name="article_id" id="article_id" class="form-control" >
												  <?php
												   if ($stmt = $mysqli->prepare("SELECT essay_type_id,essay_type FROM edu_essay_type where essay_type_status=?")) {
    
												   $stmt->bind_param("s", $param_status);
												 // Set parameters 
												 $param_status = $active;
												
												 
												 $stmt->execute();
												 // bind variables to prepared statement
												 $stmt->bind_result($essay_type_id, $essay_type);
												 $sr =1;
												 // fetch values 
												 while ($stmt->fetch()) {
													  		
													  echo " <option value='".$essay_type_id."'>".$essay_type."</option>";
												}
											 }	
												   ?>
								                      <!--<optgroup label = "Inspire/I-Think">
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
								                      </optgroup>-->
								                 </select>
								               </td>
								           </tr>
								       </table>
								       <br>
								       <label for="by issue"> By Skill</label><br>
								       <table cellspacing="10">
										   <tr>
											  <td width="40%" class="tdclass" >
												 <input class="form-control" placeholder="No." name="activity_no" id="activity_no" type="text" >
											  </td>
											  <td width="60%">
												 <select name="activity_id" id="activity_id" class="form-control" >
                                                 <option>Select Activity</option>
												 <?php
												   if ($stmt = $mysqli->prepare("SELECT activity_type_id,activity_type FROM edu_activity_type where activity_type_status=?")) {
    
												   $stmt->bind_param("s", $param_status);
												 // Set parameters 
												 $param_status = $active;
												
												 
												 $stmt->execute();
												 /* bind variables to prepared statement */
												 $stmt->bind_result($activity_type_id, $activity_type);
												 $sr =1;
												 /* fetch values */
												 while ($stmt->fetch()) {
													  		
													  echo " <option value='".$activity_type_id."'>".$activity_type."</option>";
												}
											 }	
												   ?>
													
												  </select>
												  
											   </td>
										   </tr>
								       </table>
								       				  
						  </div>
                          <div class="col-lg-6">
						         <label for="by issue"> Teacher IC:</label><br>
								 <input class="form-control" placeholder="Teacher IC" name="teacher_Ic" id="teacher_Ic" type="text" >
								 <span id="teacher_Ic-info" class="info"></span><br><br>
								 <label for="by issue"> Email:</label><br>
								  
								 <input class="form-control" placeholder="Email" name="email_Ic" id="email_Ic" type="text" >
                                 <span id="email_Ic-info" class="info"></span><br><br>
								 <label for="by issue"> EL Teacher</label><br>
								  
								 <input class="form-control" placeholder="el_Teacher" name="el_Teacher" id="el_Teacher" type="text" >
                                 <span id="el_Teacher-info" class="info"></span><br><br>
								 <label for="by issue"> Email:</label><br>
								 
								 <input class="form-control" placeholder="email" name="email_el" id="email_el" type="text" >
                                  <span id="email_el-info" class="info"></span><br><br>
								 <label for="start date">Start Date:</label> <br>
								 <span id="start_date-info" class="info"></span><br>
                                 <div class="date-selector-start">
                                  <input class="form-control"  id="startdate" name="startdate" placeholder="Start Date"  onkeydown="return false" type="date" />
                                  <span id="datePickerLbl-start" style="pointer-events: none;"></span>
                                </div>
                                 <br>
								 <label for="end date">End  Date:</label><br> 
								 <span id="end_date-info" class="info"></span><br>	
                                 <div class="date-selector-end">
                                  <input id="enddate" class="form-control" type="date" onKeyDown="return false" name="enddate" placeholder="End Date" />
                                  <span id="datePickerLbl-end" style="pointer-events: none;"></span>
                                </div>
                                 <br>
                                 <input type="hidden" name="countryNamehidden" id="countryNamehidden">
                                 <button class="btn btn-default btn-xl btnAlign">Submit</button>						   
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
        <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.min.js"></script>
        <script>
		    
			
			 
			 
               $(document).ready(function(){
			     $("#schoolName").on("change", function(e) {

				  var schoolNames = $(this).val();
				  					   $.ajax({
								type: 'POST',
								url: 'data/selectLevel.php',
								data: {schoolNames:schoolNames},
								cache: false,
								success: function(data){
								   $("#levelId").html(data);
								   
								}
					 });

				  				
				});
				$("#levelId").on("change", function(e) {

				  var schoolLevel = $(this).val();
				  					   $.ajax({
								type: 'POST',
								url: 'data/selectClass.php',
								data: {schoolLevel:schoolLevel},
								cache: false,
								success: function(data){
								   $("#class_Id").html(data);
								   
								}
					 });

				  				
				});

			     $("#startdate").on("change", function(e) {

				  displayDateFormat($(this), '#datePickerLbl-start', $(this).val());
				
				});
				
				$("#enddate").on("change", function(e) {
				
				  displayDateFormat($(this), '#datePickerLbl-end', $(this).val());
				
				});
				
				function displayDateFormat(thisElement, datePickerLblId, dateValue) {
				
				  $(thisElement).css("color", "rgba(0,0,0,0)")
					.siblings(`${datePickerLblId}`)
					.css({
					  position: "absolute",
					  left: "10px",
					  top: "8px",
					  width: $(this).width()
					})
					.text(dateValue.length == 0 ? "" : (`${getDateFormat(new Date(dateValue))}`));
				
				}
				
				function getDateFormat(dateValue) {
				
				  let d = new Date(dateValue);
				
				  // this pattern dd/mm/yyyy
				  // you can set pattern you need
				  let dstring = `${("0" + d.getDate()).slice(-2)}/${("0" + (d.getMonth() + 1)).slice(-2)}/${d.getFullYear()}`;
				
				  return dstring;
				}

			      $("select.country").change(function(){
        var selectedCountry = $(this).children("option:selected").val();
		
		const myArray = selectedCountry.split("_");
        $("#countryValue").html(myArray[1]);
		var $dst1 = $('#countryNamehidden');
		$dst1.val(myArray[0]);
    });
			      
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
				 
				$("#addUsermanually").on("submit", function () { 
			  $(".info").html("");
			  $("#name").removeClass("input-error");
			  var name = $("#name").val();
			$("#schoolId").removeClass("input-error");
			  var countryId = $("#countryId").val();
			  $("#countryId").removeClass("input-error");
			  var postalCodeid = $("#postalCodeid").val();
			  $("#postalCodeid").removeClass("input-error");
			  var addressId = $("#addressId").val();
			  $("#addressId").removeClass("input-error");
			  var schoolId = $("#schoolId").val();
			   $("#schoolId").removeClass("input-error");
			   var levelId = $("#levelId").val();
			  $("#levelId").removeClass("input-error");
			  var classId = $("#classId").val();
			  $("#classId").removeClass("input-error");
			  
			  var teacherId = $("#teacher_Ic").val();
			  $("#teacher_Ic").removeClass("input-error");
			  
			  var teacher_email = $("#email_Ic").val();
			  $("#email_Ic").removeClass("input-error");
			  
			  var inchargetrId = $("#el_Teacher").val();
			  $("#el_Teacher").removeClass("input-error");
			  
			  
			  var incharge_email = $("#email_el").val();
			  $("#email_el").removeClass("input-error");
			  
			  var start_date = $("#startdate").val();
			  $("#startdate").removeClass("input-error");
			  
			  var end_date = $("#enddate").val();
			  $("#enddate").removeClass("input-error");
			  
			  var issueId = $("#issueId").val();
			  $("#issueId").removeClass("input-error");
			  
			   var articleId = $("#articleId").val();
			  $("#articleId").removeClass("input-error");
			  
			  var skillId = $("#skillId").val();
			  $("#skillId").removeClass("input-error");
			  
	
			  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			  
			  /*if (name == "") {
					$("#name-info").html("Please enter name.");
					$("#name").addClass("input-error");
					 return false;
			  }else if (countryId == "") {
					$("#countryId-info").html("Please select the Country.");
					$("#countryId").addClass("input-error");
					 return false;
			  }
			  else if (schoolId == "") {
					$("#schoolId-info").html("Please enter the School Name.");
					$("#schoolId").addClass("input-error");
					 return false;
			  }
              else if (addressId == "") {
					$("#addressId-info").html("Please enter address.");
					$("#addressId").addClass("input-error");
					 return false;
			  }			  
			  else if (postalCodeid == "") {
					$("#postalCodeid-info").html("Please enter Postal Code.");
					$("#postalCodeid").addClass("input-error");
					 return false;
			  
			  }
			  else if (levelId == "") {
					$("#levelId-info").html("Please enter Level.");
					$("#levelId").addClass("input-error");
					 return false;
			  
			  }
			  
			  else if (classId == "") {
					$("#classId-info").html("Please enter the class.");
					$("#classId").addClass("input-error");
					 return false;
			  
			  }
			  else if (teacherId == "") {
					$("#teacher_Ic-info").html("Please enter the teacher.");
					$("#teacher_Ic").addClass("input-error");
					 return false;
			  
			  }
			  else if (teacher_email == "") {
					$("#email_Ic-info").html("Please enter the teacher email.");
					$("#email_Ic").addClass("input-error");
					 return false;
			  
			  }
			  else if (!filter.test(teacher_email)) {
					  $("#email_Ic-info").html("Please provide a valid email address");
					$("#email_Ic").addClass("input-error");
						//email.focus;
						return false;

			  }
			  else if (inchargetrId == "") {
					$("#el_Teacher-info").html("Please enter the teacher incharge.");
					$("#el_Teacher").addClass("input-error");
					 return false;
			  
			  }
			  else if (incharge_email == "") {
					$("#email_el-info").html("Please enter the teacher email.");
					$("#email_el").addClass("input-error");
					 return false;
			  
			  }

			   else if (!filter.test(incharge_email)) {
					  $("#email_el-info").html("Please provide a valid email address");
					$("#email_el").addClass("input-error");
						//email.focus;
						return false;

			  }
			  
			  else if (start_date == "") {
					$("#start_date-info").html("Please select the start date.");
					$("#start_date").addClass("input-error");
					 return false;
			  
			  }
			  else if (end_date == "") {
					$("#end_date-info").html("Please select the end date.");
					$("#end_date").addClass("input-error");
					 return false;
			  
			  }
			  
			   else if (issueId == "") {
					$("#issueId-info").html("Please select Issue.");
					$("#issueId").addClass("input-error");
					 return false;
			  
			  }
			  
			  else if (articleId == "") {
					$("#articleId-info").html("Please select article.");
					$("#articleId").addClass("input-error");
					 return false;
			  
			  }
			  
			  else if (skillId == "") {
					$("#skillId-info").html("Please select article.");
					$("#skillId").addClass("input-error");
					 return false;
			  
			  }
			  
			  else{ */
			  const mynamearray = name.split(" ");
                
			      /* $.ajax({
						type: 'POST',
						url: 'data/addUsermanually.php',
						data: {fname:mynamearray[0],lname:mynamearray[1],schoolId:schoolId,addressId:addressId,postalCodeid:postalCodeid,countryId:countryId,levelId:levelId,classId:classId,teacherId:teacherId,inchargetrId:inchargetrId,teacher_email:teacher_email,incharge_email:incharge_email,start_date:start_date,end_date:end_date,issueId:issueId,articleId:articleId,skillId:skillId},
						cache: false,
						success: function(data){
						   alert('Successful');
						   window.location='subscriber-list.php';
						   
						}
				  });event.preventDefault();*/
				  
				  $.ajax({
						type: 'POST',
						url: 'data/addUsermanually.php',
						data: $('#addUsermanually').serialize(),
					    success:function(data)
						{
						   alert('Successful');
						   window.location='subscriber-list.php';
						   
						}
				  });event.preventDefault();
			//  }
			
			
			
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
			 
			  var i=1;
	      $('#addName').click(function(){
		     i++;
		
		     $('#dynamic_field').append('<div id="row'+i+'"><input type="text" id="name'+i+'" name="name[]" class="form-control"></div>');
	      });
		  
		  $('#addissue').click(function(){
		     i++;
		
		     $('#dynamic_field1').append('<div class="col-lg-6 divbottomspace" id="row'+i+'"><select name="issueId" id="issueId' + i + '" class="form-control" ><option >Select Issue</option><?php
												          if ($stmt = $mysqli->prepare("SELECT mag_type_id,mag_type FROM edu_mag_type where mag_type_status=?")) {
    
												              $stmt->bind_param("s", $param_status);
															 // Set parameters 
															 $param_status = $active;
															
															 
															 $stmt->execute();
															 /* bind variables to prepared statement */
															 $stmt->bind_result($mag_type_id, $mag_type);
															 $sr =1;
															 /* fetch values */
															 while ($stmt->fetch()) {
																		
																  echo ' <option value="'.$mag_type_id.'">'.$mag_type.'</option>';
															}
											              }	
												   ?></select></div><div class="col-lg-6 divbottomspace"><input type="text" name="issueno[]" id="issueno' + i + '" class="form-control"></div>');
	      });
					
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
  var new_input_addissue = "<div class='col-lg-6 divbottomspace'><select name='user_id' id='user_id' class='form-control' ><option value=''>Issue</option><option value=''>I magazine</option><option value=''>inspire</option></select></div><div class='col-lg-6 divbottomspace'><input type='text' id='new_" + new_addissue_no + "' class='form-control'></div>";

  $('#new_addissue').append(new_input_addissue);
  
  $('#total_addissue').val(new_addissue_no);
}




		</script>

    </body>
</html>
