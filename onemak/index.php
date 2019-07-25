<!DOCTYPE html>
<html>
<head>
  <title>One Market Solution</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico"/>
  <meta charset="utf-8"/>
  <meta name="robots" content="index,follow"/>
  <meta name="description" content="One Market Solution ni mfumo unaowasaidia wanunuzi, wakulima na wafanyabiashara kupata taarifa za bei za bidhaa zilizopo katika masoko ya Jiji la Mwanza, Kanda ya Ziwa, na nchi za jirani zilizopo katika ukanda wa maziwa makuu."/>
  <meta name="keyword" content="onemak,one market solution,sokoni mwanza,mwanza,soko,masoko,soko tanzania,sokoni,markets,market,one,mak,solution"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="css/slide.css"/>
  <style>
  body {
      position: absolute; 
  }
  #section1 {padding-top:50px;height:auto;color: #fff; background-color:#4E8975;}
  #section2 {padding-top:50px;height:500px;color: #fff; background-color: #673ab7;}
  #section3 {padding-top:50px;height:500px;color: #fff; background-color: #ff9800;}
  #section41 {padding-top:50px;height:500px;color: #fff; background-color: #00bcd4;}
  #section42 {padding-top:50px;height:500px;color: #fff; background-color: #009688;}
  
  
  
/* The popup form - hidden by default */
.form-popup {
  display: none;
  position: fixed;
  bottom:120px;
  right: 8%;
  border: 1px solid #f1f1f1;
  border-radius:5px;
  z-index: 9;
  
}

/* Add styles to the form container */
.form-container {
  max-width:250px;
  height:350px;
  padding: 5px;
  background:white;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 70%;
  padding: 10px;
  margin-left:15%;
  margin-bottom:15px;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/login button */
.form-container .btn {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  width: 70%;
  margin-bottom:10px;
  margin-left:15%;
  opacity: 0.6;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
p{
  color:black;
  margin-left:15%;
} 
h4{
    color:black;
    margin-left:15%;
    font-size:20px;
}
**/
.signup{
    text-decoration:none;
    color:white;
    font-size:12px;
    
}
.signup:hover{
    text-decoration:none;
}

.form-container2 {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}
.form-popup2 {
  display:none;
  position: fixed;
  bottom: 10px;
  left: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

.form-container2 {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}
.form-container2 input[type=text], .form-container2 input[type=password], .form-container2 input[type=email], .form-container2 input[type=tel], .form-container2 input[type=date]{
  width: 100%;
  padding: 10px;
  margin: 5px 0 5px 0;
  border: none;
  background: #f1f1f1;
}
.form-container2 .cancel {
  background-color: red;
}
.form-container2 .btn:hover, .open-button:hover {
  opacity: 1;
}
.form-container2 .btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}
.form-container2 input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}
select{
  width: 100%;
  padding: 10px;
  margin: 5px 0 5px 0;
  border: none;
  background: #f1f1f1;
}
  
  
  
  </style>
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
<div class="container-fluid">
<div class="navbar-header">
<img src="images/one.png" width="60px" height="60px" class="img-circle pull-left" alt="Onemak Logo">
<a class="navbar-brand" href="index.php"><font size="2.3px">ONE MARKET SOLUTION</font></a>
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
	  </div>
<div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="index.php">Nyumbani</a></li>
          <li><a href="aboutus.php">Kuhusu</a></li>
          <li><a href="contact.php">Mawasiliano</a></li>
          <li><a href="onemak/index.php" target="_blank">Admin</a></li>
         <!-- <li><a href="#" class="open-button" onclick="openForm()">Nunua</a></li>-->
         <li><a href="usermanunuzi/index.php" target="_blank">Manunuzi</a></li>
		  </ul>
		  
		  
		  
		  
		  
		  
	<!--LOGIN FORM STARTS HERE-->	  
		  
		  <div class="form-popup" id="myForm">
  <form action="/action_page.php" class="form-container">
    <h4>Login</h4>

      <!--<label for="email"><b>Email/Username</b></label>-->
    <input type="text" placeholder="Enter Email /Username" name="email" required>

      <!--<label for="psw"><b>Password</b></label>-->
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit" class="btn">Login</button>
    
    <p>Dont have an Account? <a class="signup" href="#" onclick="openform2()">Signup</a></p>
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
  </form>
</div>
                 <!--LOGIN FORM ENDS HERE-->
                 
                 
                 
                 <!--SIGNUP FORM STARTS HERE-->
<div class="form-popup2" id="myForm2">

<form action="#" class="form-container2">
    <h1>Register</h1>
    <input type="text" id="fname" placeholder="Enter Username" required>
    <input type="Email" id="email" placeholder="Enter Email" required>
    <input type="Email" id="reemail" placeholder="Repeat Email" required>
    <input type="tel" id="phone" placeholder="Phone Number" required>
    <select id="location">
	       <option hidden>Makazi</option>
	       <option>Carpripoint</option>
	       <option>Isamilo</option>
	       <option>Kirumba</option>
	       <option>Kitangiri</option>
	       <option>Bwiru</option>
	       <option>Airport</option>
	       <option>Nyamanoro</option>
	       <option>Pasiansi</option>
	       <option>Igogo</option>
	       <option>Mkuyuni</option>
	       <option>Mabatini</option>
	       <option>Nyakato</option>
	       <option>Nation</option>
	       <option>Nyasaka</option>
	</select>
    <input type="radio" name="gender" id="female">:Female<input type="radio" name="gender" id="male">:Male
    <input type="date" id="dob">
    <input type="password" id="pswd" placeholder="Password" required>
    <input type="password" id="repswd" placeholder="repeat Password" required>

    <button type="submit" class="btn">Register</button>
    <button type="button" class="btn cancel" style="background-color:red;" onclick="closeForm()">Cancel</button>
  </form>

</div>
        <!--SIGNUP FORM ENDS HERE-->
        
        


		  
		  
		  
		  
		  <a href="https://web.facebook.com/onemarketz/"><img width="50px" height="50px" src="images/face2.png" alt="facebook"  class="pull-right img-circle" style="padding:5px;"/></a>
		  </div>
		  </div>
</nav>
<br/>
<br/>
<br/>
  <div class="slider">
    <div class="slide1">
      <img src="images/beans.jpg" alt="farm products" width="100%" height="500px">
    </div>

    <div class="slide2">
      <img src="images/biz.jpg" alt="farm products" width="100%" height="500px">
      <div class="text">Caption Text</div>
    </div>

    <div class="slide3">
      <img src="images/nyanya.jpg" alt="farm products" width="100%" height="500px">
      <div class="text">Caption Text</div>
    </div>
	<div class="slide4">
      <img src="images/mazao.jpg" alt="farm products" width="100%" height="500px">
    </div>

</div>
<div class="container relate">
<h3 class="bg-success"><center>BEI ZA BIDHAA KATIKA MASOKO YA MWANZA 
<?php 
date_default_timezone_set("Africa/Dar_es_Salaam");
echo date("d m Y"); ?>
</center>
</h3>
<h5 class="bg-danger text-center">TAHADHARI: Bei za bidhaa katika masoko zinaweza kubadilika wakati wowote kutokana na sababu mbalimbali</h5>
</div>

    
    <?php 
    
  

		
		function returnProductReportValues($column)
					{
	if(empty($idrecord))
	{
		return "";
	}
	else
	{
		require('connection.php');
		$query = mysqli_query("SELECT $column FROM product_prices_actual WHERE  ",$connect)or die(mysqli_error());
		if(mysqli_num_rows($query)==0)
		{
			return "";
		}
		else
		{
			$fetch_data = mysqli_fetch_array($query);
			if($column=='maximum_value' or $column=='minimum_value')
				return number_format($fetch_data[$column]);
				else
			return $fetch_data[$column];
		}
	}
}

		require('connection.php');
						$num = 0;
						$query =("SELECT * FROM markets ORDER BY ID")or die(mysqli_error());
                        $result = mysqli_query($connect, $query)or die(mysqli_error($connect));
						while($fetch_markets = mysqli_fetch_array($result))
						{
							$num++;
							$marketID = $fetch_markets['ID'];
					?>  
<div id="section1" class="container-fluid col-xs-12 col-sm-6  relate">
  <h1 class="text-center">
      <?php echo $fetch_markets['MarketName']; ?></h1>
  <table class="table  table-responsive">

              <thead>
                <tr>
                  <th class="text-center">Bidhaa</th>
                  <th class="text-center">ujazo</th>
                  <th class="text-center">Bei ya chini</th>
                  <th class="text-center">Bei ya juu</th>
                </tr>
              </thead>
			  <?php
$checkreportQuery =mysqli_query($connect,"SELECT * FROM product_prices_dates WHERE MarketID='$marketID' ORDER BY ID DESC LIMIT 1") or die(mysqli_error());
                            if(mysqli_fetch_assoc($checkreportQuery)==0)
								{
									$ID_report=0;
								}
								else
								{
									$fetch_initial_report = mysqli_fetch_array($checkreportQuery);
    								$ID_report = $fetch_initial_report['ID'];
								}

							   $queryProducts = mysqli_query($connect,"SELECT * FROM products")or die(mysqli_error());
							   $counter=0;
							   while($fetch_products = mysqli_fetch_array($queryProducts)  )
							   {
							   		$counter++;
							   		$productID = $fetch_products['ProductID'];
							   ?>
              <tbody>
                <tr>
				<td class="text-center"> <?php echo $fetch_products['ProductName']; ?> </td>
                <td class="text-center"> 1<?php echo $fetch_products['UniMeasure']; ?> </td>
                <td class="text-center"> <?php echo returnProductReportValues($productID,$ID_report,'minimum_value'); ?> </td>
                <td class="text-center"> <?php echo returnProductReportValues($productID,$ID_report,'maximum_value'); ?> </td>
                </tr>
              </tbody>
			  <?php
							}
							?>
			  </table>
  </div>
  <?php
							}
							?>
<div class="footer col-sm-6 col-md-12"><p class="pull-left">&nbsp;onemaktz@gmail.com
<span class="glyphicon glyphicon-envelope pull-left" style="padding-left:25px;"></span></p>
 &copy;2017-<?php echo date("Y") ?> One Market Solution.All Rights Reserved.</div>

</body>
</html>