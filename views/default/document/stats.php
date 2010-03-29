<?php
/**
 * Some helpful stats and instructions for users when they 
 * upload new documents
 **/

$user = $_SESSION['user'];
//get the users default access level
if (false === ($default_access = $user->getPrivateSetting('elgg_default_access'))) {
	$default_access = get_default_access();
}
//get the users default access level as a readable string
$user_acl = get_readable_access_level($default_access);
	//space used
	$space_used = 0;
 	
echo elgg_echo('document:accessdefault'); ?>: <b><?php echo $user_acl; ?></b>