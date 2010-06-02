<?php
/**
 * Elgg Document browser
 * 
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	
if (is_callable('group_gatekeeper')) group_gatekeeper();

//display the top bar
if(isloggedin()) {
	$area1 .= elgg_view('page_elements/content_header', array('context' => "friends", 'type' => 'document'));
}
		
//display the filter
//$area2 .= elgg_view('document/main_filter', array('context' => "friends"));
	
set_context('search');
$area2 .= "<div id='documents_list'>" . list_user_friends_objects(page_owner(), 'document', 10,false, false, true) . "</div>";
set_context('document');
	
// view for plugins to extend
if(isloggedin()) {
	$area3 = elgg_view('documents/sidebar', array('object_type' => "document"));
}

// fetch & display latest comments on friends Documents
$comments = get_annotations(0, "object", "document", "generic_comment", "", 0, 4, 0, "desc");
$area3 .= elgg_view('annotation/latest_comments', array('comments' => $comments));
// tag-cloud display
$area3 .= display_tagcloud(0, 50, 'tags', 'object', 'document');

$body = elgg_view_layout('one_column_with_sidebar', $area1.$area2, $area3);
	
// Finally draw the page
page_draw(sprintf(elgg_echo("document:friends")), $body);