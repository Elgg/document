<?php
/**
 * Elgg documents multiple uploader action
 */

global $CONFIG;

gatekeeper();

$not_uploaded = array(); //used to catch Documents which don't upload for some reason
$uploaded = array(); //used to catch Documents which do upload
$counter = 0;
$container_guid = (int) get_input('container_guid', 0);

foreach($_FILES as $key => $uploaded_file) {
	//check there is a Document to upload
	if (!empty($uploaded_file['name'])) {

		//set some variables
		$name = $_FILES[$key]['name'];
		$mime = $_FILES[$key]['type'];

		// Get variables
		$title = get_input("title_$counter");
		$desc = get_input("description_$counter");
		$tags = get_input("tags_$counter");
		$access_id = (int) get_input("access_id_$counter");

		// if no title on new upload, grab uploaded resource name as title
		if (empty($title)) {
			$title = $name;
		}

		// Extract Document from, save to
		$prefix = "documents/";
		$file = new DocumentPluginDoc();
		$filestorename = strtolower(time().$name);
		$file->setFilename($prefix.$filestorename);
		$file->setMimeType($mime);

		$file->originalfilename = $name;

		$file->subtype="document";

		$file->access_id = $access_id;

		$file->open("write");
		$file->write(get_uploaded_file($key));
		$file->close();

		$file->title = $title;
		$file->description = $desc;
		if ($container_guid)
			$file->container_guid = $container_guid;

		// Save tags
		$tags = explode(",", $tags);
		$file->tags = $tags;
		// this is the Document type, ppt, excel, word etc
		$file->simpletype = get_general_file_type($mime);

		// disallowed Documents with this plugin
		if (   $file->simpletype == 'image'
			|| $file->simpletype == 'audio'
			|| $file->simpletype == 'video'
			|| $file->simpletype == 'exe'
			|| $file->simpletype == 'zip') {
			// don't save these Document types, send system error msg
			$result = array_push($not_uploaded, $name);
			$upload_disallowed = sprintf(elgg_echo("document:uploadfailed:disallowed"),$file->simpletype);
			register_error($upload_disallowed);
		} else {
			// success
			$result = $file->save();
			array_push($uploaded, $file->guid);
		}

		if (!$result) {
			// unknown error
			array_push($not_uploaded, $name);
		}

		// increment upload counter
		$counter++;
	}
}

// did any documents fail to upload? display appropriate system messages
if (count($not_uploaded) == 0) {
	system_message(elgg_echo("document:saved"));
} else {
	// if there are errors, let the user know
	$error = elgg_echo("document:uploadfailed") . '<br />';
	foreach($not_uploaded as $file_name){
		$error .= '[' . $file_name . ']<br />';
	}
	register_error($error);
}

// if it was a successful upload, add to river and forward the user back to their Documents
if (count($uploaded)>0) {
	// successful upload
	$container_user = get_entity($container_guid);
	if (function_exists('add_to_river'))
		add_to_river('river/object/document/create','create',$_SESSION['user']->guid,$file->guid);

	forward($CONFIG->wwwroot . "pg/document/" . $container_user->username); //forward to users Documents
} else {
	forward(get_input('forward_url', $_SERVER['HTTP_REFERER'])); //upload failed, forward to previous page
}

?>