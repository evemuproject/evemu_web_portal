<?PHP

/***************************************************************************
 CuteNews CutePHP.com
 Copyright (C) 2005 Georgi Avramov  (flexer@cutephp.com)
****************************************************************************/

error_reporting (E_ALL ^ E_NOTICE);

require_once("./inc/functions.inc.php");
//#################

$PHP_SELF                                        = "index.php";
$cutepath                                        = ".";
$config_path_image_upload        = "./data/upimages";

$config_use_cookies = TRUE;  // Use Cookies When Checking Authorization
$config_use_sessions = FALSE;  // Use Sessions When Checking Authorization
$config_check_referer = TRUE; // Set to TRUE for more seciruty
//#################

$Timer = new microTimer;
$Timer->start();

// Check if CuteNews is not installed
$all_users_db = file("./data/users.db.php");
$check_users = $all_users_db;
$check_users[1] = trim($check_users[1]);
$check_users[2] = trim($check_users[2]);
if((!$check_users[2] or $check_users[2] == "") and (!$check_users[1] or $check_users[1] == "")){
    if(!file_exists("./inc/install.mdu")){ die('<h2>Error!</h2>CuteNews detected that you do not have users in your users.db.php file and wants to run the install module.<br>
    However, the install module (<b>./inc/install.mdu</b>) can not be located, please reupload this file and make sure you set the proper permissions so the installation can continue.'); }
    require("./inc/install.mdu");
    die();
}

require_once("./data/config.php");
if(isset($config_skin) and $config_skin != "" and file_exists("./skins/${config_skin}.skin.php")){
        require_once("./skins/${config_skin}.skin.php");
}else{
        $using_safe_skin = true;
        require_once("./skins/default.skin.php");
}

b64dck();
if($config_use_sessions){
@session_start();
@header("Cache-control: private");
}

if($action == "logout")
{
    setcookie("md5_password","");
        setcookie("username","");
        setcookie("login_referer","");

    if($config_use_sessions){
            @session_destroy();
            @session_unset();
            setcookie(session_name(),"");
        }
    msg("info", "Logout", "You are now logged out, <a href=\"$PHP_SELF\">login</a><br /><br>");
}


$is_loged_in = FALSE;
$cookie_logged = FALSE;
$session_logged = FALSE;
$temp_arr = explode("?", $HTTP_REFERER);
$HTTP_REFERER = $temp_arr[0];
if(substr($HTTP_REFERER, -1) == "/"){ $HTTP_REFERER.= "index.php"; }

// Check if The User is Identified


if($config_use_cookies == TRUE){
/* Login Authorization using COOKIES */

if(isset($username))
{
    if(isset($HTTP_COOKIE_VARS["md5_password"])){ $cmd5_password = $HTTP_COOKIE_VARS["md5_password"]; }
    elseif(isset($_COOKIE["md5_password"])){ $cmd5_password = $_COOKIE["md5_password"]; }
    else{ $cmd5_password = md5($password); }


    // Do we have correct username and password ?
    if(check_login($username, $cmd5_password))
    {
        if($action == 'dologin'){
                setcookie("lastusername", $username, time()+1012324305);
                if($rememberme == 'yes'){
                   setcookie("username", $username, time()+60*60*24*30);
                   setcookie("md5_password", $cmd5_password, time()+60*60*24*30);
                }
                else{
                   setcookie("username", $username);
                   setcookie("md5_password", $cmd5_password);
                }
        }

        $cookie_logged = TRUE;

    }else{
                   setcookie("username", FALSE);
                   setcookie("md5_password", FALSE);
        $result = "<font color=red>Wrong username or password</font>";
        $cookie_logged = FALSE;
    }
}
/* END Login Authorization using COOKIES */
}

if($config_use_sessions == TRUE){
/* Login Authorization using SESSIONS */
        if(isset($HTTP_X_FORWARDED_FOR)){ $ip = $HTTP_X_FORWARDED_FOR; }
        elseif(isset($HTTP_CLIENT_IP))        { $ip = $HTTP_CLIENT_IP; }
        if($ip == "")                                    { $ip = $REMOTE_ADDR; }
        if($ip == "")                                        { $ip = "not detected";}

if($action == "dologin")
{
        $md5_password = md5($password);
    if(check_login($username, $md5_password)){
                $session_logged = TRUE;

                @session_register('username');
                @session_register('md5_password');
                @session_register('ip');
                @session_register('login_referer');

                $_SESSION['username']                = "$username";
                $_SESSION['md5_password']         = "$md5_password";
                $_SESSION['ip']                                = "$ip";
                $_SESSION['login_referer']        = "$HTTP_REFERER";

        }else{
                $result = "<font color=red>Wrong username and/or password</font>";
                $session_logged = FALSE;
        }
}elseif(isset($_SESSION['username'])){ // Check the if member is using valid username/password
    if(check_login($_SESSION['username'], $_SESSION['md5_password'])){
        if($_SESSION['ip'] != $ip){ $session_logged = FALSE; $result = "The IP in the session doesn not match with your IP"; }
        else{ $session_logged = TRUE; }
        }else{
                $result = "<font color=red>Wrong username and/or password !!!</font>";
                $session_logged = FALSE;
        }
}

if(!$username){ $username = $_SESSION['username']; }
/* END Login Authorization using SESSIONS */
}

###########################

if($session_logged == TRUE or $cookie_logged == TRUE){
    if($action == 'dologin'){
        //-------------------------------------------
        // Modify the Last Login Date of the user
        //-------------------------------------------
        $old_users_db        = $all_users_db;
        $modified_users = fopen("./data/users.db.php", "w");
        foreach($old_users_db as $old_users_db_line){
           $old_users_db_arr = explode("|", $old_users_db_line);
            if($member_db[0] != $old_users_db_arr[0]){
                    fwrite($modified_users, "$old_users_db_line");
            }else{
                    fwrite($modified_users, "$old_users_db_arr[0]|$old_users_db_arr[1]|$old_users_db_arr[2]|$old_users_db_arr[3]|$old_users_db_arr[4]|$old_users_db_arr[5]|$old_users_db_arr[6]|$old_users_db_arr[7]|$old_users_db_arr[8]|".time()."||\n");
            }
        }
        fclose($modified_users);
        }

        $is_loged_in = TRUE;
}

###########################

// If User is Not Logged In, Display The Login Page
if($is_loged_in == FALSE)
{
    if($config_use_sessions){
            @session_destroy();
            @session_unset();
        }

//    setcookie("username","");
//    setcookie("password","");
//    setcookie("md5_password","");
//    setcookie("login_referer","");

    echoheader("user","Please Login");

    if($config_allow_registration == "yes"){ $allow_reg_status = "<a href='register.php'>(register)</a> "; }else{ $allow_reg_status = ""; }

    echo "
  <table width=\"100%\" border=0 cellpadding=1 cellspacing=0>
     <form  name=login action='$PHP_SELF' method=post>
     <tr>

       <td width=80>Username: </td>
       <td width='160'><input tabindex=1 type=text name=username value='$lastusername' style='width:150;'></td>
       <td>&nbsp;$allow_reg_status</a></td>
      </tr>
      <tr>
       <td>Password: </td>
       <td><input type=password name=password style='width:150'></td>
       <td>&nbsp;<a href='register.php?action=lostpass'>(lost password)</a> </td>
      </tr>
      <tr>

       <td></td>
       <td style='text-align:left'>
          <input accesskey='s' type=submit style=\"width:150; background-color: #F3F3F3;\" value='      Login...      '><br/>
       </td>
       <td style='text-align:left'><label for=rememberme title='Remmber me for 30 days, Do not use on Public-Terminals!'>
         <input id=rememberme type=checkbox value=yes style=\"border:0px;\" name=rememberme>
Remember Me</label> </td>
      </tr>

      <tr>
       <td align=center colspan=4 style='text-align:left;'>$result</td>
      </tr>
     <input type=hidden name=action value=dologin>
     </form>
    </table>";
                     
   echofooter();
}
elseif($is_loged_in == TRUE)
{

//----------------------------------
// Check Referer
//----------------------------------
/*if($config_check_referer == TRUE){
   $self = $_SERVER["SCRIPT_NAME"];
   if($self == ""){ $self = $_SERVER["REDIRECT_URL"]; }
   if($self == ""){ $self = "index.php"; }

   if(!preg_match($self, $HTTP_REFERER) and $HTTP_REFERER != ""){
       die("<h2>Sorry but your access to this page was denied !</h2><br>try to <a href=\"?action=logout\">logout</a> and then login again<br>To turn off this security check, change \$config_check_referer in index.php to FALSE");
   }
}*/
// ********************************************************************************
// Include System Module
// ********************************************************************************
if($_SERVER['QUERY_STRING'] == "debug"){ debug(); }

                            //name of mod   //access
    $system_modules = array('addnews' => 'user',
                            'editnews' => 'user',
                            'main' => 'user',
                            'options' => 'user',
                            'images' => 'user',
                            'editusers' => 'admin',
                            'editcomments' => 'admin',
                            'tools' => 'admin',
                            'ipban' => 'admin',
                            'about' => 'user',
                            'preview' => 'user',
                            'categories' => 'admin',
                            'massactions' => 'user',
                            'help' => 'user',
                            'snr' => 'admin',
                            'debug' => 'admin',
                            'wizards' => 'admin',
                            );


    if($mod == ""){ require("./inc/main.mdu"); }
    elseif( $system_modules[$mod] )
    {
        if(     $member_db[1] == 4 and $mod != 'options'){ msg('error', 'Error!', 'Access Denied for your user-level (commenter)'); }
        elseif( $system_modules[$mod] == "user"){ require("./inc/". $mod . ".mdu"); }
        elseif( $system_modules[$mod] == "admin" and $member_db[1] == 1){ require("./inc/". $mod . ".mdu"); }
        elseif( $system_modules[$mod] == "admin" and $member_db[1] != 1){ msg("error", "Access denied", "Only admin can access this module"); exit; }
        else{   die("Module access must be set to <b>user</b> or <b>admin</b>"); }
    }
    else{       die("$mod is NOT a valid module"); }
}

echo"<!-- execution time: ".$Timer->stop()." -->";
?>