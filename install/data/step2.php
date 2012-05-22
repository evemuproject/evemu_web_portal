<table id="installer-main">
	<tr>
		<td style="width: 185.717px; vertical-align: top;">
			<ul>
				<li>Game server information</li>
			</ul>
		</td>
		<td>
			<p><h3>EVE Server information</h3></p>
			<p>
<?php
	// Check for POST vars
	$error = false;
	
	if( @(empty($_POST['server']) == true) )
	{
		$error = true;
	}
	
	if( @(empty($_POST['user']) == true) )
	{
		$error = true;
	}
	
	if( @(empty($_POST['pass']) == true) )
	{
		$error = true;
	}
	
	if( @(empty($_POST['database']) == true) )
	{
		$error = true;
	}
	
	if($error)
	{
	?>
		<h4>Error</h4>
		<div id="error">Database information is wrong, or is not sent to the server. Please go back and try again later</div>
		<form method="POST" action="?step=1">
			<input type="submit" value="Go back">
		</form>
	<?php
	}
	else
	{
		// Update the global variables
		$DB_Server = $_POST['server'];
		$DB_User = $_POST['user'];
		$DB_Password = $_POST['pass'];
		$DB_Database = $_POST['database'];
		
		// Connect to the database
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
		else if( @($_GET['action'] == 'register') )
		{
			// Register should be handled here...
			$result = AccountManagement::Register($_POST['gameUsername'], $_POST['gamePassword'], 5003499186008621056);
			
			if($result == false)
			{
				?>
					<h4>Error</h4>
					<div id="error">Cannot create account <?php echo $_POST['gameUsername']; ?>. The user already exists</div>
					<form method="POST" action="?step=3">
						<input type="hidden" name="server" value="<?php echo $DB_Server; ?>">
						<input type="hidden" name="user" value="<?php echo $DB_User; ?>">
						<input type="hidden" name="pass" value="<?php echo $DB_Password; ?>">
						<input type="hidden" name="database" value="<?php echo $DB_Database; ?>">
						<input type="submit" value="Retry">
					</form>
				<?php
			}
			else
			{
				$accountID = mysql_insert_id();
				?>
					<h4>Account created</h4>
					<div id="sucess">Account <?php echo $_POST['gameUsername']; ?> created sucessful</div>
					<form method="POST" action="?step=3">
						<input type="hidden" name="server" value="<?php echo $DB_Server; ?>">
						<input type="hidden" name="user" value="<?php echo $DB_User; ?>">
						<input type="hidden" name="pass" value="<?php echo $DB_Password; ?>">
						<input type="hidden" name="database" value="<?php echo $DB_Database; ?>">
						<input type="hidden" name="account" value="<?php echo $accountID; ?>">
						<input type="submit" value="Next Step">
					</form>
				<?php
			}
		}
		else
		{
			$accounts = AccountManagement::GetGameAccounts();
			
			if($accounts == false)
			{
				// Display register form
				require_once "register.php";
			}
			else
			{
				// Display userlist in a form
				require_once "selectuser.php";
			}
		}
?>
		</p>
		</td>
	</tr>
</table>
<?php
	}
?>