<?PHP


// bad practice, i know
if ($HTTP_SESSION_VARS) {extract($HTTP_SESSION_VARS, EXTR_SKIP);}
if ($_SESSION)          {extract($_SESSION, EXTR_SKIP);}
if ($HTTP_COOKIE_VARS)  {extract($HTTP_COOKIE_VARS, EXTR_SKIP);}
if ($_COOKIE)           {extract($_COOKIE, EXTR_SKIP);}
if ($HTTP_POST_VARS)    {extract($HTTP_POST_VARS, EXTR_SKIP);}
if ($_POST)             {extract($_POST, EXTR_SKIP);}
if ($HTTP_GET_VARS)     {extract($HTTP_GET_VARS, EXTR_SKIP);}
if ($_GET)              {extract($_GET, EXTR_SKIP);}
if ($HTTP_ENV_VARS)     {extract($HTTP_ENV_VARS, EXTR_SKIP);}
if ($_ENV)              {extract($_ENV, EXTR_SKIP);}


//----------------------------------
// Sanitize Variables
//----------------------------------
if( isset($template) and $template != "" and !eregi("^[_a-zA-Z0-9-]{1,}$", $template)){ die("invalid template characters"); }
if( isset($archive) and $archive != "" and !eregi("^[_a-zA-Z0-9-]{1,}$", $archive)){ die("invalid archive characters"); }



if($PHP_SELF == ""){ $PHP_SELF = $_SERVER["PHP_SELF"]; }

$phpversion = @phpversion();

$a7f89abdcf9324b3 = "";

$comm_start_from = htmlspecialchars($comm_start_from);
$start_from = htmlspecialchars($start_from);
$archive = htmlspecialchars($archive);
$subaction = htmlspecialchars($subaction);
$id = htmlspecialchars($id);
$ucat = htmlspecialchars($ucat);

if(is_array($category)){ foreach($category as $ckey=>$cvalue){ $category[$ckey] = htmlspecialchars($category[$ckey]);} }
else{ $category = htmlspecialchars($category); }

$number = htmlspecialchars($number);
$template = htmlspecialchars($template);
$show = htmlspecialchars($show);


$config_version_name = "CuteNews v1.4.6";
$config_version_id = 186;




//----------------------------------
// Some Special Chars
//----------------------------------
$HTML_SPECIAL_CHARS = Array (    // Master array replaced ALWAYS !!!

    '”' => '&#8221;',
    '“' => '&#8220;',
    'œ' => '&#339;',
    '™' => '&#8482;',
    '’' => '&#8217;',
    '‘' => '&#8216;',
    '‰' => '&#8240;',
    '…' => '&#8230;',
    '€' => '&euro;',
    '¡' => '&iexcl;',
    '¢' => '&cent;',
    '£' => '&pound;',
    '¤' => '&curren;',
    '¥' => '&yen;',
    '¦' => '&brvbar;',
    '§' => '&sect;',
    '¨' => '&uml;',
    '©' => '&copy;',
    'ª' => '&ordf;',
    '«' => '&laquo;',
    '¬' => '&not;',
    '­' => '&shy;',
    '®' => '&reg;',
    '¯' => '&macr;',
    '°' => '&deg;',
    '±' => '&plusmn;',
    '²' => '&sup2;',
    '³' => '&sup3;',
    '´' => '&acute;',
    '·' => '&middot;',
    '¸' => '&cedil;',
    '¹' => '&sup1;',
    'º' => '&ordm;',
    '»' => '&raquo;',
    '¼' => '&frac14;',
    '½' => '&frac12;',
    '¾' => '&frac34;',
    '¿' => '&iquest;',
);



///////////////////////////////////////////////////////
// Function:         ResynchronizeAutoArchive
// Description:      Auto-Archives News

function ResynchronizeAutoArchive(){
         global $cutepath, $config_auto_archive, $config_notify_email,$config_notify_archive,$config_notify_status;

 $count_news = count(file("$cutepath/data/news.txt"));
 if($count_news > 1){

         if($config_auto_archive == "yes"){

         $now[year] = date("Y");
         $now[month] = date("n");

         $db_content = file("$cutepath/data/auto_archive.db.php");
         list($last_archived[year], $last_archived[month]) = split("\|", $db_content[0] );


$tmp_now_sum = $now[year] . sprintf("%02d", $now[month]) ;
$tmp_last_sum = (int)$last_archived[year] . sprintf("%02d", (int)$last_archived[month]) ;

         if($tmp_now_sum > $tmp_last_sum){

            $error = FALSE;
            $arch_name = time();
            if(!@copy("$cutepath/data/news.txt","$cutepath/data/archives/$arch_name.news.arch"))          { $error = "Can not copy news.txt from data/ to data/archives"; }
            if(!@copy("$cutepath/data/comments.txt","$cutepath/data/archives/$arch_name.comments.arch"))  { $error = "Can not copy comments.txt from data/ to data/archives"; }


            $handle = fopen("$cutepath/data/news.txt","w") or $error = "Can not open news.txt";
                      fclose($handle);
            $handle = fopen("$cutepath/data/comments.txt","w") or $error = "Can not open comments.txt";
                      fclose($handle);


            $fp = @fopen("$cutepath/data/auto_archive.db.php", "w");
            @flock ($fp,2);

            if(!$errors){ fwrite($fp, $now[year]."|".$now[month]."\n"); }
            else{ fwrite($fp, "0|0|$error\n"); }
            foreach($db_content as $line){
                    @fwrite($fp, $line);
            }

            @flock ($fp,3);
            @fclose($fp);


            if($config_notify_archive == "yes" and $config_notify_status == "active"){
               send_mail("$config_notify_email", "CuteNews - AutoArchive was Performed", "CuteNews has performed the AutoArchive function.\n$count_news News Articles were archived.\n$error");
            }
         }
         }
 }
}

///////////////////////////////////////////////////////
// Function:         ResynchronizePostponed
// Description:      Refreshes the Postponed News file.

function ResynchronizePostponed(){
         global $cutepath,$config_notify_postponed,$config_notify_status,$config_notify_email;
         $all_postponed_db = file("$cutepath/data/postponed_news.txt");
         if(!empty($all_postponed_db)){
             $new_postponed_db = fopen("$cutepath/data/postponed_news.txt", w);
             @flock ($new_postponed_db,2);
             $now_date = time();

             foreach ($all_postponed_db as $p_line){
                 $p_item_db = explode("|",$p_line);
                 if($p_item_db[0] <= $now_date){
                 // Item is old and must be Activated, add it to news.txt


                         $all_active_db = file("$cutepath/data/news.txt");
                         $active_news_file = fopen("$cutepath/data/news.txt", "w");
                         @flock ($active_news_file,2);

                         fwrite($active_news_file,"$p_line");
                         foreach ($all_active_db as $active_line){ fwrite($active_news_file, "$active_line");}
                         @flock ($active_news_file,3);
                         fclose($active_news_file);



            if($config_notify_postponed == "yes" and $config_notify_status == "active"){
               send_mail("$config_notify_email", "CuteNews - Postponed article was Activated", "CuteNews has activated the article '$p_item_db[2]'");
            }

                 }else{
                 // Item is still postponed
                    fwrite($new_postponed_db,"$p_line");
                 }



            }
            @flock ($new_postponed_db,3);
            fclose($new_postponed_db);
         }

}

///////////////////////////////////////////////////////
// Function:         send_mail
// Description:      sends mail ... huh :)

function send_mail($to, $subject, $message){

if(!isset($to) or !$to or $to == ''){   }else{

         $tos = FALSE;
         $to = str_replace(' ', '', $to);
         if(eregi(',', '')){
            $tos = explode(',', $to);
         }

         $from = 'CuteNews@' . $_SERVER['SERVER_NAME'];

         $headers = '';
         $headers .= "From: $from\n";
         $headers .= "Reply-to: $from\n";
         $headers .= "Return-Path: $from\n";
         $headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER['SERVER_NAME'] . ">\n";
         $headers .= "MIME-Version: 1.0\n";
         $headers .= "Content-type: text/plain;\n";
         $headers .= "Date: " . date('r', time()) . "\n";

         if($tos){
            foreach($tos as $my_to){
               @mail($my_to,$subject,$message,$headers);
            }
         }else{ @mail($to,$subject,$message,$headers); }

}
}

///////////////////////////////////////////////////////
// Function:         formatsize
// Description: Format the size of given file

function formatsize($file_size){

    if($file_size >= 1073741824)
            {$file_size = round($file_size / 1073741824 * 100) / 100 . "Gb";}
    elseif($file_size >= 1048576)
            {$file_size = round($file_size / 1048576 * 100) / 100 . "Mb";}
    elseif($file_size >= 1024)
            {$file_size = round($file_size / 1024 * 100) / 100 . "Kb";}
    else{$file_size = $file_size . "b";}

return $file_size;
}

///////////////////////////////////////////////////////
// Class:         microTimer
// Description: calculates the micro time

class microTimer {
    function start() {
        global $starttime;
        $mtime = microtime ();
        $mtime = explode (' ', $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $starttime = $mtime;
    }
    function stop() {
        global $starttime;
        $mtime = microtime ();
        $mtime = explode (' ', $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $endtime = $mtime;
        $totaltime = round (($endtime - $starttime), 5);
        return $totaltime;
    }
}


///////////////////////////////////////////////////////
// Function:         check_login
// Description: Check login information

function check_login($username, $md5_password){
        $result = FALSE;
    $full_member_db = file("./data/users.db.php");
    global $member_db;

    foreach($full_member_db as $member_db_line)
    {
                if(!preg_match("<\?>",$member_db_line)){
                $member_db = explode("|",$member_db_line);
                if(strtolower($member_db[2]) == strtolower($username) && $member_db[3] == $md5_password)
                {
                                $result = TRUE;
                    break;
            }
                }
        }
        return $result;
}

///////////////////////////////////////////////////////
// Function:         cute_query_string
// Description: Format the Query_String for CuteNews purpuses index.php?

function cute_query_string($q_string, $strips, $type="get"){
        foreach($strips as $key){
                $strips[$key] = TRUE;
    }
        $var_value = explode("&", $q_string);

    foreach($var_value as $var_peace){
        $parts = explode("=", $var_peace);
        if($strips[$parts[0]] != TRUE and $parts[0] != ""){
                        if($type == "post"){
                    $my_q .= "<input type=\"hidden\" name=\"".@htmlspecialchars($parts[0])."\" value=\"".@htmlspecialchars($parts[1])."\" />\n";
            }else{
                    $my_q .= "$var_peace&amp;";
                        }
        }
    }

if( substr($my_q, -5) == "&amp;" ){ $my_q = substr($my_q, 0, -5); }

return $my_q;
}

///////////////////////////////////////////////////////
// Function:        Flooder
// Description: Flood Protection Function
function flooder($ip, $comid){
    global $cutepath, $config_flood_time;

    $old_db = file("$cutepath/data/flood.db.php");
    $new_db = fopen("$cutepath/data/flood.db.php", w);
    $result = FALSE;
    foreach($old_db as $old_db_line){
        $old_db_arr = explode("|", $old_db_line);

        if(($old_db_arr[0] + $config_flood_time) > time() ){
                fwrite($new_db, $old_db_line);
                if($old_db_arr[1] == $ip and $old_db_arr[2] == $comid)
            { $result = TRUE; }
        }
    }
    fclose($new_db);
    return $result;
}

////////////////////////////////////////////////////////
// Function:         msg
// Description: Displays message to user

function msg($type, $title, $text, $back=FALSE){
  echoheader($type, $title);
  global $lang;
          echo"<table border=0 cellpading=0 cellspacing=0 width=100% height=100%><tr><td >$text";
    if($back){
                echo"<br><br> <a href=\"$back\">go back</a>";
    }
    echo"</td></tr></table>";
  echofooter();
exit();
}



////////////////////////////////////////////////////////
// Function:         echoheader
// Description: Displays header skin

function echoheader($image, $header_text){
        global $PHP_SELF, $is_loged_in, $config_skin, $skin_header, $lang_content_type, $skin_menu, $skin_prefix, $config_version_name;

    if($is_loged_in == TRUE){ $skin_header = preg_replace("/{menu}/", "$skin_menu", "$skin_header"); }
    else { $skin_header = preg_replace("/{menu}/", " &nbsp; $config_version_name", "$skin_header"); }

    $skin_header = get_skin($skin_header);
    $skin_header = preg_replace("/{image-name}/", "${skin_prefix}${image}", $skin_header);
    $skin_header = preg_replace("/{header-text}/", $header_text, $skin_header);
    $skin_header = preg_replace("/{content-type}/", $lang_content_type, $skin_header);

    echo $skin_header;
}

////////////////////////////////////////////////////////
// Function:         echofooter
// Description: Displays footer skin

function echofooter(){

        global $PHP_SELF, $is_loged_in, $config_skin, $skin_footer, $lang_content_type, $skin_menu, $skin_prefix, $config_version_name;

    if($is_loged_in == TRUE){ $skin_footer = preg_replace("/{menu}/", "$skin_menu", "$skin_footer"); }
    else { $skin_footer = preg_replace("/{menu}/", " &nbsp; $config_version_name", "$skin_footer"); }

    $skin_footer = get_skin($skin_footer);
    $skin_footer = preg_replace("/{image-name}/", "${skin_prefix}${image}", $skin_footer);
    $skin_footer = preg_replace("/{header-text}/", $header_text, $skin_footer);
    $skin_footer = preg_replace("/{content-type}/", $lang_content_type, $skin_footer);

    // Do not remove the Copyrights!
    $skin_footer = preg_replace("/{copyrights}/", "<div style='font-size: 9px'>Powered by <a style='font-size: 9px' href=\"http://cutephp.com/cutenews/\" target=_blank>$config_version_name</a> © 2005  <a style='font-size: 9px' href=\"http://cutephp.com/\" target=_blank>CutePHP</a>.</div>", $skin_footer);

    echo $skin_footer;

}

////////////////////////////////////////////////////////
// Function:         b64dck
// Description: And the duck fly away.
function b64dck(){
    $cr = bd_config('e2NvcHlyaWdodHN9');$shder = bd_config('c2tpbl9oZWFkZXI=');$sfter = bd_config('c2tpbl9mb290ZXI=');
        global $$shder,$$sfter;
    $HDpnlty = bd_config('PGNlbnRlcj48aDE+Q3V0ZU5ld3M8L2gxPjxhIGhyZWY9Imh0dHA6Ly9jdXRlcGhwLmNvbSI+Q3V0ZVBIUC5jb208L2E+PC9jZW50ZXI+PGJyPg==');
    $FTpnlty = bd_config('PGNlbnRlcj48ZGl2IGRpc3BsYXk9aW5saW5lIHN0eWxlPVwnZm9udC1zaXplOiAxMXB4XCc+UG93ZXJlZCBieSA8YSBzdHlsZT1cJ2ZvbnQtc2l6ZTogMTFweFwnIGhyZWY9XCJodHRwOi8vY3V0ZXBocC5jb20vY3V0ZW5ld3MvXCIgdGFyZ2V0PV9ibGFuaz5DdXRlTmV3czwvYT4gqSAyMDA1ICA8YSBzdHlsZT1cJ2ZvbnQtc2l6ZTogMTFweFwnIGhyZWY9XCJodHRwOi8vY3V0ZXBocC5jb20vXCIgdGFyZ2V0PV9ibGFuaz5DdXRlUEhQPC9hPi48L2Rpdj48L2NlbnRlcj4=');

        if(!stristr($$shder,$cr) and !stristr($$sfter,$cr)){ $$shder = $HDpnlty.$$shder; $$sfter = $$sfter.$FTpnlty; }
}
////////////////////////////////////////////////////////
// Function:         CountComments
// Description: Count How Many Comments Have a Specific Article

function CountComments($id, $archive = FALSE){

    global $cutepath;

    if($cutepath == ""){ $cutepath = "."; }
    $result = "0";
    if($archive and ($archive != "postponed" and $archive != "unapproved")){ $all_comments = file("$cutepath/data/archives/${archive}.comments.arch"); }
    else{ $all_comments = file("$cutepath/data/comments.txt"); }

    foreach($all_comments as $comment_line)
    {
                $comment_arr_1 = explode("|>|", $comment_line);
        if($comment_arr_1[0] == $id)
        {
                        $comment_arr_2 = explode("||", $comment_arr_1[1]);
            $result = count($comment_arr_2)-1;

        }
    }

return $result;
}

////////////////////////////////////////////////////////
// Function:         insertSmilies
// Description: insert smilies for adding into news/comments

function insertSmilies($insert_location, $break_location = FALSE, $admincp = FALSE, $wysiwyg = FALSE)
{
    global $config_http_script_dir, $config_smilies;

    $smilies = explode(",", $config_smilies);
        foreach($smilies as $smile)
        {
        $i++; $smile = trim($smile);
              if($admincp){
                    if($wysiwyg){
//                       $advanced_smile = "&lt;img alt=\':$smile:\' src=\'data/emoticons/$smile.gif\' /&gt;";
  //                     $output .= "<a href=# onclick=\"javascript:InsertIntoArea('$insert_location','$advanced_smile'); return false;\"><img style=\"border: none;\" alt=\"$smile\" src=\"$config_http_script_dir/data/emoticons/$smile.gif\" /></a>";
                       $output .= "<a href=# onclick=\"document.getElementById('$insert_location').contentWindow.document.execCommand('InsertImage', false, '$config_http_script_dir/data/emoticons/$smile.gif'); return false;\"><img style=\"border: none;\" alt=\"$smile\" src=\"$config_http_script_dir/data/emoticons/$smile.gif\" /></a>";

                    }
                    else{ $output .= "<a href=# onclick=\"javascript:document.getElementById('$insert_location').value += ' :$smile:'; return false;\"><img style=\"border: none;\" alt=\"$smile\" src=\"$config_http_script_dir/data/emoticons/$smile.gif\" /></a>"; }
              }else{
                    $output .= "<a href=\"javascript:insertext(':$smile:','$insert_location')\"><img style=\"border: none;\" alt=\"$smile\" src=\"$config_http_script_dir/data/emoticons/$smile.gif\" /></a>";
              };
                if( isset($break_location) && (int)$break_location > 0 && $i%$break_location == 0 )
                {
                        $output .= "<br>";
                }else{ $output .= "&nbsp;"; }
    }
        return $output;
}

////////////////////////////////////////////////////////
// Function:         replace_comments
// Description: Replaces comments charactars
function replace_comment($way, $sourse){
    global $HTML_SPECIAL_CHARS, $config_allow_html_in_news, $config_allow_html_in_comments, $config_http_script_dir, $config_smilies;

    $sourse = stripslashes(trim($sourse));

        if($way == "add"){

                $find = array(
                                    "'\"'",
                                        "'\''",
                                        "'<'",
                                        "'>'",
                                        "'\|'",
                                        "'\n'",
                                        "'\r'",
                         );
                $replace = array(
                                    "&quot;",
                                        "&#039;",
                                        "&lt;",
                                        "&gt;",
                                         "&#124;",
                                        " <br>",
                    "",
                         );

    }
    elseif($way == "show"){

                $find = array(
                                        "'\[b\](.*?)\[/b\]'i",
                                        "'\[i\](.*?)\[/i\]'i",
                                        "'\[u\](.*?)\[/u\]'i",
                                        "'\[link\](.*?)\[/link\]'i",
                                        "'\[link=(.*?)\](.*?)\[/link\]'i",

                    "'\[quote=(.*?)\](.*?)\[/quote\]'",
                    "'\[quote\](.*?)\[/quote\]'",
                     );
                $replace = array(
                                        "<strong>\\1</strong>",
                                        "<em>\\1</em>",
                                        "<span style=\"text-decoration: underline;\">\\1</span>",
                                        "<a href=\"\\1\">\\1</a>",
                                        "<a href=\"\\1\">\\2</a>",

                                "<blockquote><div style=\"font-size: 13px;\">quote (\\1):</div><hr style=\"border: 1px solid #ACA899;\" /><div>\\2</div><hr style=\"border: 1px solid #ACA899;\" /></blockquote>",
                                "<blockquote><div style=\"font-size: 13px;\">quote:</div><hr style=\"border: 1px solid #ACA899;\" /><div>\\1</div><hr style=\"border: 1px solid #ACA899;\" /></blockquote>",
                     );

                $smilies_arr = explode(",", $config_smilies);
            foreach($smilies_arr as $smile){
                $smile = trim($smile);
                $find[] = "':$smile:'";
                $replace[] = "<img style=\"border: none;\" alt=\"$smile\" src=\"$config_http_script_dir/data/emoticons/$smile.gif\" />";
            }

    }

$sourse  = preg_replace($find,$replace,$sourse);

           foreach ( $HTML_SPECIAL_CHARS as $key=>$value  ){
                     $sourse = str_replace($key,$value,$sourse);
           }

return $sourse;
}

////////////////////////////////////////////////////////
// Function:         rteSafe
// Description: safe data for the RTE

function rteSafe($strText) {
        //returns safe code for preloading in the RTE
        $tmpString = $strText;

        //convert all types of single quotes
        $tmpString = str_replace(chr(145), chr(39), $tmpString);
        $tmpString = str_replace(chr(146), chr(39), $tmpString);
        $tmpString = str_replace("'", "&#39;", $tmpString);

        //convert all types of double quotes
        $tmpString = str_replace(chr(147), chr(34), $tmpString);
        $tmpString = str_replace(chr(148), chr(34), $tmpString);
//        $tmpString = str_replace("\"", "&quot;", $tmpString); // we are pasting the content within '' quotes so " are valid

        //replace carriage returns & line feeds
        $tmpString = str_replace(chr(10), " ", $tmpString);
        $tmpString = str_replace(chr(13), " ", $tmpString);

        return $tmpString;

}
////////////////////////////////////////////////////////
// Function:         get_skin
// Description: Hello skin!

function get_skin($skin){
         if(!file_exists('./data/reg.php')){ $stts = base64_decode('KHVucmVnaXN0ZXJlZCk='); }
         else{
              include('./data/reg.php');

              if(preg_match('/\\A(\\w{6})-\\w{6}-\\w{6}\\z/', $reg_site_key, $mmbrid)){

                 if(!isset($reg_display_name) or !$reg_display_name or $reg_display_name == ''){
                     $stts = "<!-- (-$mmbrid[1]-) -->";
                 }else{
                     $stts = "<label title='(-$mmbrid[1]-)'>". base64_decode('TGljZW5zZWQgdG86IA==').$reg_display_name.'</label>';
                 }

              }
              else{ $stts = '!'.base64_decode('KHVucmVnaXN0ZXJlZCk=').'!';  }
         }
    $msn = bd_config('c2tpbg==');
    $cr = bd_config('e2NvcHlyaWdodHN9');
    $lct = bd_config('PGRpdiBzdHlsZT0nZm9udC1zaXplOiA5cHgnPlBvd2VyZWQgYnkgPGEgc3R5bGU9J2ZvbnQtc2l6ZTogOXB4JyBocmVmPSJodHRwOi8vY3V0ZXBocC5jb20vY3V0ZW5ld3MvIiB0YXJnZXQ9Il9ibGFuayI+Q3V0ZU5ld3MgMS40LjY8L2E+ICZjb3B5OyAyMDA4IDxhIHN0eWxlPSdmb250LXNpemU6IDlweCcgaHJlZj0iaHR0cDovL2N1dGVwaHAuY29tLyIgdGFyZ2V0PSJfYmxhbmsiPkN1dGVQSFA8L2E+Ljxicj57bC1zdGF0dXN9PC9kaXY+');

    $lct = preg_replace("/{l-status}/", $stts, $lct);

    $$msn = preg_replace("/$cr/", $lct, $$msn);

    return $$msn;
}

////////////////////////////////////////////////////////
// Function:         replace_news
// Description: Replaces news charactars

function replace_news($way, $sourse, $replce_n_to_br=TRUE, $use_html=TRUE){
    global $HTML_SPECIAL_CHARS, $config_allow_html_in_news, $config_allow_html_in_comments, $config_http_script_dir, $config_smilies;
    $sourse = stripslashes($sourse);

    if($way == "show")
    {
                $find= array(

/* 1 */                              "'\[upimage=([^\]]*?) ([^\]]*?)\]'i",
/* 2 */                                        "'\[upimage=(.*?)\]'i",
/* 3 */                                        "'\[b\](.*?)\[/b\]'i",
/* 4 */                                        "'\[i\](.*?)\[/i\]'i",
/* 5 */                                        "'\[u\](.*?)\[/u\]'i",
/* 6 */                                        "'\[link\](.*?)\[/link\]'i",
/* 7 */                                        "'\[color=(.*?)\](.*?)\[/color\]'i",
/* 8 */                                        "'\[size=(.*?)\](.*?)\[/size\]'i",
/* 9 */                                        "'\[font=(.*?)\](.*?)\[/font\]'i",
/* 10 */                                 "'\[align=(.*?)\](.*?)\[/align\]'i",
/* 12 */                                 "'\[image=(.*?)\]'i",
/* 13 */                                 "'\[link=(.*?)\](.*?)\[/link\]'i",

/* 14 */                "'\[quote=(.*?)\](.*?)\[/quote\]'i",
/* 15 */                "'\[quote\](.*?)\[/quote\]'i",

/* 16 */                "'\[list\]'i",
/* 17 */                "'\[/list\]'i",
/* 18 */                "'\[\*\]'i",

                            "'{nl}'",
                       );

                $replace=array(

/* 1 */                                        "<img \\2 src=\"${config_http_script_dir}/skins/images/upskins/images/\\1\" style=\"border: none;\" alt=\"\" />",
/* 2 */                                        "<img src=\"${config_http_script_dir}/skins/images/upskins/images/\\1\" style=\"border: none;\" alt=\"\" />",
/* 3 */                                        "<strong>\\1</strong>",
/* 4 */                                        "<em>\\1</em>",
/* 5 */                                        "<span style=\"text-decoration: underline;\">\\1</span>",
/* 6 */                                        "<a href=\"\\1\">\\1</a>",
/* 7 */                                        "<span style=\"color: \\1;\">\\2</span>",
/* 8 */                                        "<span style=\"font-size: \\1pt;\">\\2</span>",
/* 9 */                                        "<span style=\"font-family: \\1;\">\\2</span>",
/* 10 */                                "<div style=\"text-align: \\1;\">\\2</div>",
/* 12 */                                "<img src=\"\\1\" style=\"border: none;\" alt=\"\" />",
/* 13 */                                "<a href=\"\\1\">\\2</a>",

/* 14 */                                "<blockquote><div style=\"font-size: 13px;\">quote (\\1):</div><hr style=\"border: 1px solid #ACA899;\" /><div>\\2</div><hr style=\"border: 1px solid #ACA899;\" /></blockquote>",
/* 15 */                                "<blockquote><div style=\"font-size: 13px;\">quote:</div><hr style=\"border: 1px solid #ACA899;\" /><div>\\1</div><hr style=\"border: 1px solid #ACA899;\" /></blockquote>",

/* 16 */                                "<ul>",
/* 17 */                                "</ul>",
/* 18 */                                "<li>",

                                            "\n",
                        );

            $smilies_arr = explode(",", $config_smilies);
            foreach($smilies_arr as $smile){
                $smile = trim($smile);
                $find[] = "':$smile:'";
                $replace[] = "<img style=\"border: none;\" alt=\"$smile\" src=\"$config_http_script_dir/data/emoticons/$smile.gif\" />";
            }
    }
    elseif($way == "add"){

                $find = array(
                                        "'\|'",
                                        "'\r'",
                         );
                $replace = array(
                                        "&#124;",
                                        "",
                         );

                if($use_html != TRUE){
                $find[]         = "'<'";
                $find[]         = "'>'";

                        $replace[]         = "&lt;";
                        $replace[]         = "&gt;";
        }
                if($replce_n_to_br == TRUE){
                $find[]         = "'\n'";
                        $replace[]         = "<br>";
        }else{
                $find[]         = "'\n'";
                        $replace[]         = "{nl}";
        }

    }
    elseif($way == "admin"){

                $find = array(
                                        "''",
                                        "'{nl}'",
                    );
                $replace = array(
                                        "",
                                        "\n",
                         );

                //this is for 'edit news' section when we use WYSIWYG
                if(!$replce_n_to_br){$find[] = "'<br>'"; }
                if(!$replce_n_to_br){$replace[] = "\n"; }

    }

$sourse  = preg_replace($find,$replace,$sourse);


           foreach ( $HTML_SPECIAL_CHARS as $key=>$value  ){
                     $sourse = str_replace($key,$value,$sourse);
           }


return $sourse;
}

function bd_config($str){
        return base64_decode($str);
}
?>