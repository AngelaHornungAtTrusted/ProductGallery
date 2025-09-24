<?php
/*
 * Plugin Name: Product Gallery
 * Description: a simple product gallery
 * Version: 1.0
 * Requires at least: 6.0.0
 * Requires PHP: 7.0
 * Author: Angela Hornung
 * Prefix: pg
 * License: GPLv2 or later
 */

//load classes & configs
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ProductGalleryConfig.php');
require_once(PG_ROOT_DIR_PATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');
require_once(PG_UTIL_DIR_PATH . DIRECTORY_SEPARATOR . 'pg-ajax.php');
require_once(PG_UTIL_DIR_PATH . DIRECTORY_SEPARATOR . 'pg-ajax-shortcode.php');

use Util\PgDbTableManager;

/* Plugin Activation & Installation Management Hooks */
register_activation_hook(__FILE__, 'pg_activate');

/* Actions */
add_action('admin_menu', 'pg_admin_menu');

/* Administrative Actions */
add_action('wp_ajax_pg_image', 'wp_ajax_pg_image');

/* Shortcode Actions */
add_action('wp_ajax_pg_shortcode_image', 'wp_ajax_pg_shortcode_image');
add_action('wp_ajax_nopriv_pg_shortcode_image', 'wp_ajax_pg_shortcode_image');

function pg_activate(): void
{
    global $wpdb;

    $dbTableManager = new Util\PgDbTableManager($wpdb);
    $dbTableManager->initTables();
}

function pg_admin_menu(): void
{
    add_menu_page(
            'Product Gallery Management',
            'Product Gallery',
            'manage_options',
            'pg-admin',
            'pg_admin_page_content'
    );
}

function pg_admin_page_content(): void
{
    ?>
    <div class="wrap">
        <?php wp_enqueue_script('fontawesome', PG_ASSETS_URL . '/fontawesome/fontawesome.min.js'); ?>
        <?php wp_enqueue_style('bootstrap-css', PG_ASSETS_URL . '/bootstrap/css/bootstrap.css'); ?>
        <?php wp_enqueue_script('bootstrap-js', PG_ASSETS_URL . '/bootstrap/js/bootstrap.js'); ?>
        <?php wp_enqueue_style('toastr', plugin_dir_url(__FILE__) . 'Assets/toastr/build/toastr.css'); ?>
        <?php wp_enqueue_script('toastr', plugin_dir_url(__FILE__) . 'Assets/toastr/toastr.js', array('jquery')); ?>
        <?php wp_enqueue_script('admin-js', PG_ADMIN_URL . DIRECTORY_SEPARATOR . 'admin.js', array('jquery')); ?>
        <?php include(PG_ADMIN_DIR_PATH . DIRECTORY_SEPARATOR . 'admin.php'); ?>
    </div>
    <?php
}

/* Shortcode */
add_shortcode('pgallery', 'pg_shortcode');

function pg_shortcode($atts = [], $content = null): void
{
    ?>
        <div class="wrap">
            <?php wp_enqueue_style('bootstrap-css', PG_ASSETS_URL . '/bootstrap/css/bootstrap.css'); ?>
            <?php wp_enqueue_script('bootstrap-js', PG_ASSETS_URL . '/bootstrap/js/bootstrap.js'); ?>
            <?php wp_enqueue_script('popup', plugin_dir_url(__FILE__) . 'Assets/popup/popup.js', array('jquery')); ?>
            <?php include(plugin_dir_path(__FILE__) . 'Shortcode/shortcode.php'); ?>
            <?php wp_enqueue_script('admin-js', PG_SHORTCODE_URL . '/shortcode.js"', array('jquery')); ?>
        </div>
        <?php
}