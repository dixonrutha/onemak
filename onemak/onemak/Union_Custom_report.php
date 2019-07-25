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
                    <li class="active">Union Custom Report</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE TITLE -->
                <!--div class="page-title">                    
                    <h2><span class="fa fa-arrow-circle-o-left"></span> Basic Tables</h2>
                </div>-->
                <!-- END PAGE TITLE -->                
                
                <!-- PAGE CONTENT WRAPPER -->
                <?php
				
				function View_Evangelists_Reports($conferenceID,$zoneID,$year,$month,$order_by,$start_month)
				{
					
					require('connection.php');
					
					$array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
				?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Union Evangelists Custom Report - To be Sent to East and Central Africa Division(ECD) </h3>
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
								$sql = "SELECT * FROM conferences_list";
								//echo $sql;
								$query = mysql_query($sql,$connect)or die(mysql_error());
								//data-toggle="tooltip"
								//MultiQueryReport($month,$year,$order_by);
								?>
                               <!-- <a href="?View_zone_single=<?php echo $zoneID; ?>" data-toggle="tooltip" data-placement="bottom" title="Click to View List of Evangelists "> <b> Evangelists Detail List </b> </a> <br><br> -->
                                
                                Showing Report for <?php echo $array_months[$start_month]; ?> To <?php echo $array_months[$month]; ?> , <?php echo $year; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                
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
                                                <label class="col-md-3 control-label">From</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="start_month" required>
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
                                                <label class="col-md-3 control-label">To</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="month" required>
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
                                            
                                           <!-- <div class="form-group">
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
                                            </div>-->
                                            
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
									<?php
									$evange_grade_query = mysql_query("SELECT  * FROM evangelists_grades",$connect)or die(mysql_error());
									$num_rows_grades = mysql_num_rows($evange_grade_query);
									?>

                                    <table id="customers" class="table table-striped">
                                        <thead>
                                            <tr>
                                            	<th rowspan="2"> No </th>
                                                <th rowspan="2">Conference</th>
                                                <th rowspan="2"> No. of PMD LARS </th>
                                                <th colspan="<?php echo ($num_rows_grades+1); ?>"> <center>No. of literature Evangelists</center> </th>
                                                
                                                <th rowspan="2"><center>Total no. hours works</center></th>
                                                <th rowspan="2"><center>Total sales in Tshs</center></th>
                                                <th rowspan="2"> <center>No. of Books et magazines sold</center> </th>
                                                <th rowspan="2"><center>Free<br>Literature Given</center></th>
                                                <th rowspan="2">Prayers offered</th>
                                                <th rowspan="2"><center>No. of Homes Visited</center></th>
                                                <th rowspan="2"><center>Interest Contacts for Bibles studies</center></th>
                                                <th rowspan="2">LE contact Baptized

</th>

                                            </tr>
                                            <tr>
                                            <?php
											while($fetch_grades_evang = mysql_fetch_array($evange_grade_query))
											{
												?>
                                                <th> <?php echo $fetch_grades_evang['code']; ?> </th>
                                                <?php	
											}
											?>
                                            <th> TOTAL </th>
                                            </tr>
                                            
                                        </thead>
                                        <tbody>
                                        <?php
										if(mysql_num_rows($query)==0)
										{
											?>
                                            <tr>
                                            <td colspan="17"> No Conferences Registered </td> </tr>
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
												$confID = $fetch_conferences_lists['ID'];
												
												//$zoneIDre = getzoneID($evangID);
												//$confIDre = getConfID($zoneIDre);
												
												?>
                                            <tr>
                                            	<td> <?php echo $num; ?>. </td>
                                                <td> <?php echo $fetch_conferences_lists['Abbreviation']; ?>  </td>
                                                <td> <?php echo ReturnZoneDetails($zoneIDre,'ZoneName'); ?></td>
                                                
                                                <?php
												
													$sum_hours = $sum_hours + UnionCustomFigure($confID,$month,$year,'hours',$start_month);
													$sum_books_sold = $sum_books_sold + UnionCustomFigure($confID,$month,$year,'books_sold+Magazines',$start_month);
													$sum_value_sale = $sum_value_sale + UnionCustomFigure($confID,$month,$year,'Value_sales',$start_month);
													$free_literature = $free_literature + UnionCustomFigure($confID,$month,$year,'free_literature',$start_month);
													$prayers = $prayers + UnionCustomFigure($confID,$month,$year,'prayers_offered',$start_month);
													$bible_studies = $bible_studies + UnionCustomFigure($confID,$month,$year,'Bibles_studies_given',$start_month);
													$baptized = $baptized + UnionCustomFigure($confID,$month,$year,'no_baptised',$start_month);
													$visited = $visited + UnionCustomFigure($confID,$month,$year,'Waliotembelewa',$start_month);
													
													$evange_grade_query22 = mysql_query("SELECT  * FROM evangelists_grades",$connect)or die(mysql_error());
													$sum_evang_conf = 0;
													while($fetch_grader22=mysql_fetch_array($evange_grade_query22))
													{
														$id_grade = $fetch_grader22['ID'];
														$number_evang = NumberEvangelistsUnion($confID,$id_grade);
														$sum_evang_conf = $sum_evang_conf + $number_evang;
														?>
                                                        <td align="center"> <?php echo number_format($number_evang); ?> </td>
                                                        <?php	
													}
													?>
                                                <td align="center"> <?php echo number_format($sum_evang_conf); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(UnionCustomFigure($confID,$month,$year,'hours',$start_month)); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionCustomFigure($confID,$month,$year,'Value_sales',$start_month)); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(UnionCustomFigure($confID,$month,$year,'books_sold+Magazines',$start_month)); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionCustomFigure($confID,$month,$year,'free_literature',$start_month)); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionCustomFigure($confID,$month,$year,'prayers_offered',$start_month)); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionCustomFigure($confID,$month,$year,'Waliotembelewa',$start_month)); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionCustomFigure($confID,$month,$year,'Bibles_studies_given',$start_month)); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionCustomFigure($confID,$month,$year,'no_baptised',$start_month)); ?> </td>
                                               
                                            </tr>
                                          <?php
											}
										}
										?>
                                        <tr>
                                        <th colspan="2"> TOTAL  </th>
                                        <th> <center><?php echo number_format($value1); ?> </center> </th>
                                        <?php
                                        $evange_grade_query33 = mysql_query("SELECT  * FROM evangelists_grades",$connect)or die(mysql_error());
													$sum_evang_conf_t = 0;
													while($fetch_grade33=mysql_fetch_array($evange_grade_query33))
													{
														$id_grade = $fetch_grade33['ID'];
														$number_evang22 = NumberEvangelistsUnionTotal($confID,$id_grade);
														$sum_evang_conf_t = $sum_evang_conf_t + $number_evang22;
														?>
                                                        <th><center> <?php echo number_format($number_evang22); ?></center> </td>
                                                        <?php	
													}
										?>
                                        <th> <center> <?php echo number_format($sum_evang_conf_t); ?> </center> </th>
                                        
                                        <th> <center><?php echo number_format($sum_hours); ?> </center></th>
                                        <th> <center><?php echo number_format($sum_value_sale); ?> </center></th>
                                        <th> <center><?php echo number_format($sum_books_sold); ?> </center></th>
                                        <th> <center><?php echo number_format($free_literature); ?></center> </th>
                                        <th> <center><?php echo number_format($prayers); ?></center></th>
                                        <th> <center><?php echo number_format($visited); ?></center></th>
                                        <th> <center><?php echo number_format($bible_studies); ?></center></th>
                                        <th> <center><?php echo number_format($baptized); ?> </center> </th>
                                        
                                        </tr>
                                        </tbody>
                                    </table>                                    
                                    
                                    <br><br>
                                   <b> Northern Tanzania Union Conference </b>
                                    
                                    <br><br>
                                   <b> Pr. Davis Fue </b>
									<br>
                                    <i>Signed: Union Publishing Director</i>
                                    
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
					View_Evangelists_Reports($conferenceID,$zoneID,$_GET['year'],$_GET['month'],$_GET['order_by'],$_GET['start_month']);
				}
				else
				{
					$year = date('Y');
					$month = date('m')-1;
					View_Evangelists_Reports($conferenceID,$zoneID,$year,$month,'Value_sales',1);
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






