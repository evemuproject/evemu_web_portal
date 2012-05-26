<?php
	// Some useful functions
	function mysql_fetch_full_result_array( $result )
	{
		$table_result = array();
		$r = 0;
		
		while( $row = mysql_fetch_assoc( $result ) )
		{
			$arr_row = array();
			$c = 0;
			
			while ( $c < mysql_num_fields( $result ) )
			{       
				$col = mysql_fetch_field( $result, $c );   
				$arr_row[ $col -> name ] = $row[ $col -> name ];           
				$c++;
			}   
			
			$table_result[ $r ] = $arr_row;
			$r++;
		}   
		
		return $table_result;
	}
	
	function CheckGameServerStatus($server, $port)
	{
		$status = @fsockopen($server, $port, $ERROR_NO, $ERROR_STR, (float)0.5);
		
		if($status)
		{
			fclose($status);
			return true;
		}
		
		return false;
	}
	
	function userInput($string)
	{
		if(get_magic_quotes_gpc())
		{
			$string = stripslashes($string);
		}
		
		if(phpversion() >= '4.3.0')
		{
			$string = mysql_real_escape_string($string);
		}
		else
		{
			$string = mysql_escape_string($string);
		}
		
		return $string;
	}
?>