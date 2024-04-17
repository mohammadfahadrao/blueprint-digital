<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function blueprintGetVerticals()
{
    $api_url = BLUEPRINT_API_BASE_URL . '/vertical-attributes?vertical_host=' . get_permalink();
    $response = wp_remote_get(
        esc_url_raw($api_url),
        array(
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(
            'referer' => home_url()
            )
        )
    );

    return blueprintResponseValidation($response);
}

function blueprintResponseValidation($response)
{
    if (is_wp_error($response)) {
        $response_array = Array();
        $response_array['errors'] = $response->get_error_message();
        return $response_array;
    } else {
        return $response;
    }
}
