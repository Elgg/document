<?php
	$maxfilesize = $vars['entity']->maxfilesize;
	if (!$maxfilesize) $maxfilesize = (int) 10240; //set the default maximum Document size to 10MB (1024KB * 10 = 10240KB = 10MB)
	
	$num_upload = $vars['entity']->num_upload;
	if (!$num_upload) $num_upload = (int) 5; //set the default maximum Document size to 10MB (1024KB * 10 = 10240KB = 10MB)
		
?>
<p>
	<?php echo elgg_echo('document:settings:maxfilesize'); ?>
	
	<?php echo elgg_view('input/text', array('internalname' => 'params[maxfilesize]', 'value' => $maxfilesize)); ?>
</p>
<p>
	<?php echo elgg_echo('document:num_upload'); ?>
	
	<?php echo elgg_view('input/text', array('internalname' => 'params[num_upload]', 'value' => $num_upload)); ?>
</p>