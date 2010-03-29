<?php
/**
 * Elgg Document browser - shared
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

//get the shared access collection
$sac = get_input('sac');

// Get the current page's owner
$page_owner = page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
	$page_owner = $_SESSION['user'];
	set_page_owner($_SESSION['guid']);
}

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('document:all'), $CONFIG->wwwroot."mod/document/all.php");
elgg_push_breadcrumb(sprintf(elgg_echo("document:sharedaccess")));
$area1 = elgg_view('navigation/breadcrumbs');
	
$area1 .= elgg_view_title(elgg_echo("document:sharedaccess"));
	
// display the page content filter
$area1 .= elgg_view('document/main_filter');
	
set_context("search");
$get_files = list_entities_from_access_id($sac, "object", "document", 0, 10, false, false,true);
if($get_files != "") {
	$area2 = $get_files;
} else {
	$area2 = "<p class='margin_top'>".elgg_echo('document:none')."</p>";
}
set_context('document');

// include a view for plugins to extend
$area3 .= elgg_view("documents/sidebar", array("object_type" => 'document'));

// get the latest comments on user's Documents
$comments = get_annotations(0, "object", "document", "generic_comment", "", 0, 4, 0, "desc",0,0,page_owner());
$area3 .= elgg_view('annotation/latest_comments', array('comments' => $comments));
		
$body = elgg_view_layout('one_column_with_sidebar', $area1.$area2, $area3);
	
// Finally draw the page
page_draw(sprintf(elgg_echo("document:sharedaccess")), $body);
