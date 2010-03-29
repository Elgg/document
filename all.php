<?php
/**
 * Elgg Document browser - view all site Documents
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// get any input passed	
$limit = get_input("limit", 10);
$offset = get_input("offset", 0);
$tag = get_input("tag");
	
// Get the current page's owner
$page_owner = page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
	$page_owner = $_SESSION['user'];
	set_page_owner($_SESSION['guid']);
}
		
// display the top bar
if(isloggedin()) {
	$area1 = elgg_view('page_elements/content_header', array('context' => "everyone", 'type' => 'document'));
}
		
// display the filter
$area2 .= elgg_view('document/main_filter', array('context' => "everyone"));
		
// get user filter choice
$filter = get_input("filter");
	
// Get objects
if($filter && $filter != 'all'){
	set_context("search");
	$area2 .= "<div id='documents_list'>" . list_entities_from_metadata("simpletype", $filter, "object", "document", 0, 12, false, false, true) . "</div>";
	set_context('document');
}else {
	set_context("search");
	$area2 .= "<div id='documents_list'>" . elgg_list_entities(array('types' => 'object', 'subtypes' => 'document', 'owner_guid' => 0, 'limit' => 12, 'full_view' => FALSE, 'view_type_toggle' => FALSE, 'pagination' => TRUE)) . "</div>";
	set_context('document');
}

// include a view for plugins to extend
$area3 .= elgg_view("documents/sidebar", array("object_type" => 'document'));

// get the latest comments on all Documents
$comments = get_annotations(0, "object", "document", "generic_comment", "", 0, 4, 0, "desc");
$area3 .= elgg_view('annotation/latest_comments', array('comments' => $comments));

// include stats
$area3 .= elgg_view("document/document_stats");
	
$body = elgg_view_layout('one_column_with_sidebar', $area1.$area2, $area3);

// draw the page
page_draw(sprintf(elgg_echo("document:all")), $body);