<?php
if (!defined('ABSPATH')) exit;

$dir = get_template_directory();

// Core
require_once $dir . '/inc/setup.php';
require_once $dir . '/inc/enqueue.php';
require_once $dir . '/inc/helpers.php';



if (function_exists('acf')) {
    require_once $dir . '/inc/integrations/acf.php';
}
