<div class="navbar-default sidebar toppad" role="navigation" >
    <div class="sidebar-nav navbar-collapse" id="testsidemenu" >
       <ul class="nav" id="side-menu">
          <li class="logo_li"><img src="images/logo.png"  ></li>
          <li class="logo_li">
              <table width="100%" cellpadding="0" cellspacing="0">
                     <?php
					     /* Query to fetch the user details. Inner Join query on tables edu_utype and edu_users */
					     $stmt = $mysqli->prepare("SELECT a.utype_id, a.user_type, b.user_image_path, b.first_name, b.last_name FROM edu_utype a inner join edu_users b WHERE a.user_type_id=b.user_type_id and b.user_id = ? and b.user_status = ?");
						 /* Bind parameters */
						 $stmt->bind_param("ss", $param_utypeid,$param_ustatus);
						/* Set parameters */
						$param_utypeid = $_SESSION["id"];
						$param_ustatus = $active;
						$stmt->execute();
						$stmt->bind_result($col1, $col2, $col3, $col4, $col5);
						$stmt->fetch();
						$stmt->close();
					?>
                    <tr>
                        <td width="30%">
                           <span class="user" style="background-image:url(upload/<?php echo $col3;?>)"></span>
                                       
                        </td>
                        <td>
                            <span>
								 <?php
                                      /* Counts no of characters in the Name and replaces with dots if it exceeds 10 */								 
									  $uname = $col4." ".$col5;
									  $count = strlen($uname);
									  if($count > 10){
										 $uname = substr($uname,0,10);
										 echo $uname."....";
									  }
									  else {
											 echo $uname;
									  }
								?>
                           </span>
                           <br />
                           <span>
                                 <?php echo $col2;?>
						   </span>
                        </td>
                    </tr>
              </table>
           </li>
           <?php if($col1== $admconst){  /* checks if logged in user is Admin and displays menu for Admin */ ?>
                    <li>
                        <a href="dashboard.php" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="Your main page"><i class="material-icons-outlined md-16">dashboard</i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="Keep track of events"><i class="material-icons-outlined md-16">view_column</i> Calendar</a>
                    </li>
                    <li>
                        <a href="#" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="Save articles & activities for later"><i class="material-icons-outlined md-16">star_outline</i> Bookmarks</a>
                    </li>
                    <li>
                        <a href="#" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="Save words you like"><i class="material-icons-outlined md-16">folder_open</i> Word Bank</a>
                    </li>
                    <li>
                        <a href="magazines.php" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="Library of articles &activities"><i class="material-icons-outlined md-16">import_contacts</i> Resources<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="magazines.php">Magazines</a>
                            </li>
                            <li>
                                <a href="#">Articles</a>
                            </li>
                            <li>
                                <a href="#">Activities</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="View records of all users, reviews & reflections"><i class="material-icons-outlined md-16">view_agenda</i> Logs<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="subscriber-list.php">Users</a>
                            </li>
                            <li>
                                <a href="#">Task Log</a>
                            </li>
                            <li>
                                <a href="#">Reflection Log</a>
                            </li>
                            <li>
                                <a href="#">Review Log</a>
                            </li>
                            <li>
                                <a href="#">Aids Log</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="Track users' data & performance"><i class="material-icons-outlined md-16">insert_chart_outlined</i> Analytics<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Data</a>
                            </li>
                            <li>
                                <a href="#">Progress</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
            <?php } elseif($col1== $admstdconst){ /* checks if logged in user is Student and displays menu for Student */ ?>
					<li>
                        <a href="dashboard.php" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="Your main page"><i class="material-icons-outlined md-16">dashboard</i> Dashboard</a>
                    </li>
                    <li>
                          <a href="to-do-list.php" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="Get Started on Your Assignments"><i class="material-icons-outlined md-16">view_agenda</i> To-Do List</a>
                    </li>
                    <li>
                        <a href="#" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="See what's due & when"><i class="material-icons-outlined md-16">view_column</i> Calendar</a>
                    </li>
                    <li>
                        <a href="#" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="Save articles & activities for later"><i class="material-icons-outlined md-16">star_outline</i> Bookmarks</a>
                    </li>
                    <li>
                        <a href="#" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="Save words you like"><i class="material-icons-outlined md-16">folder_open</i> Word Bank</a>
                    </li>
                    <li>
                        <a href="magazines.php" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="View your available reads & activities"><i class="material-icons-outlined md-16">import_contacts</i> Resources<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="magazines.php">Magazines</a>
                            </li>
                            <li>
                                <a href="articles.php">Articles</a>
                            </li>
                            <li>
							    <a href="activities.php">Activities</a>
                            </li>
                         </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="Track your improvement"><i class="material-icons-outlined md-16">insert_chart_outlined</i> Progress<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Progress Report</a>
                            </li>
                            <li>
                                <a href="#">Past Attempts</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                            
			<?php } elseif($col1== $admtchconst){ /* checks if logged in user is Teacher and displays menu for Teacher */?>
                    <li>
                        <a href="dashboard.php" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="Your main page"><i class="material-icons-outlined md-16">dashboard</i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="See what's due & when"><i class="material-icons-outlined md-16">view_column</i> Calendar</a>
                    </li>
                    <li>
                        <a href="#" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="Save articles & activities for later"><i class="material-icons-outlined md-16">star_outline</i> Bookmarks</a>
                    </li>
                    <li>
                        <a href="#" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="Save words you like"><i class="material-icons-outlined md-16">folder_open</i> Word Bank</a>
                    </li>
                    <li>
                        <a href="magazines.php" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="View your available reads & activities"><i class="material-icons-outlined md-16">import_contacts</i> Resources<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="magazines.php">Magazines</a>
                            </li>
                            <li>
                                <a href="#">Articles</a>
                            </li>
                            <li>
                                <a href="#">Activities</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="View records of all tasks & your classes"><i class="material-icons-outlined md-16">view_agenda</i> Logs<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Users</a>
                            </li>
                            <li>
                                <a href="#">Task Log</a>
                            </li>
                            <li>
                                <a href="#">Reflection Log</a>
                            </li>
                            <li>
                                <a href="#">Review Log</a>
                            </li>
                            <li>
                                <a href="#">Aids Log</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#" class="tooltipcls" data-toggle="tooltip" data-placement="right" title="Track students' improvement"><i class="material-icons-outlined md-16">insert_chart_outlined</i> Progress<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Progress Report</a>
                            </li>
                            <li>
                                <a href="#">Past Attempts</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                            
            <?php }?>
                    <li><a>&nbsp;</a></li>
                    <li><a>&nbsp;</a></li>
                    <li><a>&nbsp;</a></li>
                    <!--<li class="menutop">-->
                     <?php if($col1== $admconst){?>
                            <li >
                                <a href="need-help-admin.php"><i class="material-icons-outlined md-16">more_horiz</i> Need Help?</a>
                            </li>
                     <?php } elseif($col1== $admstdconst){ /* checks if logged in user is Student and displays menu for Student */ ?> 
                            <li >
                                <a href="need-help.php"><i class="material-icons-outlined md-16">more_horiz</i> Need Help?</a>
                            </li>
                     <?php } elseif($col1== $admtchconst){ /* checks if logged in user is Teacher and displays menu for Teacher */?> 
                            <li >
                                <a href="#"><i class="material-icons-outlined md-16">more_horiz</i> Need Help?</a>
                            </li>
                     <?php }?>            
                    <li >
                        <a href="account-setting.php"><i class="material-icons-outlined md-16">settings</i> Settings</a>
                    </li>
        </ul>
    </div>
</div>