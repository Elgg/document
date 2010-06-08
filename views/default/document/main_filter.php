<?php
/**
 * Elgg Document-type filter bar
 */
 
global $CONFIG;
$page_owner = page_owner_entity();
 
$correct_context = $vars['context']; // so we know if the user is looking at their own, everyone's or all friends
if($page_owner == $_SESSION['user']) {
 	$owner = true;
} else {
 	$owner = false;
}	
?>

<div id="mime_type_filter" class="clearfloat">
<?php
	//get all available Document categories
	$file_cat = file_categories();
	//get those Document categories with actual Documents
	if($correct_context != 'everyone') {
		$types = elgg_get_tags(array(
			'threshold' => 0,
			'limit' => 10,
			'tag_names' => array('simpletype'),
			'type' => 'object',
			'subtype' => 'document',
			'container_guids' => $page_owner->guid
		));
	} else {
		$types = elgg_get_tags(array(
			'threshold' => 0,
			'limit' => 10,
			'tag_names' => array('simpletype'),
			'type' => 'object',
			'subtype' => 'document'
		));
	}
	//set some variables
	$selected = get_input('filter');
	$select_class = '';
	// if landing on view home (all site Documents, all your Documents etc)
	if($selected == 'all' || $selected == null) {
		$select_all = 'selected';
		$selected = "all";
	} else {
		$select_all = '';
	}
	
	echo "<a href=\"{$current_url}?filter=all\" class='contains_files $select_all'><img src=\"". $CONFIG->wwwroot . "mod/document/graphics/icons/all.png\" class='mime_icon'/></a>";
		
	//loop through the available Document categories and display the correct filter if not looking at friends
	//displaying friends Documents does not yet support filtering
	if($correct_context != 'friends'){
		foreach($file_cat as $fc){
			//set this variable each loop
			$contains_files = '';
			//set the selected Document category
			if($selected == $fc)$select_class = 'selected';
			else $select_class = '';			
			//set a class on those categories that have Documents
			foreach($types as $t){
				if($t->tag == $fc)$contains_files = 'contains_files';
			}
			//display		
			echo "<a href=\"{$current_url}?filter={$fc}\" class='$contains_files $select_class'><img src=\"". $CONFIG->wwwroot . "mod/document/graphics/icons/{$fc}.png\" class='mime_icon'/></a>";
		}
	}
?>
</div>