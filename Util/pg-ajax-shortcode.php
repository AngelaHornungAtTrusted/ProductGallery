<?php
function wp_ajax_pg_get_unfeatured()
{
    global $wpdb;
    $response = new stdClass();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $data = $wpdb->get_results("SELECT * FROM " . PG_TABLE_IMAGES . " WHERE featured!=1 ORDER BY orderNumber ASC");

        $response->status = 'success';
        $response->data = $data;
    } else {
        $response->status = 'error';
        $response->message = 'Invalid request';
        $response->code = 400;
    }

    wp_send_json($response);
}

function wp_ajax_pg_get_featured()
{
    global $wpdb;
    $response = new stdClass();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        //reported error of no prepare, prepare not required here as we're not using variable replacement via sprintf as non parameters
        $data = $wpdb->get_results("SELECT * FROM " . PG_TABLE_IMAGES . " WHERE featured=1 ORDER BY orderNumber ASC");

        $response->status = 'success';
        $response->data = $data;
    } else {
        $response->status = 'error';
        $response->message = 'Invalid request';
        $response->code = 400;
    }

    wp_send_json($response);
}