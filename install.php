<?
/*
        ------------------------------------------------------------------------------------
        LICENSE:
        ------------------------------------------------------------------------------------
        This file is part of EVEmu portal
        Copyright 2006 - 2011 The EVEmu portal Team
        For the latest information visit http://forum.evemu.org/viewtopic.php?f=7&t=68
        ------------------------------------------------------------------------------------
        This program is free software; you can redistribute it and/or modify it under
        the terms of the GNU Lesser General Public License as published by the Free Software
        Foundation; either version 2 of the License, or (at your option) any later
        version.

        This program is distributed in the hope that it will be useful, but WITHOUT
        ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
        FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.

        You should have received a copy of the GNU Lesser General Public License along with
        this program; if not, write to the Free Software Foundation, Inc., 59 Temple
        Place - Suite 330, Boston, MA 02111-1307, USA, or go to
        http://www.gnu.org/copyleft/lesser.txt.
        ------------------------------------------------------------------------------------
        Author:         Almamu
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso.8859-1" />
	<link rel="stylesheet" type="text/css" name="style" href="install.css">
	<title>EveMu portal installation</title>
</head>
<body>
<div id="header"><h1>EveMu Install script</h1></div>
<div id="content">
	<div class="content-container"><fieldset>
		<h2>Step 1: Account creation</h2>
		<h3><center>
<?
	include( 'config.php' );
	include( 'func.inc.php' );
	
	$connections = initDB();
	if( !$connections )die();
	
	$query = "SELECT accountName FROM account WHERE role=".$adminRole.";";
	$result = mysql_query( $query, $connections[ 'game' ] );
	
	if( $result )
	{
		die( 'The portal is already installed' );
	}
	
	if( !( ( empty( $_POST[ 'user' ] ) ) && ( empty( $_POST[ 'pass' ] ) ) && ( empty( $_POST[ 'mail' ] ) ) ) )
	{
		$err = 0;
		if( empty( $_POST[ 'user' ] ) )
		{
			$err = 1;
			echo '<red>Invalid username<br></red>';
		}
		if( empty( $_POST['pass'] ) )
		{
			$err = 1;
			echo '<red>Invalid password<br></red>';
		}
		
		if( $err == 0 )
		{
			// Ok, no errors, update the DB with the admin info
			$query = "INSERT INTO account (accountID, accountName, role, password, online, banned) VALUES(NULL, '".$_POST[ 'user' ]."', ".$adminRole.", PASSWORD('".$_POST[ 'pass' ]."'), 0, 0);";
			// $query = "INSERT INTO userinfo (id, username, password, role, email, banned, lastip) VALUES(0, '".$_POST['user']."', '".sha1($_POST['pass'])."', 2000, '".$_POST['mail']."', 0, '".$uip."')";
			mysql_query( $query, $connections[ 'game' ] );
			die( 'Installation completed succesfuly' );
		}
	}
	closeDB();
?>
	What you should know before installing: <br>
	EVEmu portal is configured, by default, to work with incursion client and server. If you need to use it with Apocrypha be sure to change the values $adminRole and $registerRole from config.php according to your client/server version
	<form action="install.php" method="POST">
	Username: <input type="text" name="user" maxlength=48><br>
	Password: <input type="password" name="pass" maxlength=255><br>
	<!--E-Mail: <input type="text" name="mail" maxlength=255><br />-->
	<input type="submit" value="Complete installation"><br>
	</form>
		</center></h3>
	</fieldset></div>
	</div>
</body>
</html>