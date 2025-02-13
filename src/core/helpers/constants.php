<?php

// Path Constants
defined('BASEPATH') or define('BASEPATH', dirname(__DIR__, 2));
defined('VIEWPATH') or define('VIEWPATH', BASEPATH . "/resources/views");
defined('VIEWPATH_CORE') or define('VIEWPATH_CORE', BASEPATH . "/core/resources/views");

// Server Constants
defined('REQUEST_URI') or define('REQUEST_URI', $_SERVER['REQUEST_URI']);
defined('REQUEST_METHOD') or define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);