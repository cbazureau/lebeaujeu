<?php 

$json = file_get_contents("../cron-data/news.json");
$obj = json_decode($json);

$html = "";
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
