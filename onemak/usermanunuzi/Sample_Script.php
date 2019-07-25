<?php
require('functions.php');
require('connection.php');

/*$query = mysql_query("SELECT * FROM evangelists_monthly_report ",$connect)or die(mysql_error());

while($fetch_data = mysql_fetch_array($query))
{
	$id = $fetch_data['ID'];
	$evangID = $fetch_data['evangelistID'];
	
	$zoneID = getZoneIDfromEvangelists($evangID);
	
	$updateQuery = mysql_query("UPDATE evangelists_monthly_report SET zone='$zoneID' WHERE ID='$id' ",$connect)or die(mysql_error());
	
}//end while loop
*/

$query = mysql_query("SELECT SUM(Value_sales) AS Value_sales,SUM(hours) AS hours,zone FROM evangelists_monthly_report WHERE year='2017' AND month='1' GROUP BY zone ORDER BY Value_sales DESC ",$connect)or die(mysql_error());
?>
<table>
<tr><td> No </td> <td> Zone </td> <td> Value </td> <td> Hours </td> </tr>
<?php
$num=0;
while($fetch_data = mysql_fetch_array($query))
{
	$num++;
	?>
    <tr>
    <td> <?php echo $num; ?> </td>
    <td> <?php echo $fetch_data['zone']; ?> </td>
    <td> <?php echo number_format($fetch_data['Value_sales']); ?> </td> 
    <td> <?php echo number_format($fetch_data['hours']); ?> </td>
    </tr>
    <?php
}//end while loop
?>
</table>