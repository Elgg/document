<?php
/**
 * Elgg Document browser uploader
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();
if (is_callable('group_gatekeeper')) group_gatekeeper();

// Render the Document upload page
$container_guid = page_owner();
$area2 = elgg_view_title($title = elgg_echo('document:upload'));

// set up breadcrumbs
$page_owner = page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
	$page_owner = $_SESSION['user'];
	set_page_owner($page_owner->getGUID());
}
elgg_push_breadcrumb(elgg_echo('document:all'), $CONFIG->wwwroot."mod/document/all.php");
elgg_push_breadcrumb(sprintf(elgg_echo("document:user"),$page_owner->name), $CONFIG->wwwroot."pg/document/".$page_owner->username);
elgg_push_breadcrumb(sprintf(elgg_echo("document:upload")));
$area1 = elgg_view('navigation/breadcrumbs');

$area2 .= elgg_view("document/forms/multiupload", array('container_guid' => $container_guid));
$area3 .= elgg_view("document/stats");
$body = elgg_view_layout('one_column_with_sidebar', $area1.$area2, $area3);
	
page_draw(elgg_echo("document:upload"), $body);