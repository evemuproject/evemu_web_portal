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
<div id="theader">
<table width="100%">
<tr><th><center><strong>Player ID</strong></center></th><th><center><strong>Account Name</strong></center></th><th><center><strong>Character 1</strong></center></th><th><center><strong>Character 2</strong></center></th><th><center><strong>Character 3</strong></center></th></tr>
<?
	$pInfo = array( array() );
	
	// Thats easy, connect DB, get rows, organize all in table and close all
	$query = "SELECT * FROM account;";
	$result = mysql_query( $query, $connections[ 'game' ] );
	$pCount = 1;
	$pMax = 0;
	
	while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
	{
		$pInfo[ $pCount ][0] = $row[ 'accountID' ];
		$pInfo[ $pCount ][1] = $row[ 'accountName' ];
		$pCount += 1;
	}
	
	$pMax = $pCount;
	$pCount = 1;
	$pChr = 0;
	
	while( $pCount <= $pMax )
	{
		if( !( empty( $pInfo[ $pCount ][0] ) ) )
		{
			$query = "SELECT * FROM character_ WHERE accountID=".$pInfo[ $pCount ][0];
			$result = mysql_query( $query, $connections[ 'game' ] );
			
			while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
			{
				$query = "SELECT * FROM entity WHERE itemID=".$row[ 'characterID' ];
				$result_row = mysql_query( $query, $connections[ 'game' ] );
				$rowRes = mysql_fetch_array( $result_row, MYSQL_ASSOC );
				$pInfo[ $pCount ][ $pChr + 2 ] = $rowRes[ 'itemName' ];
				$pChr += 1;
			}
		}
		
		$pChr = 0;
		$pCount += 1;
	}
	
	$pCount = 1;
	
	while( $pCount < $pMax )
	{
		echo '<tr><td><center>'.$pInfo[$pCount][0].'</center></td><td><center>'.$pInfo[$pCount][1].'</center></td><td><center>';
		if( isset( $pInfo[ $pCount ][2] ) )
		{
			echo '<a href="?p=characterinfo&c='.get_character_id( $pInfo[ $pCount ][2] ).'">'.$pInfo[ $pCount ][2].'</a></center></td><td><center>';
		}else{
			echo 'None</center></td><td><center>';
		}
		if( isset( $pInfo[ $pCount ][3] ) )
		{
			echo '<a href="?p=characterinfo&c='.get_character_id( $pInfo[ $pCount ][3] ).'">'.$pInfo[ $pCount ][3].'</a></center></td><td><center>';
		}else{
			echo 'None</center></td><td><center>';
		}
		if( isset( $pInfo[ $pCount ][4] ) )
		{
			echo '<a href="?p=characterinfo&c='.get_character_id( $pInfo[ $pCount ][4] ).'">'.$pInfo[ $pCount ][4].'</a></center></td><td><center>';
		}else{
			echo 'None</center></td></tr>';
		}
		
		$pCount += 1;
	}
?>
</table>
</div>