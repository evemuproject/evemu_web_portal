<h4>Select a user to make admin</h4>
<div id="entry-description">The user you select will be marked as the administrator of the server and the EVEmu Portal</div>
<center>
	<form method="POST" action="?step=3">
	<input type="hidden" name="server" value="<?php echo $DB_Server; ?>">
	<input type="hidden" name="user" value="<?php echo $DB_User; ?>">
	<input type="hidden" name="pass" value="<?php echo $DB_Password; ?>">
	<input type="hidden" name="database" value="<?php echo $DB_Database; ?>">
							
	<p><table id="userlist">
		<tr><td style="width: 100px;"><strong>User ID</strong></td><td><strong>Username</strong></td><td style="width: 25px;"></td></tr>
		<?php
			foreach($accounts as $user)
			{
				?>
					<tr><td><?php echo $user['accountID']; ?></td><td><?php echo $user['accountName']; ?></td><td><input type="radio" name="account" value="<?php echo $user['accountID']; ?>"></td></tr>
				<?php
			}
		?>
	</table></p>
	<input type="submit" value="Next step">
</center>