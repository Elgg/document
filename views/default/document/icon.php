<?php
	/**
	 * Elgg Document icons.
	 * Displays an icon, depending on its mime type, for a Document. 
	 * Optionally you can specify a size.
	 */

	global $CONFIG;
	
	$mime = $vars['mimetype'];
	if (isset($vars['thumbnail'])) {
		$thumbnail = $vars['thumbnail'];
	} else {
		$thumbnail = false;
	}
	
	$size = $vars['size'];
	if ($size != 'large') {
		$size = 'small';
	}

	if (!empty($mime) && elgg_view_exists("document/icon/{$mime}")) {
		echo elgg_view("document/icon/{$mime}", $vars);
	} else if (!empty($mime) && elgg_view_exists("document/icon/" . substr($mime,0,strpos($mime,'/')) . "/default")) {
		echo elgg_view("document/icon/" . substr($mime,0,strpos($mime,'/')) . "/default", $vars);
	} else {
		echo "<img src=\"". elgg_view('document/icon/default',$vars) ."\" border=\"0\" />";
	} 

?>
