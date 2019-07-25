<?php
if(isset($_POST['registerButton']))
{
	
$your_name = $_POST['your_name'];
$your_email = $_POST['your_email'];
$phone_number = $_POST['phone_number'];
$your_address = $_POST['your_address'];
$Passwordi = md5($_POST['Passwordi']);
$NewPasswordi = md5($_POST['NewPasswordi']);

require('connection.php');

//Check if the Username Selected is already in Use...
$query_login_verification = mysql_query("SELECT * FROM users_table WHERE email='$your_email' ",$connect)or die(mysql_error());

if($Passwordi!=$NewPasswordi)
{
    $errorMsg = " Error: The Password(s) Do not Match ";
}
else if(mysql_num_rows($query_login_verification)>0)
{
	$errorMsg = " Error: Email is already used , Please use a different email";
}
else
{
    //echo "INSERT INTO users_table(full_name,email,phone_number,Address,Password) VALUES('$your_name','$your_email','$phone_number','$your_address','$Passwordi') ";

	$insertQuery = mysql_query("INSERT INTO users_table(full_name,email,phone_number,Address,Password,ImageName) VALUES('$your_name','$your_email','$phone_number','$your_address','$Passwordi','no_image_user.png') ",$connect)or die(mysql_error());

    if($insertQuery)
    {
        $errorMsg = " Registration Success , You can Login Now";
    
    }

    
	
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
                    <div class="login-title">
                        <?php
                    if(isset($_POST['registerButton']))
                    {
                    ?>
                    <span style="color:red;"> <?php echo $errorMsg."<br>"; ?> </span> 
                    <?php
                    }
                    ?>
                    <!--<strong>Welcome</strong>,-->Please Sign Up by filling the form below</div>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post">



                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" name="your_name" class="form-control" placeholder="Your Name" required/>
                        </div>
                    </div>

             
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" name="your_address" class="form-control" placeholder="Your Address" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" name="phone_number" class="form-control" placeholder="Your Phone Number" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" name="your_email" class="form-control" placeholder="Your Email" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password"  name="Passwordi"  class="form-control" placeholder="Password" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password"  name="NewPasswordi"  class="form-control" placeholder="Retype Password" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6">
                             <a href="index.php" class="btn btn-link btn-block"> Login to your account </a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-info btn-block" name="registerButton">Register</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="login-footer">
                    <div class="pull-left">
                    
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






