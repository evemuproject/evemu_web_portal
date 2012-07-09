<?php
	$userID = 0;
	$ticketID = @(userInput($_GET['ticket']));

	if(is_numeric($ticketID) == false)
	{
	?>
		<center><h1>Unexpected error</h1></center>
		<center>Click <a href="?p=support">here</a> to go back</center>
	<?php
		return;
	}
	
	if(AccountManagement::IsAdmin($userID) == false)
	{
		?>
			<center><h1>You do not have enough permissions to access this page</h1></center>
			<center>Click <a href="?p=support&m=view&ticket=<?php echo $ticketID; ?>">here</a> to go back</center>
		<?php
		return;
	}
	
	if(Support::Exists($ticketID) == null)
	{
		?>
		<center><h1>The ticket you are looking for doesn't exists</h1></center>
		<center>Click <a href="?p=support">here</a> to go back
		<?php
		
		return;
	}
	
	if(Support::DeleteTicket($ticketID) == false)
	{
	?>
		<center><h1>Unexpected error</h1></center><br>
		<center><h2>Cannot delete ticket. Error: <?php echo Database::GetLastError(); ?></h2></center><br>
		<center>Click <a href="?p=support">here</a> to go back</center>
	<?php
		return;
	}
	
	?>
		<center><h1>Ticket/reply deleted succesful</h1></center>
		<center>Click <a href="?p=support">here</a> to go back</center>