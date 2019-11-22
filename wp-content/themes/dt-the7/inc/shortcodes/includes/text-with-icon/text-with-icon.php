<?php
/**
 * DT_Shortcode_Icon_Text
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Icon_Text', false ) ) {

	class DT_Shortcode_Icon_Text extends DT_Shortcode_With_Inline_Css {
		public static $instance = null;

		/**
		 * @return DT_Shortcode_Icon_Text
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {

			$this->sc_name = 'dt_icon_text';
			$this->unique_class_base = 'icon-text-id';

			$this->default_atts = array(
				'layout' => 'layout_5',
				'show_link' => 'n',
				'link' => '',
				'apply_link' => 'icon',
				'smooth_scroll' => 'n',

				'dt_text_title' => 'Your title goes here',
				'heading_tag' => 'h4',
				'dt_text_title_font_style' => ':bold:',
				'dt_text_title_font_size' => '',
				'dt_text_title_line_height' => '',
				'dt_text_custom_title_color' => '',
				'dt_text_title_bottom_margin' => '0px',

				'dt_text_desc' => 'Your text goes here. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'dt_text_content_font_style' => '',
				'dt_text_content_font_size' => '',
				'dt_text_content_line_height' => '',
				'dt_text_custom_content_color' => '',
				'dt_text_content_bottom_margin' => '0px',

				'show_btn' => 'y',
				'button_text' => 'Button name',
				'btn_size' => 'small',
				'btn_width' => '',
				'custom_btn_width' => '200px',
				'btn_animation' => 'none',
				'icon_type' => 'none',
				'icon' => '',
				'btn_icon_picker' => '',
				'icon_align' => '',
				'default_btn_bg'	   => 'y',
				'default_btn_bg_color' => '',
				'bg_hover_color'       => '',
				'default_btn_bg_hover' => 'y',
				'default_btn_border' => 'y',
				'default_btn_border_color' => '',
				'default_btn_hover' => 'y',
				'default_btn_border_hover' => 'y',
				'default_btn_border_hover_color' => '',
				'text_color'           => '',
				'text_hover_color'     => '',
				'btn_decoration' 	   => 'none',
				'font_size'            => '14px',
				'icon_size' 		=> '11px',
				'button_padding'       => '12px 18px 12px 18px',
				'border_radius'        => '1px',
				'border_width'         => '0px',

				'show_icon' => 'y',
				'icon_picker' => 'icomoon-the7-font-the7-mail-01',
				'dt_text_icon_size' => '32px',
				'dt_text_icon_color' => '#fff',
				'dt_text_icon_bg_size' => '60px',
				'dt_icon_bg' => 'y',
				'dt_text_icon_bg_color' => '',
				'dt_text_icon_border_radius' => '200px',
				'dt_text_icon_border_width' => '2',
				'icon_border_style'			=> 'solid',
				'dt_icon_border'		=> 'n',
				'dt_text_icon_border_color' => '',
				'dt_icon_hover'			=> 'n',
				'dt_icon_color_hover'	=> '#fff',
				'dt_icon_border_hover'	=> 'n',
				'dt_icon_border_color_hover'	=> '',
				'dt_icon_bg_hover'		=> 'y',
				'dt_icon_bg_color_hover'=> '',
				'dt_text_icon_paddings' => '0px 0px 0px 0px',

				'icon_animation'		 => 'none',
				
				'css_dt_carousel'         => '',
				'el_class' => '',
			);

			parent::__construct();
		}
		

		/**
		 * Do shortcode here.
		 */
		protected function do_shortcode( $atts, $content = '' ) {
			$output = '';
			$url = $this->atts['link'] ? $this->atts['link'] : '#';
			$link_title = $target = $rel = '';
			$disable_link ='';
			if ( function_exists( 'vc_build_link' ) ) {
				$link = vc_build_link( $this->atts['link'] );
				if ( ! empty( $link['url'] ) ) {
					$url = $link['url'];
					$target = ( empty( $link['target'] ) ? '' : sprintf( ' target="%s"', trim( $link['target'] ) ) );
					$link_title = ( empty( $link['title'] ) ? '' : sprintf( ' title="%s"', $link['title'] ) );
					$rel = ( empty( $link['rel'] ) ? '' : sprintf( ' rel="%s"', $link['rel'] ) );
				}
			}

			// smooth scroll
			if ( $this->atts['smooth_scroll'] ) {
				$anchorclass = 'anchor-link';
			}

			$icon_html = '';
			$icon_type = $this->atts['icon_type'];
			if ( $icon_type !== 'none' ) {
				if ( 'html' === $icon_type ) {
					if ( preg_match( '/^fa[a-z]*\s/', $this->atts['icon'] ) ) {
						$icon_html = '<i class="' . esc_attr( $this->atts['icon'] ) . '"></i>';
					} else {
						$icon_html = wp_kses( rawurldecode( base64_decode( $this->atts['icon'] ) ), array( 'i' => array( 'class' => array() ) ) );
					}
				} elseif ( ! empty( $this->atts[ "btn_icon_{$icon_type}" ] ) ) {
					$icon_html = '<i class="' . esc_attr( $this->atts[ "btn_icon_{$icon_type}" ] ) . '"></i>';
				}
			}

			$after_title  = '';
			$before_title = '';
			if ( 'right' === $this->atts['icon_align'] ) {
				$after_title = $icon_html;
			} else {
				$before_title = $icon_html;
			}

			$btn_width = '';
			if ( 'btn_fixed_width' === $this->atts['btn_width'] ) {
				$btn_width .= ' style="width:' . absint( $this->atts['custom_btn_width'] ) . 'px;"';
			}
			if(($this->atts['apply_link'] === 'button' || $this->atts['apply_link'] === 'title_button'|| $this->atts['apply_link'] === 'icon_title_button' || $this->atts['apply_link'] === 'icon_button' || $this->atts['apply_link'] === 'block') && $this->atts['show_link'] === 'y') {
				$btn_url = esc_attr( $url );
			}else {
				$btn_url = "";
				$disable_link = "not-clickable-item";
			}
			// get button html
			$button_html = presscore_get_button_html( array(

				'before_title' => $before_title,
				'after_title'  => $after_title,
				'href'			=> $btn_url,
				'title'			=> $this->atts['button_text'],
				'target'		=> $target,
				'class'			=> $this->get_html_class(array(  $anchorclass, $disable_link )),
				'atts'			=>   ($this->atts['link'] === 'button') ? $link_title . $rel : '' . $btn_width ,
			) );
			$show_icon = '';

			$dt_icon_attr = esc_attr( $this->atts['icon_picker'] );
			$heading_tag = $this->atts['heading_tag'];
			$output .= '<div ' . $this->get_container_html_class( array( 'icon-with-text-shortcode ' ) ) . ' >';
				if($this->atts['apply_link'] === 'block' && $this->atts['show_link'] === 'y'){
					$output .= '<a class="block-link '. $anchorclass .'" href="' . esc_attr( $url ) . '" '. $link_title . $rel .'></a>';
				}
				if ( $this->get_att( 'show_icon' ) === 'y' )

					if(($this->atts['apply_link'] === 'icon' || $this->atts['apply_link'] === 'icon_title_button' || $this->atts['apply_link'] === 'icon_button' || $this->atts['apply_link'] === 'block') && $this->atts['show_link'] === 'y'){
			
						$output .=  '<a title="'. $link_title .'" href="'. esc_attr( $url ) .'" '. $target . $rel . $this->get_html_icon_class( array(  $anchorclass )) .' ><span class="icon-inner"><i class="dt-regular-icon '. esc_attr( 'soc-icon ' . $dt_icon_attr ).'"></i><i class="dt-hover-icon '. esc_attr( 'soc-icon ' . $dt_icon_attr ).'"></i></span></a>';
					}else{

						$output .=  '<span  ' . $this->get_html_icon_class( ) .' ><span class="icon-inner"><i class="dt-regular-icon '. esc_attr( 'soc-icon ' . $dt_icon_attr ).'"></i><i class="dt-hover-icon '. esc_attr( 'soc-icon ' . $dt_icon_attr ).'"></i></span></span>';
					}
				if($this->atts['dt_text_title'] != '')
				
					if(($this->atts['apply_link'] === 'title' || $this->atts['apply_link'] === 'title_button' || $this->atts['apply_link'] === 'icon_title_button' || $this->atts['apply_link'] === 'block')  && $this->atts['show_link'] === 'y'){
						$output .= '<'. $heading_tag .' class="dt-text-title ' . $anchorclass . '"  ><a href="' . esc_attr( $url ) . '" '. $link_title . $rel .' class="' . $anchorclass . '">'.$this->atts['dt_text_title'].'</a></'. $heading_tag .'>';
					}else{
						$output .= '<'. $heading_tag .' class="dt-text-title"  >'.$this->atts['dt_text_title'].'</'. $heading_tag .'>';
					}
				if($this->atts['dt_text_desc'] != '')
					$output .= '<div class="dt-text-desc">'.$this->atts['dt_text_desc'].'</div>';
				if($this->atts['show_btn'] === 'y')
				{
					$output .= $button_html;
				}
			
			$output .= '</div>';
			echo $output;
		}
		
		protected function get_container_html_class( $class = array() ) {
			$el_class = $this->atts['el_class'];

			// Unique class.
			$class[] = $this->get_unique_class();

			
			$layout_classes = array(
				'layout_1' => 'layout-1',
				'layout_2' => 'layout-2',
				'layout_3' => 'layout-3',
				'layout_4' => 'layout-4',
				'layout_5' => 'layout-5',
			);
			

			$layout = $this->get_att( 'layout' );
			if ( array_key_exists( $layout, $layout_classes ) ) {
				$class[] = $layout_classes[ $layout ];
			}
			
			if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
				$class[] = vc_shortcode_custom_css_class( $this->atts['css_dt_carousel'], ' ' );
			};
			$class[] = $el_class;

			return 'class="' . esc_attr( implode( ' ', $class ) ) . '"';
		}
		protected function get_html_icon_class($class = array()) {
			//$el_class = $this->atts['el_class'];

			// Unique class.

			$class[] = 'text-icon';
			if ( $this->atts['dt_icon_bg' ] === 'y') {
				$class[] = 'dt-icon-bg-on';
			} else {
				$class[] = 'dt-icon-bg-off';
			}
			if($this->atts['dt_icon_border'] === 'y'){
				$class[] = 'dt-icon-border-on';
			}
			if($this->atts['dt_icon_hover'] === 'y'){
				$class[] = 'dt-icon-hover-on';
				if($this->atts['dt_icon_border_hover'] === 'y'){
					$class[] = 'dt-icon-hover-border-on';
				}
				if($this->atts['dt_icon_bg_hover'] === 'y'){
					$class[] = 'dt-icon-hover-bg-on';
				}else{
					$class[] = 'dt-icon-hover-bg-off';
				}
			}else{
				$class[] = 'dt-icon-hover-off';
			}
			switch ( $this->atts['icon_border_style']) {
				case 'dotted':
					$class[] = 'dt-icon-border-dotted';
					break;
				case 'dashed':
					$class[] = 'dt-icon-border-dashed';
					break;
				case 'double':
					$class[] = 'dt-icon-border-double';
					break;
			};
			switch ( $this->atts['icon_animation']) {
				case 'slide_up':
					$class[] = 'dt-icon-animate-slide-up';
					break;
				case 'slide_right':
					$class[] = 'dt-icon-animate-slide-right';
					break;
				case 'shadow':
					$class[] = 'dt-icon-animate-shadow';
					break;
				case 'spin_around':
					$class[] = 'dt-icon-animate-spin-around';
					break;
				case 'shadow':
					$class[] = 'dt-icon-animate-shadow';
					break;
				case 'scale':
					$class[] = 'dt-icon-animate-scale';
					break;
				case 'scale_down':
					$class[] = 'dt-icon-animate-scale-down';
					break;
			};
			//$class[] = $el_class;

			return 'class="' . esc_attr( implode( ' ', $class ) ) . '"';
		}

		protected function get_html_class($classes = array()) {
			// static classes
			$classes[] =  'default-btn-shortcode dt-btn' ;
			switch ( $this->atts['btn_size'] ) {
				case 'small':
					$classes[] = 'dt-btn-s';
					break;
				case 'medium':
					$classes[] = 'dt-btn-m';
					break;
				case 'big':
					$classes[] = 'dt-btn-l';
					break;
			};
			if ( presscore_shortcode_animation_on( $this->atts['btn_animation'] ) ) {
				$classes[] = presscore_get_shortcode_animation_html_class( $this->atts['btn_animation'] );
				$classes[] = 'animation-builder';
			}

			$icon_type = $this->atts['icon_type'];
			if ( 'html' === $icon_type ) {
				$there_is_an_icon = ! empty( $this->atts['icon'] );
			} else {
				$there_is_an_icon = ! empty( $this->atts[ "icon_{$icon_type}" ] );
			}
			// if ( 'y' === $this->atts['default_btn_bg'] ) {
			// 	$classes[] = 'default-btn-bg-on';
			// }else{
			// 	$classes[] = 'default-btn-bg-off';
			// } 
			// if ( 'y' === $this->atts['default_btn_bg_hover'] ) {
			// 	$classes[] = 'default-btn-bg-hover-on';
			// }else{
			// 	$classes[] = 'default-btn-bg-hover-off';
			// }


			if ( ! $this->get_flag( 'default_btn_hover' ) ) {
				$classes[] = 'btn-hover-off';
			}

			if ( $there_is_an_icon && 'right' === $this->atts['icon_align'] ) {
				$classes[] = 'ico-right-side';
			}
			if ( 'btn_full_width' === $this->atts['btn_width'] ) {
				$classes[] = 'full-width-btn';
			}
			if ('custom' ===  $this->atts['btn_size'] ) {
				switch ( $this->atts['btn_decoration'] ) {
					case 'none':
						$classes[] = 'btn-flat';
						$classes[] = 'btn-no-decoration';
						break;
					case 'btn_3d':
						$classes[] = 'btn-3d';
						break;
					case 'btn_shadow':
						$classes[] = 'btn-shadow';
						break;
				}
			}
			
			return  esc_attr( implode( ' ', $classes ) );
		}

		
		/**
		 * Setup theme config for shortcode.
		 */
		protected function setup_config() {
			$config = presscore_config();
		}
		/**
		 * Return array of prepared less vars to insert to less file.
		 *
		 * @return array
		 */
		protected function get_less_vars() {
			$less_vars = the7_get_new_shortcode_less_vars_manager();

			$less_vars->add_keyword( 'unique-shortcode-class-name', 'icon-with-text-shortcode.' . $this->get_unique_class(), '~"%s"' );

			$less_vars->add_keyword( 'dt-text-title-color', $this->get_att( 'dt_text_custom_title_color', '~""' ) );
			$less_vars->add_pixel_number( 'dt-text-title-font-size', $this->get_att( 'dt_text_title_font_size' ) );
			$less_vars->add_pixel_number( 'dt-text-title-line-height', $this->get_att( 'dt_text_title_line_height' ) );
			$less_vars->add_font_style( array(
				'dt-text-title-font-style',
				'dt-text-title-font-weight',
				'dt-text-title-text-transform',
			), $this->get_att( 'dt_text_title_font_style' ) );

			$less_vars->add_pixel_number( 'dt-text-title-margin-bottom', $this->get_att( 'dt_text_title_bottom_margin' ) );

			$less_vars->add_pixel_number( 'dt-text-content-font-size', $this->get_att( 'dt_text_content_font_size' ) );
			$less_vars->add_pixel_number( 'dt-text-content-line-height', $this->get_att( 'dt_text_content_line_height' ) );
			$less_vars->add_keyword( 'dt-text-content-color', $this->get_att( 'dt_text_custom_content_color', '~""' ) );
			$less_vars->add_font_style( array(
				'dt-text-content-font-style',
				'dt-text-content-font-weight',
				'dt-text-content-text-transform',
			), $this->get_att( 'dt_text_content_font_style' ) );
			$less_vars->add_pixel_number( 'dt-text-content-margin-bottom', $this->get_att( 'dt_text_content_bottom_margin' ) );

			$less_vars->add_pixel_number( 'dt-text-icon-size', $this->get_att( 'dt_text_icon_size' ) );
			$less_vars->add_pixel_number( 'dt-text-icon-bg-size', $this->get_att( 'dt_text_icon_bg_size' ) );
			$less_vars->add_pixel_number( 'dt-text-icon-border-width', $this->get_att( 'dt_text_icon_border_width' ) );
			$less_vars->add_pixel_number( 'dt-text-icon-border-radius', $this->get_att( 'dt_text_icon_border_radius' ) );
			$less_vars->add_keyword( 'dt-text-icon-color', $this->get_att( 'dt_text_icon_color', '~""' ) );
			$less_vars->add_keyword( 'dt-text-icon-border-color', $this->get_att( 'dt_text_icon_border_color', '~""' ) );
			$less_vars->add_keyword( 'dt-text-icon-bg-color', $this->get_att( 'dt_text_icon_bg_color', '~""' ) );

			$less_vars->add_keyword( 'dt-icon-color-hover', $this->get_att( 'dt_icon_color_hover', '~""' ) );

			$less_vars->add_keyword( 'dt-icon-border-color-hover', $this->get_att( 'dt_icon_border_color_hover', '~""' ) );
			$less_vars->add_keyword( 'dt-icon-bg-color-hover', $this->get_att( 'dt_icon_bg_color_hover', '~""' ) );
			$less_vars->add_paddings( array(
				'dt-text-icon-margin-top',
				'dt-text-icon-margin-right',
				'dt-text-icon-margin-bottom',
				'dt-text-icon-margin-left',
			), $this->get_att( 'dt_text_icon_paddings' ) );


			if ( $this->get_att( 'btn_size' ) === 'custom' ) {
				$btn_padding       = array(
					'btn-padding-top',
					'btn-padding-right',
					'btn-padding-bottom',
					'btn-padding-left',
				);
				$btn_hover_padding = array(
					'btn-padding-top-hover',
					'btn-padding-right-hover',
					'btn-padding-bottom-hover',
					'btn-padding-left-hover',
				);
				$less_vars->add_paddings( $btn_padding, $this->get_att( 'button_padding' ) );
				$less_vars->add_paddings( $btn_hover_padding, $this->get_att( 'button_padding' ) );

				$less_vars->add_pixel_number( 'btn-icon-size', $this->get_att( 'icon_size' ) );
				$less_vars->add_pixel_number( 'btn-font-size', $this->get_att( 'font_size' ) );
				$less_vars->add_pixel_number( 'btn-border-radius', $this->get_att( 'border_radius' ) );

				$less_vars->add_keyword( 'btn-color', $this->get_att( 'text_color' ) );
				$less_vars->add_keyword( 'btn-bg-color', 'none' );
				if ( $this->get_flag( 'default_btn_bg' ) ) {
					$less_vars->add_keyword( 'btn-bg-color', $this->get_att( 'default_btn_bg_color' ) );
				}
				$less_vars->add_keyword( 'btn-border-color', $this->get_att( 'default_btn_border_color' ) );

				$border_width = $this->get_att( 'border_width' );

				// Take care of border width.
				$less_vars->add_pixel_number( 'btn-border-width', $border_width );
				if ( ! $this->get_flag( 'default_btn_border' ) ) {
					$less_vars->add_pixel_number( 'btn-border-width', 0 );
					$less_vars->add_pixel_number( 'btn-pi', $border_width );
				}

				if ( $this->get_flag( 'default_btn_hover' ) ) {
					$less_vars->add_keyword( 'btn-color-hover', $this->get_att( 'text_hover_color' ) );
					$less_vars->add_keyword( 'btn-bg-color-hover', 'none' );
					if ( $this->get_flag( 'default_btn_bg_hover' ) ) {
						$less_vars->add_keyword( 'btn-bg-color-hover', $this->get_att( 'bg_hover_color' ) );
					}
					$less_vars->add_keyword( 'btn-border-color-hover', $this->get_att( 'default_btn_border_hover_color' ) );

					// Take care of border width on hover.
					$less_vars->add_pixel_number( 'btn-border-width-hover', $border_width );
					if ( ! $this->get_flag( 'default_btn_border_hover' ) ) {
						$less_vars->add_pixel_number( 'btn-border-width-hover', 0 );
						$less_vars->add_pixel_number( 'btn-pi-h', $border_width );
					}
				} else {
					// Fill hover vars with regular values.
					$less_vars->add_keyword( 'btn-color-hover', $less_vars->get_var( 'btn-color' ) );
					$less_vars->add_keyword( 'btn-bg-color-hover', $less_vars->get_var( 'btn-bg-color' ) );
					$less_vars->add_keyword( 'btn-border-color-hover', $less_vars->get_var( 'btn-border-color' ) );
					$less_vars->add_pixel_number( 'btn-border-width-hover', $less_vars->get_var( 'btn-border-width' ) );
					if ( $less_vars->get_var( 'btn-pi' ) ) {
						$less_vars->add_pixel_number( 'btn-pi-h', $less_vars->get_var( 'btn-pi' ) );
					}
				}
			}
			

			return $less_vars->get_vars();
		}
		protected function get_less_file_name() {
			// @TODO: Remove in production.
			$less_file_name = 'text-with-icon';

			$less_file_path = trailingslashit( get_template_directory() ) . "css/dynamic-less/shortcodes/{$less_file_name}.less";
			return $less_file_path;
		}
		/**
		 * Return dummy html for VC inline editor.
		 *
		 * @return string
		 */
		protected function get_vc_inline_html($content = '') {
			return $content;
		}

	}
	
	// create shortcode
	DT_Shortcode_Icon_Text::get_instance()->add_shortcode();	
	
	


}
