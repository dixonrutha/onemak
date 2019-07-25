<?php

function ExportProductsReport($sql)
{
	require('PHPExcel/Classes/PHPExcel.php');
require('connection.php');
//require('settings.php');

  $objPHPExcel = new PHPExcel();
  
  	$message = "The Products Price List Report ";
  
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Weely Product Product Report'); // renamin the sheet
	
	$query = mysql_query($sql,$connect) or die(mysql_error());
	
	if(mysql_num_rows($query)==0)
	{
		$objSheet->getStyle('A1:S1')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
		$objSheet->getStyle('A2:S2')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12
	
		$objSheet->getCell('A1')->setValue($message);
		$objSheet->getCell('A2')->setValue('Products Weekly Report');
		//echo "<br><span class='error'>Hakuna Taarifa yeyote kwa Mtaa Huu</span> <br>";
	}
	else
	{
		$fetch_initial_report = mysql_fetch_array($query);
    	$ID_report = $fetch_initial_report['ID'];

		$message2 = "The Products Price shown are as of Week Dated ".Date_formating($fetch_initial_report['Startdate'])." to ".Date_formating($fetch_initial_report['EndDate']);


$query2 = mysql_query("SELECT * FROM products ",$connect) or die(mysql_error());

		$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	
	$objSheet->getStyle('A1:J1')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A2:J2')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	
	
	$objSheet->mergeCells('A1:G1');
	$objSheet->getCell('A1')->setValue($message2);
	
	$objSheet->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  
	$objSheet->getCell('A2')->setValue('No');
	
	$objSheet->getCell('B2')->setValue('Product Name');
	
	$objSheet->getCell('C2')->setValue('Minimum Price');
	
	$objSheet->getCell('D2')->setValue('Maximum Price');
	$objSheet->getCell('E2')->setValue('Steps taken');
	$objSheet->getCell('F2')->setValue('Challeges/Changamoto');
	$objSheet->getCell('G2')->setValue('Maoni');
	
	
			$num = 2;
			$inital = $num+1;
			while($fetch_years = mysql_fetch_array($query2))
			{
				$productID = $fetch_years['ProductID'];
				$num++;
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':H'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				//$objSheet->getStyle('H'.$num)->getNumberFormat()->setFormatCode('#,##');
					
				$drugID = $fetch_years['drugid'];
				
				$objSheet->getCell('A'.$num)->setValue($num-2);
				$objSheet->getCell('B'.$num)->setValue($fetch_years['ProductName']);
				$objSheet->getCell('C'.$num)->setValue(returnProductReportValues($productID,$ID_report,'minimum_value'));
				$objSheet->getCell('D'.$num)->setValue(returnProductReportValues($productID,$ID_report,'maximum_value'));
				$objSheet->getCell('E'.$num)->setValue(returnProductReportValues($productID,$ID_report,'steps'));
				$objSheet->getCell('F'.$num)->setValue(returnProductReportValues($productID,$ID_report,'challenges'));
				$objSheet->getCell('G'.$num)->setValue(returnProductReportValues($productID,$ID_report,'feedback'));
				
			}//end while loop
	
	}
	
	$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setAutoSize(true);
	$objSheet->getColumnDimension('C')->setAutoSize(true);
	$objSheet->getColumnDimension('D')->setAutoSize(true);
	$objSheet->getColumnDimension('E')->setAutoSize(true);
	$objSheet->getColumnDimension('F')->setAutoSize(true);
	$objSheet->getColumnDimension('G')->setAutoSize(true);
	
	/*$objSheet->getColumnDimension('H')->setAutoSize(true);
	$objSheet->getColumnDimension('I')->setAutoSize(true);
	$objSheet->getColumnDimension('J')->setAutoSize(true);
	$objSheet->getColumnDimension('K')->setAutoSize(true);
	$objSheet->getColumnDimension('L')->setAutoSize(true);
	$objSheet->getColumnDimension('M')->setAutoSize(true);
	$objSheet->getColumnDimension('N')->setAutoSize(true);
	$objSheet->getColumnDimension('O')->setAutoSize(true);
	$objSheet->getColumnDimension('P')->setAutoSize(true);
	$objSheet->getColumnDimension('Q')->setAutoSize(true);*/
	
	$objWriter->save('products_weekly_report.xlsx');
}//end function

function ExportFarmProducts($sql)
{
	require('PHPExcel/Classes/PHPExcel.php');
	require('connection.php');
//require('settings.php');

  $objPHPExcel = new PHPExcel();
  
  	$message = " Farm Products Lists ";
  
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Farm Products List'); // renamin the sheet
	
	$query = mysql_query($sql,$connect) or die(mysql_error());
	
	if(mysql_num_rows($query)==0)
	{
		$objSheet->getStyle('A1:S1')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
		$objSheet->getStyle('A2:S2')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12
	
		$objSheet->getCell('A1')->setValue($message);
		$objSheet->getCell('A2')->setValue('Farm Products List');
		//echo "<br><span class='error'>Hakuna Taarifa yeyote kwa Mtaa Huu</span> <br>";
	}
	else
	{
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	
	$objSheet->getStyle('A1:J1')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A2:J2')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	
	
	$objSheet->mergeCells('A1:D1');
	$objSheet->getCell('A1')->setValue($message);
	
	$objSheet->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  
	$objSheet->getCell('A2')->setValue('No');
	
	$objSheet->getCell('B2')->setValue('Product Name');
	
	$objSheet->getCell('C2')->setValue('Unit of Measure');
	
	$objSheet->getCell('D2')->setValue('Description');
	//$objSheet->getCell('E2')->setValue('Phone Number');
	//$objSheet->getCell('F2')->setValue('Email Address');
	//$objSheet->getCell('G2')->setValue('Address');
	
	
			$num = 2;
			$inital = $num+1;
			while($fetch_years = mysql_fetch_array($query))
			{
				$num++;
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':E'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				//$objSheet->getStyle('H'.$num)->getNumberFormat()->setFormatCode('#,##');
					
				$drugID = $fetch_years['drugid'];
				
				$objSheet->getCell('A'.$num)->setValue($num-2);
				$objSheet->getCell('B'.$num)->setValue($fetch_years['ProductName']);
				$objSheet->getCell('C'.$num)->setValue($fetch_years['UniMeasure']);
				$objSheet->getCell('D'.$num)->setValue($fetch_years['Description']);
				//$objSheet->getCell('E'.$num)->setValue($fetch_years['Phone_Number']);
				//$objSheet->getCell('F'.$num)->setValue($fetch_years['Email_address']);
				//$objSheet->getCell('G'.$num)->setValue($fetch_years['Address_Box']);
				
			}//end while loop
	
	}
	
	$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setAutoSize(true);
	$objSheet->getColumnDimension('C')->setAutoSize(true);
	$objSheet->getColumnDimension('D')->setAutoSize(true);
	/*$objSheet->getColumnDimension('E')->setAutoSize(true);
	$objSheet->getColumnDimension('F')->setAutoSize(true);
	$objSheet->getColumnDimension('G')->setAutoSize(true);
	
	$objSheet->getColumnDimension('H')->setAutoSize(true);
	$objSheet->getColumnDimension('I')->setAutoSize(true);
	$objSheet->getColumnDimension('J')->setAutoSize(true);
	$objSheet->getColumnDimension('K')->setAutoSize(true);
	$objSheet->getColumnDimension('L')->setAutoSize(true);
	$objSheet->getColumnDimension('M')->setAutoSize(true);
	$objSheet->getColumnDimension('N')->setAutoSize(true);
	$objSheet->getColumnDimension('O')->setAutoSize(true);
	$objSheet->getColumnDimension('P')->setAutoSize(true);
	$objSheet->getColumnDimension('Q')->setAutoSize(true);*/
	
	$objWriter->save('farm_products.xlsx');
}//end function


function Export_Evangelists_lists($sql,$zoneID)
{
	require('PHPExcel/Classes/PHPExcel.php');
	require('connection.php');
//require('settings.php');

$zone_query = mysql_query("SELECT * FROM zones_lists WHERE ID='$zoneID' ",$connect)or die(mysql_error());
					$zone_details = mysql_fetch_array($zone_query);

  $objPHPExcel = new PHPExcel();
  
  	$message = "Evangelists Registered In ".$zone_details['ZoneName']." Zone - ".return_conference_name($zone_details['ConferenceID'])."(".return_conference_abbrev($zone_details['ConferenceID']);
  
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Evangelists List'); // renamin the sheet
	
	$query = mysql_query($sql,$connect) or die(mysql_error());
	
	if(mysql_num_rows($query)==0)
	{
		$objSheet->getStyle('A1:S1')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
		$objSheet->getStyle('A2:S2')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12
	
		$objSheet->getCell('A1')->setValue($message);
		$objSheet->getCell('A2')->setValue('Evangelists List');
		//echo "<br><span class='error'>Hakuna Taarifa yeyote kwa Mtaa Huu</span> <br>";
	}
	else
	{
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	
	$objSheet->getStyle('A1:J1')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A2:J2')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	
	
	$objSheet->mergeCells('A1:J1');
	$objSheet->getCell('A1')->setValue($message);
	
	$objSheet->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  
	$objSheet->getCell('A2')->setValue('No');
	
	$objSheet->getCell('B2')->setValue('Evangelist Name');
	
	$objSheet->getCell('C2')->setValue('Grade');
	
	$objSheet->getCell('D2')->setValue('Gender');
	$objSheet->getCell('E2')->setValue('Phone Number');
	$objSheet->getCell('F2')->setValue('Email Address');
	$objSheet->getCell('G2')->setValue('Church');
	$objSheet->getCell('H2')->setValue('District');
	
	$objSheet->getCell('I2')->setValue('Marital Status Level');
	$objSheet->getCell('J2')->setValue('Education Level');
	
	
			$num = 2;
			$inital = $num+1;
			while($fetch_years = mysql_fetch_array($query))
			{
				$num++;
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':K'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				//$objSheet->getStyle('H'.$num)->getNumberFormat()->setFormatCode('#,##');
					
				$drugID = $fetch_years['drugid'];
				
				$objSheet->getCell('A'.$num)->setValue($num-2);
				$objSheet->getCell('B'.$num)->setValue($fetch_years['First_Name']." ".$fetch_years['Middle_Name']." ".$fetch_years['Last_Name']);
				$objSheet->getCell('C'.$num)->setValue(return_grade_Name($fetch_years['Grade']));
				$objSheet->getCell('D'.$num)->setValue($fetch_years['Gender']);
				$objSheet->getCell('E'.$num)->setValue($fetch_years['Phone']);
				$objSheet->getCell('F'.$num)->setValue($fetch_years['Email']);
				$objSheet->getCell('G'.$num)->setValue($fetch_years['Region']);
				
				$objSheet->getCell('H'.$num)->setValue($fetch_years['Districts']);
				$objSheet->getCell('I'.$num)->setValue($fetch_years['Marital_status']);
				$objSheet->getCell('J'.$num)->setValue($fetch_years['Education_level']);
				
			}//end while loop
	
	}
	
	$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setAutoSize(true);
	$objSheet->getColumnDimension('C')->setAutoSize(true);
	$objSheet->getColumnDimension('D')->setAutoSize(true);
	$objSheet->getColumnDimension('E')->setAutoSize(true);
	$objSheet->getColumnDimension('F')->setAutoSize(true);
	$objSheet->getColumnDimension('G')->setAutoSize(true);
	
	$objSheet->getColumnDimension('H')->setAutoSize(true);
	$objSheet->getColumnDimension('I')->setAutoSize(true);
	$objSheet->getColumnDimension('J')->setAutoSize(true);
	$objSheet->getColumnDimension('K')->setAutoSize(true);
	$objSheet->getColumnDimension('L')->setAutoSize(true);
	$objSheet->getColumnDimension('M')->setAutoSize(true);
	$objSheet->getColumnDimension('N')->setAutoSize(true);
	$objSheet->getColumnDimension('O')->setAutoSize(true);
	$objSheet->getColumnDimension('P')->setAutoSize(true);
	$objSheet->getColumnDimension('Q')->setAutoSize(true);
	
	$objWriter->save('zone_Evangelists_lists.xlsx');
}//end function





function MultiQueryReport($month,$year,$order_by,$sql,$zoneID)
{
	require('PHPExcel/Classes/PHPExcel.php');
	require('connection.php');
//require('settings.php');

//$sql = "SELECT * FROM evangelists_monthly_report WHERE year='$year' AND month='$month'  ORDER BY $order_by DESC";
					

  $objPHPExcel = new PHPExcel();
  $array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
  
  	$message = "Multi Query Report ".$array_months[$month].", ".$year;
  
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Multi Query Report'); // renamin the sheet
	
	$query = mysql_query($sql,$connect) or die(mysql_error());
	
	if(mysql_num_rows($query)==0)
	{
		$objSheet->getStyle('A1:S1')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
		$objSheet->getStyle('A2:S2')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12
	
		$objSheet->getCell('A1')->setValue($message);
		$objSheet->getCell('A2')->setValue('No Report');
		//echo "<br><span class='error'>Hakuna Taarifa yeyote kwa Mtaa Huu</span> <br>";
	}
	else
	{
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A2:R2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	
	$objSheet->getStyle('A1:Q1')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A2:Q2')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	
	
	$objSheet->mergeCells('A1:O1');
	$objSheet->getCell('A1')->setValue($message);
	
	$objSheet->getStyle('A1:O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A2:Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  
	$objSheet->getCell('A2')->setValue('No');
	
	$objSheet->getCell('B2')->setValue('Evangelist Name');
	
	$objSheet->getCell('C2')->setValue('Zone');
	
	$objSheet->getCell('D2')->setValue('Conference');
	$objSheet->getCell('E2')->setValue('Hours');
	$objSheet->getCell('F2')->setValue('Magazines');
	$objSheet->getCell('G2')->setValue('Books Sold');
	$objSheet->getCell('H2')->setValue('Value of Sale');
	$objSheet->getCell('I2')->setValue('Free Literature');
	
	$objSheet->getCell('J2')->setValue('VOP');
	$objSheet->getCell('K2')->setValue('Attending SS');
	
	$objSheet->getCell('L2')->setValue('Back Slinders');
	$objSheet->getCell('M2')->setValue('Prayers');
	$objSheet->getCell('N2')->setValue('Bible Studies');
	$objSheet->getCell('O2')->setValue('Baptism Classes');
	$objSheet->getCell('P2')->setValue('Baptized');
	$objSheet->getCell('Q2')->setValue('Visit');
	
			$num = 2;
			$inital = $num+1;
			while($fetch_years = mysql_fetch_array($query))
			{
				$evangID = $fetch_years['evangelistID'];				
				$zoneIDre = getzoneID($evangID);
				$confIDre = getConfID($zoneIDre);
				
				if(!empty($fetch_years['Phone']))
				{
					$phone_no = ' - '.$fetch_years['Phone'];
				}
				else
				{
					$phone_no = '';	
				}
				
				$num++;
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':R'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				$objSheet->getStyle('E'.$num.':Q'.$num)->getNumberFormat()->setFormatCode('#,##');
					
				$drugID = $fetch_years['drugid'];
				
				$objSheet->getCell('A'.$num)->setValue($num-2);
				$objSheet->getCell('B'.$num)->setValue(return_Evang_Name($evangID));
				$objSheet->getCell('C'.$num)->setValue(ReturnZoneDetails($zoneIDre,'ZoneName'));
				$objSheet->getCell('D'.$num)->setValue(return_conference_abbrev($confIDre));
				$objSheet->getCell('E'.$num)->setValue($fetch_years['hours']);
				$objSheet->getCell('F'.$num)->setValue($fetch_years['Magazines']);
				$objSheet->getCell('G'.$num)->setValue($fetch_years['books_sold']);
				$objSheet->getCell('H'.$num)->setValue($fetch_years['Value_sales']);
				
				$objSheet->getCell('I'.$num)->setValue($fetch_years['free_literature']);
				$objSheet->getCell('J'.$num)->setValue($fetch_years['v_o_p']);
				$objSheet->getCell('K'.$num)->setValue($fetch_years['people_attending_SS']);
				
				$objSheet->getCell('L'.$num)->setValue($fetch_years['sda_back_slinders']);
				$objSheet->getCell('M'.$num)->setValue($fetch_years['prayers_offered']);
				$objSheet->getCell('N'.$num)->setValue($fetch_years['Bibles_studies_given']);
				$objSheet->getCell('O'.$num)->setValue($fetch_years['people_joining_bapstism_classes']);
				$objSheet->getCell('P'.$num)->setValue($fetch_years['no_baptised']);
				$objSheet->getCell('Q'.$num)->setValue($fetch_years['Waliotembelewa']);
			}//end while loop
			
			$final = $num;
			$num++;
			$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':R'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
			$objSheet->getStyle('E'.$num.':Q'.$num)->getNumberFormat()->setFormatCode('#,##');
			
			$objSheet->mergeCells('A'.$num.':B'.$num);
			$objSheet->getCell('A'.$num)->setValue('TOTAL');
			
			$objSheet->getCell('E'.$num)->setValue('=SUM(E'.$inital.':E'.$final.')');
			$objSheet->getCell('F'.$num)->setValue('=SUM(F'.$inital.':F'.$final.')');
			$objSheet->getCell('G'.$num)->setValue('=SUM(G'.$inital.':G'.$final.')');
			$objSheet->getCell('H'.$num)->setValue('=SUM(H'.$inital.':H'.$final.')');
			$objSheet->getCell('I'.$num)->setValue('=SUM(I'.$inital.':I'.$final.')');
			$objSheet->getCell('J'.$num)->setValue('=SUM(J'.$inital.':J'.$final.')');
			$objSheet->getCell('K'.$num)->setValue('=SUM(K'.$inital.':K'.$final.')');
			$objSheet->getCell('L'.$num)->setValue('=SUM(L'.$inital.':L'.$final.')');
			$objSheet->getCell('M'.$num)->setValue('=SUM(M'.$inital.':M'.$final.')');
			$objSheet->getCell('N'.$num)->setValue('=SUM(N'.$inital.':N'.$final.')');
			$objSheet->getCell('O'.$num)->setValue('=SUM(O'.$inital.':O'.$final.')');
			$objSheet->getCell('P'.$num)->setValue('=SUM(P'.$inital.':P'.$final.')');
			$objSheet->getCell('Q'.$num)->setValue('=SUM(Q'.$inital.':Q'.$final.')');
			
	}
	
	$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setAutoSize(true);
	$objSheet->getColumnDimension('C')->setAutoSize(true);
	$objSheet->getColumnDimension('D')->setAutoSize(true);
	$objSheet->getColumnDimension('E')->setAutoSize(true);
	$objSheet->getColumnDimension('F')->setAutoSize(true);
	$objSheet->getColumnDimension('G')->setAutoSize(true);
	
	$objSheet->getColumnDimension('H')->setAutoSize(true);
	$objSheet->getColumnDimension('I')->setAutoSize(true);
	$objSheet->getColumnDimension('J')->setAutoSize(true);
	$objSheet->getColumnDimension('K')->setAutoSize(true);
	$objSheet->getColumnDimension('L')->setAutoSize(true);
	$objSheet->getColumnDimension('M')->setAutoSize(true);
	$objSheet->getColumnDimension('N')->setAutoSize(true);
	$objSheet->getColumnDimension('O')->setAutoSize(true);
	$objSheet->getColumnDimension('P')->setAutoSize(true);
	$objSheet->getColumnDimension('Q')->setAutoSize(true);
	
	$objWriter->save('Multi_Query_Report.xlsx');
}//end function Multi Query Report


function ExportMonthlyEvangelistsReport($conferenceID,$year,$month,$sql,$order_by_which,$direction,$item_analysed)
{
	require('PHPExcel/Classes/PHPExcel.php');
	require('connection.php');
//require('settings.php');

$sql = "SELECT * FROM zones_lists  WHERE conferenceID='$conferenceID'";
					
  $objPHPExcel = new PHPExcel();
  
  $value_desc = array("hours"=>"Working Hours","books_sold"=>"Books sold","Value_sales"=>"Value of Sale","free_literature"=>"Free Literature","v_o_p"=>"Voice of Prophet","people_attending_SS"=>"Attending SS","sda_back_slinders"=>"Back Slinders","prayers_offered"=>"Prayers Offered","Bibles_studies_given"=>"Bible Studies","people_joining_bapstism_classes"=>"Joining Baptism Classe","no_baptised"=>"Baptized");
  
  $array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
  
  	$message = "Evangelist Monthly Report - ".return_conference_name($conferenceID)." -".$array_months[$month].", ".$year;
  
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Monthly Report'); // renamin the sheet
	
	$query = mysql_query($sql,$connect) or die(mysql_error());
	
	if(mysql_num_rows($query)==0)
	{
		$objSheet->getStyle('A1:S1')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
		$objSheet->getStyle('A2:S2')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12
	
		$objSheet->getCell('A1')->setValue($message);
		$objSheet->getCell('A2')->setValue('No Zones Registered');
		//echo "<br><span class='error'>Hakuna Taarifa yeyote kwa Mtaa Huu</span> <br>";
	}
	else
	{
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A3:J3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	
	$objSheet->getStyle('A1:O1')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A2:O2')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A3:O3')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	
	$objSheet->mergeCells('A1:I1');
	$objSheet->getCell('A1')->setValue($message);
	
	$objSheet->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  
	$objSheet->getCell('A2')->setValue('No');
	
	$objSheet->getCell('B2')->setValue('Evangelist Name');
	
	$objSheet->getCell('C2')->setValue('Grade');
	
	$objSheet->mergeCells('D2:E2');
	$objSheet->getCell('D2')->setValue($value_desc[$item_analysed]);
	
	$objSheet->getCell('F2')->setValue('Increment');
	
	$objSheet->mergeCells('G2:I2');
	$objSheet->getCell('G2')->setValue('Position');
	
	$objSheet->getCell('D3')->setValue($array_months[$month]." ,".($year-1));
	$objSheet->getCell('E3')->setValue($array_months[$month]." ,".($year));
	
	$objSheet->getCell('G3')->setValue('Zone');
	$objSheet->getCell('H3')->setValue('Conference');
	$objSheet->getCell('I3')->setValue('Union');
	
			$num = 3;
			$inital = $num+1;
			while($fetch_years = mysql_fetch_array($query))
			{
				$zoneID = $fetch_years['ID'];
				$fetch_evangelists_Query = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID'",$connect)or die(mysql_error());
				
				$num++;
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':J'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				$objSheet->mergeCells('A'.$num.':I'.$num);
				$objSheet->getCell('A'.$num)->setValue($fetch_years['ZoneName']);
				//$objSheet->getStyle('H'.$num)->getNumberFormat()->setFormatCode('#,##');
					
				$drugID = $fetch_years['drugid'];
				
				if(mysql_num_rows($fetch_evangelists_Query)==0)
				{
					$num++;
					$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':J'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
					$objSheet->mergeCells('A'.$num.':I'.$num);
					$objSheet->getCell('A'.$num)->setValue('No Evangelists Registered in this Zone');
				}
				else
				{
					$counter=0;
					while($fetch_evangelists_results = mysql_fetch_array($fetch_evangelists_Query))
					{
						$counter++;
						$num++;
						$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':J'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
						
						$evangID = $fetch_evangelists_results['ID'];
						$objSheet->getCell('A'.$num)->setValue($counter);
						$objSheet->getCell('B'.$num)->setValue($fetch_evangelists_results['First_Name']." ".$fetch_evangelists_results['Middle_Name']." ".$fetch_evangelists_results['Last_Name']);
						$objSheet->getCell('C'.$num)->setValue(return_grade_Name($fetch_evangelists_results['Grade']));
						$objSheet->getCell('D'.$num)->setValue(Sum_Monthly_Value($evangID,$month,$year-1,$item_analysed));
						$objSheet->getCell('E'.$num)->setValue(Sum_Monthly_Value($evangID,$month,$year,$item_analysed));
						$objSheet->getCell('F'.$num)->setValue('=((E'.$num.'-D'.$num.')/D'.$num.')*100');
						$objSheet->getCell('G'.$num)->setValue(ArrangezoneMonthly($evangID,$month,$year,$item_analysed,$zoneID));
						$objSheet->getCell('H'.$num)->setValue(ArrangeConfMonthly($evangID,$month,$year,$item_analysed,$zoneID,$conferenceID));
						$objSheet->getCell('I'.$num)->setValue(ArrangeUnionMonthly($evangID,$month,$year,$item_analysed,$zoneID,$conferenceID));
					}//end inner While Loop
				}
				
			}//end while loop
			
			
	}
	
	$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setAutoSize(true);
	$objSheet->getColumnDimension('C')->setAutoSize(true);
	$objSheet->getColumnDimension('D')->setAutoSize(true);
	$objSheet->getColumnDimension('E')->setAutoSize(true);
	$objSheet->getColumnDimension('F')->setAutoSize(true);
	$objSheet->getColumnDimension('G')->setAutoSize(true);
	
	$objSheet->getColumnDimension('H')->setAutoSize(true);
	$objSheet->getColumnDimension('I')->setAutoSize(true);
	$objSheet->getColumnDimension('J')->setAutoSize(true);
	$objSheet->getColumnDimension('K')->setAutoSize(true);
	$objSheet->getColumnDimension('L')->setAutoSize(true);
	$objSheet->getColumnDimension('M')->setAutoSize(true);
	$objSheet->getColumnDimension('N')->setAutoSize(true);
	$objSheet->getColumnDimension('O')->setAutoSize(true);
	$objSheet->getColumnDimension('P')->setAutoSize(true);
	$objSheet->getColumnDimension('Q')->setAutoSize(true);
	
	$objWriter->save('Evangellists_Monthly_report.xlsx');
}

function ExportQuarterEvangelistsReport($conferenceID,$year,$month,$sql,$order_by_which,$direction,$item_analysed)
{
	require('PHPExcel/Classes/PHPExcel.php');
	require('connection.php');
//require('settings.php');

$sql = "SELECT * FROM zones_lists  WHERE conferenceID='$conferenceID'";
					
  $objPHPExcel = new PHPExcel();
  
  $value_desc = array("hours"=>"Working Hours","books_sold"=>"Books sold","Value_sales"=>"Value of Sale","free_literature"=>"Free Literature","v_o_p"=>"Voice of Prophet","people_attending_SS"=>"Attending SS","sda_back_slinders"=>"Back Slinders","prayers_offered"=>"Prayers Offered","Bibles_studies_given"=>"Bible Studies","people_joining_bapstism_classes"=>"Joining Baptism Classe","no_baptised"=>"Baptized");
  
  $array_months = array("1"=>"Quarter One","2"=>"Quarter Two","3"=>"Quarter Three","4"=>"Quarter Four");
  
  	$message = "Evangelist Quartely Report - ".return_conference_name($conferenceID)." -".$array_months[$month].", ".$year;
  
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Quartely Report'); // renamin the sheet
	
	$query = mysql_query($sql,$connect) or die(mysql_error());
	
	if(mysql_num_rows($query)==0)
	{
		$objSheet->getStyle('A1:S1')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
		$objSheet->getStyle('A2:S2')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12
	
		$objSheet->getCell('A1')->setValue($message);
		$objSheet->getCell('A2')->setValue('No Zones Registered');
		//echo "<br><span class='error'>Hakuna Taarifa yeyote kwa Mtaa Huu</span> <br>";
	}
	else
	{
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A3:J3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	
	$objSheet->getStyle('A1:O1')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A2:O2')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A3:O3')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	
	$objSheet->mergeCells('A1:I1');
	$objSheet->getCell('A1')->setValue($message);
	
	$objSheet->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  
	$objSheet->getCell('A2')->setValue('No');
	
	$objSheet->getCell('B2')->setValue('Evangelist Name');
	
	$objSheet->getCell('C2')->setValue('Grade');
	
	$objSheet->mergeCells('D2:E2');
	$objSheet->getCell('D2')->setValue($value_desc[$item_analysed]);
	
	$objSheet->getCell('F2')->setValue('Increment');
	
	$objSheet->mergeCells('G2:I2');
	$objSheet->getCell('G2')->setValue('Position');
	
	$objSheet->getCell('D3')->setValue($array_months[$month]." ,".($year-1));
	$objSheet->getCell('E3')->setValue($array_months[$month]." ,".($year));
	
	$objSheet->getCell('G3')->setValue('Zone');
	$objSheet->getCell('H3')->setValue('Conference');
	$objSheet->getCell('I3')->setValue('Union');
	
			$num = 3;
			$inital = $num+1;
			while($fetch_years = mysql_fetch_array($query))
			{
				$zoneID = $fetch_years['ID'];
				$fetch_evangelists_Query = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID'",$connect)or die(mysql_error());
				
				$num++;
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':J'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				$objSheet->mergeCells('A'.$num.':I'.$num);
				$objSheet->getCell('A'.$num)->setValue($fetch_years['ZoneName']);
				//$objSheet->getStyle('H'.$num)->getNumberFormat()->setFormatCode('#,##');
					
				$drugID = $fetch_years['drugid'];
				
				if(mysql_num_rows($fetch_evangelists_Query)==0)
				{
					$num++;
					$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':J'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
					$objSheet->mergeCells('A'.$num.':I'.$num);
					$objSheet->getCell('A'.$num)->setValue('No Evangelists Registered in this Zone');
				}
				else
				{
					$counter=0;
					while($fetch_evangelists_results = mysql_fetch_array($fetch_evangelists_Query))
					{
						$counter++;
						$num++;
						$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':J'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
						
						$evangID = $fetch_evangelists_results['ID'];
						$objSheet->getCell('A'.$num)->setValue($counter);
						$objSheet->getCell('B'.$num)->setValue($fetch_evangelists_results['First_Name']." ".$fetch_evangelists_results['Middle_Name']." ".$fetch_evangelists_results['Last_Name']);
						$objSheet->getCell('C'.$num)->setValue(return_grade_Name($fetch_evangelists_results['Grade']));
						$objSheet->getCell('D'.$num)->setValue(Sum_Item_Quarter($evangID,$month,$year-1,$item_analysed));
						$objSheet->getCell('E'.$num)->setValue(Sum_Item_Quarter($evangID,$month,$year,$item_analysed));
						$objSheet->getCell('F'.$num)->setValue('=((E'.$num.'-D'.$num.')/D'.$num.')*100');
						$objSheet->getCell('G'.$num)->setValue(ArrangezoneQuarter($evangID,$month,$year,$item_analysed,$zoneID));
						$objSheet->getCell('H'.$num)->setValue(ArrangeConfQuarter($evangID,$month,$year,$item_analysed,$zoneID,$conferenceID));
						$objSheet->getCell('I'.$num)->setValue(ArrangeUnionQuarter($evangID,$month,$year,$item_analysed,$zoneID,$conferenceID));
					}//end inner While Loop
				}
				
			}//end while loop
			
			
	}
	
	$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setAutoSize(true);
	$objSheet->getColumnDimension('C')->setAutoSize(true);
	$objSheet->getColumnDimension('D')->setAutoSize(true);
	$objSheet->getColumnDimension('E')->setAutoSize(true);
	$objSheet->getColumnDimension('F')->setAutoSize(true);
	$objSheet->getColumnDimension('G')->setAutoSize(true);
	
	$objSheet->getColumnDimension('H')->setAutoSize(true);
	$objSheet->getColumnDimension('I')->setAutoSize(true);
	$objSheet->getColumnDimension('J')->setAutoSize(true);
	$objSheet->getColumnDimension('K')->setAutoSize(true);
	$objSheet->getColumnDimension('L')->setAutoSize(true);
	$objSheet->getColumnDimension('M')->setAutoSize(true);
	$objSheet->getColumnDimension('N')->setAutoSize(true);
	$objSheet->getColumnDimension('O')->setAutoSize(true);
	$objSheet->getColumnDimension('P')->setAutoSize(true);
	$objSheet->getColumnDimension('Q')->setAutoSize(true);
	
	$objWriter->save('Evangellists_Quarter_report.xlsx');
}


function ExportCustomEvangelistsReport($conferenceID,$year,$month,$sql,$order_by_which,$direction,$item_analysed,$start_month)
{
	require('PHPExcel/Classes/PHPExcel.php');
	require('connection.php');
//require('settings.php');

$sql = "SELECT * FROM zones_lists  WHERE conferenceID='$conferenceID'";
					
  $objPHPExcel = new PHPExcel();
  
  $value_desc = array("hours"=>"Working Hours","books_sold"=>"Books sold","Value_sales"=>"Value of Sale","free_literature"=>"Free Literature","v_o_p"=>"Voice of Prophet","people_attending_SS"=>"Attending SS","sda_back_slinders"=>"Back Slinders","prayers_offered"=>"Prayers Offered","Bibles_studies_given"=>"Bible Studies","people_joining_bapstism_classes"=>"Joining Baptism Classe","no_baptised"=>"Baptized");
  
  $array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
  
  	$message = "Evangelist Custom Report - ".return_conference_name($conferenceID)." -".$array_months[$start_month]." To ".$array_months[$month].", ".$year;
  
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Custom Report'); // renamin the sheet
	
	$query = mysql_query($sql,$connect) or die(mysql_error());
	
	if(mysql_num_rows($query)==0)
	{
		$objSheet->getStyle('A1:S1')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
		$objSheet->getStyle('A2:S2')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12
	
		$objSheet->getCell('A1')->setValue($message);
		$objSheet->getCell('A2')->setValue('No Zones Registered');
		//echo "<br><span class='error'>Hakuna Taarifa yeyote kwa Mtaa Huu</span> <br>";
	}
	else
	{
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A3:J3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	
	$objSheet->getStyle('A1:O1')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A2:O2')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A3:O3')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	
	$objSheet->mergeCells('A1:I1');
	$objSheet->getCell('A1')->setValue($message);
	
	$objSheet->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  
	$objSheet->getCell('A2')->setValue('No');
	
	$objSheet->getCell('B2')->setValue('Evangelist Name');
	
	$objSheet->getCell('C2')->setValue('Grade');
	
	$objSheet->mergeCells('D2:E2');
	$objSheet->getCell('D2')->setValue($value_desc[$item_analysed]);
	
	$objSheet->getCell('F2')->setValue('Increment');
	
	$objSheet->mergeCells('G2:I2');
	$objSheet->getCell('G2')->setValue('Position');
	
	$objSheet->getCell('D3')->setValue($array_months[$start_month]." To ".$array_months[$month]." ,".($year-1));
	$objSheet->getCell('E3')->setValue($array_months[$start_month]." To ".$array_months[$month]." ,".($year));
	
	$objSheet->getCell('G3')->setValue('Zone');
	$objSheet->getCell('H3')->setValue('Conference');
	$objSheet->getCell('I3')->setValue('Union');
	
			$num = 3;
			$inital = $num+1;
			while($fetch_years = mysql_fetch_array($query))
			{
				$zoneID = $fetch_years['ID'];
				$fetch_evangelists_Query = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID'",$connect)or die(mysql_error());
				
				$num++;
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':J'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				$objSheet->mergeCells('A'.$num.':I'.$num);
				$objSheet->getCell('A'.$num)->setValue($fetch_years['ZoneName']);
				//$objSheet->getStyle('H'.$num)->getNumberFormat()->setFormatCode('#,##');
					
				$drugID = $fetch_years['drugid'];
				
				if(mysql_num_rows($fetch_evangelists_Query)==0)
				{
					$num++;
					$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':J'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
					$objSheet->mergeCells('A'.$num.':I'.$num);
					$objSheet->getCell('A'.$num)->setValue('No Evangelists Registered in this Zone');
				}
				else
				{
					$counter=0;
					while($fetch_evangelists_results = mysql_fetch_array($fetch_evangelists_Query))
					{
						$counter++;
						$num++;
						$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':J'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
						
						$evangID = $fetch_evangelists_results['ID'];
						$objSheet->getCell('A'.$num)->setValue($counter);
						$objSheet->getCell('B'.$num)->setValue($fetch_evangelists_results['First_Name']." ".$fetch_evangelists_results['Middle_Name']." ".$fetch_evangelists_results['Last_Name']);
						$objSheet->getCell('C'.$num)->setValue(return_grade_Name($fetch_evangelists_results['Grade']));
						$objSheet->getCell('D'.$num)->setValue(Sum_Item_Custom($evangID,$month,$year-1,$item_analysed,$start_month));
						$objSheet->getCell('E'.$num)->setValue(Sum_Item_Custom($evangID,$month,$year,$item_analysed,$start_month));
						$objSheet->getCell('F'.$num)->setValue('=((E'.$num.'-D'.$num.')/D'.$num.')*100');
						$objSheet->getCell('G'.$num)->setValue(ArrangezoneCustom($evangID,$month,$year,$item_analysed,$zoneID,$start_month));
						$objSheet->getCell('H'.$num)->setValue(ArrangeConfCustom($evangID,$month,$year,$item_analysed,$zoneID,$conferenceID,$start_month));
						$objSheet->getCell('I'.$num)->setValue(ArrangeUnionCustom($evangID,$month,$year,$item_analysed,$zoneID,$conferenceID,$start_month));
					}//end inner While Loop
				}
				
			}//end while loop
			
			
	}
	
	$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setAutoSize(true);
	$objSheet->getColumnDimension('C')->setAutoSize(true);
	$objSheet->getColumnDimension('D')->setAutoSize(true);
	$objSheet->getColumnDimension('E')->setAutoSize(true);
	$objSheet->getColumnDimension('F')->setAutoSize(true);
	$objSheet->getColumnDimension('G')->setAutoSize(true);
	
	$objSheet->getColumnDimension('H')->setAutoSize(true);
	$objSheet->getColumnDimension('I')->setAutoSize(true);
	$objSheet->getColumnDimension('J')->setAutoSize(true);
	$objSheet->getColumnDimension('K')->setAutoSize(true);
	$objSheet->getColumnDimension('L')->setAutoSize(true);
	$objSheet->getColumnDimension('M')->setAutoSize(true);
	$objSheet->getColumnDimension('N')->setAutoSize(true);
	$objSheet->getColumnDimension('O')->setAutoSize(true);
	$objSheet->getColumnDimension('P')->setAutoSize(true);
	$objSheet->getColumnDimension('Q')->setAutoSize(true);
	
	$objWriter->save('Evangellists_Custom_report.xlsx');
}

function MultiQueryReportQuarter($month,$year,$order_by,$sql)
{
	require('PHPExcel/Classes/PHPExcel.php');
	require('connection.php');
//require('settings.php');

//$sql = "SELECT * FROM evangelists_monthly_report WHERE year='$year' AND month='$month'  ORDER BY $order_by DESC";
					

  $objPHPExcel = new PHPExcel();
  $array_months = array("1"=>"Quarter One","2"=>"Quarter Two","3"=>"Quarter Three","4"=>"Quarter Four");
  
  	$message = "Multi Query Report ".$array_months[$month].", ".$year;
  
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Multi Query Report Quarter'); // renamin the sheet
	
	$query = mysql_query($sql,$connect) or die(mysql_error());
	
	if(mysql_num_rows($query)==0)
	{
		$objSheet->getStyle('A1:S1')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
		$objSheet->getStyle('A2:S2')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12
	
		$objSheet->getCell('A1')->setValue($message);
		$objSheet->getCell('A2')->setValue('No Report');
		//echo "<br><span class='error'>Hakuna Taarifa yeyote kwa Mtaa Huu</span> <br>";
	}
	else
	{
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A2:R2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	
	$objSheet->getStyle('A1:Q1')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A2:Q2')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	
	
	$objSheet->mergeCells('A1:O1');
	$objSheet->getCell('A1')->setValue($message);
	
	$objSheet->getStyle('A1:O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A2:Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  
	$objSheet->getCell('A2')->setValue('No');
	
	$objSheet->getCell('B2')->setValue('Evangelist Name');
	
	$objSheet->getCell('C2')->setValue('Zone');
	
	$objSheet->getCell('D2')->setValue('Conference');
	$objSheet->getCell('E2')->setValue('Hours');
	$objSheet->getCell('F2')->setValue('Magazines');
	$objSheet->getCell('G2')->setValue('Books Sold');
	$objSheet->getCell('H2')->setValue('Value of Sale');
	$objSheet->getCell('I2')->setValue('Free Literature');
	
	$objSheet->getCell('J2')->setValue('VOP');
	$objSheet->getCell('K2')->setValue('Attending SS');
	
	$objSheet->getCell('L2')->setValue('Back Slinders');
	$objSheet->getCell('M2')->setValue('Prayers');
	$objSheet->getCell('N2')->setValue('Bible Studies');
	$objSheet->getCell('O2')->setValue('Baptism Classes');
	$objSheet->getCell('P2')->setValue('Baptized');
	$objSheet->getCell('Q2')->setValue('Visit');
	
			$num = 2;
			$inital = $num+1;
			while($fetch_years = mysql_fetch_array($query))
			{
				$evangID = $fetch_years['evangelistID'];				
				$zoneIDre = getzoneID($evangID);
				$confIDre = getConfID($zoneIDre);
				
				$num++;
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':R'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				$objSheet->getStyle('E'.$num.':Q'.$num)->getNumberFormat()->setFormatCode('#,##');
					
				$drugID = $fetch_years['drugid'];
				
				$objSheet->getCell('A'.$num)->setValue($num-2);
				$objSheet->getCell('B'.$num)->setValue(return_Evang_Name($evangID));
				$objSheet->getCell('C'.$num)->setValue(ReturnZoneDetails($zoneIDre,'ZoneName'));
				$objSheet->getCell('D'.$num)->setValue(return_conference_abbrev($confIDre));
				$objSheet->getCell('E'.$num)->setValue($fetch_years['hours']);
				$objSheet->getCell('F'.$num)->setValue($fetch_years['Magazines']);
				$objSheet->getCell('G'.$num)->setValue($fetch_years['books_sold']);
				$objSheet->getCell('H'.$num)->setValue($fetch_years['Value_sales']);
				
				$objSheet->getCell('I'.$num)->setValue($fetch_years['free_literature']);
				$objSheet->getCell('J'.$num)->setValue($fetch_years['v_o_p']);
				$objSheet->getCell('K'.$num)->setValue($fetch_years['people_attending_SS']);
				
				$objSheet->getCell('L'.$num)->setValue($fetch_years['sda_back_slinders']);
				$objSheet->getCell('M'.$num)->setValue($fetch_years['prayers_offered']);
				$objSheet->getCell('N'.$num)->setValue($fetch_years['Bibles_studies_given']);
				$objSheet->getCell('O'.$num)->setValue($fetch_years['people_joining_bapstism_classes']);
				$objSheet->getCell('P'.$num)->setValue($fetch_years['no_baptised']);
				$objSheet->getCell('Q'.$num)->setValue($fetch_years['Waliotembelewa']);
			}//end while loop
			
			$final = $num;
			$num++;
			$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':R'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
			$objSheet->getStyle('E'.$num.':Q'.$num)->getNumberFormat()->setFormatCode('#,##');
			
			$objSheet->mergeCells('A'.$num.':B'.$num);
			$objSheet->getCell('A'.$num)->setValue('TOTAL');
			
			$objSheet->getCell('E'.$num)->setValue('=SUM(E'.$inital.':E'.$final.')');
			$objSheet->getCell('F'.$num)->setValue('=SUM(F'.$inital.':F'.$final.')');
			$objSheet->getCell('G'.$num)->setValue('=SUM(G'.$inital.':G'.$final.')');
			$objSheet->getCell('H'.$num)->setValue('=SUM(H'.$inital.':H'.$final.')');
			$objSheet->getCell('I'.$num)->setValue('=SUM(I'.$inital.':I'.$final.')');
			$objSheet->getCell('J'.$num)->setValue('=SUM(J'.$inital.':J'.$final.')');
			$objSheet->getCell('K'.$num)->setValue('=SUM(K'.$inital.':K'.$final.')');
			$objSheet->getCell('L'.$num)->setValue('=SUM(L'.$inital.':L'.$final.')');
			$objSheet->getCell('M'.$num)->setValue('=SUM(M'.$inital.':M'.$final.')');
			$objSheet->getCell('N'.$num)->setValue('=SUM(N'.$inital.':N'.$final.')');
			$objSheet->getCell('O'.$num)->setValue('=SUM(O'.$inital.':O'.$final.')');
			$objSheet->getCell('P'.$num)->setValue('=SUM(P'.$inital.':P'.$final.')');
			$objSheet->getCell('Q'.$num)->setValue('=SUM(Q'.$inital.':Q'.$final.')');
			
	}
	
	$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setAutoSize(true);
	$objSheet->getColumnDimension('C')->setAutoSize(true);
	$objSheet->getColumnDimension('D')->setAutoSize(true);
	$objSheet->getColumnDimension('E')->setAutoSize(true);
	$objSheet->getColumnDimension('F')->setAutoSize(true);
	$objSheet->getColumnDimension('G')->setAutoSize(true);
	
	$objSheet->getColumnDimension('H')->setAutoSize(true);
	$objSheet->getColumnDimension('I')->setAutoSize(true);
	$objSheet->getColumnDimension('J')->setAutoSize(true);
	$objSheet->getColumnDimension('K')->setAutoSize(true);
	$objSheet->getColumnDimension('L')->setAutoSize(true);
	$objSheet->getColumnDimension('M')->setAutoSize(true);
	$objSheet->getColumnDimension('N')->setAutoSize(true);
	$objSheet->getColumnDimension('O')->setAutoSize(true);
	$objSheet->getColumnDimension('P')->setAutoSize(true);
	$objSheet->getColumnDimension('Q')->setAutoSize(true);
	
	$objWriter->save('Multi_Query_Report_Quarter.xlsx');
}//end function Multi Query Report

function UnionMonthlyReportExport($month,$year)
{
	require('PHPExcel/Classes/PHPExcel.php');
	require('connection.php');
	//require('settings.php');

    $array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
  
	
	$objPHPExcel = new PHPExcel();
  
  	$message = "UNION MONTHLY SUMMARY REPORT TO DIVISION ";
  
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Union Monthly Summary'); // renamin the sheet
	
	$query = mysql_query("SELECT * FROM conferences_list",$connect) or die(mysql_error());
	
	if(mysql_num_rows($query)==0)
	{
		$objSheet->getStyle('A1:S1')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
		$objSheet->getStyle('A2:S2')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12
	
		$objSheet->getCell('A1')->setValue('UNION MONTHLY SUMMARY REPORT TO DIVISION');
		$objSheet->getCell('A2')->setValue('No Monthly Report');
		//echo "<br><span class='error'>Hakuna Taarifa yeyote kwa Mtaa Huu</span> <br>";
	}
	else
	{
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A3:P3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A4:P4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A5:P5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A6:P6')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A7:P7')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	
	$objPHPExcel->getActiveSheet()->getStyle('A6:P6')->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('A7:P7')->getAlignment()->setWrapText(true);
	
	$objSheet->getStyle('H5')->getFont()->setBold(true)->setSize(10);
	
	$objSheet->getStyle('A1:J1')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A2:J2')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A3:J3')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('G5')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
	
	$objSheet->mergeCells('A1:O1');
	$objSheet->getCell('A1')->setValue('UNION MONTHLY SUMMARY REPORT TO DIVISION');
	
	$objSheet->mergeCells('A2:O2');
	$objSheet->getCell('A2')->setValue('PUBLISHING MINISTRIES DEPARTMENT ');
	
	$objSheet->mergeCells('A3:O3');
	$objSheet->getCell('A3')->setValue('UNION: NTUC , MONTH: '.$array_months[$month]);
	
	$objSheet->getCell('G5')->setValue('Ext.Rt.');
	
	$objSheet->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A2:N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A3:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  
	$objSheet->getStyle('A6:O6')->getFont()->setBold(true)->setSize(10);
	$objSheet->getStyle('A7:O7')->getFont()->setBold(true)->setSize(10);
	
	$objSheet->getCell('A6')->setValue('Reporting organization');
	$objSheet->getCell('A7')->setValue('Conferences Mission/Field');
	
	$objSheet->mergeCells('B6:B7');
	$objSheet->getCell('B6')->setValue('No. of PMD LARS');
	
	$objSheet->mergeCells('C6:G6');
	$objSheet->getCell('C6')->setValue('No. of literature Evangelists');
	
	$objSheet->getCell('C7')->setValue('ID');
	$objSheet->getCell('D7')->setValue('L');
	$objSheet->getCell('E7')->setValue('C');
	$objSheet->getCell('F7')->setValue('PT');
	$objSheet->getCell('G7')->setValue('TOTAL');
	
	$objSheet->mergeCells('H6:H7');
	$objSheet->getCell('H6')->setValue('Total no. hours works');
	
	$objSheet->mergeCells('I6:I7');
	$objSheet->getCell('I6')->setValue('Total sales in US $');
	
	$objSheet->mergeCells('I6:I7');
	$objSheet->getCell('I6')->setValue('Total sales in US $');
	
	$objSheet->mergeCells('J6:J7');
	$objSheet->getCell('J6')->setValue('No. of Books et magazines sold');
	
	$objSheet->mergeCells('K6:K7');
	$objSheet->getCell('K6')->setValue('Free Literature Given');
	
	$objSheet->mergeCells('L6:L7');
	$objSheet->getCell('L6')->setValue('Prayers offered');
	
	$objSheet->mergeCells('M6:M7');
	$objSheet->getCell('M6')->setValue('No. of Homes Visited');
	
	$objSheet->mergeCells('N6:N7');
	$objSheet->getCell('N6')->setValue('Interest Contacts for Bibles studies');
	
	$objSheet->mergeCells('O6:O7');
	$objSheet->getCell('O6')->setValue('LE contact Baptized');
	
			$num = 8;
			$inital = $num;
			while($fetch_years = mysql_fetch_array($query))
			{
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':P'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				$objSheet->getStyle('A'.$num.':O'.$num)->getNumberFormat()->setFormatCode('#,##');
				//$objSheet->getStyle('H'.$num)->getNumberFormat()->setFormatCode('#,##');
					
				$confID = $fetch_years['ID'];
				
				$objSheet->getCell('A'.$num)->setValue($fetch_years['Abbreviation']);
				
				$objSheet->getCell('C'.$num)->setValue(NumberEvangelistsUnion($confID,'I'));
				$objSheet->getCell('D'.$num)->setValue(NumberEvangelistsUnion($confID,'II'));
				$objSheet->getCell('E'.$num)->setValue(NumberEvangelistsUnion($confID,'III'));
				$objSheet->getCell('F'.$num)->setValue(NumberEvangelistsUnion($confID,'PT'));
				
				$objSheet->getCell('G'.$num)->setValue('=SUM(C'.$num.':F'.$num.')');
				
				$objSheet->getCell('H'.$num)->setValue(UnionMonthlyFigure($confID,$month,$year,'hours'));
				$objSheet->getCell('I'.$num)->setValue('='.(UnionMonthlyFigure($confID,$month,$year,'Value_sales')).'/H5');
				$objSheet->getCell('J'.$num)->setValue(UnionMonthlyFigure($confID,$month,$year,'books_sold+Magazines'));
				$objSheet->getCell('K'.$num)->setValue(UnionMonthlyFigure($confID,$month,$year,'free_literature'));
				$objSheet->getCell('L'.$num)->setValue(UnionMonthlyFigure($confID,$month,$year,'prayers_offered'));
				$objSheet->getCell('M'.$num)->setValue(UnionMonthlyFigure($confID,$month,$year,'Waliotembelewa'));
				$objSheet->getCell('N'.$num)->setValue(UnionMonthlyFigure($confID,$month,$year,'Bibles_studies_given'));
				$objSheet->getCell('O'.$num)->setValue(UnionMonthlyFigure($confID,$month,$year,'no_baptised'));
				$num = $num + 2;
				
			}//end while loop
			
			$final = $num;
			$num=$num+ 2;
			$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':P'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
			$objSheet->getStyle('A'.$num.':O'.$num)->getFont()->setBold(true)->setSize(10);
			$objSheet->getStyle('A'.$num.':O'.$num)->getNumberFormat()->setFormatCode('#,##');
			
			$objSheet->getCell('A'.$num)->setValue('TOTAL');
			
			$objSheet->getCell('B'.$num)->setValue('=SUM(B'.$inital.':B'.$final.')');
			$objSheet->getCell('C'.$num)->setValue('=SUM(C'.$inital.':C'.$final.')');
			$objSheet->getCell('D'.$num)->setValue('=SUM(D'.$inital.':D'.$final.')');
			$objSheet->getCell('E'.$num)->setValue('=SUM(E'.$inital.':E'.$final.')');
			$objSheet->getCell('F'.$num)->setValue('=SUM(F'.$inital.':F'.$final.')');
			$objSheet->getCell('G'.$num)->setValue('=SUM(G'.$inital.':G'.$final.')');
			$objSheet->getCell('H'.$num)->setValue('=SUM(H'.$inital.':H'.$final.')');
			$objSheet->getCell('I'.$num)->setValue('=SUM(I'.$inital.':I'.$final.')');
			$objSheet->getCell('J'.$num)->setValue('=SUM(J'.$inital.':J'.$final.')');
			$objSheet->getCell('K'.$num)->setValue('=SUM(K'.$inital.':K'.$final.')');
			$objSheet->getCell('L'.$num)->setValue('=SUM(L'.$inital.':L'.$final.')');
			$objSheet->getCell('M'.$num)->setValue('=SUM(M'.$inital.':M'.$final.')');
			$objSheet->getCell('N'.$num)->setValue('=SUM(N'.$inital.':N'.$final.')');
			$objSheet->getCell('O'.$num)->setValue('=SUM(O'.$inital.':O'.$final.')');
			
			$num = $num + 3;
			$objSheet->getStyle('A'.$num.':O'.$num)->getFont()->setBold(true)->setSize(10);
			
			$objSheet->mergeCells('A'.$num.':E'.$num);
			$objSheet->getCell('A'.$num)->setValue('Northern Tanzania Union Conference');
			
			$objSheet->mergeCells('K'.$num.':O'.$num);
			$objSheet->getCell('K'.$num)->setValue('Pr. Davis Fue');
			
			$num++;
			$objSheet->mergeCells('K'.$num.':O'.$num);
			$objSheet->getStyle('A'.$num.':O'.$num)->getFont()->setBold(true)->setItalic(true)->setSize(10);
			$objSheet->getCell('K'.$num)->setValue('Signed: Union Publishing Director');
	}
	
	
	$objWriter->save('Union_Summary_Monthly_Report.xlsx');
}//end function

function UnionQuarterlyReportExport($month,$year)
{
	require('PHPExcel/Classes/PHPExcel.php');
	require('connection.php');
	//require('settings.php');

    $array_months = array("1"=>"Quarter One","2"=>"Quarter Two","3"=>"Quarter Three","4"=>"Quarter Four");
  
	
	$objPHPExcel = new PHPExcel();
  
  	$message = "UNION QUARTER SUMMARY REPORT TO DIVISION ";
  
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Union Quartely Summary'); // renamin the sheet
	
	$query = mysql_query("SELECT * FROM conferences_list",$connect) or die(mysql_error());
	
	if(mysql_num_rows($query)==0)
	{
		$objSheet->getStyle('A1:S1')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
		$objSheet->getStyle('A2:S2')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12
	
		$objSheet->getCell('A1')->setValue('UNION MONTHLY SUMMARY REPORT TO DIVISION');
		$objSheet->getCell('A2')->setValue('No Monthly Report');
		//echo "<br><span class='error'>Hakuna Taarifa yeyote kwa Mtaa Huu</span> <br>";
	}
	else
	{
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A3:P3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A4:P4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A5:P5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A6:P6')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A7:P7')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	
	$objPHPExcel->getActiveSheet()->getStyle('A6:P6')->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('A7:P7')->getAlignment()->setWrapText(true);
	
	$objSheet->getStyle('H5')->getFont()->setBold(true)->setSize(10);
	
	$objSheet->getStyle('A1:J1')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A2:J2')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A3:J3')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('G5')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
	
	$objSheet->mergeCells('A1:O1');
	$objSheet->getCell('A1')->setValue('UNION MONTHLY SUMMARY REPORT TO DIVISION');
	
	$objSheet->mergeCells('A2:O2');
	$objSheet->getCell('A2')->setValue('PUBLISHING MINISTRIES DEPARTMENT ');
	
	$objSheet->mergeCells('A3:O3');
	$objSheet->getCell('A3')->setValue('UNION: NTUC , MONTH: '.$array_months[$month]);
	
	$objSheet->getCell('G5')->setValue('Ext.Rt.');
	
	$objSheet->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A2:N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A3:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  
	$objSheet->getStyle('A6:O6')->getFont()->setBold(true)->setSize(10);
	$objSheet->getStyle('A7:O7')->getFont()->setBold(true)->setSize(10);
	
	$objSheet->getCell('A6')->setValue('Reporting organization');
	$objSheet->getCell('A7')->setValue('Conferences Mission/Field');
	
	$objSheet->mergeCells('B6:B7');
	$objSheet->getCell('B6')->setValue('No. of PMD LARS');
	
	$objSheet->mergeCells('C6:G6');
	$objSheet->getCell('C6')->setValue('No. of literature Evangelists');
	
	$objSheet->getCell('C7')->setValue('ID');
	$objSheet->getCell('D7')->setValue('L');
	$objSheet->getCell('E7')->setValue('C');
	$objSheet->getCell('F7')->setValue('PT');
	$objSheet->getCell('G7')->setValue('TOTAL');
	
	$objSheet->mergeCells('H6:H7');
	$objSheet->getCell('H6')->setValue('Total no. hours works');
	
	$objSheet->mergeCells('I6:I7');
	$objSheet->getCell('I6')->setValue('Total sales in US $');
	
	$objSheet->mergeCells('I6:I7');
	$objSheet->getCell('I6')->setValue('Total sales in US $');
	
	$objSheet->mergeCells('J6:J7');
	$objSheet->getCell('J6')->setValue('No. of Books et magazines sold');
	
	$objSheet->mergeCells('K6:K7');
	$objSheet->getCell('K6')->setValue('Free Literature Given');
	
	$objSheet->mergeCells('L6:L7');
	$objSheet->getCell('L6')->setValue('Prayers offered');
	
	$objSheet->mergeCells('M6:M7');
	$objSheet->getCell('M6')->setValue('No. of Homes Visited');
	
	$objSheet->mergeCells('N6:N7');
	$objSheet->getCell('N6')->setValue('Interest Contacts for Bibles studies');
	
	$objSheet->mergeCells('O6:O7');
	$objSheet->getCell('O6')->setValue('LE contact Baptized');
	
			$num = 8;
			$inital = $num;
			while($fetch_years = mysql_fetch_array($query))
			{
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':P'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				$objSheet->getStyle('A'.$num.':O'.$num)->getNumberFormat()->setFormatCode('#,##');
				//$objSheet->getStyle('H'.$num)->getNumberFormat()->setFormatCode('#,##');
					
				$confID = $fetch_years['ID'];
				
				$objSheet->getCell('A'.$num)->setValue($fetch_years['Abbreviation']);
				
				$objSheet->getCell('C'.$num)->setValue(NumberEvangelistsUnion($confID,'I'));
				$objSheet->getCell('D'.$num)->setValue(NumberEvangelistsUnion($confID,'II'));
				$objSheet->getCell('E'.$num)->setValue(NumberEvangelistsUnion($confID,'III'));
				$objSheet->getCell('F'.$num)->setValue(NumberEvangelistsUnion($confID,'PT'));
				
				$objSheet->getCell('G'.$num)->setValue('=SUM(C'.$num.':F'.$num.')');
				
				$objSheet->getCell('H'.$num)->setValue(UnionQuartelyFigure($confID,$month,$year,'hours'));
				$objSheet->getCell('I'.$num)->setValue('='.(UnionQuartelyFigure($confID,$month,$year,'Value_sales')).'/H5');
				$objSheet->getCell('J'.$num)->setValue(UnionQuartelyFigure($confID,$month,$year,'books_sold+Magazines'));
				$objSheet->getCell('K'.$num)->setValue(UnionQuartelyFigure($confID,$month,$year,'free_literature'));
				$objSheet->getCell('L'.$num)->setValue(UnionQuartelyFigure($confID,$month,$year,'prayers_offered'));
				$objSheet->getCell('M'.$num)->setValue(UnionQuartelyFigure($confID,$month,$year,'Waliotembelewa'));
				$objSheet->getCell('N'.$num)->setValue(UnionQuartelyFigure($confID,$month,$year,'Bibles_studies_given'));
				$objSheet->getCell('O'.$num)->setValue(UnionQuartelyFigure($confID,$month,$year,'no_baptised'));
				$num = $num + 2;
				
			}//end while loop
			
			$final = $num;
			$num=$num+ 2;
			$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':P'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
			$objSheet->getStyle('A'.$num.':O'.$num)->getFont()->setBold(true)->setSize(10);
			$objSheet->getStyle('A'.$num.':O'.$num)->getNumberFormat()->setFormatCode('#,##');
			
			$objSheet->getCell('A'.$num)->setValue('TOTAL');
			
			$objSheet->getCell('B'.$num)->setValue('=SUM(B'.$inital.':B'.$final.')');
			$objSheet->getCell('C'.$num)->setValue('=SUM(C'.$inital.':C'.$final.')');
			$objSheet->getCell('D'.$num)->setValue('=SUM(D'.$inital.':D'.$final.')');
			$objSheet->getCell('E'.$num)->setValue('=SUM(E'.$inital.':E'.$final.')');
			$objSheet->getCell('F'.$num)->setValue('=SUM(F'.$inital.':F'.$final.')');
			$objSheet->getCell('G'.$num)->setValue('=SUM(G'.$inital.':G'.$final.')');
			$objSheet->getCell('H'.$num)->setValue('=SUM(H'.$inital.':H'.$final.')');
			$objSheet->getCell('I'.$num)->setValue('=SUM(I'.$inital.':I'.$final.')');
			$objSheet->getCell('J'.$num)->setValue('=SUM(J'.$inital.':J'.$final.')');
			$objSheet->getCell('K'.$num)->setValue('=SUM(K'.$inital.':K'.$final.')');
			$objSheet->getCell('L'.$num)->setValue('=SUM(L'.$inital.':L'.$final.')');
			$objSheet->getCell('M'.$num)->setValue('=SUM(M'.$inital.':M'.$final.')');
			$objSheet->getCell('N'.$num)->setValue('=SUM(N'.$inital.':N'.$final.')');
			$objSheet->getCell('O'.$num)->setValue('=SUM(O'.$inital.':O'.$final.')');
			
			$num = $num + 3;
			$objSheet->getStyle('A'.$num.':O'.$num)->getFont()->setBold(true)->setSize(10);
			
			$objSheet->mergeCells('A'.$num.':E'.$num);
			$objSheet->getCell('A'.$num)->setValue('Northern Tanzania Union Conference');
			
			$objSheet->mergeCells('K'.$num.':O'.$num);
			$objSheet->getCell('K'.$num)->setValue('Pr. Davis Fue');
			
			$num++;
			$objSheet->mergeCells('K'.$num.':O'.$num);
			$objSheet->getStyle('A'.$num.':O'.$num)->getFont()->setBold(true)->setItalic(true)->setSize(10);
			$objSheet->getCell('K'.$num)->setValue('Signed: Union Publishing Director');
	}
	
	
	$objWriter->save('Union_Summary_Quartely_Report.xlsx');
}//end function

?>