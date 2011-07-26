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

	if( empty( $_SESSION[ 'portalUser' ] ) )
	{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>You should login before being able to use this</center></td></tr></table></div>';
	}else{
		
		// First check if the character belongs to the player
		
		$query = "SELECT accountID FROM account WHERE accountName='".$_SESSION[ 'portalUser' ]."';";
		$result = @mysql_query( $query, $connections[ 'game' ] );
		
		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
		
		if( $row )
		{
			$accountID = $row[ 'accountID' ];
		}else{
			echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>The especified user doesnt exists</center></td></tr></table></div>';
		}
		
		$query = "SELECT characterID, itemName AS characterName FROM character_ LEFT JOIN entity ON characterID = itemID WHERE accountID=".$accountID." AND itemID >= 140000000;";
		$result = @mysql_query( $query, $connections[ 'game' ] );
		
		$characterInfo = array(
								"id"	=> array(),
								"name"	=> array()
							);
		
		$n = 0;
		
		while( $row = @mysql_fetch_array( $result, MYSQL_ASSOC ) )
		{
			$characterInfo[ 'id'   ][ $n ] = $row[ 'characterID' ];
			$characterInfo[ 'name' ][ $n ] = $row[ 'characterName' ];
			$n += 1;
		}
		
		if( !isset( $_GET[ 'c' ] ) )
		{
			echo 'Select one character to see the item it owns<br>';
			echo '<center>| ';
			while( $n > 0 )
			{
				$n -= 1;
				echo '<a href="?p=itemlist&amp;c='.$characterInfo[ 'id' ][ $n ].'">'.$characterInfo[ 'name' ][ $n ].'</a> | ';
			}
			echo '</center>';
		}else{
			$query = "SELECT accountID FROM character_ WHERE characterID=".$_GET[ 'c' ].";";
			$result = @mysql_query( $query, $connections[ 'game' ] );
			
			$row = @mysql_fetch_array( $result, MYSQL_ASSOC );
			
			if( !$row )
			{
				echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>This character not belongs to you</center></td></tr></table></div>';
			}else{
				
				// Ok the character is selected, now fetch all the data, thats gonna hurt!
				// WHERE ownerID=140000032 AND NOT locationID=140000032
				$query = "SELECT typeName, categoryID, entity.typeID, entity.locationID, quantity FROM entity LEFT JOIN invtypes ON entity.typeID = invtypes.typeID LEFT JOIN invgroups ON invtypes.groupID = invgroups.groupID WHERE ownerID=".$_GET[ 'c' ]." AND NOT locationID=".$_GET[ 'c' ].";";
				$result = @mysql_query( $query, $connections[ 'game' ] );
				
?>
<div id="iheader">
<table width=100%>
<tr><th width=64>Image</th><th>Item Name</th><th>Location</th><th>Quantity</th></tr>
<?
			while( $row = @mysql_fetch_array( $result, MYSQL_ASSOC ) )
			{
				echo '<tr><td>';
				echo "<a href=\"?p=iteminfo&item=".$row[ 'typeID' ]."\" alt=\"Show item info\"><img width=64 height=64 src=\"".$icon->check( $row[ 'typeID' ] )."\" alt=\"".$row[ 'typeName' ]."\"></a>";
				echo '</td><td>';
				echo '<a href="?p=iteminfo&item='.$row[ 'typeID' ].'" alt="Show item info">'.$row[ 'typeName' ].'</a>';
				echo '</td><td>';
				echo get_station_name( $row[ 'locationID' ] );
				echo '</td><td>';
				echo $row[ 'quantity' ];
				echo '</td></tr>';
			}
			
?>
</table>
</div>
<?
			}
		}
	}
?>