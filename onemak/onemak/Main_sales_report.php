<?php
session_start();
require('functions.php');
require('constants_configurations.php');
require('Excel_template_export_conferences.php');
require('datatable.php');
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
		function ValidateDelete(apl)
		{
			if(confirm("Are you sure you want to Delete - "+ apl ))
			{
				return true;
			}
			else
			{
				return false;	
			}
		}
 

		function editRow(id)
		{
			if ( 'undefined' != typeof id ) {

			$.getJSON('datatable.php?editIssue=' + id, function(obj) {
			$('#edit-id').val(obj.ID);
			$('#DateIssue').val(obj.DateIssue);
			$('#IssuedTo').val(obj.IssuedTo);
			$('#DNote').val(obj.DNote);
			$('#Description').val(obj.Description);
			$('#ToRecepientID').val(obj.ToRecepientID);
			$('#myModal_edit').modal('show')
	}).fail(function() { alert('Unable to fetch data, please try again later.') });
	} else alert('Unknown row id.');
		}

function editItems(id)
		{
			if ( 'undefined' != typeof id ) {

			$.getJSON('datatable.php?editItemIssue=' + id, function(obj) {
			$('#recordID').val(obj.ID);
			$('#Quantity').val(obj.Quantity);
			$('#UnitPrice').val(obj.UniPrice);
			$('#Description').val(obj.Description);
			$('#BookName').val(obj.BookName);
			//$('#ToRecepientID').val(obj.ToRecepientID);
			$('#myModalEditItems').modal('show')
	}).fail(function() { alert('Unable to fetch data, please try again later.') });
	} else alert('Unknown row id.');
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
					<li class="active">MAIN ABC Sales Report</li>
				</ul>
				<!-- END BREADCRUMB -->
				
				<!-- PAGE TITLE -->
				<!--div class="page-title">                    
					<h2><span class="fa fa-arrow-circle-o-left"></span> Basic Tables</h2>
				</div>-->
				<!-- END PAGE TITLE -->                
				
				<!-- PAGE CONTENT WRAPPER -->
				<?php
				
				function View_ConfSubABCStock($abcID)
				{
					require('connection.php');
					$query = mysql_query("SELECT * FROM conference_sub_abc WHERE ID='$abcID' ",$connect)or die(mysql_error());
					$fetch_details = mysql_fetch_array($query);
					$confID = $fetch_details['ConferenceID'];
				?>
				<div class="page-content-wrap">
				
					
					
					<div class="row">
						<div class="col-md-12">
							
							<!-- START DATATABLE EXPORT -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><?php echo $fetch_details['abc_name']; ?> - <?php echo return_conference_name($confID); ?> </h3>
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
								$sql = "SELECT * FROM books_list ORDER BY BookName ";
								
								require('connection.php');
								$query = mysql_query($sql,$connect)or die(mysql_error());
								?>
								<a href="?view_conferences_abs_sub=<?php echo $confID; ?>">   <b> Back </b> </a> <br><br>
								
								 <a href="#"> Sub ABC Purchases </a> | <a href="#"> Sub ABC Sales/Issues </a> | <a href='?view_sub_abc_staff=<?php echo $abcID; ?>'> <b> Sub ABC Staff </b> </a> <br><br>
								
									<table id="customers" class="table table-striped">
										<thead>
											<tr>
												<th> No </th>
												<th>Book Name</th>
												<th>Author </th>
												<th>Publisher </th>
												<th>Year </th>
												<th>Stock</th>
												<th>Selling Price</th>
												<th>Buying Price </th>
												
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										if(mysql_num_rows($query)==0)
										{
											?>
											<tr>
											<td colspan="9"> No Books List Registered </td> </tr>
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
												<td> <?php echo $fetch_conferences_lists['BookName']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Author']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Publisher']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Year_Published']; ?> </td>
												<td> <?php echo number_format($fetch_conferences_lists['xxx']); ?> </td>
												<td> <?php echo number_format($fetch_conferences_lists['SellingPrice']); ?> </td>
												<td> <?php echo number_format($fetch_conferences_lists['BuyingPrice']); ?> </td>
												
												<td>
												<div class="btn-group pull-right"> 
													<a href="#" data-toggle="dropdown" > Action </a>
														<ul class="dropdown-menu">
															<li> <a href="?View_Book_single=<?php echo $fetch_conferences_lists['ID'] ?>"> View Books Details </a> </li>
															<li> <a href="?edit_Book_single=<?php echo $fetch_conferences_lists['ID'] ?>"> Edit Book Details </a> </li>
															<li> <a href="#"> Delete Book Details </a> </li>
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
				
				function View_ConferenceStaff($confID)
				{
					
				?>
				<div class="page-content-wrap">
				
					
					
					<div class="row">
						<div class="col-md-12">
							
							<!-- START DATATABLE EXPORT -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><?php echo return_conference_name($confID); ?> MAIN ABC Publishing Staff</h3>
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
								$sql = "SELECT * FROM publishing_staffs WHERE StaffSide='Publishing' AND access_level=20 AND ConferenceID='$confID' ORDER BY FirstName,Middlename,LastName ";
								
								require('connection.php');
								$query = mysql_query($sql,$connect)or die(mysql_error());
								?>
								<a href='?View_Conference_single=<?php echo $confID; ?>'> <b> Back </b> </a> <br><br>
								<a href="?reg_new_confMain_staff=<?php echo $confID; ?>"  data-toggle="tooltip" data-placement="right" title="Click to Add/Register a New Book"><b>Register New Staff </b> </a>  <br><br>
								
									<table id="customers" class="table table-striped">
										<thead>
											<tr>
												<th> No </th>
												<th>Staff Name</th>
												<th>Gender </th>
												<th>Phone </th>
												<th>Email </th>
												<th>Address</th>
												<th>username</th>
												<th>Title </th>
												
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										if(mysql_num_rows($query)==0)
										{
											?>
											<tr>
											<td colspan="9"> No MAIN ABC Staff Registered </td> </tr>
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
												<td> <?php echo $fetch_conferences_lists['Phone']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Email']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Address']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['username']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Title']; ?> </td>
												
												<td>
												<div class="btn-group pull-right"> 
													<a href="#" data-toggle="dropdown" > Action </a>
														<ul class="dropdown-menu">
															
															<li> <a href="?edit_Unionstaff_details=<?php echo $fetch_conferences_lists['ID'] ?>"> Edit <?php echo $fetch_conferences_lists['FirstName']; ?>'s Details </a> </li>
															<li> <a href="#"> Delete Staff -  <?php echo $fetch_conferences_lists['FirstName']; ?> </a> </li>
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
				
				function View_SubABCStaff($abcID)
				{
					
				?>
				<div class="page-content-wrap">
				
					
					
					<div class="row">
						<div class="col-md-12">
							
							<!-- START DATATABLE EXPORT -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><?php echo return_sub_abc_name($abcID); ?> Sub ABC Publishing Staff</h3>
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
								$sql = "SELECT * FROM publishing_staffs WHERE StaffSide='Publishing' AND access_level=19 AND SubABCID='$abcID' ORDER BY FirstName,Middlename,LastName ";
								
								require('connection.php');
								$query = mysql_query($sql,$connect)or die(mysql_error());
								?>
								<a href='?View_sub_abc=<?php echo $abcID; ?>'> <b> Back </b> </a> <br><br>
								<a href="?reg_new_subabc_staff=<?php echo $abcID; ?>"  data-toggle="tooltip" data-placement="right" title="Click to Add/Register a New Staff"><b>Register New Staff </b> </a>  <br><br>
								
									<table id="customers" class="table table-striped">
										<thead>
											<tr>
												<th> No </th>
												<th>Staff Name</th>
												<th>Gender </th>
												<th>Phone </th>
												<th>Email </th>
												<th>Address</th>
												<th>username</th>
												<th>Title </th>
												
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										if(mysql_num_rows($query)==0)
										{
											?>
											<tr>
											<td colspan="9"> No MAIN ABC Staff Registered </td> </tr>
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
												<td> <?php echo $fetch_conferences_lists['Phone']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Email']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Address']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['username']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Title']; ?> </td>
												
												<td>
												<div class="btn-group pull-right"> 
													<a href="#" data-toggle="dropdown" > Action </a>
														<ul class="dropdown-menu">
															
															<li> <a href="?edit_Unionstaff_details=<?php echo $fetch_conferences_lists['ID'] ?>"> Edit <?php echo $fetch_conferences_lists['FirstName']; ?>'s Details </a> </li>
															<li> <a href="#"> Delete Staff -  <?php echo $fetch_conferences_lists['FirstName']; ?> </a> </li>
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
				
				
				function View_Conferences_List($confID)
				{
					if(!empty($confID))
					{
						$additionalQuery = "AND FromMainABC ='$confID' ";
					}
					else
					{
						$additionalQuery = " ";
					}
				?>
				<div class="page-content-wrap">
				
					
					
					<div class="row">
						<div class="col-md-12">
							
							<!-- START DATATABLE EXPORT -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">MAIN ABC Sales Report </h3>
									<div class="btn-group pull-right">
										<button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
										<ul class="dropdown-menu">
										   
											<li><a href="#"><img src='img/icons/xls.png' width="24"/> Excel Report </a></li>
											<li><a href="#"><img src='img/icons/xls.png' width="24"/> Excel- Sunplus </a></li>
											<li><a href="#"><img src='img/icons/word.png' width="24"/> Word</a></li>
											<li><a href="#"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
										</ul>
									</div>                                    
									
								</div>
								<div class="panel-body">
								<?php
								$sql = "SELECT * FROM mainabc_issues WHERE ID>0 $additionalQuery AND ID IN(SELECT TransID FROM mainabc_issues_items) ORDER BY DateIssue ";
								
								require('connection.php');
								$query = mysql_query($sql,$connect)or die(mysql_error());
								?>
								 <a href="#"> <b> Filter Report </b> </a>  <br><br>
								
									<table id="customers" class="table table-striped">
										<thead>
											<tr>
												<th> No </th>
												<th> MAIN ABC </th>
												<th> Date Issue </th>
												<th> Issued to </th>
												<th> D NOTE </th>
												<th> Book Name </th>
												<th> Quantity </th>
												<th> Price </th>
												<th> PRDTN- 168130 </th>
												
											</tr>
										</thead>
										<tbody>
										<?php
										if(mysql_num_rows($query)==0)
										{
											?>
											<tr>
											<td colspan="9"> No Books List Registered </td> </tr>
											</tr>
											<?php
										}	
										else
										{
											
											$num = 0;
											while($fetch_conferences_lists = mysql_fetch_array($query))
											{
												$id_s = $fetch_conferences_lists['ID'];
												$queryInside = mysql_query("SELECT * FROM mainabc_issues_items WHERE TransID='$id_s' ",$connect)or die(mysql_error());

												$number_rows = mysql_num_rows($queryInside);
												$num++;
										?>
											<tr>
												<td rowspan="<?php echo $number_rows; ?>"> <?php echo $num; ?>. </td>
												<td rowspan="<?php echo $number_rows; ?>"> <?php echo return_conference_name($fetch_conferences_lists['FromMainABC']); ?> </td>
												<td rowspan="<?php echo $number_rows; ?>"> <?php echo Date_formating($fetch_conferences_lists['DateIssue']); ?> </td>
												<td rowspan="<?php echo $number_rows; ?>">
												 <?php 
												 switch($fetch_conferences_lists['IssuedTo'])
												 {
												 	case "subABC":
												 		echo "Sub ABC-".return_sub_abc_name($fetch_conferences_lists['ToRecepientID']); 
												 		break;
												 	default:
												 		break;
												 }//end switch Statement

												 ?> 
												</td>
												<td rowspan="<?php echo $number_rows; ?>"> <?php echo $fetch_conferences_lists['DNote']; ?> </td>
												
												<?php
												while($fetch_issue_items = mysql_fetch_array($queryInside))
												{
													?>
														<td> <?php echo return_book_name($fetch_issue_items['ItemID']); ?> </td>
														<td> <?php echo $fetch_issue_items['Quantity']; ?> </td>
														<td> <?php  
														$productPrice = $fetch_issue_items['Quantity']*$fetch_issue_items['UniPrice']; 
																echo number_format($productPrice);
														?> </td>
														<td> 
															<?php

															$priceCalc = (27/55)*$productPrice;

															echo number_format($priceCalc);
															?>
														</td>
														</tr>
													<?php
												}//end Inside while loop
												?>

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
				
				
				if(isset($_GET['Save_new_book']))
				{
					
					
				}
				else
				{
					
					/*if($_SESSION['access_level']==21)
					{
						View_Conferences_List();
					}
					else if($_SESSION['access_level']==20)
					{
						ViewSingleConferenceabchhes($_SESSION['ConferenceID']);
					}
					else if($_SESSION['access_level']==19)
					{
						View_ConfSubABCStock($_SESSION['SubABCID']);
					}
					*/

					View_Conferences_List($_SESSION['ConferenceID']);
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






