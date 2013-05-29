<?php

/**
 * File            helper.php
 * Created        5/29/13 8:56 AM
 * Author        Matt Thomas matt@betweenbrain.com
 * Copyright    Copyright (C) 2013 betweenbrain llc.
 */

$array = $this->params->get('arrayName');

/*
 * Initialize session
 */
session_start();

/*
 * Create $_SESSION[$array] as array
 * Using isset to not throw an error
 */
if (!isset($_SESSION[$array])) {
	$_SESSION[$array] = array();
}

/*
 * Populate $_SESSION[$array] only with new $value
 */
if (JRequest::getVar('add')) {
	$request = isset($_GET['add']) ? JRequest::getVar('add') : (isset($_POST['add']) ? JRequest::getVar('add') : NULL);

	if ($request && !in_array($request, $_SESSION[$array])) {
		$_SESSION[$array][] = $request;
	}
}

/*
 * Unset array node and re-index the array
 */
if (JRequest::getVar('delete')) {
	$request = isset($_GET['delete']) ? JRequest::getVar('delete') : (isset($_POST['delete']) ? JRequest::getVar('delete') : NULL);

	if ($request && in_array($request, $_SESSION[$array])) {
		foreach ($_SESSION[$array] as $key => $value) {
			if ($request == $value) {
				unset($_SESSION[$array][$key]);
			}
		}
		$_SESSION[$array] = array_values($_SESSION[$array]);
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
if ($_SESSION[$array]) {
	return $_SESSION[$array];
}

return FALSE;