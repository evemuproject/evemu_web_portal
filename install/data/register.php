<table border=0>
	<form method="POST" action="?step=2&action=register">
		<input type="hidden" name="server" value="<?php echo $DB_Server; ?>">
		<input type="hidden" name="user" value="<?php echo $DB_User; ?>">
		<input type="hidden" name="pass" value="<?php echo $DB_Password; ?>">
		<input type="hidden" name="database" value="<?php echo $DB_Database; ?>">
		
		<tr><td>Username: </td><td><input type="text" name="gameUsername" value=""></td></tr>
		<tr><td colspan=2><div id="entry-description">Your desired ingame account name</div></td></tr>
		<tr><td>Password: </td><td><input type="password" name="gamePassword" value=""></td></tr>
		<tr><td colspan=2><div id="entry-description">Your desired ingame account password</div></td></tr>
		<tr><td colspan=2><input type="submit" value="Next step"></td></tr>
	</form>
</table>