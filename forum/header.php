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
?>
<br>
<table width="100%" class=registerform border=0>
<tr><th colspan=2>
<?
	function topic_exists( $id )
	{
		global $connections;
		$query = "SELECT id FROM forum_topics WHERE id=".$id.";";
		$result = mysql_query( $query, $connections[ 'portal' ] );
		$num = mysql_num_rows( $result );
		
		if( !$num )return false;
		return true;
	}
	
	function forum_exists( $id )
	{
		global $connections;
		$query = "SELECT id FROM forum_categories WHERE id=".$id.";";
		$result = mysql_query( $query, $connections[ 'portal' ] );
		if( !$row = mysql_fetch_array( $result, MYSQL_ASSOC ) )return false;
		else return true;
	}
	
	function reply_exists( $id )
	{
		global $connections;
		$query = "SELECT id FROM forum_replies WHERE id=".$id.";";
		$result = mysql_query( $query, $connections[ 'portal' ] );
		if( !$row = mysql_fetch_array( $result, MYSQL_ASSOC ) )return false;
		else return true;
	}
	
	if( isset( $_SESSION[ 'portalUser' ] ) )
	{
		$admin = is_admin( $_SESSION[ 'portalUser' ] ) & isset( $_GET[ 'admin' ] );
	}else{
		$admin = false;
	}
	// Ok lets draw the complete path
	if( ( isset( $_GET[ 'viewforum' ] ) ) && ( forum_exists( $_GET[ 'viewforum' ] ) ) )
	{
		echo '<a href="?p=forum';
		if( $admin ) echo '&amp;admin';
		echo '">Forum</a>';
		$query = "SELECT name FROM forum_categories WHERE id=".$_GET[ 'viewforum' ].";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		
		echo ' > <a href="?p=forum&amp;viewforum='.$_GET[ 'viewforum' ];
		if( $admin ) echo '&amp;admin';
		echo '">'.$row[ 'name' ].'</a>';
	}else if( ( isset( $_GET[ 'viewtopic' ] ) ) && ( topic_exists( $_GET[ 'viewtopic' ] ) ) ){
		echo '<a href="?p=forum';
		if( $admin ) echo '&amp;admin';
		echo '">Forum</a>';
		$query = "SELECT name, categoryID FROM forum_topics WHERE id=".$_GET[ 'viewtopic' ].";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		$topicname = $row[ 'name' ];
		
		$query = "SELECT id, name FROM forum_categories WHERE id=".$row[ 'categoryID' ].";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		
		echo ' > <a href="?p=forum&amp;viewforum='.$row[ 'id' ];
		if( $admin ) echo '&amp;admin';
		echo '">'.$row[ 'name' ].'</a>';
		echo ' > <a href="?p=forum&amp;viewtopic='.$_GET[ 'viewtopic' ];
		if( $admin ) echo '&amp;admin';
		echo '">'.$topicname.'</a>';
		
	}else if( isset( $_GET[ 'reply' ] ) && ( topic_exists( $_GET[ 'reply' ] ) ) ){
		echo 'Replying to: ';
		echo '<a href="?p=forum';
		if( $admin ) echo '&amp;admin';
		echo '">Forum</a>';
		$query = "SELECT name, categoryID FROM forum_topics WHERE id=".$_GET[ 'reply' ].";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		$topicname = $row[ 'name' ];
		
		$query = "SELECT id, name FROM forum_categories WHERE id=".$row[ 'categoryID' ].";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		
		echo ' > <a href="?p=forum&amp;viewforum='.$row[ 'id' ];
		if( $admin ) echo '&amp;admin';
		echo '">'.$row[ 'name' ].'</a>';
		echo ' > <a href="?p=forum&amp;viewtopic='.$_GET[ 'reply' ];
		if( $admin ) echo '&amp;admin';
		echo '">'.$topicname.'</a>';
	}else if( isset( $_GET[ 'createtopic' ] ) && ( isset( $_POST[ 'topicname' ] ) ) && ( isset( $_POST[ 'message' ] ) ) && ( !empty( $_POST[ 'topicname' ] ) ) && ( !empty( $_POST[ 'message' ] ) && ( forum_exists( $_GET[ 'createtopic' ] ) ) ) )
	{
		if( isset( $_SESSION[ 'portalUser' ] ) )$username = $_SESSION[ 'portalUser' ] ;
		else $username = "";
	
		$query = "INSERT INTO forum_topics(id, name, categoryid, creatorID, date) VALUES (NULL, '".htmlentities( mysql_real_escape_string( $_POST[ 'topicname' ] ) )."', ".$_GET[ 'createtopic' ].", ".get_account_id( $username ).", ".time().");";
		mysql_query( $query, $connections[ 'portal' ] );
		$id = mysql_insert_id();
		$query = "INSERT INTO forum_replies(id, message, topicid, creatorID, date) VALUES (NULL, '". htmlentities( mysql_real_escape_string( $_POST[ 'message' ]) )."', ".$id.", ".get_account_id($username ).", ".time().");";
		mysql_query( $query, $connections[ 'portal' ] );
		echo '<a href="?p=forum';
		if( $admin ) echo '&amp;admin';
		echo '">Forum</a>';
		
		$query = "SELECT id, name FROM forum_categories WHERE id=".$_GET[ 'createtopic' ].";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		
		echo ' > <a href="?p=forum&amp;viewforum='.$id;
		if( $admin ) echo '&amp;admin';
		echo '">'.$row[ 'name' ].'</a>';
		echo ' > <a href="?p=forum&amp;viewtopic='.$id;
		if( $admin ) echo '&amp;admin';
		echo '">'.$_POST[ 'topicname' ].'</a>';
	}else if( isset( $_GET[ 'createtopic' ] ) && ( forum_exists( $_GET[ 'createtopic' ] ) ) ){
		echo 'Creating topic in: ';
		echo '<a href="?p=forum';
		if( $admin ) echo '&amp;admin';
		echo '">Forum</a>';
		
		$query = "SELECT id, name FROM forum_categories WHERE id=".$_GET[ 'createtopic' ].";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		
		echo ' > <a href="?p=forum&amp;viewforum='.$row[ 'id' ];
		if( $admin ) echo '&amp;admin';
		echo '">'.$row[ 'name' ].'</a>';
		
	}else if( ( isset( $_GET[ 'edit' ] ) ) && ( reply_exists( $_GET[ 'edit' ] ) ) ){
		echo 'Editing your post from: ';
		echo '<a href="?p=forum';
		if( $admin ) echo '&amp;admin';
		echo '">Forum</a>';
		$query = "SELECT topicid FROM forum_replies WHERE id=".$_GET[ 'edit' ].";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		$topicid = $row[ 'topicid' ];
		
		$query = "SELECT name, categoryID FROM forum_topics WHERE id=".$topicid .";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		$topicname = $row[ 'name' ];
		
		$query = "SELECT id, name FROM forum_categories WHERE id=".$row[ 'categoryID' ].";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		
		echo ' > <a href="?p=forum&amp;viewforum='.$row[ 'id' ];
		if( $admin ) echo '&amp;admin';
		echo '">'.$row[ 'name' ].'</a>';
		echo ' > <a href="?p=forum&amp;viewtopic='.$topicid;
		if( $admin ) echo '&amp;admin';
		echo '">'.$topicname.'</a>';
	}else if( ( isset( $_GET[ 'report' ] ) ) && ( reply_exists( $_GET[ 'report' ] ) ) ){
		echo 'Reporting a post from: ';
		echo '<a href="?p=forum';
		if( $admin ) echo '&amp;admin';
		echo '">Forum</a>';
		$query = "SELECT topicid FROM forum_replies WHERE id=".$_GET[ 'report' ].";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		$topicid = $row[ 'topicid' ];
		
		$query = "SELECT name, categoryID FROM forum_topics WHERE id=".$topicid .";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		$topicname = $row[ 'name' ];
		
		$query = "SELECT id, name FROM forum_categories WHERE id=".$row[ 'categoryID' ].";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		
		echo ' > <a href="?p=forum&amp;viewforum='.$row[ 'id' ];
		if( $admin ) echo '&amp;admin';
		echo '">'.$row[ 'name' ].'</a>';
		echo ' > <a href="?p=forum&amp;viewtopic='.$topicid;
		if( $admin ) echo '&amp;admin';
		echo '">'.$topicname.'</a>';
	}else if( ( isset( $_GET[ 'viewpost' ] ) ) && ( reply_exists( $_GET[ 'viewpost' ] ) ) ){
		echo 'Viewing a reply from: ';
		echo '<a href="?p=forum';
		if( $admin ) echo '&amp;admin';
		echo '">Forum</a>';
		$topicID = get_topic_from_reply( $_GET[ 'viewpost' ] );
		$query = "SELECT name, categoryID FROM forum_topics WHERE id=".$topicID.";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		$topicname = $row[ 'name' ];
		
		$query = "SELECT id, name FROM forum_categories WHERE id=".$row[ 'categoryID' ].";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		
		echo ' > <a href="?p=forum&amp;viewforum='.$row[ 'id' ];
		if( $admin ) echo '&amp;admin';
		echo '">'.$row[ 'name' ].'</a>';
		echo ' > <a href="?p=forum&amp;viewtopic='.$topicID;
		if( $admin ) echo '&amp;admin';
		echo '">'.$topicname.'</a>';
	}else{
		echo '<a href="?p=forum';
		if( $admin ) echo '&amp;admin';
		echo '">Forum</a>';
	}
?>
</th></tr></table>
<br>