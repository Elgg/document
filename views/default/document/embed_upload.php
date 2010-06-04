<?php
/**
 * Document upload form for embed
 */

// @todo group stuff?  This isn't a full upload system so I don't think it's necessary.
$access_id = get_default_access(get_loggedin_user());

// recycling the upload action so some of these options are a bit weird.
$form_body = '<p>' . elgg_view('input/file', array('internalname' => 'upload_0')) . '</p>';
$form_body .= elgg_echo('document:title') . ": " . elgg_view("input/text", array('internalname' => 'title_0'));
$form_body .= elgg_echo('document:desc') . ": " . elgg_view("input/text",array('internalname' => 'description_0'));
$form_body .= elgg_echo('document:tags') . ": " . elgg_view("input/tags", array('internalname' => 'tags_0'));
$form_body .= elgg_echo('access') . ": " . elgg_view('input/access', array('internalname' => 'access_id_0', 'value' => $access_id));
$form_body .= '<p>' . elgg_view('input/submit', array('value' => elgg_echo('upload'))) . '</p>';
$form_body .= '</div>';

echo elgg_view('input/form', array(
	'body' => $form_body,
	'internalid' => 'document_embed_upload',
	'action' => $vars['url'] . 'action/document/upload',
));

?>

<script type="text/javascript">
$(document).ready(function() {
	// fire off the ajax upload
	$('#document_embed_upload').submit(function() {
		console.log('here');
		var options = {
			success: function() {
				$('.popup .content').load('<?php echo $vars['url'] . 'pg/embed/embed'; ?>?active_section=document');
			}
		};
		$(this).ajaxSubmit(options);
		return false;
	});
});
</script>