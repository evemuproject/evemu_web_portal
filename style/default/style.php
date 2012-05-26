	/* Dropdown navigation menu */
	#nav
	{
		list-style:none;
		font-weight:bold;
		margin-bottom:10px;
		/* Clear floats */
		float:left;
		width:100%;
		/* Bring the nav above everything else--uncomment if needed.
		position:relative;
		z-index:5;
		*/
	}

	#nav li
	{
		float:left;
		margin-right:10px;
		position:relative;
	}

	#nav a
	{
		display:block;
		padding:5px;
		color:#fff;
		background:#333;
		text-decoration:none;
	}

	#nav a:hover
	{
		color:#fff;
		background:#6b0c36;
		text-decoration:underline;
	}

	/*--- DROPDOWN ---*/
	#nav ul
	{
		background:#fff; /* Adding a background makes the dropdown work properly in IE7+. Make this as close to your page's background as possible (i.e. white page == white background). */
		background:rgba(255,255,255,0); /* But! Let's make the background fully transparent where we can, we don't actually want to see it if we can help it... */
		list-style:none;
		position:absolute;
		left:-9999px; /* Hide off-screen when not needed (this is more accessible than display:none;) */
	}

	#nav ul li
	{
		padding-top:1px; /* Introducing a padding between the li and the a give the illusion spaced items */
		float:none;
	}

	#nav ul a
	{
		white-space:nowrap; /* Stop text wrapping and creating multi-line dropdown items */
	}

	#nav li:hover ul
	{ /* Display the dropdown on hover */
		left:0; /* Bring back on-screen when needed */
	}

	#nav li:hover a
	{ /* These create persistent hover states, meaning the top-most link stays 'hovered' even when your cursor has moved down the list. */
		background:#6b0c36;
		text-decoration:underline;
	}

	#nav li:hover ul a
	{ /* The persistent hover state does however create a global style for links even before they're hovered. Here we undo these effects. */
		text-decoration:none;
	}

	#nav li:hover ul li a:hover
	{ /* Here we define the most explicit hover states--what happens when you hover each individual link. */
		background:#333;
	}
	body
	{
		background-image: url(<?php echo PortalStyle::GetImageFromStyle("background.jpg"); ?>);
	}