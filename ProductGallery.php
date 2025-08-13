<?php
/*
 * Plugin Name: ProductGallery
 * Description: Product Gallery
 * Version: 1.0
 * Requires at least: 5.2
 * Requires PHP: 8.0.0
 * Author: Angela Hornung
 * Prefix: pg
 */

//load classes & configs
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ProductGalleryConfig.php');
require_once(PG_ROOT_DIR_PATH . '/vendor/autoload.php');
require_once(PG_UTIL_DIR_PATH . '/pg-ajax.php');

/* Plugin Activation & Installation Management Hooks */
register_activation_hook(__FILE__, 'pg_activate');

/* Actions */
add_action('admin_menu', 'pg_admin_menu');

function pg_activate() : void {

}

function pg_admin_menu() : void {
    add_menu_page(
        'Product Gallery Management',
        'Product Gallery',
        'manage_options',
        'pg-admin',
        'pg_admin_page_content'
    );
}

function pg_admin_page_content() : void {
    ?>
    <div class="wrap">
        <?php wp_enqueue_style('bootstrap-css', PG_ASSETS_URL . '/bootstrap/css/bootstrap.css'); ?>
        <?php wp_enqueue_script('bootstrap-js', PG_ASSETS_URL . '/bootstrap/js/bootstrap.js'); ?>
        <?php include(PG_ADMIN_DIR_PATH . DIRECTORY_SEPARATOR . 'admin.php'); ?>
    </div>
<?php
}