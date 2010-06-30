<?php
// Latest Documents on group home page

//check to make sure this groups Documents has been activated
if($vars['entity']->documents_enable != 'no'){

?>
<div class="group_tool_widget documents">
<span class="group_widget_link"><a href="<?php echo $vars['url'] . "pg/document/" . page_owner_entity()->username; ?>"><?php echo elgg_echo('link:view:all')?></a></span>
<h3><?php echo elgg_echo("document:group"); ?></h3>

<?php
	$files = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'document',
		'container_guid' => $vars['entity']->getGUID(),
		'limit' => 6
	));

	//if there are some Documents, go get them
	if ($files) {

			//display in list mode
			foreach($files as $f){

				$mime = $f->mimetype;
				echo "<div class='entity_listing clearfloat'>";
				echo "<div class='entity_listing_icon'><a href=\"{$f->getURL()}\">" . elgg_view("document/icon", array("mimetype" => $mime, 'thumbnail' => $f->thumbnail, 'file_guid' => $f->guid)) . "</a></div>";
				echo "<div class='entity_listing_info'>";
				echo "<p class='entity_title'><a href=\"{$f->getURL()}\">" . $f->title . "</a></p>";
				echo "<p class='entity_subtext'>" . friendly_time($f->time_created) . "</p>";
				echo "</div></div>";

			}


		//get a link to the users Documents
		$users_file_url = $vars['url'] . "pg/document/" . page_owner_entity()->username;

	} else {

		$upload_document = $vars['url'] . "pg/document/" . page_owner_entity()->username . "/new/";
		echo "<p class='margin_top'><a href=\"{$upload_document}\">" . elgg_echo("document:upload") . "</a></p>";

	}

?>
</div>

<?php
	}//end of activate check statement
?>