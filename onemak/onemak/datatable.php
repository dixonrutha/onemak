
<?php
require('connection.php');

if(isset($_GET['editIssue']))
{
	$id = $_GET['editIssue'];

	
	$querySelect = mysql_query("SELECT * FROM mainabc_issues WHERE ID='$id' ",$connect)or die(mysql_error());
	die(json_encode(mysql_fetch_assoc($querySelect)));
}



if(isset($_GET['editItemIssue']))
{
	$id2 = $_GET['editItemIssue'];

	$querySelect2 = mysql_query("SELECT * FROM mainabc_issues_items WHERE ID='$id2' ",$connect)or die(mysql_error());
	die(json_encode(mysql_fetch_assoc($querySelect2)));
}
?>