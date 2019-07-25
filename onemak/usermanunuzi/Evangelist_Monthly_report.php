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
                    <li class="active">Evangelists Monthly Feedback</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE TITLE -->
                <!--div class="page-title">                    
                    <h2><span class="fa fa-arrow-circle-o-left"></span> Basic Tables</h2>
                </div>-->
                <!-- END PAGE TITLE -->                
                
                <!-- PAGE CONTENT WRAPPER -->
                <?php
				
				function View_Evangelists_Reports($conferenceID,$year,$month,$sql,$order_by_which,$direction,$item_analysed)
				{
					
					require('connection.php');
					
					$value_desc = array("hours"=>"Working Hours","books_sold"=>"Books sold","Value_sales"=>"Value of Sale","free_literature"=>"Free Literature","v_o_p"=>"Voice of Prophet","people_attending_SS"=>"Attending SS","sda_back_slinders"=>"Back Slinders","prayers_offered"=>"Prayers Offered","Bibles_studies_given"=>"Bible Studies","people_joining_bapstism_classes"=>"Joining Baptism Classe","no_baptised"=>"Baptized","Magazines"=>"Magazines","Waliotembelewa"=>"Home Visited");
					
					$array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
				?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Evangelist Monthly Report - <?php echo return_conference_name($conferenceID); ?> </h3>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Report</button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="Evangellists_Monthly_report.xlsx"><img src='img/icons/xls.png' width="24"/> Excel </a></li>
                                            <li><a href="#"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                            <li><a href="#"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                                    </div>                                    
                                    
                                </div>
                                <div class="panel-body">
                                <?php
								//ORDER BY $order_by DESC
								$sql = "SELECT * FROM zones_lists  WHERE conferenceID='$conferenceID'   ";
								//echo $sql;
								$query = mysql_query($sql,$connect)or die(mysql_error());
								//data-toggle="tooltip"
								ExportMonthlyEvangelistsReport($conferenceID,$year,$month,$sql,$order_by_which,$direction,$item_analysed);
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
                                                <label class="col-md-3 control-label">Month</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select required class="form-control select" name="month" required>
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
                                                    <select required class="form-control select" name="year" required>
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
                                                <label class="col-md-3 control-label">Item:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select required class="form-control select" name="order_by" required>
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
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Conference:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select required class="form-control select" name="confID" required>
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


                                    <table id="customers" class="table table-striped" border="1">
                                        <thead>
                                            <tr>
                                            	<th> No </th>
                                                <th>EVANGELIST NAME</th>
                                                <th> GRADE </th>
                                                <th colspan="2"> <center> <?php echo $value_desc[$item_analysed]; ?> </center></th>
                                               <th> <center>INCREMENT</center> </th>
                                               <th colspan="3"> <center>POSITION</center> </th>
                                            </tr>
                                            <tr>
                                            <th colspan="3"> </th>
                                            <th> <center><?php echo $array_months[$month].", ".($year-1); ?></center> </th> <th> <center><?php echo $array_months[$month].", ".$year; ?></center> </th>
                                            <th> <center>%</center> </th>
                                            <th> <center>ZONE</center> </th> <th> <center>CONFERENCE</center> </th> <th> <center>UNION</center> </th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
										if(mysql_num_rows($query)==0)
										{
											?>
                                            <tr>
                                            <td colspan="9"> No Report Found </td> </tr>
                                            </tr>
                                            <?php
										}	
										else
										{
											
											while($fetch_conferences_lists = mysql_fetch_array($query))
											{
												$zoneID = $fetch_conferences_lists['ID'];
												$fetch_evangelists_Query = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID'",$connect)or die(mysql_error());
												?>
                                            <tr>
                                            	<th colspan="9"> <?php echo $fetch_conferences_lists['ZoneName']; ?> </th>
                                            </tr>
                                          <?php
										  	if(mysql_num_rows($fetch_evangelists_Query)>0)
											{
												$num= 0;
												while($fetch_evangelists_results = mysql_fetch_array($fetch_evangelists_Query))
												{
													$num++;
													$evangID = $fetch_evangelists_results['ID'];
													?>
                                                    <tr>
                                                    <td> <?php echo $num; ?> </td>
                                                    <td> <?php echo $fetch_evangelists_results['First_Name']." ".$fetch_evangelists_results['Middle_Name']." ".$fetch_evangelists_results['Last_Name']; ?> </td>
                                                    <td> <?php echo return_grade_Name($fetch_evangelists_results['Grade']); ?> </td>
                                                    <?php
													$old_val = Sum_Monthly_Value($evangID,$month,$year-1,$item_analysed);
													$new_val = Sum_Monthly_Value($evangID,$month,$year,$item_analysed);
													?>
                                                    <td align="center"> <?php echo number_format($old_val); ?> </td>
                                                    <td align="center"> <?php echo number_format($new_val); ?> </td>
                                                    <td align="center">
                                                    <?php
                                                    if($old_val==0 and $new_val==0)
													{
														echo "0.00 %";
													}
													else if($old_val==0 and $new_val>0)
													{
														echo "100 %";
													}
													else if ($old_val>0 and $new_val>0)
													{
														$pungufu1 = (($new_val - $old_val)/$old_val)*100;	
														echo round($pungufu1,2)." %";
													}
													else
													{
														echo "0.00 %";
													}
													
													?>
                                                    </td>
                                                    <td align="center"> <?php echo ArrangezoneMonthly($evangID,$month,$year,$item_analysed,$zoneID); ?> </td>
                                                    <td align="center"> <?php echo ArrangeConfMonthly($evangID,$month,$year,$item_analysed,$zoneID,$conferenceID); ?> </td>
                                                    <td align="center"> <?php echo ArrangeUnionMonthly($evangID,$month,$year,$item_analysed,$zoneID,$conferenceID); ?> </td>
                                                    </tr>
                                                    <?php
												}//end function 
											}
											else
											{
												?>
                                               	<tr> <td colspan="9"> No Evangelists Registered in this Zone </td> </tr>
                                                <?php
											}
											
											}
										}
										?>
                                        
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
					View_Evangelists_Reports($_GET['confID'],$_GET['year'],$_GET['month'],$sql,$order_by_which,$direction,$_GET['order_by']);
				}
				else
				{
					$year = date('Y');
					$month = date('m')-1;
					View_Evangelists_Reports('1',$year,$month,$sql,$order_by_which,$direction,'Value_sales');
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






