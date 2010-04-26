<?php
/**
* Elgg Document saver
*/

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();

// Render the Document upload page

$file = (int) get_input('file_guid');
if ($file = get_entity($file)) {

	// Set the page owner
	$page_owner = page_owner_entity();
	if ($page_owner === false || is_null($page_owner)) {
		$container_guid = $file->container_guid;
		if (!empty($container_guid))
			if ($page_owner = get_entity($container_guid)) {
				set_page_owner($container_guid->guid);
			}
		if (empty($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}
	}

	if ($file->canEdit()) {
		// set up breadcrumbs
		elgg_push_breadcrumb(elgg_echo('document:all'), $CONFIG->wwwroot."mod/document/all.php");
		elgg_push_breadcrumb(sprintf(elgg_echo("document:user"),$page_owner->name), $CONFIG->wwwroot."pg/document/".$page_owner->username);
		elgg_push_breadcrumb(sprintf(elgg_echo("document:edit")));

		$area1 = elgg_view('navigation/breadcrumbs');
		$area2 = elgg_view_title($title = elgg_echo('document:edit'));
		$area2 .= elgg_view("document/forms/edit",array('entity' => $file));
		$file_acl = get_readable_access_level($file->access_id);
		//display the more options sidebar
		$area3 = elgg_view('document/edit_options', array('file_acl' => $file_acl, 'entity' => $file));
		$body = elgg_view_layout('documents_edit', $area1.$area2, $area3);
		page_draw(elgg_echo("document:upload"), $body);
	}
} else {
	forward();
}

?>