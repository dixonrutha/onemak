<?php
if(isset($_POST['Log_In']))
{
	
$user_name = $_POST['username'];
$pass_word = md5($_POST['Passwordi']);

require('connection.php');

$query_login_verification = mysql_query("SELECT * FROM users_table WHERE email='$user_name' AND Password='$pass_word' ",$connect)or die(mysql_error());

if(mysql_num_rows($query_login_verification)==0)
{
	$errorMsg = "Invalid Login , Try Again Later";
}
else
{
	$fetchLogin = mysql_fetch_array($query_login_verification);
	$staff_category = $fetchLogin['StaffSide'];
	session_start();
	$_SESSION['username'] = $user_name;
	$_SESSION['access_level'] = $fetchLogin['access_level'];
	$_SESSION['ConferenceID'] = $fetchLogin['MarketID'];
	$_SESSION['zoneID'] = $fetchLogin['zoneID'];
	$_SESSION['StaffSide'] = $staff_category;
	$_SESSION['title'] = $fetchLogin['Title'];
	
	
	header("Location:Conferences_list_home.php");
			
}


}

require('constants_configurations.php');
?>
<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title><?php echo $title_constant;  ?></title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->                                    
    </head>
    <body>
        
        <div class="login-container">
        
            <div class="login-box animated fadeInDown">
               <!-- <div class="login-logo"></div> -->
                <div class="login-body">
                    <div class="login-title"><strong>Welcome</strong>, Please login</div>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" name="username" class="form-control" placeholder="Your Email" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password"  name="Passwordi"  class="form-control" placeholder="Password" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                             <a href="registration_page.php" class="btn btn-link btn-block"> Sign Up Here </a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-info btn-block" name="Log_In">Log In</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="login-footer">
                    <div class="pull-left">
                    <?php
					if(isset($_POST['Log_In']))
					{
					?>
                    <span style="color:red;"> <?php echo $errorMsg."<br>"; ?> </span>
                    <?php
					}
					?>
                        &copy; 2017 One Market Solution 
                    </div>
                    <div class="pull-right">
                        <a href="#">Privacy</a> |
                        <a href="#">Contact Us</a>
                    </div>
                </div>
            </div>
            
        </div>
        
    </body>
</html>






