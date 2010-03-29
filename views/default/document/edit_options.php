<?php
/**
* display/edit current documents access level when editing a document
**/
 
global $CONFIG;

$file_acl = $vars['file_acl'];
$file = $vars['entity'];
//get the users default access level as a readable string
$user = get_user($file->owner_guid);
//get the users default access level
if (false === ($default_access = $user->getPrivateSetting('elgg_default_access'))) {
	$default_access = get_default_access();
}
$user_acl = get_readable_access_level($default_access);

//access level for current Document
echo "<div class='access_settings'><span class='current_settings'>".elgg_echo('document:access') . ": <span>$file_acl</span></span>";
?>
<span class="change_access">
<?php echo elgg_echo('access:change'); ?>:
<?php 
	//if it is a group, pull out the group access view
	$is_group = get_entity($file->container_guid);
	if($is_group instanceof ElggGroup){
		$options = group_access_options($is_group);
	}else{
		$options = '';
	} 
	echo elgg_view('input/access', array('internalname' => 'access_id','value' => $file->access_id, 'options' => $options));
?>
</span>
<?php
// default access level for users content
echo "<span class='current_access'>" . elgg_echo('document:useraccess') . " is: <span>" . $user_acl . "</span></span>";
// save edits button and close access_settings div
echo "<input type='submit' onfocus='blur()' value=\"" . elgg_echo('save') . "\"/></div>";
?>
	