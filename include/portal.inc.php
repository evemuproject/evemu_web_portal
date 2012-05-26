<?php
	class Portal
	{
		public static function CurrentPortalStyle()
		{
			$style = Configuration::GetValue("portalStyle");
			
			if(empty($style) == true)
			{
				// Default folder should always be present in styles
				return 'default';
			}
			
			// Check for the most important file in the style folder
			if(file_exists("style/$style/style.css") == false)
			{
				// Critic file does not exists, use default style
				return 'default';
			}
			
			// Everything OK, we can use our custom style
			return $style;
		}
		
		public static function SetCurrentPortalStyle($name)
		{
			// Check for the most important file in the style folder
			if(file_exists("style/$name/style.css") == false)
			{
				return false;
			}
			
			// Update the configuration value
			Configuration::SetValue("portalStyle", $name);
			
			return true;
		}
		
		public static function GetPortalMetaKeywords()
		{
			$meta = Configuration::GetValue("portalMetaKeywords");
			
			return $meta;
		}
		
		public static function GetPortalMetaDescription()
		{
			$meta = Configuration::GetValue("portalMetaDescription");
			
			return $meta;
		}
		
		public static function GetPortalMetaAuthors()
		{
			$meta = Configuration::GetValue("portalMetaAuthors");
			
			return $meta;
		}
	}
?>