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

	// check if the user is logged in
	if( !reply_exists( $_GET[ 'edit' ] ) )
	{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>The post you\'re looking for doesn\'t exists</center></td></tr></table></div>';
	}else if( ( isset( $_POST[ 'message' ] ) ) && ( !empty( $_POST[ 'message' ] ) ) )
	{
		if( isset( $_SESSION[ 'portalUser' ] ) )$username = $_SESSION[ 'portalUser' ] ;
		else $username = '';
		$query = "UPDATE forum_replies SET message='".htmlentities( mysql_real_escape_string( $_POST[ 'message' ]) )."' WHERE id=".$_GET[ 'edit' ].";";
		mysql_query( $query, $connections[ 'portal' ] );
		
		$query = "SELECT topicid FROM forum_replies WHERE id=".$_GET[ 'edit' ].";";
		$result = mysql_query( $query, $connections[ 'portal' ] );
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 0, 255, 0 );"><strong>Correct</strong></font></th></tr><tr><td><center>Post edited succesfull. Click <a href=?p=forum&amp;viewtopic='.$row[ 'topicid' ].'>here</a> to go back</center></td></tr></table></div>';
	}else{
		$query = "SELECT message, creatorID FROM forum_replies WHERE id=".$_GET[ 'edit' ].";";
		$result = mysql_query( $query , $connections[ 'portal' ] );
		$row = mysql_fetch_array( $result, MYSQL_ASSOC );
		if( !isset( $_SESSION[ 'portalUser' ] ) )
		{
			echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>You should be loggedin to use this function</center></td></tr></table></div>';
		}else{
			if( ( get_account_id( $_SESSION[ 'portalUser' ] ) == $row[ 'creatorID' ] ) || ( ($_SESSION[ 'portalRole' ] == $adminRole ) ) )
			{
			
?>
<div id="createtopic">
<form action="?p=forum&amp;edit=<? echo $_GET[ 'edit' ]; ?>" method="POST">
Edit post in: <br><textarea name="message" cols=69 rows=15>
<?
				echo $row[ 'message' ];
?></textarea><br>
<input type="submit" value="Edit post">
</form>
</div>

<?
			}else{
				echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>This post doesn\'t belongs to you</center></td></tr></table></div>';
			}
		}
	}
?>