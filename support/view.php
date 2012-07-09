<?php
	$id = $_GET['ticket'];
	
	if(Support::Exists($id) == null)
	{
		?>
		<center><h1>The ticket you are looking for doesn't exists</h1></center>
		<center>Click <a href="?p=support">here</a> to go back
		<?php
		
		return;
	}
	
	$entry = Support::GetTicket($id);
	
	?>
		<div id="supportEntry">
			<div style="float: right;">Created: <strong><?php echo date("F j, Y, g:i a", $entry['timestamp']); ?></strong> by <strong><?php echo AccountManagement::GetUserName($entry['accountID']); ?></strong></div>
			<div style="float: left;">Title: <strong><?php echo $entry['title']; ?></strong></div>
			<br><hr>
			<strong>Message:</strong><br><pre><?php echo $entry['message']; ?></pre><br>
			<hr>
		</div>
	<?php
	
	// Print the options
	/*if(AccountManagement::IsAdmin(0) == true)
	{*/
	?>
		<div id="supportButtons" style="float: right;">
			<a href="?p=support&m=reply&ticket=<?php echo $id; ?>">Reply ticket</a> |
			<a href="?p=support&m=edit&ticket=<?php echo $id; ?>">Edit ticket</a> |
			<a href="?p=support&m=delete&ticket=<?php echo $id; ?>">Delete ticket</a>
		</div>
		<br><br>
	<?php
	//}
	
	$answers = Support::GetTicketAnswers($id);
	
	if(count($answers) == 0)
	{
		?>
			<h2>No answers yet</h2>
		<?php
		return;
	}
	
	$max = count($answers);
	
	// Print each answer
	for($i = 0; $i < $max; $i ++)
	{
		?>
		<div id="supportEntry">
			<div style="float: left">Reply <strong>#<?php echo $i + 1; ?></strong></div>
			<div style="float: right;">Replied: <strong><?php echo date("F j, Y, g:i a", $answers[$i]['timestamp']); ?></strong> by <strong><?php echo AccountManagement::GetUserName($answers[$i]['accountID']); ?></strong></div>
			<br><hr>
			<strong>Message:</strong><br><pre><?php echo $answers[$i]['message']; ?></pre><br>
			<hr>
		</div>
		<?php
	
		// Print the buttons
		?>
		<div id="supportButtons" style="float: right;">
			<a href="?p=support&m=edit&ticket=<?php echo $answers[$i]['messageID']; ?>">Edit reply</a> |
			<a href="?p=support&m=delete&ticket=<?php echo $answers[$i]['messageID']; ?>">Delete reply</a>
		</div>
		<br><br>
		<?php
	}
?>