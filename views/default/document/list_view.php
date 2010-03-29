<?php
/**
 * Elgg Documents list view.
 */

global $CONFIG;
	
$file = $vars['entity'];
if ($file) {
	$file_guid = $file->getGUID();
	$tags = $file->tags;
	$title = $file->title;
	$desc = $file->description;
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = friendly_time($vars['entity']->time_created);
	$file_type = $file->simpletype;
	$mime = $file->mimetype;
	//sort out the access level for display
	$object_acl = get_readable_access_level($file->access_id);
		
	// metadata block, - access level, edit, delete, + options view extender
	$info = "<div class='entity_metadata'><span class='access_level'>" . $object_acl . "</span>";

	// view for plugins to extend	
	$info .= elgg_view('documents/options', array('entity' => $file));
					
	// include edit and delete options
	if ($file->canEdit()) {
		$info .= "<span class='entity_edit'><a href=\"{$vars['url']}mod/document/edit.php?file_guid={$file_guid}\">" . elgg_echo('edit') . "</a></span>";
		$info .= "<span class='delete_button'>" . elgg_view('output/confirmlink',array('href' => $vars['url'] . "action/document/delete?file=" . $file->getGUID(), 'text' => elgg_echo("delete"),'confirm' => elgg_echo("document:delete:confirm"),)). "</span>";  
	}
	$info .= "</div>";
		
	$info .= "<p class='entity_title'><a href=\"{$file->getURL()}\">{$title}</a></p>";
			
	$info .= "<p class='entity_subtext'><a href=\"{$vars['url']}pg/document/{$owner->username}\">{$owner->name}</a> {$friendlytime}";
	// get the number of comments
	$numcomments = elgg_count_comments($file);
	if ($numcomments) {
		$info .= ", <a href=\"{$file->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a>";
	}
	$info .= "</p>";
	$icon = elgg_view("profile/icon",array('entity' => $owner, 'size' => 'small'));
	$icon = "<a href=\"{$file->getURL()}\">" . elgg_view("document/icon", array("mimetype" => $mime, 'thumbnail' => $file->thumbnail, 'file_guid' => $file_guid, 'size' => 'small')) . "</a>";
		
	//display
	echo elgg_view_listing($icon, $info);
		
}else {	
	echo "<p class='margin_top'>".elgg_echo('document:none')."</p>";
}