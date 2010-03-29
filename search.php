<?php
/**
* Elgg Document search
*/

// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");


// Get input
$md_type = 'simpletype';
$tag = get_input('tag');
$search_viewtype = get_input('search_viewtype');

$friends = (int) get_input('friends_guid',0);
if ($friends) {
	if ($owner_guid = get_user_friends($user_guid, $subtype, 999999, 0)) {
		foreach($owner_guid as $key => $friend)
			$owner_guid[$key] = (int) $friend->getGUID();
	} else {
		$owner_guid = array();
	}
} else {
	$owner_guid = get_input('owner_guid',0);
	if (substr_count($owner_guid,',')) {
		$owner_guid = explode(",",$owner_guid);
	}
}
$page_owner = get_input('page_owner',0);
if ($page_owner) { 
	set_page_owner($page_owner);
} else {
	if ($friends) {
		set_page_owner($friends);				
	} else {
		if ($owner_guid > 0 && !is_array($owner_guid))
			set_page_owner($owner_guid);
	}
}

if (is_callable('group_gatekeeper')) group_gatekeeper();

if (empty($tag)) {
	$area2 = elgg_view_title(elgg_echo('document:type:all'));
} else {
	if (is_array($owner_guid)) {
		$area2 = elgg_view_title(elgg_echo("document:friends:type:" . $tag));
	} else if (page_owner() && page_owner() != $_SESSION['guid']) {
		$area2 = elgg_view_title(sprintf(elgg_echo("document:user:type:" . $tag),page_owner_entity()->name));
	} else{
		$area2 = elgg_view_title(elgg_echo("document:type:" . $tag));
	}
}
if ($friends) {
	$area1 = get_filetype_cloud($friends,true);
} else if ($owner_guid) {
	$area1 = get_filetype_cloud($owner_guid);
} else {
	$area1 = get_filetype_cloud();
}

// Set context
set_context('search');

$limit = 10;
if (!empty($tag)) {
	$area2 .= list_entities_from_metadata($md_type, $tag, 'object', 'document', $owner_guid, $limit);
} else {
	$area2 = elgg_list_entities(array('types' => 'object', 'subtypes' => 'document', 'container_guids' => $owner_guid, 'limit' => $limit));

}

set_context("document");

$body = elgg_view_layout('one_column_with_sidebar',$area1.$area2);

page_draw(sprintf(elgg_echo('searchtitle'),$tag),$body);

?>