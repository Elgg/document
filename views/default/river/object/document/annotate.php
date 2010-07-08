<?php

	$statement = $vars['statement'];
	$performed_by = $statement->getSubject();
	$object = $statement->getObject();
	
	$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$string = sprintf(elgg_echo("document:river:annotate"),$url) . " ";
	$string .= "<a href=\"" . $object->getURL() . "\">" . elgg_echo("document:river:item") . "</a><span class='entity_subtext'>". friendly_time($object->time_created) ."<a class='river_comment_form_button link'>Comment</a>";
	$string .= elgg_view('likes/forms/link', array('entity' => $object));
	$string .= "</span>";

	echo $string; 
	
?>