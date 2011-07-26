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

	// Fetch the list of forums, subforums and last topics
	/*
	*	Category:	type => 0
	*	Forums:		type => 1
	*	Subforums:	type => 2
	*	Posts:		type => 3
	*	Reply:		type => 4
	*/
	
	// First we need to fetch the forums only
	if( isset( $_SESSION[ 'portalUser' ] ) )
	{
		$admin = is_admin( $_SESSION[ 'portalUser' ] ) & isset( $_GET[ 'admin' ] );
	}else{
		$admin = false;
	}
	$forum = $_GET[ 'viewforum' ];
	if( isset( $_GET[ 'page' ] ) )$page = $_GET[ 'page' ];
	else $page = 1;
	$query = "SELECT id FROM forum_topics WHERE categoryID=".$forum;
	$res = mysql_query( $query, $connections[ 'portal' ] );
	$num = mysql_num_rows( $res );
	
	if( forum_exists( $forum ) )
	{
		$pages = intval( $num / 5 ) ;
		if( $num / 5 != $pages ) $pages += 1;
		$query = "SELECT DISTINCT forum_topics.id, name, forum_replies.creatorID, forum_topics.reads, forum_topics.sticky, forum_topics.closed, MAX(forum_replies.date) FROM forum_topics LEFT JOIN forum_replies ON forum_replies.topicid = forum_topics.id WHERE categoryID=".$forum." GROUP BY name ORDER BY sticky DESC, MAX( forum_replies.date ) DESC LIMIT ".( ( $page * 5 ) - 5 ).", 5;";
		$result = mysql_query( $query, $connections[ 'portal' ] );
?>
<div id="buttons-up">
<a href="?p=forum&amp;createtopic=<? echo $forum ?>">New topic</a>
</div>
<div id="fheader">
<table width="100%">
<tr><td width=21></td><td width=250><center><strong>Topics</strong></center></td><td><center><strong>Author</strong></center></td><td><center><strong>Replies</strong></center></td><td><center><strong>Reads</strong></center></td><td><center><strong>Last post</strong></center></td></tr>
<?
		while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
		{
			$reply = get_last_reply( $row[ 'id' ] );
			$author = get_account_name( $row[ 'creatorID' ] );
			$query = "SELECT id FROM forum_replies WHERE topicid=".$row[ 'id' ].";";
			$count = mysql_query( $query, $connections[ 'portal' ] );
			$replies = mysql_num_rows( $count ) - 1;
			
			if( $admin )
			{
				echo '<tr><td style="background-color: rgb(44, 44, 56);vertical-align: middle;padding-top: 7px;" ><center><a href="?p=forum&amp;deletetopic='.$row[ 'id' ].'"><img src="images/style/forum/delete-icon.png" width=21 height=21 alt="Forum icon"></a><br><a href="?p=forum&amp;locktopic='.$row[ 'id' ].'"><img src="images/style/forum/lock-icon.png" width=21 height=21 alt="Lock topic"></a><br>';
				echo '<a href="?p=forum&amp;sticktopic='.$row[ 'id' ].'"><img src="images/style/forum/sticky-icon.png" width=21 height=21 alt="Stick topic"></a><br>';
				echo '</center></td>';
			}else{
				echo '<tr><td style="background-color: rgb(44, 44, 56);vertical-align: middle;padding-top: 7px;" ><center><img src="images/style/forum/forum-icon.png" alt="Forum icon"></center></td>';
			}
			
			echo '<td style="background-color: rgb(44, 44, 56);padding-left: 5px;"><p>';
			if( $row[ 'closed' ] == 1 )echo '<strong>[Closed]</strong>';
			if( $row[ 'sticky' ] == 1 )echo '<strong>Sticky</strong>: ';
			
			echo '<a href="?p=forum&amp;viewtopic='.$row[ 'id' ];
			if( $admin ) echo '&admin';
			echo '">'.$row[ 'name' ].'</a></td><td style="background-color: rgb(44, 44, 56);"><center><a href="?p=characterinfo&amp;c='.get_principal_character( $row[ 'creatorID' ] ).'">'.$author.'</a></center></td><td style="background-color: rgb(44, 44, 56);"><center>'.$replies.'</center></td><td style="background-color: rgb(44, 44, 56);"><center>'.$row[ 'reads' ].'</center></td>';
			echo '<td style="background-color: rgb(44, 44, 56);vertical-align: center;"><center>'.date("Y.m.d H:m:s", $reply[ 'date' ] ).'<br>by: '.$reply[ 'name' ].'</center></td></tr>';
		}
?>
</table>
</div>
<div id="pages">
<?
		if( $page > 1 )
		{
			echo '<a href="?p=forum&amp;viewforum='.$forum.'"><< First</a> | ';
			echo '<a href="?p=forum&amp;viewforum='.$forum.'&amp;page='.( $page - 1 ).'"><< Prev</a> | ';
		}

		if( $page > 3 )echo '<a href="?p=forum&amp;viewforum='.$forum.'&amp;page='.( $page - 3 ).'">'.( $page - 3 ).'</a> | ';

		if( $page > 2 )echo '<a href="?p=forum&amp;viewforum='.$forum.'&amp;page='.( $page - 2 ).'">'.( $page - 2 ).'</a> | ';

		if( $page > 1 )echo '<a href="?p=forum&amp;viewforum='.$forum.'&amp;page='.( $page - 1 ).'">'.( $page - 1 ).'</a> | ';

		if( $pages > 1 )echo '['.$page.'] | ';

		if( $pages > $page )echo '<a href="?p=forum&amp;viewforum='.$forum.'&amp;page='.( $page + 1 ).'">'.( $page + 1 ).'</a> | ';

		if( $pages > $page + 2 )echo '<a href="?p=forum&amp;viewforum='.$forum.'&amp;page='.( $page + 2 ).'">'.( $page + 2 ).'</a> | ';

		if( $pages > $page + 3 )echo '<a href="?p=forum&amp;viewforum='.$forum.'&amp;page='.( $page + 3 ).'">'.( $page + 3 ).'</a> | ';

		if( $pages > $page )
		{
			echo '<a href="?p=forum&amp;viewforum='.$forum.'&amp;page='.( $page + 1 ).'">Next >></a> | ';
			echo '<a href="?p=forum&amp;viewforum='.$forum.'&amp;page='.( $pages ).'">Last >></a>';
		}
?>
</div>
<div id="buttons-down">
<a href="?p=forum&amp;createtopic=<? echo $forum ?>">New topic</a>
</div>
<?
	}else{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>The category you\'re looking for doesn\'t exists</center></td></tr></table></div>';
	}
?>