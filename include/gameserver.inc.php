<?php
	class GameServer
	{
		// Server status will be cached for 60 seconds in the database
		public static function CheckCachedServerStatus()
		{
			$cache = Cache::GetCacheInfo("gameServerStatus");
			
			if( ($cache['cacheTime'] + 60) > time() )
			{
				return $cache['cacheValue'];
			}
			
			// Check the server status
			$status = CheckGameServerStatus($GAME_Server, $GAME_Port);
			Cache::InsertCache("gameServerStatus", $status);
			
			return $status;
		}
		
		// Image server status will not be cached
		public static function CheckImageServerStatus()
		{
			return CheckGameServerStatus($GAME_Server, $GAME_ImagePort);
		}
		
		// API server status will not be cached
		public static function CheckAPIServerStatus()
		{
			return CheckGameServerStatus($GAME_Server, $GAME_APIPort);
		}
	}
?>