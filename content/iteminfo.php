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

	if( isset( $_GET[ 'item' ] ) )
	{
		if( item_exists( $_GET[ 'item' ] ) )
		{
			$query = "SELECT description, typeName, basePrice, raceID FROM invtypes WHERE typeID=".$_GET[ 'item' ].";";
			$result = @mysql_query( $query, $connections[ 'game' ] );
			
			$row = mysql_fetch_array( $result, MYSQL_ASSOC );
			echo '<div id="iheader"><table width="100%">';
			echo '<tr><th width=64><center><img src="'.$icon->check( $_GET[ 'item' ] ).'" alt="'.$row[ 'typeName' ].'"></center></th><th>';
			echo '<strong>Item name</strong>: '.$row[ 'typeName' ].'<br>';
			if( ( $row[ 'basePrice' ] != NULL ) && ( $row[ 'basePrice' ] != 0 ) )echo '<strong>Base price</strong>: '.$row[ 'basePrice' ].' ISK<br>';
			if( $row[ 'raceID' ] != NULL )echo '<strong>Race</strong>: '.get_race_name( $row[ 'raceID' ] ).'<br>';
			echo '</th></tr>';
			echo '<tr><td colspan=3>';
			if( empty( $row[ 'description' ] ) )echo '<center>No description available for this item</center>';
			else echo '<center>'.$row[ 'description' ].'</center>';
			echo '</td></tr>';
			echo '</table></div>';
		}else{
			echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>The item you\'re looking for doesn\'t exists</center></td></tr></table></div>';
		}
	}else{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>No item selected. Click <a href="?p=">here</a> to go back</center></td></tr></table></div>';
	}

?>