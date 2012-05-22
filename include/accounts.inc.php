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
			// Get the UTF8 strings of the values, just for be sure
			$username = utf8_encode($username);
			$password = utf8_encode($password);
			
			// Delete white spaces at the begining and the end of the username
			$salt = trim($username);
			
			// Get the lowercase username
			$salt = strtolower($salt);
			
			$init = $password . $salt;
			
			for($i = 0; $i < 999; $i++)
			{
				$init = sha1($init);
			}
			
			// We need to do that way in order to return the binary hash and not the str which is double sized
			return sha1($init, true);
		}
		
		public static function Register($username, $password, $role)
		{
			// Check if an account with this name already exists
			$query = "SELECT accountID FROM account WHERE accountName='" . $username . "'";
			if(Database::Query($query, true))
			{
				return false;
			}
			
			$password = AccountManagement::HashPassword($username, $password);
			$query = "INSERT INTO account (accountID, accountName, role, hash, online, banned) VALUES(NULL, '$username', $role, '$password', 0, 0);";
			
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