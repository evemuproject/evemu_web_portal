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
?>