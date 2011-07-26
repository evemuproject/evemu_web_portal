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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?

class cache
{
	var $cache_dir;
	var $cache_time;
	var $caching = false;
	var $cleaning = false;
	var $file = '';

	function start( $path='', $time, $action=NULL )
	{

		global $_SERVER;

		$this->cache_dir = $path;
		$this->cache_time = $time;
		$this->cleaning = $action;
		
		if( isset( $_SESSION[ 'portalUser' ] ) )$this->file = $this->cache_dir."cache_".md5( urlencode( $_SERVER['REQUEST_URI'] ) ).'_'.md5( $_SESSION[ 'portalUser' ] );
		else $this->file = $this->cache_dir."cache_".md5( urlencode( $_SERVER['REQUEST_URI'] ) );

		if ( ( file_exists( $this->file ) ) &&  ( ( fileatime( $this->file ) + $this->cache_time ) > time() ) && ( $this->cleaning == false ) ){

			readfile( $this->file );
			return true;
		} else {
			$this->caching = true;
			
			ob_start();
			return false;
		}
	}

	function end(){
		if ( $this->caching ){
			$data = ob_get_clean();
			echo $data;
		if( file_exists( $this->file ) ){
			unlink( $this->file );
		}
			$fp = fopen( $this->file , 'w' );
			fwrite ( $fp , $data );
			fclose ( $fp );
		}
	}

}

class dbcache
{
	var $cache_file;
	
	function check( $data, $name )
	{
		global $_SERVER;
		
		$this->cache_file = 'cache/db_'.md5( $name );
		if( file_exists( $this->cache_file ) )
		{
			$fp = fopen( $this->cache_file, 'r' );
			$read = fread( $fp, filesize( $this->cache_file ) );
			fclose( $fp );
			if( print_r( $data, true ) == $read )
			{
				if( isset( $_SESSION[ 'portalUser' ] ) )
				{
					$f = "cache/cache_".md5( urlencode( $_SERVER['REQUEST_URI'] ) ).'_'.md5( $_SESSION[ 'portalUser' ] );
					if( file_exists( $f ) )
					{
						readfile( $f );
						return true;
					}else{
						return false;
					}
				}else{
					$f = "cache/cache_".md5( urlencode( $_SERVER['REQUEST_URI'] ) );
					if( file_exists( $f ) )
					{
						readfile( $f );
						return true;
					}else{
						return false;
					}
				}
			}else{
				if( isset( $_SESSION[ 'portalUser' ] ) )
				{
					$f = "cache/cache_".md5( urlencode( $_SERVER['REQUEST_URI'] ) ).'_'.md5( $_SESSION[ 'portalUser' ] );
					if( file_exists( $f ) )
					{
						unlink( $f );
					}
				}else{
					$f = "cache/cache_".md5( urlencode( $_SERVER['REQUEST_URI'] ) );
					if( file_exists( $f ) )
					{
						unlink( $f );
					}
				}
				return false;
			}
		}else{
			$fp = fopen( $this->cache_file, 'w' );
			fwrite( $fp, print_r( $data, true ) );
			fclose( $fp );
			return false;
		}
	}
}

	session_start();
	session_set_cookie_params( 86400 );
?>
<head>
	<title>EveMu Portal</title>
	<?
		$explorer = get_browser( NULL, true );
		if( ( $explorer[ 'browser' ] == 'IE' ) )
		{
		?>
			<link rel="stylesheet" type="text/css" href="ie_style.css">
		<?
		}else if( ( $explorer[ 'browser' ] == 'Chrome' ) || ( $explorer[ 'browser' ] == 'Opera' ) || ( $explorer[ 'browser' ] == 'Safari' ) )
		{
		?>
			<link rel="stylesheet" type="text/css" href="f_style.css">
		<?
		}else{
		?>
			<link rel="stylesheet" type="text/css" href="style.css">
		<?
		}
	?>
	<script type="text/javascript" src="main.js"></script>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
</head>
<?
	function fixed_gethostbyname( $host ) {
		$ip = gethostbyname( $host );
		if ($ip != $host)
		{
			return $ip;
		}
		return false;
	}
	
	include( 'config.php' );
	include( 'func.inc.php' );
	
	if( $portal_on == false )
	{
		echo '<div id="out">The portal is down for maintenance purposes.<br>We will bring it back as soon as posible</div>';
		die();
	}
	timequery();
	
	$connections = initDB();
	
	if( !$connections ) die();
	
	if( !get_account_name( 1 )  )
	{
		echo '<meta http-equiv="refresh" content="0;URL=install.php">';
	}

	$img = new imgCache();
	$icon = new iconCache();
?>
<body>
<br>
	<center>
		<table class=mainframe>
			<tr><th class=weblogo colspan=2><? include( 'logo.php' ); ?></th></tr>
			<tr>
				<td class=webmenu><? include( 'menu.php' ); ?></td>
				<td class=webcontent><? include( 'main.php' ); ?></td>
			</tr>
			<tr><th colspan=2><? include( 'footer.php' ); ?></th></tr>
		</table>
		  <p><a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-html401" alt="Valid HTML 4.01 Transitional" height="31" width="88"></a>
		  <a href="http://jigsaw.w3.org/css-validator/check/referer"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid Cascade Style Sheet"></a></p>
	</center>
</body>
<?
	closeDB( $connections );
?>