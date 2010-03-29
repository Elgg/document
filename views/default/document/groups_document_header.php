<?php
/**
* Page header view, when visiting a groups documents
**/
 
$user = page_owner_entity();
$user_name = elgg_view_title($user->name . "'s " . elgg_echo('documents'));
$url = $CONFIG->wwwroot . "pg/document/". $user->username . "/new/";
if(isloggedin())
	$upload_link = "<a href=\"{$url}\" class='action_button'>" . elgg_echo('document:new') . "</a>";
else
	$upload_link = '';
?>
<div id="content_header" class="clearfloat">
	<div class="content_header_title">
		<?php echo $user_name; ?>
	</div>
	<div class="content_header_options">
		<?php echo $upload_link; ?>
	</div>
</div>