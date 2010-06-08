<?php
/**
 * Elgg Documents.
 * Document renderer.
 * 
 * @package Document
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.com/
 */

global $CONFIG;

$file = $vars['entity'];

//get required info
$file_guid = $file->getGUID();
$tags = $file->tags;
$title = $file->title;
$desc = $file->description;
$owner = $vars['entity']->getOwnerEntity();
$friendlytime = friendly_time($vars['entity']->time_created);
$file_type = $file->simpletype;
$mime = $file->mimetype;

//for search results, get the correct layout
if (get_context() == "search") {
	echo elgg_view("document/list_view", array("entity" => $file));
} else {
	
	//set the title
	if($file->title) {
		$pagetitle = elgg_view_title($file->title);
	} else {
		$pagetitle = elgg_view_title(elgg_echo('document:untitled'));
	}
	?>
	<div id="content_header" class="clearfloat">
	<div class="content_header_title"><h2><?php echo $owner->name; ?>'s Files</h2></div>
	<?php
	if ($vars['entity']->canEdit()) {
	?>
	<div class="content_header_options">
	<a class="action_button" href="<?php echo $vars['url']; ?>mod/document/edit.php?file_guid=<?php echo $vars['entity']->getGUID(); ?>"><?php echo elgg_echo('document:edit'); ?></a>
	<?php 
		echo elgg_view('output/confirmlink',array(	
				'href' => $vars['url'] . "action/document/delete?file=" . $vars['entity']->getGUID(),
				'text' => elgg_echo("delete"),
				'confirm' => elgg_echo("document:delete:confirm"),
				'class' => "action_button disabled"));  
	echo "</div>";
	}
	?>
	</div>
	
	
	<div class="document_header clearfloat" id="content_header">
	<?php
		// view for plugins to extend
		echo elgg_view("documents/options",array('entity' => $file));
	?>
	<div class="content_header_title"><?php echo $pagetitle; ?></div>
	</div>
				
	<div class="entity_listing document singleview clearfloat">
		<div class="entity_listing_icon">
			<?php echo elgg_view("profile/icon",array('entity' => $owner, 'size' => 'tiny')); ?>
		</div>
		
		<div class="entity_listing_info">
		<?php 
			// get access-level for display
			$object_acl = get_readable_access_level($vars['entity']->access_id);
			echo "<div class='entity_metadata'><span class='access_level'>" . $object_acl . "</span></div>";
		?>
		<p class="entity_subtext">
			<a href="<?php echo $vars['url']; ?>pg/document/<?php echo $owner->username; ?>"><?php echo $owner->name; ?></a> 
		<?php 
			echo $friendlytime;
			// get & display number of comments
    		$num_comments = elgg_count_comments($vars['entity']);
	    ?>
	    	<br /><a href="<?php echo $url; ?>"><?php echo sprintf(elgg_echo("comments")) . " (" . $num_comments . ")"; ?></a>
		</p>
		</div>
	</div>
	
	<div class="document_details clearfloat">
		<?php
		// display document description
		if (!empty($desc)) {
			echo "<p class='margin_none'>". strip_tags($desc)."</p>";
		}
	
		// display any tags for the Document
		if (!empty($tags)) {
			echo "<p class='tags margin_none'>";
			echo elgg_view('output/tags',array('value' => $tags));
			echo "</p>";
		}
	?>
		<p class="margin_top"><a class="action_button download" href="<?php echo elgg_add_action_tokens_to_url($vars['url'] . "action/document/download?file_guid=$file_guid"); ?>"><?php echo elgg_view("document/icon", array("mimetype" => $mime, 'thumbnail' => $file->thumbnail, 'file_guid' => $file_guid, 'size' => 'small')) . elgg_echo("document:download"); ?></a></p>
	</div>
	<div class="divider"></div>
	<?php
	if ($vars['full']) {
		// include comments
		echo elgg_view_comments($file);
	}
	
}//end of search check

?>
