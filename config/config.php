<?php
	define("_DB_HOST_", "127.0.0.1");
	define("_DB_NAME_", "comptabilite_dev");
	define("_DB_LOGIN_", "root");
	define("_DB_PASSWORD_", "AxelEtLilou2012");

	$currentDir = dirname(__FILE__);

	define("_ROOT_DIR_", realpath($currentDir.'/..'));
	define("_DEFAULT_CSS_", _ROOT_DIR_."/css/");
	define("_DEFAULT_JS_", _ROOT_DIR_."/js/");
	define("_DEFAULT_IMG_", _ROOT_DIR_."/img/");