<?php

	if ($vars['size'] == 'large') {
		$ext = '_lrg';
	} else {
		$ext = '';
	}
	echo "{$CONFIG->wwwroot}mod/document/graphics/icons/application{$ext}.png";

?>