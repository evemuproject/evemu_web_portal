<?php
	class PortalStyle
	{		
		public static function GetImageFromStyle($image)
		{
			$style = PortalStyle::CurrentPortalStyle();
			
			return "images/style/$style/$image";
		}
	}
?>