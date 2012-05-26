<?php
	class Configuration
	{
		public static function GetValue($name)
		{
			// Get the value
			$query = "SELECT configValue FROM portalconfig WHERE configName='$name '";
			$result = Database::Query($query, true);
			
			return @$result[0]['configValue'];
		}
		
		public static function SetValue($name, $value)
		{
			// Delete the old config value(if any)
			$query = "DELETE FROM portalconfig WHERE configName='$name'";
			Database::Query($query, false);
			
			// Insert the new value
			$query = "INSERT INTO portalconfig(configName, configValue)VALUES('$name', '$value');";
			Database::Query($query, false);
		}
	}
?>