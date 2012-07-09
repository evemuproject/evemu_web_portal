<table id="installer-main">
	<tr>
		<td style="width: 185.717px; vertical-align: top;">
			<ul>
				<li>SQL Import</li>
			</ul>
		</td>
		<td>
			<p><h3>Final step</h3></p>
			<p>
<?php
	// Set default data
	$DB_Server = "localhost";
	$DB_User = "root";
	$DB_Password = "root";
	$DB_Database = "evemu";
	$accountID = 0;
	$GAME_Server = "localhost";
	$GAME_Port = 26000;
	$GAME_APIPort = 50001;
	$GAME_ImagePort = 26001;
	
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
	
	if( @(empty($_POST['gamehost']) == false) )
	{
		$GAME_Server = $_POST['gamehost'];
	}
	
	if( @(empty($_POST['gameport']) == false) )
	{
		$GAME_Port = $_POST['gameport'];
	}
	
	if( @(empty($_POST['apiport']) == false) )
	{
		$GAME_APIPort = $_POST['apiport'];
	}
	
	if( @(empty($_POST['imageport']) == false) )
	{
		$GAME_ImagePort = $_POST['imageport'];
	}
	
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
		// Try to connect to all the servers
		// Check if the field is already added
		$query = "SELECT portalRole FROM account WHERE accountID=" . $accountID;
		$result = Database::Query($query, true);

		if( @($result[0]['portalRole'] == null) )
		{
			$query = "ALTER TABLE `account` ADD `portalRole` INT( 10 ) NOT NULL DEFAULT '1'";
		
			Database::Query($query, false);
		}
		
		// Update the user portalRole
		$query = "UPDATE account SET portalRole= portalRole | 32 WHERE accountID=" . $accountID;
		Database::Query($query, false);
		
		// Create the portalcache table
		$query = "DROP TABLE IF EXISTS portalcache";
		Database::Query($query, false);
		
		$query = "CREATE TABLE `evemu-crucible`.`portalcache` (
					`cacheName` VARCHAR( 255 ) NOT NULL ,
					`cacheValue` TEXT NOT NULL ,
					`cacheTime` BIGINT NOT NULL ,
					PRIMARY KEY ( `cacheName` )
				  ) ENGINE = InnoDB;";
		
		Database::Query($query, false);
		
		$query = "DROP TABLE IF EXISTS portalconfig";
		Database::Query($query, false);
		
		$query = "CREATE TABLE `evemu-crucible`.`portalconfig` (
					`configName` VARCHAR( 255 ) NOT NULL ,
					`configValue` VARCHAR( 255 ) NOT NULL ,
					PRIMARY KEY ( `configName` )
				  ) ENGINE = InnoDB;";
		Database::Query($query, false);
		
		$query = "DROP TABLE IF EXISTS portalSupportMessages";
		Database::Query($query, false);
		
		$query = "CREATE TABLE `evemu-crucible`.`portalSupportMessages` (
					`messageID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`accountID` INT NOT NULL DEFAULT '0',
					`title` VARCHAR( 255 ) NOT NULL DEFAULT '',
					`message` TEXT NOT NULL DEFAULT '',
					`parentID` INT NOT NULL DEFAULT '0',
					`timestamp` BIGINT NOT NULL ,
					INDEX ( `accountID` , `parentID` , `timestamp` )
					) ENGINE = InnoDB;";
		
		Database::Query($query, false);
		?>
		<h4>Sucess</h4>
		<div id="sucess">Database information added</div><br>
		<?php
		
		// Create the config.php file
		$cfg = new ConfigGenerator();
		
		$cfg->Init();
		$cfg->AddVariable("DB_Server", $DB_Server);
		$cfg->AddVariable("DB_User", $DB_User);
		$cfg->AddVariable("DB_Password", $DB_Password);
		$cfg->AddVariable("DB_Database", $DB_Database);
		$cfg->AddVariable("GAME_Server", $GAME_Server);
		$cfg->AddVariable("GAME_Port", $GAME_Port);
		$cfg->AddVariable("GAME_APIPort", $GAME_APIPort);
		$cfg->AddVariable("GAME_ImagePort", $GAME_ImagePort);
		$cfg->Stop();
		
		$cfg->SaveFile("../config.php");
		if(CheckGameServerStatus($GAME_Server, $GAME_Port) == false)
		{
			?>
				<div id="warn">Could not connect to the game server</div><br>
			<?php
		}
		
		if(CheckGameServerStatus($GAME_Server, $GAME_APIPort) == false)
		{
			?>
				<div id="warn">Could not connect to the API server</div><br>
			<?php
		}
		
		if(CheckGameServerStatus($GAME_Server, $GAME_ImagePort) == false)
		{
			?>
				<div id="warn">Could not connect to the Image server</div><br>
			<?php
		}
		?>
		<div id="sucess">EVEmu portal installed</div><br>
		<form method="POST" action="../index.php">
			<input type="submit" value="Go to EVEmu portal">
		</form>
		<?php
	}
?>
		</p>
		</td>
	</tr>
</table>