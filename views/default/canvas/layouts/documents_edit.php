<?php
/**
 * Elgg individual Document edit page
 */
 
global $CONFIG;
$page_owner = page_owner_entity();	
?>
<form action="<?php echo $vars['url']; ?>action/document/save" enctype="multipart/form-data" method="post">
<?php echo elgg_view('input/securitytoken'); ?>

<div id="elgg_content" class="clearfloat sidebar">
	<div id="elgg_sidebar">
		<?php 
			echo elgg_view('page_elements/owner_block'); 
			if (isset($vars['area2'])) echo $vars['area2']; 
			if (isset($vars['area3'])) echo $vars['area3'];	
		?>
	</div>
	
	<div id="elgg_page_contents" class="clearfloat">
		<?php 
			if (isset($vars['area1'])) echo $vars['area1'];
		?>
	</div>
</div>

</form>
