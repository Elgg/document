<?php
/**
* Elgg Document browser download action.
*/

// Get the guid
$file_guid = get_input("file_guid");

// Get the Document
$file = new DocumentPluginDoc($file_guid);

if ($file){
	$mime = $file->getMimeType();
	if (!$mime) $mime = "application/octet-stream";
	
	$filename = $file->originalfilename;
	// IE download issue when in SSL mode, fix
	header("Pragma: public");
	header("Content-type: $mime");
	if (strpos($mime, "image/")!==false)
		header("Content-Disposition: inline; filename=\"$filename\"");
	else
		header("Content-Disposition: attachment; filename=\"$filename\"");

	$contents = $file->grabFile();
	$splitString = str_split($contents, 8192);
	foreach($splitString as $chunk)
		echo $chunk;
	exit;
}
else
	register_error(elgg_echo("document:downloadfailed"));
?>