<?PHP
include('./data/rss_config.php');

if(!isset($rss_news_include_url) or !$rss_news_include_url or $rss_news_include_url == ''){

    die("The RSS is not configured.<br>Please do this from: <strong>CuteNews > Options > Implementation Wizards > RSS</strong>");

}

header("Content-type: text/xml");

echo"<?xml version=\"1.0\" encoding=\"$rss_encoding\" ?>
<?xml-stylesheet type=\"text/css\" href=\"skins/rss_style.css\" ?>
<rss version=\"2.0\" >
 <channel>
   <title>$rss_title</title>
   <link>$rss_news_include_url</link>
   <language>$rss_language</language>
   <description></description>
<!-- <docs>This is an RSS 2.0 file intended to be viewed in a newsreader or syndicated to another site. For more information on RSS check : http://www.feedburner.com/fb/a/aboutrss</docs> -->
   <generator>CuteNews</generator>
";

if(!$_GET[number] or $_GET[number] == ''){ $number = 10;}else{ $number = $_GET[number];}
if(!$_GET[only_active] or $_GET[only_active] == ''){ $only_active = TRUE;}else{ $only_active = $_GET[only_active];}

$template="rss";
include("show_news.php");


echo"</channel></rss>";
?>