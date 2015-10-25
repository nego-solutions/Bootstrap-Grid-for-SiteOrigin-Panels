<?php
function so_overwrites(){

    wp_enqueue_style( 'so-overwrites', SO_URL. 'assets/style/so-overwrites.css');

}
//=============================== ROW =======================================

function so_panels_bootstrap_row_fields($fields) {
    $fields['row_stretch']['options'] = array(
            'container' => 'Container',
            'container-fluid' => 'Container Fluid',
        );
    return $fields;
}
//
function ns_panels_row_ratios($so_ratios) {
    $so_ratios = array(
        '6 - 6' => '1',
        '7 - 5' => '0.710',
        '8 - 4' => '0.5',
        '9 - 3' => '0.333',
        '10 - 2' => '0.2',
        '11 - 1' => '0.09',
    );
    return $so_ratios;
}
