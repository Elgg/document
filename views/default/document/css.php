<?php
/**
* Documents CSS
*/
?>
/* documents list view */
#documents_list .entity_listing_icon img {
	height:25px;
	width:auto;
}
.entity_listing.document.singleview:hover {
	background-color: white;
}

/* document-type page filter */
#mime_type_filter {
	padding:0 3px 3px 3px;
}
#mime_type_filter a img.mime_icon {
	margin:0;
	padding:0;
}
#mime_type_filter a {
	border:2px solid white;
	display:none;
	float:left;
	-webkit-border-radius: 4px; 
	-moz-border-radius: 4px;
	padding:0 1px 0 1px;
	margin:2px;
}
#mime_type_filter a.contains_files {
	display:block;
}
#mime_type_filter a.selected {
	border-color: #999999;
	background-color: #999999;
}

/* document display - single entity page */
.document_header .content_header_title h2 {
	margin-top:4px;
}
.document_details {
	margin-top: 10px;
	margin-bottom: 20px;
}

/* edit document page */
.document_edit {
	margin-top:4px;
}
.document_edit .mime_icon img {
	width:25px;
	height:25px;
}
.mime_icon {
	float:left;
	margin-bottom:5px;
	margin-top:-3px;
}


/* display/edit access settings area in sidebar */
.access_settings .current_settings span {
	display:block;
	font-weight: bold;
}
.access_settings .change_access {
	padding:4px;
	margin:5px 0;
	-webkit-border-radius: 4px; 
	-moz-border-radius: 4px;
	border: 1px solid #cccccc;
	display:block;
}
.access_settings .change_access .input_access {
	width:200px;
}
.access_settings .current_access {
	color:#666666;
	display:block;
}
.access_settings .current_access span {
	font-weight: bold;
}

 
/* multi upload form */
.upload_slot {
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
	background-color: #EEEEEE;
	padding:5px;
	margin-bottom:10px;
}
.file_upload_details {
	padding:5px;
}
.file_upload_details input {
	margin-bottom:5px;
}
.more_upload_details {
	margin-left:20px;
}

/* group docs widget */
.group_tool_widget.documents .entity_listing_icon img {
	width:25px;
}



