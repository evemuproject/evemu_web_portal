<?PHP
$skin_prefix = "";
// *********
// Skin MENU
// *********
$skin_menu = <<<HTML
<table cellpadding=8 cellspacing=4 border=0>
<tr>
<td>
<a class="nav" href="$PHP_SELF?mod=main">Home</a>
</td>
<td>|</td>
<td>
<a class="nav" href="$PHP_SELF?mod=addnews&action=addnews">Add News</a>
</td>
<td>|</td>
<td>
<a class="nav" href="$PHP_SELF?mod=editnews&action=list">Edit News</a>
</td>
<td>|</td>
<td>
<a class="nav" href="$PHP_SELF?mod=options&action=options">Options</a>
</td>
<td>|</td>
<td>
<a class="nav" href="$PHP_SELF?mod=about&action=about">Help/About</a>
</td>
<td>|</td>
<td>
<a class="nav" href="$PHP_SELF?action=logout">Logout</a>
</td>
</tr>
</table>
HTML;
// *******************
//  Template -> Header
// *******************
$skin_header=<<<HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<script type="text/javascript" src="skins/cute.js"></script>
<style type="text/css">
<!--
SELECT, option, textarea, input {
BORDER: #000000 1px solid;
COLOR: #000000;
FONT-SIZE: 11px;
FONT-FAMILY: Verdana; BACKGROUND-COLOR: #ffffff
}
BODY {text-decoration: none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt;}
TD {text-decoration: none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt;}
a:active,a:visited,a:link {color: #446488; text-decoration: none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt;}
a:hover {color: #00004F; text-decoration: none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt;}

a.nav { padding-top:3px; padding-bottom:3px; padding:2px;}
a.nav:active, a.nav:visited,  a.nav:link { color: #000000; font-size : 10px; font-weight: bold; font-family: verdana; text-decoration: none;}
a.nav:hover { font-size : 10px; font-weight: bold; color: black; font-family: verdana; background-color:000000; color:FFFFFF}

.bborder        { background-color: #FFFFFF; border: 1px #000000 solid; }
.panel                {-moz-border-radius: .3em .3em .3em .3em; border: 1px dotted #B4D2E7; background-color: #ECF4F9;}
BODY, TD, TR {text-decoration: none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt; cursor: default;}

input[type=submit]:hover, input[type=button]:hover{
background-color:#E0EDF3 !important;
}
-->
</style>
<title>CuteNews</title>
</head>
<body bgcolor="#A5CBDE">
<center>
<table width="565" border="0" cellspacing="0" cellpadding="2">
<tr>
<td class="bborder" bgcolor="#FFFFFF" width="777">
<table border=0 cellpadding=0 cellspacing=0 bgcolor="#ffffff" width="645" >
<tr>
<td width="645" align="center">
{menu}
</td>
</tr>
<tr>
<td bgcolor="#000000" width="802" height="1"><img src="skins/images/blank.gif" width=1 height=1></td>
</tr>
<tr><td bgcolor="#FFFFFF" width="802" height="9"><img src="skins/images/blank.gif" width=1 height=5></td></tr>
<tr>
<td width="802" height="42">
</center>
<table border=0 cellpading=0 cellspacing=10 width="100%" height="100%" >
<tr>
<td width="98%" height="46%">
<!--MAIN area-->
HTML;
// ********************************************************************************
//  Template -> Footer
// ********************************************************************************
$skin_footer=<<<HTML
<!--MAIN area-->
</tr>
</table>
</td>
</tr></table></td></tr></table>
<br /><center>{copyrights}
</body></html>
HTML;
?>