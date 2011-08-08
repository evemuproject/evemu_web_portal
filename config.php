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

	/*************************************************
	 * EveMu Portal Configuration file				 *
	 * Edit these values according to your own	 	 *
	 *************************************************/

	/* MySQL connection settings */
	$sql_gameserver_user = "Almamu"; // MYSQL User for gameserver DB
	$sql_gameserver_pass = "966772320"; // MySQL Password for gameserver DB
	$sql_gameserver_host = "localhost"; // MySQL Host for gameserver DB
	$sql_gameserver_db = "eve-incursion"; // Server database name

	/* Portal DB */
	$sql_portal_user = "Almamu"; // MySQL User for portal DB
	$sql_portal_pass = "966772320"; // MySQL Password for portal DB
	$sql_portal_host = "localhost"; // MySQL Host for portal DB
	$sql_portal_db = "eveportal"; // Portal database name

	/* Server config */
	$game_server = "127.0.0.1"; // EVEmu Server
	$game_port = 26000; // EVEmu Server Port
	
	/* Portal config */
	$portal_on = true; // Is the portal openned ?
	
	/* Role */
	$adminRole = 4294967231; // Admin role
	$registerRole = 4294967231; //Default registration role for register script
	
	/* Server version */
	$server_version = "incursion";

?>