<?php
	class Cache
	{
		public static function InsertCache($name, $value, $time = 0)
		{
			if($time == 0) $time = time();
			
			// Delete the current value(if any)
			$query = "DELETE FROM portalcache WHERE cacheName='$name'";
			Database::Query($query, false);
			
			$query = "INSERT INTO portalcache(cacheName, cacheValue, cacheTime)VALUES('$name', '$value', $time)";
			Database::Query($query, false);
		}
		
		public static function GetCacheInfo($name)
		{
			$query = "SELECT cacheValue, cacheTime FROM portalcache WHERE cacheName='$name'";
			$result = Database::Query($query, true);
			
			return @$result[0];
		}
		
		public static function GetCacheValue($name)
		{
			$query = "SELECT cacheValue FROM portalcache WHERE cacheName='$name'";
			$result = Database::Query($query, true);
			
			return @$result[0]['cacheValue'];
		}
		
		public static function GetCacheTime($name)
		{
			$query = "SELECT cacheTime FROM portalcache WHERE cacheName='$name'";
			$result = Database::Query($query, true);
			
			return @$result[0]['cacheTime'];
		}
	}
?>