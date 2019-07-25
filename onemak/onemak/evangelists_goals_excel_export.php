<?php

function Export_All_zones_reports($sql,$confID,$year)
{
	require('PHPExcel/Classes/PHPExcel.php');
	require('connection.php');
//require('settings.php');

  $objPHPExcel = new PHPExcel();
  
  	$message = return_conference_abbrev($confID)." Evangelists Goals ".$year;
  
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Evangelists Goals'); // renamin the sheet
	
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
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	
	$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A4:H4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
	$objSheet->getStyle('A1:Q1')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A2:Q2')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A3:Q3')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	$objSheet->getStyle('A4:Q4')->getFont()->setBold(true)->setSize(10); // bold cell A1 to D1 and set the font size to 12 
	
	
		$objSheet->mergeCells('A1:G1');
		$objSheet->getCell('A1')->setValue('SEVENTH DAY ADVENTIST CHURCH');
		$objSheet->mergeCells('A2:G2');
		$objSheet->getCell('A2')->setValue(strtoupper(return_conference_name($confID)));
		$objSheet->mergeCells('A3:G3');
		$objSheet->getCell('A3')->setValue(getAddressConference($confID));
		$objSheet->mergeCells('A4:G4');
		$objSheet->getCell('A4')->setValue($year.' EVANGELISTS GOALS');
		
		$objSheet->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objSheet->getStyle('A2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  		$objSheet->getStyle('A3:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objSheet->getStyle('A4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
		
		$objSheet->getStyle('A6:Q6')->getFont()->setBold(true)->setSize(10);
		$objSheet->getCell('A6')->setValue('No');
		$objSheet->getCell('B6')->setValue('FD');
		$objSheet->getCell('C6')->setValue('Current ID');
		$objSheet->getCell('D6')->setValue('Name');
		$objSheet->getCell('E6')->setValue('Year Goal');
		
		$objSheet->getCell('F6')->setValue('Value of Sale');
		$objSheet->getCell('G6')->setValue('Percent (%)');
		
			$num = 6;
			$inital = $num+1;
			while($fetch_years = mysql_fetch_array($query))
			{
				$num++;
				$zoneID = $fetch_years['ID'];
				
				$query_zones_inner = mysql_query("SELECT * FROM evangelists_list WHERE zoneID='$zoneID' ",$connect)or die(mysql_error());
				
				$objSheet->mergeCells('A'.$num.':G'.$num);
				$objSheet->getStyle('A'.$num)->getFont()->setBold(true)->setSize(10);
				$objSheet->getCell('A'.$num)->setValue($fetch_years['ZoneName']);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':H'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				
				if(mysql_num_rows($query_zones_inner)==0)
				{
						$num++;
						$objSheet->mergeCells('A'.$num.':G'.$num);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':H'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
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
						
						
				$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':H'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
				$objSheet->getStyle('E'.$num.':'.'G'.$num)->getNumberFormat()->setFormatCode('#,##');
				//$objSheet->getStyle('H'.$num)->getNumberFormat()->setFormatCode('#,##');
					
				$drugID = $fetch_years['drugid'];
				
				$objSheet->getCell('A'.$num)->setValue($counter);
				
				$objSheet->getCell('C'.$num)->setValue(return_evang_grade_disp($fetch_evang_lists_inner['Grade']));
				$objSheet->getCell('D'.$num)->setValue(strtoupper($fetch_evang_lists_inner['First_Name']." ".$fetch_evang_lists_inner['Middle_Name']." ".$fetch_evang_lists_inner['Last_Name']));
				$objSheet->getCell('E'.$num)->setValue(ReturnGoals($year,$fetch_evang_lists_inner['Grade']));
				$objSheet->getCell('F'.$num)->setValue(Evangelists_Collection($evangIDz,$year));
				
				$objSheet->getCell('G'.$num)->setValue('=(F'.$num.'/E'.$num.')*100');
				
				
					}//inner while loop
					$final_zone = $num;
					$num++;
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':H'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
					$objSheet->mergeCells('A'.$num.':D'.$num);
			$objSheet->getCell('A'.$num)->setValue('ZONE TOTAL');
			
			$objSheet->getStyle('A'.$num.':'.'Q'.$num)->getFont()->setBold(true)->setSize(10);
			$objSheet->getStyle('E'.$num.':'.'Q'.$num)->getNumberFormat()->setFormatCode('#,##');
			$objSheet->getCell('E'.$num)->setValue('=SUM(E'.$initial_zone.':E'.$final_zone.')');
			$objSheet->getCell('F'.$num)->setValue('=SUM(F'.$initial_zone.':F'.$final_zone.')');
			$objSheet->getCell('G'.$num)->setValue('=(F'.$num.'/E'.$num.')*100');
			
					
					$num++;
					$objPHPExcel->getActiveSheet()->getStyle('A'.$num.':H'.$num)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
					$objSheet->mergeCells('A'.$num.':G'.$num);
					
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
	
	
	$objWriter->save('evangelists_goals.xlsx');
	
}//end function

?>