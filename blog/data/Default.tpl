<?PHP
///////////////////// TEMPLATE Default /////////////////////
$template_active = <<<HTML
<span style="font-size:7pt;color: #888888">{date}</span><br>
<span style="font-weight:bolder;"><strong>{title}</strong></span><br>
<div style="padding-top:4px;padding-bottom:4px;">{short-story}</div><br>
<div style="float: left">[full-link]More >>[/full-link]</div>  <div style="float: right;">[com-link]{comments-num} Comments[/com-link]</div><br>
<hr style="color: #434343" noshade="noshade" size="1">
HTML;


$template_full = <<<HTML
<span style="font-weight:bolder;"><strong>{title}</strong></span><br>
<span style=" margin: -0.25em 0 0.2em; font-size:90%;color:#a4a4a4; padding:0px;">reported by {author} | {date}</span>
<div style="padding-top:4px;padding-bottom:4px;">{full-story}</div><br>
<hr style="color: #434343" noshade="noshade" size="1">
<br>
HTML;


$template_comment = <<<HTML
<span style=" margin: -0.25em 0 0.2em; font-size:90%;color:#a4a4a4; padding:0px;">by {author} | {date}</span>

<div style="color: white">{comment}</div>

</div>
<br>
<hr style="color: #434343" noshade="noshade" size="1">
<br>
HTML;


$template_form = <<<HTML
<center>
  <table border="0" width="370" cellspacing="0" cellpadding="0" style="color: white; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 7pt;">
    <tr>
      <td width="60">Name:</td>
      <td><input type="text" name="name"></td>
    </tr>
    <tr>
      <td>E-mail:</td>
      <td><input type="text" name="mail"> (optional)</td>
    </tr>
    <tr>
      <td>Smile:</td>
      <td>{smilies}</td>
    </tr>
    <tr>
      <td colspan="2">
      <textarea cols="40" rows="6" id=commentsbox name="comments"></textarea><br />
      <input type="submit" name="submit" value="Add My Comment">
      <input type=checkbox name=CNremember  id=CNremember value=1><label for=CNremember> Remember Me</label> |
  <a href="javascript:CNforget();">Forget Me</a>
      </td>
    </tr>
  </table>
</center>
HTML;


$template_prev_next = <<<HTML
<p align="center">[prev-link]<< Previous[/prev-link] {pages} [next-link]Next >>[/next-link]</p>
HTML;
$template_comments_prev_next = <<<HTML
<p align="center">[prev-link]<< Older[/prev-link] ({pages}) [next-link]Newest >>[/next-link]</p>
HTML;
?>
