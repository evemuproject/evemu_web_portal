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
	
	function toUrl( $text )
	{
		return preg_replace('/(?<!S)((http(s?):\/\/)|(www.))+([\w.1-9\&=#?\-~%;\/]+)/','<a href="http$3://$4$5">http$3://$4$5</a>', $text);
	}

	if( isset( $_SESSION[ 'portalUser' ] ) )
	{
		$admin = is_admin( $_SESSION[ 'portalUser' ] ) & isset( $_GET[ 'admin' ] );
	}else{
		$admin = false;
	}
	$forum = $_GET[ 'viewtopic' ];
	if( isset( $_GET[ 'page' ] ) )$page = $_GET[ 'page' ];
	else $page = 1;
	$query = "UPDATE forum_topics SET `reads`=`reads`+1 WHERE id=".$forum.";";
	$result = @mysql_query( $query, $connections[ 'portal' ] );
	$query = "SELECT id FROM forum_replies WHERE topicid=".$forum." ORDER BY date";
	$result = @mysql_query( $query, $connections[ 'portal' ] );
	$num = mysql_num_rows( $result );
	
	if( $num )
	{
		$pages = intval( $num / 20 ) ;
		if( $num / 20 != $pages ) $pages += 1;
		$m = ( $page * 20 ) - 20;
		$s = 0;
		$query = "SELECT categoryID FROM forum_topics WHERE id=".$forum.";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		$row = mysql_fetch_array( $result, MYSQL_ASSOC );
		$categoryID = $row[ 'categoryID' ];
?>
<div id="buttons-up">
<a href="?p=forum&amp;createtopic=<? echo $categoryID; ?>">New topic</a>
<?
	$query = "SELECT closed FROM forum_topics WHERE id=".$forum.";";
	$result = mysql_query( $query, $connections[ 'portal' ] );
	
	$row = mysql_fetch_array( $result, MYSQL_ASSOC );
	
	if( $row[ 'closed' ] == 0 )echo '| <a href="?p=forum&amp;reply='.$forum.'">Reply to Topic</a>';
	if( $admin )
	{
		echo ' | <a href="?p=forum&amp;sticktopic='.$forum.'">Mark/Unmark as Sticky</a>';
		echo ' | <a href="?p=forum&amp;deletetopic='.$forum.'">Delete topic </a>';
		echo ' | <a href="?p=forum&amp;locktopic='.$forum.'">Lock/Unlock topic</a>';
	}
?>
</div>
<div id="theader">
<table>
<tr><th width=128><center><strong>Author</strong></center></th><th style="width: 450px;"><center><strong>Topic</strong></center></th></tr>
<?
		$query = "SELECT * FROM forum_replies WHERE topicid=".$forum." ORDER BY date LIMIT ".( ( $page  * 20 ) - 20 ).", 20;";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		
		// Fetch all the data to the file
		$row = mysql_fetch_full_result_array( $result );
		$db = new dbcache();
		if( $db->check( $row, "f".$forum."p".$page ) == false )
		{
			$c = new cache();
			if( $c->start( 'cache/', 86400, false ) == false )
			{
				while( $s < mysql_num_rows( $result ) )
				{
					$s += 1;
					$m += 1;
					echo '<tr><td width=128 style="background-color: rgb(44, 44, 56);"><center><strong><a href="?p=characterinfo&amp;c='.get_principal_character( $row[ $s - 1 ][ 'creatorID' ] ).'">'.get_principal_picture( $row[ $s - 1 ][ 'creatorID' ] ).'</a><br>'.get_account_name( $row[ $s - 1 ][ 'creatorID' ] ).'</strong></center></td><td style="background-color: rgb(44, 44, 56);">';
					echo '<div style="float: left">Posted - '.date("Y.m.d H:m:s", $row[ $s - 1 ][ 'date' ] ).' - [<a href="?p=forum&amp;viewtopic='.$forum.'#'.( $m ).'">'. $m .'</a>]<a name="'.$m.'"></a> - <a href="?p=forum&amp;reply='.$forum.'&amp;quote='.$row[ $s - 1 ][ 'id' ].'">Quote</a></div><div style="float: right"><a href="?p=forum&amp;report='.$row[ $s - 1 ][ 'id' ].'">Report</a>';
					if( ( $admin ) || ( isset( $_SESSION[ 'portalUser' ] ) ) )
					{
						if( ( $_SESSION[ 'portalUser' ] == get_account_name( $row[ $s - 1 ][ 'creatorID' ] ) ) )
						{
							echo ' | <a href="?p=forum&amp;edit='.$row[ $s - 1 ][ 'id' ].'">Edit</a>';
							if( $admin )echo ' | <a href="?p=forum&amp;delete='.$row[ $s - 1 ][ 'id' ].'">Delete</a>';
						}
					}
					echo '</div><br><hr noshade="noshade" size="1"><br>';

					echo '<div id="p'.( $s - 1 ).'">'.toUrl( nl2br( $row[ $s - 1 ][ 'message' ], true ) ).'<script type="text/javascript">load_post( \'p'.( $s - 1 ).'\' );</script></div></td></tr>';
				}
			}
			$c->end();
		}
?>
</table>
</div>
<div id="pages">
<?
		if( $page > 1 )
		{
			echo '<a href="?p=forum&amp;viewtopic='.$forum.'"><< First</a> ';
			echo '<a href="?p=forum&amp;viewtopic='.$forum.'&amp;page='.( $page - 1 ).'"><< Prev</a> ';
		}

		if( $pages - $page > 3 )echo '<a href="?p=forum&amp;viewtopic='.$forum.'&amp;page='.( $page - 3 ).'">'.( $page - 3 ).'</a> ';

		if( $pages - $page > 2 )echo '<a href="?p=forum&amp;viewtopic='.$forum.'&amp;page='.( $page - 2 ).'">'.( $page - 2 ).'</a> ';

		if( $page > 1 )echo '<a href="?p=forum&amp;viewtopic='.$forum.'&amp;page='.( $page - 1 ).'">'.( $page - 1 ).'</a> ';

		if( $pages > 1 )echo '['.$page.'] ';

		if( $pages > $page )echo '<a href="?p=forum&amp;viewtopic='.$forum.'&amp;page='.( $page + 1 ).'">'.( $page + 1 ).'</a> ';

		if( $pages > $page + 2 )echo '<a href="?p=forum&amp;viewtopic='.$forum.'&amp;page='.( $page + 2 ).'">'.( $page + 2 ).'</a> ';

		if( $pages > $page + 3 )echo '<a href="?p=forum&amp;viewtopic='.$forum.'&amp;page='.( $page + 3 ).'">'.( $page + 3 ).'</a> ';

		if( $pages > $page )
		{
			echo '<a href="?p=forum&amp;viewtopic='.$forum.'&amp;page='.( $page + 1 ).'">Next >></a> ';
			echo '<a href="?p=forum&amp;viewtopic='.$forum.'&amp;page='.( $pages ).'">Last >></a> ';
		}
?>
</div>
<div id="buttons-down">
<a href="?p=forum&amp;createtopic=<? echo $categoryID; ?>">New topic</a>
<?
	$query = "SELECT closed FROM forum_topics WHERE id=".$forum.";";
	$result = mysql_query( $query, $connections[ 'portal' ] );
	
	$row = mysql_fetch_array( $result, MYSQL_ASSOC );
	
	if( $row[ 'closed' ] == 0 )echo '| <a href="?p=forum&amp;reply='.$forum.'">Reply to Topic</a>';
	if( $admin )
	{
		echo ' | <a href="?p=forum&amp;sticktopic='.$forum.'">Mark/Unmark as Sticky</a>';
		echo ' | <a href="?p=forum&amp;deletetopic='.$forum.'">Delete topic </a>';
		echo ' | <a href="?p=forum&amp;locktopic='.$forum.'">Lock/Unlock topic</a>';
	}
?>
</div>
<?
	}else{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>The topic you\'re looking for doesn\'t exists</center></td></tr></table></div>';
	}
?>