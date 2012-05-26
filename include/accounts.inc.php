<?php
	class AccountManagement
	{
		public static function GetGameAccounts()
		{
			$query = "SELECT accountID, accountName FROM account";
			
			return Database::Query($query, true);
		}
		
		public static function HashPassword($username, $password)
		{
			// Delete white spaces at the begining and the end of the username
			$salt = trim($username, " \t\r");
			
			// Get the lowercase username
			$salt = strtolower($salt);
			
			$init = $password . $salt;
						
			for($i = 0; $i < 1000; $i++)
			{
				$init = sha1($init, true);
			}
			
			// This should be the binary hash(20 bytes)and not the string hash(40 bytes)
			return $init;
		}
		
		public static function Register($username, $password, $role)
		{
			// Check if an account with this name already exists
			$query = "SELECT accountID FROM account WHERE accountName='" . $username . "'";
			if( @(Database::Query($query, true)[0]['accountID']) != null)
			{
				return false;
			}
			
			$password = AccountManagement::HashPassword($username, $password);
			$query = "INSERT INTO account (accountID, accountName, role, hash, online, banned) VALUES(NULL, '$username', $role, '" . mysql_real_escape_string($password) . "', 0, 0);";
			
			Database::Query($query, false);
			
			return true;
		}
		
		public static function Exists($accountID)
		{
			$query = "SELECT accountName FROM account WHERE accountID=" . $accountID;
			
			$result = Database::Query($query, true);
			
			if( @($result[0] == null) )
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	}
?>