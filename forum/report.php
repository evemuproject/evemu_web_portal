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

	$message = $_GET[ 'report' ];
	if( !reply_exists( $_GET[ 'report' ] ) )
	{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>The post you\'re reporting doesn\'t exists</center></td></tr></table></div>';
	}else if( !isset( $_SESSION[ 'portalUser' ] ) )
	{
		'<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>Only registered users can send reports</center></td></tr></table></div>';
	}else if( isset( $_POST[ 'reason' ] ) )
	{
		$username = $_SESSION[ 'portalUser' ] ;
		$query = "INSERT INTO forum_reports(id, reason, fromID, replyID) VALUES (NULL, '".$_POST[ 'reason' ]."', ".get_account_id( $username ).", ".$message.");";
		mysql_query( $query, $connections[ 'portal' ] );
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 0, 255, 0 );"><strong>Correct</strong></font></th></tr><tr><td><center>Report registered succesfull. Please wait while an admin reads it.</center></td></tr></table></div>';
	}else{
?>
<form method="POST" action="?p=forum&report=<? echo $message; ?>">
<table width="100%" border=0>
<tr><td><textarea cols=69 rows=15 name="reason"></textarea></td></tr>
<tr><td><input type="submit" value="Report post"></td></tr>
</table>
</form>
<?
	}
?>