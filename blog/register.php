<?PHP



error_reporting (E_ALL ^E_NOTICE);
require_once("./inc/functions.inc.php");
require_once("./data/config.php");
require_once("./skins/${config_skin}.skin.php");



// Check if CuteNews is not installed
$all_users_db = file("./data/users.db.php");
$check_users = $all_users_db;
$check_users[1] = trim($check_users[1]);
$check_users[2] = trim($check_users[2]);
if((!$check_users[2] or $check_users[2] == "") and (!$check_users[1] or $check_users[1] == "")){
    if(!file_exists("./inc/install.mdu")){ die('<h2>Error!</h2>CuteNews detected that you do not have users in your users.db.php file and wants to run the install module.<br>
    However, the install module (<b>./inc/install.mdu</b>) can not be located, please reupload this file and make sure you set the proper permissions so the installation can continue.'); }

        msg("info", "CuteNews Not Installed", "CuteNews is not properly installed (users missing) <a href=index.php>go to index.php</a>");
}


$register_level = $config_registration_level;

if($action == "doregister"){
        if($config_allow_registration != "yes"){  msg("error","Error", "User registration is Disabled"); }
        if(!$regusername){ msg("error","Error !!!", "Username can not be blank"); }
        if(!$regpassword){ msg("error","Error !!!", "Password can not be blank"); }
        if(!$regemail)         { msg("error","Error !!!", "Email can not be blank"); }

    $regusername        = preg_replace( array("'<'", "'>'", "'\n'", "'\r'", "'\|'"), array("", "", "", "", ""), $regusername);
    $regnickname        = preg_replace( array("'<'", "'>'", "'\n'", "'\r'", "'\|'"), array("", "", "", "", ""), $regnickname);
    $regemail           = preg_replace( array("'<'", "'>'", "'\n'", "'\r'", "'\|'"), array("", "", "", "", ""), $regemail);
    $regpassword        = preg_replace( array("'<'", "'>'", "'\n'", "'\r'", "'\|'"), array("", "", "", "", ""), $regpassword);

    if(!preg_match("/^[\.A-z0-9_\-]{1,15}$/i", $regusername)){ msg("error","Error !!!", "$regusername Your username must only contain valid characters, numbers and the symbol '_'"); }
    if(!preg_match("/^[\.A-z0-9_\-]{1,15}$/i", $regnickname)){ msg("error","Error !!!", "Your nickname must only contain valid characters, numbers and the symbol '_'"); }
    if(!preg_match("/^[\.A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $regemail)){ msg("error","Error !!!", "Not valid Email."); }
    if(!preg_match("/^[\.A-z0-9_\-]{1,15}$/i", $regpassword)){ msg("error","Error !!!", "Your password must conatain only valid characters and numbers"); }

    $all_users = file("./data/users.db.php");
    foreach($all_users as $user_line)
    {
                $user_arr = explode("|", $user_line);
        if($user_arr[2] == $regusername){ msg("error", "Error", "This username is already taken"); }
    }

        $add_time = time()+($config_date_adjust*60);
        $regpassword = md5($regpassword);

        $old_users_file = file("./data/users.db.php");
        $new_users_file = fopen("./data/users.db.php", "a");
                fwrite($new_users_file, "$add_time|$register_level|$regusername|$regpassword|$regnickname|$regemail|0|0||||\n");
        fclose($new_users_file);

        if($config_notify_registration == "yes" and $config_notify_status == "active"){
           send_mail("$config_notify_email", "CuteNews - New User Registered", "New user ($regusername) has just registered:\nUsername: $regusername\nNickname: $regnickname\nEmail: $regemail\n ");
        }

        msg("user", "User Added", "You were successfully added to users database.<br>You can now login <a href=index.php>here</a>");


}elseif($action == "lostpass"){

    echoheader("user","Lost Password");

    echo"<form method=post action=\"$PHP_SELF\"><table border=0 cellpading=0 cellspacing=0 width=\"654\" height=\"59\" >
    <td width=\"18\" height=\"11\">
    <td width=\"71\" height=\"11\" align=\"left\">

    Username<td width=\"203\" height=\"11\" align=\"left\">
        <input type=text name=user seize=20>
    <td width=\"350\" height=\"26\" align=\"left\" rowspan=\"2\" valign=\"middle\">
        If the username and email match in our users database,<br> and email with furher instructions will be sent to you.
        <tr>
        <td width=\"18\" valign=\"top\" height=\"15\">
          <td width=\"71\" height=\"15\" align=\"left\">
          Email
          <td width=\"203\" height=\"15\" align=\"left\">

        <input type=text name=email size=\"20\">

        </tr>
        <tr>
          <td width=\"18\" valign=\"top\" height=\"15\">
          <td width=\"628\" height=\"15\" align=\"left\" colspan=\"3\">
          &nbsp;

        </tr>
        <tr>
          <td width=\"18\" valign=\"top\" height=\"15\">
          <td         width=\"628\" height=\"15\" align=\"left\" colspan=\"3\">
          <input type=submit value=\"Send me the Confirmation\">
        </tr>
        <input type=hidden name=action value=validate>
        <input type=hidden name=mod value=lostpass>
        <tr>
        <td width=\"18\" height=\"27\">
        <td width=\"632\" height=\"27\" colspan=\"3\">
        </tr></table></form>";

    echofooter();

}elseif($action == "validate"){

if(!isset($user) or !$user or $user == '' or !isset($email) or !$email or $email == ''){ msg("error", "Error !!!", "All the fields are required"); }

    $found = FALSE;
    $all_users = file("./data/users.db.php");
    foreach($all_users as $user_line){
            $user_arr = explode("|", $user_line);
            if($user_arr[2] == $user and $user_arr[5] == $email){ $sstring = "${user_arr[0]}${user_arr[3]}"; $found = TRUE; break;}
    }
    if(!$found){ msg("error", "Error !!!", "The username/email you enter did not match in our users database"); }
        else{

             $confirm_url = "$config_http_script_dir/register.php?a=dsp&s=$sstring";
             $message = "Hi,\n Someone requested your password to be changed, if this is the desired action and you want to change your password please follow this link: $confirm_url .";


             mail("$email", "Confirmation ( New Password for CuteNews )", $message,
             "From: no-reply@$SERVER_NAME\r\n"
            ."X-Mailer: PHP/" . phpversion()) or die("can not send mail");

             msg('info','Confirmation Email',"A confirmation email was sent, please check your inbox for further details.");
        }


//Do Send Password
}elseif($a == "dsp"){

    if($s == "" or !$s){ msg("error", "Error !!!", "All fields are required"); }
    $found = FALSE;
    $all_users = file("./data/users.db.php");
    foreach($all_users as $user_line){
            $user_arr = explode("|", $user_line);
        if($s == "${user_arr[0]}${user_arr[3]}"){ $found = TRUE; break;}
    }
    if(!$found){ msg("error", "Error !!!", "invalid string"); }
        else{

                $salt = "abchefghjkmnpqrstuvwxyz0123456789";
                srand((double)microtime()*1000000);
                for($i=0;$i<9;$i++){
                        $new_pass .= $salt{rand(0,33)};
                }
        $md5_pass = md5($new_pass);

        $old_db = file("./data/users.db.php");
            $new_db = fopen("./data/users.db.php", w);
            foreach($old_db as $old_db_line){
                $old_db_arr = explode("|", $old_db_line);
                if($s != "${old_db_arr[0]}${old_db_arr[3]}"){
                        fwrite($new_db,"$old_db_line");
                }else{
                        fwrite($new_db,"$old_db_arr[0]|$old_db_arr[1]|$old_db_arr[2]|$md5_pass|$old_db_arr[4]|$old_db_arr[5]|$old_db_arr[6]|$old_db_arr[7]|||\n");
                }
            }
            fclose($new_db);

        $message = "Hi $user_arr[2],\n Your new password for CuteNews is $new_pass, please after you login change this password.";

        mail("$user_arr[5]", "Your New Password for CuteNews", $message,
             "From: no-reply@$SERVER_NAME\r\n"
            ."X-Mailer: PHP/" . phpversion()) or die("can not send mail");


        msg("info", "Password Sent", "The new password for <b> $user_arr[2]</b> was sent to the email.");
    }

}else{
if($config_allow_registration != "yes"){  msg("error","Error", "User registration is Disabled"); }
        echoheader("user", "User Registration");

echo<<<HTML
    <table leftmargin=0 marginheight=0 marginwidth=0 topmargin=0 border=0 height=100% cellspacing=0>
     <form  name=login action="$PHP_SELF" method=post>
     <tr>
       <td width=80>Username: </td>
       <td><input tabindex=1 type=text name=regusername  style="width:134" size="20"></td>
     </tr>
     <tr>
       <td width=80>Nickname: </td>
       <td><input tabindex=1 type=text name=regnickname  style="width:134" size="20"></td>
     </tr>
     <tr>
       <td width=80>Password: </td>
       <td><input tabindex=1 type=text name=regpassword  style="width:134" size="20"></td>
     </tr>
     <tr>
       <td width=80>Email: </td>
       <td><input tabindex=1 type=text name=regemail  style="width:134" size="20"></td>
     </tr>
      <tr>
       <td></td>
       <td ><input accesskey="s" type=submit style="background-color: #F3F3F3;" value='Register'></td>
      </tr>
      <tr>
       <td align=center colspan=2>$result</td>
      </tr>
     <input type=hidden name=action value=doregister>
     </form>
    </table>
HTML;

        echofooter();

}
?>