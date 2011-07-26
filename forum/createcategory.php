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

	$admin = false;
	if( isset( $_SESSION[ 'portalUser' ] ) )
	{
		$admin = is_admin( $_SESSION[ 'portalUser' ] ) & isset( $_GET[ 'admin' ] );
	}
	
	if( !$admin )
	{
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>You should be an admin to use this feature</center></td></tr></table></div>';
	}else if( ( isset( $_POST[ 'name' ] ) ) && ( isset( $_POST[ 'description' ] ) ) && ( !empty( $_POST[ 'name' ] ) ) && ( !empty( $_POST[ 'description' ] ) ) ){
		$query = "INSERT INTO forum_categories( id, name, description, priority )VALUES(NULL, '".$_POST[ 'name' ]."', '".$_POST[ 'description' ]."', 1 );";
		$result = @mysql_query( $query, $connections[ 'portal' ] );
		$id = mysql_insert_id ( $connections[ 'portal' ] );
		echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 0, 255, 0 );"><strong>Correct</strong></font></th></tr><tr><td><center>Category created correctly. Click <a href="?p=forum&amp;viewforum='.$id.'&amp;admin">here</a> to go back</center></td></tr></table></div>';
	}else if( ( ( isset( $_POST[ 'name' ] ) ) && ( isset( $_POST[ 'description' ] ) ) ) && ( ( empty( $_POST[ 'name' ] ) ) && ( empty( $_POST[ 'description' ] ) ) ) ){
		'<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>You should enter the category name and the description</center></td></tr></table></div>';
	}else{
?>
<div id="createtopic">
<form action="?p=forum&amp;createcategory&admin" method="POST">
Category name: <input type="text" name="name" maxlength=255/><br />
Description: <br /><textarea name="description" cols=69 rows=15></textarea><br />
<input type="submit" value="Create category" />
</form>
</div>
<?
	}
?>