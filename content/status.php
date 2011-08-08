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
<div id="serverstatus">
<font style="text-align: center">
<?
	// Open a socket and try to connect to the server
	$err = 0; // We will use it later to see if the server was on or not

	echo 'Server version: ';
	if( is_incursion() )
	{
		echo '<strong><font color=orange>Incursion</font></strong><br>';
	}else{
		echo '<strong><font color=green>Apocrypha</font></strong><br>';
	}
	
	$status = @fsockopen( $game_server, $game_port, $ERROR_NO, $ERROR_STR, ( float ) 0.5 );
	if( $status )
	{
		fclose( $status );
		// There are a lot of versions of evemu, including the caytchen one, and this portal will be fully compatible with it and its imageserve
		echo 'Server status: ';
		echo '<strong><font color=green>Online</font></strong><br>';
	}else{
		echo 'Server status: ';
		echo '<strong><font color=red>Offline</font></strong><br>';
		$err = 1;
	}
	if( $err == 0 )
	{
?>
Users online:
<?
		$nUsersConnected = 0;
		$query = "SELECT online FROM account WHERE online=1";
		$result = mysql_query( $query, $connections[ 'game' ] );
		
		while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
		{
			$nUsersConnected += 1;
		}
		echo $nUsersConnected.'<br>';
	}
?>
IP: <strong><? echo $game_server; ?></strong>
</font>
</div>