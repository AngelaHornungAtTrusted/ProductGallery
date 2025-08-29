<?php
function wp_ajax_pg_shortcode_image() : void {
    global $wpdb;
    $response = new stdClass();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        //$featured = (intval($_GET['data']['featured']) === 1) ? " WHERE featured = 1" : " WHERE featured = 0";

        $data = $wpdb->get_results("SELECT * FROM " . PG_TABLE_IMAGES . /*$featured .*/ " ORDER BY orderNumber ASC");

        $response->status = 'success';
        $response->data = $data;
    } else {
        $response->status = 'error';
        $response->message = 'Invalid request';
        $response->code = 400;
    }

    wp_send_json($response);
}