<?php
/**
* Elgg Document delete
*/

$guid = (int) get_input('document');
if ($file = get_entity($guid)) {
	$container = get_entity($file->container_guid);
	if ($file->canEdit()) {
		
		$thumbnail = $file->thumbnail;
		$smallthumb = $file->smallthumb;
		$largethumb = $file->largethumb;
		if ($thumbnail) {

			$delfile = new ElggFile();
			$delfile->owner_guid = $file->owner_guid;
			$delfile->setFilename($thumbnail);
			$delfile->delete();

		}
		if ($smallthumb) {

			$delfile = new ElggFile();
			$delfile->owner_guid = $file->owner_guid;
			$delfile->setFilename($smallthumb);
			$delfile->delete();

		}
		if ($largethumb) {

			$delfile = new ElggFile();
			$delfile->owner_guid = $file->owner_guid;
			$delfile->setFilename($largethumb);
			$delfile->delete();

		}
		
		if (!$file->delete()) {
			register_error(elgg_echo("document:deletefailed"));
		} else {
			system_message(elgg_echo("document:deleted"));
		}

	} else {
		
		$container = $_SESSION['user'];
		register_error(elgg_echo("document:deletefailed"));
		
	}
	
	forward("pg/document/" . $container->username);

} else {
	
	register_error(elgg_echo("document:deletefailed"));
	forward($_SERVER['HTTP_REFERER']);
	
}