<?php
session_start();
require('functions.php');
require('constants_configurations.php');
require('Excel_template_export_conferences.php');
CheckLogin_Validity();

?>
<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title><?php echo $title_constant; ?> </title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <script type="text/javascript">
		function DeleteConfirm(apl)
		{
			if(connfirm("Are you sure you want to Delete - "+ apl ))
				return true;
			else
				return false;	
		}
		</script>
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->                                      
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <?php
				System_Navigation();
				?>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                   <li>
                   <?php echo $system_top_headding; ?>
                   </li>
                    <!-- TOGGLE NAVIGATION 
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->
                    
                    <!-- SIGN OUT 
                    <li class="xn-icon-button pull-right">
                        <a href="signout.php" class="mb-control" data-box="#mb-signout">Logout</a>                        
                    </li> 
                        -->
                     
                     </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     
                
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">NTUC Publishing</a></li>
                    <li><a href="#">Pages</a></li>
                    <li class="active">Change Password</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE TITLE -->
                <!--div class="page-title">                    
                    <h2><span class="fa fa-arrow-circle-o-left"></span> Basic Tables</h2>
                </div>-->
                <!-- END PAGE TITLE -->                
                
                <!-- PAGE CONTENT WRAPPER -->
                <?php
				
				function View_Evangelists_Reports($conferenceID,$zoneID,$year,$month,$order_by,$confIDselc)
				{
					
					require('connection.php');
					
					$array_months = array("1"=>"Quarter One","2"=>"Quarter Two","3"=>"Quarter Three","4"=>"Quarter Four");
				?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Evangelist Multi Query Quartely Report </h3>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Report</button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="Multi_Query_Report_Quarter.xlsx"><img src='img/icons/xls.png' width="24"/> Excel </a></li>
                                            <li><a href="#"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                            <li><a href="#"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                                    </div>                                    
                                    
                                </div>
                                <div class="panel-body">
                                <?php
								
								if(!empty($zoneID))
								{
									$conc_Query = " AND zone='$zoneID' ";
								}
								else
								{
								
								if($_SESSION['access_level']==20)
								{
									$conferenceIDsession = $_SESSION['ConferenceID'];
									$conc_Query = " AND evangelistID IN (SELECT ID FROM evangelists_list WHERE zoneID IN(SELECT ID FROM zones_lists WHERE ConferenceID='$conferenceIDsession') )";	
								}
								else if($_SESSION['access_level']==21 and $confIDselc!='')
								{
									//$confIDselc = $confIDselc;
									$conc_Query = " AND evangelistID IN (SELECT ID FROM evangelists_list WHERE zoneID IN(SELECT ID FROM zones_lists WHERE ConferenceID='$confIDselc') )";	
								}
								else
								{
									$conc_Query = "";	
								}
								
								
								}
								
								switch($month)
								{
									case 1:
										$prev_year = $year-1;
										$value1= "(month='11' AND year=".$prev_year.")";
										$value2= "(month='12' AND year=".$prev_year.")";
										$value3= "(month='1' AND year=".$year.")";
										break;
									case 2:	
										$value1="(month='2' AND year=".$year.")";
										$value2="(month='3' AND year=".$year.")";
										$value3="(month='4' AND year=".$year.")";
										break;
									case 3:
										$value1="(month='5' AND year=".$year.")"
										;$value2="(month='6' AND year=".$year.")";
										$value3="(month='7' AND year=".$year.")";
										break;
									case 4:
										$value1="(month='8' AND year=".$year.")";
										$value2="(month='9' AND year=".$year.")";
										$value3="(month='10' AND year=".$year.")";
									break;
								}//end switch statement...
								
								$sql = "SELECT * FROM evangelists_monthly_report WHERE ID>1 AND ($value1 OR $value2 OR $value3 ) $conc_Query ORDER BY $order_by DESC";
								//echo $sql;
								$query = mysql_query($sql,$connect)or die(mysql_error());
								//data-toggle="tooltip"
								MultiQueryReportQuarter($month,$year,$order_by,$sql);
								?>
                               <!-- <a href="?View_zone_single=<?php echo $zoneID; ?>" data-toggle="tooltip" data-placement="bottom" title="Click to View List of Evangelists "> <b> Evangelists Detail List </b> </a> <br><br> -->
                                
                                Showing Report for <?php echo $array_months[$month]; ?> , <?php echo $year; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                
                                <a href="#"  data-placement="bottom" title="Click to View Reports for Other Month / year" data-toggle="modal" data-target="#myModal"> <b> View Other Reports </b> </a> 
                               
                                <br><br>
                                <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Choose Report Month and Year</h4>
      </div>
      <div class="modal-body">
        <p>Please Select Month and Year for the report you want to View .
        
        <div class="row">
        <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <div class="col-md-6">
        
        										<div class="form-group">
                                                <label class="col-md-3 control-label">Conf:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="confID">
                                                    <?php
													if($_SESSION['access_level']==20)
													{
														?>
														<option value="<?php echo $_SESSION['ConferenceID']; ?>"> <?php echo return_conference_name($_SESSION['ConferenceID']); ?> </option>
                                                        <?php
													}
													else if($_SESSION['access_level']==21)
													{
													?>
                                                    <option value=""> ------Select Conference ------ </option>
                                                    <?php
													$confQuery = mysql_query("SELECT * FROM conferences_list",$connect) or die(mysql_error());
													while($fetchConf = mysql_fetch_array($confQuery))
													{
													?>
                                                        <option value="<?php echo $fetchConf['ID']; ?>"> <?php echo $fetchConf['conference_Name']; ?> </option>
                                                      <?php
													}
													
													}
													else
													{
														
													}
													?>
                                                        
                                                    </select>
                                                    
                                                </div>
                                            </div>
        									
                                            <br>
        										<div class="form-group">
                                                <label class="col-md-3 control-label">Zone</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="Zone">
                                                    <option value="">---Select Zone---</option>
                                                        <?php
														if($_SESSION['access_level']==20)
														{
															$conf_ya_alieingia = $_SESSION['ConferenceID'];
														    $conc_add_find_zone = "WHERE ConferenceID ='$conf_ya_alieingia' "; 
														}
														else
														{
															$conc_add_find_zone = '';
														}
														$zones_lists = mysql_query("SELECT * FROM zones_lists $conc_add_find_zone ORDER BY ConferenceID ",$connect)or die(mysql_error());
														while($fetch_zones_lists = mysql_fetch_array($zones_lists))
														{
															?>
                                                            <option value="<?php echo $fetch_zones_lists['ID']; ?>"> <?php echo $fetch_zones_lists['ZoneName'].' - '.getconfAbrrfromZoneID($fetch_zones_lists['ID']); ?> </option>
                                                            <?php
														}//end while loop for zones
														?>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            
                                            <br>
        										<div class="form-group">
                                                <label class="col-md-3 control-label">Quarter</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="month" required>
                                                    <option value="">---Select Month---</option>
                                                        <option value="1">Quarter One</option>
                                                        <option value="2">Quarter Two</option>
                                                        <option value="3">Quarter Three</option>
                                                        <option value="4">Quarter Four</option>
                                                        
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            <br> 
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" >Year</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="year" required>
                                                    <option value="">---Select year---</option>
                                                       <?php
													   $year_current = date('Y');
													   for($i=$year_current;$i>($year_current-15);$i--)
													   {
														   ?>
															<option value="<?php echo $i; ?>"><?php echo $i; ?></option>   
                                                            <?php
													   }
													   ?>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            <br>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Order By:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="order_by" required>
                                                        <option value="Value_sales">Value of Sale</option>
                                                        <option value="hours">Hours</option>
                                                        <option value="books_sold">Number of Books Sold</option>
                                                        <option value="free_literature">Free Literature</option>
                                                        <option value="v_o_p">Voice of Prophet</option>
                                                        <option value="people_attending_SS">Attending Sabbath School</option>
                                                        <option value="sda_back_slinders">SDA Back Slinders</option>
                                                        <option value="prayers_offered">Number of Prayers Offered</option>
                                                        <option value="Bibles_studies_given">Bible Studies Given</option>
                                                        <option value="people_joining_bapstism_classes">Joining Baptism Classes</option>
                                                        <option value="no_baptised">Number Baptized</option>
                                                        <option value="Magazines">Magazines</option>
                                                        <option value="Waliotembelewa">Home Visited</option>
                                                        
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            <BR>
                                            <br><br>
                                             <div class="col-md-6">
                                             <div class="form-group">
                                             <div class="col-md-9">
                                            <button class="btn btn-primary pull-right" type="submit">Submit</button>
                                            </div>
                                            </div>
                                            </div>
                                            
           </div>
           </div>
        </form> 
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End Modal-->


                                    <table id="customers" class="table table-striped">
                                        <thead>
                                            <tr>
                                            	<th> No </th>
                                                <th>Evangelist Name</th>
                                                <th> Zone </th>
                                                <th> Conf </th>
                                                <th>Hours</th>
                                                <th><center>Books<br>Sold</center></th>
                                                <th><center>Magazine</center></th>
                                                <th> <center>Value of <br>Sales</center> </th>
                                                <th><center>Free<br>Lit</center></th>
                                                <th>V.O.P</th>
                                                <th><center>Attending<br> SS</center></th>
                                                <th><center>Back<br>Slinder</center></th>
                                                <th>Prayers</th>
                                                <th><center>Bible<br>Studies</center></th>
                                                <th><center>Baptisim<br>Classes</center></th> 
                                                <th> Baptized </th>
                                                <th> Home<br>Visited </th> 
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
										if(mysql_num_rows($query)==0)
										{
											?>
                                            <tr>
                                            <td colspan="17"> No Report Found </td> </tr>
                                            </tr>
                                            <?php
										}	
										else
										{
											$num = 0;
											
											
											$sum_hours = 0;
											$sum_books_sold = 0;
											$sum_value_sale = 0;
											$free_literature = 0;
											$vop = 0;
											$attending_ss = 0;
											$back_slinders = 0;
											$prayers = 0;
											$bible_studies = 0;
											$baptism_classes = 0;
											$baptized = 0;
											while($fetch_conferences_lists = mysql_fetch_array($query))
											{
												$num++;
												$evangID = $fetch_conferences_lists['evangelistID'];
												
												$zoneIDre = getzoneID($evangID);
												$confIDre = getConfID($zoneIDre);
												
												?>
                                            <tr>
                                            	<td> <?php echo $num; ?>. </td>
                                                <td> <?php echo return_Evang_Name($evangID); ?>  </td>
                                                <td> <?php echo ReturnZoneDetails($zoneIDre,'ZoneName'); ?></td>
                                                <td> <?php echo return_conference_abbrev($confIDre); ?> </td>
                                                <?php
												
													$sum_hours = $sum_hours + $fetch_conferences_lists['hours'];
													$sum_books_sold = $sum_books_sold + $fetch_conferences_lists['books_sold'];
													$sum_value_sale = $sum_value_sale + $fetch_conferences_lists['Value_sales'];
													$free_literature = $free_literature + $fetch_conferences_lists['free_literature'];
													$vop = $vop + $fetch_conferences_lists['v_o_p'];
													$attending_ss = $attending_ss + $fetch_conferences_lists['people_attending_SS'];
													$back_slinders = $back_slinders + $fetch_conferences_lists['sda_back_slinders'];
													$prayers = $prayers + $fetch_conferences_lists['prayers_offered'];
													$bible_studies = $bible_studies + $fetch_conferences_lists['Bibles_studies_given'];
													$baptism_classes = $baptism_classes + $fetch_conferences_lists['people_joining_bapstism_classes'];
													$baptized = $baptized + $fetch_conferences_lists['no_baptised'];
													
													$magazine = $magazine + $fetch_conferences_lists['Magazines'];
													$visited = $visited + $fetch_conferences_lists['Waliotembelewa'];
													
													?>
                                                <td align="center"> <?php echo number_format($fetch_conferences_lists['hours']); ?></td>
                                                <td align="center"> <?php echo number_format($fetch_conferences_lists['books_sold']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_conferences_lists['Magazines']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_conferences_lists['Value_sales']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_conferences_lists['free_literature']); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format($fetch_conferences_lists['v_o_p']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_conferences_lists['people_attending_SS']); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format($fetch_conferences_lists['sda_back_slinders']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_conferences_lists['prayers_offered']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_conferences_lists['Bibles_studies_given']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_conferences_lists['people_joining_bapstism_classes']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_conferences_lists['no_baptised']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_conferences_lists['Waliotembelewa']); ?> </td>
                                                <?php
												
												?>
                                                
                                                
                                            </tr>
                                          <?php
											}
										}
										?>
                                        <tr>
                                        <th colspan="4"> TOTAL  </th>
                                        <th> <center><?php echo number_format($sum_hours); ?> </center> </th>
                                        <th> <center><?php echo number_format($sum_books_sold); ?> </center> </th>
                                        <th> <center><?php echo number_format($magazine); ?> </center> </th>
                                        <th> <center><?php echo number_format($sum_value_sale); ?> </center> </th>
                                        <th> <center><?php echo number_format($free_literature); ?> </center></th>
                                        <th> <center><?php echo number_format($vop); ?> </center></th>

                                        <th> <center><?php echo number_format($attending_ss); ?> </center></th>
                                        <th> <center><?php echo number_format($back_slinders); ?> </center></th>
                                        <th> <center><?php echo number_format($prayers); ?></center> </th>
                                        <th> <center><?php echo number_format($bible_studies); ?></center></th>
                                        <th> <center><?php echo number_format($baptism_classes); ?></center></th>
                                        <th> <center><?php echo number_format($baptized); ?></center></th>
                                        <th> <center><?php echo number_format($visited); ?> </center> </th>
                                        
                                        </tr>
                                        </tbody>
                                    </table>                                    
                                    
                                </div>
                            </div>
                            <!-- END DATATABLE EXPORT -->                            
                            
                            
                        </div>
                    </div>

                </div>         
                <!-- END PAGE CONTENT WRAPPER -->
                <?php
				}//end function Conferences Lists
				
				if(isset($_GET['month']))
				{
					View_Evangelists_Reports($conferenceID,$_GET['Zone'],$_GET['year'],$_GET['month'],$_GET['order_by'],$_GET['confID']);
				}
				else
				{
					$year = date('Y');
					$month = date('m')-1;
					View_Evangelists_Reports($conferenceID,$zoneID,$year,1,'Value_sales','');
				}
				?>
                
                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->    

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-remove-row">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-times"></span> Remove <strong>Data</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to remove this row?</p>                    
                        <p>Press Yes if you sure.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button class="btn btn-success btn-lg mb-control-yes">Yes</button>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->        
        
        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="signout.php" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->                      

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>        
        <!-- END PLUGINS -->
        
        <!-- START THIS PAGE PLUGINS-->        
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        
        <script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/plugins/tableexport/tableExport.js"></script>
	<script type="text/javascript" src="js/plugins/tableexport/jquery.base64.js"></script>
	<script type="text/javascript" src="js/plugins/tableexport/html2canvas.js"></script>
	<script type="text/javascript" src="js/plugins/tableexport/jspdf/libs/sprintf.js"></script>
	<script type="text/javascript" src="js/plugins/tableexport/jspdf/jspdf.js"></script>
	<script type="text/javascript" src="js/plugins/tableexport/jspdf/libs/base64.js"></script>        
        <!-- END THIS PAGE PLUGINS-->  
        
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>                
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
        
        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/settings.js"></script>
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->                 
    </body>
</html>






