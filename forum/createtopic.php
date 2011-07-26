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
	if( !forum_exists( $_GET[ 'createtopic' ] ) )
	{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>The category you\'re trying to create a topic doesn\'t exists</center></td></tr></table></div>';
	}else if( ( isset( $_POST[ 'topicname' ] ) ) && ( isset( $_POST[ 'message' ] ) ) && ( !empty( $_POST[ 'topicname' ] ) ) && ( !empty( $_POST[ 'message' ] ) ) )
	{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 0, 255, 0 );"><strong>Correct</strong></font></th></tr><tr><td><center>Post added succesfull. Click <a href="?p=forum&amp;viewforum='.$_GET[ 'createtopic' ].'">here</a> to go back</center></td></tr></table></div>';
	}else if( ( ( isset( $_POST[ 'topicname' ] ) ) && ( isset( $_POST[ 'message' ] ) ) ) && ( ( empty( $_POST[ 'topicname' ] ) ) && ( empty( $_POST[ 'message' ] ) ) ) ){
		'<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>You should enter the topic name and the message</center></td></tr></table></div>';
	}else{
?>
<div id="createtopic">
<form action="?p=forum&amp;createtopic=<? echo $_GET[ 'createtopic' ]; ?>" method="POST">
Topic name: <input type="text" name="topicname" maxlength=255/><br />
Message: <br /><textarea name="message" cols=69 rows=15></textarea><br />
<input type="submit" value="Create topic" />
</form>
</div>

<?
	}
?>