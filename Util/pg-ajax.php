<?php
function wp_ajax_pg_image() {
    global $wpdb;
    $response = new stdClass();

    if (!current_user_can('administrator')) {
        $response->status = 'error';
        $response->message = 'Unauthorized Request';
        $response->code = 403;

        wp_send_json($response);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['data']['postId'])) {
            //actually posting an image
            if (!isset($_POST['data']['title']) || !isset($_POST['data']['path']) || !isset($_POST['data']['description'])){
                $response->status = 'error';
                $response->message = 'Missing Required Parameters';
                $response->code = 400;

                wp_send_json($response);
            }

            try {
                $wpdb->insert(
                    PG_TABLE_IMAGES,
                    array(
                        'title' => sanitize_text_field($_POST['data']['title']),
                        'alt' => sanitize_text_field($_POST['data']['alt']),
                        'path' => sanitize_text_field($_POST['data']['path']),
                        'description' => sanitize_text_field($_POST['data']['description']),
                        'create_date' => date('Y-m-d H:i:s'),
                        'update_date' => gmdate('Y-m-d H:i:s'),
                    )
                );

                $response->status = 'success';
                $response->code = 200;
            } catch (Exception $e) {
                $response->status = 'error';
                $response->message = $e->getMessage();
                $response->code = 500;
            }
        } else {
            //if set, we're deleting or updating an image
            try {

                if (!isset($_POST['data']['description'])) {
                    $wpdb->delete(
                        PG_TABLE_IMAGES,
                        array('id' => intval($_POST['data']['postId']))
                    );
                } else {
                    $wpdb->update(
                        PG_TABLE_IMAGES,
                        array(
                            'description' => sanitize_text_field($_POST['data']['description']),
                        ),
                        array('id' => intval($_POST['data']['postId']))
                    );

                    $response->message = 'Image Updated Successfully';
                }

                $response->status = 'success';
                $response->code = 200;
            } catch (Exception $e) {
                $response->status = 'error';
                $response->message = $e->getMessage();
                $response->code = 500;
            }
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!isset($_GET['data']['imageId'])) {
            //grab all
            try {
                $data = $wpdb->get_results("SELECT * FROM " . PG_TABLE_IMAGES);
            } catch (Exception $e) {
                $response->status = 'error';
                $response->message = $e->getMessage();
                $response->code = 500;
            }

            $response->data = $data;
            $response->code = 200;
            $response->status = 'success';
        } else {
            //grab specific
            try{
                $data = $wpdb->get_results("SELECT * FROM " . PG_TABLE_IMAGES . " WHERE id = " . intval($_GET['data']['imageId']));
            }catch(Exception $e){
                $response->status = 'error';
                $response->message = $e->getMessage();
                $response->code = 500;
            }

            $response->data = $data;
            $response->code = 200;
            $response->status = 'success';
        }
    } else {
        $response->status = 'error';
        $response->message = 'Invalid Request';
        $response->code = 400;
    }

    wp_send_json($response);
}