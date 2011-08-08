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
	if( is_incursion() )
	{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>EVEmu portal is not compatible with incursion login/register functions</center></td></tr></table></div>';
	}
	else if( ( isset( $_SESSION[ 'portalRole' ] ) ) && ( isset( $_SESSION[ 'portalUser' ] ) ) && ( isset( $_SESSION[ 'portalPassword' ] ) ) )
	{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>You are already logged in. Click <a href="?p=">here</a> to see the news</center></td></tr></table></div>';
	}else if( ( isset( $_POST[ 'username' ] ) ) && ( isset( $_POST[ 'password' ] ) ) )
	{
		if( ( empty( $_POST[ 'username' ] ) ) )
		{
			echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>You should write a username</center></td></tr></table></div>';
		}else if( ( empty( $_POST[ 'password' ] ) ) ){
			echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>You should write a password</center></td></tr></table></div>';
		}else{			
			// Check if the user exists
			if( !is_incursion() ) $query = "SELECT 1 AS correct, role, banned FROM account WHERE accountName='".$_POST[ 'username' ]."' AND password=PASSWORD('".$_POST[ 'password' ]."');";
			else $query = "SELECT 1 AS correct, role, banned, hash FROM account WHERE accountName='".$_POST[ 'username' ]."' AND hash=BIN('".$hash."');";
			$gameserver_result = mysql_query( $query, $connections[ 'game' ] );
			if( $row = mysql_fetch_array( $gameserver_result, MYSQL_ASSOC ) )
			{
				if( $row[ 'banned' ] == 1)
				{
					echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>You\'re banned and you are not able to login</center></td></tr></table></div>';
				}else if( $row[ 'correct' ] == 1 ){
					// Correctly logged in
					$_SESSION[ 'portalRole' ] = $row[ 'role' ] ;
					$_SESSION[ 'portalUser' ] = $_POST[ 'username' ];
					$_SESSION[ 'portalPassword' ] = $_POST[ 'password' ];
					/*setcookie( 'portalRole', $row[ 'role' ], 0 );
					setcookie( 'portalUser', $_POST[ 'username' ], 0 );
					setcookie( 'portalPassword', $_POST[ 'password' ], 0 );*/
					echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 0, 255, 0 );"><strong>Correct</strong></font></th></tr><tr><td><center>You are correctly logged in. Click <a href="?p=">here</a> to see the news</center></td></tr></table></div>';
				}else{
					echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>Strange thing happened, stoping login. <br>Try to login in a few minutes.</center></td></tr></table></div>';
				}
			}else{
				echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>The user\\password is not correct</center></td></tr></table></div>';
			}
		}
	}else{
?>
<form action="?p=login" method="POST">
<table class=registerform border=0 width="100%">
<tr><th colspan=2>Welcome to EVEmu Portal, please fill the form in order to login</th></tr>
<tr><td>Username: </td><td><input type="text" name="username" maxlength=48></td></tr>
<tr><td>Password: </td><td><input type="password" name="password"></td></tr>
<tr><td><input type="submit" value="Log in"></td></tr>
</table>
</form>

<?
	}
?>