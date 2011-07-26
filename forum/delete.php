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

	if( reply_exists( $_GET[ 'delete' ] ) )
	{
		$query = "SELECT topicid FROM forum_replies WHERE id=".$_GET[ 'delete' ].";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		$posts = mysql_num_rows( $result );
		
		$row = mysql_fetch_array( $result, MYSQL_ASSOC );
		
		if( $posts == 1 )
		{
			$query = "DELETE FROM forum_topics WHERE id=".$row[ 'topicid' ].";";
			@mysql_query( $query, $connections[ 'portal' ] );
		}
		
		$query = "DELETE FROM forum_replies WHERE id=".$_GET[ 'delete' ].";";
		@mysql_query( $query, $connections[ 'portal' ] );
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 0, 255, 0 );"><strong>Correct</strong></font></th></tr><tr><td><center>Post deleted succesfull</center></td></tr></table></div>';
	}else{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>Can\'t find the topic you\'re looking for</center></td></tr></table></div>';
	}
?>