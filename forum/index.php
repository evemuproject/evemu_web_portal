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
	$admin = false;
	if( isset( $_SESSION[ 'portalUser' ] ) )
	{
		$admin = is_admin( $_SESSION[ 'portalUser' ] ) & isset( $_GET[ 'admin' ] );
	}
	$query = "SELECT * FROM forum_categories ORDER BY priority;";
	$result = mysql_query( $query, $connections[ 'portal' ] );
	$forum = 0;
?>
<div id="fheader">
<table width="100%">
<tr><td width=21></td><td width=356><center><strong>Channels</strong></center></td><td width=77><center><strong>Topics</strong></center></td><td width=140><center><strong>Latest topic</strong></center></td></tr>
<?
	while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
	{
		$forum += 1;
		$reply = get_last_topic( $row[ 'id' ] );
		$query = "SELECT id FROM forum_topics WHERE categoryID=".$row[ 'id' ].";";
		$count = mysql_query( $query, $connections[ 'portal' ] );
		$topics = mysql_num_rows( $count );
		echo '<tr><td style="background-color: rgb(44, 44, 56);vertical-align: top;padding-top: 7px;"><center>';
		if( $admin ) echo '<a href="?p=forum&amp;deleteforum='.$forum.'&amp;admin"><img src="images/style/forum/delete-icon.png" width=21 height=21 alt="Delete icon"></a>';
		else echo '<img src="images/style/forum/forum-icon.png" alt="Forum Icon">';
		echo '</center></td><td style="background-color: rgb(44, 44, 56);padding-left: 5px;"><p><a href="?p=forum&amp;viewforum='.$row[ 'id' ];
		if( $admin ) echo '&amp;admin';
		echo '">'.$row[ 'name' ].'</a></p>'.$row[ 'description' ].'</td><td style="background-color: rgb(44, 44, 56);"><center>'.$topics.'</center></td><td style="background-color: rgb(44, 44, 56);"><center>';
		if( $topics > 0 ) echo date("Y.m.d H:m:s", $reply[ 'date' ] ).'<br>by: '.$reply[ 'name' ].'</center></td></tr>';
		else echo $reply[ 'name' ].'</center></td></tr>';
	}
?>
</table>
</div>
<div id="buttons-down">
<?
	if( $admin ) echo '<a href="?p=forum&amp;createcategory&amp;admin">Create category</a>';
?>
</div>

<?
?>