<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> One Market Solution </title>
    <link rel="stylesheet" href="css/stylecs.css">
    <link rel="stylesheet" href="font/Font-Awesome-master/css/font-awesome.min.css">
    <script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
    <script src="js/slick.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/" type="text/javascript" charset="utf-8"></script>


    <style type="text/css">
        * {
            box-sizing: border-box;
        }
        .slider {
            width: 95%;
            margin: 100px auto;
        }
        .slick-slide {
            margin: 0px 5px;
        }
        .slick-slide img {

        }
        .slick-prev:before,
        .slick-next:before {
            color: white;
        }
    </style>


</head>
<body>

<div class="centerThis">

    <div class="header">
        <div class="site-name"><span>One Market Solution</span></div>
        <div class="logo"></div>
        <div class="social-links"><a href="https://web.facebook.com/onemarketz/"><img width="35px" height="35px" src="/images/facebook-logo.png" alt="logo" /></a></div>
        <!--<div class="trigger-btn"><span>Jiunge</span></div> -->
    </div>
    <div class="loh-hd">





        <div class="form">
            <div class="freeUsage">Ni bure kujisajili , ni bure kujiunga , ni bure kutumia</div>

            <ul class="tab-group">
                <li class="tab active"><a href="#signup">Jisajili</a></li>
                <li class="tab"><a href="#login">Jiunge</a></li>
            </ul>

            <div class="tab-content">
                <div id="signup">
                    <form action="/" method="post">
                        <div class="top-row">
                            <div class="field-wrap">
                                <input type="text" placeholder="Jina la kwanza" required autocomplete="off" />
                            </div>

                            <div class="field-wrap">
                                <input type="text" placeholder="Jina la pili" required autocomplete="off"/>
                            </div>
                        </div>

                        <div class="field-wrap">
                            <input type="email" placeholder="Barua pepe" required autocomplete="off"/>
                        </div>

                        <div class="field-wrap">
                            <input type="password" placeholder="Neno la siri" required autocomplete="off"/>
                        </div>

                        <div class="field-wrap">
                            <input type="password" placeholder="Thibitisha neno la siri" required autocomplete="off"/>
                        </div>

                        <button type="submit" class="button button-block"/>Jisajili sasa</button>

                    </form>

                </div>

                <div id="login">

                    <form action="/" method="post">

                        <div class="field-wrap">
                            <input type="email" placeholder="Barua pepe" required autocomplete="off"/>
                        </div>

                        <div class="field-wrap">
                            <input type="password" placeholder="Neno la siri" required autocomplete="off"/>
                        </div>

                        <p class="forgot"><a href="#">Umesahau neo la siri?</a></p>

                        <button class="button button-block"/>Jiunge</button>

                    </form>

                </div>

            </div><!-- tab-content -->

        </div> <!-- /form -->






    </div>

    <div class="stick-image">
        <img class="image-body" src="images/maize.jpg">
    </div>


    <div class="cropsInformation_footer">
<h3><center>BEI ZA BIDHAA KATIKA MASOKO YA MWANZA 
<?php 
date_default_timezone_set("Africa/Dar_es_Salaam");
echo date("d m Y"); ?>
</center>
</h3>
        <section class="regular slider">
		
		<?php 
		
		function returnProductReportValues($productID,$idrecord,$column)
					{
	if(empty($idrecord))
	{
		return "";
	}
	else
	{
		require('connection.php');
		$query = mysql_query("SELECT $column FROM product_prices_actual WHERE ProductID='$productID' AND PriceID='$idrecord' ",$connect)or die(mysql_error());
		if(mysql_num_rows($query)==0)
		{
			return "";
		}
		else
		{
			$fetch_data = mysql_fetch_array($query);
			if($column=='maximum_value' or $column=='minimum_value')
				return number_format($fetch_data[$column]);
				else
			return $fetch_data[$column];
		}
	}
}

		require('connection.php');
						$num = 0;
						$query = mysql_query("SELECT * FROM markets ORDER BY ID",$connect)or die(mysql_error());
						while($fetch_markets = mysql_fetch_array($query))
						{
							$num++;
							$marketID = $fetch_markets['ID'];
					?>
		
            <div>
                <div class="tableExits">
                  <!--  <a href="kn_products_more.html"> -->
                        <div class="tableProductName">
                            <span> <?php echo $fetch_markets['MarketName']; ?>  </span>
                        </div>
                        <div class="tableProductHeader">
                            <div class="tableHeader foodName ">Bidhaa</div>
                            <div class="tableHeader foodWeight">Ujazo</div>
                            <div class="tableHeader foodPrice">bei</div>
                        </div>
						<?php
							   $checkreportQuery =  mysql_query("SELECT * FROM product_prices_dates WHERE MarketID='$marketID' ORDER BY ID DESC LIMIT 1",$connect) or die(mysql_error());

							   if(mysql_num_rows($checkreportQuery)==0)
								{
									$ID_report=0;
								}
								else
								{
									$fetch_initial_report = mysql_fetch_array($checkreportQuery);
    								$ID_report = $fetch_initial_report['ID'];
								}

							   $queryProducts = mysql_query("SELECT * FROM products",$connect)or die(mysql_error());
							   $counter=0;
							   while($fetch_products = mysql_fetch_array($queryProducts))
							   {
							   		$counter++;
							   		$productID = $fetch_products['ProductID'];
							   ?>
                        <div class="tableProductList">
                            <div class="tableCrop cropName"><?php echo $fetch_products['ProductName']; ?></div>
                            <div class="tableCrop cropWeight">1<?php echo $fetch_products['UniMeasure']; ?></div>
                            <div class="tableCrop cropPrice"><?php echo returnProductReportValues($productID,$ID_report,'minimum_value'); ?></div>
                        </div>
						 <?php
							}
							?>
                       
                        
                   <!-- </a> -->
                </div>
            </div>
			
			<?php 
		}//end while loop
		?>
			

        </section>
<center><p><font color="red">TAHADHARI: Bei za bidhaa katika masoko zinaweza kubadilika wakati wowote kutokana na sababu mbalimbali</font></p></center>


        <div class="footer">
            <ul class="listWrapper">
                <li class="listFooter"> <a href="#"> Tujue </a> </li>
                <li class="listFooter"> <a href="#"> Tangaza </a> </li>
                <li class="listFooter"> <a href="#"> Msaada </a> </li>
                <li class="listFooter"> <a href="#"> Mrejesho </a> </li>
                <li class="listFooter"> <a href="onemak/index.php" target="_blank"> Admin <span id="ad-users">(Authorized users only)</span> </a> </li>
            </ul>

            <div class="copyRght">&copy 2017-<?php echo date("Y") ?> One Market Solution </div>
        </div>

    </div>
</div>
</body>



<script type="text/javascript">
    $(document).on('ready', function() {
        $(".regular").slick({
            dots: false,
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 5
        });
        $(".center").slick({
            dots: false,
            infinite: true,
            centerMode: true,
            slidesToShow: 5,
            slidesToScroll: 5
        });
        $(".variable").slick({
            dots: false,
            infinite: true,
            variableWidth: true
        });
        $(".lazy").slick({
            lazyLoad: 'ondemand', // ondemand progressive anticipated
            infinite: true
        });
    });






/* This open and close form */

    $(document).ready(function () {
        $(".trigger-btn").click(function () {
            var $target = $($(this).data('target'));
            $(".loh-hd").not($target).stop().slideDown();
            $target.slideUp();
        });
        //$(".trigger-btn").mouseleave(function () {
          //  $(".loh-hd").stop().slideUp();
        //});
    });






//  form changes from registration to login

    $('.form').find('input, textarea').on('keyup blur focus', function (e) {

        var $this = $(this),
                label = $this.prev('label');

        if (e.type === 'keyup') {
            if ($this.val() === '') {
                label.removeClass('active highlight');
            } else {
                label.addClass('active highlight');
            }
        } else if (e.type === 'blur') {
            if( $this.val() === '' ) {
                label.removeClass('active highlight');
            } else {
                label.removeClass('highlight');
            }
        } else if (e.type === 'focus') {

            if( $this.val() === '' ) {
                label.removeClass('highlight');
            }
            else if( $this.val() !== '' ) {
                label.addClass('highlight');
            }
        }

    });

    $('.tab a').on('click', function (e) {

        e.preventDefault();

        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');

        target = $(this).attr('href');

        $('.tab-content > div').not(target).hide();

        $(target).fadeIn(600);

    });
</script>

</html>