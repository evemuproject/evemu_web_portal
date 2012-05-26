<?php
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
		   <li><a href='#'><span>Portal Websites</span></a>
			  <ul>
				 <li><a href='#'><span>Account Management</span></a></li>
				 <li><a href='#'><span>Forums</span></a></li>
				 <li><a href='#'><span>Support</span></a></li>
			  </ul>
		   </li>
		   <li><a href='#'><span>Language</span></a>
			  <ul>
				 <li><a href='#'><span>Spanish</span></a></li>
				 <li><a href='#'><span>English</span></a></li>
			  </ul>
		   </li>
		</ul>
		</div>
		<div style="margin: 30% 30% 0% 30%; text-align: center;">
			EVEmu Portal is under construction
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