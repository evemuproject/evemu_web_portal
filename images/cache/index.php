<?php
	// We are using userInput from here
	require_once "../../include/functions.inc.php";
	
	// Some needed variables here ;)
	$folder = "";
	$imageExtension = "png";
	$imageID = "";
	
	if( @(empty($_GET['typeID']) == false) )
	{
		$folder = "InventoryType";
		$imageID = userInput($_GET['typeID']);
	}
	else if( @(empty($_GET['shipID']) == false) )
	{
		$folder = "Render";
		$imageID = userInput($_GET['shipID']);
	}
	else if( @(empty($_GET['characterID']) == false) )
	{
		$folder = "Characters";
		$imageID = userInput($_GET['characterID']);
		$imageExtension = "jpg";
	}
	
	$file = "$folder/$imageID.$imageExtension";
	
	if(file_exists($file) == false)
	{
		$file = "error.png";
		$imageExtension = "png";
	}
	
	if($imageExtension == "png")
	{
		header("Content-Type: image/png");
		$im = imagecreatefrompng($file);
		imagealphablending($im, true);
		imagesavealpha($im, true);
		$img = imagepng($im);
		echo $img;
	}
	else
	{
		header("Content-Type: image/jpg");
		$im = imagecreatefromjpeg($file);
		$img = imagejpeg($im);
		echo $img;
	}
?>