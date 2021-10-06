<?php
$rows = array();
foreach ($content as $apakek) {
	$rows[] = $apakek;
}
echo '{ "data": ';
$tag = array("<p>", "</p>", "\r", "\n", "\t","<\/p>","<\p>");
$data = str_replace($tag, "", $rows);

print (json_encode($data));
echo ' }';

//echo json_encode($rows);