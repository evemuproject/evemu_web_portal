	// Dropdown menus stuff
	.cssmenu{
		border-bottom-style: solid;
		border-bottom-width: 1px;
		border-bottom-color: rgb(255, 255, 255);
		/*border:none;
		border:0px;*/
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
		color: rgb(60, 60, 60);
		text-shadow: 0.1em 0.1em 0.05em #333;
		
		background-color: rgb(0, 0, 0);
		background-image: url(<?php echo PortalStyle::GetImageFromStyle("background.jpg"); ?>);
		background-position: center top;
		background-attachment: none;
		background-repeat: no-repeat;
		
		margin: 0;
	}
	
	#footer
	{
		background-color: rgb(0, 0, 0);
		border-top-style: solid;
		border-top-width: 1px;
		border-top-color: rgba(128, 128, 128, 0.35);
		
		height: 75px;
		width: 96%;
		float: left;
	
		margin-top: 18.40%;
		margin-bottom: 0px;
		
		color: rgb(128, 128, 128);
		padding-top: 25px;
		padding-left: 50px;
		
		text-align: left;

	}
	
	#footer a, a:visited
	{
		font: 67.5% 'Lucida Sans Unicode', 'Bitstream Vera Sans', 'Trebuchet Unicode MS', 'Lucida Grande', Verdana, Helvetica, sans-serif;
		font-size:14px;
		font-weight:bold;
		color: rgb(24, 159, 204);
		text-decoration: none;
	}
	
	#footer a:hover
	{
		color: rgb(255, 255, 255);
	}
	
	#error
	{
		text-align: center;
		color: rgb(255, 17, 17);
	}
	
	#content
	{
		background-color: rgba(255, 255, 255, 0.35);
		
		border-style: solid;
		border-width: 10px;
		border-color: rgba(255, 255, 255, 0.35);
		
		/* For IE8 */
		filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99808080, endColorstr=#99808080)";
		
		/* For IE < 8 */
		-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99808080, endColorstr=#99808080)";
		
		background: rgb(238,238,238); /* Old browsers */
		background: -moz-linear-gradient(top,  rgba(238,238,238,1) 0%, rgba(204,204,204,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(238,238,238,1)), color-stop(100%,rgba(204,204,204,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  rgba(238,238,238,1) 0%,rgba(204,204,204,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  rgba(238,238,238,1) 0%,rgba(204,204,204,1) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  rgba(238,238,238,1) 0%,rgba(204,204,204,1) 100%); /* IE10+ */
		background: linear-gradient(top,  rgba(238,238,238,1) 0%,rgba(204,204,204,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eeeeee', endColorstr='#cccccc',GradientType=0 ); /* IE6-9 */
		-moz-background-clip: padding;     /* Firefox 3.6 */
		-webkit-background-clip: padding;  /* Safari 4? Chrome 6? */
		background-clip: padding-box;      /* Firefox 4, Safari 5, Opera 10, IE 9 */
		
		<?php
			if( @(($_GET['p'] != 'forum') && ($_GET['p'] != 'account') && ($_GET['p'] != 'support') &&($_GET['p'] != 'admin')) )
			{
		?>
		margin-top: 1%;
		<?php
			}
			else
			{
		?>
		margin-top: 10%;
		<?php
			}
		?>
		margin-left: 5%;
		margin-right: 5%;
		padding: 10px;
		min-height: 400px;
		
		-moz-box-shadow:0 0 15px rgba(255,255,255,0.3);
		-webkit-box-shadow:0 0 15px rgba(255,255,255,0.3);
		box-shadow:0 0 15px rgba(255,255,255,0.3);
		
		color: rgb(60, 60, 60);
		text-shadow: 0.1em 0.1em 0.05em rgb(255, 255, 255);
	}

	#content a, a:visited
	{
		font: 67.5% 'Lucida Sans Unicode', 'Bitstream Vera Sans', 'Trebuchet Unicode MS', 'Lucida Grande', Verdana, Helvetica, sans-serif;
		font-size:14px;
		color: rgb(24, 159, 204);
		text-decoration: none;
		text-shadow: 0em 0em 0em rgb(0, 0, 0);
		text-transform: uppercase;
		font-weight: bold;
	}
	
	#content a:hover
	{
		color: rgb(255, 255, 255);
		text-shadow: 0.1em 0.1em 0.05em rgb(128, 128, 128);
	}
	
	#content img
	{
		-moz-box-shadow:0 0 15px rgba(0,0,0,0.5);
		-webkit-box-shadow:0 0 15px rgba(0,0,0,0.5);
		box-shadow:0 0 15px rgba(0,0,0,0.5);
	}
	
	#content pre
	{
		background-color: rgb(255, 255, 255);
		border-style: solid;
		border-width: 1px;
		border-color: rgb(0, 0, 0);
		text-shadow: 0em 0em 0em #FFFFFF;
		padding-left: 10px;
		margin-right: 10px;
	}
	
	#content h1
	{
		text-shadow: 0.05em 0.05em 0.05em rgb(128, 128, 128);
	}
	
	#gamebanner
	{
		text-align: center;
		
		border-style: solid;
		border-width: 10px;
		border-color: rgba(255, 255, 255, 0.35);
		background-color: rgba(255, 255, 255, 0.35);
		
		background-image: url(<?php echo PortalStyle::GetImageFromStyle("gamebanner.png"); ?>);
		-moz-background-clip: padding;     /* Firefox 3.6 */
		-webkit-background-clip: padding;  /* Safari 4? Chrome 6? */
		background-clip: padding-box;      /* Firefox 4, Safari 5, Opera 10, IE 9 */
		background-position: center center;
		
		margin-top: 10%;
		margin-left: 5%;
		margin-right: 5%;
		
		min-height: 250px;
		
		overflow: hidden;
		
		-moz-box-shadow:0 0 15px rgba(255,255,255,0.3);
		-webkit-box-shadow:0 0 15px rgba(255,255,255,0.3);
		box-shadow:0 0 15px rgba(255,255,255,0.3);
	}
	
	#tryeve
	{
		background: rgb(238,238,238); /* Old browsers */
		background: -moz-linear-gradient(top,  rgba(238,238,238,1) 0%, rgba(204,204,204,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(238,238,238,1)), color-stop(100%,rgba(204,204,204,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  rgba(238,238,238,1) 0%,rgba(204,204,204,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  rgba(238,238,238,1) 0%,rgba(204,204,204,1) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  rgba(238,238,238,1) 0%,rgba(204,204,204,1) 100%); /* IE10+ */
		background: linear-gradient(top,  rgba(238,238,238,1) 0%,rgba(204,204,204,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eeeeee', endColorstr='#cccccc',GradientType=0 ); /* IE6-9 */
		
		float: right;
		
		padding-left: 5px;
		padding-right: 5px;
		margin-right: 25px;
		color: rgb(17, 17, 17);
		
		-moz-box-shadow:0 0 15px rgba(0, 0, 0,0.8);
		-webkit-box-shadow:0 0 15px rgba(0, 0, 0,0.8);
		box-shadow:0 0 15px rgba(0, 0, 0,0.8);
		
		text-shadow: 0;
	}
	
	#tryeve:hover
	{

		background: rgb(24, 159, 204);
		color: rgb(255, 255, 255);
		
		-moz-box-shadow:0 0 15px rgba(99,182,219,0.8);
		-webkit-box-shadow:0 0 15px rgba(99,182,219,0.8);
		box-shadow:0 0 15px rgba(99,182,219,0.8);
	}