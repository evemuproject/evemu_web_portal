<?php
	$step = 0;
	$file = "data/step0.php";
			
	if( (isset($_GET['step'])) && (empty($_GET['step']) == false) )
	{
		$file = "data/step" . $_GET['step'] . ".php";
	}
	
	if(file_exists($file) == false)
	{
		Header("Location: /install/index.php");
	}
	
	require_once "../include/functions.inc.php";
	require_once "../include/database.inc.php";
	require_once "../include/accounts.inc.php";
	require_once "include/config.inc.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>EVEmu Portal installation</title>
		<style>
			<!--
				body
				{
					background-color: rgb(17, 17, 17);
					color: rgb(255, 255, 255);
					text-shadow: 0.1em 0.1em 0.05em #333;
					font-family: Century Gothic, Verdana, Arial, Helvetica, sans-serif;
					font-size: 10pt;
					text-align: center;
				}
				
				#installer-main
				{
					background-color: rgb(130, 130, 130);
					
					border-width: 1px;
					border-style: solid;
					border-color: rgb(0, 0, 0);
					
					-webkit-border-radius: 12px;
					-moz-border-radius: 12px;
					border-radius: 12px; /* CSS3 */
					
					behavior:url(border-radius.htc);
					
					width: 90%;
				}
				
				a, a:visited
				{
					color: rgb(201, 201, 201);
					text-decoration: none;
				}

				a:hover
				{
					color: rgb(171, 171, 171);
					text-decoration: underline;
				}
				
				img
				{
					border: 0;
				}
				
				input
				{
					background-color: rgb(0, 0, 0);
					
					border-width: 1px;
					border-style: solid;
					border-color: rgb(255, 255, 255);
					
					color: rgb(255, 255, 255);
					text-shadow: 0.1em 0.1em 0.05em #333;
					font-family: Century Gothic, Verdana, Arial, Helvetica, sans-serif;
					font-size: 10pt;
					text-align: center;
				}
				
				input:hover
				{
					border-color: rgb(130, 130, 130);
					background-color: rgb(255, 255, 255);
					color: rgb(0, 0, 0);
				}
				
				#entry-description
				{
					font-size: 8pt;
					font-style: italic;
				}
				
				#error
				{
					color: rgb(255, 17, 17);
					
					text-align: center;
					vertical-align: middle;
					height: 50px;
				}
				
				#sucess
				{
					color: rgb(17, 220, 17);
					
					text-align: center;
					vertical-align: middle;
					height: 50px;
				}

				#warn
				{
					color: rgb(220, 220, 17);
					
					text-align: center;
					vertical-align: middle;
					height: 50px;
				}
				
				#license
				{
					color: rgb(0, 0, 0);
					background-color: rgb(255, 255, 255);
					border-width: 1px;
					border-style: solid;
					border-color: rgb(0, 0, 0);
					text-shadow: 0 0 0 #FFFFFF;
					width: 90%
				}
				
				#userlist
				{
					border-width: 1px;
					border-color: rgb(255, 255, 255);
					border-style: solid;
					border-collapse: collapse;
					
					background-color: rgb(17, 17, 17);
					width: 90%;
				}
				
				#userlist td
				{
					border-width: 1px;
					border-style: solid;
					border-color: rgb(255, 255, 255);
				}
			-->
		</style>
	</head>
	
	<body>
		<h1>EVEmu Portal installation</h1>
		<center>
			<?php include($file); ?>
		</center>
	</body>
</html>