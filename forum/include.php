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
	
	if( isset( $_GET[ 'viewforum' ] ) )include( "forum/viewforum.php" );
	else if( isset( $_GET[ 'createtopic' ] ) )include( "forum/createtopic.php" );
	else if( isset( $_GET[ 'viewtopic' ] ) )include( "forum/viewtopic.php" );
	else if( isset( $_GET[ 'reply' ] ) )include( "forum/reply.php" );
	else if( isset( $_GET[ 'report' ] ) )include( "forum/report.php" );
	else if( isset( $_GET[ 'edit' ] ) )include( "forum/edit.php" );
	else if( isset( $_GET[ 'deleteforum' ] ) )include( "forum/deleteforum.php" );
	else if( isset( $_GET[ 'delete' ] ) )include( "forum/delete.php" );
	else if( isset( $_GET[ 'deletetopic' ] ) )include( "forum/deletetopic.php" );
	else if( isset( $_GET[ 'createcategory' ] ) )include( "forum/createcategory.php" );
	else if( isset( $_GET[ 'sticktopic' ] ) )include( "forum/sticktopic.php" );
	else if( isset( $_GET[ 'locktopic' ] ) )include( "forum/locktopic.php" );
	else if( isset( $_GET[ 'reports' ] ) )include( "forum/reports.php" );
	else if( isset( $_GET[ 'viewpost' ] ) )include( "forum/viewpost.php" );
	else if( isset( $_GET[ 'deletereport' ] ) )include( "forum/deletereport.php" );
	else include( "forum/index.php" );

?>