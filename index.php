<?php
	// Check for config file
	if(file_exists("config.php") == false)
	{
		// Redirect the user
		Header("Location: install/index.php");
	}
	
	$result = include("config.php");
	
	if($result == false)
	{
		// Wrong config file was generated, go to install script
		Header("Location: install/index.php");
	}
	
	// Include some system headers
	require_once "include/functions.inc.php";
	require_once "include/database.inc.php";
	require_once "include/forum.inc.php";
	require_once "include/accounts.inc.php";
	
	if(Database::Connect() == false)
	{
		echo 'Error';
	}
?>

<!DOCTYPE html>
	<html>
	<head>
		<title>EVEmu Portal - Under construction</title>
		<style>
		<!--
			body
			{
				font-family: Century Gothic, Verdana, Arial, Helvetica, sans-serif;
				font-size: 10pt;
				color: rgb(255, 255, 255);
				background-color: rgb(17, 17, 17);
				text-shadow: 0.1em 0.1em 0.05em #333;
			}
		-->
		</style>
		<!-- Add meta here for your web -->
	</head>
	<body>
		<div style="margin: 30% 30% 30% 30%; text-align: center;">
			EVEmu Portal is under construction
		</div>
	</body>
</html>

<?php
	Database::Close();
?>