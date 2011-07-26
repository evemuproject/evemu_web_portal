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

function isempty( str )
{
	if( str == "" ) return false;
	for( i = 0; i < str.length; i++ )
	{
		if( str.charAt( i ) != " " )
		{
			return false;
		}
	}
	return true;
}

function switchMenu()
{
	div = document.getElementById( 'haccount' );
	div.style.display = ( div.style.display == 'none' ) ? 'block' : 'none';
}

function setCookie( c_name, value, expiredays )
{
	var exdate = new Date();
	exdate.setDate( exdate.getDate() + expiredays );
	document.cookie = c_name + "=" + escape( value ) + ( ( expiredays == null ) ? "" : ";expires=" + exdate.toUTCString() );
}

function getCookie( c_name )
{
	if( document.cookie.length > 0 )
	{
		c_start = document.cookie.indexOf( c_name + "=" );
		if( c_start != -1 )
		{
			c_start = c_start + c_name.length + 1;
			c_end = document.cookie.indexOf( ";", c_start );
			if( c_end == -1 ) c_end = document.cookie.length;
			return unescape( document.cookie.substring( c_start, c_end ) );
		}
	}
	return "";
}

function load_post( e_name )
{
	var b_open = 0;
	var s_open = 0;
	var u_open = 0;
	var i_open = 0;
	var red_open = 0;
	var green_open = 0;
	var orange_open = 0;
	var image_open = 0;
	var left_open = 0;
	var right_open = 0;
	var center_open = 0;
	var quote_open = 0;
	var h2_open = 0;

	element = document.getElementById( e_name );

	var text = element.innerHTML;

	while( text.indexOf( '[b]' ) != -1 )
	{
		text = text.replace( '[b]', '<strong>' );
		b_open += 1;
	}

	while( text.indexOf( '[/b]' ) != -1 )
	{
		if( b_open > 0 )
		{
			text = text.replace( '[/b]', '</strong>' );
			b_open -= 1;
		}
	}

	while( text.indexOf( '[s]' ) != -1 )
	{
		text = text.replace( '[s]', '<s>' );
		s_open += 1;
	}

	while( text.indexOf( '[/s]' ) != -1 )
	{
		if( s_open > 0 )
		{
			text = text.replace( '[/s]', '</s>' );
			s_open -= 1;
		}
	}

	while( text.indexOf( '[u]' ) != -1 )
	{
		text = text.replace( '[u]', '<u>' );
		u_open += 1;
	}

	while( text.indexOf( '[/u]' ) != -1 )
	{
		if( u_open > 0 )
		{
			text = text.replace( '[/u]', '</u>' );
			u_open -= 1;
		}
	}

	while( text.indexOf( '[i]' ) != -1 )
	{
		text = text.replace( '[i]', '<i>' );
		u_open += 1;
	}

	while( text.indexOf( '[/i]' ) != -1 )
	{
		if( u_open > 0 )
		{
			text = text.replace( '[/i]', '</i>' );
			u_open -= 1;
		}
	}

	while( text.indexOf( '[red]' ) != -1 )
	{
		text = text.replace( '[red]', '<font color="red">' );
		red_open += 1;
	}

	while( text.indexOf( '[/red]' ) != -1 )
	{
		if( red_open > 0 )
		{
			text = text.replace( '[/red]', '</font>' );
			red_open -= 1;
		}
	}

	while( text.indexOf( '[green]' ) != -1 )
	{
		text = text.replace( '[green]', '<font color="green">' );
		green_open += 1;
	}

	while( text.indexOf( '[/green]' ) != -1 )
	{
		if( green_open > 0 )
		{
			text = text.replace( '[/green]', '</font>' );
			green_open -= 1;
		}
	}

	while( text.indexOf( '[orange]' ) != -1 )
	{
		text = text.replace( '[orange]', '<font color="orange">' );
		orange_open += 1;
	}

	while( text.indexOf( '[/orange]' ) != -1 )
	{
		if( orange_open > 0 )
		{
			text = text.replace( '[/orange]', '</font>' );
			orange_open -= 1;
		}
	}

	while( text.indexOf( '[img]' ) != -1 )
	{
		text = text.replace( '[img]', '<img src="' );
		image_open += 1;
	}

	while( text.indexOf( '[/img]' ) != -1 )
	{
		if( image_open > 0 )
		{
			text = text.replace( '[/img]', '" />' );
			image_open -= 1;
		}
	}

	while( text.indexOf( '[center]' ) != -1 )
	{
		text = text.replace( '[center]', '<div style="text-align: center">' );
		center_open += 1;
	}


	while( text.indexOf( '[/center]' ) != -1 )
	{
		if( center_open > 0 )
		{
			text = text.replace( '[/center]', '</div>' );
			center_open -= 1;
		}
	}

	while( text.indexOf( '[left]' ) != -1 )
	{
		text = text.replace( '[left]', '<div style="text-align: left">' );
		left_open += 1;
	}


	while( text.indexOf( '[/left]' ) != -1 )
	{
		if( left_open > 0 )
		{
			text = text.replace( '[/left]', '</div>' );
			left_open -= 1;
		}
	}

	while( text.indexOf( '[right]' ) != -1 )
	{
		text = text.replace( '[right]', '<div style="text-align: right">' );
		right_open += 1;
	}


	while( text.indexOf( '[/right]' ) != -1 )
	{
		if( right_open > 0 )
		{
			text = text.replace( '[/right]', '</div>' );
			right_open -= 1;
		}
	}

	while( text.indexOf( '[quote]' ) != -1 )
	{
		text = text.replace( '[quote]', 'Quote: <div id="quote">' );
		quote_open += 1;
	}
	
	while( text.indexOf( '[/quote]' ) != -1 )
	{
		if( quote_open > 0 )
		{
			text = text.replace( '[/quote]', '</div>' );
			quote_open -= 1;
		}
	}

	while( text.indexOf( '[h2]' ) != -1 )
	{
		text = text.replace( '[h2]', '<h2>' );
		h2_open += 1;
	}
	
	while( text.indexOf( '[/h2]' ) != -1 )
	{
		if( h2_open > 0 )
		{
			text = text.replace( '[/h2]', '</h2>' );
			h2_open -= 1;
		}
	}
	
	while( b_open > 0 )
	{
		text += '</strong>';
		b_open -= 1;
	}
	
	while( s_open > 0 )
	{
		text += '</s>';
		s_open -= 1;
	}
	
	while( u_open > 0 )
	{
		text += '</u>';
		u_open -= 1;
	}
	
	while( i_open > 0 )
	{
		text += '</i>';
		i_open -= 1;
	}
	
	while( h2_open > 0 )
	{
		text += '</h2>';
		h2_open -= 1;
	}
	
	while( ( red_open > 0 ) || ( green_open > 0 ) || ( orange_open > 0 ) )
	{
		text += '</font>';
		if( red_open > 0 )red_open -= 1;
		else if( green_open > 0 )green_open -= 1;
		else if( orange_open > 0 )orange_open -= 1;
	}
	
	while( ( center_open > 0 ) || ( left_open > 0 ) || ( right_open > 0 ) || ( quote_open > 0 ) )
	{
		text += '</div>';
		if( code_open > 0 ) code_open -= 1;
		else if( left_open > 0 ) left_open -= 1;
		else if( right_open > 0 ) right_open -= 1;
		else if( quote_open > 0 ) quote_open -= 1;
	}
	
	while( image_open > 0 )
	{
		text += '">';
		image_open -= 1;
	}
	

	element.innerHTML = text;
	
}