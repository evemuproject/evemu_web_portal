	// Dropdown menus stuff
	.cssmenu{
		border:none;
		border:0px;
		margin:0px;
		padding:0px;
		font: 67.5% 'Lucida Sans Unicode', 'Bitstream Vera Sans', 'Trebuchet Unicode MS', 'Lucida Grande', Verdana, Helvetica, sans-serif;
		font-size:14px;
		font-weight:bold;
	}
	.cssmenu ul
	{
		background:#333333;
		height:35px;
		list-style:none;
		margin:0;
		padding:0;
	}
	.cssmenu li
	{
		float:left;
		padding:0px;
	}
	.cssmenu li a
	{
		background: rgba(51, 51, 51, 0.35) bottom right no-repeat;
		color:#cccccc;
		display:block;
		font-weight:normal;
		line-height:35px;
		margin:0px;
		padding:0px 25px;
		text-align:center;
		text-decoration:none;
	}
	.cssmenu li a:hover, .cssmenu ul li:hover a
	{
		background: rgba(37, 128, 162, 0.35) bottom center no-repeat;
		color:#FFFFFF;
		text-decoration:none;
	}
	
	.cssmenu li ul
	{
		background: rgba(51, 51, 51, 0.35);
		display:none;
		height:auto;
		padding:0px;
		margin:0px;
		border:0px;
		position:absolute;
		width:225px;
		z-index:200;
		/*top:1em;
		/*left:0;*/
	}
	.cssmenu li:hover ul
	{
		display:block;
		
	}
	.cssmenu li li
	{
		background:url('images/sub_sep.gif') bottom left no-repeat;
		display:block;
		float:none;
		margin:0px;
		padding:0px;
		width:225px;
	}
	.cssmenu li:hover li a
	{
		background:none;
		
	}
	.cssmenu li ul a
	{
		display:block;
		height:35px;
		font-size:12px;
		font-style:normal;
		margin:0px;
		padding:0px 10px 0px 15px;
		text-align:left;
	}
	.cssmenu li ul a:hover, .cssmenu li ul li:hover a
	{
		background: rgba(37, 128, 162, 0.35) center left no-repeat;
		border:0px;
		color:#ffffff;
		text-decoration:none;
	}
	
	.cssmenu p
	{
		clear:left;
	}	
		
	body
	{
		font-family: Century Gothic, Verdana, Arial, Helvetica, sans-serif;
		font-size: 10pt;
		color: rgb(255, 255, 255);
		background-color: rgb(17, 17, 17);
		text-shadow: 0.1em 0.1em 0.05em #333;
		background-image: url(<?php echo PortalStyle::GetImageFromStyle("background.jpg"); ?>);
		background-position: center top;
		background-attachment: none;
		background-repeat: no-repeat;
		margin: 0;
	}