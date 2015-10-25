<?php
add_action('admin_enqueue_scripts', 'so_overwrites');
//=============================== ROW =======================================
add_filter( 'siteorigin_panels_row_style_fields', 'so_panels_bootstrap_row_fields', 10 );
add_filter('siteorigin_panels_column_ratios', 'so_panels_bootstrap_panels_row_ratios', 10, 3);

