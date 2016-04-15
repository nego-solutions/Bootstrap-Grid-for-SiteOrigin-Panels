<?php
//============================= ROW/PANNEL =====================================
add_filter('siteorigin_panels_row_attributes', 'so_panels_bootstrap_row_layout_attributes', 10, 3);
add_filter('siteorigin_panels_row_style_attributes', 'so_panels_bootstrap_row_style_attributes', 10, 2);
add_filter('siteorigin_panels_row_style_classes', 'so_panels_bootstrap_row_style_classes', 10, 2);
//============================= CELL ===========================================
add_filter('siteorigin_panels_row_cell_classes', 'so_panels_bootstrap_cell_layout_classes', 10, 3);
add_filter('siteorigin_panels_row_cell_attributes', 'so_panels_bootstrap_cell_layout_attributes', 10, 3);
add_filter('siteorigin_panels_cell_style_attributes', 'so_panels_bootstrap_cell_style_attributes', 10, 2);
add_filter('siteorigin_panels_cell_style_classes', 'so_panels_bootstrap_cell_style_classes', 10, 3);

//============================== SO WIDGET HOOKS =======================
add_filter('siteorigin_panels_widget_classes', 'so_panels_bootstrap_panels_widget_classes', 10, 4);
add_filter('siteorigin_panels_widget_args', 'so_panels_bootstrap_widget_args', 10, 1);
//============================== CSS OUTPUT ======================================
add_filter('siteorigin_panels_css_cell_margin_bottom', 'so_panels_bootstrap_css_cell_margin_bottom', 10, 5);
add_filter('siteorigin_panels_css_object', 'so_panels_bootstrap_css_object', 10, 2);
//=============================== FRONTEND SCRIPTS =======================================
add_action( 'wp_enqueue_scripts', 'so_panels_bootstrap_assets' );
