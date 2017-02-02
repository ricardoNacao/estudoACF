<?php 
    /*
    Plugin Name: ACF-VC Integrator
    Plugin URI: http://www.dejliglama.dk/
    Description: ACF VC Integrator plugin is the easiest way to output your Advanced Custom Posttype fields in a Visual Composer Grid.
    Author: DejligLama.dk
    Version: 1.0
    Author URI: http://www.dejliglama.dk/
    */
?>
<?php
	function acf_vc_integrator_check_for_dependancy() {		
		function acf_vc_integrator_showMessage($message, $errormsg = false)
		{
			if ($errormsg) {
				echo '<div id="message" class="error">';
			}
			else {
				echo '<div id="message" class="updated fade">';
			}
			echo "<p><strong>$message</strong></p></div>";
		} 
		 
		function acf_vc_integrator_showAdminMessages()
		{
			if ( !is_plugin_active( 'js_composer/js_composer.php' ) and  !is_plugin_active( 'advanced-custom-fields/acf.php' )) {
				acf_vc_integrator_showMessage("ACF-VC Integrator require both WP Bakery Visual Composer and Advanced Custom Fields plugins installed and activated.", true);				
			} elseif ( !is_plugin_active( 'js_composer/js_composer.php' ) ) {
				acf_vc_integrator_showMessage("ACF-VC Integrator require WP Bakery Visual Composer plugin installed and activated.", true);			
			} elseif ( !is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {
				acf_vc_integrator_showMessage("ACF-VC Integrator require Advanced Custom Fields plugin installed and activated.", true);		
			}	
		}
		add_action('admin_notices', 'acf_vc_integrator_showAdminMessages');
	}
	
	//Check for ACF and VC plugins
	add_action('admin_init', 'acf_vc_integrator_check_for_dependancy');	
	
	//Adding dashboard page.
	function acf_vc_integrator_admin() {
		include('acf_vc_integrator_admin.php');
	}
	function acf_vc_integrator_admin_actions() {
		/* add_options_page("ACF-VC Integrator", "ACF-VC Integrator", 1, "acf-vc-integrator", "acf_vc_integrator_admin"); */
		add_menu_page("ACF-VC Integrator", "ACF-VC Integrator", 1, "acf-vc-integrator", "acf_vc_integrator_admin", plugin_dir_url( __FILE__ )."images/acf_icon.png");
	}
	add_action('admin_menu', 'acf_vc_integrator_admin_actions');
	
	add_action( 'vc_before_init', 'acf_vc_integrator_elem' );
	function acf_vc_integrator_elem() {
		
		$groups = function_exists( 'acf_get_field_groups' ) ? acf_get_field_groups() : apply_filters( 'acf/get_field_groups', array() );
		$groups_param_values = $fields_params = array();
		foreach ( $groups as $group ) {
			$flg = 1;
			
			$id = isset( $group['id'] ) ? 'id' : ( isset( $group['ID'] ) ? 'ID' : 'id' );
			$groups_param_values[ $group['title'] ] = $group[ $id ];
			$fields = function_exists( 'acf_get_fields' ) ? acf_get_fields( $group[ $id ] ) : apply_filters( 'acf/field_group/get_fields', array(), $group[ $id ] );
			$fields_param_value = array();
			foreach ( $fields as $field ) {
				$fields_param_value[ $field['label'] ] = (string) $field['key'];
			}
			$fields_params[] = array(
				'type' => 'dropdown',
				'heading' => __( 'Field name', 'js_composer' ),
				'param_name' => 'field_from_' . $group[ $id ],
				'value' => $fields_param_value,
				'save_always' => true,
				'description' => __( 'Select field from group.', 'js_composer' ),
				'dependency' => array(
					'element' => 'field_group',
					'value' => array( (string) $group[ $id ] ),
				)
			);
			
			
		}
		
		wp_enqueue_style( 'acf-vc-integrator-style', plugin_dir_url( __FILE__ ).'css/acf-vc-integrator-style.css');
		
		vc_map( array(
			'name' => __( 'ACF-VC Integrator', 'js_composer' ),
			'base' => 'acf_vc_integrator',
			/* 'icon' => 'vc_icon-acf', */
			'category' => __( 'Content', 'js_composer' ),
			'description' => __( 'Advanced Custom Field - Visual Composer Integrator', 'js_composer' ),
			'php_class_name' => 'Acf_vc_integrator_Shortcode',
			'admin_enqueue_css' => plugin_dir_url( __FILE__ ).'css/acf-vc-integrator-style.css',
			'params' => array_merge(
				array(
					array(
						'type' => 'dropdown',
						'heading' => __( 'Field group', 'js_composer' ),
						'param_name' => 'field_group',
						'admin_label' => true,
						'value' => $groups_param_values,
						'save_always' => true,
						'description' => __( 'Select field group.', 'js_composer' ),
					),
				), 
				$fields_params,
				array(
					array(
						'type' => 'checkbox',
						'heading' => __( 'Show label', 'js_composer' ),
						'param_name' => 'show_label',
						'value' => array( __( 'Yes', 'js_composer' ) => 'yes' ),
						'description' => __( 'Enter label to display before key value.', 'js_composer' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Align', 'js_composer' ),
						'param_name' => 'align',
						'value' => array(
							__( 'left', 'js_composer' ) => 'left',
							__( 'right', 'js_composer' ) => 'right',
							__( 'center', 'js_composer' ) => 'center',
							__( 'justify', 'js_composer' ) => 'justify',
						),
						'description' => __( 'Select alignment.', 'js_composer' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Extra class name', 'js_composer' ),
						'param_name' => 'el_class',
						'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Custom Link Text', 'js_composer' ),
						'param_name' => 'link_text',
						'description' => __( 'Applicable only for File Objects and Page Links', 'js_composer' ),
					)
				)
			),
		));

		class Acf_vc_integrator_Shortcode extends WPBakeryShortCode {
			/**
			 * @param $atts
			 * @param null $content
			 *
			 * @return mixed|void
			 */
			protected function content( $atts, $content = null ) {
				$field_key = $label = '';
				/**
				 * @var string $el_class
				 * @var string $show_label
				 * @var string $align
				 * @var string $field_group
				 */
				extract( shortcode_atts( array(
					'el_class' => '',
					'field_group' => '',
					'show_label' => '',
					'align' => '',
					'link_text' => ''
				), $atts ) );
				if ( 0 === strlen( $field_group ) ) {
					$groups = function_exists( 'acf_get_field_groups' ) ? acf_get_field_groups() : apply_filters( 'acf/get_field_groups', array() );
					if ( is_array( $groups ) && isset( $groups[0] ) ) {
						$key = isset( $groups[0]['id'] ) ? 'id' : ( isset( $groups[0]['ID'] ) ? 'ID' : 'id' );
						$field_group = $groups[0][ $key ];
					}
				}
				if ( ! empty( $field_group ) ) {
					$field_key = ! empty( $atts[ 'field_from_' . $field_group ] ) ? $atts[ 'field_from_' . $field_group ] : 'field_from_group_' . $field_group;
				}
				
				$custom_field = get_field_object($field_key);				
				$css_class = 'vc_sw-acf' . ( strlen( $el_class ) ? ' ' . $el_class : '' ) . ( strlen( $align ) ? ' vc_sw-align-' . $align : '' ) . ( strlen( $field_key ) ? ' ' . $field_key : '' );
				$link_text = ( strlen( $link_text ) ? $link_text : 'Link' );
				
				if('image' === $custom_field["type"]) {
					$img_details = $custom_field["value"];					
					if($custom_field["save_format"] == "object" ) {
						if(isset($img_details["url"])) {
							$ret_val = '<img title="'.$img_details["title"].'" src="'.$img_details["url"].'" alt="'.$img_details["alt"].'" width="'.$img_details["width"].'" height="'.$img_details["height"].'" />';
						} else {
							$ret_val = 'data-mismatch';
						}
					} else {
						$ret_val = $custom_field["value"];
					}
				} elseif('file' === $custom_field["type"]) {			
					$file_details = $custom_field["value"];										
					if($custom_field["save_format"] == "object" ) {
						if(isset($file_details["url"])) {
							$ret_val = '<a title="Download '.$file_details["title"].'" href="'.$file_details["url"].'">'.$link_text.'</a>';	
						} else {
							$ret_val = 'data-mismatch';
						}
					} else {
						$ret_val = $custom_field["value"];
					}
				} elseif('checkbox' === $custom_field["type"]) {
					$check_values = $custom_field["value"];
					if(is_array($check_values)) {
						$ret_val = implode(", ", $check_values);
					} else {
						$ret_val = ''; 
					}
				} elseif('user' === $custom_field["type"]) {
					$user_details = $custom_field["value"];
					$ret_val = $user_details["display_name"];
				} elseif('page_link' === $custom_field["type"]) {
					
					$page_link = $custom_field["value"];
					$ret_val = '<a href="'.$page_link.'">'.$link_text.'</a>';
					
				} elseif('google_map' === $custom_field["type"]) {
					$map_details = $custom_field["value"];
					$ret_val = '<iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q='.$map_details["lat"].','.$map_details["lng"].'&hl=es;z=14&amp;output=embed"></iframe>';
				} elseif('color_picker' === $custom_field["type"]) {
					$ret_val = '<div style="display: inline-block; height: 15px; width: 15px; margin: 0px 5px 0px 0px; background-color: '.$custom_field["value"].'"></div>'.$custom_field["value"];
				} elseif('true_false' === $custom_field["type"]) {
					if(1 == $custom_field["value"]) $ret_val = 'True'; else $ret_val = 'False';
				} elseif('taxonomy' === $custom_field["type"]) {					
					$terms = $custom_field["value"];
					$ret_val = "<ul>";
					foreach($terms as $term) {						
						$term_details = get_term( $term, 'category', ARRAY_A );
						$ret_val .= '<li><a href="'.get_term_link( $term_details["term_id"], 'category' ).'" title="'.$term_details["name"].'">'.$term_details["name"].'</a></li>';
					}
					$ret_val .= "</ul>";
				} elseif('post_object' === $custom_field["type"]) {
					
					$post_obj = $custom_field["value"];
					$post_id = $post_obj->ID;
					$ret_val .= '<a href="'.get_permalink($post_id).'" title="'.get_the_title($post_id).'">'.get_the_title($post_id).'</a>';
					
				} elseif('relationship' === $custom_field["type"]) {
										
					$posts = $custom_field["value"];
					$ret_val = "<ul>";
					foreach($posts as $post_details) {						
						$post_id = $post_details->ID;
						$ret_val .= '<li><a href="'.get_permalink($post_id).'" title="'.get_the_title($post_id).'">'.get_the_title($post_id).'</a></li>';
					}
					$ret_val .= "</ul>";
				
				}
				
				if($ret_val == "data-mismatch") {
					// set the mismatch error message here.
					$ret_val = 'Data mismatch error. Custom field value doesn\'t match the field type. Please set the field value again.';
				}
				if ( 'yes' === $show_label) {
					if(!isset($ret_val)) {
						$ret_val = '<span class="sw-acf-field-label label-'.$field_key.'">'.$custom_field["label"].'</span> : '.$custom_field["value"];
					} else {
						$ret_val = '<span class="sw-acf-field-label label-'.$field_key.'">'.$custom_field["label"].'</span> : '.$ret_val;
					}
				} else {
					if(!isset($ret_val)) $ret_val = $custom_field["value"];
				}
							
				
				return '<div id="' . $field_key . '" class="' . esc_attr( $css_class ) . '">'.$ret_val. '</div>';
				
				/*return '<< Working on retrieving the data from ACF. >>';*/
				
			}
		}
		
		
	}
?>