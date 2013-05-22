<?php defined('_JEXEC') or die;

/**
 * File       mod_session.php
 * Created    5/22/13 6:43 AM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2013 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

$doc = JFactory::getDocument();

$doc->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');

$js = <<<JS
(function ($) {
	$(document).on("submit", function () {
		var now = Date();
		$.ajax({
			type   : 'POST',
			data   : "option=com_ajax&group=session&time=" + now + "&format=json",
			success: function (response) {
				$(".status").html(response);
			}
		});
		return false;
	});
})(jQuery)
JS;

$doc->addScriptDeclaration($js);

require(JModuleHelper::getLayoutPath('mod_session'));