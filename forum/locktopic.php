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

	if( !is_admin( $_SESSION[ 'portalUser' ] ) )
	{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>You should be an admin to do this</center></td></tr></table></div><br>';
	}else if( !isset( $_GET[ 'action' ] )  )
	{
		$query = "SELECT closed FROM forum_topics WHERE id=".$_GET[ 'locktopic' ].";";
		$result = mysql_query( $query, $connections[ 'portal' ] );
		$row = mysql_fetch_array( $result, MYSQL_ASSOC );
		if( $row[ 'closed' ] == 1 )
		{
			echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 255, 0 );"><strong>Warning</strong></font></th></tr><tr><td><center>Are you sure you want to un-lock the topic?<br>';
			echo '<a href="?p=forum&locktopic='.$_GET[ 'locktopic' ].'&admin&action=1">Yes</a> | <a href="?p=forum&viewtopic='.$_GET[ 'locktopic' ].'&admin">No</a></center></td></tr></table></div>';
		}else{
			echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 255, 0 );"><strong>Warning</strong></font></th></tr><tr><td><center>Are you sure you want to lock the topic?<br>';
			echo '<a href="?p=forum&locktopic='.$_GET[ 'locktopic' ].'&admin&action=1">Yes</a> | <a href="?p=forum&viewtopic='.$_GET[ 'locktopic' ].'&admin">No</a></center></td></tr></table></div>';
		}
	}else{
		// Change the status of the sticky flag
		$query = "SELECT closed FROM forum_topics WHERE id=".$_GET[ 'locktopic' ].";";
		$result = mysql_query( $query, $connections[ 'portal' ] );
		$row = mysql_fetch_array( $result, MYSQL_ASSOC );
		if( $row[ 'closed' ] == 1 )
		{
			echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 0, 255, 0 );"><strong>Correct</strong></font></th></tr><tr><td><center>Topic openned correctly<br>Click <a href="?p=forum&viewtopic='.$_GET[ 'locktopic' ].'&admin">here</a> to go back</center></td></tr></table></div>';
			$query = "UPDATE forum_topics SET closed=0 WHERE id=".$_GET[ 'locktopic' ].";";
		}else{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 0, 255, 0 );"><strong>Correct</strong></font></th></tr><tr><td><center>Topic closed correctly<br>Click <a href="?p=forum&viewtopic='.$_GET[ 'locktopic' ].'&admin">here</a> to go back</center></td></tr></table></div>';
			$query = "UPDATE forum_topics SET closed=1 WHERE id=".$_GET[ 'locktopic' ].";";
		}
		@mysql_query( $query, $connections[ 'portal' ] );
	}
	
?>