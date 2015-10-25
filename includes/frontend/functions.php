<?php
//============================= ROW ============================================
function so_panels_bootstrap_row_layout_classes($classes_array = array(), $panels_data)
{
    $classes_array = array('row');
    return $classes_array;
}

function so_panels_bootstrap_row_layout_attributes( $attributes = array(), $panel_grid_data )
{
    $post_id_helper = explode('-', $attributes['id']);
    $post_id = $post_id_helper[1];
    if ($post_id[0] == 'w') {
        $attributes['class'] = 'layout-builder';
        $post_id_helper = explode('-', $attributes['id']);
        $post_id = $post_id_helper[1];
    } else {
        if ( array_key_exists('row_stretch', $panel_grid_data['style']) ) {
            switch ($panel_grid_data['style']['row_stretch']) {
                case 'container':
                    $attributes['class'] = 'container';
                    break;

                case 'container-fluid':
                    $attributes['class'] = 'container-fluid';
                    break;

                default:
                    $attributes['class'] = 'container';
                    break;
            }
        } else {
            $attributes['class'] = 'container';
        }
    }

	return $attributes;
}

function so_panels_bootstrap_row_style_attributes( $attributes, $args )
{
    $class = array();
    if ( array_key_exists('class', $args) ) {
        $class = array($args['class']);
    } else {
        $attributes['data-layout'] = 'row';
    }
    $attributes['class'] = apply_filters( 'ns_row_style_attributes', $class, $attributes, $args );

    return $attributes;
}

function so_panels_bootstrap_row_style_classes($style_attributes, $style_args)
{
    $style_attributes['class'] = apply_filters('ns_row_style_classes', array('row', $style_args['class'][0]), $style_attributes, $style_args);
    return $style_attributes['class'];
}

//============================= CELL ===========================================
function so_panels_bootstrap_cell_layout_attributes( $attributes = array(), $panel_data )
{
    $post_id_helper = explode('-', $attributes['id']);
    $post_id = $post_id_helper[1];
    $current_grid = $post_id_helper[2];
    $current_cell = $post_id_helper[3];
    $no_of_cells = $panel_data['grids'][$current_grid]['cells'];
    $offset_cells = 0;
    for ( $i = 0; $i < $current_grid; $i++ )
    {
        $offset_cells = $offset_cells + $panel_data['grids'][$i]['cells'];
    }
    $get_cell = $offset_cells + $current_cell;
    $cell_weight = $panel_data['grid_cells'][$get_cell]['weight'];
    if ($cell_weight > 0.08 && $cell_weight < 0.09) {
        $attributes['class'] = 'col-md-1';
    } elseif ($cell_weight > 0.16 && $cell_weight < 0.17) {
        $attributes['class'] = 'col-md-2';
    } elseif ($cell_weight > 0.24 && $cell_weight < 0.26) {
        $attributes['class'] = 'col-md-3';
    } elseif ($cell_weight > 0.33 && $cell_weight < 0.34) {
        $attributes['class'] = 'col-md-4';
    } elseif ($cell_weight > 0.41 && $cell_weight < 0.42) {
        $attributes['class'] = 'col-md-5';
    } elseif ($cell_weight > 0.49 && $cell_weight < 0.51) {
        $attributes['class'] = 'col-md-6';
    } elseif ($cell_weight > 0.58 && $cell_weight < 0.59) {
        $attributes['class'] = 'col-md-7';
    } elseif ($cell_weight > 0.66 && $cell_weight < 0.67) {
        $attributes['class'] = 'col-md-8';
    } elseif ($cell_weight > 0.74 && $cell_weight < 0.76) {
        $attributes['class'] = 'col-md-9';
    } elseif ($cell_weight > 0.83 && $cell_weight < 0.84) {
        $attributes['class'] = 'col-md-10';
    } elseif ($cell_weight > 0.91 && $cell_weight < 0.92) {
        $attributes['class'] = 'col-md-11';
    } else {
        $attributes['class'] = 'col-md-12';
    }

    return $attributes;
}

function so_panels_bootstrap_cell_layout_classes($classes_array = array(), $panel_data)
{
    return $classes_array;
}

function so_panels_bootstrap_cell_style_attributes( $attributes, $args )
{
    $attributes['data-layout'] = 'cell';
    return $attributes;
}

function so_panels_bootstrap_cell_style_classes ( $style_class, $style_attributes, $style_args )
{
    return $style_class;
}

//============================== SO WIDGET HOOKS =======================
function so_panels_bootstrap_panels_widget_classes( $classes, $widget, $instance, $widget_info )
{
    $classes = array('ns-widget');
    return $classes;
}

function so_panels_bootstrap_widget_args($args)
{
    $args['before_widget'] = '';
    $args['after_widget'] = '';
    return $args;
}

function so_panels_bootstrap_css_cell_margin_bottom( $panels_margin_bottom, $grid, $gi, $panels_data, $post_id ) {
    return $panels_margin_bottom;
}

function so_panels_bootstrap_css_object( $css, $panels_data = null, $post_id = null ) {
	$settings = siteorigin_panels_setting();
	$panels_mobile_width = $settings['mobile-width'];
	$panels_margin_bottom = $settings['margin-bottom'];
    $css = new SiteOrigin_Panels_Css_Builder();
    foreach ( $panels_data['grids'] as $gi => $grid ) {

    	$cell_count = intval( $grid['cells'] );

    	if($gi != count($panels_data['grids'])-1){
			// Filter the bottom margin for this row with the arguments
			$css->add_row_css($post_id, $gi, '', array(
				'margin-bottom' => apply_filters('siteorigin_panels_css_row_margin_bottom', $panels_margin_bottom.'px', $grid, $gi, $panels_data, $post_id)
			));
		}

		if ( $cell_count > 1 ) {
			$css->add_cell_css($post_id, $gi, false, '', array(
				// Float right for RTL
				'float' => !is_rtl() ? 'left' : 'right'
			));
		}

		if ( $settings['responsive'] ) {
			for ( $i = 0; $i < $cell_count; $i++ ) {
				if ( $i != $cell_count - 1 ) {
					$css->add_cell_css($post_id, $gi, $i, '', array(
						'margin-bottom' => $panels_margin_bottom . 'px',
					), $panels_mobile_width);
				}
			}
		}
    }

    // Add the bottom margins
	$css->add_cell_css($post_id, false, false, '.so-panel', array(
		'margin-bottom' => apply_filters('siteorigin_panels_css_cell_margin_bottom', $panels_margin_bottom.'px', $grid, $gi, $panels_data, $post_id)
	));
	$css->add_cell_css($post_id, false, false, '.so-panel:last-child', array(
		'margin-bottom' => apply_filters('siteorigin_panels_css_cell_last_margin_bottom', '0px', $grid, $gi, $panels_data, $post_id)
	));

	foreach ( $panels_data['grids'] as $gi => $grid ) {
		// Rows with only one cell don't need gutters
		if($grid['cells'] <= 1) continue;

		// Let other themes and plugins change the gutter.
		$gutter = apply_filters('siteorigin_panels_css_row_gutter', $settings['margin-sides'].'px', $grid, $gi, $panels_data);

		if( !empty($gutter) ) {
			// We actually need to find half the gutter.
			preg_match('/([0-9\.,]+)(.*)/', $gutter, $match);
			if( !empty( $match[1] ) ) {
				$margin_half = (floatval($match[1])/2) . $match[2];
				$css->add_row_css($post_id, $gi, '', array(
					'margin-left' => '-' . $margin_half,
					'margin-right' => '-' . $margin_half,
				) );
				$css->add_cell_css($post_id, $gi, false, '', array(
					'padding-left' => $margin_half,
					'padding-right' => $margin_half,
				) );

			}
		}
	}

	// Let other plugins and components filter the CSS object.
	$css = apply_filters('so_panels_bootstrap_css_object', $css, $panels_data, $post_id);
    return $css;
}