<?php
define('PG_PLUGIN_NAME', 'Product Gallery');
define('PG_PLUGIN_SLUG', 'product-gallery');
define('PG_PLUGIN_VERSION', '1.0.0');

/* Global File Paths */
define('PG_ROOT_DIR_NAME', 'ProductGallery');
define('PG_ROOT_DIR_PATH', plugin_dir_path(__FILE__));
define('PG_ADMIN_DIR_PATH', PG_ROOT_DIR_PATH . 'Admin');
define('PG_ASSETS_DIR_PATH', PG_ROOT_DIR_PATH . 'Assets');
define('PG_SHORTCODE_DIR_PATH', PG_ROOT_DIR_PATH . 'Shortcode');
define('PG_UTIL_DIR_PATH', PG_ROOT_DIR_PATH . 'Util');

/* Global File Urls */
define('PG_ROOT_DIR_URL', plugin_dir_url(__FILE__));
define('PG_ADMIN_URL', PG_ROOT_DIR_URL . 'Admin');
define('PG_ASSETS_URL', PG_ROOT_DIR_URL . 'Assets');
define('PG_SHORTCODE_URL', PG_ROOT_DIR_URL . 'Shortcode');
define('PG_UTIL_URL', PG_ROOT_DIR_URL . 'Util');

/* Global Database Details */
global $wpdb;
define('PG_PLUGIN_PREFIX', 'PG');
define('PG_DB_PREFIX', 'pg_');

/* Tables */
define('PG_TABLE_IMAGES', PG_DB_PREFIX . 'images');