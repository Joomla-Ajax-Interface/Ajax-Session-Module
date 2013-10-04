<?php defined('_JEXEC') or die;

/**
 *
 * File       mod_session.php
 * Created    5/22/13 6:43 AM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2013 betweenbrain llc. All Rights Reserved.
 * License    GNU General Public License version 2, or later.
 */

// Include the helper.
require_once __DIR__ . '/helper.php';

// Instantiate global document object
$doc = JFactory::getDocument();

$loadJquery = $params->get('loadJquery', 1);
$format     = $params->get('format', 'debug');

// Load jQuery
if ($loadJquery == '1') {
	$doc->addScript('//code.jquery.com/jquery-latest.min.js');
}

$js = <<<JS
(function ($) {
	$(document).on('click', 'input[type=submit]', function () {
		var value   = $('input[name=data]').val(),
			action  = $(this).attr('class'),
			request = {
					'option' : 'com_ajax',
					'module' : 'session',
					'cmd'    : action,
					'data'   : value,
					'format' : '{$format}'
				};
		$.ajax({
			type   : 'POST',
			data   : request,
			success: function (response) {

				switch (Object.prototype.toString.call(response)){

					case '[object Object]':
						console.log('JSON response:', response);

						var result = '';
						$.each(response, function (index, value) {
							result = result + ' ' + value;
						});

						$('.status').html(result);
						break;

					case '[object String]':

						console.log('String response:', response);

						if(response.length){
							$('.status').html(response);
						} else{
							$('.status').html('No Data');
						}
						break;

					case '[object Boolean]':

						console.log('Boolean response:', response);

						$('.status').html('No Data');
						break;

					default :
					$('.status').html('No Data');
				}

			},
			error: function(response) {
				var data = '',
					obj = $.parseJSON(response.responseText);
				for(key in obj){
					data = data + ' ' + obj[key] + '<br/>';
				}
				$('.status').html(data);
	        }
		});
		return false;
	});
})(jQuery)
JS;

$doc->addScriptDeclaration($js);

require(JModuleHelper::getLayoutPath('mod_session'));