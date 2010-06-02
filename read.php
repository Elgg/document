<?php
/**
* View an individual Document
*/

global $CONFIG;
// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Get the GUID of the entity we want to view
$guid = (int) get_input('guid');
		
// Set variables
$file_acl = '';

// set up breadcrumbs
$page_owner = page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
	$page_owner = $_SESSION['user'];
	set_page_owner($page_owner->getGUID());
}
elgg_push_breadcrumb(elgg_echo('document:all'), $CONFIG->wwwroot."mod/document/all.php");
elgg_push_breadcrumb(sprintf(elgg_echo("document:user"),$page_owner->name), $CONFIG->wwwroot."pg/document/".$page_owner->username);
	
// Get the Document, if possible
if ($file = get_entity($guid)) {
	if ($file->container_guid) {
		set_page_owner($file->container_guid);
	} else {
		set_page_owner($file->owner_guid);
	}
	
	elgg_push_breadcrumb(sprintf($file->title)); // complete breadcrumb with Document title
	$area1 = elgg_view('navigation/breadcrumbs');
	$area2 = elgg_view_entity($file,true);
	$file_acl = get_readable_access_level($file->access_id);

} else {	
	$area2 = elgg_echo('notfound');		
}

// tag-cloud display
$area3 = display_tagcloud(0, 50, 'tags', 'object', 'document', $page_owner->getGUID());
		
$body = elgg_view_layout('one_column_with_sidebar',$area1.$area2, $area3);
page_draw(sprintf(elgg_echo("document:user"),page_owner_entity()->name), $body);