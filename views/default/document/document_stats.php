<?php
/**
 * All site Document stats
 **/

$s = 's';
if (!$count_files = elgg_get_entities(array(
	'types' => 'object',
	'subtypes' => 'document',
	'owner_guids' => 0,
	'limit' => 10,
	'offset' => 0,
	'count' => TRUE,
	'site_guids' => 0,
	'container_guids' => NULL,
	'created_time_upper' => 0,
	'created_time_lower' => 0,
))) {
	$count_files = 'No';
} elseif ($count_files == 1) {
	$s = '';
}

$comments = '';
if ($count_file_comments = count_annotations(0, "object", "document","generic_comment")) {
	$comments = " with $count_file_comments comment";
	
	if ($count_file_comments > 1) {
		$comments .= 's';
	}
}

$stats = elgg_echo('document:stats');
$body = <<<__HTML
<h3>$stats</h3>
<p>$count_files document$s uploaded$comments.</p>
__HTML;

echo $body;
