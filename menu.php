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
<div id="menu">
	<ul>
		<li><a href="?p=" title="Home">Home</a></li>
		<li><a href="?p=forum" title="Forum">Forum</a></li>
	</ul>
</div>
<div id="dmenu">
	<ul>
		<li><a href="javascript:switchMenu();" title="Account Management">Account management</a></li>
	</ul>
</div>
<div id="haccount" style="display: none;" >
	<ul>
		<? if( !isset( $_SESSION[ 'portalUser' ] ) )
		{
		?>
			<li><a href="?p=login" title="Login">Login</a></li>
			<li><a href="?p=register" title="Registration">Register</a></li>
		<?
		}else{
		?>
			<li><a href="?p=logout" title="Logout">Logout</a></li>
			<li><a href="?p=itemlist" title="Item list">Item list</a></li>
			<li><a href="?p=characterinfo" title="Character Info">Character Info</a></li>
		<?
		}
		
		if( ( isset( $_SESSION[ 'portalRole' ] ) ) && ( $_SESSION[ 'portalRole' ]  == $adminRole ) )
		{
		?>
			<li><a href="?p=admin" title="Adminisrtation">Administration</a></li>
			<li><a href="blog" title="News management">News management</a></li>
		<?
		}
		?>
		<li><a href="?p=userlist" title="Player list">Registered players</a></li>
	</ul>
</div>
<? include('content/status.php'); ?>