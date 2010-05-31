<?php

$performed_by = get_entity($vars['item']->subject_guid);
$object = get_entity($vars['item']->object_guid);
$is_group = get_entity($object->container_guid);
$url = $object->getURL();
$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
$title = $object->title;
if(!$title)
 $title = 'an untitled document';
$string = sprintf(elgg_echo("document:river:created"),$url) . " <a href=\"{$object->getURL()}\">" . $title . "</a>";
if(($is_group instanceof ElggGroup) && (get_context() != 'groups')){
	$string .= " " . elgg_echo('document:ingroup') . " <a href=\"{$is_group->getURL()}\">" . $is_group->name . "</a>";
}
$string .= " <span class='entity_subtext'>" . friendly_time($object->time_created) . "</span>";
if (isloggedin()){
	$string .= "<a class='river_comment_form_button link'>Comment</a>";
	$string .= elgg_view('likes/forms/link', array('entity' => $object));
}

//show the Document type icon with title
$filetype = get_general_file_type($object->mimetype);
echo $string;