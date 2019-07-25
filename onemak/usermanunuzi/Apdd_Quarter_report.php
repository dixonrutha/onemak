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
					
					$array_months = array("1"=>"Quarter One","2"=>"Quarter Two","3"=>"Quarter Three","4"=>"Quarter Four");
				?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> APDD Quartely Report - <?php echo return_conference_name($conferenceID); ?> </h3>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Report</button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="#"><img src='img/icons/xls.png' width="24"/> Excel </a></li>
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
								//ExportMonthlyEvangelistsReport($conferenceID,$year,$month,$sql,$order_by_which,$direction,$item_analysed);
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


                                    <table id="customers" class="table table-striped">
                                        <thead>
                                            <tr>
                                            	<th> No </th>
                                                <th>ZONE </th>
                                                <th> APDD NAME </th>
                                                <th> Hours </th>
                                                <th> Books Sold </th>
                                                <th> Value of Sales </th>
                                                <th> Homes Visited </th>
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
											$num = 0;
											$sum_hours = 0;
											$sum_books = 0;
											$sum_visits = 0;
											$sum_sales = 0;
											
											while($fetch_conferences_lists = mysql_fetch_array($query))
											{
												$num++;
												$zoneID = $fetch_conferences_lists['ID'];
												$sum_hours = $sum_hours + Apdd_Quarter_Calculation($zoneID,$month,$year,'hours');
												$sum_books = $sum_books + Apdd_Quarter_Calculation($zoneID,$month,$year,'vitabu');
												$sum_visits = $sum_visits + Apdd_Quarter_Calculation($zoneID,$month,$year,'waliotembelewa');
												$sum_sales = $sum_sales + Apdd_Quarter_Calculation($zoneID,$month,$year,'mauzo_siku');
												?>
                                            	<tr>
                                                <td> <?php echo $num; ?>. </td>
                                            	<td> <?php echo $fetch_conferences_lists['ZoneName']; ?> </td>
                                                <td> <?php echo $fetch_conferences_lists['Assistant_Publishing_Director']; ?> </td>
                                                <td> <?php echo number_format(Apdd_Quarter_Calculation($zoneID,$month,$year,'hours')); ?> </td>
                                                <td> <?php echo number_format(Apdd_Quarter_Calculation($zoneID,$month,$year,'vitabu')); ?> </td>
                                                <td> <?php echo number_format(Apdd_Quarter_Calculation($zoneID,$month,$year,'mauzo_siku')); ?> </td>
                                                <td> <?php echo number_format(Apdd_Quarter_Calculation($zoneID,$month,$year,'waliotembelewa')); ?> </td>
                                              <?php
										
											}//end while loop
										}
										?>
                                        <tr>
                                        <th colspan="3"> TOTAL </th>
                                        
                                        <th> <?php echo number_format($sum_hours); ?> </th>
                                        <th> <?php echo number_format($sum_books); ?> </th>
                                        <th> <?php echo number_format($sum_sales); ?> </th>
                                        <th> <?php echo number_format($sum_visits); ?> </th>
                                        
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
					View_Evangelists_Reports($_GET['confID'],$_GET['year'],$_GET['month'],$sql,$order_by_which,$direction,$_GET['order_by']);
				}
				else
				{
					$year = date('Y');
					$month = date('m')-1;
					View_Evangelists_Reports('1',$year,1,$sql,$order_by_which,$direction,'mauzo_siku');
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






