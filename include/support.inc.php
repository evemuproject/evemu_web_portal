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
			return Database::Query($query, true)[0];
		}
		
		static public function GetTicketAnswers($messageID)
		{
			$query = "SELECT messageID, accountID, title, message, timestamp FROM portalSupportMessages WHERE parentID=$messageID ORDER BY timestamp";
			return Database::Query($query, true);
		}
	}
?>