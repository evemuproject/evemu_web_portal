<?php
	$footer = Configuration::GetValue("footer");
	
	if( empty($footer) )
	{
		?>
			EVEmu portal &copy; EVEmu Portal Team<br>
			<a href="http://forum.evemu.org">Contact us</a> |
			<a href="http://github.com/evemuproject/evemu_web_portal/tree/rewrite">Portal repo</a> |
			<a href="http://github.com/evemuproject/evemu_server">Server repo</a>
		<?php
	}
	else
	{
		echo $footer;
	}
?>