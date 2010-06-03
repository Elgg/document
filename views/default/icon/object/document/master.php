<?php
/**
 * Display a video's icon.
 */

$entity = elgg_get_array_value('entity', $vars, NULL);
$size = 'master';

if ($entity) {
	echo document_get_entity_icon_url($entity, $size);
}