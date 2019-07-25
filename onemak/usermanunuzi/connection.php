<?php
	$connect = mysql_connect('localhost','onemak_user','P@55w0rd');
	mysql_select_db("onemak_marketInfo",$connect)or die(mysql_error());
?>