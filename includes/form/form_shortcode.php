<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_shortcode("blue_print_form", "blueprintFormShortcode");

function blueprintFormShortcode()
{
    $verticals = blueprintGetVerticals();
    if ($verticals['errors'] ?? null) {
        return;
    }

    wp_enqueue_script('blue-print-forms-script', BLUEPRINT_URL . '/assets/javascript/form.js', array('jquery'));
    wp_enqueue_script('blue-print-forms-recaptcha', 'https://www.google.com/recaptcha/api.js');
    wp_enqueue_style('blue-print-forms-style', BLUEPRINT_URL . '/assets/css/form.css');

    $form_columns = $verticals['response']['code'] != 404 ? json_decode($verticals['body']) : array();

    $order = array();
    foreach ($form_columns as $ikey => $irow) {
        $order[$ikey] = $irow->order;
    }
    $formVerticalFields = (array)$form_columns;
    array_multisort($order, SORT_ASC, $formVerticalFields);
    if ($form_columns == null || count((array) $form_columns) == 0) {
        return '<div class="bp-text-center"><h4><i class="text bp-text-error bp-err-font-md">' . ucfirst($verticals["body"]) . '</i></h4></div>';
    }

    ob_start();
    if (count((array) $form_columns) <= 10) {
        require_once BLUEPRINT_PATH . '/includes/form/form_template.php';
    } else {
        require_once BLUEPRINT_PATH . '/includes/form/form_paginated.php';
    }
    return ob_get_clean();
}
