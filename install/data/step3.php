<?php
	// Set default data
	$DB_Server = "";
	$DB_User = "";
	$DB_Password = "";
	$DB_Database = "";
	$accountID = 0;
	
	// Get the data from the form
	if( @(empty($_POST['server']) == false) )
	{
		$DB_Server = $_POST['server'];
	}
	
	if( @(empty($_POST['user']) == false) )
	{
		$DB_User = $_POST['user'];
	}
	
	if( @(empty($_POST['pass']) == false) )
	{
		$DB_Password = $_POST['pass'];
	}
	
	if( @(empty($_POST['database']) == false) )
	{
		$DB_Database = $_POST['database'];
	}
	
	if( @(empty($_POST['account']) == false) )
	{
		$accountID = $_POST['account'];
	}
?>
<table id="installer-main">
	<tr>
		<td style="width: 185.717px; vertical-align: top;">
			<ul>
				<li>Game server information</li>
			</ul>
		</td>
		<td>
			<p><h3>Game servers information </h3></p>
			<p>
				<?php				
					if(Database::Connect() == false)
					{
						?>
							<h4>MySql error</h4>
							<div id="error">Cannot connect to the database. MySql error: <?php echo mysql_error(); ?></div>
							<form method="POST" action="?step=1">
								<input type="submit" value="Go back">
							</form>
						<?php
					}
					// Account id should NEVER be 0
					else if( ($accountID == 0) || (AccountManagement::Exists($accountID) == false) )
					{
					?>
						<h4>Error</h4>
						<div id="error">You have not selected an account or the account data is wrong</div>
						<form method="POST" action="?step=2">
							<input type="hidden" name="server" value="<?php echo $DB_Server; ?>">
							<input type="hidden" name="user" value="<?php echo $DB_User; ?>">
							<input type="hidden" name="pass" value="<?php echo $DB_Password; ?>">
							<input type="hidden" name="database" value="<?php echo $DB_Database; ?>">
							<input type="submit" value="Go back">
						</form>
					<?php
					}
					else
					{
					?>
						<table border=0>
							<form method="POST" action="?step=4">
								<input type="hidden" name="server" value="<?php echo $DB_Server; ?>">
								<input type="hidden" name="user" value="<?php echo $DB_User; ?>">
								<input type="hidden" name="pass" value="<?php echo $DB_Password; ?>">
								<input type="hidden" name="database" value="<?php echo $DB_Database; ?>">
								<input type="hidden" name="account" value="<?php echo $accountID; ?>">
								<tr><td>Server host:</td><td><input type="text" name="gamehost" value=""></td></tr>
								<tr><td colspan=2><div id="entry-description">The EVEmu server address(empty for localhost)</div></td></tr>
								<tr><td>Server port:</td><td><input type="text" name="gameport" value=""></td></tr>
								<tr><td colspan=2><div id="entry-description">The port in which the EVEmu server is listening on(empty for 26000)</div></td></tr>
								<tr><td>API Server Port:</td><td><input type="text" name="apiport" value=""></td></tr>
								<tr><td colspan=2><div id="entry-description">The port in which the API server is listening on(empty for 50001)</div></td></tr>
								<tr><td>Image Server Port:</td><td><input type="text" name="imageport" value=""></td></tr>
								<tr><td colspan=2><div id="entry-description">The port in which the Image Server is listening on(empty for 26001)</div></td></tr>
								<tr><td colspan=2><input type="submit" value="Next step"></td></tr>
							</form>
						</table>
					<?php
					}
				?>
			</p>
		</td>
	</tr>
</table>