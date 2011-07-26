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

	if( isset( $_SESSION[ 'portalUser' ] ) )
	{
		$admin = is_admin( $_SESSION[ 'portalUser' ] ) & isset( $_GET[ 'admin' ] );
	}else{
		$admin = false;
	}
	if( $admin )
	{
		$query = "SELECT * FROM forum_reports";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		
		while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
		{
			if( !reply_exists( $row[ 'replyID' ] ) )
			{
				$query = "DELETE FROM forum_reports WHERE replyID=".$row[ 'replyID' ].";";
				@mysql_query( $query, $connections[ 'portal' ] );
			}
		}
		
		$query = "SELECT * FROM forum_reports";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		
		if( mysql_num_rows( $result ) != 0 )
		{
			echo '<div id="iheader"><table width="100%">';
			echo '<tr><th>Topic</th><th width=320>Reason</th><th>Reporter</th><th>Actions</th></tr>';
			while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
			{
				echo '<tr><td><center>'.get_topic_name( get_topic_from_reply( $row[ 'replyID' ] ) ).'</strong></td><td>';
				echo '<center>'.$row[ 'reason' ].'</center></td><td>';
				echo '<center>'.get_account_name( $row[ 'fromID' ] ).'</center></td><td>';
				echo '<a href="?p=forum&viewpost='.$row[ 'replyID' ].'&admin">View post</a><br>';
				echo '<a href="?p=forum&deletereport='.$row[ 'id' ].'&admin">Delete report</a><br>';
				echo '</td></tr>';
			}
			echo '</table></div>';
		}else{
			echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>No reports where found</center></td></tr></table></div>';
		}
	}else{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>You should be an admin to see this</center></td></tr></table></div>';
	}
?>