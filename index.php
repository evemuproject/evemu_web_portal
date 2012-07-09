<?php
	if(isset($loaded) == true)
	{
		echo "We are loading ourselves a lot of times...";
		return;
	}
	
	// Check for config file
	if(file_exists("config.php") == false)
	{
		// Redirect the user
		Header("Location: install/index.php");
	}
	
	$result = include("config.php");
	
	if($result == false)
	{
		// Wrong config file was generated, go to install script
		Header("Location: install/index.php");
	}
	
	// Include some system headers
	require_once "config.php";
	require_once "include/database.inc.php";
	require_once "include/cache.inc.php";
	require_once "include/localcache.inc.php";
	require_once "include/configuration.inc.php";
	require_once "include/portal.inc.php";
	require_once "include/styles.inc.php";
	require_once "include/functions.inc.php";
	require_once "include/forum.inc.php";
	require_once "include/accounts.inc.php";
	require_once "include/gameserver.inc.php";
	
	if(Database::Connect() == false)
	{
		echo Database::GetLastError();
	}
	
	$loaded = true;
	
	$page = "content/main.php";
	if( @(empty($_GET['p']) == false) )
	{
		$page = "content/" . userInput($_GET['p']) . ".php";
	}
	
	if(file_exists($page) == falsE)
	{
		$page = "404.php";
	}
?>

<!DOCTYPE html>
	<html>
	<head>
		<title>EVEmu Portal - Under construction</title>		
		<style>
			<!--
				<?php
					include PortalStyle::GetStyleConfig();
				?>
			-->
		</style>
		<!-- Meta tags here -->
		<meta name="Keywords" content="<?php echo Portal::GetPortalMetaKeywords(); ?>">
		<meta name="Description" content="<?php echo Portal::GetPortalMetaDescription(); ?>">
		<meta name="Author" content="<?php echo Portal::GetPortalMetaAuthors(); ?>">
	</head>
	<body>
		<div class='cssmenu'>
		<ul>
		   <li><a href='?p='><span>Home</span></a></li>
		   <li><a href='#'><span>Portal Websites</span></a>
			  <ul>
				 <li><a href='?p=account'><span>Account Management</span></a></li>
				 <li><a href='?p=forum'><span>Forums</span></a></li>
				 <li><a href='?p=support'><span>Support</span></a></li>
			  </ul>
		   </li>
		   <li><a href='?p=admin'><span>Administration interface</span></a></li>
		   <!--<li><a href='#'><span>Language</span></a>
			  <ul>
				 <li><a href='?lang=es'><span>Spanish</span></a></li>
				 <li><a href='?lang=en'><span>English</span></a></li>
			  </ul>
		   </li>-->
		   
		   <?php
			// TODO: Add a check to show the user name or the login form
		   ?>
			<li style="float: right;"><a href="#"><form method="POST" action="#">
				Username: <input type="text" name="username" value=""> 
				Password: <input type="password" name="password" value=""> 
				<input type="submit" value="Login">
			</form></a></li>
		</ul>
		</div>
		
		<?php
			if( @(($_GET['p'] != 'forum') && ($_GET['p'] != 'account') && ($_GET['p'] != 'support') && ($_GET['p'] != 'admin')) )
			{
			?>
		<a href="?p=download"><div id="tryeve"><h4>DOWNLOAD EVEMU CRUCIBLE NOW<br><center>Client build supported: 360229</center></h4></div></a>
		
		<a href="?p=crucible"><div id="gamebanner"></div></a>
		<?php
			}
		?>
		<div id="content">
		<?php
			include $page;
		?>
		</div>
		
		<div id="footer">
			<?php
				include "footer.php";
			?>
		</div>
	</body>
</html>

<?php
	Database::Close();
?>