<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
/*ensure that our ajax was posted successfully into the following variables*/
if(isset($_POST['num'])) $num = $_POST['num'];
if(isset($_POST['username'])) $username = $_POST['username'];

//get contents of our twitter stream
$twitter_raw = file_get_contents('http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=' . $username);

$twitter = array();

$twitter_xml = new SimpleXMLElement($twitter_raw);
foreach($twitter_xml->channel->item as $item) {
	//replace 'johnernaut' with your username if you'd like to remove it from the description
	$description = trim(str_replace('johnernaut:', '', $item->description));
	$twitter_item = array(
		'content' => $description,
		'date' => strtotime($item->pubDate),
		'type' => 'Twitter'
	);
	array_push($twitter, $twitter_item);
}

$t_index = 0;
$count = 0;
$twitter_final = array();
//logic to only display defined number of tweets
while($count < $num) {
	if(isset($twitter[$t_index])) {
		array_push($twitter_final, $twitter[$t_index]);
		$t_index++;
	} else {
		throw new Exception("nope");
	}
	$count++;
}
//the quick, dirty way to display our tweets in a somewhat useable format
foreach($twitter_final as $item) {
	echo '<li>' . $item["content"]
. '<a href="#">' . date(DATE_RFC822, $item["date"]) . '</a>'
	. '</li>';
}