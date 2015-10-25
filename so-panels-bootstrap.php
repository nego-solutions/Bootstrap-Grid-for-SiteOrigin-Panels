<?php
/*
Plugin Name: SO Panels Bootstrap
*/


define('SO_URL', plugin_dir_url(__FILE__));


//define('SO_PANELS_BOOTSTRAP_BASE_FILE', __FILE__);
require_once plugin_dir_path(__FILE__) . 'includes/backend/hooks.php';
require_once plugin_dir_path(__FILE__) . 'includes/backend/functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/frontend/hooks.php';
require_once plugin_dir_path(__FILE__) . 'includes/frontend/functions.php';

add_action( 'wp_enqueue_scripts', 'so_panels_bootstrap_assets' );
function so_panels_bootstrap_assets() {
    //wp_enqueue_style('so-panels-bootstrap-style', plugins_url('assets/so-panels-style.less', __FILE__) );
	//enueue bootstrap
	wp_enqueue_style('so-panels-bootstrap', plugins_url('assets/style/bootstrap.min.css', __FILE__) );
	wp_enqueue_script( 'so-panels-bootstrap-js', plugin_dir_url(__FILE__) . 'assets/js/bootstrap.min.js', null, true );
}


function ns_dequeue_script() {
   wp_dequeue_script( 'so-panels-admin' );
   wp_dequeue_script( 'so-panels-admin-utils' );
   wp_dequeue_script( 'so-panels-admin-styles' );
   wp_dequeue_script( 'so-panels-admin-history' );
   wp_dequeue_script( 'so-panels-admin-live-editor' );

}
add_action( 'admin_print_scripts', 'ns_dequeue_script', 100 );


add_action( 'admin_enqueue_scripts', 'so_panels_bootstrap_admin_enqueue_scripts' );

function so_panels_bootstrap_admin_enqueue_scripts( $prefix = '', $force = false ){
	$screen = get_current_screen();
	if ( $force || siteorigin_panels_is_admin_page() ) {
		wp_enqueue_media();

		//wp_enqueue_script( 'so-panels-bootstrap-admin', plugin_dir_url(__FILE__) . 'assets/js/so-panels-bootstrap' . SITEORIGIN_PANELS_JS_SUFFIX . '.js', array( 'jquery', 'jquery-ui-resizable', 'jquery-ui-sortable', 'jquery-ui-draggable', 'underscore', 'backbone', 'plupload', 'plupload-all' ), SITEORIGIN_PANELS_VERSION, true );
		wp_enqueue_script( 'so-panels-bootstrap-admin', plugin_dir_url(__FILE__) . 'assets/js/so-panels-bootstrap.js', array( 'jquery', 'jquery-ui-resizable', 'jquery-ui-sortable', 'jquery-ui-draggable', 'underscore', 'backbone', 'plupload', 'plupload-all' ), SITEORIGIN_PANELS_VERSION, true );
wp_enqueue_script( 'so-panels-bootstrap-admin-utils', plugin_dir_url(__FILE__) . 'assets/js/so-panels-bootstrap-utils' . SITEORIGIN_PANELS_JS_SUFFIX . '.js', null, SITEORIGIN_PANELS_VERSION, true );		wp_enqueue_script( 'so-panels-bootstrap-admin-utils', plugin_dir_url(__FILE__) . 'assets/js/so-panels-bootstrap-utils' . SITEORIGIN_PANELS_JS_SUFFIX . '.js', null, SITEORIGIN_PANELS_VERSION, true );
		wp_enqueue_script( 'so-panels-bootstrap-admin-styles', plugin_dir_url(__FILE__) . 'assets/js/so-panels-bootstrap-styles' . SITEORIGIN_PANELS_JS_SUFFIX . '.js', array( 'jquery', 'underscore', 'backbone', 'wp-color-picker' ), SITEORIGIN_PANELS_VERSION, true );

		if( $screen->base != 'widgets' && $screen->base != 'customize' ) {
			// We don't use the history browser and live editor in the widgets interface
			wp_enqueue_script( 'so-panels-bootstrap-admin-history', plugin_dir_url(__FILE__) . 'assets/js/so-panels-bootstrap-history' . SITEORIGIN_PANELS_JS_SUFFIX . '.js', array( 'so-panels-bootstrap-admin', 'jquery', 'underscore', 'backbone' ), SITEORIGIN_PANELS_VERSION, true );
			wp_enqueue_script( 'so-panels-bootstrap-admin-live-editor', plugin_dir_url(__FILE__) . 'assets/js/so-panels-bootstrap-admin-live-editor' . SITEORIGIN_PANELS_JS_SUFFIX . '.js', array( 'so-panels-bootstrap-admin', 'jquery', 'underscore', 'backbone' ), SITEORIGIN_PANELS_VERSION, true );
		}

		add_action( 'admin_footer', 'siteorigin_panels_js_templates' );

		$widgets = siteorigin_panels_get_widgets();
		$directory_enabled = get_user_meta( get_current_user_id(), 'so_panels_directory_enabled', true );

		wp_localize_script( 'so-panels-bootstrap-admin', 'soPanelsOptions', array(
			'ajaxurl' => wp_nonce_url( admin_url('admin-ajax.php'), 'panels_action', '_panelsnonce' ),
			'widgets' => $widgets,
			'widget_dialog_tabs' => apply_filters( 'siteorigin_panels_widget_dialog_tabs', array(
				0 => array(
					'title' => __('All Widgets', 'siteorigin-panels'),
					'filter' => array(
						'installed' => true,
						'groups' => ''
					)
				)
			) ),
			'row_layouts' => apply_filters( 'siteorigin_panels_row_layouts', array() ),
			'directory_enabled' => !empty( $directory_enabled ),

			// Settings for the contextual menu
			'contextual' => array(
				// Developers can change which widgets are displayed by default using this filter
				'default_widgets' => apply_filters( 'siteorigin_panels_contextual_default_widgets', array(
					'SiteOrigin_Widget_Editor_Widget',
					'SiteOrigin_Widget_Button_Widget',
					'SiteOrigin_Widget_Image_Widget',
					'SiteOrigin_Panels_Widgets_Layout',
				) )
			),

			// General localization messages
			'loc' => array(
				'missing_widget' => array(
					'title' => __('Missing Widget', 'siteorigin-panels'),
					'description' => __("Page Builder doesn't know about this widget.", 'siteorigin-panels'),
				),
				'time' => array(
					// TRANSLATORS: Number of seconds since
					'seconds' => __('%d seconds', 'siteorigin-panels'),
					// TRANSLATORS: Number of minutes since
					'minutes' => __('%d minutes', 'siteorigin-panels'),
					// TRANSLATORS: Number of hours since
					'hours' => __('%d hours', 'siteorigin-panels'),

					// TRANSLATORS: A single second since
					'second' => __('%d second', 'siteorigin-panels'),
					// TRANSLATORS: A single minute since
					'minute' => __('%d minute', 'siteorigin-panels'),
					// TRANSLATORS: A single hour since
					'hour' => __('%d hour', 'siteorigin-panels'),

					// TRANSLATORS: Time ago - eg. "1 minute before".
					'ago' => __('%s before', 'siteorigin-panels'),
					'now' => __('Now', 'siteorigin-panels'),
				),
				'history' => array(
					// History messages
					'current' => __('Current', 'siteorigin-panels'),
					'revert' => __('Original', 'siteorigin-panels'),
					'restore' => __('Version restored', 'siteorigin-panels'),
					'back_to_editor' => __('Converted to editor', 'siteorigin-panels'),

					// Widgets
					// TRANSLATORS: Message displayed in the history when a widget is deleted
					'widget_deleted' => __('Widget deleted', 'siteorigin-panels'),
					// TRANSLATORS: Message displayed in the history when a widget is added
					'widget_added' => __('Widget added', 'siteorigin-panels'),
					// TRANSLATORS: Message displayed in the history when a widget is edited
					'widget_edited' => __('Widget edited', 'siteorigin-panels'),
					// TRANSLATORS: Message displayed in the history when a widget is duplicated
					'widget_duplicated' => __('Widget duplicated', 'siteorigin-panels'),
					// TRANSLATORS: Message displayed in the history when a widget position is changed
					'widget_moved' => __('Widget moved', 'siteorigin-panels'),

					// Rows
					// TRANSLATORS: Message displayed in the history when a row is deleted
					'row_deleted' => __('Row deleted', 'siteorigin-panels'),
					// TRANSLATORS: Message displayed in the history when a row is added
					'row_added' => __('Row added', 'siteorigin-panels'),
					// TRANSLATORS: Message displayed in the history when a row is edited
					'row_edited' => __('Row edited', 'siteorigin-panels'),
					// TRANSLATORS: Message displayed in the history when a row position is changed
					'row_moved' => __('Row moved', 'siteorigin-panels'),
					// TRANSLATORS: Message displayed in the history when a row is duplicated
					'row_duplicated' => __('Row duplicated', 'siteorigin-panels'),

					// Cells
					'cell_resized' => __('Cell resized', 'siteorigin-panels'),

					// Prebuilt
					'prebuilt_loaded' => __('Prebuilt layout loaded', 'siteorigin-panels'),
				),

				// general localization
				'prebuilt_confirm' => __('Are you sure you want to overwrite your current content? This can be undone in the builder history.', 'siteorigin-panels'),
				'prebuilt_loading' => __('Loading prebuilt layout', 'siteorigin-panels'),
				'confirm_use_builder' => __("Would you like to copy this editor's existing content to Page Builder?", 'siteorigin-panels'),
				'confirm_stop_builder' => __("Would you like to clear your Page Builder content and revert to using the standard visual editor?", 'siteorigin-panels'),
				// TRANSLATORS: This is the title for a widget called "Layout Builder"
				'layout_widget' => __('Layout Builder Widget', 'siteorigin-panels'),
				// TRANSLATORS: A standard confirmation message
				'dropdown_confirm' => __('Are you sure?', 'siteorigin-panels'),
				'search_results_header' => __('Search Results For: ', 'siteorigin-panels'),

				// Everything for the contextual menu
				'contextual' => array(
					'add_widget_below' => __('Add Widget Below', 'siteorigin-panels'),
					'add_widget_cell' => __('Add Widget to Cell', 'siteorigin-panels'),
					'search_widgets' => __('Search Widgets', 'siteorigin-panels'),

					'add_row' => __('Add Row', 'siteorigin-panels'),
					'column' => __('Column', 'siteorigin-panels'),
				)
			),
			'plupload' => array(
				'max_file_size' => wp_max_upload_size().'b',
				'url'  => wp_nonce_url( admin_url('admin-ajax.php'), 'panels_action', '_panelsnonce' ),
				'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
				'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
				'filter_title' => __('Page Builder layouts', 'siteorigin-panels'),
				'error_message' => __('Error uploading or importing file.', 'siteorigin-panels'),
			),
			'wpColorPickerOptions' => apply_filters('siteorigin_panels_wpcolorpicker_options', array()),
		));

	}
}

