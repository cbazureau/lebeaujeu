<?php 

$json = file_get_contents("https://slack.com/api/channels.list?token=[TOKEN]&exclude_archived=1");
$obj = json_decode($json);
echo "<table style='text-align:left'>";
echo "<thead><tr><th>Channel</th><th>Description</th><th>Nb d'abonnés</th></tr></thead><tbody>";
if($obj->ok) {
    foreach ($obj->channels as $value){
        echo "<tr><td>#".$value->name."</td><td>".$value->purpose->value."</td><td>".$value->num_members."</td></tr>";
    }
}
echo "</tbody></table>";
