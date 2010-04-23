<?php
	/**
	 * Elgg edit Document page 
	 */

	global $CONFIG;
	if (isset($vars['entity'])) {
		$title = $vars['entity']->title;
		$description = $vars['entity']->description;
		$tags = $vars['entity']->tags;
	} 
	
?>
<div class="document_edit">
<!-- insert a view for plugins to extend -->
<?php echo elgg_view('documents/options', array('entity' => $vars['entity'])); ?>

<p><label>
	<span class="mime_icon">
	<?php
		// mime type icon
		echo elgg_view("document/icon", array("mimetype" => $vars['entity']->mimetype, 'thumbnail' => $vars['entity']->thumbnail, 'file_guid' => $vars['entity']->guid, 'size' => 'small'));
	?>
	</span>
	<?php echo elgg_echo("title"); ?><br />
	<?php echo elgg_view("input/text", array("internalname" => "title","value" => $title,));?>
</label></p>	
<p class="longtext_inputarea">
	<label><?php echo elgg_echo("description"); ?></label>
	<?php echo elgg_view("input/longtext",array("internalname" => "description","value" => $description,));?>
</p>
<p>
	<label><?php echo elgg_echo("tags"); ?><br />
	<?php echo elgg_view("input/tags", array("internalname" => "tags","value" => $tags,)); ?>
</p>
<?php
	$categories = elgg_view('categories',$vars);
	if (!empty($categories)) {
?>
	<p><?php echo $categories; ?></p>
<?php
	}
?>	
<p><?php
	if (isset($vars['container_guid']))
		echo "<input type='hidden' name='container_guid' value=\"{$vars['container_guid']}\" />";
	if (isset($vars['entity']))
		echo "<input type='hidden' name='file_guid' value=\"{$vars['entity']->getGUID()}\" />";
?></p>
</div>