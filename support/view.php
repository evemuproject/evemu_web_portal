<?php
	$id = $_GET['ticket'];
	
	$entry = Support::GetTicket($id);
	
	?>
		<div id="supportEntry">
			<div style="float: right;">Created: <strong><?php echo date("F j, Y, g:i a", $entry['timestamp']); ?></strong></div>
			<div style="float: left;">Title: <strong><?php echo $entry['title']; ?></strong></div>
			<br><hr>
			<strong>Message:</strong><br><?php echo substr($entry['message'], 0, 128); ?>...<br>
		</div>
	<?php
	
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
			<div style="float: right;">Replyed: <strong><?php echo date("F j, Y, g:i a", $answers[$i]['timestamp']); ?></strong></div>
			<br><hr>
			<strong>Message:</strong><br><?php echo substr($answers[$i]['message'], 0, 128); ?>...<br>
		</div>
	<?php
	}
?>