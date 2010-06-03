<?php
/**
 * Elgg Document icons.
 * Displays an icon, depending on its mime type, for a Document.
 * Optionally you can specify a size.
 *
 * Most of these variables don't seem to be used, but are available.
 * @uses string $vars['size'] -
 * @uses string $vars['mimetype']
 * @uses string $vars['thumbnail'] The url to a thumbnail image?
 * @uses string $vars['file_guid']
 */

global $CONFIG;

$size = $vars['size'];
if ($size != 'large') {
	$size = 'small';
}

$entity = get_entity($vars['file_guid']);

$img_url = $entity->getIcon($size);

echo "<img src=\"$img_url\" border=\"0\" />";