<?php
	class PortalStyle
	{		
		public static function GetImageFromStyle($image)
		{
			$style = Portal::CurrentPortalStyle();
			
			return "style/$style/images/$image";
		}
		
		public static function GetStyleConfig()
		{
			$style = Portal::CurrentPortalStyle();
			
			return "style/$style/style.php";
		}
	}
?>