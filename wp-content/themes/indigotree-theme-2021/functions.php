<?php

// Define base paths & uri
//
define('ORIGIN_PATH', untrailingslashit(get_template_directory()));
define('ORIGIN_URI', untrailingslashit(get_template_directory_uri()));

// Include misc setup & function files
//
require_once(ORIGIN_PATH . '/theme/theme-functions.php');
require_once(ORIGIN_PATH . '/theme/theme-setup.php');
require_once(ORIGIN_PATH . '/theme/theme-filters.php');
require_once(ORIGIN_PATH . '/theme/theme-navwalker.php');
