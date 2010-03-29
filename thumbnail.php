<?php
/**
* Elgg Document thumbnail
*/

// Get engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Get Document GUID
$file_guid = (int) get_input('file_guid',0);

// Get Document thumbnail size
$size = get_input('size','small');
if ($size != 'small') {
	$size = 'large';
}

// Get Document entity
if ($file = get_entity($file_guid)) {
	
	if ($file->getSubtype() == "document") {
		
		$simpletype = $file->simpletype;
		if ($simpletype == "image") {
			
			// Get Document thumbnail
				if ($size == "small") {
					$thumbfile = $file->smallthumb;
				} else {
					$thumbfile = $file->largethumb;
				}
				
			// Grab the Document
				if ($thumbfile && !empty($thumbfile)) {
					$readfile = new ElggFile();
					$readfile->owner_guid = $file->owner_guid;
					$readfile->setFilename($thumbfile);
					$mime = $file->getMimeType();
					$contents = $readfile->grabFile();
					
					header("Content-type: $mime");
					echo $contents;
					exit;
					
				} 
			
		}
		
	}
	
}

?>