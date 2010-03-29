<?php
	/**
	 * This Document displays the access level, edit/delete buttons and other options on an individual Document
	 **/
	 
	global $CONFIG;
	
	//grab some values
	$file_acl = $vars['file_acl'];
	$file = $vars['entity'];
	
	//display the access level
	echo elgg_echo('document:access') . ": <br /><span><b>$file_acl</b></span>";
	//if the user can edit this Document, show the edit and delete links
	if ($file->canEdit()) {
?>
		<a href="<?php echo $vars['url']; ?>mod/document/edit.php?file_guid=<?php echo $file->getGUID(); ?>" class='submit_button'><?php echo elgg_echo('document:edit'); ?></a> 
		<?php 
			echo elgg_view('output/confirmlink',array(	
				'href' => $vars['url'] . "action/document/delete?file=" . $file->getGUID(),
				'text' => elgg_echo("delete"),
				'confirm' => elgg_echo("document:delete:confirm"),
				'class' => "cancel_button",));  
		?>
<?php		
	}
?>		