<?PHP

?>
<html>
<head>
<title>Example</title>
<style>
<!--
        A                         { color: #003366; text-decoration: none; }
        A:link                { color: #003366; text-decoration: none; }
        A:visited        { color: #003366; text-decoration: none; }
        A:active        { color: #54622D;  }
        A:hover        { color: #54622D;  }


BODY,TD,TR{
                font-family: verdana, arial, sans-serif;
                color:#000;
                font-size:11;
                font-weight:normal;
}
.banner {
        font-family: georgia, verdana, arial, sans-serif;
        color:white;
        font-size:x-large;
        font-weight:bold;
        border-left:1px solid #FFF;
        border-right:1px solid #FFF;
        border-top:1px solid #FFF;
        background:#003366;
        padding:7px;
}
.description{
        font-family:verdana, arial, sans-serif;
        font-size:x-small;
        font-weight:bold;
}

//-->
</style>
</head>
<body bgcolor="#ffffff">
<div align="center"><center>
<table border="0" width="700" cellspacing="0" cellpadding="0">
<tr>
        <td class=banner >
        Put here your title<br>
        <span class="description">and this is your description</span>
        </td>
</tr>

<tr>
<td>
 &nbsp;
</center>

 <table border="0" width="100%" cellspacing="0" cellpadding="6">
<tr>
  <td width="180" valign=top style="border-right: 1px dotted #000000;"><table border="0" width=93% cellspacing="0" cellpadding="0">
 <tr>

<td width="100%" style="border-top: 1 solid #000000; border-bottom: 1 solid #000000" bgcolor="#F3F4F5" height="26">
<p align="left">&nbsp;<b><font color="#003366">Navigation</font></b></p>
</td>
 </tr>
 <tr>

<td width="100%">
&nbsp;
</td>
 </tr>
 <tr>

<td width="100%">
&nbsp;<a href="?">main page</a>
</td>
 </tr>
 <tr>

<td width="100%">
&nbsp;<a href="?do=archives">archives</a>
</td>
 </tr>
 <tr>

<td width="100%">
&nbsp;<a href="?do=stats">statistic</a>
</td>
 </tr>
 <tr>

<td width="100%">
&nbsp;<a href="?">other link</a>
</td>
 </tr>
 <tr>

<td width="100%">
&nbsp;<a href="?">other link</a>
</td>
 </tr>
 <tr>

<td width="100%">
&nbsp;
</td>
 </tr>
 <tr>

<td width="100%" style="border-top: 1 solid #000000; border-bottom: 1 solid #000000" bgcolor="#F3F4F5" height="26">
<p align="left">&nbsp;<font color="#003366"><b>Quick search</b></font></p>
</td>
 </tr>
 <tr>

<td width="100%">
</td>
 </tr>
 <tr>
<!-- The Quick Search Form -->
<form method="post">
<td width="100%" align="center">&nbsp;<br>
<input type="text" name="story" size="14">
<input type="hidden" name="do" value="search">
</td>
</form>
<!-- End of the Search Form -->

 </tr>
 <tr>

<td width="100%">
&nbsp;
</td>
 </tr>
 <tr>

<td width="100%" style="border-top: 1 solid #000000; border-bottom: 1 solid #000000" bgcolor="#F3F4F5" height="26">
<p align="left">&nbsp;<b><font color="#003366">banners/sponsors</font></b></p>
</td>
 </tr>
 <center>

<tr>

<td width="100%">
&nbsp;
</td>
</tr>
<tr>

<td width="100%">
&nbsp;put some banners here
</td>
</tr>
<tr>

<td width="100%">
&nbsp;
</td>
</tr>
<tr>

<td width="100%">
&nbsp;and another banners here
</td>
</tr>
<tr>

<td width="100%">
&nbsp;
</td>
</tr>
<tr>

<td width="100%" style="border-top: 1 solid #000000; border-bottom: 1 solid #000000" bgcolor="#F3F4F5" height="26">
<p align="left">&nbsp;<font color="#003366"><b>Friends</b></font></p>
</td>
</tr>
<tr>

<td width="100%">
&nbsp;
</td>
</tr>
<tr>

<td width="100%">
&nbsp;<a href="http://cutephp.com" title="PHP News Content Management System" target="_blank">CutePHP Scripts</a>
</td>
</tr>
<tr>

<td width="100%">
&nbsp;<a href="http://news.google.com" target="_blank">Google News</a>
</td>
</tr>
<tr>

<td width="100%">
&nbsp;<a href="http://mozilla.org" target="_blank">Mozilla.org</a>
</td>
</tr>
  </table>

    <p align="center"><br><br>
    <br>
    <br>
    <br>
    </center>
  </td>
  <td width="520" valign="top" align="center">

<table border="0" width="453" cellspacing="1" cellpadding="3">
<tr>
<td width="441">
<?PHP

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  Here we decide what page to include
 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

if($_POST['do'] == "search" or $_GET['dosearch'] == "yes"){ $subaction = "search"; $dosearch = "yes"; include("./search.php"); }
elseif($_GET['do'] == "archives"){ include("./show_archives.php"); }
elseif($_GET['do'] == "stats"){ echo"You can download the stats addon and include it here to show how many news, comments ... you have"; /* include("$path/stats.php"); */ }
else{ include("./show_news.php"); }

?>
</td>
</tr>
</table>

 </td>
      </tr>
    </table>
    </td>
  </tr>

</table><br><br><center>
<table border=0 width=700 style="border-top: 1px dotted #000000;">
<tr><td>
    <p align="center">put your footer and copyright here

</td></tr></table>
</body>
</html>