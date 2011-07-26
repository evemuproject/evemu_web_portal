<?PHP

error_reporting (E_ALL ^ E_NOTICE);

$cutepath =  __FILE__;
$cutepath = preg_replace( "'\\\show_archives\.php'", "", $cutepath);
$cutepath = preg_replace( "'/show_archives\.php'", "", $cutepath);

require_once("$cutepath/inc/functions.inc.php");
require_once("$cutepath/data/config.php");
if(!isset($template) or $template == "" or strtolower($template) == "default"){ require_once("$cutepath/data/Default.tpl"); }
else{
        if(file_exists("$cutepath/data/${template}.tpl")){ require("$cutepath/data/${template}.tpl"); }

    else{ die("Error!<br>the template <b>".htmlspecialchars($template)."</b> does not exists, note that templates are case sensetive and you must write the name exactly as it is"); }
}

// Prepare requested categories
if(eregi("[a-z]", $category)){
        die("<b>Error</b>!<br>CuteNews has detected that you use \$category = \"".htmlspecialchars($category)."\"; but you can call the categories only with their <b>ID</b> numbers and not with names<br>
    example:<br><blockquote>&lt;?PHP<br>\$category = \"1\";<br>include(\"path/to/show_archives.php\");<br>?&gt;</blockquote>");
}
$category = preg_replace("/ /", "", $category);
$tmp_cats_arr = explode(",", $category);
foreach($tmp_cats_arr as $key=>$value){
    if($value != ""){ $requested_cats[$value] = TRUE; }
}


if($archive == "" or !$archive){
        $news_file = "$cutepath/data/news.txt";
        $comm_file = "$cutepath/data/comments.txt";
}elseif(is_numeric($archive)){
        $news_file = "$cutepath/data/archives/$archive.news.arch";
        $comm_file = "$cutepath/data/archives/$archive.comments.arch";
}else{
        die("Archive varialbe is invalid");
}

if($subaction == "" or !isset($subaction)){
                $user_query = cute_query_string($QUERY_STRING, array("start_from", "archive", "subaction", "id", "ucat"));

        if(!$handle = opendir("$cutepath/data/archives")){ die("<center>Can not open directory $cutepath/data/archives "); }
        while (false !== ($file = readdir($handle))) {
                        $file_arr = explode(".",$file);
                        if($file != "." and $file != ".." and $file_arr[1] == "news"){
                                $arch_arr[] = $file_arr[0];
                        }
                }
        closedir($handle);

        if(is_array($arch_arr)){
                $arch_arr = array_reverse($arch_arr);
                foreach($arch_arr as $arch_file){

                                $news_lines = file("$cutepath/data/archives/$arch_file.news.arch");
                                $count = count($news_lines);
                                $last = $count-1;
                                $first_news_arr = explode("|", $news_lines[$last]);
                                $last_news_arr        = explode("|", $news_lines[0]);

                                $first_timestamp = $first_news_arr[0];
                                $last_timestamp         = $last_news_arr[0];

                                echo"<a href=\"$PHP_SELF?archive=$arch_file&subaction=list-archive&$user_query\">".date("d M Y",$first_timestamp) ." - ". date("d M Y",$last_timestamp).", (<b>$count</b>)</a><br />";
                }
                }
}
else{

if( $CN_HALT != TRUE and $static != TRUE and ($subaction == "showcomments" or $subaction == "showfull" or $subaction == "addcomment") and ((!isset($category) or $category == "") or $requested_cats[$ucat] == TRUE) ){
    if($subaction == "addcomment"){ $allow_add_comment        = TRUE; $allow_comments = TRUE; }
    if($subaction == "showcomments") $allow_comments = TRUE;
        if(($subaction == "showcomments" or $allow_comments == TRUE) and $config_show_full_with_comments == "yes") $allow_full_story = TRUE;
        if($subaction == "showfull") $allow_full_story = TRUE;
        if($subaction == "showfull" and $config_show_comments_with_full == "yes") $allow_comments = TRUE;

}
else{
    if($config_reverse_active == "yes"){ $reverse = TRUE; }
        $allow_active_news = TRUE;
}
require("$cutepath/inc/shows.inc.php");

}
unset($template, $requested_cats, $reverse, $in_use, $archive, $archives_arr, $number, $no_prev, $no_next, $i, $showed, $prev, $used_archives);
?>
<!-- News Powered by CuteNews: http://cutephp.com/ -->