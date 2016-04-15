<?php
add_action('admin_enqueue_scripts', 'so_overwrites');
//=============================== ROW =======================================
add_filter( 'siteorigin_panels_row_style_fields', 'so_panels_bootstrap_row_fields', 20 );
add_filter('siteorigin_panels_column_ratios', 'so_panels_bootstrap_panels_row_ratios', 20, 3);

//=============================== ADMIN SCRIPTS =======================================
// add_action( 'admin_print_scripts', 'ns_dequeue_script', 100 );
// add_action( 'admin_enqueue_scripts', 'so_panels_bootstrap_admin_enqueue_scripts' );