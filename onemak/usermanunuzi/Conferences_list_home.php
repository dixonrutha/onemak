<?php
session_start();
require('functions.php');
require('constants_configurations.php');
require('Excel_template_export_conferences.php');
require('Excel_template_export_reports.php');
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
			if(confirm("Are you sure you want to Delete - "+ apl ))
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
                    <li><a href="#">kilimo Net</a></li>
                    <li><a href="#">Pages</a></li>
                    <li class="active">My Product Request</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE TITLE -->
                <!--div class="page-title">                    
                    <h2><span class="fa fa-arrow-circle-o-left"></span> Basic Tables</h2>
                </div>-->
                <!-- END PAGE TITLE -->                
                
                <!-- PAGE CONTENT WRAPPER -->
                <?php
				function View_Conferences_List()
				{
					
				?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> My Product Orders / Requests </h3>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="ntuc_conferences_lists.xlsx"><img src='img/icons/xls.png' width="24"/> Excel </a></li>
                                            <li><a href="#"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                            <li><a href="#"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                                    </div>                                    
                                    
                                </div>
                                <div class="panel-body">
                                <?php
                                $YourUserID = return_user_ID($_SESSION['username']);

								$sql = "SELECT * FROM users_requests WHERE UserID='$YourUserID' ORDER BY ID DESC ";

								//Export_Conferences_lists($sql); //Codes to generate Microsoft Excel file
								require('connection.php');
								$query = mysql_query($sql,$connect)or die(mysql_error());
								?>

                                <div id="chooseMarketModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Choose the Market for your Order</h4>
      </div>
      <div class="modal-body">
        <p>Please Select Market from the Market List below.
        
        <div class="row">
        <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <div class="col-md-6">
        
        <div class="form-group">
                                                <label class="col-md-3 control-label"> Market </label>
                                                <div class="col-md-9">                                                                                            
                                                    <select required class="form-control select" name="MarketID" required>
                                                    <option value="">-----Select Market-------</option>
                                        <?php
                                        $queryMarketList = mysql_query("SELECT * FROM markets",$connect)or die(mysql_error());
                                        while($fetchMarketLists = mysql_fetch_array($queryMarketList))
                                        {
                                            ?>
                                            <option value="<?php echo $fetchMarketLists['ID']; ?>"><?php echo $fetchMarketLists['MarketName']; ?></option>
                                            <?php
                                        }
                                        ?>
                                                        
                                                        
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            
                                            
                                            <br><br>
                                             <div class="col-md-6">
                                             <div class="form-group">
                                             <div class="col-md-9">
                                            <button name="add_new_market" class="btn btn-primary pull-right" type="submit">Submit</button>
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


                                <a href="#chooseMarketModal" data-toggle="modal" data-placement="right" title="Click to Create a New Product Order/Request "><b>Create a New Products Order/Request </b> </a> <!--| <a href="?view_union_summary=1"  data-toggle="tooltip" data-placement="right" title="Click to View Union Evangelist Summary "><b> View Union Summary </b> </a>--><br><br>
                                
                                    <table id="customers" class="table table-striped">
                                        <thead>
                                            <tr>
                                            	<th> No </th>
                                                <th> Order Date </th>
                                                <th> Order Time </th>
                                                <th> Market </th>
                                                <th> Products Ordered / Requested </th>
                                                <th> Total Amount </th>
                                                <th> Name(PickUp) </th>
                                                <th> Phone(PickUp) </th>
                                                <th> Order Status </th>
                                                <th> Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
										if(mysql_num_rows($query)==0)
										{
											?>
                                            <tr>
                                            <td colspan="10"> There is No Records of any Requests from you </td> </tr>
                                            </tr>
                                            <?php
										}	
										else
										{
											
											$num = 0;
											while($fetch_conferences_lists = mysql_fetch_array($query))
											{
                                                $id = $fetch_conferences_lists['ID'];

                                                $queryIndProd = mysql_query("SELECT * FROM users_requests_items WHERE ReqID='$id' ",$connect)or die(mysql_error());
												$num++;
										?>
                                            <tr>
                                            	<td> <?php echo $num; ?>. </td>
                                                <td> <?php echo $fetch_conferences_lists['ReqDate']; ?> </td>
                                                <td> <?php echo $fetch_conferences_lists['ReqTime']; ?> </td>
                                                <td> <?php echo return_conference_name($fetch_conferences_lists['marketID']); ?> </td>
                                                <td> 
                                                    <?php 
                                                    if(mysql_num_rows($queryIndProd)==0)
                                                    {
                                                        echo  "No Products Requested";
                                                    }
                                                    else
                                                    {
                                                        $totalOrderAmount = 0;
                                                        while($fetchIndiProd = mysql_fetch_array($queryIndProd))
                                                        {
                                                            $singleProAmount = $fetchIndiProd['Quantity']* $fetchIndiProd['AmountPerUnit'];
                                                            $totalOrderAmount = $totalOrderAmount + $singleProAmount;

                                                            echo getProductName($fetchIndiProd['ProductID'])." ".$fetchIndiProd['Quantity'].getProductUnit($fetchIndiProd['ProductID']).", ";
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td> <?php echo number_format($totalOrderAmount); ?> </td>

                                                <td> <?php echo $fetch_conferences_lists['pickupName']; ?> </td>
                                                <td> <?php echo $fetch_conferences_lists['pickupphone']; ?> </td>

                                                <td> <?php echo $fetch_conferences_lists['OrderStatus']; ?> </td>
                                                
                                                <td>
                                                <div class="btn-group pull-right"> 
                                                	<a href="#" data-toggle="dropdown" > Action </a>
                                                		<ul class="dropdown-menu">
                                                			
                                                			<li> <a href="?Edit_market_info=<?php echo $fetch_conferences_lists['ID']; ?>&marketID=<?php echo $fetch_conferences_lists['marketID']; ?>"> Modify Order </a> </li>
                                                			<li> <a onclick="return DeleteConfirm('<?php echo $fetch_conferences_lists['ReqDate']; ?> Order ?')" href="?delete_market=<?php  echo $fetch_conferences_lists['ID']; ?>"> Delete Order </a> </li>
                                                		</ul>
                                                 </div>
                                                 </td>
                                            </tr>
                                          <?php
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

                function View_Market_staff($conferenceID)
                {
                    
                ?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> <?php echo return_conference_name($conferenceID); ?> Market Staffs </h3>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="ntuc_conferences_lists.xlsx"><img src='img/icons/xls.png' width="24"/> Excel </a></li>
                                            <li><a href="#"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                            <li><a href="#"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                                    </div>                                    
                                    
                                </div>
                                <div class="panel-body">
                                <?php
                                $sql = "SELECT * FROM publishing_staffs WHERE MarketID='$conferenceID' ";
                                //Export_Conferences_lists($sql); //Codes to generate Microsoft Excel file
                                require('connection.php');
                                $query = mysql_query($sql,$connect)or die(mysql_error());
                                if($_SESSION['title']=="System Administrator")
                                {
                                ?>
                                <a href="?add_new_market_staff=<?php echo $conferenceID; ?>"  data-toggle="tooltip" data-placement="right" title="Click to Add/Register a New Market Staff"><b>Register New Staff </b> </a> <!--| <a href="?view_union_summary=1"  data-toggle="tooltip" data-placement="right" title="Click to View Union Evangelist Summary "><b> View Union Summary </b> </a>--><?php } ?> <br><br>
                                
                                    <table id="customers" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th> No </th>
                                                <th>Staff Name</th>
                                                <th>Gender</th>
                                                <th>Title</th>
                                                <th>Phone </th>
                                                <th>Email</th>
                                                <th>Username</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if(mysql_num_rows($query)==0)
                                        {
                                            ?>
                                            <tr>
                                            <td colspan="8"> No Staffs Registered </td> </tr>
                                            </tr>
                                            <?php
                                        }   
                                        else
                                        {
                                            
                                            $num = 0;
                                            while($fetch_conferences_lists = mysql_fetch_array($query))
                                            {
                                                $num++;
                                        ?>
                                            <tr>
                                                <td> <?php echo $num; ?>. </td>
                                                <td> <?php echo $fetch_conferences_lists['FirstName']." ".$fetch_conferences_lists['Middlename']." ".$fetch_conferences_lists['LastName']; ?> </td>
                                                <td> <?php echo $fetch_conferences_lists['Gender']; ?> </td>
                                                <td> <?php echo $fetch_conferences_lists['Title']; ?> </td>
                                                <td> <?php echo $fetch_conferences_lists['Phone']; ?> </td>
                                                <td> <?php echo $fetch_conferences_lists['Email']; ?> </td>
                                                <td> <?php echo $fetch_conferences_lists['username']; ?></td>
                                                <td>
                                                <div class="btn-group pull-right"> 
                                                    <a href="#" data-toggle="dropdown" > Action </a>
                                                        <ul class="dropdown-menu">
                                                            <li> <a href="?View_Conference_single=<?php echo $fetch_conferences_lists['ID'] ?>"> View <?php echo $fetch_conferences_lists['MarketName']; ?> Details </a> </li>
                                                            <li> <a href="?Edit_market_info=<?php echo $fetch_conferences_lists['ID']; ?>"> Edit <?php echo $fetch_conferences_lists['MarketName']; ?> Details </a> </li>
                                                            <li> <a href="#"> Delete <?php echo $fetch_conferences_lists['MarketName']; ?> Details </a> </li>
                                                        </ul>
                                                 </div>
                                                 </td>
                                            </tr>
                                          <?php
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
                }//end function Conference
				
				function View_APDD_List($conferenceID,$zoneID,$month,$year)
				{
					$total_days = cal_days_in_month(CAL_GREGORIAN,$month,$year);
					
					$days_week = array("1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday","0"=>"Sunday");
					
					$dayofweek = date('w', strtotime('2017-04-20'));
					//echo $dayofweek;
					
					$array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
					
					Evangelists_Apdd_monthly_report($zoneID,$month,$year,$conferenceID);
					
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
                                           
                                            <li><a href="Apdd_zone_monthly_report.xlsx"><img src='img/icons/xls.png' width="24"/> Excel </a></li>
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
                                                <th>Evangelist Name(s)</th>
                                                
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
                                                <td> <?php echo return_Evang_Name($fetch_apdd['evangID'])." - ".return_grade_Name($fetch_apdd['Grade']); 
												if($fetch_apdd['evangID_2']>0)
												{
													echo "<br>".return_Evang_Name($fetch_apdd['evangID_2'])." - ".return_grade_Name($fetch_apdd['Grade_2']);	
												}
												
												if($fetch_apdd['evangID_3']>0)
												{
													echo "<br>".return_Evang_Name($fetch_apdd['evangID_3'])." - ".return_grade_Name($fetch_apdd['Grade_3']);	
												}
												
												if($fetch_apdd['evangID_4']>0)
												{
													echo "<br>".return_Evang_Name($fetch_apdd['evangID_4'])." - ".return_grade_Name($fetch_apdd['Grade_4']);	
												}
												
												?> </td>
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
				
				function New_Report_Apdd($zoneID,$month,$year,$date,$confID)
				{
					require('connection.php');
					
					$zone_query_evang = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID' ",$connect)or die(mysql_error());
					$zone_query_evang2 = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID' ",$connect)or die(mysql_error());
					$zone_query_evang3 = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID' ",$connect)or die(mysql_error());
					$zone_query_evang4 = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID' ",$connect)or die(mysql_error());
					
					
					$zone_query = mysql_query("SELECT * FROM zones_lists WHERE ID='$zoneID' ",$connect)or die(mysql_error());
					$zone_details = mysql_fetch_array($zone_query);
					?>
                    <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input type="hidden" name="month" value="<?php echo $month; ?>">
                            <input type="hidden" name="year" value="<?php echo $year; ?>">
                             <input type="hidden" name="zoneID" value="<?php echo $zoneID; ?>">
                             <input type="hidden" name="date" value="<?php echo $date; ?>">
                             <input type="hidden" name="confID" value="<?php echo $confID; ?>">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                
                                    <h3 class="panel-title">New APDD Report Dated <?php echo Date_formating($date); ?> </h3>
                                    
                                    <ul class="panel-controls">
                                        <!-- <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li> -->
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <p>Please Fill the form below to Add APDD Report, All fields with a * must be filled.</p>
                                    <a href="?view_apdd_report=<?php echo  $confID; ?>&zoneID=<?php echo $zoneID ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>"> Back </a> 
                                </div>
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*APDD Name:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="apdd_name" class="form-control" placeholder="APDD Name" value="<?php echo $zone_details['Assistant_Publishing_Director']; ?>" required/>                                                    </div> 
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Evangelists/Jina la Mwinjilist:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select required class="form-control select" name="Evangelist_name">
                                                     <option value="">------Select Evangelist ------</option>
                                                        <?php
														while($fetch_evangelists = mysql_fetch_array($zone_query_evang))
														{
														?>
                                                        <option value="<?php echo $fetch_evangelists['ID']; ?>"><?php echo $fetch_evangelists['First_Name']." ".$fetch_evangelists['Middle_Name']." ".$fetch_evangelists['Last_Name']." - ".return_grade_Name($fetch_evangelists['Grade']); ?></option>
                                                        <?php
														}
														?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Evangelists/Jina la Mwinjilist 2:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="Evangelist_name2">
                                                     <option value="">------Select Evangelist ------</option>
                                                        <?php
														while($fetch_evangelists2 = mysql_fetch_array($zone_query_evang2))
														{
														?>
                                                        <option value="<?php echo $fetch_evangelists2['ID']; ?>"><?php echo $fetch_evangelists2['First_Name']." ".$fetch_evangelists2['Middle_Name']." ".$fetch_evangelists2['Last_Name']." - ".return_grade_Name($fetch_evangelists2['Grade']); ?></option>
                                                        <?php
														}
														?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Evangelists/Jina la Mwinjilist 3:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="Evangelist_name3">
                                                     <option value="">------Select Evangelist ------</option>
                                                        <?php
														while($fetch_evangelists3 = mysql_fetch_array($zone_query_evang3))
														{
														?>
                                                        <option value="<?php echo $fetch_evangelists3['ID']; ?>"><?php echo $fetch_evangelists3['First_Name']." ".$fetch_evangelists3['Middle_Name']." ".$fetch_evangelists3['Last_Name']." - ".return_grade_Name($fetch_evangelists3['Grade']); ?></option>
                                                        <?php
														}
														?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Evangelists/Jina la Mwinjilist 4:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="Evangelist_name4">
                                                     <option value="">------Select Evangelist ------</option>
                                                        <?php
														while($fetch_evangelists4 = mysql_fetch_array($zone_query_evang4))
														{
														?>
                                                        <option value="<?php echo $fetch_evangelists4['ID']; ?>"><?php echo $fetch_evangelists4['First_Name']." ".$fetch_evangelists4['Middle_Name']." ".$fetch_evangelists4['Last_Name']." - ".return_grade_Name($fetch_evangelists4['Grade']); ?></option>
                                                        <?php
														}
														?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="col-md-6">
                                            
                                            
                                            
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Hours / Masaa ya kazi:</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Hours" name="hours" >                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>         
                                            
                                    <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Visits / Waliotembelewa:</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="People Visited" name="vists" >
                                                    </div>
                                                </div>
                                            </div>      
                                            
                                            
                                     <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Books / Vitabu Vilivyouzwa:</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="books" placeholder="Books Sold"  />                                                    </div>            
                                                </div>
                                            </div>
                                            
                                        
                                        
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Value of Sale / Mauzo ya Siku:</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="value_sale" placeholder="Value of Sale" required />                                                    </div>            
                                                </div>
                                            </div>
                                            
                                  
                                            
                                           
                                            
                                            
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-default">Clear Form</button>                                    
                                    <button class="btn btn-primary pull-right" type="submit" name="Save_new_app_report">Save</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                    <?php	

				}//end functio New Apdd Report
				
				function Edit_Report_Apdd($recordID,$zoneID,$month,$year,$date,$confID)
				{
					require('connection.php');
					
					$reportQuery = mysql_query("SELECT * FROM apdd_report WHERE ID='$recordID' ",$connect)or die(mysql_error());
					$fetch_report = mysql_fetch_array($reportQuery);
					
					$zone_query_evang = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID' ",$connect)or die(mysql_error());
					$zone_query_evang2 = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID' ",$connect)or die(mysql_error());
					$zone_query_evang3 = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID' ",$connect)or die(mysql_error());
					$zone_query_evang4 = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID' ",$connect)or die(mysql_error());
					
					$zone_query = mysql_query("SELECT * FROM zones_lists WHERE ID='$zoneID' ",$connect)or die(mysql_error());
					$zone_details = mysql_fetch_array($zone_query);
					?>
                    <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            
                            <input type="hidden" name="month" value="<?php echo $month; ?>">
                            <input type="hidden" name="year" value="<?php echo $year; ?>">
                             <input type="hidden" name="zoneID" value="<?php echo $zoneID; ?>">
                             <input type="hidden" name="date" value="<?php echo $date; ?>">
                             <input type="hidden" name="confID" value="<?php echo $confID; ?>">
                             <input type="hidden" name="recordID" value="<?php echo $recordID; ?>">
                             
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                
                                    <h3 class="panel-title">Editing APDD Report Dated <?php echo Date_formating($date); ?> </h3>
                                    
                                    <ul class="panel-controls">
                                        <!-- <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li> -->
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <p>Please Fill the form below to Add APDD Report, All fields with a * must be filled.</p>
                                    <a href="?view_apdd_report=<?php echo  $confID; ?>&zoneID=<?php echo $zoneID ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>"> Back </a> 
                                </div>
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*APDD Name:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="apdd_name" class="form-control" placeholder="APDD Name" value="<?php echo $fetch_report['APDD_Name']; ?>" required/>                                                    </div> 
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Evangelists/Jina la Mwinjilist:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select required class="form-control select" name="Evangelist_name">
                                                    <option value="<?php echo $fetch_report['evangID']; ?>"><?php echo return_Evang_Name($fetch_report['evangID'])." - ".return_grade_Name($fetch_report['Grade']); ?></option>
                                                     <option value="">------Select Evangelist ------</option>
                                                        <?php
														while($fetch_evangelists = mysql_fetch_array($zone_query_evang))
														{
														?>
                                                        <option value="<?php echo $fetch_evangelists['ID']; ?>"><?php echo $fetch_evangelists['First_Name']." ".$fetch_evangelists['Middle_Name']." ".$fetch_evangelists['Last_Name']." - ".return_grade_Name($fetch_evangelists['Grade']); ?></option>
                                                        <?php
														}
														?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Evangelists/Jina la Mwinjilist 2:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="Evangelist_name2">
                                                     <option value="<?php echo $fetch_report['evangID_2']; ?>"><?php echo return_Evang_Name($fetch_report['evangID_2'])." - ".return_grade_Name($fetch_report['Grade_2']); ?></option>
                                                     <option value="">------Select Evangelist ------</option>
                                                        <?php
														while($fetch_evangelists2 = mysql_fetch_array($zone_query_evang2))
														{
														?>
                                                        <option value="<?php echo $fetch_evangelists2['ID']; ?>"><?php echo $fetch_evangelists2['First_Name']." ".$fetch_evangelists2['Middle_Name']." ".$fetch_evangelists2['Last_Name']." - ".return_grade_Name($fetch_evangelists2['Grade']); ?></option>
                                                        <?php
														}
														?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Evangelists/Jina la Mwinjilist 3:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="Evangelist_name3">
                                                     <option value="<?php echo $fetch_report['evangID_3']; ?>"><?php echo return_Evang_Name($fetch_report['evangID_3'])." - ".return_grade_Name($fetch_report['Grade_3']); ?></option>
                                                     <option value="">------Select Evangelist ------</option>
                                                        <?php
														while($fetch_evangelists3 = mysql_fetch_array($zone_query_evang3))
														{
														?>
                                                        <option value="<?php echo $fetch_evangelists3['ID']; ?>"><?php echo $fetch_evangelists3['First_Name']." ".$fetch_evangelists3['Middle_Name']." ".$fetch_evangelists3['Last_Name']." - ".return_grade_Name($fetch_evangelists3['Grade']); ?></option>
                                                        <?php
														}
														?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Evangelists/Jina la Mwinjilist 4:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="Evangelist_name4">
                                                     <option value="<?php echo $fetch_report['evangID_4']; ?>"><?php echo return_Evang_Name($fetch_report['evangID_4'])." - ".return_grade_Name($fetch_report['Grade_4']); ?></option>
                                                     <option value="">------Select Evangelist ------</option>
                                                        <?php
														while($fetch_evangelists4 = mysql_fetch_array($zone_query_evang4))
														{
														?>
                                                        <option value="<?php echo $fetch_evangelists4['ID']; ?>"><?php echo $fetch_evangelists4['First_Name']." ".$fetch_evangelists4['Middle_Name']." ".$fetch_evangelists4['Last_Name']." - ".return_grade_Name($fetch_evangelists4['Grade']); ?></option>
                                                        <?php
														}
														?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6">
                                       
                                       <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Hours / Masaa ya kazi:</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Hours" name="hours" value="<?php echo $fetch_report['hours']; ?>" >                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>         
                                            
                                    <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Visits / Waliotembelewa:</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="People Visited" name="vists" value="<?php echo $fetch_report['waliotembelewa']; ?>" >
                                                    </div>
                                                </div>
                                            </div>      
                                            
                                            
                                     <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Books / Vitabu Vilivyouzwa:</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="books" placeholder="Books Sold" value="<?php echo $fetch_report['vitabu']; ?>"  />                                                    </div>            
                                                </div>
                                            </div>
                                            
                                        
                                        
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Value of Sale / Mauzo ya Siku:</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="value_sale" placeholder="Value of Sale" value="<?php echo number_format($fetch_report['mauzo_siku']); ?>" required />                                                    </div>            
                                                </div>
                                            </div>
                                     
                                            
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-default">Clear Form</button>                                    
                                    <button class="btn btn-primary pull-right" type="submit" name="Save_edit_apdd_report">Update</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                    <?php	

				}//end functio New Apdd Report
				
				
				function View_Conference_Single($conferenceID,$reportID)
				{
				?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> <?php echo return_conference_name($conferenceID); ?> Market </h3>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="products_weekly_report.xlsx"><img src='img/icons/xls.png' width="24"/> Excel </a></li>
                                            <li><a href="#"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                            <li><a href="#"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                                    </div>                                    
                                    
                                </div>
                                <div class="panel-body">
                                <?php
								$sql2 = "SELECT * FROM products  ";
								require('connection.php');
								$query = mysql_query($sql2,$connect)or die(mysql_error());
								
								//Export_Zones_lists($sql,$conferenceID);
								
								?>
                               <a href="?cancel=1" data-toggle="tooltip" data-placement="bottom" title="Click to go back to conferences lists"> <b> Back </b> </a> | <a href="#" data-toggle="modal" data-target="#myModalOtherreport"><b> View Other Reports </b> </a> | <a href="#" data-toggle="modal" data-target="#myModal"><b> Add/Edit product Prices </b> </a> | <a href="?Market_staffs=<?php echo $conferenceID; ?>"> <b>Market Staffs </b> </a> <br><br>
                               
                               <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Adding Product Prices</h4>
      </div>
      <div class="modal-body">
        <p>Please select report dates to add product prices.
        
        <div class="row">
        <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="hidden" name="marketID" value="<?php echo $conferenceID; ?>" >
        <div class="col-md-6">
        										<div class="form-group">
                                                <label class="col-md-3 control-label"> From</label>
                                                <div class="col-md-9">                                                                                            
                                                    <input type="text" name="Start_date" class="form-control datepicker" placeholder="Start Date" />
                                                    
                                                </div>
                                            </div>
                                            <br> 
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" > To</label>
                                                <div class="col-md-9">                                                                                            
                                                    <input type="text" name="end_date" class="form-control datepicker" placeholder="End Date" />
                                                    
                                                </div>
                                            </div>
                                            
                                            <br> 
                                            
                                            <br><br>
                                             <div class="col-md-6">
                                             <div class="form-group">
                                             <div class="col-md-9">
                                            <button class="btn btn-primary pull-right" name="new_market_price_report" type="submit">Submit</button>
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

<div id="myModalOtherreport" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">View other Registered Reports</h4>
      </div>
      <div class="modal-body">
        <p>Please select report dates to View other registered reports.
        
        <div class="row">
        <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
        <input type="hidden" name="marketID" value="<?php echo $conferenceID; ?>" >
        <div class="col-md-6">
                                                <div class="form-group">
                                                <label class="col-md-3 control-label"> Week: </label>
                                                <div class="col-md-9">
                                                <?php
                                                $queryViewOther = mysql_query("SELECT * FROM product_prices_dates WHERE MarketID='$conferenceID'ORDER BY  EndDate DESC",$connect)or die(mysql_error());
                                                ?>                               
                                                    <select class="form-control select" name="reportID" required>
                                                    <option value="">---Select report to View---</option>
                                                        <?php
                                                        if(mysql_num_rows($queryViewOther)==0)
                                                        {

                                                        }
                                                        else
                                                        {
                                                            while($fetch_avg_reps = mysql_fetch_array($queryViewOther))
                                                            {
                                                                ?>
                                                                <option value="<?php echo $fetch_avg_reps['ID'];?>"> <?php echo Date_formating($fetch_avg_reps['Startdate']); ?> to <?php echo Date_formating($fetch_avg_reps['EndDate']); ?> </option>
                                                                <?php
                                                            }
                                                        }

                                                        ?>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            <br> 
                                            
                                            
                                            <br> 
                                            
                                            <br><br>
                                             <div class="col-md-6">
                                             <div class="form-group">
                                             <div class="col-md-9">
                                            <button class="btn btn-primary pull-right" name="View_other_market_price_report" type="submit">Submit</button>
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


<?php
if(!empty($reportID))
{
    $addQuery = "AND ID='$reportID' ";
}
else
{
    $addQuery = " ";
}

$sql = "SELECT * FROM product_prices_dates WHERE MarketID='$conferenceID' $addQuery ORDER BY ID DESC LIMIT 1 ";

//Exporting Data to Microsoft Excel Format.
ExportProductsReport($sql);

$query_check_report = mysql_query($sql,$connect) or die(mysql_error());
if(mysql_num_rows($query_check_report)==0)
{

}
else
{

    $fetch_initial_report = mysql_fetch_array($query_check_report);
    $ID_report = $fetch_initial_report['ID'];
    ?>
    The Products Price shown are as of Week Dated <b> <?php echo Date_formating($fetch_initial_report['Startdate']); ?> </b> to <b> <?php echo Date_formating($fetch_initial_report['EndDate']); ?> &nbsp;&nbsp;&nbsp;&nbsp;(<a href="
        ?edit_prices_report=<?php echo $ID_report; ?>&MarketID=<?php echo $conferenceID; ?>">Edit this report</a> )</b> <br><br>
    <?php
}
?>

                                
                                    <table id="customers" class="table table-striped">
                                        <thead>
                                            <tr>
                                            	<th> No </th>
                                                <th>Product Name</th>
                                                <th> Minimum Price </th>
                                                <th> Maximum Price </th>
                                                <th>Steps taken</th>
                                                <th>Challenges/Changamoto</th>
                                                <th> Maoni </th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
										if(mysql_num_rows($query)==0)
										{
											?>
                                            <tr>
                                            <td colspan="7"> No Product Registered  </td> </tr>
                                            </tr>
                                            <?php
										}	
										else
										{
											$num = 0;
											while($fetch_conferences_lists = mysql_fetch_array($query))
											{
												$num++;
                                                $productID = $fetch_conferences_lists['ProductID'];

										?>
                                            <tr>
                                            	<td> <?php echo $num; ?>. </td>
                                                <td> <?php echo $fetch_conferences_lists['ProductName']; ?> </td>
                                                <td> <?php echo returnProductReportValues($productID,$ID_report,'minimum_value'); ?></td>
                                                <td> <?php echo returnProductReportValues($productID,$ID_report,'maximum_value'); ?> </td>
                                                <td> <?php echo returnProductReportValues($productID,$ID_report,'steps'); ?> </td>
                                                <td> <?php echo returnProductReportValues($productID,$ID_report,'challenges'); ?> </td>
                                                <td> <?php echo returnProductReportValues($productID,$ID_report,'feedback'); ?> </td>
                                                
                                            </tr>
                                          <?php
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
				
                function EditMarketDetails($marketID)
                {
                    require('connection.php');
                    $query = mysql_query("SELECT * FROM markets WHERE ID='$marketID' ",$connect)or die(mysql_error());
                    $fetch_market_info = mysql_fetch_array($query);
                    ?>
                    <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                             
                             <input type="hidden" name="recordID" value="<?php echo $marketID; ?>">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                
                                    <h3 class="panel-title">Edit Market Details </h3>
                                    
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <p>Please Fill the form below to Register a new zone, All fields with a * must be filled.</p>
                                    <a href="?View_Conference_single=<?php echo  $conferenceID; ?>"> Back </a> 
                                </div>
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Market Name:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="market_name" class="form-control" placeholder="Market Name" required value="<?php echo $fetch_market_info['MarketName']; ?>" />
                                                    </div>                                            
                                                    
                                                </div>
                                            </div>
                                            
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">*Disrict:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="district" class="form-control" placeholder="Disrict" required value="<?php echo $fetch_market_info['District']; ?>"/>
                                                    </div>                                            
                                                    
                                                </div>
                                            </div>
                                            
                                            
                                             <div class="form-group">                                        
                                                <label class="col-md-3 control-label">*Region</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="region" placeholder="Region" value="<?php echo $fetch_market_info['Region']; ?>" required/>
                                                    </div>            
                                                   <!-- <span class="help-block">Password field sample</span> -->
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Street</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Street" value="<?php echo $fetch_market_info['Street']; ?>" name="Street">                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">                                        
                                                <label class="col-md-3 control-label">In Charge</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="In Charge" value="<?php echo $fetch_market_info['Incharge']; ?>" name="incharge">                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                          
                                          <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Phone Number</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Phone Number" name="phone_number" value="<?php echo $fetch_market_info['Phone']; ?>">                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>  
                                            
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-default">Clear Form</button>                                    
                                    <button class="btn btn-primary pull-right" type="submit" name="Save_new_zone_update">Save</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                    <?php   
                }

				function AddRegisterMarket($marketID)
				{
                    require('connection.php');
                    $idreport = returnMarketPrice($marketID);
					?>
                    <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                                <input type="hidden" name="MarketID" value="<?php echo $marketID; ?>">
                                <input type="hidden" name="UserID" value="<?php echo return_user_ID($_SESSION['username']); ?>">
                             
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                
                                    <h3 class="panel-title">Your New Product Order / Request from <?php echo return_conference_name($marketID); ?> Market </h3>
                                    
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <p>Please Fill the form below to finish your product Order / Request.</p>
                                    <a href="?cancel_back_main=1"> Back </a> 
                                </div>
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                    <?php 
                                    $query = mysql_query("SELECT * FROM products",$connect)or die(mysql_error());
                                    while($fetchProducts = mysql_fetch_array($query))
                                    {
                                        
                                        $productsMaxPrice = returnProductReportValues($fetchProducts['ProductID'],$idreport,'maximum_value');
                                        $productsMinPrice = returnProductReportValues($fetchProducts['ProductID'],$idreport,'minimum_value');
                                        $prodAvgPrice = ($productsMaxPrice+$productsMinPrice)/2;
                                        //$prodAvgPrice = number_format($prodAvgPrice);
                                    ?>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"><?php echo $fetchProducts['ProductName']; ?>: ( Tshs <?php echo $productsMaxPrice.'/'.$fetchProducts['UniMeasure'];?> ) </label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="productname_<?php echo $fetchProducts['ProductID']; ?>" class="form-control" placeholder="How many <?php echo $fetchProducts['UniMeasure']; ?> of <?php echo $fetchProducts['ProductName']; ?> e.g 20 " /> 
                                                    </div>

                                                    
                                                </div>
                                            </div>
                                       <?php
                                       }
                                       ?>     
                                            
                                        </div>

                                    <div class="col-md-6">
                                        <center><h4> Order Pickup Details </h4> </center>
                                            
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Name</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Name of the Person Picking up the order" name="pickupname" required>                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>

                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Phone Number</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Phone Number of the Person Picking up the order" name="phone_number" required>                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>

                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Street</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Street Name , Where the Order is Delivered" name="pickupstreet" required>                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>

                                             <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Popular Area</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Popular Area near the Street Name , Where the Order is Delivered" name="popularareapickup" value="<?php echo $fetch_data['Phone_Number']; ?>">                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>


                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    
                                    <!--<a href="?cancel_back_main=1"><button class="btn btn-default">Back </button> </a> &nbsp;&nbsp;&nbsp;-->

                                    <button class="btn btn-primary pull-left" type="submit" name="Save_new_zone">Save Order / Request </button>

                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                    <?php	
				}

                function EditOrderRequest($RequestID,$marketID)
                {
                    require('connection.php');
                    $queryOrder= mysql_query("SELECT * FROM users_requests WHERE ID='$RequestID' ",$connect)or die(mysql_error());
                    $fetchOrderDetails = mysql_fetch_array($queryOrder);

                     $idreport = returnMarketPrice($marketID);
                    ?>
                    <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                                <input type="hidden" name="UserID" value="<?php echo return_user_ID($_SESSION['username']); ?>">
                                <input type="hidden" name="ReqID" value="<?php echo $RequestID; ?>">
                                <input type="hidden" name="MarketID" value="<?php echo $marketID; ?>">
                             
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                
                                    <h3 class="panel-title">Modify Your Product Order / Request from <?php echo return_conference_name($marketID); ?> Market </h3> 
                                    
                                    
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <h5>Order Date: <?php echo $fetchOrderDetails['ReqDate']; ?>, Order Time: <?php echo $fetchOrderDetails['ReqTime']; ?>  </h5>
                                    <br>

                                    <p>Please Fill the form below to finish your product Order / Request.</p>
                                    <a href="?cancel_back_main=1"> Back </a> 
                                </div>
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                    <?php 
                                    $query = mysql_query("SELECT * FROM products",$connect)or die(mysql_error());
                                    while($fetchProducts = mysql_fetch_array($query))
                                    {
                                        $productsMaxPrice = returnProductReportValues($fetchProducts['ProductID'],$idreport,'maximum_value');
                                    ?>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"><?php echo $fetchProducts['ProductName']; ?>: ( Tshs <?php echo $productsMaxPrice.'/'.$fetchProducts['UniMeasure'];?> ) </label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="productname_<?php echo $fetchProducts['ProductID']; ?>" class="form-control" placeholder="How many <?php echo $fetchProducts['UniMeasure']; ?> of <?php echo $fetchProducts['ProductName']; ?> e.g 20 " value="<?php echo ProductValueOrder($RequestID,$fetchProducts['ProductID']); ?>" />
                                                    </div>                                            
                                                    
                                                </div>
                                            </div>
                                       <?php
                                       }
                                       ?>     
                                            
                                        </div>

                                        <div class="col-md-6">
                                        <center><h4> Order Pickup Details </h4> </center>
                                            
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Name</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Name of the Person Picking up the order" name="pickupname" required
                                                        value="<?php echo $fetchOrderDetails['pickupName']; ?>">                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>

                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Phone Number</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Phone Number of the Person Picking up the order" name="phone_number" required value="<?php echo $fetchOrderDetails['pickupphone']; ?>" >                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>

                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Street</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Street Name , Where the Order is Delivered" name="pickupstreet" required value="<?php echo $fetchOrderDetails['pickupstreet']; ?>" >                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>

                                             <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Popular Area</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Popular Area near the Street Name , Where the Order is Delivered" name="popularareapickup" value="<?php echo $fetch_data['Phone_Number']; ?>" value="<?php echo $fetchOrderDetails['pickupnearbypopulararea']; ?>" >                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>


                                        </div>
                                        
                                        
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    
                                    <!--<a href="?cancel_back_main=1"><button class="btn btn-default">Back </button> </a> &nbsp;&nbsp;&nbsp;-->

                                    <button class="btn btn-primary pull-left" type="submit" name="Save_new_zone_edited">Update Your Order/Request </button>

                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                    <?php   
                }
				

                function AddRegisterMarketStaff($MarketID)
                {
                    ?>
                    <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input type="hidden" name="MarketID" value="<?php echo $MarketID; ?>">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                
                                    <h3 class="panel-title">Register a new staff at <?php echo return_conference_name($MarketID); ?> Market </h3>
                                    
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <p>Please Fill the form below to Register a new Staff, All fields with a * must be filled.</p>
                                    <a href="?View_Conference_single=<?php echo  $conferenceID; ?>"> Back </a> 
                                </div>
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*First Name:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="fname" class="form-control" placeholder="First Name" required/>
                                                    </div>                                            
                                                    
                                                </div>
                                            </div>
                                            
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">*Last Name:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="lname" class="form-control" placeholder="Last Name" required/>
                                                    </div>                                            
                                                    
                                                </div>
                                            </div>
                                            
                                            
                                             <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Phone Number</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="phone" placeholder="Phone Number" />
                                                    </div>            
                                                   <!-- <span class="help-block">Password field sample</span> -->
                                                </div>
                                            </div>

                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Job Title</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Jobtitle" placeholder="Staff Job Title" />
                                                    </div>            
                                                   <!-- <span class="help-block">Password field sample</span> -->
                                                </div>
                                            </div>

                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">*Login Username</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="username" placeholder="Login Username" required/>
                                                    </div>            
                                                   <!-- <span class="help-block">Password field sample</span> -->
                                                </div>
                                            </div>

                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">*Confirm Password</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="password" class="form-control" name="conf_pass" placeholder="Confirm Password" required/>
                                                    </div>            
                                                   <!-- <span class="help-block">Password field sample</span> -->
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Middle Name</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Middle Name" name="mname">                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Gender</label>
                                                <div class="col-md-9">                                          
                                                    <select class="form-control select" name="gender" required>
                                                    <option value="">---Select Gender---</option>
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                        </select>
                                                    
                                                </div>
                                            </div>
                                          
                                          <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Email Address</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Email Address" name="email">                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>  

                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Staff Address</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Staff Address" name="Address">                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>  

                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Password</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="password" class="form-control" placeholder="Password" name="pass">                                            
                                                    </div>
                                                   
                                                </div>
                                            </div> 
                                            
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-default">Clear Form</button>                                    
                                    <button class="btn btn-primary pull-right" type="submit" name="Save_new_market_staff">Save</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                    <?php   
                }
                

				function Edit_Zone_Details($recordID)
				{
					require('connection.php');
					$query = mysql_query("SELECT * FROM zones_lists WHERE ID='$recordID'",$connect)or die(mysql_error());
					$fetch_data = mysql_fetch_array($query);
					?>
                    <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                             <input type="hidden" name="confID" value="<?php echo $fetch_data['ConferenceID']; ?>">
                             <input type="hidden" name="recordID" value="<?php echo $recordID; ?>">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                
                                    <h3 class="panel-title">Edit zone Details in <?php echo return_conference_name($fetch_data['ConferenceID']); ?> (<?php echo return_conference_abbrev($fetch_data['ConferenceID']); ?>) </h3>
                                    
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <p>Please Fill the form below to Register a new zone, All fields with a * must be filled.</p>
                                    <a href="?View_Conference_single=<?php echo  $fetch_data['ConferenceID']; ?>"> Back </a> 
                                </div>
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Zone Name:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="zone_name" class="form-control" placeholder="Zone Name" value="<?php echo $fetch_data['ZoneName']; ?>" required/>
                                                    </div>                                            
                                                    
                                                </div>
                                            </div>
                                            
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">*Zone Abbreviation:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="zone_abbrev" class="form-control" placeholder="Zone Abbreviation" required value="<?php echo $fetch_data['abbreviation']; ?>"/>
                                                    </div>                                            
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Zone Descriptions</label>
                                                <div class="col-md-9 col-xs-12">                                            
                                                    <textarea class="form-control" rows="5" name="zone_desc"><?php echo $fetch_data['Description']; ?></textarea>
                                                    <!-- <span class="help-block">Default textarea field</span>-->
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">                                        
                                                <label class="col-md-3 control-label">*Assistant Publishing Direcor</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="zone_publishing_director" placeholder="Assistant Publishing Director" value="<?php echo $fetch_data['Assistant_Publishing_Director']; ?>" required/>
                                                    </div>            
                                                   <!-- <span class="help-block">Password field sample</span> -->
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Phone Number</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Phone Number" name="phone_number" value="<?php echo $fetch_data['Phone_Number']; ?>">                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Email Number</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Email Address" name="email_address" value="<?php echo $fetch_data['Email_address']; ?>">                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-default">Clear Form</button>                                    
                                    <button class="btn btn-primary pull-right" type="submit" name="Save_new_zone_update">Update</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                    <?php	
				}
				
				function Delete_Evangelist($evang_ID,$zoneID)
				{
					
				}//end fucntion 
				
				function View_Evangelists_list($zoneID)
				{
					require('connection.php');
					$zone_query = mysql_query("SELECT * FROM zones_lists WHERE ID='$zoneID' ",$connect)or die(mysql_error());
					$zone_details = mysql_fetch_array($zone_query);
				?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Evangelists Registered In <?php echo $zone_details['ZoneName']; ?> Zone - <?php echo return_conference_name($zone_details['ConferenceID']); ?> (<?php echo return_conference_abbrev($zone_details['ConferenceID']) ?>) </h3>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="zone_Evangelists_lists.xlsx"><img src='img/icons/xls.png' width="24"/> Excel </a></li>
                                            <li><a href="#"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                            <li><a href="#"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                                    </div>                                    
                                    
                                </div>
                                <div class="panel-body">
                                <?php
								$sql = "SELECT * FROM evangelists_list WHERE zoneID='$zoneID' ";
								
								$query = mysql_query($sql,$connect)or die(mysql_error());
								
								Export_Evangelists_lists($sql,$zoneID);
								?>
                               <a href="?View_Conference_single=<?php echo $zone_details['ConferenceID']; ?>" data-toggle="tooltip" data-placement="bottom" title="Click to go back to zones lists"> <b> Back </b> </a> | <a href="?add_new_evangelist=<?php echo $zoneID; ?>" data-toggle="tooltip" data-placement="bottom" title="Click to Add / Register a new Evangelist"><b>Register New Evangelist </b> </a> | <a href="?view_zone_monthly_report=<?php echo $zoneID; ?>"  data-toggle="tooltip" data-placement="bottom" title="Click to View or  Add or Edit Evangelists Monthly Report"> <b> Evangelists Monthly Report </b> </a> 
          | <a href="?view_zone_summary_data=<?php echo $zoneID; ?>&confID=<?php echo $zone_details['ConferenceID']; ?>"  data-toggle="tooltip" data-placement="bottom" title="Click to View Evangelists Zone Summary With Their Graphs"> <b> Evangelists Zone Summary </b> </a>
                               <br><br>
                                
                                    <table id="customers" class="table table-striped">
                                        <thead>
                                            <tr>
                                            	<th> No </th>
                                                <th>Evangelist Name</th>
                                                <th>Grade</th>
                                                <th>Gender</th>
                                                <th>Phone </th>
                                                <th>Email</th>
                                                <th>Church</th>
                                                <th>District</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
										if(mysql_num_rows($query)==0)
										{
											?>
                                            <tr>
                                            <td colspan="9"> No Evangelists Registered in <?php echo $zone_details['ZoneName']; ?> Zone - <?php echo return_conference_name($zone_details['ConferenceID']); ?> (<?php echo return_conference_abbrev($zone_details['ConferenceID']) ?>) </td> </tr>
                                            </tr>
                                            <?php
										}	
										else
										{
											$num = 0;
											while($fetch_conferences_lists = mysql_fetch_array($query))
											{
												$num++;
										?>
                                            <tr>
                                            	<td> <?php echo $num; ?>. </td>
                                                <td> <?php echo $fetch_conferences_lists['First_Name']." ".$fetch_conferences_lists['Middle_Name']." ".$fetch_conferences_lists['Last_Name']; ?>  </td>
                                                <td> <?php echo return_grade_Name($fetch_conferences_lists['Grade']); ?></td>
                                                <td> <?php echo $fetch_conferences_lists['Gender']; ?> </td>
                                                <td> <?php echo $fetch_conferences_lists['Phone']; ?> </td>
                                                <td> <?php echo $fetch_conferences_lists['Email']; ?> </td>
                                                
                                                <td> <?php echo $fetch_conferences_lists['Region']; ?> </td>
                                                <td> <?php echo $fetch_conferences_lists['Districts']; ?> </td>
                                                <td>
                                                <div class="btn-group pull-right"> 
                                                	<a href="#" data-toggle="dropdown" > Action </a>
                                                		<ul class="dropdown-menu">
                                                			<li> <a href="?View_evangelists_details=<?php echo $fetch_conferences_lists['ID']; ?>"> View <?php echo $fetch_conferences_lists['First_Name']; ?>'s Details </a> </li>
                                                			<li> <a href="?edit_evangelist_single=<?php echo $fetch_conferences_lists['ID']; ?>&zoneID=<?php echo $zoneID; ?>"> Edit <?php echo $fetch_conferences_lists['First_Name']; ?>'s Details </a> </li>
                                                			<li> <a onClick="return DeleteConfirm('Evangelist - <?php echo $fetch_conferences_lists['First_Name']." ".$fetch_conferences_lists['Middle_Name']." ".$fetch_conferences_lists['Last_Name']; ?> ? ')" href="#"> Delete <?php echo $fetch_conferences_lists['First_Name']; ?> </a> </li>
                                                		</ul>
                                                 </div>
                                                 </td>
                                            </tr>
                                          <?php
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
				
				function View_Evangelists_Reports($zoneID,$year,$month)
				{
					
					require('connection.php');
					$zone_query = mysql_query("SELECT * FROM zones_lists WHERE ID='$zoneID' ",$connect)or die(mysql_error());
					$zone_details = mysql_fetch_array($zone_query);
					
					$array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
				?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Evangelists Monthly Report - <?php echo $zone_details['ZoneName']; ?> Zone - <?php echo return_conference_name($zone_details['ConferenceID']); ?> (<?php echo return_conference_abbrev($zone_details['ConferenceID']) ?>) </h3>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Report</button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="zone_evangelists_report.xlsx"><img src='img/icons/xls.png' width="24"/> Excel </a></li>
                                            <li><a href="#"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                            <li><a href="#"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                                    </div>                                    
                                    
                                </div>
                                <div class="panel-body">
                                <?php
								$sql = "SELECT * FROM evangelists_list WHERE zoneID='$zoneID' ";
								$query = mysql_query($sql,$connect)or die(mysql_error());
								//data-toggle="tooltip"
								Export_Zone_Report($zone_details['ConferenceID'],$sql,$zoneID,$month,$year);
								?>
                               <a href="?View_zone_single=<?php echo $zoneID; ?>" data-toggle="tooltip" data-placement="bottom" title="Click to View List of Evangelists "> <b> Evangelists Detail List </b> </a> <br><br>
                                
                                Showing Report for <?php echo $array_months[$month]; ?> , <?php echo $year; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                
                                <a href="#"  data-placement="bottom" title="Click to View Reports for Other Month / year" data-toggle="modal" data-target="#myModal"> <b> View Other Reports </b> </a> | <a href="#" data-toggle="modal" data-target="#myModal2" data-placement="bottom" title="Click to Add / Edit Evangelist Report"> <b> Add / Edit Zonal Report </b> </a>
                               
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
        <input type="hidden" name="zoneID" value="<?php echo $zoneID ?>" >
        <div class="col-md-6">
        										<div class="form-group">
                                                <label class="col-md-3 control-label">Month</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="view_evang_report_monthly_month" required>
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
                                                    <select class="form-control select" name="view_evang_report_monthly_year" required>
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


 <!-- Modal -->
<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Choose Report Month and Year to Create report</h4>
      </div>
      <div class="modal-body">
        <p>Please Select Month and Year for the report you want to Create .
        
        <div class="row">
        <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <input type="hidden" name="zoneID" value="<?php echo $zoneID ?>" >
        <div class="col-md-6">
        										<div class="form-group">
                                                <label class="col-md-3 control-label">Month</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="new_zone_report_month" required>
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
                                                    <select class="form-control select" name="new_zone_report_year" required>
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
                                                <th>Hours</th>
                                                <th><center>Books<br>Sold</center></th>
                                                <th><center>Magazine</center></th>
                                                <th> Value of <br> Sales </th>
                                                <th><center>Free<br>Literature</center></th>
                                                <th>V.O.P</th>
                                                <th><center>Attending <br>SS</center></th>
                                                <th><center>Back<br>Slinders</center></th>
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
                                            <td colspan="11"> No Evangelists Registered in <?php echo $zone_details['ZoneName']; ?> Zone - <?php echo return_conference_name($zone_details['ConferenceID']); ?> (<?php echo return_conference_abbrev($zone_details['ConferenceID']) ?>) </td> </tr>
                                            </tr>
                                            <?php
										}	
										else
										{
											$num = 0;
											$visited = 0;
											$magazine = 0;
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
												$evangID = $fetch_conferences_lists['ID'];
												$query_repoti = mysql_query("SELECT * FROM evangelists_monthly_report WHERE evangelistID='$evangID' AND year='$year' AND month='$month' ",$connect)or die(mysql_error());
												
												?>
                                            <tr>
                                            	<td> <?php echo $num; ?>. </td>
                                                <td> <?php echo $fetch_conferences_lists['First_Name']." ".$fetch_conferences_lists['Middle_Name']." ".$fetch_conferences_lists['Last_Name']; ?>  </td>
                                                <?php
												if(mysql_num_rows($query_repoti)==0)
												{
													?>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <?php
												}
												else
												{
													$fetch_results = mysql_fetch_array($query_repoti);
													
													$sum_hours = $sum_hours + $fetch_results['hours'];
													$sum_books_sold = $sum_books_sold + $fetch_results['books_sold'];
													$sum_value_sale = $sum_value_sale + $fetch_results['Value_sales'];
													$free_literature = $free_literature + $fetch_results['free_literature'];
													$vop = $vop + $fetch_results['v_o_p'];
													$attending_ss = $attending_ss + $fetch_results['people_attending_SS'];
													$back_slinders = $back_slinders + $fetch_results['sda_back_slinders'];
													$prayers = $prayers + $fetch_results['prayers_offered'];
													$bible_studies = $bible_studies + $fetch_results['Bibles_studies_given'];
													$baptism_classes = $baptism_classes + $fetch_results['people_joining_bapstism_classes'];
													$baptized = $baptized + $fetch_results['no_baptised'];
													
													$visited = $visited + $fetch_results['Waliotembelewa'];
													$magazine = $magazine + $fetch_results['Magazines'];
													?>
                                                <td align="center"> <?php echo number_format($fetch_results['hours']); ?></td>
                                                <td align="center"> <?php echo number_format($fetch_results['books_sold']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['Magazines']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['Value_sales']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['free_literature']); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format($fetch_results['v_o_p']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['people_attending_SS']); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format($fetch_results['sda_back_slinders']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['prayers_offered']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['Bibles_studies_given']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['people_joining_bapstism_classes']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['no_baptised']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['Waliotembelewa']); ?> </td>
                                                <?php
												}
												?>
                                                
                                                
                                            </tr>
                                          <?php
											}
										}
										?>
                                        <tr>
                                        <th colspan="2"><center> TOTAL </center> </th>
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
				
				function View_EvangelistSummary($evangID,$year)
				{
					require('connection.php');
					$query = mysql_query("SELECT * FROM evangelists_list WHERE ID='$evangID' ",$connect)or die(mysql_error());
					$fetch_evangelists = mysql_fetch_array($query);
					
					$array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
					
				?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Evangelist Summary - <?php echo $fetch_evangelists['First_Name']." ".$fetch_evangelists['Middle_Name']." ".$fetch_evangelists['Last_Name']; ?> - <?php echo ReturnZoneDetails($fetch_evangelists['zoneID'],'ZoneName'); ?> </h3>
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
								
								?>
                               <a href="?View_zone_single=<?php echo $fetch_evangelists['zoneID']; ?>" data-toggle="tooltip" data-placement="bottom" title="Click to go back "> <b> Back </b> </a> <br><br>
                                
                                Showing Summary for <?php echo $year; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                
                                <a href="#"  data-placement="bottom" title="Click to View Summary for Other year" data-toggle="modal" data-target="#myModal"> <b> View Other Year Summary </b> </a> 
                               
                                <br><br>
                                <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Choose Another Year</h4>
      </div>
      <div class="modal-body">
        <p>Please Select the Year for the summary you want to View .
        
        <div class="row">
        <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <input type="hidden" name="view_evang_summary_select" value="<?php echo $evangID; ?>" >
        <div class="col-md-6">
        										
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
                                                <th>Month</th>
                                                <th>Hours</th>
                                                <th><center>Books<br>Sold</center></th>
                                                <th><center>Magazine</center></th>
                                                <th> Value of <br> Sales </th>
                                                <th><center>Free<br>Literature</center></th>
                                                <th>V.O.P</th>
                                                <th><center>Attending <br>SS</center></th>
                                                <th><center>Back<br>Slinders</center></th>
                                                <th>Prayers</th>
                                                <th><center>Bible<br>Studies</center></th>
                                                <th><center>Baptisim<br>Classes</center></th> 
                                                <th> Baptized </th> 
                                                <th> Home<br>Visited </th> 
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        <tr>
												<td> November , <?php echo ($year-1); ?> </td>
                                        		<td align="center"> <?php echo number_format(EvangelistSummary($evangID,11,$year-1,'hours')); ?></td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,11,$year-1,'books_sold')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,11,$year,'Magazines')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,11,$year-1,'Value_sales')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,11,$year-1,'free_literature')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,11,$year-1,'v_o_p')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,11,$year-1,'people_attending_SS')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,11,$year-1,'sda_back_slinders')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,11,$year-1,'prayers_offered')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,11,$year-1,'Bibles_studies_given')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,11,$year-1,'people_joining_bapstism_classes')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,11,$year-1,'no_baptised')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,11,$year-1,'Waliotembelewa')); ?> </td>
                                               </tr>
                                               
                                               <tr>
                                                <td> December , <?php echo ($year-1); ?>  </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,12,$year-1,'hours')); ?></td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,12,$year-1,'books_sold')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,12,$year-1,'Magazines')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,12,$year-1,'Value_sales')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,12,$year-1,'free_literature')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,12,$year-1,'v_o_p')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,12,$year-1,'people_attending_SS')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,12,$year-1,'sda_back_slinders')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,12,$year-1,'prayers_offered')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,12,$year-1,'Bibles_studies_given')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,12,$year-1,'people_joining_bapstism_classes')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,12,$year-1,'no_baptised')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,12,$year-1,'Waliotembelewa')); ?> </td>
                                                
                                        	</tr>
                                        
                                        <?php
										$num = 0;
											$visited = EvangelistSummary($evangID,11,$year-1,'Waliotembelewa') + EvangelistSummary($evangID,12,$year-1,'Waliotembelewa');
											$magazine = EvangelistSummary($evangID,11,$year-1,'Magazines') + EvangelistSummary($evangID,12,$year-1,'Magazines');
											$sum_hours = EvangelistSummary($evangID,11,$year-1,'hours') + EvangelistSummary($evangID,12,$year-1,'hours');
											$sum_books_sold = EvangelistSummary($evangID,11,$year-1,'books_sold') + EvangelistSummary($evangID,12,$year-1,'books_sold');
											$sum_value_sale = EvangelistSummary($evangID,11,$year-1,'Value_sales') + EvangelistSummary($evangID,12,$year-1,'Value_sales');
											$free_literature = EvangelistSummary($evangID,11,$year-1,'free_literature') + EvangelistSummary($evangID,12,$year-1,'free_literature');
											$vop = EvangelistSummary($evangID,11,$year-1,'v_o_p') + EvangelistSummary($evangID,12,$year-1,'v_o_p');
											$attending_ss = EvangelistSummary($evangID,11,$year-1,'people_attending_SS') + EvangelistSummary($evangID,12,$year-1,'people_attending_SS');
											$back_slinders = EvangelistSummary($evangID,11,$year-1,'sda_back_slinders') + EvangelistSummary($evangID,12,$year-1,'sda_back_slinders');
											$prayers = EvangelistSummary($evangID,11,$year-1,'prayers_offered') + EvangelistSummary($evangID,12,$year-1,'prayers_offered');
											$bible_studies = EvangelistSummary($evangID,11,$year-1,'Bibles_studies_given') + EvangelistSummary($evangID,12,$year-1,'Bibles_studies_given');
											$baptism_classes = EvangelistSummary($evangID,11,$year-1,'people_joining_bapstism_classes') + EvangelistSummary($evangID,12,$year-1,'people_joining_bapstism_classes');
											$baptized = EvangelistSummary($evangID,11,$year-1,'no_baptised') + EvangelistSummary($evangID,12,$year-1,'no_baptised');
											
										for($i=1;$i<11;$i++)
										{
											
												?>
                                            <tr>
                                            	
                                                <td> <?php echo $array_months[$i].' , '.$year; ?>  </td>
                                                <?php
													
													$sum_hours = $sum_hours + EvangelistSummary($evangID,$i,$year,'hours');
													$sum_books_sold = $sum_books_sold + EvangelistSummary($evangID,$i,$year,'books_sold');
													$sum_value_sale = $sum_value_sale + EvangelistSummary($evangID,$i,$year,'Value_sales');
													$free_literature = $free_literature + EvangelistSummary($evangID,$i,$year,'free_literature');
													$vop = $vop + EvangelistSummary($evangID,$i,$year,'v_o_p');
													$attending_ss = $attending_ss + EvangelistSummary($evangID,$i,$year,'people_attending_SS');
													$back_slinders = $back_slinders + EvangelistSummary($evangID,$i,$year,'sda_back_slinders');
													$prayers = $prayers + EvangelistSummary($evangID,$i,$year,'prayers_offered');
													$bible_studies = $bible_studies + EvangelistSummary($evangID,$i,$year,'Bibles_studies_given');
													$baptism_classes = $baptism_classes + EvangelistSummary($evangID,$i,$year,'people_joining_bapstism_classes');
													$baptized = $baptized + EvangelistSummary($evangID,$i,$year,'no_baptised');
													
													$visited = $visited + EvangelistSummary($evangID,$i,$year,'Waliotembelewa');
													$magazine = $magazine + EvangelistSummary($evangID,$i,$year,'Magazines');
													?>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,$i,$year,'hours')); ?></td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,$i,$year,'books_sold')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,$i,$year,'Magazines')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,$i,$year,'Value_sales')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,$i,$year,'free_literature')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,$i,$year,'v_o_p')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,$i,$year,'people_attending_SS')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,$i,$year,'sda_back_slinders')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,$i,$year,'prayers_offered')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,$i,$year,'Bibles_studies_given')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,$i,$year,'people_joining_bapstism_classes')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,$i,$year,'no_baptised')); ?> </td>
                                                <td align="center"> <?php echo number_format(EvangelistSummary($evangID,$i,$year,'Waliotembelewa')); ?> </td>
                                                <?php
												
												?>
                                                
                                                
                                            </tr>
                                          <?php
											
										}//end for loop
										?>
                                        <tr>
                                        <th><center> TOTAL </center> </th>
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
                                    
                                    <br>
                                    <i> Click on Column Heading to View Graph of a Particular Item </i>
                                                                     
                                    
                                </div>
                            </div>
                            <!-- END DATATABLE EXPORT -->                            
                            
                            
                        </div>
                    </div>

                </div>         
                <!-- END PAGE CONTENT WRAPPER -->
                <?php
				}//end function Conferences Lists
				
				
				function View_ConferenceSummary($confID,$year)
				{
					$array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
					
				?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Conference Evangelists Summary - <?php echo return_conference_name($confID); ?> (<?php echo return_conference_abbrev($confID) ?>) </h3>
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
								
								?>
                               <a href="?View_Conference_single=<?php echo $confID; ?>" data-toggle="tooltip" data-placement="bottom" title="Click to go back "> <b> Back </b> </a> <br><br>
                                
                                Showing Summary for <?php echo $year; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                
                                <a href="#"  data-placement="bottom" title="Click to View Summary for Other year" data-toggle="modal" data-target="#myModal"> <b> View Other Year Summary </b> </a> 
                               
                                <br><br>
                                <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Choose Another Year</h4>
      </div>
      <div class="modal-body">
        <p>Please Select the Year for the summary you want to View .
        
        <div class="row">
        <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <input type="hidden" name="view_zones_summary_select" value="<?php echo $confID ?>" >
        <div class="col-md-6">
        										
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
                                                <th>Month</th>
                                                <th>Hours</th>
                                                <th><center>Books<br>Sold</center></th>
                                                <th><center>Magazine</center></th>
                                                <th> Value of <br> Sales </th>
                                                <th><center>Free<br>Literature</center></th>
                                                <th>V.O.P</th>
                                                <th><center>Attending <br>SS</center></th>
                                                <th><center>Back<br>Slinders</center></th>
                                                <th>Prayers</th>
                                                <th><center>Bible<br>Studies</center></th>
                                                <th><center>Baptisim<br>Classes</center></th> 
                                                <th> Baptized </th> 
                                                <th> Home<br>Visited </th> 
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        <tr>
<td> November , <?php echo ($year-1); ?> </td>
                                        		<td align="center"> <?php echo number_format(ConferenceSummary($confID,11,$year-1,'hours')); ?></td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,11,$year-1,'books_sold')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,11,$year,'Magazines')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,11,$year-1,'Value_sales')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,11,$year-1,'free_literature')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,11,$year-1,'v_o_p')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,11,$year-1,'people_attending_SS')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,11,$year-1,'sda_back_slinders')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,11,$year-1,'prayers_offered')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,11,$year-1,'Bibles_studies_given')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,11,$year-1,'people_joining_bapstism_classes')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,11,$year-1,'no_baptised')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,11,$year-1,'Waliotembelewa')); ?> </td>
                                               </tr>
                                               
                                               <tr>
                                                <td> December , <?php echo ($year-1); ?>  </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,12,$year-1,'hours')); ?></td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,12,$year-1,'books_sold')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,12,$year-1,'Magazines')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,12,$year-1,'Value_sales')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,12,$year-1,'free_literature')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,12,$year-1,'v_o_p')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,12,$year-1,'people_attending_SS')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,12,$year-1,'sda_back_slinders')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,12,$year-1,'prayers_offered')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,12,$year-1,'Bibles_studies_given')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,12,$year-1,'people_joining_bapstism_classes')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,12,$year-1,'no_baptised')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,12,$year-1,'Waliotembelewa')); ?> </td>
                                                
                                        	</tr>
                                        
                                        <?php
										$num = 0;
											$visited = ConferenceSummary($confID,11,$year-1,'Waliotembelewa') + ConferenceSummary($confID,12,$year-1,'Waliotembelewa');
											$magazine = ConferenceSummary($confID,11,$year-1,'Magazines') + ConferenceSummary($confID,12,$year-1,'Magazines');
											$sum_hours = ConferenceSummary($confID,11,$year-1,'hours') + ConferenceSummary($confID,12,$year-1,'hours');
											$sum_books_sold = ConferenceSummary($confID,11,$year-1,'books_sold') + ConferenceSummary($confID,12,$year-1,'books_sold');
											$sum_value_sale = ConferenceSummary($confID,11,$year-1,'Value_sales')+ ConferenceSummary($confID,12,$year-1,'Value_sales');
											$free_literature = ConferenceSummary($confID,11,$year-1,'free_literature') + ConferenceSummary($confID,12,$year-1,'free_literature');
											$vop = ConferenceSummary($confID,11,$year-1,'v_o_p') + ConferenceSummary($confID,12,$year-1,'v_o_p');
											$attending_ss = ConferenceSummary($confID,11,$year-1,'people_attending_SS') + ConferenceSummary($confID,12,$year-1,'people_attending_SS');
											$back_slinders = ConferenceSummary($confID,11,$year-1,'sda_back_slinders') + ConferenceSummary($confID,12,$year-1,'sda_back_slinders');
											$prayers = ConferenceSummary($confID,11,$year-1,'prayers_offered') + ConferenceSummary($confID,12,$year-1,'prayers_offered');
											$bible_studies = ConferenceSummary($confID,11,$year-1,'Bibles_studies_given') + ConferenceSummary($confID,12,$year-1,'Bibles_studies_given');
											$baptism_classes = ConferenceSummary($confID,11,$year-1,'people_joining_bapstism_classes') + ConferenceSummary($confID,12,$year-1,'people_joining_bapstism_classes');
											$baptized = ConferenceSummary($confID,11,$year-1,'no_baptised') + ConferenceSummary($confID,12,$year-1,'no_baptised');
											
										for($i=1;$i<11;$i++)
										{
											
												?>
                                            <tr>
                                            	
                                                <td> <?php echo $array_months[$i].', '.$year; ?>  </td>
                                                <?php 
													
													$sum_hours = $sum_hours + ConferenceSummary($confID,$i,$year,'hours');
													$sum_books_sold = $sum_books_sold + ConferenceSummary($confID,$i,$year,'books_sold');
													$sum_value_sale = $sum_value_sale + ConferenceSummary($confID,$i,$year,'Value_sales');
													$free_literature = $free_literature + ConferenceSummary($confID,$i,$year,'free_literature');
													$vop = $vop + ConferenceSummary($confID,$i,$year,'v_o_p');
													$attending_ss = $attending_ss + ConferenceSummary($confID,$i,$year,'people_attending_SS');
													$back_slinders = $back_slinders + ConferenceSummary($confID,$i,$year,'sda_back_slinders');
													$prayers = $prayers + ConferenceSummary($confID,$i,$year,'prayers_offered');
													$bible_studies = $bible_studies + ConferenceSummary($confID,$i,$year,'Bibles_studies_given');
													$baptism_classes = $baptism_classes + ConferenceSummary($confID,$i,$year,'people_joining_bapstism_classes');
													$baptized = $baptized + ConferenceSummary($confID,$i,$year,'no_baptised');
													
													$visited = $visited + ConferenceSummary($confID,$i,$year,'Waliotembelewa');
													$magazine = $magazine + ConferenceSummary($confID,$i,$year,'Magazines');
													?>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,$i,$year,'hours')); ?></td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,$i,$year,'books_sold')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,$i,$year,'Magazines')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,$i,$year,'Value_sales')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,$i,$year,'free_literature')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,$i,$year,'v_o_p')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,$i,$year,'people_attending_SS')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,$i,$year,'sda_back_slinders')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,$i,$year,'prayers_offered')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,$i,$year,'Bibles_studies_given')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,$i,$year,'people_joining_bapstism_classes')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,$i,$year,'no_baptised')); ?> </td>
                                                <td align="center"> <?php echo number_format(ConferenceSummary($confID,$i,$year,'Waliotembelewa')); ?> </td>
                                                <?php
												
												?>
                                                
                                                
                                            </tr>
                                          <?php
											
										}//end for loop
										?>
                                        <tr>
                                        <th><center> TOTAL </center> </th>
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
                                    
                                    <br>
                                    <i> Click on Column Heading to View Graph of a Particular Item </i>
                                                                     
                                    
                                </div>
                            </div>
                            <!-- END DATATABLE EXPORT -->                            
                            
                            
                        </div>
                    </div>

                </div>         
                <!-- END PAGE CONTENT WRAPPER -->
                <?php
				}//end function Conferences Lists
				
				function View_UnionSummary($confID,$year)
				{
					$array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
					
				?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> NTUC Evangelists Summary  </h3>
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
								
								?>
                               <a href="?Cancel_back_go=<?php echo $confID; ?>" data-toggle="tooltip" data-placement="bottom" title="Click to go back "> <b> Back </b> </a> <br><br>
                                
                                Showing Summary for <?php echo $year; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                
                                <a href="#"  data-placement="bottom" title="Click to View Summary for Other year" data-toggle="modal" data-target="#myModal"> <b> View Other Year Summary </b> </a> 
                               
                                <br><br>
                                <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Choose Another Year</h4>
      </div>
      <div class="modal-body">
        <p>Please Select the Year for the summary you want to View .
        
        <div class="row">
        <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <input type="hidden" name="view_union_summary_select" value="<?php echo $confID ?>" >
        <div class="col-md-6">
        										
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
                                                <th>Month</th>
                                                <th>Hours</th>
                                                <th><center>Books<br>Sold</center></th>
                                                <th><center>Magazine</center></th>
                                                <th> Value of <br> Sales </th>
                                                <th><center>Free<br>Literature</center></th>
                                                <th>V.O.P</th>
                                                <th><center>Attending <br>SS</center></th>
                                                <th><center>Back<br>Slinders</center></th>
                                                <th>Prayers</th>
                                                <th><center>Bible<br>Studies</center></th>
                                                <th><center>Baptisim<br>Classes</center></th> 
                                                <th> Baptized </th> 
                                                <th> Home<br>Visited </th> 
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                        		<td> November <?php echo ($year-1); ?> </td>
                                        		<td align="center"> <?php echo number_format(UnionSummary($confID,11,$year-1,'hours')); ?></td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,11,$year-1,'books_sold')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,11,$year,'Magazines')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,11,$year-1,'Value_sales')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,11,$year-1,'free_literature')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,11,$year-1,'v_o_p')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,11,$year-1,'people_attending_SS')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,11,$year-1,'sda_back_slinders')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,11,$year-1,'prayers_offered')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,11,$year-1,'Bibles_studies_given')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,11,$year-1,'people_joining_bapstism_classes')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,11,$year-1,'no_baptised')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,11,$year-1,'Waliotembelewa')); ?> </td>
                                               </tr>
                                               
                                               <tr>
                                                <td> December <?php echo ($year-1); ?>  </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,12,$year-1,'hours')); ?></td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,12,$year-1,'books_sold')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,12,$year-1,'Magazines')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,12,$year-1,'Value_sales')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,12,$year-1,'free_literature')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,12,$year-1,'v_o_p')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,12,$year-1,'people_attending_SS')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,12,$year-1,'sda_back_slinders')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,12,$year-1,'prayers_offered')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,12,$year-1,'Bibles_studies_given')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,12,$year-1,'people_joining_bapstism_classes')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,12,$year-1,'no_baptised')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,12,$year-1,'Waliotembelewa')); ?> </td>
                                                
                                        	</tr>
                                        <?php
										$num = 0;
											$visited = UnionSummary($confID,11,$year-1,'Waliotembelewa') + UnionSummary($confID,12,$year-1,'Waliotembelewa');
											$magazine = UnionSummary($confID,11,$year-1,'Magazines') + UnionSummary($confID,12,$year-1,'Magazines');
											$sum_hours = UnionSummary($confID,11,$year-1,'hours') + UnionSummary($confID,12,$year-1,'hours');
											$sum_books_sold = UnionSummary($confID,11,$year-1,'books_sold') + UnionSummary($confID,12,$year-1,'books_sold');
											$sum_value_sale = UnionSummary($confID,11,$year-1,'Value_sales') + UnionSummary($confID,12,$year-1,'Value_sales');
											$free_literature = UnionSummary($confID,11,$year-1,'free_literature') + UnionSummary($confID,12,$year-1,'free_literature');
											$vop = UnionSummary($confID,11,$year-1,'v_o_p') + UnionSummary($confID,12,$year-1,'v_o_p');
											$attending_ss = UnionSummary($confID,11,$year-1,'people_attending_SS') + UnionSummary($confID,12,$year-1,'people_attending_SS');
											$back_slinders = UnionSummary($confID,11,$year-1,'sda_back_slinders') + UnionSummary($confID,12,$year-1,'sda_back_slinders');
											$prayers = UnionSummary($confID,11,$year-1,'prayers_offered') + UnionSummary($confID,12,$year-1,'prayers_offered');
											$bible_studies = UnionSummary($confID,11,$year-1,'Bibles_studies_given') + UnionSummary($confID,12,$year-1,'Bibles_studies_given');
											$baptism_classes = UnionSummary($confID,11,$year-1,'people_joining_bapstism_classes') + UnionSummary($confID,12,$year-1,'people_joining_bapstism_classes');
											$baptized = UnionSummary($confID,11,$year-1,'no_baptised') + UnionSummary($confID,12,$year-1,'no_baptised');
											
										for($i=1;$i<11;$i++)
										{
											
												?>
                                            <tr>
                                            	
                                                <td> <?php echo $array_months[$i].' , '.$year; ?>  </td>
                                                <?php
													
													$sum_hours = $sum_hours + UnionSummary($confID,$i,$year,'hours');
													$sum_books_sold = $sum_books_sold + UnionSummary($confID,$i,$year,'books_sold');
													$sum_value_sale = $sum_value_sale + UnionSummary($confID,$i,$year,'Value_sales');
													$free_literature = $free_literature + UnionSummary($confID,$i,$year,'free_literature');
													$vop = $vop + UnionSummary($confID,$i,$year,'v_o_p');
													$attending_ss = $attending_ss + UnionSummary($confID,$i,$year,'people_attending_SS');
													$back_slinders = $back_slinders + UnionSummary($confID,$i,$year,'sda_back_slinders');
													$prayers = $prayers + UnionSummary($confID,$i,$year,'prayers_offered');
													$bible_studies = $bible_studies + UnionSummary($confID,$i,$year,'Bibles_studies_given');
													$baptism_classes = $baptism_classes + UnionSummary($confID,$i,$year,'people_joining_bapstism_classes');
													$baptized = $baptized + UnionSummary($confID,$i,$year,'no_baptised');
													
													$visited = $visited + UnionSummary($confID,$i,$year,'Waliotembelewa');
													$magazine = $magazine + UnionSummary($confID,$i,$year,'Magazines');
													?>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,$i,$year,'hours')); ?></td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,$i,$year,'books_sold')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,$i,$year,'Magazines')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,$i,$year,'Value_sales')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,$i,$year,'free_literature')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,$i,$year,'v_o_p')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,$i,$year,'people_attending_SS')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,$i,$year,'sda_back_slinders')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,$i,$year,'prayers_offered')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,$i,$year,'Bibles_studies_given')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,$i,$year,'people_joining_bapstism_classes')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,$i,$year,'no_baptised')); ?> </td>
                                                <td align="center"> <?php echo number_format(UnionSummary($confID,$i,$year,'Waliotembelewa')); ?> </td>
                                                <?php
												
												?>
                                                
                                                
                                            </tr>
                                          <?php
											
										}//end for loop
										?>
                                        <tr>
                                        <th><center> TOTAL </center> </th>
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
                                    
                                    <br>
                                    <i> Click on Column Heading to View Graph of a Particular Item </i>
                                                                     
                                    
                                </div>
                            </div>
                            <!-- END DATATABLE EXPORT -->                            
                            
                            
                        </div>
                    </div>

                </div>         
                <!-- END PAGE CONTENT WRAPPER -->
                <?php
				}//end function Conferences Lists
				
				
				function View_ZoneSummary($confID,$zoneID,$year)
				{
					$array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
					
				?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Zone Evangelists Summary -<?php echo ReturnZoneDetails($zoneID,'ZoneName'); ?> -<?php echo return_conference_name($confID); ?> (<?php echo return_conference_abbrev($confID) ?>) </h3>
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
								
								?>
                               <a href="?View_zone_single=<?php echo $zoneID; ?>" data-toggle="tooltip" data-placement="bottom" title="Click to go back "> <b> Back </b> </a> <br><br>
                                
                                Showing Summary for <?php echo $year; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                
                                <a href="#"  data-placement="bottom" title="Click to View Summary for Other year" data-toggle="modal" data-target="#myModal"> <b> View Other Year Summary </b> </a> 
                               
                                <br><br>
                                <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Choose Another Year</h4>
      </div>
      <div class="modal-body">
        <p>Please Select the Year for the summary you want to View .
        
        <div class="row">
        <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <input type="hidden" name="view_single_zones_summary_select" value="<?php echo $zoneID ?>" >
        <input type="hidden" name="confID" value="<?php echo $confID ?>" >
        <div class="col-md-6">
        										
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
                                                <th>Month</th>
                                                <th>Hours</th>
                                                <th><center>Books<br>Sold</center></th>
                                                <th><center>Magazine</center></th>
                                                <th> Value of <br> Sales </th>
                                                <th><center>Free<br>Literature</center></th>
                                                <th>V.O.P</th>
                                                <th><center>Attending <br>SS</center></th>
                                                <th><center>Back<br>Slinders</center></th>
                                                <th>Prayers</th>
                                                <th><center>Bible<br>Studies</center></th>
                                                <th><center>Baptisim<br>Classes</center></th> 
                                                <th> Baptized </th> 
                                                <th> Home<br>Visited </th> 
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        <tr>
<td> November , <?php echo ($year-1); ?> </td>
                                        		<td align="center"> <?php echo number_format(ZoneSummary($zoneID,11,$year-1,'hours')); ?></td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,11,$year-1,'books_sold')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,11,$year,'Magazines')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,11,$year-1,'Value_sales')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,11,$year-1,'free_literature')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,11,$year-1,'v_o_p')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,11,$year-1,'people_attending_SS')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,11,$year-1,'sda_back_slinders')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,11,$year-1,'prayers_offered')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,11,$year-1,'Bibles_studies_given')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,11,$year-1,'people_joining_bapstism_classes')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,11,$year-1,'no_baptised')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,11,$year-1,'Waliotembelewa')); ?> </td>
                                               </tr>
                                               
                                               <tr>
                                                <td> December , <?php echo ($year-1); ?>  </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,12,$year-1,'hours')); ?></td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,12,$year-1,'books_sold')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,12,$year-1,'Magazines')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,12,$year-1,'Value_sales')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,12,$year-1,'free_literature')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,12,$year-1,'v_o_p')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,12,$year-1,'people_attending_SS')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,12,$year-1,'sda_back_slinders')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,12,$year-1,'prayers_offered')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,12,$year-1,'Bibles_studies_given')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,12,$year-1,'people_joining_bapstism_classes')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,12,$year-1,'no_baptised')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,12,$year-1,'Waliotembelewa')); ?> </td>
                                                
                                        	</tr>
                                        
                                        <?php
										$num = 0;
											$visited = ZoneSummary($zoneID,11,$year-1,'Waliotembelewa') + ZoneSummary($zoneID,12,$year-1,'Waliotembelewa');
											$magazine = ZoneSummary($zoneID,11,$year-1,'Magazines') + ZoneSummary($zoneID,12,$year-1,'Magazines');
											$sum_hours = ZoneSummary($zoneID,11,$year-1,'hours') + ZoneSummary($zoneID,12,$year-1,'hours');
											$sum_books_sold = ZoneSummary($zoneID,11,$year-1,'books_sold') + ZoneSummary($zoneID,12,$year-1,'books_sold');
											$sum_value_sale = ZoneSummary($zoneID,11,$year-1,'Value_sales') + ZoneSummary($zoneID,12,$year-1,'Value_sales');
											$free_literature = ZoneSummary($zoneID,11,$year-1,'free_literature') + ZoneSummary($zoneID,12,$year-1,'free_literature');
											$vop = ZoneSummary($zoneID,11,$year-1,'v_o_p') + ZoneSummary($zoneID,12,$year-1,'v_o_p');
											$attending_ss = ZoneSummary($zoneID,11,$year-1,'people_attending_SS') + ZoneSummary($zoneID,12,$year-1,'people_attending_SS');
											$back_slinders = ZoneSummary($zoneID,11,$year-1,'sda_back_slinders') + ZoneSummary($zoneID,12,$year-1,'sda_back_slinders');
											$prayers = ZoneSummary($zoneID,11,$year-1,'prayers_offered') + ZoneSummary($zoneID,12,$year-1,'prayers_offered');
											$bible_studies = ZoneSummary($zoneID,11,$year-1,'Bibles_studies_given') + ZoneSummary($zoneID,12,$year-1,'Bibles_studies_given');
											$baptism_classes = ZoneSummary($zoneID,11,$year-1,'people_joining_bapstism_classes') + ZoneSummary($zoneID,12,$year-1,'people_joining_bapstism_classes');
											$baptized = ZoneSummary($zoneID,11,$year-1,'no_baptised') + ZoneSummary($zoneID,12,$year-1,'no_baptised');
											
										for($i=1;$i<11;$i++)
										{
											
												?>
                                            <tr>
                                            	
                                                <td> <?php echo $array_months[$i].' , '.$year; ?>  </td>
                                                <?php
													
													$sum_hours = $sum_hours + ZoneSummary($zoneID,$i,$year,'hours');
													$sum_books_sold = $sum_books_sold + ZoneSummary($zoneID,$i,$year,'books_sold');
													$sum_value_sale = $sum_value_sale + ZoneSummary($zoneID,$i,$year,'Value_sales');
													$free_literature = $free_literature + ZoneSummary($zoneID,$i,$year,'free_literature');
													$vop = $vop + ZoneSummary($zoneID,$i,$year,'v_o_p');
													$attending_ss = $attending_ss + ZoneSummary($zoneID,$i,$year,'people_attending_SS');
													$back_slinders = $back_slinders + ZoneSummary($zoneID,$i,$year,'sda_back_slinders');
													$prayers = $prayers + ZoneSummary($zoneID,$i,$year,'prayers_offered');
													$bible_studies = $bible_studies + ZoneSummary($zoneID,$i,$year,'Bibles_studies_given');
													$baptism_classes = $baptism_classes + ZoneSummary($zoneID,$i,$year,'people_joining_bapstism_classes');
													$baptized = $baptized + ZoneSummary($zoneID,$i,$year,'no_baptised');
													
													$visited = $visited + ZoneSummary($zoneID,$i,$year,'Waliotembelewa');
													$magazine = $magazine + ZoneSummary($zoneID,$i,$year,'Magazines');
													?>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,$i,$year,'hours')); ?></td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,$i,$year,'books_sold')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,$i,$year,'Magazines')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,$i,$year,'Value_sales')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,$i,$year,'free_literature')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,$i,$year,'v_o_p')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,$i,$year,'people_attending_SS')); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,$i,$year,'sda_back_slinders')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,$i,$year,'prayers_offered')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,$i,$year,'Bibles_studies_given')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,$i,$year,'people_joining_bapstism_classes')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,$i,$year,'no_baptised')); ?> </td>
                                                <td align="center"> <?php echo number_format(ZoneSummary($zoneID,$i,$year,'Waliotembelewa')); ?> </td>
                                                <?php
												
												?>
                                                
                                                
                                            </tr>
                                          <?php
											
										}//end for loop
										?>
                                        <tr>
                                        <th><center> TOTAL </center> </th>
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
                                    
                                    <br>
                                    <i> Click on Column Heading to View Graph of a Particular Item </i>
                                                                     
                                    
                                </div>
                            </div>
                            <!-- END DATATABLE EXPORT -->                            
                            
                            
                        </div>
                    </div>

                </div>         
                <!-- END PAGE CONTENT WRAPPER -->
                <?php
				}//end function Conferences Lists
				
				
				function New_Edit_Evangelists_Reports($marketID,$initalID,$pageNum)
				{
					$num_records_per_page = 15;
			
					if(empty($pageNum))
					{
						$page = 1;
					}
					else
					{
						$page = $pageNum;	
					}
			
					$start_from = ($page-1)*$num_records_per_page;
					
					require('connection.php');
					$queryreportdesc = mysql_query("SELECT * FROM product_prices_dates WHERE ID='$initalID' ",$connect) or die(mysql_error());
                    $fetch_reportDesc = mysql_fetch_array($queryreportdesc);
					
					$array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
				?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Adding /Editing Product Prices - <?php echo return_conference_name($marketID); ?> Market </h3>
                                                                    
                                    
                                </div>
                                <div class="panel-body">
                                <?php
								
								
								
								$query = mysql_query("SELECT * FROM products LIMIT $start_from,$num_records_per_page  ",$connect)or die(mysql_error());
								
								$query_all = mysql_query("SELECT * FROM products ",$connect)or die(mysql_error());
								$total_evangelists_number = mysql_num_rows($query_all);
								//data-toggle="tooltip"
								?>
                               <a href="?BackView_Report=<?php echo $marketID; ?>&reportID=<?php echo $initalID; ?>" data-toggle="tooltip" data-placement="bottom" title="Click to View the Report "> <b> Back to Viewing Report </b> </a> <br><br>
                                
                                 Product Price(s) Report for week dated <b><?php echo Date_formating($fetch_reportDesc['Startdate']); ?></b> to <b> <?php echo Date_formating($fetch_reportDesc['EndDate']); ?> </b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                <?php
								$database_columns = array("minimum_value","maximum_value","steps","challenges","feedback");
								
							$database_columns_desc = array("minimum_value"=>"Product Minimum Price","maximum_value"=>"Product Maximum Price","steps"=>"Steps Taken/hatua zilizochukuliwa","challenges"=>"Challenges Encountered/Changamoto","feedback"=>"Feedbacks/ Maoni");	
								
								$database_columns_box_sizes = array("minimum_value"=>"10","maximum_value"=>"10","steps"=>"35","challenges"=>"35","feedback"=>"35");

                                $database_columns_data_types = array("minimum_value"=>"number","maximum_value"=>"number","steps"=>"text","challenges"=>"text","feedback"=>"text");
								
								?>
                               
                                <br><br>
                                
                               <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                               <input type="hidden" name="MarketID" value="<?php echo $marketID; ?>">
                               <input type="hidden" name="initialID" value="<?php echo $initalID; ?>">
                               
                               <input type="hidden" name="pageNum" value="<?php echo $pageNum; ?>">
                               
                               
                                    <table id="customers" class="table table-striped">
                                        <thead>
                                            <tr>
                                            	<th> No </th>
                                                <th>Product Name</th>
                                                <th align="center">Minimum Price</th>
                                                <th><center>Maximum Price</center></th>
                                                <th> Steps Taken / Hatua Zilizochukuliwa </th>
                                                <th> Challenges / Changamoto </th>
                                                <th> Feedback / Maoni </th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
										if(mysql_num_rows($query)==0)
										{
											?>
                                            <tr>
                                            <td colspan="11"> No Evangelists Registered in <?php echo $zone_details['ProductName']; ?> Zone - <?php echo return_conference_name($zone_details['ConferenceID']); ?> (<?php echo return_conference_abbrev($zone_details['ConferenceID']) ?>) </td> </tr>
                                            </tr>
                                            <?php
										}	
										else
										{
											$num = $start_from;
											while($fetch_conferences_lists = mysql_fetch_array($query))
											{
												$num++;
												$evangID = $fetch_conferences_lists['ProductID'];
												$query_repoti = mysql_query("SELECT * FROM product_prices_actual WHERE PriceID='$initalID' AND ProductID='$evangID' ",$connect)or die(mysql_error());
												
													$fetch_existing = mysql_fetch_array($query_repoti);	
												
												?>
                                            <tr>
                                            	<td> <?php echo $num; ?>. </td>
                                                <td> <?php echo $fetch_conferences_lists['ProductName']; ?>  </td>
                                                <?php
                                                foreach($database_columns as $get)
												{
													if($fetch_existing[$get]!='')
													{
                                                        if($database_columns_data_types[$get]=='number')
														$amount_disp = number_format($fetch_existing[$get]);
                                                    else
                                                        $amount_disp = $fetch_existing[$get];
													}
													else
													{
														$amount_disp = "";	
													}
													?>
                                                    <td align="center"> <input type="text" name="<?php echo $get."_".$evangID; ?>" value="<?php echo $amount_disp; ?>" size=<?php echo $database_columns_box_sizes[$get]; ?> data-toggle="tooltip" data-placement="bottom" title="<?php echo $database_columns_desc[$get]; ?>" > </td>
                                                    <?php
												}//end foreach
												
												?>
                                                
                                            </tr>
                                          <?php
											}
										}
										?>
                                        </tbody>
                                    </table>      
                                    <?php 
                                    $total_pages = ceil($total_evangelists_number/$num_records_per_page);
				?>
                <ul class="pagination">
                <?php
				for($i=1;$i<=$total_pages;$i++)
				{
					if($i==$page)
					{
						?>
						<li class="active"> <a href="#"> <?php echo $page." "; ?> </a> </li>	
                        <?php
					}
					else
					{
						?>
                        <li> <a href="?new_zone_report_month_page=<?php echo $i; ?>&MarketID=<?php echo $marketID; ?>&initialID=<?php echo $initalID; ?>"> <?php echo $i; ?> </a> </li>
                        <?php
					}
				}
									?>
					</ul>                             
                                    <button class="btn btn-primary pull-left" type="submit" name="save_monthly_report">Save Price Report</button>
                                    </form>
                                </div>
                            </div>
                            <!-- END DATATABLE EXPORT -->                            
                            
                            
                        </div>
                    </div>

                </div>         
                <!-- END PAGE CONTENT WRAPPER -->
                <?php
				}//end function Conferences Lists
				
				function New_Edit_Evangelists_Reports_22($zoneID,$year,$month,$confID,$pageNum)
				{
					$num_records_per_page = 30;
					
					if(empty($pageNum))
					{
						$page = 1;
					}
					else
					{
						$page = $pageNum;	
					}
			
					$start_from = ($page-1)*$num_records_per_page;
					
					require('connection.php');
					$zone_query = mysql_query("SELECT * FROM zones_lists WHERE ID='$zoneID' ",$connect)or die('Could not get Zone details because '.mysql_error());
					$zone_details = mysql_fetch_array($zone_query);
					
					$array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
				?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Adding /Editing Evangelists Monthly Report - <?php echo $zone_details['ZoneName']; ?> Zone - <?php echo return_conference_name($zone_details['ConferenceID']); ?> (<?php echo return_conference_abbrev($zone_details['ConferenceID']) ?>) </h3>
                                                                    
                                    
                                </div>
                                <div class="panel-body">
                                <?php
								
								//echo "SELECT * FROM evangelists_list WHERE zoneID='$zoneID' LIMIT $start_from,$num_records_per_page  ";
								
								$query = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID' LIMIT $start_from,$num_records_per_page  ",$connect)or die('Could not Paginate becasue '.mysql_error());
								
								$query_all = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID' ",$connect)or die(mysql_error());
								$total_evangelists_number = mysql_num_rows($query_all);
								//data-toggle="tooltip"
								?>
                               <a href="?view_conf_evang_report_month=<?php echo $month; ?>&confID=<?php echo $confID; ?>&view_conf_evang_report_year=<?php echo $year; ?>" data-toggle="tooltip" data-placement="bottom" title="Click to View List of Evangelists "> <b> Back to Viewing Report </b> </a> <br><br>
                                
                                 <?php echo $array_months[$month]; ?> , <?php echo $year; ?> Report &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                <?php
								$database_columns = array("hours","books_sold","Magazines","Value_sales","free_literature","v_o_p","people_attending_SS","sda_back_slinders","prayers_offered","Bibles_studies_given","people_joining_bapstism_classes","no_baptised","Waliotembelewa");
								
							$database_columns_desc = array("hours"=>"Work Hours","books_sold"=>"Books Sold","Value_sales"=>"Value of Sales","free_literature"=>"Free Literature","v_o_p"=>"VOP","people_attending_SS"=>"Attending SS","sda_back_slinders"=>"SDA Back Slinders","prayers_offered"=>"Prayers Offered","Bibles_studies_given"=>"Bible Studies Given","people_joining_bapstism_classes"=>"People Joining Baptism Classes","no_baptised"=>"Baptized","Magazines"=>"Magazines","Waliotembelewa"=>"Home Visited");	
								
								$database_columns_box_sizes = array("hours"=>"4","books_sold"=>"4","Value_sales"=>"10","free_literature"=>"4","v_o_p"=>"4","people_attending_SS"=>"4","sda_back_slinders"=>"4","prayers_offered"=>"4","Bibles_studies_given"=>"4","people_joining_bapstism_classes"=>"4","no_baptised"=>"4","Magazines"=>"4","Waliotembelewa"=>"4");
								
								?>
                               
                                <br><br>
                                
                               <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                               <input type="hidden" name="zoneID" value="<?php echo $zoneID; ?>">
                               <input type="hidden" name="month" value="<?php echo $month; ?>">
                               <input type="hidden" name="year" value="<?php echo $year; ?>">
                               <input type="hidden" name="confID" value="<?php echo $confID; ?>">
                               <input type="hidden" name="pageNum" value="<?php echo $pageNum; ?>">
                               
                                    <table id="customers" class="table table-striped">
                                        <thead>
                                            <tr>
                                            	<th> No </th>
                                                <th>Evangelist Name</th>
                                                <th align="center">Hours</th>
                                                <th><center>Books<br>Sold</center></th>
                                                <th> Magazines </th>
                                                <th> Value of <br>Sales </th>
                                                <th><center>Free<br>Literature</center></th>
                                                <th align="center">V.O.P</th>
                                                <th><center>Attend<br>SS</center></th>
                                                <th><center>Back<br>Slinders</center></th>
                                                <th align="center">Prayers</th>
                                                <th><center>Bible<br>Studies</center></th>
                                                <th><center>Baptisim<br>Classes</center></th> 
                                                <th align="center"> Baptized </th> 
                                                 <th align="center"> Home<br>Visited </th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
										if(mysql_num_rows($query)==0)
										{
											?>
                                            <tr>
                                            <td colspan="9"> No Evangelists Registered in <?php echo $zone_details['ZoneName']; ?> Zone - <?php echo return_conference_name($zone_details['ConferenceID']); ?> (<?php echo return_conference_abbrev($zone_details['ConferenceID']) ?>) </td> </tr>
                                            </tr>
                                            <?php
										}	
										else
										{
											$num = $start_from;
											while($fetch_conferences_lists = mysql_fetch_array($query))
											{
												$num++;
												$evangID = $fetch_conferences_lists['ID'];
												$query_repoti = mysql_query("SELECT * FROM evangelists_monthly_report WHERE evangelistID='$evangID' AND year='$year' AND month='$month' ",$connect)or die(mysql_error());
												
													$fetch_existing = mysql_fetch_array($query_repoti);	
												
												?>
                                            <tr>
                                            	<td> <?php echo $num; ?>. </td>
                                                <td> <?php echo $fetch_conferences_lists['First_Name']." ".$fetch_conferences_lists['Middle_Name']." ".$fetch_conferences_lists['Last_Name']; ?>  </td>
                                                <?php
                                                foreach($database_columns as $get)
												{
													if($fetch_existing[$get]>0)
													{
														$amount_disp = number_format($fetch_existing[$get]);
													}
													else
													{
														$amount_disp = "";	
													}
													?>
                                                    <td align="center"> <input type="text" name="<?php echo $get."_".$evangID; ?>" value="<?php echo $amount_disp; ?>" size=<?php echo $database_columns_box_sizes[$get]; ?> data-toggle="tooltip" data-placement="bottom" title="<?php echo $database_columns_desc[$get]; ?>" > </td>
                                                    <?php
												}//end foreach
												
												?>
                                                
                                            </tr>
                                          <?php
											}
										}
										?>
                                        </tbody>
                                    </table>  
                                    <?php 
                                    $total_pages = ceil($total_evangelists_number/$num_records_per_page);
				?>
                <ul class="pagination">
                <?php
				for($i=1;$i<=$total_pages;$i++)
				{
					if($i==$page)
					{
						?>
						<li class="active"> <a href="#"> <?php echo $page." "; ?> </a> </li>	
                        <?php
					}
					else
					{
						?>
                        <li> <a href="?new_zone_report_month_page223=<?php echo $i; ?>&zoneID=<?php echo $zoneID; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>&confID=<?php echo $confID; ?>"> <?php echo $i; ?> </a> </li>
                        <?php
					}
				}
									?>
					</ul>                                  
                                    <button class="btn btn-primary pull-left" type="submit" name="save_monthly_report_22">Save Report</button>
                                    </form>
                                </div>
                            </div>
                            <!-- END DATATABLE EXPORT -->                            
                            
                            
                        </div>
                    </div>

                </div>         
                <!-- END PAGE CONTENT WRAPPER -->
                <?php
				}//end function Conferences Lists
				
				
				function AddEvangelistIn_zone($zoneID)
				{
					
					require('connection.php');
					$zone_query = mysql_query("SELECT * FROM zones_lists WHERE ID='$zoneID' ",$connect)or die(mysql_error());
					$zone_details = mysql_fetch_array($zone_query);
					?>
                    <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                             <input type="hidden" name="zoneID" value="<?php echo $zoneID; ?>">
                             <input type="hidden" name="confID" value="<?php echo $zone_details['ConferenceID']; ?>">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                
                                    <h3 class="panel-title">Register a new Evangelist In <?php echo $zone_details['ZoneName']; ?> Zone - <?php echo return_conference_name($zone_details['ConferenceID']); ?> (<?php echo return_conference_abbrev($zone_details['ConferenceID']); ?>) </h3>
                                    
                                    <ul class="panel-controls">
                                        <!-- <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li> -->
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <p>Please Fill the form below to Register a new Evangelist, All fields with a * must be filled.</p>
                                    <a href="?View_zone_single=<?php echo  $zoneID; ?>"> Back </a> 
                                </div>
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*First Name:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="FirstName" class="form-control" placeholder="Evangelist First Name" required/>                                                    </div> 
                                                </div>
                                            </div>
                                            
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Middle Name:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="MiddleName" class="form-control" placeholder="Evangelist Middle Name" />                                      </div>                                            
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Last Name:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="LastName" class="form-control" placeholder="Evangelist Last Name" required/>                                      			</div>                                            
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Gender:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select required class="form-control select" name="Gender">
                                                     	<option value="">------Select Gender ------</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Marital Status:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="Marital_Status">
                                                     	<option value="">------Select Marital Status ------</option>
                                                        <option value="Single">Single</option>
                                                        <option value="Married">Married</option>
                                                        <option value="Separated">Separated</option>
                                                        <option value="Widowed">Widowed</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Grade:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select required class="form-control select" name="Evang_grade">
                                                     	<option value="">------Select Evangelist Grade ------</option>
                                                        <?php
														$query_grades = mysql_query("SELECT * FROM evangelists_grades",$connect)or die(mysql_error());
														while($fetch_grades = mysql_fetch_array($query_grades))
														{
														?>
                                                        <option value="<?php echo $fetch_grades['ID']; ?>"><?php echo $fetch_grades['Name']; ?></option>
                                                        <?php
														}//end while loop
														?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Education Level:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="EducationLevel">
                                                     	<option value="">------Select Education Level ------</option>
                                                        <option value="Primary School">Primary School</option>
                                                        <option value="Form IV">Form IV</option>
                                                        <option value="Form VI">Form VI</option>
                                                        <option value="Certificate">Certificate</option>
                                                        <option value="Diploma">Diploma</option>
                                                        <option value="Advanced Diploma">Advanced Diploma</option>
                                                        <option value="Degree">Degree</option>
                                                        <option value="Post Graduate">Post Graduate</option>
                                                        <option value="Masters">Masters</option>
                                                        <option value="Phd">Phd</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                             
                                            
                                        </div>
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Phone Number:</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Phone Number" name="phone_number">                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Email Number:</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Email Address" name="email_address">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Church:</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Region" placeholder="Residence Region" />                                                    </div>            
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Church District:</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="District" placeholder="Residence District" />                                                    </div>            
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-default">Clear Form</button>                                    
                                    <button class="btn btn-primary pull-right" type="submit" name="Save_new_evangelist">Save</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                    <?php	
				}
				
				function EditEvangelistIn_zone($evangelistID,$zoneID)
				{
					
					require('connection.php');
					
					$zone_query = mysql_query("SELECT * FROM evangelists_list WHERE ID='$evangelistID' ",$connect)or die(mysql_error());
					$fetch_evangelists = mysql_fetch_array($zone_query);
					
					$zone_query = mysql_query("SELECT * FROM zones_lists WHERE ID='$zoneID' ",$connect)or die(mysql_error());
					$zone_details = mysql_fetch_array($zone_query);
					?>
                    <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input type="hidden" name="evangID" value="<?php echo $evangelistID; ?>">
                             <input type="hidden" name="zoneID" value="<?php echo $zoneID; ?>">
                             <input type="hidden" name="confID" value="<?php echo $zone_details['ConferenceID']; ?>">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                
                                    <h3 class="panel-title">Editing Evangelist From <?php echo $zone_details['ZoneName']; ?> Zone - <?php echo return_conference_name($zone_details['ConferenceID']); ?> (<?php echo return_conference_abbrev($zone_details['ConferenceID']); ?>) </h3>
                                    
                                    <ul class="panel-controls">
                                        <!-- <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li> -->
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <p>Please Fill the form below to Edit Evangelist Details, All fields with a * must be filled.</p>
                                    <a href="?View_zone_single=<?php echo  $zoneID; ?>"> Back </a> 
                                </div>
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*First Name:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="FirstName" class="form-control" placeholder="Evangelist First Name" value="<?php echo $fetch_evangelists['First_Name']; ?>" required/>                                                    </div> 
                                                </div>
                                            </div>
                                            
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Middle Name:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="MiddleName" class="form-control" placeholder="Evangelist Middle Name" value="<?php echo $fetch_evangelists['Middle_Name']; ?>" />                                      </div>                                            
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Last Name:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="LastName" class="form-control" placeholder="Evangelist Last Name" required value="<?php echo $fetch_evangelists['Last_Name']; ?>"/>                                      			</div>                                            
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Gender:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select required class="form-control select" name="Gender">
                                                     <option value="<?php echo $fetch_evangelists['Gender']; ?>"> <?php echo $fetch_evangelists['Gender']; ?> </option>
                                                     	<option value="">------Select Gender ------</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Marital Status:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="Marital_Status">
                                                     <option value="<?php echo $fetch_evangelists['Marital_status']; ?>"> <?php echo $fetch_evangelists['Marital_status']; ?> </option>
                                                     	<option value="">------Select Marital Status ------</option>
                                                        <option value="Single">Single</option>
                                                        <option value="Married">Married</option>
                                                        <option value="Separated">Separated</option>
                                                        <option value="Widowed">Widowed</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Grade:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select required class="form-control select" name="Evang_grade">
                                                    <option value="<?php echo $fetch_evangelists['Grade']; ?>"> <?php echo return_grade_Name($fetch_evangelists['Grade']) ?> </option>
                                                     	<option value="">------Select Evangelist Grade ------</option>
                                                        <?php
														$query_grades = mysql_query("SELECT * FROM evangelists_grades",$connect)or die(mysql_error());
														while($fetch_grades = mysql_fetch_array($query_grades))
														{
														?>
                                                        <option value="<?php echo $fetch_grades['ID']; ?>"><?php echo $fetch_grades['Name']; ?></option>
                                                        <?php
														}//end while loop
														?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Education Level:</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="EducationLevel">
                                                    <option value="<?php echo $fetch_evangelists['Education_level']; ?>"> <?php echo $fetch_evangelists['Education_level']; ?> </option>
                                                     	<option value="">------Select Education Level ------</option>
                                                        <option value="Primary School">Primary School</option>
                                                        <option value="Form IV">Form IV</option>
                                                        <option value="Form VI">Form VI</option>
                                                        <option value="Certificate">Certificate</option>
                                                        <option value="Diploma">Diploma</option>
                                                        <option value="Advanced Diploma">Advanced Diploma</option>
                                                        <option value="Degree">Degree</option>
                                                        <option value="Post Graduate">Post Graduate</option>
                                                        <option value="Masters">Masters</option>
                                                        <option value="Phd">Phd</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                             
                                            
                                        </div>
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Phone Number:</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Phone Number" name="phone_number" value="<?php echo $fetch_evangelists['Phone']; ?>">                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Email Number:</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Email Address" name="email_address" value="<?php echo $fetch_evangelists['Email']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Church:</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Region" placeholder="Residence Region"  value="<?php echo $fetch_evangelists['Region']; ?>"/>                                                    </div>            
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Church District:</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="District" placeholder="Residence District"  value="<?php echo $fetch_evangelists['Districts']; ?>"/>                                                    </div>            
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-default">Clear Form</button>                                    
                                    <button class="btn btn-primary pull-right" type="submit" name="Save_new_evangelist_edit">Update</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                    <?php	
				}
				
				function View_Conference_Evangelists_Reports($confID,$year,$month)
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
                                    <h3 class="panel-title">Evangelists Monthly Report - <?php echo return_conference_name($confID); ?> (<?php echo return_conference_abbrev($confID) ?>) </h3>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Report</button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="Conference_zones_report.xlsx"><img src='img/icons/xls.png' width="24"/> Excel </a></li>
                                            <li><a href="#"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                            <li><a href="#"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                                    </div>                                    
                                    
                                </div>
                                <div class="panel-body">
                                
                               <a href="?View_Conference_single=<?php echo $confID; ?>" data-toggle="tooltip" data-placement="bottom" title="Click to go back "> <b> Back </b> </a> <br><br>
                                
                                Showing Report for <?php echo $array_months[$month]; ?> , <?php echo $year; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                
                                <a href="#"  data-placement="bottom" title="Click to View Reports for Other Month / year" data-toggle="modal" data-target="#myModal"> <b> View Other Reports </b> </a> | <a href="#" data-toggle="modal" data-target="#myModal2" data-placement="bottom" title="Click to Add / Edit Evangelist Report"> <b> Add / Edit Zonal Report </b> </a>
                               
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
        <input type="hidden" name="confID" value="<?php echo $confID ?>" >
        <div class="col-md-6">
        										<div class="form-group">
                                                <label class="col-md-3 control-label">Month</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="view_conf_evang_report_month" required>
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
                                                    <select class="form-control select" name="view_conf_evang_report_year" required>
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


 <!-- Modal -->
<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Zone , Month and Year to Create report</h4>
      </div>
      <div class="modal-body">
        <p>Please Select Zone , Month and Year for the report you want to Create .
        
        <div class="row">
        <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <input type="hidden" name="ConfID" value="<?php echo $confID; ?>" >
        <div class="col-md-6">
        										<div class="form-group">
                                                <label class="col-md-3 control-label">Month</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select" name="new_zone_report_month_conf" required>
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
                                                    <select class="form-control select" name="new_zone_report_year_conf" required>
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
                                                <label class="col-md-3 control-label" >Zone</label>
                                                <div class="col-md-9">	
                                                <?php
												$query_zones = mysql_query("SELECT * FROM zones_lists WHERE ConferenceID='$confID' ",$connect)or die('Error Selecting conferences zones due to reason - '.mysql_error());
												?>					                                                                                            
                                                    <select class="form-control select" name="new_zone_report_zone_conf" required>
                                                    <option value="">---Select zone---</option>
                                                       <?php
													   if(mysql_num_rows($query_zones)>0)
													   {
													   
													   while($fetch_zones = mysql_fetch_array($query_zones))
													   {
														   ?>
															<option value="<?php echo $fetch_zones['ID']; ?>"><?php echo $fetch_zones['ZoneName']; ?></option>   
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
									<?php
								$sql = "SELECT * FROM zones_lists WHERE ConferenceID='$confID' ";
								
								$zone_query = mysql_query($sql,$connect)or die('Error Selecting Zones Lists because - '.mysql_error());
								
								Export_All_zones_reports($sql,$confID,$month,$year); //Export the Zones Report to Microsoft Excel....
								
								?>
                                <table id="customers" class="table table-striped">
                                <?php
											$sum_hours_gr = 0;
											$sum_books_sold_gr = 0;
											$sum_value_sale_gr = 0;
											$free_literature_gr = 0;
											$vop_gr = 0;
											$attending_ss_gr = 0;
											$back_slinders_gr = 0;
											$prayers_gr = 0;
											$bible_studies_gr = 0;
											$baptism_classes_gr = 0;
											$baptized_gr = 0;
											$home_visited_gr = 0;
											$magazine_gr = 0;
											
								while($zone_details = mysql_fetch_array($zone_query))
								{
									$zoneID = $zone_details['ID'];
									
								$query = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID' ",$connect)or die(mysql_error());
								//data-toggle="tooltip"
								?>
                                    
                                        <thead>
                                        <tr><th colspan="16"> <?php echo $zone_details['ZoneName']; ?> </th> </tr>
                                            <tr>
                                            	<th> No </th>
                                                <th>Evangelist Name</th>
                                                <th>Grade</th>
                                                <th>Hours</th>
                                                <th><center>Books<br>Sold</center></th>
                                                <th><center>Magazine</center></th>
                                                <th> Value of <br>Sales </th>
                                                <th><center>Free<br>Literature</center></th>
                                                <th>V.O.P</th>
                                                <th><center>Attending<br> SS</center></th>
                                                <th><center>Back<br>Slinders</center></th>
                                                <th>Prayers</th>
                                                <th><center>Bible<br>Studies</center></th>
                                                <th><center>Baptisim<br>Classes</center></th> 
                                                <th> Baptized </th> 
                                                <th> Home<br>Visited </th> 
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
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
											$home_visited = 0;
											$magazine = 0;
										if(mysql_num_rows($query)==0)
										{
											?>
                                            <tr>
                                            <td colspan="16"> No Evangelists Registered in <?php echo $zone_details['ZoneName']; ?> Zone - <?php echo return_conference_name($zone_details['ConferenceID']); ?> (<?php echo return_conference_abbrev($zone_details['ConferenceID']) ?>) </td> </tr>
                                            </tr>
                                            <?php
										}	
										else
										{
											$num = 0;
											
											
											
											while($fetch_conferences_lists = mysql_fetch_array($query))
											{
												$num++;
												$evangID = $fetch_conferences_lists['ID'];
												$query_repoti = mysql_query("SELECT * FROM evangelists_monthly_report WHERE evangelistID='$evangID' AND year='$year' AND month='$month' ",$connect)or die(mysql_error());
												
												?>
                                            <tr>
                                            	<td> <?php echo $num; ?>. </td>
                                                <td> <?php echo $fetch_conferences_lists['First_Name']." ".$fetch_conferences_lists['Middle_Name']." ".$fetch_conferences_lists['Last_Name']; ?>  </td>
                                                <td> <?php echo return_evang_grade_disp($fetch_conferences_lists['Grade']); ?> </td>
                                                <?php
												if(mysql_num_rows($query_repoti)==0)
												{
													?>
                                                    <td align="center"> - </td>
                                                    <td align="center"> - </td>
                                                    <td align="center"> - </td>
                                                    <td align="center"> - </td>
                                                    <td align="center"> - </td>
                                                    <td align="center"> - </td>
                                                    <td align="center"> - </td>
                                                    <td align="center"> - </td>
                                                    <td align="center"> - </td>
                                                    <td align="center"> - </td>
                                                    <td align="center"> - </td>
                                                    <td align="center"> - </td>
                                                    <td align="center"> - </td>
                                                    <?php
												}
												else
												{
													$fetch_results = mysql_fetch_array($query_repoti);
													
													$sum_hours = $sum_hours + $fetch_results['hours'];
													$sum_books_sold = $sum_books_sold + $fetch_results['books_sold'];
													$sum_value_sale = $sum_value_sale + $fetch_results['Value_sales'];
													$free_literature = $free_literature + $fetch_results['free_literature'];
													$vop = $vop + $fetch_results['v_o_p'];
													$attending_ss = $attending_ss + $fetch_results['people_attending_SS'];
													$back_slinders = $back_slinders + $fetch_results['sda_back_slinders'];
													$prayers = $prayers + $fetch_results['prayers_offered'];
													$bible_studies = $bible_studies + $fetch_results['Bibles_studies_given'];
													$baptism_classes = $baptism_classes + $fetch_results['people_joining_bapstism_classes'];
													$baptized = $baptized + $fetch_results['no_baptised'];
													$home_visited = $home_visited + $fetch_results['Waliotembelewa'];
													$magazine = $magazine + $fetch_results['Magazines'];
													
													$sum_hours_gr = $sum_hours_gr + $fetch_results['hours'];
													$sum_books_sold_gr = $sum_books_sold_gr + $fetch_results['books_sold'];
													$sum_value_sale_gr = $sum_value_sale_gr + $fetch_results['Value_sales'];
													$free_literature_gr = $free_literature_gr + $fetch_results['free_literature'];
													$vop_gr = $vop_gr + $fetch_results['v_o_p'];
													$attending_ss_gr = $attending_ss_gr + $fetch_results['people_attending_SS'];
													$back_slinders_gr = $back_slinders_gr + $fetch_results['sda_back_slinders'];
													$prayers_gr = $prayers_gr + $fetch_results['prayers_offered'];
													$bible_studies_gr = $bible_studies_gr + $fetch_results['Bibles_studies_given'];
													$baptism_classes_gr = $baptism_classes_gr + $fetch_results['people_joining_bapstism_classes'];
													$baptized_gr = $baptized_gr + $fetch_results['no_baptised'];
													$home_visited_gr = $home_visited_gr + $fetch_results['Waliotembelewa'];
													$magazine_gr = $magazine_gr + $fetch_results['Magazines'];
													?>
                                                <td align="center"> <?php echo number_format($fetch_results['hours']); ?></td>
                                                <td align="center"> <?php echo number_format($fetch_results['books_sold']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['Magazines']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['Value_sales']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['free_literature']); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format($fetch_results['v_o_p']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['people_attending_SS']); ?> </td>
                                                
                                                <td align="center"> <?php echo number_format($fetch_results['sda_back_slinders']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['prayers_offered']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['Bibles_studies_given']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['people_joining_bapstism_classes']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['no_baptised']); ?> </td>
                                                <td align="center"> <?php echo number_format($fetch_results['Waliotembelewa']); ?> </td>
                                                <?php
												}
												?>
                                                
                                                
                                            </tr>
                                          <?php
											}
										}
										?>
                                        <tr>
                                        <th colspan="3"> TOTAL </th>
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
                                        <th> <center><?php echo number_format($home_visited); ?></center></th>
                                        
                                        
                                        </tr>
                                        <tr><th colspan="16">&nbsp;  </th></tr>
                                        </tbody>
                                        <?php
								}//end Outer While loop
								?>
                                	<tr>
                                    <th colspan="3"> GRAND TOTAL </th>
                                    <th> <center><?php echo number_format($sum_hours_gr); ?> </center> </th>
                                        <th> <center><?php echo number_format($sum_books_sold_gr); ?> </center> </th>
                                         <th> <center><?php echo number_format($magazine_gr); ?> </center> </th>
                                        <th> <center><?php echo number_format($sum_value_sale_gr); ?> </center> </th>
                                        <th> <center><?php echo number_format($free_literature_gr); ?> </center></th>
                                        <th> <center><?php echo number_format($vop_gr); ?> </center></th>
                                        <th> <center><?php echo number_format($attending_ss_gr); ?> </center></th>
                                        <th> <center><?php echo number_format($back_slinders_gr); ?> </center></th>
                                        <th> <center><?php echo number_format($prayers_gr); ?></center> </th>
                                        <th> <center><?php echo number_format($bible_studies_gr); ?></center></th>
                                        <th> <center><?php echo number_format($baptism_classes_gr); ?></center></th>
                                        <th> <center><?php echo number_format($baptized_gr); ?></center></th>
                                        <th> <center><?php echo number_format($baptized_gr); ?></center></th>
                                    </tr>
                                    </table>                                    
                                    
                                    <br><br>
                                   
                                   <table id="customers" class="table table-striped">
                                   <thead>
                                   <tr>
                                   <th colspan="6"> KANDA / SUMMARY B</th> </tr>
                                   <tr>
                                   <th> ZONE </th> 
                                   <?php
								   $query_grade = mysql_query("SELECT * FROM evangelists_grades",$connect)or die(mysql_error());
								   while($fetch_gradre = mysql_fetch_array($query_grade))
								   {
									   ${'evang'.$fetch_gradre['ID']} = 0;
										?>
                                        <th> <?php echo $fetch_gradre['code']; ?> </th>
                                        <?php   
								   }
								   ?>
                                   <th> TOTAL </th>
                                   </tr>
                                   </tr>
                                   </thead>
                                   
                                   <tbody>
                                   <?php
								   $query_zones_all = mysql_query("SELECT *FROM zones_lists WHERE ConferenceID='$confID' ",$connect)or die(mysql_error());
								   while($fetch_zones_zone = mysql_fetch_array($query_zones_all))
								   {
									   $zoneID = $fetch_zones_zone['ID'];
									   ?>
                                       <tr>
                                       <td> <?php echo $fetch_zones_zone['ZoneName']; ?> </td>
                                       <?php
									   $total = 0;
								   $query_grade2 = mysql_query("SELECT * FROM evangelists_grades",$connect)or die(mysql_error());
								   while($fetch_gradre2 = mysql_fetch_array($query_grade2))
								   {
									   $evangGrade = $fetch_gradre2['ID'];
									   $total = $total + CountEvangelistsZones($zoneID,$evangGrade);
									   //${'evang'.$fetch_gradre2['ID']} = ${'evang'.$fetch_gradre2['ID']} + CountEvangelistsZones($zoneID,$evangGrade);
										?>
                                        <td> <?php echo CountEvangelistsZones($zoneID,$evangGrade); ?> </td>
                                        <?php   
								   }
								   ?>
                                       <td> <?php echo $total; ?> </td>
                                       </tr>
                                       <?php
								   }//end while loop
								   ?>
                                   </tbody>
                                   
                                   </table>
                                   
                                   <br><br>
                                   
                                   <table id="customers" class="table table-striped"> 
                                    <thead>
                                        <tr> <th colspan="15"> KANDA / SUMMARY C</th> </tr>
                                            <tr>
                                            	<th> No </th>
                                                <th>Zone Name</th>
                                                <th>Hours</th>
                                                <th><center>Books<br>Sold</center></th>
                                                <th><center>Magazines</center></th>
                                                <th> Value of<br> Sales </th>
                                                <th><center>Free<br>Literature</center></th>
                                                <th>V.O.P</th>
                                                <th><center>Attending<br> SS</center></th>
                                                <th><center>Back<br>Slinders</center></th>
                                                <th>Prayers</th>
                                                <th><center>Bible<br>Studies</center></th>
                                                <th><center>Baptisim<br>Classes</center></th> 
                                                <th> Baptized </th> 
                                                <th> Home<br>Visited </th> 
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
										$query_kanda = mysql_query("SELECT * FROM zones_lists WHERE ConferenceID='$confID' ",$connect)or die(mysql_error());
										$num_kanda = 0;
										$sum_hours_kanda = 0;
										$sum_books_sold_kanda = 0;
										$sum_magazines_kanda = 0;
										$sum_valuesale_kanda = 0;
										$sum_feeLiter_kanda = 0;
										$sum_vop_kanda = 0;
										$sum_attendSS_kanda = 0;
										$sum_backslinders_kanda = 0;
										$sum_prayers_kanda = 0;
										$sum_bibleStudies_kanda = 0;
										$sum_baptismClass_kanda = 0;
										$sum_baptized_kanda = 0;
										$sum_visited_kanda = 0;
										while($fetch_kandaz = mysql_fetch_array($query_kanda))
										{
											$num_kanda++;
											$kandaID = $fetch_kandaz['ID'];
											$sum_hours_kanda = $sum_hours_kanda + Sum_Item_Month('hours',$month,$year,$kandaID);
											$sum_books_sold_kanda = $sum_books_sold_kanda + Sum_Item_Month('books_sold',$month,$year,$kandaID);
											$sum_valuesale_kanda = $sum_valuesale_kanda + Sum_Item_Month('Value_sales',$month,$year,$kandaID);
											$sum_feeLiter_kanda = $sum_feeLiter_kanda + Sum_Item_Month('free_literature',$month,$year,$kandaID);
											$sum_vop_kanda = $sum_vop_kanda + Sum_Item_Month('v_o_p',$month,$year,$kandaID);
											$sum_attendSS_kanda = $sum_attendSS_kanda + Sum_Item_Month('people_attending_SS',$month,$year,$kandaID);
											$sum_backslinders_kanda = $sum_backslinders_kanda + Sum_Item_Month('sda_back_slinders',$month,$year,$kandaID);
											$sum_prayers_kanda = $sum_prayers_kanda + Sum_Item_Month('prayers_offered',$month,$year,$kandaID);
											$sum_bibleStudies_kanda = $sum_bibleStudies_kanda + Sum_Item_Month('Bibles_studies_given',$month,$year,$kandaID);
											$sum_baptismClass_kanda = $sum_baptismClass_kanda + Sum_Item_Month('people_joining_bapstism_classes',$month,$year,$kandaID);
											$sum_baptized_kanda = $sum_baptized_kanda + Sum_Item_Month('no_baptised',$month,$year,$kandaID);
											$sum_visited_kanda = $sum_visited_kanda + Sum_Item_Month('Waliotembelewa',$month,$year,$kandaID);
											$sum_magazines_kanda = $sum_magazines_kanda + Sum_Item_Month('Magazines',$month,$year,$kandaID);
											?>
                                            <tr>
                                            <td> <?php echo $num_kanda; ?>. </td>
                                            <td> <?php echo $fetch_kandaz['ZoneName']; ?> </td>
                                            <td align="center"> <?php echo number_format(Sum_Item_Month('hours',$month,$year,$kandaID)); ?> </td>
                                            <td align="center"> <?php echo number_format(Sum_Item_Month('books_sold',$month,$year,$kandaID)); ?> </td>
                                            <td align="center"> <?php echo number_format(Sum_Item_Month('Magazines',$month,$year,$kandaID)); ?> </td>
                                            <td align="center"> <?php echo number_format(Sum_Item_Month('Value_sales',$month,$year,$kandaID)); ?> </td>
                                            <td align="center"> <?php echo number_format(Sum_Item_Month('free_literature',$month,$year,$kandaID)); ?> </td>
                                            <td align="center"> <?php echo number_format(Sum_Item_Month('v_o_p',$month,$year,$kandaID)); ?> </td>
                                            <td align="center"> <?php echo number_format(Sum_Item_Month('people_attending_SS',$month,$year,$kandaID)); ?> </td>
                                            <td align="center"> <?php echo number_format(Sum_Item_Month('sda_back_slinders',$month,$year,$kandaID)); ?> </td>
                                            <td align="center"> <?php echo number_format(Sum_Item_Month('prayers_offered',$month,$year,$kandaID)); ?> </td>
                                            <td align="center"> <?php echo number_format(Sum_Item_Month('Bibles_studies_given',$month,$year,$kandaID)); ?> </td>
                                            <td align="center"> <?php echo number_format(Sum_Item_Month('people_joining_bapstism_classes',$month,$year,$kandaID)); ?> </td>
                                            <td align="center"> <?php echo number_format(Sum_Item_Month('no_baptised',$month,$year,$kandaID)); ?> </td>
                                            <td align="center"> <?php echo number_format(Sum_Item_Month('Waliotembelewa',$month,$year,$kandaID)); ?> </td>
                                            </tr>
                                            <?php
										}//end fucntion Query Kanda
										?>
                                        
                                        <tr>
                                        <th colspan="2"> TOTAL </th>
                                        <th> <center><?php echo number_format($sum_hours_kanda); ?></center> </th>
                                        <th> <center><?php echo number_format($sum_books_sold_kanda); ?></center> </th>
                                        <th> <center><?php echo number_format($sum_magazines_kanda); ?></center> </th>
                                        <th> <center><?php echo number_format($sum_valuesale_kanda); ?></center> </th>
                                        <th> <center><?php echo number_format($sum_feeLiter_kanda); ?></center> </th>
                                        <th> <center><?php echo number_format($sum_vop_kanda); ?></center> </th>
                                        <th> <center><?php echo number_format($sum_attendSS_kanda); ?></center> </th>
                                        <th> <center><?php echo number_format($sum_backslinders_kanda); ?></center> </th>
                                        <th> <center><?php echo number_format($sum_prayers_kanda); ?></center> </th>
                                        <th> <center><?php echo number_format($sum_bibleStudies_kanda); ?></center> </th>
                                        <th> <center><?php echo number_format($sum_baptismClass_kanda); ?></center> </th>
                                        <th> <center><?php echo number_format($sum_baptized_kanda); ?></center> </th>
                                        <th> <center><?php echo number_format($sum_visited_kanda); ?></center> </th>
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
				
				
				//*****************************************PROGRAM EXECUTION************************8
				if(isset($_GET['View_Conference_single']))
				{
					View_Conference_Single($_GET['View_Conference_single'],$reportID);
				}
                else if(isset($_GET['BackView_Report']))
                {
                    View_Conference_Single($_GET['BackView_Report'],$_GET['reportID']);
                }
				else if(isset($_GET['add_new_zone']))
				{
					AddRegister_zone($_GET['add_new_zone']);	
				}
                else if(isset($_POST['Save_new_zone_edited']))
                {
                    $ReqID = $_POST['ReqID'];
                    $UserID = $_POST['UserID'];
                    $MarketID = $_POST['MarketID'];

                    $pickupname = $_POST['pickupname'];
                    $phone_number = $_POST['phone_number'];
                    $pickupstreet = $_POST['pickupstreet'];
                    $popularareapickup = $_POST['popularareapickup'];

                    $idreport = returnMarketPrice($MarketID);

                     require('connection.php');

                    //Order Pickup Details Update
                    $pickupname = $_POST['pickupname'];
                    $updatePickupOrderQuery = mysql_query("UPDATE users_requests SET pickupName='$pickupname',pickupphone='$phone_number',pickupstreet='$pickupstreet',pickupnearbypopulararea='$popularareapickup' WHERE ID='$ReqID' ",$connect)or die(mysql_error());

                   

                    $queryProduct = mysql_query("SELECT * FROM products ",$connect)or die(mysql_error());
                    while($fetchProducts = mysql_fetch_array($queryProduct))
                    {
                        $prodID = $fetchProducts['ProductID'];
                        $prodVal = $_POST['productname_'.$prodID];

                        if($prodVal=="")
                        {
                            //Check if the Product was There initially
                            $queryCheckAvailabilityBefore = mysql_query("SELECT * FROM users_requests_items WHERE ReqID='$ReqID' AND ProductID='$prodID' ",$connect)or die(mysql_error());

                            if(mysql_num_rows($queryCheckAvailabilityBefore)>0)
                            {
                                $deleteQuery = mysql_query("DELETE FROM users_requests_items WHERE ReqID='$ReqID' AND ProductID='$prodID' ",$connect)or die(mysql_error());
                            }
                            else
                            {
                                continue;
                            }
                        }
                        else
                        {
                            $queryCheckAvailabilityBefore = mysql_query("SELECT * FROM users_requests_items WHERE ReqID='$ReqID' AND ProductID='$prodID' ",$connect)or die(mysql_error());

                            if(mysql_num_rows($queryCheckAvailabilityBefore)>0)
                            {
                                $deleteQuery = mysql_query("UPDATE users_requests_items SET Quantity='$prodVal' WHERE ReqID='$ReqID' AND ProductID='$prodID' ",$connect)or die(mysql_error());
                            }
                            else
                            {
                                $prodprice = str_replace(',','',returnProductReportValues($prodID,$idreport,'maximum_value'))
                                    ;

                                $InsertIntoProdReqQuery = mysql_query("INSERT INTO users_requests_items(ReqID,ProductID,Quantity,AmountPerUnit) VALUES('$ReqID','$prodID','$prodVal','$prodprice') ",$connect)or die(mysql_error());
                            }

                        }

                    }//end while loop

                    View_Conferences_List();

                }
                else if(isset($_GET['Edit_market_info']))
                {
                    EditOrderRequest($_GET['Edit_market_info'],$_GET['marketID']);
                }
				else if(isset($_GET['new_apdd_report']))
				{
					New_Report_Apdd($_GET['new_apdd_report'],$_GET['month'],$_GET['year'],$_GET['date'],$_GET['confID']);	
				}
				else if(isset($_GET['month_apdd_report_choice']))
				{
					View_APDD_List($_GET['ConfID'],$_GET['new_zone_report_zone_conf'],$_GET['month_apdd_report_choice'],$_GET['year_apdd_report_choice']);	
				}
				else if(isset($_GET['view_zones_summary']))
				{
					$year = date('Y');
					View_ConferenceSummary($_GET['view_zones_summary'],$year);	
				}
                else if(isset($_GET['add_new_market']))
                {
                    AddRegisterMarket($_GET['MarketID']);
                }
				else if(isset($_POST['save_monthly_report']))
				{
						$MarketID = $_POST['MarketID'];
						$initialID = $_POST['initialID'];
						$pageNum = $_POST['pageNum'];
						
						
						$array_database_columns = array("minimum_value","maximum_value","steps","challenges","feedback");
						
						require('connection.php');
						
						$query = mysql_query("SELECT * FROM products ",$connect)or die(mysql_error());
						while($fetch_conferences_lists = mysql_fetch_array($query))
						{
							$productID = $fetch_conferences_lists['ProductID'];
							$query_repoti_availability = mysql_query("SELECT * FROM product_prices_actual WHERE ProductID='$productID' AND PriceID='$initialID' ",$connect)or die(mysql_error());
							
							if(mysql_num_rows($query_repoti_availability)==0)
							{
								//Insert Few Details and Update the rest
								//Insert New Values 
								$queryWeka = mysql_query("INSERT INTO product_prices_actual(ProductID,PriceID) VALUES ('$productID','$initialID') ",$connect) or die(mysql_error());
								$id_mpya = mysql_insert_id();
								
					for($a=0;$a<count($array_database_columns);$a++)
					{
						$name_variable = $array_database_columns[$a]."_".$productID;
						$name_column = $array_database_columns[$a];
						$value = str_replace(',','',$_POST[$name_variable]);
						//echo $value.":";   
						//echo $name_column.":";
						//$sql = "UPDATE ripoti_ya_mtaa SET $name_column='$value' WHERE recordID='$recordID'";
						//echo $sql."<br>";
						if($value==0)
						{
							continue;
						}
						else
						{
						$query_update_values = mysql_query("UPDATE product_prices_actual SET $name_column='$value' WHERE ID='$id_mpya' ",$connect) or die(mysql_error());
						}
						
					}
							}
							else
							{
								//Only Uodate the Data that Has Changed	
								$rec_data_existing = mysql_fetch_array($query_repoti_availability);
								$recordID = $rec_data_existing['ID'];

                                //echo $recordID;
								
					for($a=0;$a<count($array_database_columns);$a++)
					{
						$name_variable = $array_database_columns[$a]."_".$productID;
						$name_column = $array_database_columns[$a];
						$value = str_replace(',','',$_POST[$name_variable]);
						//echo $value.":";   
						//echo $name_column.":";
						//$sql = "UPDATE ripoti_ya_mtaa SET $name_column='$value' WHERE recordID='$recordID'";
						//echo $sql."<br>";
						
						$existing_value = $rec_data_existing[$name_column];
                        //echo $existing_value.":".$value."<br>";
						
						if($value=='-')
						{
							$query_update_values = mysql_query("UPDATE product_prices_actual SET $name_column='0' WHERE ID='$recordID' ",$connect) or die(mysql_error());	
						}
						else if($value=='' or $value==$existing_value) //This ensures value 0 and if the form value and database values are the same they will not be updated - Their Queries will not be updated
						{
                            //echo "continued";
							continue;
						}
						else
						{
                            //echo "UPDATE product_prices_actual SET $name_column='$value' WHERE ID='$recordID<br>'";
						$query_update_values = mysql_query("UPDATE product_prices_actual SET $name_column='$value' WHERE ID='$recordID' ",$connect) or die(mysql_error());
						}
					}
							}
							
						}
						
						New_Edit_Evangelists_Reports($MarketID,$initialID,$pageNum);
				}
                else if(isset($_GET['Market_staffs']))
                {
                    View_Market_staff($_GET['Market_staffs']);
                }
                else if(isset($_POST['Save_new_market_staff']))
                {
                    $MarketID = $_POST['MarketID'];
                    $fname = $_POST['fname'];
                    $lname = $_POST['lname'];
                    $phone = $_POST['phone'];
                    $username = $_POST['username'];
                    $conf_pass = md5($_POST['conf_pass']);
                    $mname = $_POST['mname'];
                    $gender = $_POST['gender'];
                    $Jobtitle = $_POST['Jobtitle'];
                    $email = $_POST['email'];
                    $Address = $_POST['Address'];
                    $pass = md5($_POST['pass']);

                    require('connection.php');

                    $Verifyquery = mysql_query("SELECT * FROM publishing_staffs WHERE FirstName='$fname' AND LastName='$lname' AND Title='$Jobtitle' AND MarketID='$MarketID' ",$connect) or die(mysql_error());
                    if(mysql_num_rows($Verifyquery)==0)
                    {
                        $insertQuery = mysql_query("INSERT INTO publishing_staffs (FirstName,Middlename,LastName,Gender,Phone,Email,username,Passwordi,Title,MarketID,access_level,ImageName,StaffSide,Address) VALUES ('$fname','$mname','$lname','$gender','$phone','$email','$username','$pass','$Jobtitle','$MarketID','20','no_image_user.png','Evangelists','$Address') ",$connect)or die(mysql_error());
                    }

                    View_Market_staff($MarketID);

                }
                else if(isset($_GET['edit_prices_report']))
                {
                    $MarketID = $_GET['MarketID'];
                    $initialID = $_GET['edit_prices_report'];

                    New_Edit_Evangelists_Reports($MarketID,$initialID,$pageNum);
                }
				else if(isset($_GET['view_zones_summary_select']))
				{
					View_ConferenceSummary($_GET['view_zones_summary_select'],$_GET['year']);
				}
				else if(isset($_GET['view_union_summary']))
				{	
					$year = date('Y');
					View_UnionSummary($_GET['view_zones_summary_select'],$year);
				}
				else if(isset($_GET['view_single_zones_summary_select']))
				{
					View_ZoneSummary($_GET['confID'],$_GET['view_single_zones_summary_select'],$_GET['year']);	
				}
				else if(isset($_GET['View_evangelists_details']))
				{
					$year = date('Y');
					View_EvangelistSummary($_GET['View_evangelists_details'],$year);	
				}
				else if(isset($_POST['save_monthly_report_22']))
				{
						$zoneID = $_POST['zoneID'];
						$month = $_POST['month'];
						$year = $_POST['year'];
						$confID = $_POST['confID'];
						$pageNum = $_POST['pageNum'];
						
						
						$array_database_columns = array("hours","books_sold","Magazines","Value_sales","free_literature","v_o_p","people_attending_SS","sda_back_slinders","prayers_offered","Bibles_studies_given","people_joining_bapstism_classes","no_baptised","Waliotembelewa");
						
						require('connection.php');
						
						$query = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID' ",$connect)or die(mysql_error());
						while($fetch_conferences_lists = mysql_fetch_array($query))
						{
							$evangID = $fetch_conferences_lists['ID'];
							$query_repoti_availability = mysql_query("SELECT * FROM evangelists_monthly_report WHERE evangelistID='$evangID' AND year='$year' AND month='$month' ",$connect)or die(mysql_error());
							
							if(mysql_num_rows($query_repoti_availability)==0)
							{
								//Insert Few Details and Update the rest
								//Insert New Values 
								$queryWeka = mysql_query("INSERT INTO evangelists_monthly_report(evangelistID,year,month,zone) VALUES ('$evangID','$year','$month','$zoneID') ",$connect) or die(mysql_error());
								$id_mpya = mysql_insert_id();
								
					for($a=0;$a<count($array_database_columns);$a++)
					{
						$name_variable = $array_database_columns[$a]."_".$evangID;
						$name_column = $array_database_columns[$a];
						$value = str_replace(',','',$_POST[$name_variable]);
						//echo $value.":";   
						//echo $name_column.":";
						//$sql = "UPDATE ripoti_ya_mtaa SET $name_column='$value' WHERE recordID='$recordID'";
						//echo $sql."<br>";
						if($value==0)
						{
							continue;
						}
						else
						{
						$query_update_values = mysql_query("UPDATE evangelists_monthly_report SET $name_column='$value' WHERE ID='$id_mpya' ",$connect) or die(mysql_error());
						}
						
					}
							}
							else
							{
								//Only Uodate the Data that Has Changed	
								$rec_data_existing = mysql_fetch_array($query_repoti_availability);
								$recordID = $rec_data_existing['ID'];
								
					for($a=0;$a<count($array_database_columns);$a++)
					{
						$name_variable = $array_database_columns[$a]."_".$evangID;
						$name_column = $array_database_columns[$a];
						$value = str_replace(',','',$_POST[$name_variable]);
						//echo $value.":";   
						//echo $name_column.":";
						//$sql = "UPDATE ripoti_ya_mtaa SET $name_column='$value' WHERE recordID='$recordID'";
						//echo $sql."<br>";
						
						$existing_value = $rec_data_existing[$name_column];
						
						if($value=='-')
						{
							$query_update_values = mysql_query("UPDATE evangelists_monthly_report SET $name_column='0' WHERE ID='$recordID' ",$connect) or die(mysql_error());	
						}
						else if($value==0 or $value==$existing_value) //This ensures value 0 and if the form value and database values are the same they will not be updated - Their Queries will not be updated
						{
							continue;
						}
						else
						{
						$query_update_values = mysql_query("UPDATE evangelists_monthly_report SET $name_column='$value' WHERE ID='$recordID' ",$connect) or die(mysql_error());
						}
					}
							}
							
						}
						
						New_Edit_Evangelists_Reports_22($zoneID,$year,$month,$confID,$pageNum);
				}
				else if(isset($_GET['view_evang_summary_select']))
				{
					View_EvangelistSummary($_GET['view_evang_summary_select'],$_GET['year']);	
				}
				else if(isset($_GET['view_apdd_report']))
				{
					View_APDD_List($_GET['view_apdd_report'],$_GET['zoneID'],$_GET['month'],$_GET['year']);	
				}
                else if(isset($_GET['add_new_market_staff']))
                {
                    AddRegisterMarketStaff($_GET['add_new_market_staff']);
                }
				else if(isset($_POST['Save_new_app_report']))
				{
					$confID = $_POST['confID'];
					$month = $_POST['month'];
					$year = $_POST['year'];
					$zoneID = $_POST['zoneID'];
					$date = $_POST['date'];
					$apdd_name = $_POST['apdd_name'];
					$Evangelist_name = $_POST['Evangelist_name'];
					$hours = $_POST['hours'];
					$vists = $_POST['vists'];
					$books = $_POST['books'];
					
					$Evangelist_name2 = $_POST['Evangelist_name2'];
					$Evangelist_name3 = $_POST['Evangelist_name3'];
					$Evangelist_name4 = $_POST['Evangelist_name4'];
					
					$value_sale = str_replace(',','',$_POST['value_sale']);
					
					require('connection.php');
					
					$evangQuery = mysql_query("SELECT * FROM evangelists_list WHERE ID='$Evangelist_name' ",$connect)or die(mysql_error());
					$fetch_evangelists = mysql_fetch_array($evangQuery);
					$evang_grade = $fetch_evangelists['Grade'];
					
					$evangQuery2 = mysql_query("SELECT * FROM evangelists_list WHERE ID='$Evangelist_name2' ",$connect)or die(mysql_error());
					$fetch_evangelists2 = mysql_fetch_array($evangQuery2);
					$evang_grade2 = $fetch_evangelists2['Grade'];
					
					$evangQuery3 = mysql_query("SELECT * FROM evangelists_list WHERE ID='$Evangelist_name3' ",$connect)or die(mysql_error());
					$fetch_evangelists3 = mysql_fetch_array($evangQuery3);
					$evang_grade3 = $fetch_evangelists3['Grade'];
					
					$evangQuery4 = mysql_query("SELECT * FROM evangelists_list WHERE ID='$Evangelist_name4' ",$connect)or die(mysql_error());
					$fetch_evangelists4 = mysql_fetch_array($evangQuery4);
					$evang_grade4 = $fetch_evangelists4['Grade'];
					
					$verify_Insert = mysql_query("SELECT * FROM apdd_report WHERE zoneID='$zoneID' AND Date='$date' AND evangID='$Evangelist_name' ",$connect)or die(mysql_error());
					if(mysql_num_rows($verify_Insert)>0)
					{
						
					}
					else
					{
						$insertQuery = mysql_query("INSERT INTO apdd_report(Date,zoneID,APDD_Name,evangID,Grade,hours,waliotembelewa,vitabu,mauzo_siku,evangID_2,Grade_2,evangID_3,Grade_3,evangID_4,Grade_4) VALUES ('$date','$zoneID','$apdd_name','$Evangelist_name','$evang_grade','$hours','$vists','$books','$value_sale','$Evangelist_name2','$evang_grade2','$Evangelist_name3','$evang_grade3','$Evangelist_name4','$evang_grade4')",$connect)or die(mysql_error());	
					}
					
					View_APDD_List($confID,$zoneID,$month,$year);
					
				}
				else if(isset($_GET['view_union_summary_select']))
				{
					View_UnionSummary($confID,$_GET['year']);	
				}
				else if(isset($_POST['Save_edit_apdd_report']))
				{
					$confID = $_POST['confID'];
					$month = $_POST['month'];
					$year = $_POST['year'];
					$zoneID = $_POST['zoneID'];
					$date = $_POST['date'];
					$apdd_name = $_POST['apdd_name'];
					$Evangelist_name = $_POST['Evangelist_name'];
					$hours = $_POST['hours'];
					$vists = $_POST['vists'];
					$books = $_POST['books'];
					$recordID = $_POST['recordID'];
					
					$Evangelist_name2 = $_POST['Evangelist_name2'];
					$Evangelist_name3 = $_POST['Evangelist_name3'];
					$Evangelist_name4 = $_POST['Evangelist_name4'];
					
					$value_sale = str_replace(',','',$_POST['value_sale']);
					
					//echo $Evangelist_name2."-----";
					
					require('connection.php');
					
					
					$evangQuery = mysql_query("SELECT * FROM evangelists_list WHERE ID='$Evangelist_name' ",$connect)or die(mysql_error());
					$fetch_evangelists = mysql_fetch_array($evangQuery);
					$evang_grade = $fetch_evangelists['Grade'];
					
					$evangQuery2 = mysql_query("SELECT * FROM evangelists_list WHERE ID='$Evangelist_name2' ",$connect)or die(mysql_error());
					$fetch_evangelists2 = mysql_fetch_array($evangQuery2);
					$evang_grade2 = $fetch_evangelists2['Grade'];
					
					$evangQuery3 = mysql_query("SELECT * FROM evangelists_list WHERE ID='$Evangelist_name3' ",$connect)or die(mysql_error());
					$fetch_evangelists3 = mysql_fetch_array($evangQuery3);
					$evang_grade3 = $fetch_evangelists3['Grade'];
					
					$evangQuery4 = mysql_query("SELECT * FROM evangelists_list WHERE ID='$Evangelist_name4' ",$connect)or die(mysql_error());
					$fetch_evangelists4 = mysql_fetch_array($evangQuery4);
					$evang_grade4 = $fetch_evangelists4['Grade'];
					
					
					
					
						$updateQuery = mysql_query("UPDATE apdd_report SET APDD_Name='$apdd_name',evangID='$Evangelist_name',Grade='$evang_grade',hours='$hours',waliotembelewa='$vists',vitabu='$books',mauzo_siku='$value_sale',evangID_2='$Evangelist_name2',Grade_2='$evang_grade2',evangID_3='$Evangelist_name3',Grade_3='$evang_grade3',evangID_4='$Evangelist_name4',Grade_4='$evang_grade4'  WHERE ID='$recordID' ",$connect)or die(mysql_error());	
					
					//echo "UPDATE apdd_report SET APDD_Name='$apdd_name',evangID='$Evangelist_name',Grade='$evang_grade',hours='$hours',waliotembelewa='$vists',vitabu='$books',mauzo_siku='$value_sale',evangID_2='$Evangelist_name2',Grade_2='$evang_grade2',evangID_3='$Evangelist_name3',Grade_3='$evang_grade3',evangID_4='$Evangelist_name4',Grade_4='$evang_grade4'  WHERE ID='$recordID' ";
					
					View_APDD_List($confID,$zoneID,$month,$year);
					
				}
				else if(isset($_POST['Save_new_zone']))
				{
					$UserID = $_POST['UserID'];
                    $MarketID = $_POST['MarketID'];
					$today_order = date('Y').'-'.date('m').'-'.date('d');

                    $pickupname = $_POST['pickupname'];
                    $phone_number = $_POST['phone_number'];
                    $pickupstreet = $_POST['pickupstreet'];
                    $popularareapickup = $_POST['popularareapickup'];

                    $idreport = returnMarketPrice($MarketID);


					require('connection.php');
					
					$query = mysql_query("SELECT * FROM users_requests WHERE UserID='$UserID' AND ReqDate='$today_order'  ",$connect)or die(mysql_error());
					
					if(mysql_num_rows($query)>0)
					{
						echo "<span class='error'> You have already Made an Order Today , Please Modify it </span> ";
                        View_Conferences_List();
					}
					else
					{
						$insertQuery = mysql_query("INSERT INTO users_requests(UserID,ReqDate,ReqTime,marketID,pickupName,pickupphone,pickupstreet,pickupnearbypopulararea) VALUES('$UserID',CURDATE(),CURTIME(),'$MarketID','$pickupname','$phone_number','$pickupstreet','$popularareapickup')",$connect)or die(mysql_error());	
                        if($insertQuery)
                        {
                            $id = mysql_insert_id();
                            //Insert into the Product table
                            $productQuery = mysql_query("SELECT * FROM products ",$connect)or die(mysql_error());
                            while($fetchProd = mysql_fetch_array($productQuery))
                            {
                                $prodID = $fetchProd['ProductID'];
                                $prodVal = $_POST['productname_'.$prodID];

                                if($prodVal=='')
                                {
                                    continue;
                                }
                                else
                                {
                                    $prodprice = str_replace(',','',returnProductReportValues($prodID,$idreport,'maximum_value'))
                                    ;

                                    $InsertIntoProdReqQuery = mysql_query("INSERT INTO users_requests_items(ReqID,ProductID,Quantity,AmountPerUnit) VALUES('$id','$prodID','$prodVal','$prodprice') ",$connect)or die(mysql_error());
                                }

                            }//end while loop

                            View_Conferences_List();

                        }
                        else
                        {
                            echo "<span class='error'> Unknown Error has occured , Please Try Again </span> ";
                            AddRegisterMarket();
                        }
					}
					
					
					
				}
                else if(isset($_POST['new_market_price_report']))
                {
                    $marketID = $_POST['marketID'];
                    $Start_date = $_POST['Start_date'];
                    $end_date = $_POST['end_date'];

                    require('connection.php');
                    $verifyQuery = mysql_query("SELECT * FROM product_prices_dates WHERE MarketID='$marketID' AND Startdate='$Start_date' AND EndDate='$end_date' ",$connect)or die(mysql_error());
                    if(mysql_num_rows($verifyQuery)==0)
                    {
                    $query = mysql_query("INSERT INTO product_prices_dates(Startdate,EndDate,MarketID,DataEntryDate) VALUES('$Start_date','$end_date','$marketID',CURDATE()) ",$connect) or die(mysql_error());

                        $initalID = mysql_insert_id();
                     }
                    else
                    {
                        $fetch_initial_records = mysql_fetch_array($verifyQuery);
                        $initalID = $fetch_initial_records['ID'];
                    }

                    New_Edit_Evangelists_Reports($marketID,$initalID,$pageNum);
                }
				else if(isset($_POST['Save_new_zone_update']))
				{
					$phone_number = $_POST['phone_number'];
                    $incharge = $_POST['incharge'];
                    $Street = $_POST['Street'];
                    $region = $_POST['region'];
                    $district = $_POST['district'];
                    $market_name = $_POST['market_name'];
					$recordID = $_POST['recordID'];
					
					require('connection.php');
					
					$insertQuery = mysql_query("UPDATE markets SET MarketName='$market_name',District='$district',Region='$region',Street='$Street',Phone='$phone_number',Incharge='$incharge' WHERE ID='$recordID' ",$connect)or die(mysql_error());
					
					View_Conferences_List();
					
				}
				else if(isset($_GET['view_zone_summary_data']))
				{
					$year = date('Y');
					View_ZoneSummary($_GET['confID'],$_GET['view_zone_summary_data'],$year);
				}
				else if(isset($_POST['Save_new_evangelist_edit']))
				{
					$FirstName = $_POST['FirstName'];
					$MiddleName = $_POST['MiddleName'];
					$LastName = $_POST['LastName'];
					$Gender = $_POST['Gender'];
					$Marital_Status = $_POST['Marital_Status'];
					$Evang_grade = $_POST['Evang_grade'];
					$EducationLevel = $_POST['EducationLevel'];
					$Region = $_POST['Region'];
					$District = $_POST['District'];
					$phone_number = $_POST['phone_number'];
					$email_address	= $_POST['email_address'];
					$zoneID = $_POST['zoneID'];
					$confID = $_POST['confID'];
					$evangID = $_POST['evangID'];
					
					require('connection.php');
					
					$insertQuery = mysql_query("UPDATE  evangelists_list SET First_Name='$FirstName',Middle_Name='$MiddleName',Last_Name='$LastName',Gender='$Gender',Phone='$phone_number',Email='$email_address',Grade='$Evang_grade',Region='$Region',Districts='$District',Marital_status='$Marital_Status',Education_level='$EducationLevel' WHERE ID='$evangID' ",$connect)or die(mysql_error());
					
					View_Evangelists_list($zoneID);
					
						
				}
				
				else if(isset($_GET['new_zone_report_month_page']))
				{
					New_Edit_Evangelists_Reports($_GET['MarketID'],$_GET['initialID'],$_GET['new_zone_report_month_page']);	
				}

				else if(isset($_GET['view_conf_evangelists_report']))
				{
					$year = date('Y');
					$month = date('m')-1;
					
					View_Conference_Evangelists_Reports($_GET['view_conf_evangelists_report'],$year,$month);	
				}
				else if(isset($_POST['Save_new_evangelist']))
				{
					$FirstName = $_POST['FirstName'];
					$MiddleName = $_POST['MiddleName'];
					$LastName = $_POST['LastName'];
					$Gender = $_POST['Gender'];
					$Marital_Status = $_POST['Marital_Status'];
					$Evang_grade = $_POST['Evang_grade'];
					$EducationLevel = $_POST['EducationLevel'];
					$Region = $_POST['Region'];
					$District = $_POST['District'];
					$phone_number = $_POST['phone_number'];
					$email_address	= $_POST['email_address'];
					$zoneID = $_POST['zoneID'];
					$confID = $_POST['confID'];
					
					require('connection.php');
					
					$query_verify = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID' AND First_Name='$FirstName' AND Middle_Name='$MiddleName' AND Last_Name='$LastName' AND Gender='$Gender' AND Grade='$Evang_grade' AND Education_level='$EducationLevel' ",$connect)or die(mysql_error());
					
					if(mysql_num_rows($query_verify)>0)
					{
						
					}
					else
					{
						$insertQuery = mysql_query("INSERT INTO evangelists_list(zoneID,First_Name,Middle_Name,Last_Name,Gender,Phone,Email,Grade,Region,Districts,Marital_status,Education_level) VALUES('$zoneID','$FirstName','$MiddleName','$LastName','$Gender','$phone_number','$email_address','$Evang_grade','$Region','$District','$Marital_Status','$EducationLevel')",$connect)or die(mysql_error());
						
					}
					
					View_Evangelists_list($zoneID);
				}
				else if(isset($_GET['add_new_evangelist']))
				{
					AddEvangelistIn_zone($_GET['add_new_evangelist']);
				}
                else if(isset($_GET['delete_market']))
                {
                    $marketID = $_GET['delete_market'];

                    require('connection.php');
                    $query = mysql_query("DELETE FROM users_requests WHERE ID='$marketID' ",$connect)or die(mysql_error());

                    $query = mysql_query("DELETE FROM users_requests_items WHERE ReqID='$marketID' ",$connect)or die(mysql_error());

                    View_Conferences_List();
                    
                }
				else if(isset($_GET['edit_apdd_report']))
				{
					Edit_Report_Apdd($_GET['edit_apdd_report'],$_GET['zoneID'],$_GET['month'],$_GET['year'],$_GET['date'],$_GET['confID']);	
				}
				else if(isset($_GET['edit_zone_single']))
				{
					Edit_Zone_Details($_GET['edit_zone_single']);	
				}
				else if(isset($_GET['View_zone_single']))
				{
					View_Evangelists_list($_GET['View_zone_single']);	
				}
				else if(isset($_GET['edit_evangelist_single']))
				{
					EditEvangelistIn_zone($_GET['edit_evangelist_single'],$_GET['zoneID']);	
				}
				else if(isset($_GET['view_zone_monthly_report']))
				{
					$year = date('Y');
					$month = date('m')-1;
					
					View_Evangelists_Reports($_GET['view_zone_monthly_report'],$year,$month);	
				}
				else if(isset($_GET['view_evang_report_monthly_month']))
				{
					View_Evangelists_Reports($_GET['zoneID'],$_GET['view_evang_report_monthly_year'],$_GET['view_evang_report_monthly_month']);		
				}
				else if(isset($_GET['new_zone_report_month']))
				{
					New_Edit_Evangelists_Reports($_GET['zoneID'],$_GET['new_zone_report_year'],$_GET['new_zone_report_month'],$pageNum);	
				}
				else if(isset($_GET['new_zone_report_month_conf']))
				{
					New_Edit_Evangelists_Reports_22($_GET['new_zone_report_zone_conf'],$_GET['new_zone_report_year_conf'],$_GET['new_zone_report_month_conf'],$_GET['ConfID'],$pageNum);	
				}
                else if(isset($_GET['View_other_market_price_report']))
                {
                    View_Conference_Single($_GET['marketID'],$_GET['reportID']);
                }
				else if(isset($_GET['new_zone_report_month_page223']))
				{
					New_Edit_Evangelists_Reports_22($_GET['zoneID'],$_GET['year'],$_GET['month'],$_GET['confID'],$_GET['new_zone_report_month_page223']);	
				}

				else if(isset($_GET['view_conf_evang_report_month']))
				{
					View_Conference_Evangelists_Reports($_GET['confID'],$_GET['view_conf_evang_report_year'],$_GET['view_conf_evang_report_month']);	
				}
				else
				{
					
						View_Conferences_List();
					
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






