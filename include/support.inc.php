<?php
	class Support
	{
		static public function GetLastTickets()
		{
			$query = "SELECT messageID, accountID, title, message, timestamp FROM portalSupportMessages WHERE parentID=0 ORDER BY timestamp LIMIT 0,10";
			return Database::Query($query, true);
		}
		
		static public function TicketsCount()
		{
			$query = "SELECT COUNT(messageID) AS ticketsCount FROM portalSupportMessages WHERE parentID=0";
			return Database::Query($query, true)[0]['ticketsCount'];
		}
		
		static public function GetTicket($messageID)
		{
			$query = "SELECT messageID, accountID, title, message, timestamp FROM portalSupportMessages WHERE messageID=$messageID";
			return @(Database::Query($query, true)[0]);
		}
		
		static public function GetTicketAnswers($messageID)
		{
			$query = "SELECT messageID, accountID, title, message, timestamp FROM portalSupportMessages WHERE parentID=$messageID ORDER BY timestamp";
			return Database::Query($query, true);
		}
		
		static public function GetMessage($messageID)
		{
			$query = "SELECT messageID, accountID, title, message, timestamp, parentID FROM portalSupportMessages WHERE messageID=$messageID";
			return @(Database::Query($query, true)[0]);
		}
		
		static public function DeleteTicket($messageID)
		{
			$data = GetMessage($messageID);
			
			if($data == null)
			{
				return false;
			}
			
			if($data['parentID'] == 0)
			{
				// Main ticket, delete the answers too
				$query = "DELETE FROM portalSupportMessages WHERE parentID=$messageID OR messageID=$messageID";
				Database::Query($query, false);
				
				return true;
			}
			else
			{
				// Just an answer, delete it
				$query = "DELETE FROM portalSupportMessages WHERE messageID=$messageID";
				Database::Query($query, false);
				
				return true;
			}
		}
		
		static public function Exists($messageID)
		{
			$query = "SELECT messageID FROM portalSupportMessages WHERE messageID=$messageID";
			return @(Database::Query($query, true)[0]);
		}
		
		static public function GetMessageCreator($messageID)
		{
			$query = "SELECT accountID FROM portalSupportMessages WHERE messageID=$messageID";
			return @(Database::Query($query, true)[0]['accountID']);
		}
	}
?>