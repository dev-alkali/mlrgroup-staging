<?php
if (!defined('ABSPATH')) exit;

$dir = get_template_directory();

// Core
require_once $dir . '/inc/setup.php';
require_once $dir . '/inc/enqueue.php';
require_once $dir . '/inc/helpers.php';

require_once __DIR__ . '/features/get-cpt-data/bootstrap.php';
require_once __DIR__ . '/features/get-cpts-data/bootstrap.php';
require_once __DIR__ . '/features/load-more-portfolio/bootstrap.php';
require_once __DIR__ . '/features/case-studies-rest-field/bootstrap.php';

if (function_exists('acf')) {
    require_once $dir . '/inc/integrations/acf.php';
}
