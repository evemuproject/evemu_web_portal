<?PHP
///////////////////// TEMPLATE rss /////////////////////
$template_active = <<<HTML
<item>
<title><![CDATA[{title}]]></title>
<link>{rss-news-include-url}?subaction=showfull&amp;id={news-id}&amp;archive={archive-id}</link>
<description><![CDATA[{short-story}]]></description>
<guid isPermaLink="false">{news-id}</guid>
<pubDate>{date}</pubDate>
</item>
HTML;


$template_full = <<<HTML

HTML;


$template_comment = <<<HTML

HTML;


$template_form = <<<HTML

HTML;


$template_prev_next = <<<HTML

HTML;
$template_comments_prev_next = <<<HTML

HTML;
?>
