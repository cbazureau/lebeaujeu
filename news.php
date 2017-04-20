<?php 

$json = file_get_contents("../cron-data/news.json");
$obj = json_decode($json);
$html = "";

if(isset($_GET["format"]) && $_GET["format"] == "xml") {

header('Content-Type: application/rss+xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"';
?>
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	>

    <channel>
        <title>Le beau jeu</title>
        <atom:link href="https://lebeaujeu.com/news.php?format=xml" rel="self" type="application/rss+xml" />
        <link>https://lebeaujeu.com/news</link>
        <description>Le beau jeu</description>
        <lastBuildDate><?php echo date("r"); ?></lastBuildDate>
        <language>fr-FR</language>
        <sy:updatePeriod>hourly</sy:updatePeriod>
        <sy:updateFrequency>1</sy:updateFrequency>

<?php
    if(isset($obj->news)) {
        foreach ($obj->news as $news){
            if($news->slack == 'true') {
                $html = $html."<item>\n" .
                        "<title><![CDATA[".$news->title."]]></title>\n" .
                        "<link>".htmlentities($news->link)."</link>\n" .
                        "<pubDate>".date("r",$news->timestamp)."</pubDate>\n<dc:creator><![CDATA[Todo]]></dc:creator>\n";
                foreach ($news->categories as $cat){
                    $html = $html."<category><![CDATA[".$cat."]]></category>\n";
                }
                $html = $html."<description><![CDATA[".substr(trim(str_replace("&nbsp;","",strip_tags($news->description))), 0, 1000)."]]></description>\n</item>\n";
            }
        }
        echo $html;
    }
?>
    </channel>
</rss><?php
} else {
 
    if(isset($obj->news)) {
        foreach ($obj->news as $news){
            $cats = implode(', ',$news->categories);
            if(!empty($cats)) $cats = "(".$cats.")";
            $html = $html."<article><img class='logo' src='".$news->flux->logo."' /><h1>".$news->title."</h1>" .
                    "<h2>".$news->date." - ".$news->flux->name." ".$cats."</h2>" .
                    "<h2><a href='".$news->link."'>".$news->link."</a></h2>" .
                    "<div class='description'><p>".substr(trim(str_replace("&nbsp;","",strip_tags($news->description))), 0, 1000)."</p></div></article>";
        }
    }
    //file_put_contents("toto.txt",$html);
    echo $html;
}
