<?php
function CheckLogin_Validity()
{
	if($_SESSION['username']=="")
	{
		header("Location:index.php");	
	}
}//end function Checking Login Validity

function FindAveragePrice($productID,$reportID)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM product_prices_actual WHERE ProductID='$productID' AND PriceID='$reportID' ",$connect)or die(mysql_error());
	$fetch_data = mysql_fetch_array($query);
	$avg = ($fetch_data['minimum_value'] + $fetch_data['maximum_value'])/2;
	return $avg;
}

function getProductName($prodID)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM  products WHERE ProductID='$prodID' ",$connect)or die(mysql_error());
	$fetch_data = mysql_fetch_array($query);
	return $fetch_data['ProductName'];
}//end function

function getProductUnit($prodID)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM  products WHERE ProductID='$prodID' ",$connect)or die(mysql_error());
	$fetch_data = mysql_fetch_array($query);
	return $fetch_data['UniMeasure'];
}//end function

function getZoneIDfromEvangelists($evangID)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM  evangelists_list WHERE ID='$evangID' ",$connect)or die(mysql_error());
	$fetch_data = mysql_fetch_array($query);
	return $fetch_data['zoneID'];
}//end function

function ReturnGoals($year,$grade)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM  evangelists_goals WHERE Year='$year' AND Grade='$grade' ",$connect)or die(mysql_error());
	$fetch_data = mysql_fetch_array($query);
	return $fetch_data['Amount'];
}//end function Return Goals

function Evangelists_Collection($evangID,$year)
{
	$sum_value_sale = EvangelistSummary($evangID,11,$year-1,'Value_sales') + EvangelistSummary($evangID,12,$year-1,'Value_sales');
	
	for($i=1;$i<11;$i++)
	{
		$sum_value_sale = $sum_value_sale + EvangelistSummary($evangID,$i,$year,'Value_sales');
	}//end for loop
	
	return $sum_value_sale;
	
}//end function..

function getAddressConference($conferenceID)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM conferences_list WHERE ID='$conferenceID' ",$connect)or die(mysql_error());
	$fetch_details = mysql_fetch_array($query);
	return $fetch_details['Address_Box'];
}//end function

function CountEvangelistsZones($zoneID,$evangGrade)
{
	require('connection.php');
	$query = mysql_query("SELECT COUNT(ID) AS Totali FROM evangelists_list WHERE zoneID='$zoneID' AND Grade='$evangGrade' ",$connect)or die(mysql_error());	
	$fetch_total = mysql_fetch_array($query);
	return $fetch_total['Totali'];
}

function return_evang_grade_disp($evangID)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM evangelists_grades WHERE ID='$evangID' ",$connect)or die(mysql_error());	
	$fetch_madetail = mysql_fetch_array($query);
	return $fetch_madetail['code'];
}

function getconfAbrrfromZoneID($zoneID)
{
	require('connection.php');
	$Zonequery = mysql_query("SELECT * FROM zones_lists WHERE ID='$zoneID' ",$connect)or die(mysql_error());
	$fetch_zones = mysql_fetch_array($Zonequery);
	$confID = $fetch_zones['ConferenceID'];
	$conf_abre = return_conference_abbrev($confID);
	return $conf_abre;
}

function ProductValueOrder($OrderNo,$ProductID)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM users_requests_items WHERE ReqID='$OrderNo' AND ProductID='$ProductID' ",$connect)or die(mysql_error());
	if(mysql_num_rows($query)==0)
	{
		return "";
	}
	else
	{
		$fetchProdQuery = mysql_fetch_array($query);
		return $fetchProdQuery['Quantity'];
	}
	
}

function return_monthly_avg($marketID,$productID,$month,$year)
{
	require('connection.php');
	$sql = mysql_query("SELECT * FROM product_prices_dates WHERE MarketID='$marketID' AND EndDate LIKE '$year-$month-%'",$connect)or die(mysql_error());

	//echo "SELECT * FROM product_prices_dates WHERE MarketID='$marketID' AND EndDate LIKE '$year-$month-%'";

	if(mysql_num_rows($sql)==0)
	{
		return "";
	}
	else
	{
		$total_avg = 0;
		$counter = 0;
		
		while($fetch_row = mysql_fetch_array($sql))
		{
			$counter++;

			$ID = $fetch_row['ID'];
			$minimum = returnProductReportValues22($productID,$ID,'minimum_value');
			$maximum = returnProductReportValues22($productID,$ID,'maximum_value');
			$avg = ($minimum+$maximum)/2;
			$total_avg = $total_avg + $avg;
		}//end while loop

		$avg_o = $total_avg/$counter;
		return number_format($avg_o);
	}
}

function returnProductReportValues22($productID,$idrecord,$column)
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
			
			return $fetch_data[$column];
		}
	}
}

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

function Date_formating($date)
{
	if($date!='0000-00-00')
	{
	$dateformat = explode( "-" , $date);
	
	$day = $dateformat[2];
	$month = $dateformat[1];
	$year = $dateformat[0];
	
	$formatteddate = $day."/".$month."/".$year;
	}
	
	return $formatteddate;
}

function return_sub_abc_name($abcID)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM conference_sub_abc WHERE ID='$abcID' ",$connect)or die('Error returning Conference Name due to - '.mysql_error());	
	$fetch_details = mysql_fetch_array($query);
	return $fetch_details['abc_name'];
}

function return_conference_name($id)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM markets WHERE ID='$id' ",$connect)or die('Error returning Conference Name due to - '.mysql_error());	
	$fetch_details = mysql_fetch_array($query);
	return $fetch_details['MarketName'];
}


function returnMarketPrice($marketID)
{
	require('connection.php');
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
	
	return $ID_report;

}

function ReturnZoneDetails($zoneID,$toreturn)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM zones_lists WHERE ID='$zoneID' ",$connect)or die(mysql_error());	
	$fetch_details = mysql_fetch_array($query);
	return $fetch_details[$toreturn];
}//end function

function return_conference_abbrev($id)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM conferences_list WHERE ID='$id' ",$connect)or die(mysql_error());	
	$fetch_details = mysql_fetch_array($query);
	return $fetch_details['Abbreviation'];
}

function return_Evang_Name($id)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM evangelists_list WHERE ID='$id' ",$connect)or die(mysql_error());	
	$fetch_details = mysql_fetch_array($query);
	return $fetch_details['First_Name']." ".$fetch_details['Middle_Name']." ".$fetch_details['Last_Name'];
}

function return_Evang_Phone($id)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM evangelists_list WHERE ID='$id' ",$connect)or die(mysql_error());	
	$fetch_details = mysql_fetch_array($query);
	if($fetch_details['Phone']=='')
	 return '';
	 else
	return ' - '.$fetch_details['Phone'];
}

function GetTotalValueIssue($IssueID,$tablename)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM $tablename WHERE TransID='$IssueID' ",$connect) or die(mysql_error());
	if(mysql_num_rows($query)>0)
	{
		$total = 0;
		while($fetchDateIssue = mysql_fetch_array($query))
		{
			$single_total = $fetchDateIssue['Quantity']*$fetchDateIssue['UniPrice'];
			$total = $total + $single_total;
		}//end while loop
	}

	return $total;

}

function return_book_name($bookID)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM books_list WHERE ID='$bookID'",$connect)or die(mysql_error());
	$fetch_book = mysql_fetch_array($query);
	return $fetch_book['BookName'];

}

function getzoneID($evangID)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM evangelists_list WHERE ID='$evangID' ",$connect)or die(mysql_error());	
	$fetch_details = mysql_fetch_array($query);
	return $fetch_details['zoneID'];
}	
//*********************************************************** ZONE'S LIST CALCULATIONS ***********************************

function Apdd_Monthly_Calculation($zoneID,$month,$year,$item)
{
	require('connection.php');
	$partial_date = $year.'-'.$month.'-';
	//echo "SELECT SUM($item) AS Value_Selected FROM  apdd_report WHERE Date LIKE '$partial_date%' AND zoneID='$zoneID'";
	$query = mysql_query("SELECT SUM($item) AS Value_Selected FROM  apdd_report WHERE Date LIKE '$partial_date%' AND zoneID='$zoneID' ",$connect)or die(mysql_error());
	$fetch_value_sum = mysql_fetch_array($query);
	return $fetch_value_sum['Value_Selected'];
}

function Apdd_Quarter_Calculation($zoneID,$month,$year,$item)
{
	switch($month)
	{
		case 1:
		$value1='01';$value2='02';$value3='03';
		break;
		case 2:	
		$value1='04';$value2='05';$value3='06';
		break;
		case 3:
		$value1='07';$value2='08';$value3='09';
		break;
		case 4:
		$value1=10;$value2=11;$value3=12;
		break;
	}
	
	require('connection.php');
	$partial_date1 = $year.'-'.$value1.'-';
	$partial_date2 = $year.'-'.$value2.'-';
	$partial_date3 = $year.'-'.$value3.'-';
	
	//echo "SELECT SUM($item) AS Value_Selected FROM apdd_report WHERE (Date LIKE '$partial_date1%' OR Date LIKE '$partial_date2%' OR Date LIKE '$partial_date3%') AND zoneID='$zoneID' ";
	
	$query = mysql_query("SELECT SUM($item) AS Value_Selected FROM apdd_report WHERE (Date LIKE '$partial_date1%' OR Date LIKE '$partial_date2%' OR Date LIKE '$partial_date3%') AND zoneID='$zoneID' ",$connect)or die(mysql_error());
	$fetch_value_sum = mysql_fetch_array($query);
	return $fetch_value_sum['Value_Selected'];
}

function Apdd_Custom_Calculation($zoneID,$month,$year,$item,$start_month)
{
	$conc = "";
	for($i=$month;$i>=$start_month;$i--)
	{
		if($i<10)
			$month_val = '0'.$i;
		else
			$month_val = $i;
			
		if($i==$start_month)
		$conc = $conc."Date LIKE '$year-$month_val-%'";
		else
		$conc = $conc."Date LIKE '$year-$month_val-%' OR ";
	}
	
	require('connection.php');
	
	///echo "SELECT SUM($item) AS Value_Selected FROM apdd_report WHERE ($conc) AND zoneID='$zoneID'";
	
	$query = mysql_query("SELECT SUM($item) AS Value_Selected FROM apdd_report WHERE ($conc) AND zoneID='$zoneID' ",$connect)or die(mysql_error());
	$fetch_value_sum = mysql_fetch_array($query);
	return $fetch_value_sum['Value_Selected'];
}

//***********************************************************UNION DIVISION ITEMS TO BE SENT******************************
function UnionMonthlyFigure($conferenceID,$month,$year,$item)
{
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS Value_Selected FROM evangelists_monthly_report WHERE year='$year' AND month='$month' AND evangelistID IN (SELECT ID FROM evangelists_list WHERE zoneID IN (SELECT ID FROM zones_lists WHERE ConferenceID ='$conferenceID' ))",$connect)or die(mysql_error());
	$fetch_value_sum = mysql_fetch_array($query);
	return $fetch_value_sum['Value_Selected'];
}

function UnionQuartelyFigure($conferenceID,$month,$year,$item)
{
								switch($month)
								{
									case 1:
										$prev_year = $year-1;
										$value1= "(month='11' AND year=".$prev_year.")";
										$value2= "(month='12' AND year=".$prev_year.")";
										$value3= "(month='1' AND year=".$year.")";
										break;
									case 2:	
										$value1="(month='2' AND year=".$year.")";
										$value2="(month='3' AND year=".$year.")";
										$value3="(month='4' AND year=".$year.")";
										break;
									case 3:
										$value1="(month='5' AND year=".$year.")"
										;$value2="(month='6' AND year=".$year.")";
										$value3="(month='7' AND year=".$year.")";
										break;
									case 4:
										$value1="(month='8' AND year=".$year.")";
										$value2="(month='9' AND year=".$year.")";
										$value3="(month='10' AND year=".$year.")";
									break;
								}//end switch statement...
	
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS Value_Selected FROM evangelists_monthly_report WHERE ID>0 AND ($value1 OR $value2 OR $value3 ) AND evangelistID IN (SELECT ID FROM evangelists_list WHERE zoneID IN (SELECT ID FROM zones_lists WHERE ConferenceID ='$conferenceID' ))",$connect)or die(mysql_error());
	$fetch_value_sum = mysql_fetch_array($query);
	return $fetch_value_sum['Value_Selected'];
}

function UnionCustomFigure($conferenceID,$month,$year,$item,$start_month)
{
	require('connection.php');
	
	$conc = "";
	for($i=$month;$i>=$start_month;$i--)
	{
		if($i==$start_month)
		$conc = $conc."month='$i'";
		else
		$conc = $conc."month='$i' OR ";
	}
	
	$query = mysql_query("SELECT SUM($item) AS Value_Selected FROM evangelists_monthly_report WHERE year='$year' AND ($conc) AND evangelistID IN (SELECT ID FROM evangelists_list WHERE zoneID IN (SELECT ID FROM zones_lists WHERE ConferenceID ='$conferenceID' ))",$connect)or die(mysql_error());
	$fetch_value_sum = mysql_fetch_array($query);
	return $fetch_value_sum['Value_Selected'];
}

function UnionMonthlyFigureTotal($month,$year,$item)
{
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS Value_Selected FROM evangelists_monthly_report WHERE year='$year' AND month='$month' ",$connect)or die(mysql_error());
	$fetch_value_sum = mysql_fetch_array($query);
	return $fetch_value_sum['Value_Selected'];
}

function NumberEvangelistsUnion($conferenceID,$evangID)
{
	require('connection.php');
	$query = mysql_query("SELECT COUNT(ID) AS Value_Selected FROM evangelists_list WHERE Grade='$evangID' AND zoneID IN (SELECT ID FROM zones_lists WHERE ConferenceID ='$conferenceID' )",$connect)or die(mysql_error());
	$fetch_value_sum = mysql_fetch_array($query);
	return $fetch_value_sum['Value_Selected'];	
}

function NumberEvangelistsUnionTotal($conferenceID,$evangID)
{
	require('connection.php');
	$query = mysql_query("SELECT COUNT(ID) AS Value_Selected FROM evangelists_list WHERE Grade='$evangID' ",$connect)or die(mysql_error());
	$fetch_value_sum = mysql_fetch_array($query);
	return $fetch_value_sum['Value_Selected'];	
}
//************************************************************************************************************************

function getConfID($zoneIDre)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM zones_lists WHERE ID='$zoneIDre' ",$connect)or die(mysql_error());	
	$fetch_details = mysql_fetch_array($query);
	return $fetch_details['ConferenceID'];	
}

function return_grade_Name($grade_id)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM evangelists_grades WHERE ID='$grade_id' ",$connect)or die(mysql_error());	
	$fetch_details = mysql_fetch_array($query);
	return $fetch_details['Name'];
}

//*********************************************************Monthly Data *********************************************************************

function Sum_Monthly_Value($evangID,$month,$year,$item)
{
	require('connection.php');
	$query = mysql_query("SELECT $item FROM evangelists_monthly_report WHERE evangelistID='$evangID' AND year='$year' AND month='$month' ",$connect)or die(mysql_error());	
	$fetch_results = mysql_fetch_array($query);
	return $fetch_results[$item];
}

function ArrangezoneMonthly($evangID,$month,$year,$item,$zoneID)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM evangelists_monthly_report WHERE year='$year' AND month='$month' AND evangelistID IN (SELECT ID FROM evangelists_list WHERE zoneID='$zoneID') ORDER BY  $item DESC ",$connect) or die(mysql_error());	
	if(mysql_num_rows($query)>0)
	{	
		$num = 0;
		while($fetch_zones = mysql_fetch_array($query))
		{
			$num++;
			if($fetch_zones['evangelistID']==$evangID)
			{
				$position = $num;
				break;
			}
		}
	}
	else
	{
		$position = 0;	
	}
	
	return $position;
	
	
}

function ArrangeConfMonthly($evangID,$month,$year,$item,$zoneID,$confID)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM evangelists_monthly_report WHERE year='$year' AND month='$month' AND evangelistID IN (SELECT ID FROM evangelists_list WHERE zoneID IN (SELECT ID FROM zones_lists WHERE ConferenceID='$confID' )) ORDER BY  $item DESC ",$connect) or die(mysql_error());	
	if(mysql_num_rows($query)>0)
	{	
		$num = 0;
		while($fetch_zones = mysql_fetch_array($query))
		{
			$num++;
			if($fetch_zones['evangelistID']==$evangID)
			{
				$position = $num;
				break;
			}
		}
	}
	else
	{
		$position = 0;	
	}
	
	return $position;
	
	
}

function ArrangeUnionMonthly($evangID,$month,$year,$item,$zoneID,$confID)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM evangelists_monthly_report WHERE year='$year' AND month='$month' AND evangelistID IN (SELECT ID FROM evangelists_list WHERE zoneID IN (SELECT ID FROM zones_lists WHERE ConferenceID IN (SELECT ID FROM conferences_list ) ) ) ORDER BY  $item DESC ",$connect) or die(mysql_error());	
	if(mysql_num_rows($query)>0)
	{	
		$num = 0;
		while($fetch_zones = mysql_fetch_array($query))
		{
			$num++;
			if($fetch_zones['evangelistID']==$evangID)
			{
				$position = $num;
				break;
			}
		}
	}
	else
	{
		$position = 0;	
	}
	
	return $position;
	
	
}


function Sum_Item_Month($item,$month,$year,$zoneID)
{
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS sum_item FROM evangelists_monthly_report WHERE year='$year' AND month='$month' AND evangelistID IN(SELECT ID FROM evangelists_list WHERE zoneID='$zoneID' )",$connect)or die(mysql_error());
	$fetch_sum = mysql_fetch_array($query);
	return $fetch_sum['sum_item'];
}

//********************************************************Quartely******************************************

function Sum_Item_Quarter($evangID,$month,$year,$item)
{
								switch($month)
								{
									case 1:
										$prev_year = $year-1;
										$value1= "(month='11' AND year=".$prev_year.")";
										$value2= "(month='12' AND year=".$prev_year.")";
										$value3= "(month='1' AND year=".$year.")";
										break;
									case 2:	
										$value1="(month='2' AND year=".$year.")";
										$value2="(month='3' AND year=".$year.")";
										$value3="(month='4' AND year=".$year.")";
										break;
									case 3:
										$value1="(month='5' AND year=".$year.")"
										;$value2="(month='6' AND year=".$year.")";
										$value3="(month='7' AND year=".$year.")";
										break;
									case 4:
										$value1="(month='8' AND year=".$year.")";
										$value2="(month='9' AND year=".$year.")";
										$value3="(month='10' AND year=".$year.")";
									break;
								}//end switch statement...
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS Sum_Item FROM evangelists_monthly_report WHERE evangelistID='$evangID' AND ($value1 OR $value2 OR $value3 ) ",$connect)or die(mysql_error());	
	$fetch_results = mysql_fetch_array($query);
	return $fetch_results['Sum_Item'];
}

function ArrangezoneQuarter($evangID,$month,$year,$item,$zoneID)
{
	switch($month)
	{
		case 1:
		$value1=1;$value2=2;$value3=3;
		break;
		case 2:	
		$value1=4;$value2=5;$value3=6;
		break;
		case 3:
		$value1=7;$value2=8;$value3=9;
		break;
		case 4:
		$value1=10;$value2=11;$value3=12;
		break;
	}
	
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS item_Sum,evangelistID FROM evangelists_monthly_report WHERE year='$year' AND (month='$value1' OR month='$value2' OR month='$value3' ) AND evangelistID IN (SELECT ID FROM evangelists_list WHERE zoneID='$zoneID') GROUP BY evangelistID ORDER BY item_Sum DESC ",$connect) or die(mysql_error());	
	if(mysql_num_rows($query)>0)
	{	
		$num = 0;
		while($fetch_zones = mysql_fetch_array($query))
		{
			$num++;
			if($fetch_zones['evangelistID']==$evangID)
			{
				$position = $num;
				break;
			}
		}
	}
	else
	{
		$position = 0;	
	}
	
	return $position;
	
	
}

function ArrangeConfQuarter($evangID,$month,$year,$item,$zoneID,$confID)
{
	switch($month)
	{
		case 1:
		$value1=1;$value2=2;$value3=3;
		break;
		case 2:	
		$value1=4;$value2=5;$value3=6;
		break;
		case 3:
		$value1=7;$value2=8;$value3=9;
		break;
		case 4:
		$value1=10;$value2=11;$value3=12;
		break;
	}
	
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS item_Sum,evangelistID FROM evangelists_monthly_report WHERE year='$year' AND (month='$value1' OR month='$value2' OR month='$value3' ) AND evangelistID IN (SELECT ID FROM evangelists_list WHERE zoneID IN (SELECT ID FROM zones_lists WHERE ConferenceID='$confID' )) GROUP BY evangelistID ORDER BY item_Sum DESC ",$connect) or die(mysql_error());	
	if(mysql_num_rows($query)>0)
	{	
		$num = 0;
		while($fetch_zones = mysql_fetch_array($query))
		{
			$num++;
			if($fetch_zones['evangelistID']==$evangID)
			{
				$position = $num;
				break;
			}
		}
	}
	else
	{
		$position = 0;	
	}
	
	return $position;
	
	
}


function ArrangeUnionQuarter($evangID,$month,$year,$item,$zoneID,$confID)
{
	switch($month)
	{
		case 1:
		$value1=1;$value2=2;$value3=3;
		break;
		case 2:	
		$value1=4;$value2=5;$value3=6;
		break;
		case 3:
		$value1=7;$value2=8;$value3=9;
		break;
		case 4:
		$value1=10;$value2=11;$value3=12;
		break;
	}
	
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS item_Sum,evangelistID FROM evangelists_monthly_report WHERE year='$year' AND (month='$value1' OR month='$value2' OR month='$value3' ) AND evangelistID IN (SELECT ID FROM evangelists_list WHERE zoneID IN (SELECT ID FROM zones_lists WHERE ConferenceID IN (SELECT ID FROM conferences_list ) ) ) GROUP BY evangelistID ORDER BY item_Sum DESC  ",$connect) or die(mysql_error());	
	if(mysql_num_rows($query)>0)
	{	
		$num = 0;
		while($fetch_zones = mysql_fetch_array($query))
		{
			$num++;
			if($fetch_zones['evangelistID']==$evangID)
			{
				$position = $num;
				break;
			}
		}
	}
	else
	{
		$position = 0;	
	}
	
	return $position;
	
	
}



//***********************************************Custom Report*************************************************************************************

function Sum_Item_Custom($evangID,$month,$year,$item,$start_month)
{
	$conc = "";
	for($i=$month;$i>=$start_month;$i--)
	{
		if($i==$start_month)
		$conc = $conc."month='$i'";
		else
		$conc = $conc."month='$i' OR ";
	}
	
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS Sum_Item FROM evangelists_monthly_report WHERE evangelistID='$evangID' AND year='$year' AND ($conc ) ",$connect)or die(mysql_error());	
	$fetch_results = mysql_fetch_array($query);
	return $fetch_results['Sum_Item'];
}

function ArrangezoneCustom($evangID,$month,$year,$item,$zoneID,$start_month)
{
	$conc = "";
	for($i=$month;$i>=$start_month;$i--)
	{
		if($i==$start_month)
		$conc = $conc."month='$i'";
		else
		$conc = $conc."month='$i' OR ";
	}
	
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS item_Sum,evangelistID FROM evangelists_monthly_report WHERE year='$year' AND ($conc) AND evangelistID IN (SELECT ID FROM evangelists_list WHERE zoneID='$zoneID') GROUP BY evangelistID ORDER BY item_Sum DESC ",$connect) or die(mysql_error());	
	if(mysql_num_rows($query)>0)
	{	
		$num = 0;
		while($fetch_zones = mysql_fetch_array($query))
		{
			$num++;
			if($fetch_zones['evangelistID']==$evangID)
			{
				$position = $num;
				break;
			}
		}
	}
	else
	{
		$position = 0;	
	}
	
	return $position;
	
	
}

function ArrangeConfCustom($evangID,$month,$year,$item,$zoneID,$confID,$start_month)
{
	$conc = "";
	for($i=$month;$i>=$start_month;$i--)
	{
		if($i==$start_month)
		$conc = $conc."month='$i'";
		else
		$conc = $conc."month='$i' OR ";
	}
	
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS item_Sum,evangelistID FROM evangelists_monthly_report WHERE year='$year' AND ($conc) AND evangelistID IN (SELECT ID FROM evangelists_list WHERE zoneID IN (SELECT ID FROM zones_lists WHERE ConferenceID='$confID' )) GROUP BY evangelistID ORDER BY item_Sum DESC ",$connect) or die(mysql_error());	
	if(mysql_num_rows($query)>0)
	{	
		$num = 0;
		while($fetch_zones = mysql_fetch_array($query))
		{
			$num++;
			if($fetch_zones['evangelistID']==$evangID)
			{
				$position = $num;
				break;
			}
		}
	}
	else
	{
		$position = 0;	
	}
	
	return $position;
	
	
}

function ArrangeUnionCustom($evangID,$month,$year,$item,$zoneID,$confID,$start_month)
{
	$conc = "";
	for($i=$month;$i>=$start_month;$i--)
	{
		if($i==$start_month)
		$conc = $conc."month='$i'";
		else
		$conc = $conc."month='$i' OR ";
	}
	
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS item_Sum,evangelistID FROM evangelists_monthly_report WHERE year='$year' AND ($conc) AND evangelistID IN (SELECT ID FROM evangelists_list WHERE zoneID IN (SELECT ID FROM zones_lists WHERE ConferenceID IN (SELECT ID FROM conferences_list ) ) ) GROUP BY evangelistID ORDER BY item_Sum DESC  ",$connect) or die(mysql_error());	
	if(mysql_num_rows($query)>0)
	{	
		$num = 0;
		while($fetch_zones = mysql_fetch_array($query))
		{
			$num++;
			if($fetch_zones['evangelistID']==$evangID)
			{
				$position = $num;
				break;
			}
		}
	}
	else
	{
		$position = 0;	
	}
	
	return $position;
	
	
}

//**************************************************************************************************************************************************

function EvangelistSummary($evangID,$month,$year,$item)
{
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS sum_item FROM evangelists_monthly_report WHERE month='$month' AND year='$year' AND evangelistID ='$evangID' ",$connect)or die(mysql_error());
	$fetch_data = mysql_fetch_array($query);
	return $fetch_data['sum_item'];
}//end function$

function ConferenceSummary($confID,$month,$year,$item)
{
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS sum_item FROM evangelists_monthly_report WHERE month='$month' AND year='$year' AND evangelistID IN(SELECT ID FROM evangelists_list WHERE zoneID IN (SELECT ID FROM zones_lists WHERE ConferenceID='$confID') )",$connect)or die(mysql_error());
	$fetch_data = mysql_fetch_array($query);
	return $fetch_data['sum_item'];
}//end function$

function ZoneSummary($zoneID,$month,$year,$item)
{
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS sum_item FROM evangelists_monthly_report WHERE month='$month' AND year='$year' AND evangelistID IN(SELECT ID FROM evangelists_list WHERE zoneID ='$zoneID' )",$connect)or die(mysql_error());
	$fetch_data = mysql_fetch_array($query);
	return $fetch_data['sum_item'];
}//end function$

function ZoneSummaryQuarterz($zoneID,$month,$year,$item)
{
	switch($month)
	{
		case 1:
		$value1=1;$value2=2;$value3=3;
		break;
		case 2:	
		$value1=4;$value2=5;$value3=6;
		break;
		case 3:
		$value1=7;$value2=8;$value3=9;
		break;
		case 4:
		$value1=10;$value2=11;$value3=12;
		break;
	}
	
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS sum_item FROM evangelists_monthly_report WHERE year='$year' AND (month='$value1' OR month='$value2' OR month='$value3' ) AND  evangelistID IN(SELECT ID FROM evangelists_list WHERE zoneID ='$zoneID' )",$connect)or die(mysql_error());
	$fetch_data = mysql_fetch_array($query);
	return $fetch_data['sum_item'];
}//end function$

function ZoneSummaryCustomz($zoneID,$month,$year,$item,$start_month)
{
	$conc = "";
	for($i=$month;$i>=$start_month;$i--)
	{
		if($i==$start_month)
		$conc = $conc."month='$i'";
		else
		$conc = $conc."month='$i' OR ";
	}
	
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS sum_item FROM evangelists_monthly_report WHERE year='$year' AND ($conc) AND  evangelistID IN(SELECT ID FROM evangelists_list WHERE zoneID ='$zoneID' )",$connect)or die(mysql_error());
	$fetch_data = mysql_fetch_array($query);
	return $fetch_data['sum_item'];
}//end function$

function UnionSummary($confID,$month,$year,$item)
{
	require('connection.php');
	$query = mysql_query("SELECT SUM($item) AS sum_item FROM evangelists_monthly_report WHERE month='$month' AND year='$year' AND evangelistID IN(SELECT ID FROM evangelists_list WHERE zoneID IN (SELECT ID FROM zones_lists WHERE ConferenceID IN (SELECT ID FROM conferences_list)) )",$connect)or die(mysql_error());
	$fetch_data = mysql_fetch_array($query);
	return $fetch_data['sum_item'];
}//end function$

function System_Navigation()
{
	?>
    <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="Conferences_list_home.php">NTUC</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="#" class="profile-mini">
                            <img src="assets/images/users/<?php echo return_staff_picture($_SESSION['username']); ?>" alt="John Doe"/>
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                <img src="assets/images/users/<?php echo return_staff_picture($_SESSION['username']); ?>" alt="John Doe"/>
                            </div>
                            <div class="profile-data">
                                <div class="profile-data-name"><?php echo return_staff_name($_SESSION['username']); ?></div>
                                <div class="profile-data-title"><?php echo return_staff_title($_SESSION['username']); ?></div>
                                <div> <a href="signout.php" class="mb-control" data-box="#mb-signout">Sign Out</a>  </div>
                            </div>
                            <div class="profile-controls">
                                <a title="Update Your Profile" href="pages_update_profile.php" class="profile-control-left"><span class="fa fa-user"></span></a>
                                <a href="pages_change_password.php" data-toggle="tooltip" data-placement="right" title="Change Your Login Password" class="profile-control-right"><span class="fa fa-lock" ></span></a>
                            </div>
                        </div>                                                                        
                    </li>
                    <li class="xn-title">Main Navigation</li>   
                                     
                    <li>
                        <a href="Conferences_list_home.php"><span class="fa fa-desktop"></span> <span class="xn-text">My Orders </span></a>
                    </li>
                    
                    <li>
                        <a href="pages_update_profile.php"><span class="fa fa-user"></span> <span class="xn-text">Update My Profile </span></a>
                    </li>

                    <li>
                        <a href="pages_change_password.php"><span class="fa fa-lock"></span> <span class="xn-text"> Change My Password </span></a>
                    </li>

                    
                    <!--
                    <li>
                        <a href="#"><span class="fa fa-desktop"></span> <span class="xn-text">Conference BookShop(s)</span></a>
                        
                    </li>
                    
                    
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-clock-o"></span> Timeline</a>
                                <ul>
                                    <li><a href="pages-timeline.html"><span class="fa fa-align-center"></span> Default</a></li>
                                    <li><a href="pages-timeline-simple.html"><span class="fa fa-align-justify"></span> Full Width</a></li>
                                </ul>
                            </li>
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-envelope"></span> Mailbox</a>
                                <ul>
                                    <li><a href="pages-mailbox-inbox.html"><span class="fa fa-inbox"></span> Inbox</a></li>
                                    <li><a href="pages-mailbox-message.html"><span class="fa fa-file-text"></span> Message</a></li>
                                    <li><a href="pages-mailbox-compose.html"><span class="fa fa-pencil"></span> Compose</a></li>
                                </ul>
                            </li>
                            <li><a href="pages-messages.html"><span class="fa fa-comments"></span> Messages</a></li>
                            <li><a href="pages-calendar.html"><span class="fa fa-calendar"></span> Calendar</a></li>
                            <li><a href="pages-tasks.html"><span class="fa fa-edit"></span> Tasks</a></li>
                            <li><a href="pages-content-table.html"><span class="fa fa-columns"></span> Content Table</a></li>
                            <li><a href="pages-faq.html"><span class="fa fa-question-circle"></span> FAQ</a></li>
                            <li><a href="pages-search.html"><span class="fa fa-search"></span> Search</a></li>
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-file"></span> Blog</a>
                                
                                <ul>                                    
                                    <li><a href="pages-blog-list.html"><span class="fa fa-copy"></span> List of Posts</a></li>
                                    <li><a href="pages-blog-post.html"><span class="fa fa-file-o"></span>Single Post</a></li>
                                </ul>
                            </li>
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-sign-in"></span> Login</a>
                                <ul>                                    
                                    <li><a href="pages-login.html">App Login</a></li>
                                    <li><a href="pages-login-website.html">Website Login</a></li>
                                    <li><a href="pages-login-website-light.html"> Website Login Light</a></li>
                                </ul>
                            </li>                            
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-warning"></span> Error Pages</a>
                                <ul>                                    
                                    <li><a href="pages-error-404.html">Error 404 Sample 1</a></li>
                                    <li><a href="pages-error-404-2.html">Error 404 Sample 2</a></li>
                                    <li><a href="pages-error-500.html"> Error 500</a></li>
                                </ul>
                            </li>                            
                        </ul>
                    </li>
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-file-text-o"></span> <span class="xn-text">Layouts</span></a>
                        <ul>
                            <li><a href="layout-boxed.html">Boxed</a></li>
                            <li><a href="layout-nav-toggled.html">Navigation Toggled</a></li>
                            <li><a href="layout-nav-top.html">Navigation Top</a></li>
                            <li><a href="layout-nav-right.html">Navigation Right</a></li>
                            <li><a href="layout-nav-top-fixed.html">Top Navigation Fixed</a></li>                            
                            <li><a href="layout-nav-custom.html">Custom Navigation</a></li>
                            <li><a href="layout-frame-left.html">Frame Left Column</a></li>
                            <li><a href="layout-frame-right.html">Frame Right Column</a></li>
                            <li><a href="layout-search-left.html">Search Left Side</a></li>
                            <li><a href="blank.html">Blank Page</a></li>
                        </ul>
                    </li>         
                    <li class="xn-title">Components</li>                    
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-cogs"></span> <span class="xn-text">UI Kits</span></a>
                        <ul>
                            <li><a href="ui-widgets.html"><span class="fa fa-heart"></span> Widgets</a></li>                            
                            <li><a href="ui-elements.html"><span class="fa fa-cogs"></span> Elements</a></li>
                            <li><a href="ui-buttons.html"><span class="fa fa-square-o"></span> Buttons</a></li>                            
                            <li><a href="ui-panels.html"><span class="fa fa-pencil-square-o"></span> Panels</a></li>
                            <li><a href="ui-icons.html"><span class="fa fa-magic"></span> Icons</a><div class="informer informer-warning">+679</div></li>
                            <li><a href="ui-typography.html"><span class="fa fa-pencil"></span> Typography</a></li>
                            <li><a href="ui-portlet.html"><span class="fa fa-th"></span> Portlet</a></li>
                            <li><a href="ui-sliders.html"><span class="fa fa-arrows-h"></span> Sliders</a></li>
                            <li><a href="ui-alerts-popups.html"><span class="fa fa-warning"></span> Alerts & Popups</a></li>                            
                            <li><a href="ui-lists.html"><span class="fa fa-list-ul"></span> Lists</a></li>
                            <li><a href="ui-tour.html"><span class="fa fa-random"></span> Tour</a></li>
                        </ul>
                    </li>                    
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-pencil"></span> <span class="xn-text">Forms</span></a>
                        <ul>
                            <li>
                                <a href="form-layouts-two-column.html"><span class="fa fa-tasks"></span> Form Layouts</a>
                                <div class="informer informer-danger">New</div>
                                <ul>
                                    <li><a href="form-layouts-one-column.html"><span class="fa fa-align-justify"></span> One Column</a></li>
                                    <li><a href="form-layouts-two-column.html"><span class="fa fa-th-large"></span> Two Column</a></li>
                                    <li><a href="form-layouts-tabbed.html"><span class="fa fa-table"></span> Tabbed</a></li>
                                    <li><a href="form-layouts-separated.html"><span class="fa fa-th-list"></span> Separated Rows</a></li>
                                </ul> 
                            </li>
                            <li><a href="form-elements.html"><span class="fa fa-file-text-o"></span> Elements</a></li>
                            <li><a href="form-validation.html"><span class="fa fa-list-alt"></span> Validation</a></li>
                            <li><a href="form-wizards.html"><span class="fa fa-arrow-right"></span> Wizards</a></li>
                            <li><a href="form-editors.html"><span class="fa fa-text-width"></span> WYSIWYG Editors</a></li>
                            <li><a href="form-file-handling.html"><span class="fa fa-floppy-o"></span> File Handling</a></li>
                        </ul>
                    </li>
                    <li class="xn-openable active">
                        <a href="tables.html"><span class="fa fa-table"></span> <span class="xn-text">Tables</span></a>
                        <ul>                            
                            <li><a href="table-basic.html"><span class="fa fa-align-justify"></span> Basic</a></li>
                            <li><a href="table-datatables.html"><span class="fa fa-sort-alpha-desc"></span> Data Tables</a></li>
                            <li class="active"><a href="table-export.html"><span class="fa fa-download"></span> Export Tables</a></li>                     
                        </ul>
                    </li>
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-bar-chart-o"></span> <span class="xn-text">Charts</span></a>
                        <ul>
                            <li><a href="charts-morris.html"><span class="xn-text">Morris</span></a></li>
                            <li><a href="charts-nvd3.html"><span class="xn-text">NVD3</span></a></li>
                            <li><a href="charts-rickshaw.html"><span class="xn-text">Rickshaw</span></a></li>
                            <li><a href="charts-other.html"><span class="xn-text">Other</span></a></li>
                        </ul>
                    </li>     
                    <li>
                        <a href="maps.html"><span class="fa fa-map-marker"></span> <span class="xn-text">Maps</span></a>
                    </li>                    
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-sitemap"></span> <span class="xn-text">Navigation Levels</span></a>
                        <ul>                            
                            <li class="xn-openable">
                                <a href="#">Second Level</a>
                                <ul>
                                    <li class="xn-openable">
                                        <a href="#">Third Level</a>
                                        <ul>
                                            <li class="xn-openable">
                                                <a href="#">Fourth Level</a>
                                                <ul>
                                                    <li><a href="#">Fifth Level</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>                            
                        </ul>
                    </li>       -->             
                </ul>
            
    <?php	
}

function return_staff_name($username)
{

	require('connection.php');
	$query = mysql_query("SELECT * FROM users_table WHERE email ='$username' ",$connect)or die(mysql_error());
	$fetch_staff_details = mysql_fetch_array($query);
	return $fetch_staff_details['full_name'];
}

function return_staff_title($username)
{

	require('connection.php');
	$query = mysql_query("SELECT * FROM publishing_staffs WHERE username ='$username' ",$connect)or die(mysql_error());
	$fetch_staff_details = mysql_fetch_array($query);
	return $fetch_staff_details['Title'];
}

function return_staff_picture($username)
{


	require('connection.php');
	$query = mysql_query("SELECT * FROM users_table WHERE email ='$username' ",$connect)or die(mysql_error());
	$fetch_staff_details = mysql_fetch_array($query);
	return $fetch_staff_details['ImageName'];

}//end function return pictures


function return_user_ID($username)
{
	require('connection.php');
	$query = mysql_query("SELECT * FROM users_table WHERE email ='$username' ",$connect)or die(mysql_error());
	$fetch_staff_details = mysql_fetch_array($query);
	return $fetch_staff_details['ID'];
}//end function return pictures

?>