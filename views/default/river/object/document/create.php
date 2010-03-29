<?php

$performed_by = get_entity($vars['item']->subject_guid);
$object = get_entity($vars['item']->object_guid);
$url = $object->getURL();
$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
$title = $object->title;
if(!$title)
 $title = 'an untitled document';

$string = "<div class='river_content_title'>" . sprintf(elgg_echo("document:river:created"),$url) . " <a href=\"{$object->getURL()}\">" . $title . "</a> <span class='river_item_time'>" . friendly_time($object->time_updated) . "</span></div>";

//show the Document type icon with title
$filetype = get_general_file_type($object->mimetype);
echo $string;