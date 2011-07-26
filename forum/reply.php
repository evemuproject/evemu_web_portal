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

	if( !topic_exists( $_GET[ 'reply' ] ) )
	{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>The topic you\'re looking for doesn\'t exists</center></td></tr></table></div>';
	}else if( ( isset( $_POST[ 'message' ] ) ) && ( !empty( $_POST[ 'message' ] ) ) ){
		if( isset( $_SESSION[ 'portalUser' ] ) )$username = $_SESSION[ 'portalUser' ] ;
		else $username = '';
		@$query = "INSERT INTO forum_replies(id, message, topicid, creatorID, date) VALUES (NULL, '".htmlentities( mysql_real_escape_string( $_POST[ 'message' ]) )."', ".$_GET[ 'reply' ].", ".get_account_id( $username ).", ".time().");";
		mysql_query( $query, $connections[ 'portal' ] );
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 0, 255, 0 );"><strong>Correct</strong></font></th></tr><tr><td><center>Reply added succesfull. Click <a href=?p=forum&amp;viewtopic='.$_GET[ 'reply' ].'>here</a> to go back</center></td></tr></table></div>';
	}else if( ( isset( $_POST[ 'message' ] ) ) && ( empty( $_POST[ 'message' ] ) ) ){
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>You should enter a text in the textarea</center></td></tr></table></div>';
	}else{
		$query = "SELECT closed FROM forum_topics WHERE id=".$_GET[ 'reply' ].";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		$row = mysql_fetch_array( $result, MYSQL_ASSOC );
		if( $row[ 'closed' ] == true )
		{
			echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>The topic is closed and you can\'t post replyes on it</center></td></tr></table></div>';
		}else{
	
?>
<div id="createtopic">
<form action="?p=forum&amp;reply=<? echo $_GET[ 'reply' ]; ?>" method="POST">
Reply: <br><textarea name="message" cols=69 rows=15>
<?
			if( isset( $_GET[ 'quote' ] ) )
			{
				$query = "SELECT message FROM forum_replies WHERE id=".$_GET[ 'quote' ].";";
				$result = mysql_query( $query, $connections[ 'portal' ] );
				$row = mysql_fetch_array( $result, MYSQL_ASSOC );
				echo '[quote]'.$row[ 'message' ].'[/quote]';
			}
?></textarea><br>
<input type="submit" value="Create reply">
</form>
</div>

<?
		}
	}
?>