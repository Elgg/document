<?php
/**
 * Elgg Document browser
 */
 
global $CONFIG;

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

if (is_callable('group_gatekeeper')) group_gatekeeper();
		
// set up breadcrumbs
$page_owner = page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
	$page_owner = $_SESSION['user'];
	set_page_owner($page_owner->getGUID());
}
elgg_push_breadcrumb(elgg_echo('document:all'), $CONFIG->wwwroot."mod/document/all.php");
elgg_push_breadcrumb(sprintf(elgg_echo("document:user"),$page_owner->name));

//display the top bar
if(page_owner()== get_loggedin_user()->guid){
	$area1 .= elgg_view('page_elements/content_header', array('context' => "mine", 'type' => 'document'));
}elseif(page_owner_entity() instanceof ElggGroup){
	$area1 .= elgg_view('navigation/breadcrumbs');	
	$area1 .= elgg_view('document/groups_document_header');
}else{
	$area1 .= elgg_view('navigation/breadcrumbs');
	$area1 .= elgg_view('page_elements/content_header_member', array('type' => 'document'));
}
		
//display the filter
$area2 .= elgg_view('document/main_filter');
		
//get user filter choice
$filter = get_input("filter");
	
// Get objects
if($filter && $filter != 'all'){
	set_context("search");
	$get_files = list_entities_from_metadata('simpletype', $filter, 'object', 'document', page_owner(), 12, false, false, true);
	if(!$get_files && (page_owner()== get_loggedin_user()->guid)) {
		$get_files = elgg_view('help/document');
	}
	set_context('document');
}else {
	set_context("search");
	$get_files = elgg_list_entities(array('types' => 'object', 'subtypes' => 'document', 'container_guids' => page_owner(), 'limit' => 12, 'full_view' => FALSE, 'view_type_toggle' => FALSE, 'pagination' => TRUE));
	if(!$get_files && (page_owner()== get_loggedin_user()->guid)){
		$get_files = elgg_view('help/document');
	}
	set_context('document');
}
$area2 .= "<div id='documents_list'>" . $get_files . "</div>";

// view for plugins to extend
$area3 .= elgg_view("documents/sidebar", array("object_type" => 'file'));

// fetch & display latest comments on user's docs
$comments = get_annotations(0, "object", "document", "generic_comment", "", 0, 4, 0, "desc",0,0,page_owner());
$area3 .= elgg_view('annotation/latest_comments', array('comments' => $comments));

// tag-cloud display
$area3 .= display_tagcloud(0, 50, 'tags', 'object', 'document', $page_owner->getGUID());
		
$body = elgg_view_layout('one_column_with_sidebar', $area1.$area2, $area3);
	
// Finally draw the page
page_draw(sprintf(elgg_echo("document:user"),page_owner_entity()->name), $body);