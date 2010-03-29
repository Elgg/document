<?php
/**
 * All site Document stats
 **/
$count_files = elgg_get_entities(array('types' => 'object', 'subtypes' => 'document', 'owner_guids' => 0, 'limit' => 10, 'offset' => 0, 'count' => TRUE, 'site_guids' => 0, 'container_guids' => NULL, 'created_time_upper' => 0, 'created_time_lower' => 0));

$count_file_comments = count_annotations(0, "object", "document","generic_comment");

echo "<h3>".elgg_echo('document:stats')."</h3>";
echo $count_files . " documents uploaded with " . $count_file_comments . " comments.";
