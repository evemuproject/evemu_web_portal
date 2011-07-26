<?PHP

$skin_prefix = "";

// ********************************************************************************
// Skin MENU
// ********************************************************************************

$skin_menu = <<<HTML
        <table cellpadding=5 cellspacing=4 border=0>
        <tr>
    <td>
        <a class="nav" href="$PHP_SELF?mod=main">Home</a>
                </td>
                <td>|</td>
                <td>
        <a class="nav" href="$PHP_SELF?mod=addnews&action=addnews" accesskey="a">Add News</a>
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

// ********************************************************************************
// Skin HEADER
// ********************************************************************************
$skin_header = <<<HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<script type="text/javascript" src="skins/cute.js"></script>
<style type="text/css">
<!--
select, textarea, input {
border: #808080 1px solid;
color: #000000;
font-size: 11px;
font-family: Verdana; BACKGROUND-COLOR: #ffffff }

input[type=submit]:hover, input[type=button]:hover{
background-color:#EBEBEB !important;
}

a:active,a:visited,a:link {color: #446488; text-decoration: none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt;}
a:hover {color: #00004F; text-decoration: none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt; }

a.nav { padding-top:10px; padding-bottom:10px; padding:9px;}
a.nav:active, a.nav:visited,  a.nav:link { color: #000000; font-size : 10px; font-weight: bold; font-family: verdana; text-decoration: none;}
a.nav:hover { font-size : 10px; font-weight: bold; color: black; font-family: verdana; text-decoration: underline; }

.header { font-size : 16px; font-weight: bold; color: #808080; font-family: verdana; text-decoration: none;  }
.bborder        { background-color: #FFFFFF; border: 1px #A7A6B4 solid; }
.panel                {-moz-border-radius: .3em .3em .3em .3em; border: 1px solid silver; background-color: #F7F6F4;}

BODY, TD, TR {text-decoration: none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt; cursor: default;}
-->
</style>
        <title>CuteNews</title>



</head>

<body BgColor=white>
<center>
<table border="0" cellspacing="0" cellpadding="2" >
  <tr>
        <td class="bborder" bgcolor="#FFFFFF" style="-moz-border-radius: .8em .8em .8em .8em;">
<table border=0 cellpadding=0 cellspacing=0 bgcolor="#ffffff" width="745" >
<tr>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
</tr>
<tr>
        <td bgcolor="#000000" ><img src="skins/images/blank.gif" width=1 height=1></td>
</tr>
<tr>
        <td bgcolor="#F7F6F4" >
            {menu}
        </td>
</tr>
<tr>
        <td bgcolor="#000000" ><img src="skins/images/blank.gif" width=1 height=1></td>
</tr>
<tr><td bgcolor="#FFFFFF" ><img src="skins/images/blank.gif" width=1 height=5></td></tr>
<tr>
        <td >
</center>
<!--SELF-->
<table border=0 cellpading=0 cellspacing=0 width="100%" height="100%" >
<td width="13%" height="55%">
  <p align="center"><br /><img border="0" src="skins/images/{image-name}.gif" >
<td width="87%" height="20%">
<div class=header>{header-text}</div>
<tr>
<td width="13%" height="26%">
<td width="87%" height="46%">
<!--MAIN area-->
HTML;

// ********************************************************************************
// Skin FOOTER
// ********************************************************************************
$skin_footer = <<<HTML
         <!--MAIN area-->
        <img border=0 height=10 src="skins/images/blank.gif"></tr>
        </table>
        <!--/SELF-->
                </td>
        </tr></table></td></tr></table>
    <br /><center>{copyrights}
    </body></html>
HTML;

?>