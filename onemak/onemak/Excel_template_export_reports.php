<?php

function Export_Zone_Report($confID,$sql,$zoneID,$month,$year)
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

function Export_All_zones_reports($sql,$confID,$month,$year)
{
	require('PHPExcel/Classes/PHPExcel.php');
	require('connection.php');
//require('settings.php');

  $objPHPExcel = new PHPExcel();
  
  	$message = return_conference_abbrev($confID)." Zones Lists ";
  
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Monthly Report'); // renamin the sheet
	
	$query = mysql_query($sql,$connect) or die(mysql_error());
	
	if(mysql_num_rows($query)==0)
	{
		$objSheet->getStyle('A1:Q1')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
		$objSheet->getStyle('A2:Q2')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12
	
		$objSheet->getCell('A1')->setValue($message);
		$objSheet->getCell('A2')->setValue('No Zones Registered');
		//echo "<br><span class='error'>Hakuna Taarifa yeyote kwa Mtaa Huu</span> <br>";
	}
	else
	{
		$array_months = array('1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December');
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:R1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A2:R2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	
	$objPHPExcel->getActiveSheet()->getStyle('A3:R3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A4:R4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objSheet->getStyle('A1:Q1')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A2:Q2')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A3:Q3')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A4:Q4')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	
	
		$objSheet->mergeCells('A1:Q1');
		$objSheet->getCell('A1')->setValue('SEVENTH DAY ADVENTIST CHURCH');
		$objSheet->mergeCells('A2:Q2');
		$objSheet->getCell('A2')->setValue(strtoupper(return_conference_name($confID)));
		$objSheet->mergeCells('A3:Q3');
		$objSheet->getCell('A3')->setValue(getAddressConference($confID));
		$objSheet->mergeCells('A4:Q4');
		$objSheet->getCell('A4')->setValue(strtoupper($array_months[$month]).' EVANGELISTS REPORT');
		
		$objSheet->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objSheet->getStyle('A2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  		$objSheet->getStyle('A3:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objSheet->getStyle('A4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->getStyle('A6:R6')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
		
		$objSheet->getCell('A6')->setValue('No');
		$objSheet->getCell('B6')->setValue('FD');
		$objSheet->getCell('C6')->setValue('ID');
		$objSheet->getCell('D6')->setValue('Name');
		$objSheet->getCell('E6')->setValue('Hours');
		
		$objSheet->getCell('F6')->setValue('Books Sold');
		$objSheet->getCell('G6')->setValue('Magazine');
		$objSheet->getCell('H6')->setValue('Value of Sale');
		$objSheet->getCell('I6')->setValue('Free Literature');
		$objSheet->getCell('J6')->setValue('V.O.P');
		$objSheet->getCell('K6')->setValue('Attending SS');
		$objSheet->getCell('L6')->setValue('Back Slinders');
		$objSheet->getCell('M6')->setValue('Prayers');
		$objSheet->getCell('N6')->setValue('Bible studies');
		$objSheet->getCell('O6')->setValue('baptism class');
		$objSheet->getCell('P6')->setValue('Baptised');
		$objSheet->getCell('Q6')->setValue('Visits');
	
	
			$num = 6;
			$inital = $num+1;
			while($fetch_years = mysql_fetch_array($query))
			{
				$num++;
				$zoneID = $fetch_years['ID'];
				
				$query_zones_inner = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID' ",$connect)or die(mysql_error());
				
				$objSheet->mergeCells('A'.$num.':Q'.$num);
				$objSheet->getCell('A'.$num)->setValue($fetch_years['ZoneName']);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':R'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				
				if(mysql_num_rows($query_zones_inner)==0)
				{
						$num++;
						$objSheet->mergeCells('A'.$num.':Q'.$num);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':R'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
						$objSheet->getCell('A'.$num)->setValue('No Evangeists Registered in this Zone');
						$num++;
				}
				else
				{
					$initial_zone = $num+1;
					$counter = 0;
					while($fetch_evang_lists_inner = mysql_fetch_array($query_zones_inner))
					{
						$num++;
						$counter++;
						$evangIDz = $fetch_evang_lists_inner['ID'];
						
						$monthly_report_values_query = mysql_query("SELECT * FROM evangelists_monthly_report WHERE evangelistID='$evangIDz' AND year='$year' AND month='$month' ",$connect)or  die(mysql_error());
						$fetch_results_evangelists = mysql_fetch_array($monthly_report_values_query);
						
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':R'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				$objSheet->getStyle('E'.$num.':'.'Q'.$num)->getNumberFormat()->setFormatCode('#,##');
				//$objSheet->getStyle('H'.$num)->getNumberFormat()->setFormatCode('#,##');
					
				$drugID = $fetch_years['drugid'];
				
				$objSheet->getCell('A'.$num)->setValue($counter);
				
				$objSheet->getCell('C'.$num)->setValue(return_evang_grade_disp($fetch_evang_lists_inner['Grade']));
				$objSheet->getCell('D'.$num)->setValue(strtoupper($fetch_evang_lists_inner['First_Name']." ".$fetch_evang_lists_inner['Middle_Name']." ".$fetch_evang_lists_inner['Last_Name']));
				$objSheet->getCell('E'.$num)->setValue($fetch_results_evangelists['hours']);
				$objSheet->getCell('F'.$num)->setValue($fetch_results_evangelists['books_sold']);
				
				$objSheet->getCell('G'.$num)->setValue($fetch_results_evangelists['Magazines']);
				
				$objSheet->getCell('H'.$num)->setValue($fetch_results_evangelists['Value_sales']);
				$objSheet->getCell('I'.$num)->setValue($fetch_results_evangelists['free_literature']);
				$objSheet->getCell('J'.$num)->setValue($fetch_results_evangelists['v_o_p']);
				
				$objSheet->getCell('K'.$num)->setValue($fetch_results_evangelists['people_attending_SS']);
				$objSheet->getCell('L'.$num)->setValue($fetch_results_evangelists['sda_back_slinders']);
				$objSheet->getCell('M'.$num)->setValue($fetch_results_evangelists['prayers_offered']);
				$objSheet->getCell('N'.$num)->setValue($fetch_results_evangelists['Bibles_studies_given']);
				$objSheet->getCell('O'.$num)->setValue($fetch_results_evangelists['people_joining_bapstism_classes']);
				$objSheet->getCell('P'.$num)->setValue($fetch_results_evangelists['no_baptised']);
				$objSheet->getCell('Q'.$num)->setValue($fetch_results_evangelists['Waliotembelewa']);
					}//inner while loop
					$final_zone = $num;
					$num++;
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':R'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
					$objSheet->mergeCells('A'.$num.':D'.$num);
			$objSheet->getCell('A'.$num)->setValue('ZONE TOTAL');
			
			$objSheet->getStyle('A'.$num.':'.'Q'.$num)->getFont()->setBold(true)->setSize(10);
			$objSheet->getStyle('E'.$num.':'.'Q'.$num)->getNumberFormat()->setFormatCode('#,##');
			$objSheet->getCell('E'.$num)->setValue('=SUM(E'.$initial_zone.':E'.$final_zone.')');
			$objSheet->getCell('F'.$num)->setValue('=SUM(F'.$initial_zone.':F'.$final_zone.')');
			$objSheet->getCell('G'.$num)->setValue('=SUM(G'.$initial_zone.':G'.$final_zone.')');
			$objSheet->getCell('H'.$num)->setValue('=SUM(H'.$initial_zone.':H'.$final_zone.')');
			$objSheet->getCell('I'.$num)->setValue('=SUM(I'.$initial_zone.':I'.$final_zone.')');
			$objSheet->getCell('J'.$num)->setValue('=SUM(J'.$initial_zone.':J'.$final_zone.')');
			$objSheet->getCell('K'.$num)->setValue('=SUM(K'.$initial_zone.':K'.$final_zone.')');
			$objSheet->getCell('L'.$num)->setValue('=SUM(L'.$initial_zone.':L'.$final_zone.')');
			$objSheet->getCell('M'.$num)->setValue('=SUM(M'.$initial_zone.':M'.$final_zone.')');
			$objSheet->getCell('N'.$num)->setValue('=SUM(N'.$initial_zone.':N'.$final_zone.')');
			$objSheet->getCell('O'.$num)->setValue('=SUM(O'.$initial_zone.':O'.$final_zone.')');
			$objSheet->getCell('P'.$num)->setValue('=SUM(P'.$initial_zone.':P'.$final_zone.')');
			$objSheet->getCell('Q'.$num)->setValue('=SUM(Q'.$initial_zone.':Q'.$final_zone.')');
					
					$num++;
					$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':R'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
					$objSheet->mergeCells('A'.$num.':Q'.$num);
					
				}
				
			}//end while loop
			
			$num++;
			
			$final = $num-1;
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':R'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
			$objSheet->mergeCells('A'.$num.':D'.$num);
			$objSheet->getCell('A'.$num)->setValue('GRAND TOTAL');
			
			$objSheet->getStyle('A'.$num.':'.'Q'.$num)->getFont()->setBold(true)->setSize(10);
			$objSheet->getStyle('E'.$num.':'.'Q'.$num)->getNumberFormat()->setFormatCode('#,##');
			$objSheet->getCell('E'.$num)->setValue(ConferenceSummary($confID,$month,$year,'hours'));
			$objSheet->getCell('F'.$num)->setValue(ConferenceSummary($confID,$month,$year,'books_sold'));
			$objSheet->getCell('G'.$num)->setValue(ConferenceSummary($confID,$month,$year,'Magazines'));
			$objSheet->getCell('H'.$num)->setValue(ConferenceSummary($confID,$month,$year,'Value_sales'));
			$objSheet->getCell('I'.$num)->setValue(ConferenceSummary($confID,$month,$year,'free_literature'));
			$objSheet->getCell('J'.$num)->setValue(ConferenceSummary($confID,$month,$year,'v_o_p'));
			$objSheet->getCell('K'.$num)->setValue(ConferenceSummary($confID,$month,$year,'people_attending_SS'));
			$objSheet->getCell('L'.$num)->setValue(ConferenceSummary($confID,$month,$year,'sda_back_slinders'));
			$objSheet->getCell('M'.$num)->setValue(ConferenceSummary($confID,$month,$year,'prayers_offered'));
			$objSheet->getCell('N'.$num)->setValue(ConferenceSummary($confID,$month,$year,'Bibles_studies_given'));
			$objSheet->getCell('O'.$num)->setValue(ConferenceSummary($confID,$month,$year,'people_joining_bapstism_classes'));
			$objSheet->getCell('P'.$num)->setValue(ConferenceSummary($confID,$month,$year,'no_baptised'));
			$objSheet->getCell('Q'.$num)->setValue(ConferenceSummary($confID,$month,$year,'Waliotembelewa'));
			
			$num = $num + 2;
			
			
			//Creaating a Zone Summary Section with zones and Evangelists Types in those zones...
			//$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':D'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
			$objSheet->mergeCells('D'.$num.':I'.$num);
			$objSheet->getCell('D'.$num)->setValue('KANDA /SUMMARY B');
			$objSheet->getStyle('D'.$num)->getFont()->setBold(true)->setSize(10);
			
			$num = $num + 2;
			
			$objSheet->getCell('D'.$num)->setValue('KANDA');
			
			$columns = array("E","F","G","H","I","J","K","L","M");
			
			$query_evangs = mysql_query("SELECT * FROM evangelists_grades ",$connect)or die(mysql_error());
			$number_grades = mysql_num_rows($query_evangs);
			
			$counter = 0;
			while($fetch_graded = mysql_fetch_array($query_evangs))
			{
				$objSheet->getCell($columns[$counter].$num)->setValue($fetch_graded['code']);
				$counter++;
			}//end while loop
			$objSheet->getCell($columns[$counter].$num)->setValue('TOTAL');
			
			$num++;
			//"SELECT * FROM zones_lists WHERE ConferenceID='$confID' ",
			$initial_summary_b = $num;
			
			$query_summary_b = mysql_query($sql,$connect)or die(mysql_error());
			
			while($fetch_summary_b_zones = mysql_fetch_array($query_summary_b))
			{
				$objSheet->getCell('D'.$num)->setValue($fetch_summary_b_zones['ZoneName']);
				
				$query_evangs22 = mysql_query("SELECT * FROM evangelists_grades ",$connect)or die(mysql_error());
				$counter = 0;
				while($fetch_evangdgr2 = mysql_fetch_array($query_evangs22))
				{
					$evangGrade = $fetch_evangdgr2['ID'];
					$objSheet->getCell($columns[$counter].$num)->setValue(CountEvangelistsZones($fetch_summary_b_zones['ID'],$evangGrade));
					
					$counter++;
				}
				
				$objSheet->getCell($columns[$counter].$num)->setValue('=SUM('.$columns[0].$num.':'.$columns[$counter-1].$num.')');
				
				$num++;
			}//end while loop
			
			$final_summary_b = $num-1;
			$objSheet->getCell('D'.$num)->setValue('TOTAL');
			for($i=0;$i<=$number_grades;$i++)
			{
				$objSheet->getCell($columns[$i].$num)->setValue('=SUM('.$columns[$i].$initial_summary_b.':'.$columns[$i].$final_summary_b.')');
			}//end for loop
			
			$num = $num + 3;
			$objPHPExcel->getActiveSheet()->getStyle('D'.$num.':R'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
			$objSheet->mergeCells('D'.$num.':Q'.$num);
			$objSheet->getCell('D'.$num)->setValue('KANDA /SUMMARY C');
			$objSheet->getStyle('D'.$num)->getFont()->setBold(true)->setSize(10);
			
			$num++;
			$query_summary_c = mysql_query($sql,$connect)or die(mysql_error());
			$initial_summary_c = $num;
			while($fetch_summary_c_zones = mysql_fetch_array($query_summary_c))
			{
				$objSheet->getStyle('E'.$num.':'.'Q'.$num)->getNumberFormat()->setFormatCode('#,##');
				$objPHPExcel->getActiveSheet()->getStyle('D'.$num.':R'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				$objSheet->getCell('D'.$num)->setValue($fetch_summary_c_zones['ZoneName']);
				$objSheet->getCell('E'.$num)->setValue(Sum_Item_Month('hours',$month,$year,$fetch_summary_c_zones['ID']));
				$objSheet->getCell('F'.$num)->setValue(Sum_Item_Month('books_sold',$month,$year,$fetch_summary_c_zones['ID']));
				$objSheet->getCell('G'.$num)->setValue(Sum_Item_Month('Magazines',$month,$year,$fetch_summary_c_zones['ID']));
				$objSheet->getCell('H'.$num)->setValue(Sum_Item_Month('Value_sales',$month,$year,$fetch_summary_c_zones['ID']));
				$objSheet->getCell('I'.$num)->setValue(Sum_Item_Month('free_literature',$month,$year,$fetch_summary_c_zones['ID']));
				$objSheet->getCell('J'.$num)->setValue(Sum_Item_Month('v_o_p',$month,$year,$fetch_summary_c_zones['ID']));
				$objSheet->getCell('K'.$num)->setValue(Sum_Item_Month('people_attending_SS',$month,$year,$fetch_summary_c_zones['ID']));
				$objSheet->getCell('L'.$num)->setValue(Sum_Item_Month('sda_back_slinders',$month,$year,$fetch_summary_c_zones['ID']));
				$objSheet->getCell('M'.$num)->setValue(Sum_Item_Month('prayers_offered',$month,$year,$fetch_summary_c_zones['ID']));
				$objSheet->getCell('N'.$num)->setValue(Sum_Item_Month('Bibles_studies_given',$month,$year,$fetch_summary_c_zones['ID']));
				$objSheet->getCell('O'.$num)->setValue(Sum_Item_Month('people_joining_bapstism_classes',$month,$year,$fetch_summary_c_zones['ID']));
				$objSheet->getCell('P'.$num)->setValue(Sum_Item_Month('no_baptised',$month,$year,$fetch_summary_c_zones['ID']));
				$objSheet->getCell('Q'.$num)->setValue(Sum_Item_Month('Waliotembelewa',$month,$year,$fetch_summary_c_zones['ID']));
				$num++;
			}//end while loop
			$final_summary_c = $num;
			$num++;
			
			$objPHPExcel->getActiveSheet()->getStyle('D'.$num.':R'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
			$objSheet->getStyle('E'.$num.':'.'Q'.$num)->getNumberFormat()->setFormatCode('#,##');
			$objSheet->getCell('D'.$num)->setValue('TOTAL');
			
			$objSheet->getStyle('D'.$num.':'.'Q'.$num)->getFont()->setBold(true)->setSize(10);
			$objSheet->getCell('E'.$num)->setValue('=SUM(E'.$initial_summary_c.':E'.$final_summary_c.')');
			$objSheet->getCell('F'.$num)->setValue('=SUM(F'.$initial_summary_c.':F'.$final_summary_c.')');
			$objSheet->getCell('G'.$num)->setValue('=SUM(G'.$initial_summary_c.':G'.$final_summary_c.')');
			$objSheet->getCell('H'.$num)->setValue('=SUM(H'.$initial_summary_c.':H'.$final_summary_c.')');
			$objSheet->getCell('I'.$num)->setValue('=SUM(I'.$initial_summary_c.':I'.$final_summary_c.')');
			$objSheet->getCell('J'.$num)->setValue('=SUM(J'.$initial_summary_c.':J'.$final_summary_c.')');
			$objSheet->getCell('K'.$num)->setValue('=SUM(K'.$initial_summary_c.':K'.$final_summary_c.')');
			$objSheet->getCell('L'.$num)->setValue('=SUM(L'.$initial_summary_c.':L'.$final_summary_c.')');
			$objSheet->getCell('M'.$num)->setValue('=SUM(M'.$initial_summary_c.':M'.$final_summary_c.')');
			$objSheet->getCell('N'.$num)->setValue('=SUM(N'.$initial_summary_c.':N'.$final_summary_c.')');
			$objSheet->getCell('O'.$num)->setValue('=SUM(O'.$initial_summary_c.':O'.$final_summary_c.')');
			$objSheet->getCell('P'.$num)->setValue('=SUM(P'.$initial_summary_c.':P'.$final_summary_c.')');
			$objSheet->getCell('Q'.$num)->setValue('=SUM(Q'.$initial_summary_c.':Q'.$final_summary_c.')');
			
			$num = $num + 6;
			
			//$objSheet->mergeCells('D'.$num.':P'.$num);
			//$objSheet->getCell('D'.$num)->setValue('');
			
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
	
	$objWriter->save('Conference_zones_report.xlsx');
	
}//end function


function Evangelists_Apdd_monthly_report($zoneID,$month,$year,$confID)
{
	require('PHPExcel/Classes/PHPExcel.php');
	require('connection.php');
//require('settings.php');


	$total_days = cal_days_in_month(CAL_GREGORIAN,$month,$year);
	$days_week = array("1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday","0"=>"Sunday");				
	$dayofweek = date('w', strtotime('2017-04-20'));
					//echo $dayofweek;
					
					$array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
	

  $objPHPExcel = new PHPExcel();
  
  	$message = "APDD Monthly Report for ".ReturnZoneDetails($zoneID,'ZoneName')." Zone - ".return_conference_name($confID)."(".return_conference_abbrev($confID).") ".$array_months[$month]." , ".$year;
  
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('APDD Monthly Report'); // renamin the sheet
	
	
	
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	
	$objSheet->getStyle('A1:J1')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A2:J2')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	
	
	$objSheet->mergeCells('A1:J1');
	$objSheet->getCell('A1')->setValue($message);
	
	$objSheet->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  
	$objSheet->getCell('A2')->setValue('No');
	
	$objSheet->getCell('B2')->setValue('Date');
	
	$objSheet->getCell('C2')->setValue('Day');
	
	$objSheet->getCell('D2')->setValue('APDD Name');
	$objSheet->getCell('E2')->setValue('Evangelist Name');
	$objSheet->getCell('F2')->setValue('Grade');
	$objSheet->getCell('G2')->setValue('Hours');
	$objSheet->getCell('H2')->setValue('Visits');
	
	$objSheet->getCell('I2')->setValue('Books');
	$objSheet->getCell('J2')->setValue('Value of Sale');
	
	
			$num = 2;
			$inital = $num+1;
			for($i=1;$i<=$total_days;$i++)
			{
				$date_z = $year.'-'.$month.'-'.$i;
				$date_disp = $i."/".$month."/".$year;
				$zoneIDQuery = mysql_query("SELECT * FROM apdd_report WHERE Date='$date_z' AND zoneID='$zoneID' ",$connect) or die(mysql_error());
				$num_rows_data = mysql_num_rows($zoneIDQuery);
				$fetch_apdd = mysql_fetch_array($zoneIDQuery);
				
				$num++;
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':K'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				//$objSheet->getStyle('H'.$num)->getNumberFormat()->setFormatCode('#,##');
					
				$drugID = $fetch_years['drugid'];
				
				$objSheet->getCell('A'.$num)->setValue($num-2);
				$objSheet->getCell('B'.$num)->setValue($date_disp);
				$dayofweek = date('w', strtotime($year.'-'.$month.'-'.$i));
				//echo $days_week[$dayofweek];
				$objSheet->getCell('C'.$num)->setValue($days_week[$dayofweek]);
				
				$objSheet->getCell('D'.$num)->setValue($fetch_apdd['APDD_Name']);
				$objSheet->getCell('E'.$num)->setValue(return_Evang_Name($fetch_apdd['evangID']));
				$objSheet->getCell('F'.$num)->setValue(return_grade_Name($fetch_apdd['Grade']));
				$objSheet->getCell('G'.$num)->setValue($fetch_apdd['hours']);
				
				$objSheet->getCell('H'.$num)->setValue($fetch_apdd['waliotembelewa']);
				$objSheet->getCell('I'.$num)->setValue($fetch_apdd['vitabu']);
				$objSheet->getCell('J'.$num)->setValue($fetch_apdd['mauzo_siku']);
				
			}//end for loop
			
			$final = $num;
			$num++;
			$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':K'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
			$objSheet->mergeCells('A'.$num.':F'.$num);
			$objSheet->getCell('A'.$num)->setValue('TOTAL');
			
			
			$objSheet->getCell('G'.$num)->setValue('=SUM(G'.$inital.':G'.$final.')');
			$objSheet->getCell('H'.$num)->setValue('=SUM(H'.$inital.':H'.$final.')');
			$objSheet->getCell('I'.$num)->setValue('=SUM(I'.$inital.':I'.$final.')');
			$objSheet->getCell('J'.$num)->setValue('=SUM(J'.$inital.':J'.$final.')');
			
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
	
	
	$objWriter->save('Apdd_zone_monthly_report.xlsx');
}//end function

function Export_Union_Monthly_Report()
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



function Export_All_Zone_Summaries($sql,$month,$year)
{
	require('PHPExcel/Classes/PHPExcel.php');
require('connection.php');
//require('settings.php');

$array_months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

  $objPHPExcel = new PHPExcel();
  
  	$message = "Zones Monthly Summaries - ".$array_months[$month]." ,".$year;
  
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Zones Monthly Summaries'); // renamin the sheet
	
	$query = mysql_query($sql,$connect) or die(mysql_error());
	
	if(mysql_num_rows($query)==0)
	{
		$objSheet->getStyle('A1:S1')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
		$objSheet->getStyle('A2:S2')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12
	
		$objSheet->getCell('A1')->setValue($message);
		$objSheet->getCell('A2')->setValue('Zones Monthly Summaries');
		//echo "<br><span class='error'>Hakuna Taarifa yeyote kwa Mtaa Huu</span> <br>";
	}
	else
	{
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	
	$objSheet->getStyle('A1:P1')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A2:P2')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	
	
	$objSheet->mergeCells('A1:P1');
	$objSheet->getCell('A1')->setValue($message);
	
	$objSheet->getStyle('A1:P1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A2:P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  
	$objSheet->getCell('A2')->setValue('No');
	
	$objSheet->getCell('B2')->setValue('Zone Name');
	
	$objSheet->getCell('C2')->setValue('Conference');
	
	$objSheet->getCell('D2')->setValue('Hours');
	
	$objSheet->getCell('E2')->setValue('Books Sold');
	$objSheet->getCell('F2')->setValue('Magazines');
	$objSheet->getCell('G2')->setValue('Value of Sale');
	$objSheet->getCell('H2')->setValue('Free Literature');
	$objSheet->getCell('I2')->setValue('V.O.P');
	
	$objSheet->getCell('J2')->setValue('Attending SS');
	$objSheet->getCell('K2')->setValue('Back Slinders');
	$objSheet->getCell('L2')->setValue('Prayers');
	$objSheet->getCell('M2')->setValue('Bible Studies');
	
	$objSheet->getCell('N2')->setValue('Bapstism Classess');
	$objSheet->getCell('O2')->setValue('Baptized');
	$objSheet->getCell('P2')->setValue('Visits');
	
			$num = 2;
			$inital = $num+1;
			while($fetch_years = mysql_fetch_array($query))
			{
				
				$num++;
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':Q'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				$objSheet->getStyle('A'.$num.':'.'P'.$num)->getNumberFormat()->setFormatCode('#,##');
				//$objSheet->getStyle('H'.$num)->getNumberFormat()->setFormatCode('#,##');
					
				$drugID = $fetch_years['drugid'];
				
				$objSheet->getCell('A'.$num)->setValue($num-2);
				$objSheet->getCell('B'.$num)->setValue(ReturnZoneDetails($fetch_years['zone'],'ZoneName'));
				$objSheet->getCell('C'.$num)->setValue(getconfAbrrfromZoneID($fetch_years['zone']));
				$objSheet->getCell('D'.$num)->setValue($fetch_years['hours']);
				$objSheet->getCell('E'.$num)->setValue($fetch_years['books_sold']);
				$objSheet->getCell('F'.$num)->setValue($fetch_years['Magazines']);
				$objSheet->getCell('G'.$num)->setValue($fetch_years['Value_sales']);
				$objSheet->getCell('H'.$num)->setValue($fetch_years['free_literature']);
				$objSheet->getCell('I'.$num)->setValue($fetch_years['v_o_p']);
			
				$objSheet->getCell('J'.$num)->setValue($fetch_years['people_attending_SS']);
				$objSheet->getCell('K'.$num)->setValue($fetch_years['sda_back_slinders']);
				$objSheet->getCell('L'.$num)->setValue($fetch_years['prayers_offered']);
				$objSheet->getCell('M'.$num)->setValue($fetch_years['Bibles_studies_given']);
				$objSheet->getCell('N'.$num)->setValue($fetch_years['people_joining_bapstism_classes']);
				$objSheet->getCell('O'.$num)->setValue($fetch_years['no_baptised']);
				$objSheet->getCell('P'.$num)->setValue($fetch_years['Waliotembelewa']);
				
				
			}//end while loop
			
			
			$final = $num;
			$num++;
			$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':Q'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
			$objSheet->mergeCells('A'.$num.':B'.$num);
			
			$objSheet->getStyle('A'.$num.':'.'P'.$num)->getNumberFormat()->setFormatCode('#,##');
			$objSheet->getStyle('A'.$num.':'.'P'.$num)->getFont()->setBold(true)->setSize(10);
			
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
			$objSheet->getCell('N'.$num)->setValue('=SUM(N'.$inital.':N'.$final.')');
			$objSheet->getCell('O'.$num)->setValue('=SUM(O'.$inital.':O'.$final.')');
			$objSheet->getCell('P'.$num)->setValue('=SUM(P'.$inital.':P'.$final.')');
	
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
	
	
	$objWriter->save('Zone_Monthly_Summaries.xlsx');
}//end function

function Export_All_Zone_SummariesQurter($sql,$month,$year)
{
	require('PHPExcel/Classes/PHPExcel.php');
require('connection.php');
//require('settings.php');

$array_months = array("1"=>"Quarter One","2"=>"Quarter Two","3"=>"Quarter Three","4"=>"Quarter Four");

  $objPHPExcel = new PHPExcel();
  
  	$message = "Zones Monthly Summaries - ".$array_months[$month]." ,".$year;
  
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Zones Monthly Summaries'); // renamin the sheet
	
	$query = mysql_query($sql,$connect) or die(mysql_error());
	
	if(mysql_num_rows($query)==0)
	{
		$objSheet->getStyle('A1:S1')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12 
		$objSheet->getStyle('A2:S2')->getFont()->setBold(true)->setSize(12); // bold cell A1 to D1 and set the font size to 12
	
		$objSheet->getCell('A1')->setValue($message);
		$objSheet->getCell('A2')->setValue('Zones Monthly Summaries');
		//echo "<br><span class='error'>Hakuna Taarifa yeyote kwa Mtaa Huu</span> <br>";
	}
	else
	{
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	
	$objSheet->getStyle('A1:P1')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A2:P2')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	
	
	$objSheet->mergeCells('A1:P1');
	$objSheet->getCell('A1')->setValue($message);
	
	$objSheet->getStyle('A1:P1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A2:P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  
	$objSheet->getCell('A2')->setValue('No');
	
	$objSheet->getCell('B2')->setValue('Zone Name');
	
	$objSheet->getCell('C2')->setValue('Conference');
	
	$objSheet->getCell('D2')->setValue('Hours');
	
	$objSheet->getCell('E2')->setValue('Books Sold');
	$objSheet->getCell('F2')->setValue('Magazines');
	$objSheet->getCell('G2')->setValue('Value of Sale');
	$objSheet->getCell('H2')->setValue('Free Literature');
	$objSheet->getCell('I2')->setValue('V.O.P');
	
	$objSheet->getCell('J2')->setValue('Attending SS');
	$objSheet->getCell('K2')->setValue('Back Slinders');
	$objSheet->getCell('L2')->setValue('Prayers');
	$objSheet->getCell('M2')->setValue('Bible Studies');
	
	$objSheet->getCell('N2')->setValue('Bapstism Classess');
	$objSheet->getCell('O2')->setValue('Baptized');
	$objSheet->getCell('P2')->setValue('Visits');
	
			$num = 2;
			$inital = $num+1;
			while($fetch_years = mysql_fetch_array($query))
			{
				
				$num++;
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':Q'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				$objSheet->getStyle('A'.$num.':'.'P'.$num)->getNumberFormat()->setFormatCode('#,##');
				//$objSheet->getStyle('H'.$num)->getNumberFormat()->setFormatCode('#,##');
					
				$drugID = $fetch_years['drugid'];
				
				$objSheet->getCell('A'.$num)->setValue($num-2);
				$objSheet->getCell('B'.$num)->setValue(ReturnZoneDetails($fetch_years['zone'],'ZoneName'));
				$objSheet->getCell('C'.$num)->setValue(getconfAbrrfromZoneID($fetch_years['zone']));
				$objSheet->getCell('D'.$num)->setValue($fetch_years['hours']);
				$objSheet->getCell('E'.$num)->setValue($fetch_years['books_sold']);
				$objSheet->getCell('F'.$num)->setValue($fetch_years['Magazines']);
				$objSheet->getCell('G'.$num)->setValue($fetch_years['Value_sales']);
				$objSheet->getCell('H'.$num)->setValue($fetch_years['free_literature']);
				$objSheet->getCell('I'.$num)->setValue($fetch_years['v_o_p']);
			
				$objSheet->getCell('J'.$num)->setValue($fetch_years['people_attending_SS']);
				$objSheet->getCell('K'.$num)->setValue($fetch_years['sda_back_slinders']);
				$objSheet->getCell('L'.$num)->setValue($fetch_years['prayers_offered']);
				$objSheet->getCell('M'.$num)->setValue($fetch_years['Bibles_studies_given']);
				$objSheet->getCell('N'.$num)->setValue($fetch_years['people_joining_bapstism_classes']);
				$objSheet->getCell('O'.$num)->setValue($fetch_years['no_baptised']);
				$objSheet->getCell('P'.$num)->setValue($fetch_years['Waliotembelewa']);
				
				
			}//end while loop
			
			
			$final = $num;
			$num++;
			$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':Q'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
			$objSheet->mergeCells('A'.$num.':B'.$num);
			
			$objSheet->getStyle('A'.$num.':'.'P'.$num)->getNumberFormat()->setFormatCode('#,##');
			$objSheet->getStyle('A'.$num.':'.'P'.$num)->getFont()->setBold(true)->setSize(10);
			
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
			$objSheet->getCell('N'.$num)->setValue('=SUM(N'.$inital.':N'.$final.')');
			$objSheet->getCell('O'.$num)->setValue('=SUM(O'.$inital.':O'.$final.')');
			$objSheet->getCell('P'.$num)->setValue('=SUM(P'.$inital.':P'.$final.')');
	
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
	
	
	$objWriter->save('Zone_Monthly_SummariesQuarter.xlsx');
}//end function


?>