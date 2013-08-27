<?php defined('_JEXEC') or die;

/**
 * File       helper.php
 * Created    6/7/13 1:51 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2013 betweenbrain llc. All Rights Reserved.
 * License    GNU General Public License version 2, or later.
 */

class modSessionHelper {

	public static function getAjax() {

		// Get module parameters
		jimport('joomla.application.module.helper');
		$module      = JModuleHelper::getModule('session', NULL);
		$params      = new JParameter($module->params);
		$node        = $params->get('node', 'data');
		$session     = JFactory::getSession();
		$sessionData = $session->get($node);

		if (is_null($sessionData)) {
			$sessionData = array();
			$session->set($node, $sessionData);
		}

		if (JRequest::getVar('cmd')) {
			$cmd  = JRequest::getVar('cmd');
			$data = JRequest::getVar('data');

			switch ($cmd) {
				case "add" :
					if (!isset($sessionData[$data]) && $data != '') {
						$sessionData[$data] = $data;
						$session->set($node, $sessionData);
					}
					break;

				case "delete" :
					if (isset($sessionData[$data])) {
						unset($sessionData[$data]);
						$session->set($node, $sessionData);
					}
					break;

				case "destroy" :
					$sessionData = NULL;
					$session->set($node, $sessionData);
					break;

				case "debug" :
					die('<pre>' . print_r($sessionData, TRUE) . '</pre>');
					break;
			}

			if ($sessionData) {
				return $sessionData;
			}

			return FALSE;
		}
	}
}