<?php
	/**
	 * Elgg Document browser uploader
	 */

	global $CONFIG;

	$title = elgg_echo("blog:addpost");
	$action = "document/upload";
	$tags = "";
	$title = "";
	$description = "";
	if(page_owner_entity() instanceof ElggGroup){
		//if in a group, set the access level to default to the group
		$access_id = page_owner_entity()->group_acl;
	}else{
		$access_id = get_default_access(get_loggedin_user());
	}

	//grab the number of Document inputs to show, this is set by the admin
	$num = get_plugin_setting("num_upload");
	if(!$num)
		$num = 5;

?>
<form id="document_upload" action="<?php echo $vars['url']; ?>action/<?php echo $action; ?>" enctype="multipart/form-data" method="post" class="margin_top">
<?php
	echo elgg_view('input/securitytoken');
	//if it is a group, pull out the group access view
	if(page_owner_entity() instanceof ElggGroup){
		$options = group_access_options(page_owner_entity());
	}else{
		$options = '';
	}
	//loop through the number of Documents the admin allows to be uploaded at one time
	for($x = 0; $x < $num; $x++){
		echo "<div class='upload_slot'>" .elgg_view("input/file",array('internalname' => "upload_$x"));
		echo " <a onclick=\"$('#upload_$x').slideToggle();\" class='more_upload_details link' />" . elgg_echo('document:moredetail') . "</a>";
		echo "<div id='upload_$x' class='file_upload_details hidden'>";
		echo elgg_echo('document:title') . ": " . elgg_view("input/text", array("internalname" => "title_$x","value" => '',));
		echo elgg_echo('document:desc') . ": " . elgg_view("input/text",array("internalname" => "description_$x","value" => '',));
		echo elgg_echo('document:tags') . ": " . elgg_view("input/tags", array("internalname" => "tags_$x","value" => '',));
		echo elgg_echo('access') . ": " . elgg_view('input/access', array('internalname' => "access_id_$x",'value' => $access_id, 'options' => $options));
		echo "</div></div>";
	}
?>
<?php
	$categories = elgg_view('categories',$vars);
	if (!empty($categories)) {
?>
	<p><?php echo $categories; ?></p>
<?php
	}
	if (isset($vars['container_guid']))
		echo "<input type='hidden' name='container_guid' value=\"{$vars['container_guid']}\" />";
?>
	<div id="files_uploading" class="ajax_loader left hidden"></div>

	<input id="submit" type="submit" value="<?php echo elgg_echo("save"); ?>" onfocus="blur()" onclick="$('#files_uploading').show();$('#submit').hide();" />
</form>