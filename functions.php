<?php

(defined('ABSPATH')) || exit;
define('NASR_VERSION', '1.5.3');

define('NASR_PATH', get_template_directory() . "/");
define('NASR_INCLUDES', NASR_PATH . 'includes/');
define('NASR_CLASS', NASR_PATH . 'classes/');
define('NASR_FUNCTION', NASR_PATH . 'functions/');
define('NASR_VIEWS', NASR_PATH . 'views/');

define('NASR_URL', get_template_directory_uri() . "/");
define('NASR_PHP', NASR_URL . 'json/');
define('NASR_ASSETS', NASR_URL . 'assets/');
define('NASR_CSS', NASR_ASSETS . 'css/');
define('NASR_JS', NASR_ASSETS . 'js/');
define('NASR_IMAGE', NASR_ASSETS . 'image/');

require_once NASR_INCLUDES . '/init.php';
require_once NASR_INCLUDES . '/theme-function.php';
require_once NASR_INCLUDES . '/styles.php';
require_once NASR_INCLUDES . '/jdf.php';
require_once NASR_INCLUDES . '/ajax.php';

require_once NASR_CLASS . '/Nasr.php';

require_once NASR_INCLUDES . '/cron.php';

$nasr_option = nasr_start_working();


if (is_admin()) {
    require_once NASR_CLASS . '/List_Table.php';

    require_once NASR_INCLUDES . '/menu.php';
    require_once NASR_INCLUDES . '/install.php';

}



// exit;
