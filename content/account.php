<?php
	$module = @$_GET['m'];
	
	if(empty($module) == true)
	{
		$module = "main";
	}
	
	$file = "accountmanagement/$module.php";
	
	if(file_exists($file) == false)
	{
		include '404.php';
	}
	else
	{
		include $file;
	}
?>