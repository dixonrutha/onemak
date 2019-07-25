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
					<li class="active">HHES, MAIN, SUB ABC</li>
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
				
				
				function View_Conferences_List()
				{
					
				?>
				<div class="page-content-wrap">
				
					
					
					<div class="row">
						<div class="col-md-12">
							
							<!-- START DATATABLE EXPORT -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Union HHES </h3>
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
								<a href="?add_new_book=1"  data-toggle="tooltip" data-placement="right" title="Click to Add/Register a New Book"><b>Register New Book </b> </a> | <a href="#"> Union HHES Purchases </a> | <a href="#"> Union HHES Sale/Issues </a> | <a href="#"> Union HHES Expenses </a> | <a href="?view_conferences_abs=1"> <b> Conference MAIN ABC's </b> </a> | <a href="?union_hhes_staff=1"> <b> Union HHES Staff </b> </a> <br><br>
								
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
				
				function View_UnionStaff()
				{
					
				?>
				<div class="page-content-wrap">
				
					
					
					<div class="row">
						<div class="col-md-12">
							
							<!-- START DATATABLE EXPORT -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Union HHES Publishing Staff</h3>
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
								$sql = "SELECT * FROM publishing_staffs WHERE StaffSide='Publishing' AND access_level=21 ORDER BY FirstName,Middlename,LastName ";
								
								require('connection.php');
								$query = mysql_query($sql,$connect)or die(mysql_error());
								?>
								<a href='?cancel_staff=1'> <b> Back </b> </a> <br><br>
								<a href="?reg_new_union_staff=1"  data-toggle="tooltip" data-placement="right" title="Click to Add/Register a New Book"><b>Register New Staff </b> </a>  <br><br>
								
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
											<td colspan="9"> No Union Staff Registered </td> </tr>
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
				
				
				function ViewSingleConferenceabchhes($confID)
				{
					
				?>
				<div class="page-content-wrap">
				
					
					
					<div class="row">
						<div class="col-md-12">
							
							<!-- START DATATABLE EXPORT -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"> <?php echo return_conference_name($confID); ?> MAIN ABC </h3>
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
								<a href="?view_conferences_abs=1"> <b> Back </b> </a> <br><br> 
							   <a href="#"> <?php echo return_conference_abbrev($confID); ?> MAIN ABC Purchases </a> | <a href="?view_main_sales_issues=<?php echo $confID; ?>" > <?php echo return_conference_abbrev($confID); ?> MAIN ABC Sales/Issues </a> | <a href="?view_conferences_abs_sub=<?php echo $confID; ?>"> <b> <?php echo strtoupper(return_conference_name($confID)); ?> Sub ABC's </b> </a> | <a href='?view_conference_staff=<?php echo $confID; ?>'> <b> <?php //echo strtoupper(return_conference_name($confID)); ?> MAIN ABC staff </b>  </a> <br><br>

								<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Select Where The Items are Issued to </h4>
	  </div>
	  <div class="modal-body">
		<p>Select to Choose Items Recipient.
		
		<div class="row">
		<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
			<input type="hidden" name="confIDs" value="<?php echo $confID; ?>">
		<div class="col-md-6">
												<div class="form-group">
												<label class="col-md-3 control-label">Issued to:</label>
												<div class="col-md-9">                                                                                            
													<select class="form-control select" name="Itemrecipient" required>
													
													<option value="">---Select Recipient---</option>
														<option value="subABC">Sub ABC</option>
														<option value="APDD">ZONE APDD</option>
														<option value="Evangelist">Evangelists</option>
														
													</select>
													
												</div>
											</div>
											
										   
											<br><br>
											 <div class="col-md-6">
											 <div class="form-group">
											 <div class="col-md-9">
											<button class="btn btn-primary pull-right" type="submit" name='ItemsIssuedToSelection'>Submit</button>
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
				
				function IssueFromMAINSubABC($confID)
				{
					
				?>
				<div class="page-content-wrap">
				
					
					
					<div class="row">
						<div class="col-md-12">
							
							<!-- START DATATABLE EXPORT -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"> Item Issues From <?php echo return_conference_name($confID); ?> MAIN ABC </h3>
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
								$sql = "SELECT * FROM mainabc_issues WHERE FromMainABC='$confID' ORDER BY DateIssue DESC ";
								
								require('connection.php');
								$query = mysql_query($sql,$connect)or die(mysql_error());
								?>
								<a href="?View_Conference_single=<?php echo $confID; ?>"> <b> Back </b> </a> <br><br> 
								<a href="#" data-toggle="modal" data-target="#myModal"> <b> New Item Sale / Issue </b> </a>  <br><br>

								<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Select Where The Items are Issued to </h4>
	  </div>
	  <div class="modal-body">
		<p>Select to Choose Items Recipient. </p>
		
		<div class="row">
		<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
		
		<input type='hidden' name='confIDs' value='<?php echo $confID; ?>' >
		
		<div class="col-md-6">
												<div class="form-group">
												<label class="col-md-3 control-label">Issued to:</label>
												<div class="col-md-9">                                                                                            
													<select class="form-control select" name="Itemrecipient" required>
													
													<option value="">---Select Recipient---</option>
														<option value="subABC">Sub ABC</option>
														<option value="APDD">ZONE APDD</option>
														<option value="Evangelist">Evangelists</option>
														
													</select>
													
												</div>
											</div>


											<br><br>
											 <div class="col-md-6">

											 <div class="form-group">
											 <div class="col-md-9">
											<button class="btn btn-primary pull-right" type="submit" name='ItemsIssuedToSelection'>Submit</button>
											</div>
											</div>
											</div>
											
		   </div>
		   
		</form> 
		
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	</div>

  </div>
</div>
</div>


<div class="modal fade" id="myModal_edit" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
	<form class="form-horizontal" id="edit-form">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
	aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="edit-modal-label">Edit selected row</h4>
	</div>
	<div class="modal-body">
	<input type="hidden" id="edit-id" value="" class="hidden">
	


	<div class="form-group">
	<label for="email" class="col-sm-2 control-label">Date of Issue</label>
	<div class="col-sm-10">
	<input type="email" class="form-control datepicker" id="DateIssue"
	name="email" placeholder="E-mail address" required>
	</div>
	</div>

	<div class="form-group">
	<label for="email" class="col-sm-2 control-label">Recipient</label>
	<div class="col-sm-10">
	<input type="text" class="form-control" id="IssuedTo"
	name="email" placeholder="E-mail address" required>
	</div>
	</div>

<div class="form-group">
	<label for="email" class="col-sm-2 control-label">Recipient Name</label>
	<div class="col-sm-10">
	<input type="text" class="form-control" id="ToRecepientID"
	name="email" placeholder="E-mail address" required>
	</div>
	</div>

	<div class="form-group">
	<label for="mobile" class="col-sm-2 control-label">D Note</label>
	<div class="col-sm-10">
	<input type="text" class="form-control" id="DNote"
	name="mobile" placeholder="Mobile" required>
	</div>
	</div>

	<div class="form-group">
	<label for="mobile" class="col-sm-2 control-label">Description</label>
	<div class="col-sm-10">
	<textarea class="form-control" id="Description"
	name="mobile" placeholder="Mobile" > </textarea>
	</div>
	</div>

	</div>
	<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	<button type="submit" class="btn btn-primary">Save changes</button>
	</div>
	</form>
	</div>
	</div>
	</div>


									<table id="customers" class="table table-striped">
										<thead>
											<tr>
												<th> No </th>
												<th> Date of Issue</th>
												<th> Recipient </th>
												<th> Recipient Name </th>
												<th> D NOTE </th>
												<th> Issue Description </th>
												<th> Total Amount</th>
												<!--<th>Buying Price </th>-->
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										if(mysql_num_rows($query)==0)
										{
											?>
											<tr>
											<td colspan="9"> No Item issues from <?php echo return_conference_name($confID); ?> </td> </tr>
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
												<td> <?php echo Date_formating($fetch_conferences_lists['DateIssue']); ?> </td>
												<td> <?php echo $fetch_conferences_lists['IssuedTo']; ?> </td>
												<td> <?php echo return_sub_abc_name($fetch_conferences_lists['ToRecepientID']); ?> </td>
												<td> <?php echo $fetch_conferences_lists['DNote']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Description']; ?> </td>
												<td> <?php echo number_format(GetTotalValueIssue($fetch_conferences_lists['ID'],'mainabc_issues_items')); ?> </td>
												<!--<td> <?php echo number_format($fetch_conferences_lists['BuyingPrice']); ?> </td> -->
												
												<td>
												<div class="btn-group pull-right"> 
													<a href="#" data-toggle="dropdown" > Action </a>
														<ul class="dropdown-menu">
															<li> <a href="?View_single_issue=<?php echo $fetch_conferences_lists['ID'] ?>"> View Item Issue  </a> </li>
															<li> <a href="#" onclick="editRow('<?php echo $fetch_conferences_lists['ID'] ?>')"> Edit Item Issue  </a> </li>
															<li> <a href="#"> Delete Item Issue </a> </li>
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
				
				
				function View_Conferences_List_abs()
				{
					
				?>
				<div class="page-content-wrap">
				
					
					
					<div class="row">
						<div class="col-md-12">
							
							<!-- START DATATABLE EXPORT -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">NTUC Conferences Lists</h3>
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
								$sql = "SELECT * FROM conferences_list ";
								Export_Conferences_lists($sql); //Codes to generate Microsoft Excel file
								require('connection.php');
								$query = mysql_query($sql,$connect)or die(mysql_error());
								?>
								<a href="?cancel=1" data-toggle="tooltip" data-placement="right" title="Click to go back to Union ABC"><b>Back </b> </a> <br><br>
								
									<table id="customers" class="table table-striped">
										<thead>
											<tr>
												<th> No </th>
												<th>Conference Name</th>
												<th>Abbreviation</th>
												<th>Publishing Director</th>
												<th>Phone </th>
												<th>Email</th>
												<th>Address</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										if(mysql_num_rows($query)==0)
										{
											?>
											<tr>
											<td colspan="6"> No Conferences Registered </td> </tr>
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
												<td> <?php echo $fetch_conferences_lists['conference_Name']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Abbreviation']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Publishing_Director']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Phone_Number']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Email_address']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Address_Box']; ?></td>
												<td>
												<div class="btn-group pull-right"> 
													<a href="#" data-toggle="dropdown" > Action </a>
														<ul class="dropdown-menu">
															<li> <a href="?View_Conference_single=<?php echo $fetch_conferences_lists['ID'] ?>"> View <?php echo $fetch_conferences_lists['Abbreviation']; ?> MAIN ABC </a> </li>
															
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
				
				
				function View_Conferences_sub_abs($confID)
				{
					
				?>
				<div class="page-content-wrap">
				
					
					
					<div class="row">
						<div class="col-md-12">
							
							<!-- START DATATABLE EXPORT -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Sub ABC's In <?php echo return_conference_name($confID); ?> </h3>
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
								$sql = "SELECT * FROM conference_sub_abc WHERE ConferenceID='$confID' ";
								//Export_Conferences_lists($sql); //Codes to generate Microsoft Excel file
								require('connection.php');
								$query = mysql_query($sql,$connect)or die(mysql_error());
								?>
								<a href="?View_Conference_single=<?php echo $confID; ?>" data-toggle="tooltip" data-placement="right" title="Click to go back to Conference ABC"><b>Back </b> </a> <br><br>
								
								<a href="?reg_new_subabc=<?php echo $confID; ?>" data-toggle="tooltip" data-placement="right" title="Click to go back to Conference ABC"><b>Register New Sub ABC </b> </a> 
								
								<br><br>
									<table id="customers" class="table table-striped">
										<thead>
											<tr>
												<th> No </th>
												<th>ABC Name</th>
												<th>ABC Code</th>
												<th>Region</th>
												<th>District</th>
												<th>S/BH Manager </th>
												<th>Phone Contact</th>
												<th>Zone</th> 
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										if(mysql_num_rows($query)==0)
										{
											?>
											<tr>
											<td colspan="8"> No Sub ABC Registered </td> </tr>
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
												<td> <?php echo $fetch_conferences_lists['abc_name']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['SubABC_Code']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Region']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['District']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Incharge']; ?> </td>
												<td> <?php echo $fetch_conferences_lists['Phone']; ?> </td>
											   <td> <?php echo ReturnZoneDetails($fetch_conferences_lists['ZoneID'],'ZoneName'); ?></td>
												<td>
												<div class="btn-group pull-right"> 
													<a href="#" data-toggle="dropdown" > Action </a>
														<ul class="dropdown-menu">
															<li> <a href="?View_sub_abc=<?php echo $fetch_conferences_lists['ID'] ?>"> View <?php echo $fetch_conferences_lists['abc_name']; ?> </a> </li>
															<li> <a href="?edit_sub_abc=<?php echo $fetch_conferences_lists['ID'] ?>"> Edit <?php echo $fetch_conferences_lists['abc_name']; ?> </a> </li>
															<li> <a href="?delete_sub_abc=<?php echo $fetch_conferences_lists['ID'] ?>"> Delete <?php echo $fetch_conferences_lists['abc_name']; ?> </a> </li>
															
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
				
				function AddRegister_Book()
				{
					?>
					<div class="page-content-wrap">
				
					<div class="row">
						<div class="col-md-12">
							
							<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							 <input type="hidden" name="confID" value="<?php echo $conferenceID ?>">
							<div class="panel panel-default">
								<div class="panel-heading">
								
									<h3 class="panel-title">Register a new Book in the List </h3>
									
									<ul class="panel-controls">
										<li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
									</ul>
								</div>
								<div class="panel-body">
									<p>Please Fill the form below to Register a new Book, All fields with a * must be filled.</p>
									<a href="?Cancel_adding_book=1"> Back </a> 
								</div>
								<div class="panel-body">                                                                        
									
									<div class="row">
										
										<div class="col-md-6">
											
											<div class="form-group">
												<label class="col-md-3 control-label">*Book Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="Book_name" class="form-control" placeholder="Book Name" required/>
													</div>                                            
													
												</div>
											</div>
											
										   <div class="form-group">
												<label class="col-md-3 control-label">*Book Author:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="Book_author" class="form-control" placeholder="Book Author" />
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label">Book Descriptions</label>
												<div class="col-md-9 col-xs-12">                                            
													<textarea class="form-control" rows="5" name="book_desc"></textarea>
													<!-- <span class="help-block">Default textarea field</span>-->
												</div>
											</div>
											
										 <div class="form-group">
												<label class="col-md-3 control-label">*Selling Price:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="selling_price" class="form-control" placeholder="Selling Price" required/>
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">                                        
												<label class="col-md-3 control-label">*Buying Price</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="buying_price" placeholder="Buying Price" required/>
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										</div>
										<div class="col-md-6">
											
										<div class="form-group">                                        
												<label class="col-md-3 control-label">Publisher</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="Publisher" placeholder="Publisher" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										 
										 <div class="form-group">                                        
												<label class="col-md-3 control-label">Year Published</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="year_published" placeholder="Year Published" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										 
											
										</div>
										
									</div>

								</div>
								<div class="panel-footer">
								   <!-- <button class="btn btn-default">Clear Form</button>          -->                          
									<button class="btn btn-primary pull-left" type="submit" name="Save_new_book">Save <span class="fa fa-floppy-o fa-right"></span> </button>
								</div>
							</div>
							</form>
							
						</div>
					</div>                    
					
				</div>
					<?php	
				}
				
				
				function RegisterUnionStaff()
				{
					?>
					<div class="page-content-wrap">
				
					<div class="row">
						<div class="col-md-12">
							
							<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							 <input type="hidden" name="confID" value="<?php echo $conferenceID ?>">
							<div class="panel panel-default">
								<div class="panel-heading">
								
									<h3 class="panel-title">Register a new Union Publishing Staff </h3>
									
									<ul class="panel-controls">
										<li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
									</ul>
								</div>
								<div class="panel-body">
									<p>Please Fill the form below to Register a Union Publishing Staff, All fields with a * must be filled.</p>
									<a href="?union_hhes_staff=1"> Back </a> 
								</div>
								<div class="panel-body">                                                                        
									
									<div class="row">
										
										<div class="col-md-6">
											
											<div class="form-group">
												<label class="col-md-3 control-label">*First Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="fname" class="form-control" placeholder="Staff first name" required/>
													</div>                                            
													
												</div>
											</div>
											
										   <div class="form-group">
												<label class="col-md-3 control-label">Middle Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="mname" class="form-control" placeholder="Staff middle name" />
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label">*Last Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="lname" class="form-control" placeholder="Staff last name" required/>
													</div>                                            
													
												</div>
											</div>
											
										<div class="form-group">
												<label class="col-md-3 control-label">Gender:</label>
												<div class="col-md-9">                                                           
													<select class="form-control select" name="Gender" required>
														<option value=""> ---------- Select Gender ---------- </option>
														<option value="Male"> Male </option>
														<option value="Female"> Female </option>
													</select>
													
												</div>
											</div>    
										
										<div class="form-group">
												<label class="col-md-3 control-label">Address:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="Address" class="form-control" placeholder="Staff Address" />
													</div>                                            
													
												</div>
											</div>
										
										 <div class="form-group">
												<label class="col-md-3 control-label">Phone:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="Phone" class="form-control" placeholder="Staff Phone Number" />
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">                                        
												<label class="col-md-3 control-label">Email:</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="Email" placeholder="Staff Email Address" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										</div>
										<div class="col-md-6">
											
										<div class="form-group">                                        
												<label class="col-md-3 control-label">Title</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="Title" placeholder="Staff Title" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										 
										 <div class="form-group">                                        
												<label class="col-md-3 control-label">Login Username</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="username" placeholder="Staff Login Username" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										 
											
										</div>
										
									</div>

								</div>
								<div class="panel-footer">
								   <!-- <button class="btn btn-default">Clear Form</button>          -->                          
									<button class="btn btn-primary pull-left" type="submit" name="Save_new_publishing_staff">Save <span class="fa fa-floppy-o fa-right"></span> </button>
								</div>
							</div>
							</form>
							
						</div>
					</div>                    
					
				</div>
					<?php	
				}
				
				function InitialIssues_Details($recipient,$confID)
				{
					require('connection.php');
					?>
					<div class="page-content-wrap">
				
					<div class="row">
						<div class="col-md-12">
							
							<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							 <input type="hidden" name="confID" value="<?php echo $confID; ?>">
							<div class="panel panel-default">
								<div class="panel-heading">
								
									<h3 class="panel-title"> New Items Issues from <?php echo return_conference_name($confID); ?> </h3>
									
									<ul class="panel-controls">
										<li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
									</ul>
								</div>
								<div class="panel-body">
									<p>Please Fill the form below to Register a Union Publishing Staff, All fields with a * must be filled.</p>
									<a href="?view_main_sales_issues=<?php echo $confID; ?>"> Back </a> 
								</div>
								<div class="panel-body">                                                                        
									
									<div class="row">
										
										<div class="col-md-6">
										
										<?php
										switch($recipient)
										{
											case "subABC":
												?>
												<input type="hidden" name='recepientType' value="subABC">
												<div class="form-group">
												<label class="col-md-3 control-label">Sub ABC:</label>
												<div class="col-md-9">                                                           
													<select class="form-control select" name="issuedID" required>
														<option value=""> ---------- Select Sub ABC ---------- </option>
														<?php
														$querySubABC = mysql_query("SELECT * FROM conference_sub_abc WHERE ConferenceID='$confID' ",$connect)or die(mysql_error());
														if(mysql_num_rows($querySubABC)>0)
														{
															while($fetchABC = mysql_fetch_array($querySubABC))
															{
																?>
																<option value='<?php echo $fetchABC['ID']; ?>'> <?php echo $fetchABC['abc_name']; ?> </option>
																<?php
															}//end while loop
														}
														?>
													</select>
													
												</div>
											</div> 
												<?php
												break;
										}//end switch statement
										?>
										
											
											
											<div class="form-group">
												<label class="col-md-3 control-label">*Date of Issue:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="dateIssue" class="form-control datepicker" placeholder="Date of Issue" required/>
													</div>                                            
													
												</div>
											</div>
											
										   <div class="form-group">
												<label class="col-md-3 control-label">D NOTE:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="d_note" class="form-control" placeholder="Issue D NOTE" />
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label">Issue Descriptions</label>
												<div class="col-md-9 col-xs-12">                                            
													<textarea class="form-control" rows="5" name="issueDescription"><?php echo $fetch_book['Book_Description']; ?></textarea>
													<!-- <span class="help-block">Default textarea field</span>-->
												</div>
											</div>
											
										<!--
										<div class="form-group">
												<label class="col-md-3 control-label">Address:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="Address" class="form-control" placeholder="Staff Address" />
													</div>                                            
													
												</div>
											</div>
										
										 <div class="form-group">
												<label class="col-md-3 control-label">Phone:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="Phone" class="form-control" placeholder="Staff Phone Number" />
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">                                        
												<label class="col-md-3 control-label">Email:</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="Email" placeholder="Staff Email Address" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> 
												</div>
											</div>-->
											
										</div>
										<div class="col-md-6">
											
										
											
										</div>
										
									</div>

								</div>
								<div class="panel-footer">
								   <!-- <button class="btn btn-default">Clear Form</button>          -->                          
									<button class="btn btn-primary pull-left" type="submit" name="Save_new_conf_issue">Next <span class="fa fa-floppy-o fa-right"></span> </button>
								</div>
							</div>
							</form>
							
						</div>
					</div>                    
					
				</div>
					<?php	
					mysql_close($connect);
				}//end function mysql close
				

				function View_Single_Conf_Issue($IssueID)
				{
					require('connection.php');
					$querySelect = mysql_query("SELECT * FROM mainabc_issues WHERE ID='$IssueID' ",$connect)or die(mysql_error());
					$fetch_Issue_details = mysql_fetch_array($querySelect);
					$confID = $fetch_Issue_details['FromMainABC'];
				?>
				<div class="page-content-wrap">
				
					<div class="row">
						<div class="col-md-12">
							
							<!-- START DATATABLE EXPORT -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"> Book items issue/Sales from <?php echo return_conference_name($confID); ?> </h3>
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
								$sql = "SELECT * FROM mainabc_issues_items WHERE TransID='$IssueID' ";
								
								require('connection.php');
								$query = mysql_query($sql,$connect)or die(mysql_error());
								?>

								<a href="?view_main_sales_issues=<?php echo $confID; ?>"> <b> Back </b> </a> <br><br>

								<table>
									<tr> <td> <b>Date of Issue:</b> </td> <td> &nbsp;&nbsp; <?php echo Date_formating($fetch_Issue_details['DateIssue']); ?> </td> </tr>

									<tr> <td> <b> Issued To:</b> </td> <td> &nbsp;&nbsp; 


										<?php 
										switch($fetch_Issue_details['IssuedTo'])
										{
											case "subABC":
											echo "Sub ABC - ".return_sub_abc_name($fetch_Issue_details['ToRecepientID']); 
											break;

											default:
											break;
										}
										?> 

									</td> </tr>

									<tr> <td> <b> D Note: </b> </td> <td> &nbsp;&nbsp; <?php echo $fetch_Issue_details['DNote']; ?> </td> </tr>

									<tr> <td> <b> Issue Description: </b> </td> <td> &nbsp;&nbsp; <?php echo $fetch_Issue_details['Description']; ?> </td> </tr>

								</table> <br> <br>

								<div class="modal fade" id="myModalAddItems" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
	<form class="form-horizontal" id="additemsIssueForm" method="post" action="<?php echo $_SERVER[PHP_SELF]; ?>">
		<input type="hidden" name="IssueID" value="<?php echo $IssueID; ?>">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
	aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="edit-modal-label"> Add Book / Item In the List  </h4>
	</div>
	<div class="modal-body">
	<input type="hidden" id="edit-id" value="" class="hidden">
	


	<div class="form-group">
	<label for="email" class="col-sm-2 control-label">Book/Item</label>
	<div class="col-sm-10">
	<select class="form-control" id="bookItem" name="bookItem" required>
	<option value="">----------Select Book Item -------</option>
	<?php
		$queryBooks = mysql_query("SELECT * FROM  books_list ORDER BY BookName ",$connect)or die(mysql_error());
		if(mysql_num_rows($queryBooks)>0)
		{
			while($fetchBooks = mysql_fetch_array($queryBooks))
			{
				?>
				<option value="<?php echo $fetchBooks['ID'] ?>"> <?php echo $fetchBooks['BookName']; ?> </option>
				<?php
			}
		}
	?>
	</select>
	</div>
	</div>

	<div class="form-group">
	<label for="email" class="col-sm-2 control-label">Quantity</label>
	<div class="col-sm-10">
	<input type="text" class="form-control" id="IssuedTo"
	name="Quantity" placeholder="Quantity" required>
	</div>
	</div>

<div class="form-group">
	<label for="email" class="col-sm-2 control-label">Unit Price</label>
	<div class="col-sm-10">
	<input type="text" class="form-control" id="ToRecepientID"
	name="UnitPrice" placeholder="Unit price" required>
	</div>
	</div>

	

	<div class="form-group">
	<label for="mobile" class="col-sm-2 control-label">Description</label>
	<div class="col-sm-10">
	<textarea class="form-control" id="Description2"
	name="Description" placeholder="" > </textarea>
	</div>
	</div>

	</div>
	<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	<button type="submit" name='Save_Item_Issue_Request' class="btn btn-primary">Save changes</button>
	</div>
	</form>
	</div>
	</div>
	</div>


<!-- Modal for editinf Issue Items-->
<div class="modal fade" id="myModalEditItems" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
	<form class="form-horizontal" id="additemsIssueForm" method="post" action="<?php echo $_SERVER[PHP_SELF]; ?>">
		<input type="hidden" name="IssueID" value="<?php echo $IssueID; ?>">
		<input type="hidden" name="recordID" id="recordID">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
	aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="edit-modal-label"> Edit Item in the List </h4>
	</div>
	<div class="modal-body">
	<input type="hidden" id="edit-id" value="" class="hidden">
	


	<div class="form-group">
	<label for="email" class="col-sm-2 control-label">Book Name</label>
	<div class="col-sm-10">
	<input type="text" class="form-control" id="BookName"
	name="bookName" placeholder="Book Name" disabled>
	</div>
	</div>

	<div class="form-group">
	<label for="email" class="col-sm-2 control-label">Quantity</label>
	<div class="col-sm-10">
	<input type="text" class="form-control" id="Quantity"
	name="Quantity" placeholder="Quantity" required>
	</div>
	</div>

<div class="form-group">
	<label for="email" class="col-sm-2 control-label">Unit Price</label>
	<div class="col-sm-10">
	<input type="text" class="form-control" id="UnitPrice"
	name="UnitPrice" placeholder="Unit price" required>
	</div>
	</div>

	

	<div class="form-group">
	<label for="mobile" class="col-sm-2 control-label">Description</label>
	<div class="col-sm-10">
	<textarea class="form-control" id="Description"
	name="Description" placeholder="" > </textarea>
	</div>
	</div>

	</div>
	<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	<button type="submit" name='Save_Item_Issue_Request_edit' class="btn btn-primary">Update changes</button>
	</div>
	</form>
	</div>
	</div>
	</div>
<!-- End Modal for editing Issue items-->

								<a href="#"  data-toggle="modal" data-target="#myModalAddItems"><b>Add More Item </b> </a> <br><br>
								
									<table id="customers" class="table table-striped">
										<thead>
											<tr>
												<th> No </th>
												<th>Book / Item Name</th>
												<th>Quantity / Copies</th>
												<th>Unit Price </th>
												<th>Total Price </th>
												<th>Description</th>
												<!--<th>Selling Price</th>
												<th>Buying Price </th>-->
												
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										if(mysql_num_rows($query)==0)
										{
											?>
											<tr>
											<td colspan="9"> No Books List Registered in the list </td> </tr>
											</tr>
											<?php
										}	
										else
										{
											
											$num = 0;
											$sumtotalprice = 0;
											while($fetch_conferences_lists = mysql_fetch_array($query))
											{
												$num++;
										?>
											<tr>
												<td> <?php echo $num; ?>. </td>
												<td> <?php 
												$bookNameR = return_book_name($fetch_conferences_lists['ItemID']);

												echo $bookNameR; ?> </td>
												<td> <?php echo number_format($fetch_conferences_lists['Quantity']); ?> </td>
												<td> <?php echo number_format($fetch_conferences_lists['UniPrice']); ?> </td>
												<td> <?php 
														$product_total_price = $fetch_conferences_lists['UniPrice']*$fetch_conferences_lists['Quantity'];

												echo number_format($product_total_price); 
												$sumtotalprice = $sumtotalprice + $product_total_price;

												?> </td>
												<td> <?php echo $fetch_conferences_lists['Description']; ?> </td>
												<!--<td> <?php echo number_format($fetch_conferences_lists['SellingPrice']); ?> </td>
												<td> <?php echo number_format($fetch_conferences_lists['BuyingPrice']); ?> </td>-->
												
												<td>
												<div class="btn-group pull-right"> 
													<a href="#" data-toggle="dropdown" > Action </a>
														<ul class="dropdown-menu">
															
															<li> <a onclick="editItems('<?php echo $fetch_conferences_lists[ID] ?>')" href="#"> Edit / Modify Item </a> </li>
															<li> <a onclick="return ValidateDelete('Book Named - <?php echo $bookNameR; ?> from the List')" 
																href="?delete_item_from_Isue=<?php echo $fetch_conferences_lists['ID']; ?>&IssueID=<?php echo $IssueID; ?>"> Delete / Remove Item </a> </li>
														</ul>
												 </div>
												 </td>
											</tr>
										  <?php
											}
											?>
											<tr>
												<th colspan="4"> TOTAL ITEM(S) PRICE</th> <th> <?php echo number_format($sumtotalprice); ?> </th> <th colspan="2"> </th></tr>
											
											<?php
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
				

				
				function EditUnionStaff($staffID)
				{
					require('connection.php');
					$query = mysql_query("SELECT * FROM publishing_staffs WHERE ID='$staffID' ",$connect)or die(mysql_error());
					$fetch_staff_data = mysql_fetch_array($query);
					?>
					<div class="page-content-wrap">
				
					<div class="row">
						<div class="col-md-12">
							
							<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							 <input type="hidden" name="staffID" value="<?php echo $staffID ?>">
							<div class="panel panel-default">
								<div class="panel-heading">
								
									<h3 class="panel-title">Edit Union Publishing Staff Details</h3>
									
									<ul class="panel-controls">
										<li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
									</ul>
								</div>
								<div class="panel-body">
									<p>Please Fill the form below to Edit a Union Publishing Staff details, All fields with a * must be filled.</p>
									<a href="?union_hhes_staff=1"> Back </a> 
								</div>
								<div class="panel-body">                                                                        
									
									<div class="row">
										
										<div class="col-md-6">
											
											<div class="form-group">
												<label class="col-md-3 control-label">*First Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="fname" class="form-control" placeholder="Staff first name" value='<?php echo $fetch_staff_data['FirstName']; ?>' required/>
													</div>                                            
													
												</div>
											</div>
											
										   <div class="form-group">
												<label class="col-md-3 control-label">Middle Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="mname" class="form-control" placeholder="Staff middle name" value='<?php echo $fetch_staff_data['Middlename']; ?>' />
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label">*Last Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="lname" class="form-control" placeholder="Staff last name" value='<?php echo $fetch_staff_data['LastName']; ?>' required/>
													</div>                                            
													
												</div>
											</div>
											
										<div class="form-group">
												<label class="col-md-3 control-label">Gender:</label>
												<div class="col-md-9">                                                           
													<select class="form-control select" name="Gender" required>
													<option value="<?php echo $fetch_staff_data['Gender']; ?>"> <?php echo $fetch_staff_data['Gender']; ?> </option>
														<option value=""> ---------- Select Gender ---------- </option>
														<option value="Male"> Male </option>
														<option value="Female"> Female </option>
													</select>
													
												</div>
											</div>    
										
										<div class="form-group">
												<label class="col-md-3 control-label">Address:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="Address" class="form-control" placeholder="Staff Address" value='<?php echo $fetch_staff_data['Address']; ?>' />
													</div>                                            
													
												</div>
											</div>
										
										 <div class="form-group">
												<label class="col-md-3 control-label">Phone:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="Phone" class="form-control" placeholder="Staff Phone Number" value='<?php echo $fetch_staff_data['Phone']; ?>' />
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">                                        
												<label class="col-md-3 control-label">Email:</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="Email" placeholder="Staff Email Address" value='<?php echo $fetch_staff_data['Email']; ?>' />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										</div>
										<div class="col-md-6">
											
										<div class="form-group">                                        
												<label class="col-md-3 control-label">Title</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="Title" placeholder="Staff Title" value='<?php echo $fetch_staff_data['Title']; ?>' />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										 
										 <div class="form-group">                                        
												<label class="col-md-3 control-label">Login Username</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="username" placeholder="Staff Login Username" value='<?php echo $fetch_staff_data['username']; ?>' />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										 
											
										</div>
										
									</div>

								</div>
								<div class="panel-footer">
								   <!-- <button class="btn btn-default">Clear Form</button>          -->                          
									<button class="btn btn-primary pull-left" type="submit" name="Save_new_publishing_staff_update">Update <span class="fa fa-floppy-o fa-right"></span> </button>
								</div>
							</div>
							</form>
							
						</div>
					</div>                    
					
				</div>
					<?php	
				}
				
				
				function RegisterSubABCStaff($abcID)
				{
					?>
					<div class="page-content-wrap">
				
					<div class="row">
						<div class="col-md-12">
							
							<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							 <input type="hidden" name="abcID" value="<?php echo $abcID; ?>">
							<div class="panel panel-default">
								<div class="panel-heading">
								
									<h3 class="panel-title">Register a new '<?php echo return_sub_abc_name($abcID); ?>' Publishing Staff </h3>
									
									<ul class="panel-controls">
										<li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
									</ul>
								</div>
								<div class="panel-body">
									<p>Please Fill the form below to Register a Sub ABC Publishing Staff, All fields with a * must be filled.</p>
									<a href="?view_sub_abc_staff=<?php echo $abcID; ?>"> Back </a> 
								</div>
								<div class="panel-body">                                                                        
									
									<div class="row">
										
										<div class="col-md-6">
											
											<div class="form-group">
												<label class="col-md-3 control-label">*First Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="fname" class="form-control" placeholder="Staff first name" required/>
													</div>                                            
													
												</div>
											</div>
											
										   <div class="form-group">
												<label class="col-md-3 control-label">Middle Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="mname" class="form-control" placeholder="Staff middle name" />
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label">*Last Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="lname" class="form-control" placeholder="Staff last name" required/>
													</div>                                            
													
												</div>
											</div>
											
										<div class="form-group">
												<label class="col-md-3 control-label">Gender:</label>
												<div class="col-md-9">                                                           
													<select class="form-control select" name="Gender" required>
														<option value=""> ---------- Select Gender ---------- </option>
														<option value="Male"> Male </option>
														<option value="Female"> Female </option>
													</select>
													
												</div>
											</div>    
										
										<div class="form-group">
												<label class="col-md-3 control-label">Address:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="Address" class="form-control" placeholder="Staff Address" />
													</div>                                            
													
												</div>
											</div>
										
										 <div class="form-group">
												<label class="col-md-3 control-label">Phone:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="Phone" class="form-control" placeholder="Staff Phone Number" />
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">                                        
												<label class="col-md-3 control-label">Email:</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="Email" placeholder="Staff Email Address" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										</div>
										<div class="col-md-6">
											
										<div class="form-group">                                        
												<label class="col-md-3 control-label">Title</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="Title" placeholder="Staff Title" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										 
										 <div class="form-group">                                        
												<label class="col-md-3 control-label">Login Username</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="username" placeholder="Staff Login Username" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										 
											
										</div>
										
									</div>

								</div>
								<div class="panel-footer">
								   <!-- <button class="btn btn-default">Clear Form</button>          -->                          
									<button class="btn btn-primary pull-left" type="submit" name="Save_new_subABC_publishing_staff">Save <span class="fa fa-floppy-o fa-right"></span> </button>
								</div>
							</div>
							</form>
							
						</div>
					</div>                    
					
				</div>
					<?php	
				}
				
				
				
				function RegisterConferenceMainStaff($confID)
				{
					?>
					<div class="page-content-wrap">
				
					<div class="row">
						<div class="col-md-12">
							
							<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							 <input type="hidden" name="confID" value="<?php echo $confID; ?>">
							<div class="panel panel-default">
								<div class="panel-heading">
								
									<h3 class="panel-title">Register a new '<?php echo return_conference_name($confID); ?>' MAIN ABC Publishing Staff </h3>
									
									<ul class="panel-controls">
										<li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
									</ul>
								</div>
								<div class="panel-body">
									<p>Please Fill the form below to Register a MAIN ABC Publishing Staff, All fields with a * must be filled.</p>
									<a href="?union_hhes_staff=1"> Back </a> 
								</div>
								<div class="panel-body">                                                                        
									
									<div class="row">
										
										<div class="col-md-6">
											
											<div class="form-group">
												<label class="col-md-3 control-label">*First Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="fname" class="form-control" placeholder="Staff first name" required/>
													</div>                                            
													
												</div>
											</div>
											
										   <div class="form-group">
												<label class="col-md-3 control-label">Middle Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="mname" class="form-control" placeholder="Staff middle name" />
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label">*Last Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="lname" class="form-control" placeholder="Staff last name" required/>
													</div>                                            
													
												</div>
											</div>
											
										<div class="form-group">
												<label class="col-md-3 control-label">Gender:</label>
												<div class="col-md-9">                                                           
													<select class="form-control select" name="Gender" required>
														<option value=""> ---------- Select Gender ---------- </option>
														<option value="Male"> Male </option>
														<option value="Female"> Female </option>
													</select>
													
												</div>
											</div>    
										
										<div class="form-group">
												<label class="col-md-3 control-label">Address:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="Address" class="form-control" placeholder="Staff Address" />
													</div>                                            
													
												</div>
											</div>
										
										 <div class="form-group">
												<label class="col-md-3 control-label">Phone:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="Phone" class="form-control" placeholder="Staff Phone Number" />
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">                                        
												<label class="col-md-3 control-label">Email:</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="Email" placeholder="Staff Email Address" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										</div>
										<div class="col-md-6">
											
										<div class="form-group">                                        
												<label class="col-md-3 control-label">Title</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="Title" placeholder="Staff Title" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										 
										 <div class="form-group">                                        
												<label class="col-md-3 control-label">Login Username</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="username" placeholder="Staff Login Username" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										 
											
										</div>
										
									</div>

								</div>
								<div class="panel-footer">
								   <!-- <button class="btn btn-default">Clear Form</button>          -->                          
									<button class="btn btn-primary pull-left" type="submit" name="Save_new_main_publishing_staff">Save <span class="fa fa-floppy-o fa-right"></span> </button>
								</div>
							</div>
							</form>
							
						</div>
					</div>                    
					
				</div>
					<?php	
				}
				
				function edit_books($bookID)
				{
					require('connection.php');
					$query = mysql_query("SELECT * FROM books_list WHERE ID='$bookID' ",$connect)or die(mysql_error());
					$fetch_book = mysql_fetch_array($query);
					?>
					<div class="page-content-wrap">
				
					<div class="row">
						<div class="col-md-12">
							
							<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							 <input type="hidden" name="bookID" value="<?php echo $bookID ?>">
							<div class="panel panel-default">
								<div class="panel-heading">
								
									<h3 class="panel-title">Edit Book Details </h3>
									
									<ul class="panel-controls">
										<li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
									</ul>
								</div>
								<div class="panel-body">
									<p>Please Fill the form below to edit book details , All fields with a * must be filled.</p>
									<a href="?Cancel_adding_book=1"> Back </a> 
								</div>
								<div class="panel-body">                                                                        
									
									<div class="row">
										
										<div class="col-md-6">
											
											<div class="form-group">
												<label class="col-md-3 control-label">*Book Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="Book_name" class="form-control" placeholder="Book Name" value="<?php echo $fetch_book['BookName']; ?>" required/>
													</div>                                            
													
												</div>
											</div>
											
										   <div class="form-group">
												<label class="col-md-3 control-label">*Book Author:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="Book_author" class="form-control" placeholder="Book Author" value="<?php echo $fetch_book['Author']; ?>" />
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label">Book Descriptions</label>
												<div class="col-md-9 col-xs-12">                                            
													<textarea class="form-control" rows="5" name="book_desc"><?php echo $fetch_book['Book_Description']; ?></textarea>
													<!-- <span class="help-block">Default textarea field</span>-->
												</div>
											</div>
											
										 <div class="form-group">
												<label class="col-md-3 control-label">*Selling Price:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="selling_price" class="form-control" placeholder="Selling Price" value="<?php echo $fetch_book['SellingPrice']; ?>"
														 required/>
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">                                        
												<label class="col-md-3 control-label">*Buying Price</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="buying_price" placeholder="Buying Price" value="<?php echo $fetch_book['BuyingPrice']; ?>" required/>
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										</div>
										<div class="col-md-6">
											
										<div class="form-group">                                        
												<label class="col-md-3 control-label">Publisher</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="Publisher" placeholder="Publisher" value="<?php echo $fetch_book['Publisher']; ?>" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										 
										 <div class="form-group">                                        
												<label class="col-md-3 control-label">Year Published</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="year_published" placeholder="Year Published" value="<?php echo $fetch_book['Year_Published']; ?>" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										 
											
										</div>
										
									</div>

								</div>
								<div class="panel-footer">
								   <!-- <button class="btn btn-default">Clear Form</button>          -->                          
									<button class="btn btn-primary pull-left" type="submit" name="Save_new_book_edit">Save <span class="fa fa-floppy-o fa-right"></span> </button>
								</div>
							</div>
							</form>
							
						</div>
					</div>                    
					
				</div>
					<?php	
				}
				
				
				function RegNewSubABC($confID)
				{
					?>
					<div class="page-content-wrap">
				
					<div class="row">
						<div class="col-md-12">
							
							<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							 <input type="hidden" name="confID" value="<?php echo $confID; ?>">
							<div class="panel panel-default">
								<div class="panel-heading">
								
									<h3 class="panel-title">Register a new sub ABC in <?php echo return_conference_name($confID); ?> </h3>
									
									<ul class="panel-controls">
										<li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
									</ul>
								</div>
								<div class="panel-body">
									<p>Please Fill the form below to Register a new sub ABC , All fields with a * must be filled.</p>
									<a href="?view_conferences_abs_sub=<?php echo $confID; ?>"> Back </a> 
								</div>
								<div class="panel-body">                                                                        
									
									<div class="row">
										
										<div class="col-md-6">
											
											<div class="form-group">
												<label class="col-md-3 control-label">*Conference Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="Book_name" value='<?php echo return_conference_name($confID); ?>' class="form-control" placeholder="Book Name" disabled/>
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label">Zone:</label>
												<div class="col-md-9">                                                           
													<select class="form-control select" name="subabc_zone" required>
														<option value=""> ---------- Select Zone ---------- </option>
														
													   <?php
													   require('connection.php');
													   $query = mysql_query("SELECT * FROM zones_lists WHERE ConferenceID='$confID' ",$connect)or die(mysql_error());
													   if(mysql_num_rows($query)>0)
													   {
															while($fetch_zones = mysql_fetch_array($query))
															{
																?>
																<option value="<?php echo $fetch_zones['ID']; ?>"> <?php echo $fetch_zones['ZoneName']; ?> </option>
																<?php
															}//end while loop
													   }
													   
													   ?>
														
													</select>
													
												</div>
											</div>
											
										   <div class="form-group">
												<label class="col-md-3 control-label">*ABC Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="abc_name" class="form-control" placeholder="Sub ABC Name " />
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label">*ABC Code:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="abc_code" class="form-control" placeholder="Sub ABC Code e.g  INSAMES01 
" />
													</div>                                            
													
												</div>
											</div>
											
											
											<div class="form-group">
												<label class="col-md-3 control-label">ABC Descriptions</label>
												<div class="col-md-9 col-xs-12">                                            
													<textarea class="form-control" rows="5" name="abc_descriptions"></textarea>
													<!-- <span class="help-block">Default textarea field</span>-->
												</div>
											</div>
											
										
											
										   
											
										</div>
										<div class="col-md-6">
										
										 <div class="form-group">
												<label class="col-md-3 control-label">*S/BH Manager:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="inCharge" class="form-control" placeholder="S/BH Manager" required/>
													</div>                                            
													
												</div>
											</div>
										
										 <div class="form-group">                                        
												<label class="col-md-3 control-label">Manager Phone</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="phoneContacts" placeholder="S/BH Manager Phone" required/>
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
										
										<div class="form-group">                                        
												<label class="col-md-3 control-label">Region</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="Region" placeholder="ABC Location (Region)" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										 
										 <div class="form-group">                                        
												<label class="col-md-3 control-label">District</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="District" placeholder="ABC Location (District)" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										 
											
										</div>
										
									</div>

								</div>
								<div class="panel-footer">
								   <!-- <button class="btn btn-default">Clear Form</button>          -->                          
									<button class="btn btn-primary pull-left" type="submit" name="Save_new_sub_abc">Save <span class="fa fa-floppy-o fa-right"></span> </button>
								</div>
							</div>
							</form>
							
						</div>
					</div>                    
					
				</div>
					<?php	
				}
				
				function EditsubABCInfo($recordID)
				{
					require('connection.php');
					$queryView = mysql_query("SELECT * FROM conference_sub_abc WHERE ID='$recordID' ",$connect)or die(mysql_error());
					$fetchrecord = mysql_fetch_array($queryView);
					
					$confID = $fetchrecord['ConferenceID'];
					
					?>
					<div class="page-content-wrap">
				
					<div class="row">
						<div class="col-md-12">
							
							<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							 <input type="hidden" name="recordID" value="<?php echo $recordID; ?>">
							 <input type="hidden" name="confID" value="<?php echo $confID; ?>">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
								
									<h3 class="panel-title">Edit sub ABC in <?php echo return_conference_name($confID); ?> </h3>
									
									<ul class="panel-controls">
										<li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
									</ul>
								</div>
								<div class="panel-body">
									<p>Please Fill the form below to Edit a sub ABC , All fields with a * must be filled.</p>
									<a href="?view_conferences_abs_sub=<?php echo $confID; ?>"> Back </a> 
								</div>
								<div class="panel-body">                                                                        
									
									<div class="row">
										
										<div class="col-md-6">
											
											<div class="form-group">
												<label class="col-md-3 control-label">*Conference Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="Book_name" value='<?php echo return_conference_name($confID); ?>' class="form-control" placeholder="Book Name" disabled/>
													</div>                                            
													
												</div>
											</div>
										   
										   
										  <div class="form-group">
												<label class="col-md-3 control-label">Zone:</label>
												<div class="col-md-9">                                                           
													<select class="form-control select" name="subabc_zone" required>
													 <option value="<?php echo $fetchrecord['ZoneID']; ?>"> <?php echo ReturnZoneDetails($fetchrecord['ZoneID'],'ZoneName'); ?> </option>
														<option value=""> ---------- Select Zone ---------- </option>
														
													   <?php
													   require('connection.php');
													   $query = mysql_query("SELECT * FROM zones_lists WHERE ConferenceID='$confID' ",$connect)or die(mysql_error());
													   if(mysql_num_rows($query)>0)
													   {
															while($fetch_zones = mysql_fetch_array($query))
															{
																?>
																<option value="<?php echo $fetch_zones['ID']; ?>"> <?php echo $fetch_zones['ZoneName']; ?> </option>
																<?php
															}//end while loop
													   }
													   
													   ?>
														
													</select>
													
												</div>
											</div>
											
										   
										   <div class="form-group">
												<label class="col-md-3 control-label">*ABC Name:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="abc_name" class="form-control" placeholder="Sub ABC (HHES) Name " value="<?php echo $fetchrecord['abc_name']; ?>" />
													</div>                                            
													
												</div>
											</div>
										   
											<div class="form-group">
												<label class="col-md-3 control-label">*ABC Code:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="abc_code" class="form-control" placeholder="Sub ABC Code e.g  INSAMES01" value="<?php echo $fetchrecord['SubABC_Code']; ?>" />
													</div>                                            
													
												</div>
											</div>
										   
											<div class="form-group">
												<label class="col-md-3 control-label">ABC Descriptions</label>
												<div class="col-md-9 col-xs-12">                                            
													<textarea class="form-control" rows="5" name="abc_descriptions"><?php echo $fetchrecord['Description']; ?></textarea>
													<!-- <span class="help-block">Default textarea field</span>-->
												</div>
											</div>
											
										 
											
										</div>
										<div class="col-md-6">
										
										<div class="form-group">
												<label class="col-md-3 control-label">*S/BH Manager:</label>
												<div class="col-md-9">                                            
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" name="inCharge" class="form-control" placeholder="ABC In charge" value="<?php echo $fetchrecord['Incharge']; ?>" required/>
													</div>                                            
													
												</div>
											</div>
											
											<div class="form-group">                                        
												<label class="col-md-3 control-label">Phone Contacts</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="phoneContacts" placeholder="ABC Phone Contacts" value="<?php echo $fetchrecord['Phone']; ?>" required/>
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
										
										<div class="form-group">                                        
												<label class="col-md-3 control-label">Region</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="Region" placeholder="ABC Location (Region)" value="<?php echo $fetchrecord['Region']; ?>" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										 
										 <div class="form-group">                                        
												<label class="col-md-3 control-label">District</label>
												<div class="col-md-9 col-xs-12">
													<div class="input-group">
														<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="text" class="form-control" name="District" placeholder="ABC Location (District)" value="<?php echo $fetchrecord['District']; ?>" />
													</div>            
												   <!-- <span class="help-block">Password field sample</span> -->
												</div>
											</div>
											
										 
											
										</div>
										
									</div>

								</div>
								<div class="panel-footer">
								   <!-- <button class="btn btn-default">Clear Form</button>          -->                          
									<button class="btn btn-primary pull-left" type="submit" name="Save_new_sub_abc_edit">Save <span class="fa fa-floppy-o fa-right"></span> </button>
								</div>
							</div>
							</form>
							
						</div>
					</div>                    
					
				</div>
					<?php	
				}
				
				if(isset($_GET['add_new_book']))
				{
					AddRegister_Book();
				}
				else if(isset($_GET['reg_new_subabc']))
				{
					RegNewSubABC($_GET['reg_new_subabc']);
				}
				else if(isset($_GET['View_sub_abc']))
				{
					View_ConfSubABCStock($_GET['View_sub_abc']);	
				}
				else if(isset($_GET['edit_Unionstaff_details']))
				{
					EditUnionStaff($_GET['edit_Unionstaff_details']);
				}
				else if(isset($_GET['edit_sub_abc']))
				{
					EditsubABCInfo($_GET['edit_sub_abc']);
				}
				else if(isset($_GET['delete_item_from_Isue']))
				{
					$record_id = $_GET['delete_item_from_Isue'];
					$IssueID = $_GET['IssueID'];

					require('connection.php');
					$queryDelete = mysql_query("DELETE FROM mainabc_issues_items WHERE ID='$record_id' ",$connect)or die(mysql_error());

					View_Single_Conf_Issue($IssueID);
				}
				else if(isset($_GET['View_single_issue']))
				{
					View_Single_Conf_Issue($_GET['View_single_issue']);
				}
				else if(isset($_GET['view_sub_abc_staff']))
				{
					View_SubABCStaff($_GET['view_sub_abc_staff']);
				}
				else if(isset($_POST['Save_Item_Issue_Request']))
				{
					$IssueID = $_POST['IssueID'];
					$bookItem = $_POST['bookItem'];
					$booKName = return_book_name($bookItem);
					$Quantity = $_POST['Quantity'];
					$UnitPrice = str_replace(',', '', $_POST['UnitPrice']);
					$Description = $_POST['Description'];

					require('connection.php');

					$queryValidate = mysql_query("SELECT * FROM mainabc_issues_items WHERE TransID='$IssueID' AND ItemID='$bookItem'",$connect)or die(mysql_error());

					if(mysql_num_rows($queryValidate)>0)
					{
						echo "<font color='red'><b>&nbsp;&nbsp;&nbsp;Error: The Book / Item is already in the List</b></font>";
					}
					else
					{
						$insertQuery = mysql_query("INSERT INTO mainabc_issues_items(TransID,ItemID,Quantity,UniPrice,Description,BookName) VALUES ('$IssueID','$bookItem','$Quantity','$UnitPrice','$Description','$booKName')",$connect)or die(mysql_error());
					}

					View_Single_Conf_Issue($IssueID);

				}
				else if(isset($_POST['Save_Item_Issue_Request_edit']))
				{
					$IssueID = $_POST['IssueID'];
					$bookItem = $_POST['bookItem'];
					$Quantity = $_POST['Quantity'];
					$UnitPrice = str_replace(',', '', $_POST['UnitPrice']);
					$Description = $_POST['Description'];
					$recordID = $_POST['recordID'];

					require('connection.php');

						$UpdateQuery = mysql_query("UPDATE mainabc_issues_items SET Quantity='$Quantity',UniPrice='$UnitPrice',Description='$Description' WHERE ID='$recordID' ",$connect)or die(mysql_error());
					

					View_Single_Conf_Issue($IssueID);

				}
				else if(isset($_POST['Save_new_conf_issue']))
				{
					$confID = $_POST['confID'];
					$recepientType = $_POST['recepientType'];
					$issuedID = $_POST['issuedID'];
					$dateIssue = $_POST['dateIssue'];
					$d_note = $_POST['d_note'];
					$issueDescription = $_POST['issueDescription'];

					require('connection.php');

					$queryValidate = mysql_query("SELECT * FROM mainabc_issues WHERE FromMainABC='$confID' AND IssuedTo='$recepientType' AND ToRecepientID='$issuedID' AND DateIssue='$dateIssue' ",$connect)or die(mysql_error());

					if(mysql_num_rows($queryValidate)>0)
					{
						$fetch_existing = mysql_fetch_array($queryValidate);
						$ids = $fetch_existing['ID'];
					}
					else
					{
						//The Issus request do not exist , proceed to insert the Data into the database

						$isertQuery = mysql_query("INSERT INTO mainabc_issues(DateIssue,FromMainABC,ToRecepientID,DNote,Description,IssuedTo) VALUES ('$dateIssue','$confID','$issuedID','$d_note','$issueDescription','$recepientType')",$connect) or die(mysql_error());

						   $ids = mysql_insert_id();
					}

					//The name of PHP function to be called after the execution is done..

					View_Single_Conf_Issue($ids);

				}
				else if(isset($_POST['Save_new_main_publishing_staff']))
				{
					$fname = $_POST['fname'];
					$mname = $_POST['mname'];
					$lname = $_POST['lname'];
					$Gender = $_POST['Gender'];
					$Address = $_POST['Address'];
					$Email = $_POST['Email'];
					$Phone = $_POST['Phone'];
					$username = $_POST['username'];
					$Title = $_POST['Title'];
					$confID = $_POST['confID'];
					
					$password = md5(1234);
					$access_level = 20;
					$image_name = 'no_image_user.png';
					$staff_side = 'Publishing';
					
					require('connection.php');
					
					$QueryVerify = mysql_query("SELECT * FROM publishing_staffs WHERE FirstName='$fname' AND Middlename='$mname' AND LastName='$lname' AND ConferenceID='$confID' AND StaffSide='$staff_side' AND access_level='$access_level' ",$connect)or die(mysql_error());
					if(mysql_num_rows($QueryVerify)>0)
					{
						
					}
					else
					{
						$insertQuery = mysql_query("INSERT INTO publishing_staffs
						(FirstName,Middlename,LastName,Gender,Phone,Email,Address,username,Passwordi,Title,access_level,ImageName,StaffSide,ConferenceID) VALUES 
						('$fname','$mname','$lname','$Gender','$Phone','$Email','$Address','$username','$password','$Title','$access_level','$image_name','$staff_side','$confID')",$connect)or die(mysql_error());
					}
					
					View_ConferenceStaff($confID);
					
				}
				else if(isset($_POST['Save_new_subABC_publishing_staff']))
				{
					$fname = $_POST['fname'];
					$mname = $_POST['mname'];
					$lname = $_POST['lname'];
					$Gender = $_POST['Gender'];
					$Address = $_POST['Address'];
					$Email = $_POST['Email'];
					$Phone = $_POST['Phone'];
					$username = $_POST['username'];
					$Title = $_POST['Title'];
					$abcID = $_POST['abcID'];
					
					$password = md5(1234);
					$access_level = 19;
					$image_name = 'no_image_user.png';
					$staff_side = 'Publishing';
					
					require('connection.php');
					
					$QueryVerify = mysql_query("SELECT * FROM publishing_staffs WHERE FirstName='$fname' AND Middlename='$mname' AND LastName='$lname' AND SubABCID='$abcID' AND StaffSide='$staff_side' AND access_level='$access_level' ",$connect)or die(mysql_error());
					if(mysql_num_rows($QueryVerify)>0)
					{
						
					}
					else
					{
						$insertQuery = mysql_query("INSERT INTO publishing_staffs
						(FirstName,Middlename,LastName,Gender,Phone,Email,Address,username,Passwordi,Title,access_level,ImageName,StaffSide,SubABCID) VALUES 
						('$fname','$mname','$lname','$Gender','$Phone','$Email','$Address','$username','$password','$Title','$access_level','$image_name','$staff_side','$abcID')",$connect)or die(mysql_error());
					}
					
					View_SubABCStaff($abcID);
					
				}
				else if(isset($_POST['Save_new_publishing_staff']))
				{
					$fname = $_POST['fname'];
					$mname = $_POST['mname'];
					$lname = $_POST['lname'];
					$Gender = $_POST['Gender'];
					$Address = $_POST['Address'];
					$Email = $_POST['Email'];
					$Phone = $_POST['Phone'];
					$username = $_POST['username'];
					$Title = $_POST['Title'];
					
					$password = md5(1234);
					$access_level = 21;
					$image_name = 'no_image_user.png';
					$staff_side = 'Publishing';
					
					require('connection.php');
					
					$QueryVerify = mysql_query("SELECT * FROM publishing_staffs WHERE FirstName='$fname' AND Middlename='$mname' AND LastName='$lname' AND StaffSide='$staff_side' AND access_level='$access_level' ",$connect)or die(mysql_error());
					if(mysql_num_rows($QueryVerify)>0)
					{
						
					}
					else
					{
						$insertQuery = mysql_query("INSERT INTO publishing_staffs
						(FirstName,Middlename,LastName,Gender,Phone,Email,Address,username,Passwordi,Title,access_level,ImageName,StaffSide) VALUES 
						('$fname','$mname','$lname','$Gender','$Phone','$Email','$Address','$username','$password','$Title','$access_level','$image_name','$staff_side')",$connect)or die(mysql_error());
					}
					
					View_UnionStaff();
					
				}
				else if(isset($_GET['view_conference_staff']))
				{
					View_ConferenceStaff($_GET['view_conference_staff']);
				}
				else if(isset($_GET['ItemsIssuedToSelection']))
				{
					$confIDs = $_GET['confIDs'];
					$Itemrecipient = $_GET['Itemrecipient'];
					InitialIssues_Details($Itemrecipient,$confIDs);
				}
				else if(isset($_POST['Save_new_publishing_staff_update']))
				{
					$fname = $_POST['fname'];
					$mname = $_POST['mname'];
					$lname = $_POST['lname'];
					$Gender = $_POST['Gender'];
					$Address = $_POST['Address'];
					$Email = $_POST['Email'];
					$Phone = $_POST['Phone'];
					$username = $_POST['username'];
					$Title = $_POST['Title'];
					$staffID = $_POST['staffID'];
					
					$password = md5(1234);
					$access_level = 21;
					$image_name = 'no_image_user.png';
					$staff_side = 'Publishing';
					
					require('connection.php');
					
					
						$insertQuery = mysql_query("UPDATE publishing_staffs SET FirstName='$fname',Middlename='$mname',LastName='$lname',Gender='$Gender',Phone='$Phone',Email='$Email',
						Address='$Address',username='$username',Title='$Title',access_level='$access_level',ImageName='$image_name' WHERE ID='$staffID' ",$connect)or die(mysql_error());
					
					
					View_UnionStaff();
					
				}
				else if(isset($_GET['view_conferences_abs']))
				{
					View_Conferences_List_abs();	
				}
				else if(isset($_GET['reg_new_confMain_staff']))
				{
					RegisterConferenceMainStaff($_GET['reg_new_confMain_staff']);
				}
				else if(isset($_GET['union_hhes_staff']))
				{
					View_UnionStaff();
				}
				else if(isset($_POST['Save_new_sub_abc_edit']))
				{
					$abc_name = $_POST['abc_name'];
					$abc_descriptions = $_POST['abc_descriptions'];
					$inCharge = $_POST['inCharge'];
					$phoneContacts = $_POST['phoneContacts'];
					$Region = $_POST['Region'];
					$District = $_POST['District'];
					$recordID = $_POST['recordID'];
					$confID = $_POST['confID'];
					$subabc_zone = $_POST['subabc_zone'];
					$abc_code = $_POST['abc_code'];
					$abc_descriptions = $_POST['abc_descriptions'];
					
					require('connection.php');
					
					$queryInsert = mysql_query("UPDATE conference_sub_abc SET abc_name='$abc_name',Region='$Region',District='$District',Phone='$phoneContacts',Incharge='$inCharge',SubABC_Code='$abc_code',ZoneID='$subabc_zone',Description='$abc_descriptions' WHERE ID='$recordID' ",$connect)or die(mysql_error());
					
					View_Conferences_sub_abs($confID);
					
				}
				else if(isset($_POST['Save_new_sub_abc']))
				{
					$abc_name = $_POST['abc_name'];
					$abc_descriptions = $_POST['abc_descriptions'];
					$inCharge = $_POST['inCharge'];
					$phoneContacts = $_POST['phoneContacts'];
					$Region = $_POST['Region'];
					$District = $_POST['District'];
					$confID = $_POST['confID'];
					$subabc_zone = $_POST['subabc_zone'];
					$abc_code = $_POST['abc_code'];
					$abc_descriptions = $_POST['abc_descriptions'];
					
					require('connection.php');
					$queryVerify = mysql_query("SELECT * FROM conference_sub_abc WHERE ConferenceID='$confID' AND abc_name='$abc_name' ",$connect)or die(mysql_error());
					if(mysql_num_rows($queryVerify)>0)
					{
						
					}
					else
					{
						$queryInsert = mysql_query("INSERT INTO conference_sub_abc(ConferenceID,abc_name,Region,District,Phone,Incharge,SubABC_Code,ZoneID,Description) 
						VALUES ('$confID','$abc_name','$Region','$District','$phoneContacts','$inCharge','$abc_code','$subabc_zone','$abc_descriptions') ",$connect)or die(mysql_error());	
					}
					
					View_Conferences_sub_abs($confID);
					
				}
				else if(isset($_GET['view_conferences_abs_sub']))
				{
					View_Conferences_sub_abs($_GET['view_conferences_abs_sub']);
				}
				else if(isset($_GET['view_main_sales_issues']))
				{
					IssueFromMAINSubABC($_GET['view_main_sales_issues']);
				}
				else if(isset($_GET['View_Conference_single']))
				{
					ViewSingleConferenceabchhes($_GET['View_Conference_single']);	
				}
				else if(isset($_GET['edit_Book_single']))
				{
					edit_books($_GET['edit_Book_single']);	
				}
				else if(isset($_GET['reg_new_union_staff']))
				{
					RegisterUnionStaff();
				}
				else if(isset($_GET['reg_new_subabc_staff']))
				{
					RegisterSubABCStaff($_GET['reg_new_subabc_staff']);
				}
				else if(isset($_POST['Save_new_book_edit']))
				{
					$Publisher = $_POST['Publisher'];
					$year_published = $_POST['year_published'];
					$buying_price = str_replace(',','',$_POST['buying_price']);
					$selling_price = str_replace(',','',$_POST['selling_price']);
					$book_desc = $_POST['book_desc'];
					$Book_author = $_POST['Book_author'];
					$Book_name = $_POST['Book_name'];
					$bookID = $_POST['bookID'];
					
					require('connection.php');
					
					$insertQuery = mysql_query("UPDATE books_list SET BookName=\"$Book_name\",Book_Description='$book_desc',Author='$Book_author',Publisher='$Publisher',Year_Published='$year_published',BuyingPrice='$buying_price',SellingPrice='$selling_price' WHERE ID = '$bookID' ",$connect)or die(mysql_error());
					
					View_Conferences_List();
					
				}
				else if(isset($_POST['Save_new_book']))
				{
					$Publisher = $_POST['Publisher'];
					$year_published = $_POST['year_published'];
					$buying_price = str_replace(',','',$_POST['buying_price']);
					$selling_price = str_replace(',','',$_POST['selling_price']);
					$book_desc = $_POST['book_desc'];
					$Book_author = $_POST['Book_author'];
					$Book_name = $_POST['Book_name'];
					
					require('connection.php');
					$verify_presence = mysql_query("SELECT * FROM books_list WHERE  BookName=\"$Book_name\" AND Author='$Book_author' ",$connect)or die(mysql_error());
					if(mysql_num_rows($verify_presence)>0)
					{
						
						
					}
					else
					{
						//Insert Query
						$insertQuery = mysql_query("INSERT INTO books_list(BookName,Book_Description,Author,Publisher,Year_Published,BuyingPrice,SellingPrice) VALUES (\"$Book_name\",'$book_desc','$Book_author','$Publisher','$year_published','$buying_price','$selling_price')",$connect)or die(mysql_error());	
					}
					
					View_Conferences_List();
					
				}
				else
				{
					
					if($_SESSION['access_level']==21)
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






