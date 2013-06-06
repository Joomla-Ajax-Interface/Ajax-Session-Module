<?php defined('_JEXEC') or die;

/**
 * File            helper.php
 * Created        5/29/13 8:56 AM
 * Author        Matt Thomas matt@betweenbrain.com
 * Copyright    Copyright (C) 2013 betweenbrain llc.
 */

class modSessionHelper {

	public static function getAjax() {

		/*
		 * Initialize session
		 */
		session_start();

		/*
		 * Create $_SESSION['data'] as array
		 * Using isset to not throw an error
		 */
		if (!isset($_SESSION['data'])) {
			$_SESSION['data'] = array();
		}

		/*
		 * Populate $_SESSION['data'] only with new $value
		 */
		if (JRequest::getVar('add')) {
			$request = isset($_GET['add']) ? JRequest::getVar('add') : (isset($_POST['add']) ? JRequest::getVar('add') : NULL);

			if ($request && !in_array($request, $_SESSION['data'])) {
				$_SESSION['data'][] = $request;
			}
		}

		/*
		 * Unset array node and re-index the array
		 */
		if (JRequest::getVar('delete')) {
			$request = isset($_GET['delete']) ? JRequest::getVar('delete') : (isset($_POST['delete']) ? JRequest::getVar('delete') : NULL);

			if ($request && in_array($request, $_SESSION['data'])) {
				foreach ($_SESSION['data'] as $key => $value) {
					if ($request == $value) {
						unset($_SESSION['data'][$key]);
					}
				}
				$_SESSION['data'] = array_values($_SESSION['data']);
			}
		}

		/*
		 * Destroy the session
		 */
		if (JRequest::getVar('destroy')) {
			session_destroy();
		}

		/*
		 * Check for session array and return contents
		 */
		if ($_SESSION['data']) {
			return $_SESSION['data'];
		}

		return FALSE;
	}
}
