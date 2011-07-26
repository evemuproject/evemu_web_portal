<html>
<head><title>Example1</title></head>
<body>

<a href="?go=news">news</a> ||
<a href="?go=headlines">headlines</a> ||
<a href="?go=archives">arhcives</a> ||
<a href="?go=search">search</a> ||
<a style="font-size:120%" href="example2.php">See Advanced Example >></a>

<hr>


<?PHP
error_reporting (E_ALL ^ E_NOTICE);

if($_GET['go'] == "" or $_GET['go'] == "news"){
   include("show_news.php");
}
elseif($_GET['go'] == "headlines"){
   $template = "Headlines";
   include("show_news.php");
}
elseif($_GET['go'] == "archives"){
   include("show_archives.php");
}
elseif($_GET['go'] == "search"){
   include("search.php");
}
?>



</body>
</html>