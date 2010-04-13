<?php 
// Latest Documents on group home page

//check to make sure this groups Documents has been activated 
if($vars['entity']->documents_enable != 'no'){

?>

<script type="text/javascript">
$(document).ready(function () {
// @todo - check this
$('a.show_file_desc').click(function () {
	$(this.parentNode).children("[class=filerepo_listview_desc]").slideToggle("fast");
	return false;
});

});
</script>

<div class="group_tool_widget documents"> 
<h3><?php echo elgg_echo("document:group"); ?></h3>

<?php

	//the number of Documents to display
	$number = (int) $vars['entity']->num_display;
	if (!$number)
		$number = 6;
	
	//get the user's Documents
	$files = get_user_objects($vars['entity']->guid, "document", $number, 0);
	
	//if there are some Documents, go get them
	if ($files) {
    	       	    
            //display in list mode
            foreach($files as $f){
            	
                $mime = $f->mimetype;
                echo "<div class='entity_listing clearfloat'>";
            	echo "<div class='entity_listing_icon'><a href=\"{$f->getURL()}\">" . elgg_view("document/icon", array("mimetype" => $mime, 'thumbnail' => $f->thumbnail, 'file_guid' => $f->guid)) . "</a></div>";
            	echo "<div class='entity_listing_info'>";
            	echo "<p class='entity_title'>" . $f->title . "</p>";
            	echo "<p class='entity_subtext'>" . friendly_time($f->time_created) . "</p>";
		        $description = $f->description;
		        if (!empty($description)) echo "<a href=\"javascript:void(0);\" class=\"show_file_desc\">". elgg_echo('more') ."</a><br /><div class=\"filerepo_listview_desc\">" . $description . "</div>";
		        echo "</div></div>";
            				
        	}
        	
        	
        //get a link to the users Documents
        $users_file_url = $vars['url'] . "pg/document/" . page_owner_entity()->username;
        	
        echo "<p class='link'><a href=\"{$users_file_url}\">" . elgg_echo('document:more') . "</a></p>";
       
	} else {
		
		echo "<p class='margin_top'>" . elgg_echo("document:none") . "</p>";

	}

?>
</div>

<?php
	}//end of activate check statement
?>