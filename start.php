<?php
/**
 * Elgg Document browser
 */

/**
 * Extend ElggFile
 */
class DocumentPluginDoc extends ElggFile{
	protected function initialise_attributes(){
		parent::initialise_attributes();

		$this->attributes['subtype'] = "document";
	}

	public function __construct($guid = null){
		parent::__construct($guid);
	}
}


/**
 * Document plugin initialisation functions.
 */
function document_init(){
	global $CONFIG;

	$page_owner = page_owner_entity();

	add_menu(elgg_echo('documents'), $CONFIG->wwwroot . 'mod/document/all.php');
	elgg_extend_view('css', 'document/css');

	// add group profile and tool entries
	elgg_extend_view('groups/tool_latest', 'document/groups_documents');
	add_group_tool_option('documents', elgg_echo('groups:enabledocuments'), true);

	// Add to profile menu
	register_plugin_hook('profile_menu', 'profile', 'document_profile_menu');

	register_page_handler('document','document_page_handler');
	register_entity_url_handler('document_url','object','document');

	// Register granular notification for this type
	if (is_callable('register_notification_object')) {
		register_notification_object('object', 'document', elgg_echo('document:newupload'));
	}

	// Listen to notification events and supply a more useful message
	register_plugin_hook('notify:entity:message', 'object', 'document_notify_message');

	// register type for search.
	register_entity_type('object','document');

	// expose documents for embed plugin
	register_plugin_hook('embed_get_sections', 'all', 'document_embed_get_sections');
	register_plugin_hook('embed_get_items', 'document', 'document_embed_get_items');

	elgg_register_tag_metadata_name('simpletype');
}

/**
 * Sets up submenus for the Documents.  Triggered on pagesetup.
 *
 */
/*
function document_submenus() {

	global $CONFIG;

	$page_owner = page_owner_entity();

	// Group submenu option
	if ($page_owner instanceof ElggGroup && get_context() == "groups") {
		if($page_owner->documents_enable != "no"){
			add_submenu_item(sprintf(elgg_echo("document:group"),$page_owner->name), $CONFIG->wwwroot . "pg/document/" . $page_owner->username);
		}
	}
}
*/

/**
 * Document page handler
 *
 * @param array $page Array of page elements, forwarded by the page handling mechanism
 */
function document_page_handler($page) {

	global $CONFIG;

	// The username should be the Document we're getting
	if (isset($page[0])) {
		set_input('username',$page[0]);
	}

	if (isset($page[1])){
		switch($page[1]){
			case "read":
				set_input('guid',$page[2]);
				include($CONFIG->pluginspath . "document/read.php");
			break;
			case "friends":
				include($CONFIG->pluginspath . "document/friends.php");
			break;
			case "all":
					include($CONFIG->pluginspath . "document/all.php");
			break;
			case "new":
				include($CONFIG->pluginspath . "document/upload.php");
			break;
		}
	} else {
		// Include the standard profile index
		include($CONFIG->pluginspath . "document/index.php");
	}

}

/**
 * Returns a more meaningful message
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
*/
function document_notify_message($hook, $entity_type, $returnvalue, $params){
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'document')){
		$descr = $entity->description;
		$title = $entity->title;
		global $CONFIG;
		$url = $CONFIG->wwwroot . "pg/view/" . $entity->guid;
		if ($method == 'sms') {
			$owner = $entity->getOwnerEntity();
			return $owner->username . ' ' . elgg_echo("document:via") . ': ' . $url . ' (' . $title . ')';
		}
		if ($method == 'email') {
			$owner = $entity->getOwnerEntity();
			return $owner->username . ' ' . elgg_echo("document:via") . ': ' . $entity->title . "\n\n" . $descr . "\n\n" . $entity->getURL();
		}
		if ($method == 'web') {
			$owner = $entity->getOwnerEntity();
			return $owner->username . ' ' . elgg_echo("document:via") . ': ' . $entity->title . "\n\n" . $descr . "\n\n" . $entity->getURL();
		}
	}
	return null;
}


/**
 * Returns an overall Document type from the mimetype
 *
 * @param string $mimetype The MIME type
 * @return string The overall type
 */
function get_general_file_type($mimetype) {
	switch($mimetype) {

		case "application/msword":
									return "msword";
									break;
		case "application/pdf":
									return "pdf";
									break;

		case "application/vnd.ms-powerpoint":
									return "ppt";
									break;

		case "application/vnd.ms-excel":
									return "excel";
									break;

		case "application/adobe.intel.form":
									return "pdf";
									break;
	}

	if (substr_count($mimetype,'text/')) {
		return "text";
	}

	if (substr_count($mimetype,'application/vnd.openxmlformats-officedocument.')) {
		return "openoffice";
	}

	if (substr_count($mimetype,'application/vnd.oasis.opendocument.')) {
		return "ppt";
	}

	if (substr_count($mimetype,'application/octet-stream')) {
		return "general";
	}

	if (substr_count($mimetype,'application/')) {
		return "application";
	}

	return "general";

}

/**
 * Returns a list of the available Document types to help generate a menu
 *
 * @return array The overall type
 */
function file_categories() {
	global $CONFIG;
	$file_cats = array("all", "document", "pdf", "excel", "ppt", "text", "application", "general");
	return $file_cats;
}

/**
 * Get the users groups for the filter menu
 *
 * @return array The overall type
 **/
function users_filter() {
	global $CONFIG;
	$user = $_SESSION['user']->guid; //this filter is for the logged in user
	$user_filter = elgg_get_entities_from_relationship(array('relationship' => 'member', 'relationship_guid' => $user, 'inverse_relationship' => FALSE, 'types' => 'group', 'owner_guid' => 0, 'limit' => 100, 'offset' => 0, 'count' => FALSE, 'site_guid' => 0));
	return $user_filter;
}


/**
 * Returns a list of Document types to search specifically on
 *
 * @param int|array $owner_guid The GUID(s) of the owner(s) of the Documents
 * @param true|false $friends Whether we're looking at the owner or the owner's friends
 * @return string The typecloud
 */
function get_filetype_cloud($owner_guid = "", $friends = false) {

	if ($friends) {
		if ($friendslist = get_user_friends($user_guid, $subtype, 999999, 0)) {
			$friendguids = array();
			foreach($friendslist as $friend) {
				$friendguids[] = $friend->getGUID();
			}
		}
		$friendofguid = $owner_guid;
		$owner_guid = $friendguids;
	} else {
		$friendofguid = false;
	}

	$types = elgg_get_tags(array(
		'threshold' => 0,
		'limit' => 10,
		'tag_names' => array('simpletype'),
		'type' => 'object',
		'subtype' => 'document',
		'owner_guids' => $owner_guid
	));
	return elgg_view('document/typecloud', array(
		'owner_guid' => $owner_guid,
		'friend_guid' => $friendofguid,
		'types' => $types
	));

}

/**
 * Populates the ->getUrl() method for Document objects
 *
 * @param ElggEntity $entity Document entity
 * @return string Document URL
 */
function document_url($entity) {
	global $CONFIG;

	$title = $entity->title;
	$title = friendly_title($title);
	return $CONFIG->url . "pg/document/" . $entity->getOwnerEntity()->username . "/read/" . $entity->getGUID() . "/" . $title;
}

function document_profile_menu($hook, $entity_type, $return_value, $params) {
	global $CONFIG;

	$return_value[] = array(
		'text' => elgg_echo('document'),
		'href' => "{$CONFIG->url}pg/document/{$params['owner']->username}",
	);

	return $return_value;
}

/**
 * Register documents as an embed type.
 *
 * @param unknown_type $hook
 * @param unknown_type $type
 * @param unknown_type $value
 * @param unknown_type $params
 */
function document_embed_get_sections($hook, $type, $value, $params) {
	$value['document'] = array(
		'name' => elgg_echo('documents'),
		'layout' => 'list',
	);

	return $value;
}

/**
 * Return a list of documents for embedding
 *
 * @param unknown_type $hook
 * @param unknown_type $type
 * @param unknown_type $value
 * @param unknown_type $params
 */
function document_embed_get_items($hook, $type, $value, $params) {
	$options = array(
		'owner_guid' => get_loggedin_userid(),
		'type_subtype_pair' => array('object' => 'document'),
		'count' => TRUE
	);

	$count = elgg_get_entities($options);
	$value['count'] += $count;

	unset($options['count']);
	$options['offset'] = $params['offset'];
	$options['limit'] = $params['limit'];

	$items = elgg_get_entities($options);

	$value['items'] = array_merge($items, $value['items']);

	return $value;
}

/**
 * Returns the URL of the icon for $entity at $size.
 *
 * @param ElggEntity $entity
 * @param string $size Not used yet.
 */
function videolist_get_entity_icon_url(ElggEntity $entity, $size = 'medium') {
	return $entity->thumbnail;
}

// Make sure test_init is called on initialisation
register_elgg_event_handler('init','system','document_init');
//register_elgg_event_handler('pagesetup','system','document_submenus');

// Register actions
register_action("document/upload", false, $CONFIG->pluginspath . "document/actions/upload.php");
register_action("document/save", false, $CONFIG->pluginspath . "document/actions/save.php");
register_action("document/download", true, $CONFIG->pluginspath. "document/actions/download.php");
register_action("document/delete", false, $CONFIG->pluginspath. "document/actions/delete.php");