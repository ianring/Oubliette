<?php
require_once("../config.php");
require_once("../oubliette.class.php");

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Oubliette"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Oubliette says Good Day.';
    exit;
} else {
	if ($_SERVER['PHP_AUTH_USER'] != OUBLIETTE_ADMIN_USER || $_SERVER['PHP_AUTH_PW'] != OUBLIETTE_ADMIN_PASSWORD){
	    header('HTTP/1.0 401 Unauthorized');
	    echo 'Oubliette says Sorry.';
	    exit;
	}
}




$oubliette = new Oubliette();
if (isset($_POST['action'])){
	if ($_POST['action'] == 'greylist_add'){
		$success = $oubliette->greylist_add($_POST['ip']);
		echo $success?'true':'false';
		die();
	}
	if ($_POST['action'] == 'blacklist_add'){
		$success = $oubliette->blacklist_add($_POST['ip']);
		echo $success?'true':'false';
		die();
	}
	if ($_POST['action'] == 'whitelist_add'){
		$success = $oubliette->whitelist_add($_POST['ip']);
		echo $success?'true':'false';
		die();
	}

	if ($_POST['action'] == 'whitelist_remove'){
		$success = $oubliette->whitelist_remove($_POST['ip']);
		echo $success?'true':'false';
		die();
	}
	if ($_POST['action'] == 'blacklist_remove'){
		$success = $oubliette->blacklist_remove($_POST['ip']);
		echo $success?'true':'false';
		die();
	}
	if ($_POST['action'] == 'greylist_remove'){
		$success = $oubliette->greylist_remove($_POST['ip']);
		echo $success?'true':'false';
		die();
	}
	if ($_POST['action'] == 'update_config'){
		$success = $oubliette->update_config($_POST['key'], $_POST['value']);
		echo $success?'true':'false';
		die();
	}
}

?>