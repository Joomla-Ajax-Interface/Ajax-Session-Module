<?php defined('_JEXEC') or die;

/**
 * File       helper.php
 * Created    6/6/13 12:56 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/Ajax-Session-Module/issues
 * Copyright  Copyright (C) 2013 betweenbrain llc. All Rights Reserved.
 * License    GNU General Public License version 2, or later.
 */

class modSessionHelper {

	public static function getAjax() {

		// Get module parameters
		jimport('joomla.application.module.helper');
		jimport('joomla.html.parameter');
		$module = JModuleHelper::getModule('session');
		$params = new JParameter($module->params);
		$node   = $params->get('node', 'data');

		session_start();

		if (!isset($_SESSION[$node])) {
			$_SESSION[$node] = array();
		}

		if (JRequest::getVar('cmd')) {
			$cmd  = JRequest::getVar('cmd');
			$data = JRequest::getVar('data');

			switch ($cmd) {
				case "add":
					if (!in_array($data, $_SESSION[$node])) {
						$_SESSION[$node][] = $data;
					}
					break;

				case "delete":
					if (in_array($data, $_SESSION[$node])) {
						foreach ($_SESSION[$node] as $key => $value) {
							if ($data == $value) {
								unset($_SESSION[$node][$key]);
							}
						}
						$_SESSION[$node] = array_values($_SESSION[$node]);
					}
					break;

				case "destroy" :
					session_destroy();
					break;

				// cmd=debug, not to be confused with format=debug
				case "debug" :
					die('<pre>' . print_r($_SESSION[$node], TRUE) . '</pre>');
					break;
			}

			if ($_SESSION[$node]) {

				return $_SESSION[$node];
			}

			return FALSE;
		}
	}
}