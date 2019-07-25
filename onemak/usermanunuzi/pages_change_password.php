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
                    <li><a href="#">kilimo Net</a></li>
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
				function Change_Password()
				{
					?>
                    <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                             <input type="hidden" name="confID" value="<?php echo $conferenceID ?>">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                
                                    <h3 class="panel-title">Change Your Login Password</h3>
                                    
                                    <ul class="panel-controls">
                                        <!-- <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li> -->
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <p>Please Fill the form below to Change Your Login Password, All fields with a * must be filled.</p>
                                    <?php
if(isset($_POST['change_pass']))
{
	require('connection.php');
$clearpassword=$_POST['newpassword'];

$currentpassword=md5($_POST['current_password']);
$newpassword=md5($_POST['new_password']);
$confirmcurrentpassword=md5($_POST['confirm_new_password']);

if($currentpassword=='' or $newpassword=='' or $confirmcurrentpassword=='')
{
	?>
    <span style="color:red;"> All Fields Should be Filled </span>
    <?php
}	
else{

if($newpassword!=$confirmcurrentpassword){
	?>
    <span style="color:red;"> The New Passwords entered do not Match </span>
    <?php
}else{
$checkCurrentpassword=mysql_query("SELECT * FROM users_table WHERE email='$_SESSION[username]' AND Password='$currentpassword'",$connect)or die('Could not confirm the new password due to '.mysql_error());
if(mysql_num_rows($checkCurrentpassword)==0){
?>
    <span style="color:red;"> The Current Password is Incorrect </span>
    <?php
}else{
//Change password here
$update=mysql_query("UPDATE users_table SET Password='$newpassword' WHERE email='$_SESSION[username]'",$connect)or die('Could not update the password value in the table due to '.mysql_error());

     if($update){
	 ?>
    <span style="color:red;"> Success: The Password has Changed, Login with your New Password now </span>
    <?php
	 }

}

}

}
}//end isset
				

                             ?>       
                                </div>
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">*Current Password:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                                        <input type="password" name="current_password" class="form-control" placeholder="Current Password" required/>
                                                    </div>                                            
                                                    
                                                </div>
                                            </div>
                                            
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">*New Password:</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                                        <input type="password" name="new_password" class="form-control" placeholder="New Password" required/>
                                                    </div>                                            
                                                    
                                                </div>
                                            </div>
                                 
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">*Repeat New Password</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                                        <input type="password" class="form-control" name="confirm_new_password" placeholder="Repeat New Password" required/>
                                                    </div>            
                                                   <!-- <span class="help-block">Password field sample</span> -->
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            
                                            
                                            
                                            
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-default">Clear Form</button>                                    
                                    <button class="btn btn-primary pull-right" type="submit" name="change_pass">Change Password</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                    <?php	
				}
				
				Change_Password();
				
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






