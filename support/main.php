<?php
	$full = Support::TicketsCount();
	
	if($full == 0)
	{
	?>
	<center>
		<h1>There are not support tickets openned yet</h1><br>
		Click <a href="?p=support&m=create">here</a> to open a new ticket<br>
	</center>
	<?php
		return;
	}
	
	// Get the last entryes
	$data = Support::GetLastTickets();
	
	if(count($data) == 0)
	{
	?>
	<center>
		<h1>Error fetching opened tickets</h1><br>
		Click <a href="?p=support">here</a> to retry<br>
	</center>
	<?php
		return;
	}
	
	$max = count($data);
	
	for($i = 0; $i < $max; $i ++)
	{
		// Print each entry
		?>
		<div id="supportEntry">
			<div style="float: right;">Created: <strong><?php echo date("F j, Y, g:i a", $data[$i]['timestamp']); ?></strong></div>
			<div style="float: left;">Title: <strong><a href="?p=support&m=view&ticket=<?php echo $data[$i]['messageID']; ?>"><?php echo $data[$i]['title']; ?></a></strong></div>
			<br><hr>
			<strong>Message:</strong><br><?php echo substr($data[$i]['message'], 0, 128); ?>...<br>
		</div>
		<?php
	}
	
	?>
		<div id="supportButtons" style="float: right;">
			<a href="?p=support&m=create">Create ticket</a>
		</div>
	<?php
?>