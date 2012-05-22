<?php

	/*
		Database Class. Written By Almamu
	*/

	class Database
	{
		static public $connection;
		static public function Connect()
		{
			global $DB_Server;
			global $DB_User;
			global $DB_Password;
			global $DB_Database;
			
			Database::$connection = @mysql_connect($DB_Server, $DB_User, $DB_Password);
			
			if( !Database::$connection )
			{
				return false;
			}
			
			return @mysql_select_db($DB_Database, Database::$connection);
		}
		
		static public function Query($query, $fullFetch)
		{
			$res = @mysql_query($query, Database::$connection);
			
			if( is_bool($res) )
			{
				return $res;
			}
			
			if($fullFetch)
			{
				return mysql_fetch_full_result_array($res);
			}
			
			return $res;
		}
		
		static public function Close()
		{
			@mysql_close(Database::$connection);
		}
	}
?>