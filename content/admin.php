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

	$correct = true;
	if( isset( $_SESSION[ 'portalUser' ] ) )
	{
		$query = "SELECT banned, role, PASSWORD('".$_SESSION[ 'portalPassword' ]."') AS webpass, password FROM account WHERE accountName='".$_SESSION[ 'portalUser' ]."';";
		$result = @mysql_query( $query, $connections[ 'game' ] );
		
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		
		if( $row )
		{
			if( $row[ 'banned' ] == 1 )
			{
				echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>You\'re banned from the portal and the server</center></td></tr></table></div>';
				$correct = false;
			}else if( ( $row[ 'role' ]  != $adminRole ) ){
				echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>You\'re not an admin</center></td></tr></table></div>';
				$correct = false;
			}else if( $row[ 'webpass' ] != $row[ 'password' ] ){
				echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>User information invalid, please re-login <a href="?p=login">here</a></center></td></tr></table></div>';
				session_destroy();
				$correct = false;
			}
		}else{
			echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>User information invalid, please re-login <a href="?p=login">here</a></center></td></tr></table></div>';
			session_destroy();
			$correct = false;
		}
		
		if( $correct == true )
		{
		/*}else{
			echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>Please <a href="?p=login">login</a> before being able to use the control panel</center></td></tr></table></div>';
		}*/
			if( isset( $_GET[ 'm' ] ) )
			{
				$file = 'content/admin/'.$_GET[ 'm' ].'.php';
				if( file_exists( $file ) )
				{
					include( $file );
				}else{
					echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>The module you\'re looking for doesn\'t exists</center></td></tr></table></div><br>';
					include( 'content/admin/panel.php' );
				}
			}else{
				include( 'content/admin/panel.php' );
			}
		}
	}

?>