<?php

function Export_Zone_Monthly_Report($confID,$sql,$zoneID,$month,$year)
{
	require('PHPExcel/Classes/PHPExcel.php');
require('connection.php');
//require('settings.php');

$array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

  $objPHPExcel = new PHPExcel();
  
  	$message = "Evangelists Monthly Report - ".ReturnZoneDetails($zoneID,'ZoneName')." Zone - ".return_conference_name($confID)."(".return_conference_abbrev($confID).") ".$array_months[$month]." ,".$year;
  
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Zone Evangelists Report'); // renamin the sheet
	
	$query = mysql_query($sql,$connect) or die(mysql_error());
	
	if(mysql_num_rows($query)==0)
	{
		$objSheet->getStyle('A1:S1')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
		$objSheet->getStyle('A2:S2')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12
	
		$objSheet->getCell('A1')->setValue($message);
		$objSheet->getCell('A2')->setValue('Zone Evangelists Monthly Report');
		//echo "<br><span class='error'>Hakuna Taarifa yeyote kwa Mtaa Huu</span> <br>";
	}
	else
	{
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	
	$objSheet->getStyle('A1:O1')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A2:O2')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	
	
	$objSheet->mergeCells('A1:O1');
	$objSheet->getCell('A1')->setValue($message);
	
	$objSheet->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  
	$objSheet->getCell('A2')->setValue('No');
	
	$objSheet->getCell('B2')->setValue('Evangelist Name');
	
	$objSheet->getCell('C2')->setValue('Hours');
	
	$objSheet->getCell('D2')->setValue('Books Sold');
	$objSheet->getCell('E2')->setValue('Magazines');
	$objSheet->getCell('F2')->setValue('Value of Sale');
	$objSheet->getCell('G2')->setValue('Free Literature');
	$objSheet->getCell('H2')->setValue('V.O.P');
	
	$objSheet->getCell('I2')->setValue('Attending SS');
	$objSheet->getCell('J2')->setValue('Back Slinders');
	$objSheet->getCell('K2')->setValue('Prayers');
	$objSheet->getCell('L2')->setValue('Bible Studies');
	
	$objSheet->getCell('M2')->setValue('Bapstism Classess');
	$objSheet->getCell('N2')->setValue('Baptized');
	$objSheet->getCell('O2')->setValue('Visits');
	
			$num = 2;
			$inital = $num+1;
			while($fetch_years = mysql_fetch_array($query))
			{
				$evangID = $fetch_years['ID'];
				$query_repoti = mysql_query("SELECT * FROM evangelists_monthly_report WHERE evangelistID='$evangID' AND year='$year' AND month='$month' ",$connect)or die(mysql_error());
				
				$fetch_results = mysql_fetch_array($query_repoti);
				
				$num++;
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':P'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				$objSheet->getStyle('A'.$num.':'.'O'.$num)->getNumberFormat()->setFormatCode('#,##');
				//$objSheet->getStyle('H'.$num)->getNumberFormat()->setFormatCode('#,##');
					
				$drugID = $fetch_years['drugid'];
				
				$objSheet->getCell('A'.$num)->setValue($num-2);
				$objSheet->getCell('B'.$num)->setValue($fetch_years['First_Name']." ".$fetch_years['Middle_Name']." ".$fetch_years['Last_Name']);
				$objSheet->getCell('C'.$num)->setValue($fetch_results['hours']);
				$objSheet->getCell('D'.$num)->setValue($fetch_results['books_sold']);
				$objSheet->getCell('E'.$num)->setValue($fetch_results['Magazines']);
				$objSheet->getCell('F'.$num)->setValue($fetch_results['Value_sales']);
				$objSheet->getCell('G'.$num)->setValue($fetch_results['free_literature']);
				$objSheet->getCell('H'.$num)->setValue($fetch_results['v_o_p']);
			
				$objSheet->getCell('I'.$num)->setValue($fetch_results['people_attending_SS']);
				$objSheet->getCell('J'.$num)->setValue($fetch_results['sda_back_slinders']);
				$objSheet->getCell('K'.$num)->setValue($fetch_results['prayers_offered']);
				$objSheet->getCell('L'.$num)->setValue($fetch_results['Bibles_studies_given']);
				$objSheet->getCell('M'.$num)->setValue($fetch_results['people_joining_bapstism_classes']);
				$objSheet->getCell('N'.$num)->setValue($fetch_results['no_baptised']);
				$objSheet->getCell('O'.$num)->setValue($fetch_results['Waliotembelewa']);
				
				
			}//end while loop
			
			
			$final = $num;
			$num++;
			$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':P'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
			$objSheet->mergeCells('A'.$num.':B'.$num);
			
			$objSheet->getStyle('A'.$num.':'.'O'.$num)->getNumberFormat()->setFormatCode('#,##');
			$objSheet->getStyle('A'.$num.':'.'O'.$num)->getFont()->setBold(true)->setSize(10);
			
			$objSheet->getCell('A'.$num)->setValue('TOTAL');
			
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
			$objSheet->getCell('N'.$num)->setValue('=SUM(M'.$inital.':M'.$final.')');
			$objSheet->getCell('O'.$num)->setValue('=SUM(M'.$inital.':M'.$final.')');
	
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
	
	
	$objWriter->save('zone_evangelists_report.xlsx');
}//end function


?>