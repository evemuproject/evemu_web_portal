<?php
	class LocalCache
	{
		public static function LoadCharacterImage($characterID)
		{
			global $GAME_Server;
			global $GAME_ImagePort;
			
			// Check if we have the cached file and check for the date
			// Images should be cached for 3 days maximum
			$remoteFile = "http://$GAME_Server:$GAME_ImagePort/Characters/" . $characterID . "_512.jpg";
			$localFile = "images/cache/Characters/$characterID.png";
			$time = 86400 * 3;
			
			if(LocalCache::LoadCachedImage($remoteFile, $localFile, $time) == true)
			{
				return "images/cache/?characterID=$characterID";
			}

			return 'images/cache/error.png';
		}
		
		public static function LoadItemImage($typeID)
		{
			global $GAME_Server;
			global $GAME_ImagePort;
			
			// This is cached forever(as long as it does not fails)
			$remoteFile = "http://$GAME_Server:$GAME_ImagePort/InventoryType/" . $typeID . "_64.png";
			$localFile = "images/cache/InventoryType/$typeID.png";
			$time = time(); // Get some big time
			
			if(LocalCache::LoadCachedImage($remoteFile, $localFile, $time) == true)
			{
				return "images/cache/?typeID=$typeID";
			}
			
			// We were not able to get the file from Game server, try with image.eveonline.com
			$remoteFile = "http://image.eveonline.com/Type/" . $typeID . "_64.png";
			
			if(LocalCache::LoadCachedImage($remoteFile, $localFile, $time) == true)
			{
				return "images/cache/?typeID=$typeID";
			}
			
			return "images/cache/error.png";
		}
		
		public static function LoadShipImage($shipID)
		{
			global $GAME_Server;
			global $GAME_ImagePort;
			
			// This is cached forever like ItemTypes
			$remoteFile = "http://$GAME_Server:$GAME_ImagePort/Render/" . $shipID . "_512.png";
			$localFile = "images/cache/Ship/$shipID.png";
			$time = time();
			
			if(LocalCache::LoadCachedImage($remoteFile, $localFile, $time) == true)
			{
				return "images/cache/?shipID=$shipID";
			}
			
			//We were not able to get the file from Game server
			$remoteFile = "http://image.eveonline.com/Render/" . $shipID . "_512.png";
			
			if(LocalCache::LoadCachedImage($remoteFile, $localFile, $time) == true)
			{
				return "images/cache/?shipID=$shipID";
			}
			
			return "images/cache/error.png";
		}
		
		public static function LoadCachedImage($url, $image, $time)
		{
			// Check if we have the cached file and check the date
			if(file_exists($image))
			{
				if(fileatime($image) + $time < time())
				{
					unlink($image);
				}
				else
				{
					return true;
				}
			}
			
			// Load image from the remote server
			$input = @fopen($url, 'r');
			$output = @fopen($image, 'w');
			
			if( ($input == false) || ($output == false) )
			{
				if($output)
				{
					fclose($output);
					unlink($image);
				}
				
				if($input)
				{
					fclose($input);
				}
				
				return false;
			}
			
			while(feof($input) == false)
			{
				$data = fread($input, 512);
				if( ($data == false) || (fwrite($output, $data, 512) == false) )
				{
					fclose($input);
					fclose($output);
					unlink($image);
				}
			}
			
			fclose($input);
			fclose($output);
			
			return true;
		}
	}
?>