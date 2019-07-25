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
			if(confirm("Are you sure you want to Delete this product" ))
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
                    <li><a href="#">Onemak</a></li>
                    <li><a href="#">Pages</a></li>
                    <li class="active">Farm Products</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE TITLE -->
                <!--div class="page-title">                    
                    <h2><span class="fa fa-arrow-circle-o-left"></span> Basic Tables</h2>
                </div>-->
                <!-- END PAGE TITLE -->                
                
                <!-- PAGE CONTENT WRAPPER -->
                <?php
				
				function View_Conference_Single($conferenceID)
				{
				?>
                <div class="page-content-wrap">
                
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Farm Products </h3>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="farm_products.xlsx"><img src='img/icons/xls.png' width="24"/> Excel </a></li>
                                            <li><a href="#"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                            <li><a href="#"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                                    </div>                                    
                                    
                                </div>
                                <div class="panel-body">
                                <?php
								$sql = "SELECT * FROM products ";
								require('connection.php');
								$query = mysql_query($sql,$connect)or die(mysql_error());
								
								ExportFarmProducts($sql);
								
								?>
                               <a href="?add_new_zone=<?php echo $conferenceID; ?>" data-toggle="tooltip" data-placement="right" title="Click to Add / Register a new Patient"><b>Register A New Product </b> </a> <!--| <a href="?view_conf_evangelists_report=<?php echo $conferenceID; ?>" data-toggle="tooltip" data-placement="bottom" title="Click to View Evangelists Reports "> <b>Evangelists Report </b></a> | <a href="#" data-toggle="modal" data-target="#myModal"><b> APDD Report </b> </a> | <a href="?view_zones_summary=<?php echo $conferenceID; ?>"data-toggle="tooltip" data-placement="bottom" title="View Conference Summary and Growth Graphs" ><b> Conference Summary </b> </a> --> <br><br>
                               
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
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                
                                    <table id="customers" class="table table-striped">
                                        <thead>
                                            <tr>
                                            	<th> No </th>
                                                <th> Product Name </th>
                                                <th> Unit of Meausure </th>
                                                <th> Description </th>
                                                
                                                
                                                <th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
										if(mysql_num_rows($query)==0)
										{
											?>
                                            <tr>
                                            <td colspan="8"> No Farm Products Registered  </td> </tr>
                                            </tr>
                                            <?php
										}	
										else
										{
											$num = 0;
											while($fetch_conferences_lists = mysql_fetch_array($query))
											{
												$num++;
												$phoneNow = $fetch_conferences_lists['Phone'];
												
										?>
                                            <tr>
                                            	<td> <?php echo $num; ?>. </td>
                                                <td> <?php echo $fetch_conferences_lists['ProductName']; ?> </td>
                                                <td> <?php echo $fetch_conferences_lists['UniMeasure']; ?></td>
                                                <td> <?php echo $fetch_conferences_lists['Description']; ?></td>
                                                
                                                <td>
                                                <div class="btn-group pull-right"> 
                                                	<a href="#" data-toggle="dropdown" > Action </a>
                                                		<ul class="dropdown-menu">
                                                			<!---<li> <a href="?View_zone_single=<?php echo $fetch_conferences_lists['ID']; ?>#"> View <?php echo $fetch_conferences_lists['Name']; ?> Details </a> </li> -->
                                                			<li> <a href="?edit_zone_single=<?php echo $fetch_conferences_lists['ProductID']; ?>"> Edit <?php echo $fetch_conferences_lists['Name']; ?> Details </a> </li>
                                                			 <li> <a href="?delete_zone_single=<?php echo $fetch_conferences_lists['ProductID']; ?>" onclick="return DeleteConfirm()"> Delete Details </a> </li>
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
                                    
                                    <!-- <button class="btn btn-default">Clear Form</button> -->                                   
                                   <!-- <button class="btn btn-primary pull-left" type="submit" name="send_sms_participants">Send SMS</button> -->
                               		
                                    </form >
                                    
                                </div>
                            </div>
                            <!-- END DATATABLE EXPORT -->                            
                            
                            
                        </div>
                    </div>

                </div>         
                <!-- END PAGE CONTENT WRAPPER -->
                <?php
				}//end function Conferences Lists
				
				function AddRegister_zone($conferenceID)
				{
					?>
                    <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                             <input type="hidden" name="confID" value="<?php echo $conferenceID ?>">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                
                                    <h3 class="panel-title">Register a new Farm Product </h3>
                                    
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <p>Please Fill the form below to Register a new farm product, All fields must be filled.</p>
                                    <a href="?View_Conference_single=<?php echo  $conferenceID; ?>"> Back </a> 
                                </div>
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Product Name:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="product_name" class="form-control" placeholder="Product Name" />
                                                    </div>                                            
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Unit of Measure:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="unit_measure" class="form-control" placeholder="Product Description" required/>
                                                    </div>                                            
                                                    
                                                </div>
                                            </div>

                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Product Description:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="product_desc" class="form-control" placeholder="Product Description" required/>
                                                    </div>                                            
                                                    
                                                </div>
                                            </div>
                                            
                                            <!--<div class="form-group">
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
                                                <label class="col-md-3 control-label">*Age:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="participant_age" class="form-control" placeholder="Participant's Age" required/>
                                                    </div>                                            
                                                    
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">                                        
                                                <label class="col-md-3 control-label"> *Place of Residence</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="ward" placeholder="Ward - Kata" required />
                                                    </div>            
                                                   <!-- <span class="help-block">Password field sample</span> 
                                                </div>
                                            </div>
                                            -->
                                        </div>
                                        <div class="col-md-6">
                                            
                                            <!--<div class="form-group">                                        
                                                <label class="col-md-3 control-label">Village (Kijiji)</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Village ( Kijiji )" name="Village">                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">                                        
                                                <label class="col-md-3 control-label"> Street ( Mtaa )</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" placeholder="Street ( Mtaa )" name="street">                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>-->
                                            
											
                                            
										
											
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <!-- <button class="btn btn-default">Clear Form</button> -->                                   
                                    <button class="btn btn-primary pull-left" type="submit" name="Save_new_zone">Save product </button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                    <?php	
				}//end function....
				if(isset($_GET['delete_zone_single'])){
				    $delete=$_GET['delete_zone_single'];
				    mysql_query("delete from products where ProductID='$delete'");
				}
				
				function Edit_Zone_Details($recordID)
				{
					require('connection.php');
					$query = mysql_query("SELECT * FROM products WHERE ProductID='$recordID'",$connect)or die(mysql_error());
					
					//echo "SELECT * FROM study_participants WHERE Phone='$recordID'";
					
					$fetch_data = mysql_fetch_array($query);
					?>
                    <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                             
                             <input type="hidden" name="recordID" value="<?php echo $recordID; ?>">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                
                                    <h3 class="panel-title">Edit products Details </h3>
                                    
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <p>Please Fill the form below to Edit Products details.</p>
                                    <a href="?View_Conference_single=<?php echo  $fetch_data['ConferenceID']; ?>"> Back </a> 
                                </div>
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Product Name:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="product_name" class="form-control" placeholder="Product Name" value="<?php echo $fetch_data['ProductName']; ?>" />
                                                    </div>                                            
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Unit of Measure:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="unit_measure" class="form-control" placeholder="Unit of Measure" value="<?php echo $fetch_data['UniMeasure']; ?>" required/>
                                                    </div>                                            
                                                    
                                                </div>
                                            </div>

                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Product Description:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" name="product_desc" class="form-control" placeholder="Product Description" value="<?php echo $fetch_data['Description']; ?>" required/>
                                                    </div>                                            
                                                    
                                                </div>
                                            </div>
                                            
                                             
                                            
                                            
                                            
                                        </div>
                                        
                                            
											
                                            
                                            
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <!-- <button class="btn btn-default">Clear Form</button> -->                                    
                                    <button class="btn btn-primary pull-left" type="submit" name="Save_new_zone_update">Update</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                    <?php	
				}
				
				
				
				
				//*****************************************PROGRAM EXECUTION************************8
				if(isset($_GET['View_Conference_single']))
				{
					View_Conference_Single($_GET['View_Conference_single']);
				}
				else if(isset($_GET['add_new_zone']))
				{
					AddRegister_zone($_GET['add_new_zone']);	
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
				else if(isset($_POST['save_monthly_report']))
				{
						$zoneID = $_POST['zoneID'];
						$month = $_POST['month'];
						$year = $_POST['year'];
						$pageNum = $_POST['pageNum'];
						
						/*echo "zone ID-".$zoneID;
						echo "Month-".$month;
						echo "Year-".$year;
						echo "confID-".$confID;*/
						
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
						
						New_Edit_Evangelists_Reports($zoneID,$year,$month,$pageNum);
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
					$product_name = $_POST['product_name'];
                    $unit_measure = $_POST['unit_measure'];
					$product_desc = $_POST['product_desc'];
					
					
					require('connection.php');
					
					$query = mysql_query("SELECT * FROM products WHERE ProductName='$product_name' ",$connect)or die(mysql_error());
					
					if(mysql_num_rows($query)>0)
					{
						
					}
					else
					{
						$insertQuery = mysql_query("INSERT INTO products(ProductName,Description,UniMeasure) VALUES('$product_name','$product_desc','$unit_measure') ",$connect)or die(mysql_error());	
					}
					
					View_Conference_Single($confID);
					
				}
				else if(isset($_POST['Save_new_zone_update']))
				{
					$recordID = $_POST['recordID'];
					$ProductName = $_POST['product_name'];
                    $unit_measure = $_POST['unit_measure'];
                    $product_desc = $_POST['product_desc'];
					
					require('connection.php');
					
					$insertQuery = mysql_query("UPDATE products SET ProductName='$ProductName',Description='$product_desc',UniMeasure='$unit_measure' WHERE ProductID='$recordID' ",$connect)or die(mysql_error());
					
					View_Conference_Single($confID);
					
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
					New_Edit_Evangelists_Reports($_GET['ZoneID'],$_GET['year'],$_GET['month'],$_GET['new_zone_report_month_page']);	
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
				else if(isset($_GET['new_zone_report_month_page223']))
				{
					New_Edit_Evangelists_Reports_22($_GET['zoneID'],$_GET['year'],$_GET['month'],$_GET['confID'],$_GET['new_zone_report_month_page223']);	
				}
				else if(isset($_POST['send_sms_participants']))
				{
					$sizeArray = count($_POST['check_participant']);
					
					if($sizeArray>0)
					{
						require('connection.php');
						require('sms_api/setting_receiving_codes.php');
						require('sms_api/sms_api.php');
						
						foreach($_POST['check_participant'] as $numbers)
						{
							SendMessage('192.168.0.100', '9710', 'admin', 'P@55w0rd', $numbers, "1.Umehudhuria kituo cha afya  hivi karibuni?\n\nA.Ndiyo\nB.Hapana");	
							
							$researchID = GetthecurrentreasearchID2($numbers);
							
							$query_update_more = mysql_query("INSERT INTO question_reply_answers(phone_number,QuestionNo,Date_sent,Time_Sent,ResearchID) VALUES ('$numbers','1',CURDATE(),CURTIME(),'$researchID' )",$connect)or die(mysql_error());								
						}//end foreach loop
					}
					
					View_Conference_Single($zoneID);
				}
				else
				{
					View_Conference_Single($zoneID);
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






