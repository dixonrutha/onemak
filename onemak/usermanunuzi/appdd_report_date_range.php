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
                    <li class="active">APDD Report</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE TITLE -->
                <!--div class="page-title">                    
                    <h2><span class="fa fa-arrow-circle-o-left"></span> Basic Tables</h2>
                </div>-->
                <!-- END PAGE TITLE -->                
                
                <!-- PAGE CONTENT WRAPPER -->
                <?php
				
				function View_APDD_List($conferenceID,$startDate,$endDate)
				{
					//$total_days = cal_days_in_month(CAL_GREGORIAN,$month,$year);
					
					$days_week = array("1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday","0"=>"Sunday");
					
					$dayofweek = date('w', strtotime('2017-04-20'));
					//echo $dayofweek;
					
					$array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
					
					//Evangelists_Apdd_monthly_report($zoneID,$month,$year,$conferenceID);
					
				?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">APDD Monthly Report for <?php echo $array_months[$month]; ?> , <?php echo $year; ?> </h3>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="#"><img src='img/icons/xls.png' width="24"/> Excel </a></li>
                                            <li><a href="#"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                            <li><a href="#"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                                    </div>                                    
                                    
                                </div>
                                <div class="panel-body">
                                <?php
								
								require('connection.php');
								
								?>
                                <a href="?View_Conference_single=<?php echo $conferenceID; ?>" data-toggle="tooltip" data-placement="bottom" title="Click to go back to Zone Lists"> <b> Back </b> </a> | <a href="#" data-toggle="modal" data-target="#myModal" data-placement="right" title="Click to View / Add Other APDD Reports"><b>View Other Report </b> </a> <br><br>
                                
                                <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Zone , Month and Year to View APDD report</h4>
      </div>
      <div class="modal-body">
        <p>Please Select Zone , Month and Year for the APDD report you want to View .
        
        <div class="row">
        <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <input type="hidden" name="ConfID" value="<?php echo $conferenceID; ?>" >
        <div class="col-md-6">
        										<div class="form-group">
                                                <label class="col-md-3 control-label">Month</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="month_apdd_report_choice" required>
                                                    <option value="">---Select Month---</option>
                                                        <option value="1">January</option>
                                                        <option value="2">February</option>
                                                        <option value="3">March</option>
                                                        <option value="4">April</option>
                                                        <option value="5">May</option>
                                                        <option value="6">June</option>
                                                        <option value="7">July</option>
                                                        <option value="8">August</option>
                                                        <option value="9">September</option>
                                                        <option value="10">October</option>
                                                        <option value="11">November</option>
                                                        <option value="12">December</option>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            <br> 
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" >Year</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="year_apdd_report_choice" required>
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
                                                <label class="col-md-3 control-label" >APDD:</label>
                                                <div class="col-md-9">	
                                                <?php
												$query_zones = mysql_query("SELECT * FROM zones_lists WHERE ConferenceID='$conferenceID' ",$connect)or die(mysql_error());
												?>					                                                                                            
                                                    <select class="form-control select" name="new_zone_report_zone_conf" required>
                                                    <option value="">---Select zone---</option>
                                                       <?php
													   if(mysql_num_rows($query_zones)>0)
													   {
													   
													   while($fetch_zones = mysql_fetch_array($query_zones))
													   {
														   ?>
															<option value="<?php echo $fetch_zones['ID']; ?>"><?php echo $fetch_zones['Assistant_Publishing_Director']." - ".$fetch_zones['ZoneName']; ?></option>   
                                                            <?php
													   }
													   
													   }
													   ?>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            
                                            
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
                                
                                
                                Zone Name: <?php echo ReturnZoneDetails($zoneID,'ZoneName'); ?> <br>
                                APDD Name: <?php echo ReturnZoneDetails($zoneID,'Assistant_Publishing_Director'); ?> <br><br>
                                    <table id="customers" class="table table-striped">
                                        <thead>
                                            <tr>
                                            	<!-- <th>No </th>-->
                                                <th>Date</th>
                                                <th>Day</th>
                                                <th>APDD Name </th>
                                                <th>Evangelists</th>
                                                <th>Grade </th>
                                                <th>Hours</th>
                                                <th>Visits</th>
                                                <th>Books</th>
                                                <th>Value of Sale</th>
                                                <th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
										$sum_hours = 0;
										$sum_vitabu = 0;
										$sum_visits = 0;
										$sum_value_money = 0;
										
										for($i=1;$i<=$total_days;$i++)
										{
										$date_z = $year.'-'.$month.'-'.$i;
										$date_disp = $i."/".$month."/".$year;
										$zoneIDQuery = mysql_query("SELECT * FROM apdd_report WHERE Date='$date_z' AND zoneID='$zoneID' ",$connect) or die(mysql_error());
										$num_rows_data = mysql_num_rows($zoneIDQuery);
										$fetch_apdd = mysql_fetch_array($zoneIDQuery);
										
										$sum_hours = $sum_hours + $fetch_apdd['hours'];
										$sum_vitabu = $sum_vitabu + $fetch_apdd['vitabu'];
										$sum_visits = $sum_visits + $fetch_apdd['waliotembelewa'];
										$sum_value_money = $sum_value_money + $fetch_apdd['mauzo_siku'];
										?>
                                        
                                            <tr>
                                            	<!-- <td> <?php echo $i; ?>. </td> -->
                                                <td> <?php echo $i."/".$month."/".$year; ?> </td>
                                                <td> <?php
												 $dayofweek = date('w', strtotime($year.'-'.$month.'-'.$i));
												 echo $days_week[$dayofweek]; ?> </td>
                                                <td> <?php echo $fetch_apdd['APDD_Name']; ?> </td>
                                                <td> <?php echo return_Evang_Name($fetch_apdd['evangID']); ?> </td>
                                                <td> <?php echo return_grade_Name($fetch_apdd['Grade']); ?> </td>
                                                <td> <?php echo number_format($fetch_apdd['hours']); ?> </td>
                                                <td> <?php echo number_format($fetch_apdd['waliotembelewa']); ?></td>
                                                <td> <?php echo number_format($fetch_apdd['vitabu']); ?></td>
                                                <td> <?php echo number_format($fetch_apdd['mauzo_siku']); ?></td>
                                                <td>
                                                <div class="btn-group pull-right"> 
                                                	<a href="#" data-toggle="dropdown" > Action </a>
                                                		<ul class="dropdown-menu">
                                                			<li> <a href="?new_apdd_report=<?php echo $zoneID; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>&date=<?php echo $date_z; ?>&confID=<?php echo $conferenceID; ?>"> New <?php echo $date_disp; ?> Records </a> </li>
                                                            <?php
															if($fetch_apdd['APDD_Name']!='')
															{
															?>
                                                			<li> <a href="?edit_apdd_report=<?php echo $fetch_apdd['ID'] ?>&zoneID=<?php echo $zoneID; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>&date=<?php echo $date_z; ?>&confID=<?php echo $conferenceID; ?>"> Edit <?php echo $date_disp; ?> Details </a> </li>
                                                			<li> <a href="#"> Delete <?php echo $date_disp; ?> Details </a> </li>
                                                            <?php
															}
															?>
                                                		</ul>
                                                 </div>
                                                 </td>
                                            </tr>
                                          <?php
											
										
									}//end for loop 
										?>
                                        <th colspan="5"> TOTAL </th>
                                        <th> <?php echo number_format($sum_hours); ?></th>
                                        <th> <?php echo number_format($sum_visits); ?></th>
                                        <th> <?php echo number_format($sum_vitabu); ?></th>
                                        <th> <?php echo number_format($sum_value_money); ?></th>
                                        <th> </th>
                                   
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
				
				View_APDD_List($conferenceID,$zoneID,$month,$year);
				
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






