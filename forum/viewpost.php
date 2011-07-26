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
	$forum = $_GET[ 'viewpost' ];
	$query = "SELECT * FROM forum_replies WHERE id=".$forum.";";
	$result = @mysql_query( $query, $connections[ 'portal' ] );
	
	if( mysql_num_rows( $result ) != 0 )
	{
?>
<div id="theader">
<table>
<tr><th width=128><center><strong>Author</strong></center></th><th style="width: 450px;"><center><strong>Topic</strong></center></th></tr>
<?
		
		// Fetch all the data to the file
		$row = mysql_fetch_array( $result, MYSQL_ASSOC );
		echo '<tr><td width=128 style="background-color: rgb(44, 44, 56);"><center><strong><a href="?p=characterinfo&amp;c='.get_principal_character( $row[ 'creatorID' ] ).'">'.get_principal_picture( $row[ 'creatorID' ] ).'</a><br>'.get_account_name( $row[ 'creatorID' ] ).'</strong></center></td><td style="background-color: rgb(44, 44, 56);">';
		echo '<div style="float: left">Posted - '.date("Y.m.d H:m:s", $row[ 'date' ] ).' - <a href="?p=forum&amp;reply='.$forum.'&amp;quote='.$row[ 'id' ].'">Quote</a></div><div style="float: right"><a href="?p=forum&amp;report='.$row[ 'id' ].'">Report</a>';
		if( ( $admin ) || ( isset( $_SESSION[ 'portalUser' ] ) ) )
		{
			if( ( $_SESSION[ 'portalUser' ] == get_account_name( $row[ 'creatorID' ] ) ) )
			{
				echo ' | <a href="?p=forum&amp;edit='.$row[ 'id' ].'">Edit</a>';
				if( $admin )echo ' | <a href="?p=forum&amp;delete='.$row[ 'id' ].'">Delete</a>';
			}
		}
		echo '</div><br><hr noshade="noshade" size="1"><br>';
		echo '<div id="p'.$row[ 'id' ].'">'.toUrl( nl2br( $row[ 'message' ], true ) ).'<script type="text/javascript">load_post( \'p'.$row[ 'id' ].'\' );</script></div></td></tr>';
		
?>
</table>
</div>
<?
	}else{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>The post you\'re looking for doesn\'t exists</center></td></tr></table></div>';
	}
?>