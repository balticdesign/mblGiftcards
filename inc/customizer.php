<?php
/**
 * UnderStrap Theme Customizer
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if ( ! function_exists( 'understrap_customize_register' ) ) {
	/**
	 * Register basic customizer support.
	 *
	 * @param object $wp_customize Customizer reference.
	 */
	function understrap_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'understrap_customize_register' );

if ( ! function_exists( 'understrap_theme_customize_register' ) ) {
	/**
	 * Register individual settings through customizer's API.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer reference.
	 */
	function understrap_theme_customize_register( $wp_customize ) {

		// Theme layout settings.
		$wp_customize->add_section(
			'understrap_theme_layout_options',
			array(
				'title'       => __( 'Theme Layout Settings', 'understrap' ),
				'capability'  => 'edit_theme_options',
				'description' => __( 'Container width and sidebar defaults', 'understrap' ),
				'priority'    => apply_filters( 'understrap_theme_layout_options_priority', 160 ),
			)
		);

		/**
		 * Select sanitization function
		 *
		 * @param string               $input   Slug to sanitize.
		 * @param WP_Customize_Setting $setting Setting instance.
		 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
		 */
		function understrap_theme_slug_sanitize_select( $input, $setting ) {

			// Ensure input is a slug (lowercase alphanumeric characters, dashes and underscores are allowed only).
			$input = sanitize_key( $input );

			// Get the list of possible select options.
			$choices = $setting->manager->get_control( $setting->id )->choices;

			// If the input is a valid key, return it; otherwise, return the default.
			return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

		}

		

		$wp_customize->add_setting(
			'understrap_container_type',
			array(
				'default'           => 'container',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'understrap_theme_slug_sanitize_select',
				'capability'        => 'edit_theme_options',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'understrap_container_type',
				array(
					'label'       => __( 'Container Width', 'understrap' ),
					'description' => __( 'Choose between Bootstrap\'s container and container-fluid', 'understrap' ),
					'section'     => 'understrap_theme_layout_options',
					'settings'    => 'understrap_container_type',
					'type'        => 'select',
					'choices'     => array(
						'container'       => __( 'Fixed width container', 'understrap' ),
						'container-fluid' => __( 'Full width container', 'understrap' ),
					),
					'priority'    => apply_filters( 'understrap_container_type_priority', 10 ),
				)
			)
		);

		$wp_customize->add_setting(
			'understrap_sidebar_position',
			array(
				'default'           => 'right',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'capability'        => 'edit_theme_options',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'understrap_sidebar_position',
				array(
					'label'             => __( 'Sidebar Positioning', 'understrap' ),
					'description'       => __(
						'Set sidebar\'s default position. Can either be: right, left, both or none. Note: this can be overridden on individual pages.',
						'understrap'
					),
					'section'           => 'understrap_theme_layout_options',
					'settings'          => 'understrap_sidebar_position',
					'type'              => 'select',
					'sanitize_callback' => 'understrap_theme_slug_sanitize_select',
					'choices'           => array(
						'right' => __( 'Right sidebar', 'understrap' ),
						'left'  => __( 'Left sidebar', 'understrap' ),
						'both'  => __( 'Left & Right sidebars', 'understrap' ),
						'none'  => __( 'No sidebar', 'understrap' ),
					),
					'priority'          => apply_filters( 'understrap_sidebar_position_priority', 20 ),
				)
			)
		);
		
		
		$wp_customize->add_setting('hide_product_title_price', array(
			'default'    => '1',
			'sanitize_callback' => $pgwp_sanitize,
		));
		
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'show_footer_facebook',
				array(
					'label'     => __('Hide Product Title & Price'),
					'section'   => 'understrap_theme_layout_options',
					'settings'  => 'hide_product_title_price',
					'type'      => 'checkbox',
				)
			)
		);

		/* Dan's Go at this */


/**
 * Enqueue scripts for our Customizer preview
 *
 * @return void
 */
if ( ! function_exists( 'skyrocket_customizer_preview_scripts' ) ) {
	function skyrocket_customizer_preview_scripts() {
		wp_enqueue_script( 'skyrocket-customizer-preview', get_template_directory_uri() . '/js/customizer-preview.js', array( 'customize-preview', 'jquery' ) );
	}
}
add_action( 'customize_preview_init', 'skyrocket_customizer_preview_scripts' );

    /**
	 * Slider Custom Control
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */

    class Skyrocket_Custom_Control extends WP_Customize_Control {
		protected function get_skyrocket_resource_url() {
			if( strpos( wp_normalize_path( __DIR__ ), wp_normalize_path( WP_PLUGIN_DIR ) ) === 0 ) {
				// We're in a plugin directory and need to determine the url accordingly.
				return plugin_dir_url( __DIR__ );
			}

			return trailingslashit( get_template_directory_uri() );
		}
	}

	class Skyrocket_Slider_Custom_Control extends Skyrocket_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'slider_control';
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_script( 'skyrocket-custom-controls-js', get_template_directory_uri() . '/js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.0', true );
			wp_enqueue_style( 'skyrocket-custom-controls-css', get_template_directory_uri() . '/css/customizer.css', array(), '1.0', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
		?>
			<div class="slider-custom-control">
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><input type="number" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-slider-value" <?php $this->link(); ?> />
				<div class="slider" slider-min-value="<?php echo esc_attr( $this->input_attrs['min'] ); ?>" slider-max-value="<?php echo esc_attr( $this->input_attrs['max'] ); ?>" slider-step-value="<?php echo esc_attr( $this->input_attrs['step'] ); ?>"></div><span class="slider-reset dashicons dashicons-image-rotate" slider-reset-value="<?php echo esc_attr( $this->value() ); ?>"></span>
			</div>
		<?php
		}
	}
	
	class Skyrocket_Alpha_Color_Control extends Skyrocket_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'wpcolorpicker-alpha-color';
		/**
		 * ColorPicker Attributes
		 */
		public $attributes = "";
		/**
		 * Color palette defaults
		 */
		public $defaultPalette = array(
			'#000000',
			'#ffffff',
			'#dd3333',
			'#dd9933',
			'#eeee22',
			'#81d742',
			'#1e73be',
			'#8224e3',
		);
		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
			$this->attributes .= 'data-default-color="' . esc_attr( $this->value() ) . '"';
			$this->attributes .= 'data-alpha="true"';
			$this->attributes .= 'data-reset-alpha="' . ( isset( $this->input_attrs['resetalpha'] ) ? $this->input_attrs['resetalpha'] : 'true' ) . '"';
			$this->attributes .= 'data-custom-width="0"';
		}
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_script( 'wp-color-picker-alpha', get_template_directory_uri() . '/js/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.0', true );
			wp_enqueue_style( 'wp-color-picker' );
		}
		/**
		 * Pass our Palette colours to JavaScript
		 */
		public function to_json() {
			parent::to_json();
			$this->json['colorpickerpalette'] = isset( $this->input_attrs['palette'] ) ? $this->input_attrs['palette'] : $this->defaultPalette;
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
		?>
		  <div class="wpcolorpicker_alpha_color_control">
				<?php if( !empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<input type="text" class="color-picker" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-colorpicker-alpha-color" <?php echo $this->attributes; ?> <?php $this->link(); ?> />
			</div>
		<?php
		}
	}

	/**
	 * Alpha Color (Hex & RGBa) sanitization
	 *
	 * @param  string	Input to be sanitized
	 * @return string	Sanitized input
	 */
	if ( ! function_exists( 'skyrocket_hex_rgba_sanitization' ) ) {
		function skyrocket_hex_rgba_sanitization( $input, $setting ) {
			if ( empty( $input ) || is_array( $input ) ) {
				return $setting->default;
			}

			if ( false === strpos( $input, 'rgba' ) ) {
				// If string doesn't start with 'rgba' then santize as hex color
				$input = sanitize_hex_color( $input );
			} else {
				// Sanitize as RGBa color
				$input = str_replace( ' ', '', $input );
				sscanf( $input, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
				$input = 'rgba(' . skyrocket_in_range( $red, 0, 255 ) . ',' . skyrocket_in_range( $green, 0, 255 ) . ',' . skyrocket_in_range( $blue, 0, 255 ) . ',' . skyrocket_in_range( $alpha, 0, 1 ) . ')';
			}
			return $input;
		}
	}

	/**
	 * Only allow values between a certain minimum & maxmium range
	 *
	 * @param  number	Input to be sanitized
	 * @return number	Sanitized input
	 */
	if ( ! function_exists( 'skyrocket_in_range' ) ) {
		function skyrocket_in_range( $input, $min, $max ){
			if ( $input < $min ) {
				$input = $min;
			}
			if ( $input > $max ) {
				$input = $max;
			}
			return $input;
		}
	}
    
    if ( ! function_exists( 'skyrocket_sanitize_integer' ) ) {
		function skyrocket_sanitize_integer( $input ) {
			return (int) $input;
		}
	}

      $wp_customize->add_setting( 'logo_vertical_padding',
	array(
		'default' => 48,
		'sanitize_callback' => 'skyrocket_sanitize_integer'
	)
);
$wp_customize->add_control( new Skyrocket_Slider_Custom_Control( $wp_customize, 'logo_vertical_padding',
	array(
		'label' => esc_html__( 'Header Padding (Vertical) (px)' ),
		'section' => 'title_tagline',
		'input_attrs' => array(
			'min' => 0, // Required. Minimum value for the slider
			'max' => 90, // Required. Maximum value for the slider
			'step' => 1, // Required. The size of each interval or step the slider takes between the minimum and maximum values
		),
	)
) );

$wp_customize->add_setting( 'header_configuration', array(
    'default' => 'left_logo',
     // Sanitize on insertion
  'sanitize_callback' => $pgwp_sanitize,
) );

$wp_customize->add_control( 'header_configuration', array(
    'type' => 'select',
    'priority' => 0, // Within the section.
  'section' => 'understrap_theme_layout_options', // Required, core or custom.
  'label' => __( 'Logo Position' ),
  'choices' => array(
    'left_logo' => 'Left Aligned',
    'center_logo' =>'Centered',
    'right_logo'  =>'Right Aligned',
  ),
  'description' => __( 'Choose Your Logo Alignment' ),
   ) );


   $wp_customize->add_setting( 'home_bkg',
   array(
	   'default' => '',
   )
);

   $wp_customize->add_control( new WP_Customize_Image_Control ( $wp_customize, 'home_bkg', array(
	'label' => 'Homepage Background',
	'description' => esc_html__( 'Choose a background for the homepage' ),
	'section' => 'static_front_page',
) ) );

$wp_customize->add_setting( 'home_bkg_size', array(
    'default' => 'cover',
     // Sanitize on insertion
  'sanitize_callback' => $pgwp_sanitize,
) );

$wp_customize->add_control( 'home_bkg_size', array(
    'type' => 'select',
    'priority' => 10, // Within the section.
  'section' => 'static_front_page', // Required, core or custom.
  'label' => __( 'Home Background Size' ),
  'choices' => array(
    'auto' => 'Auto',
    'cover' =>'Cover',
	'contain'  => 'Contain',
	'inherit' => 'Inherit',
  ),
  'description' => __( 'Choose Background Sizing' ),
   ) );

   $wp_customize->add_setting( 'home_bkg_pos', array(
    'default' => 'center',
     // Sanitize on insertion
  'sanitize_callback' => $pgwp_sanitize,
) );

$wp_customize->add_control( 'home_bkg_pos', array(
    'type' => 'select',
    'priority' => 10, // Within the section.
  'section' => 'static_front_page', // Required, core or custom.
  'label' => __( 'Home Background Position' ),
  'choices' => array(
    'left' => 'Left',
    'center' =>'Center',
	'right'  => 'Right',
  ),
  'description' => __( 'Choose Background Position' ),
   ) );

   $wp_customize->add_setting( 'home_cta_color',
	array(
		'default' => '',
		'sanitize_callback' => 'skyrocket_hex_rgba_sanitization'
	)
);
$wp_customize->add_control( new Skyrocket_Alpha_Color_Control( $wp_customize, 'home_cta_color',
	array(
		'label' => __( 'CTA Transparent Overlay' ),
		'description' => esc_html__( 'This is a control for Transparent Overlay on the optional homepage CTA' ),
		'section' => 'static_front_page',
	)
) );

   $wp_customize->add_setting( 'background_top_margin', array(
    'default' => '0',
     // Sanitize on insertion
  'sanitize_callback' => $pgwp_sanitize,
) );

$wp_customize->add_setting( 'cta_text_color', array(
    'default' => 'text-dark',
     // Sanitize on insertion
  'sanitize_callback' => $pgwp_sanitize,
) );

$wp_customize->add_control( 'cta_text_color', array(
    'type' => 'select',
    'priority' => 10, // Within the section.
  'section' => 'static_front_page', // Required, core or custom.
  'label' => __( 'Preffered Text Color' ),
  'choices' => array(
    'text-light' => 'Light Text / Dark Background',
    'text-dark' => 'Dark Text / Light Background',
  ),
  'description' => __( 'Choose best colour to contrast background' ),
   ) );

$wp_customize->add_setting( 'cta_vertical_top_margin',
   array(
	   'default' => 48,
	   'sanitize_callback' => 'skyrocket_sanitize_integer'
   )
);
$wp_customize->add_control( new Skyrocket_Slider_Custom_Control( $wp_customize, 'cta_vertical_top_margin',
   array(
	'priority' => 11,
	   'label' => esc_html__( 'CTA Top Margin (Vertical) (px)' ),
	   'section' => 'static_front_page',
	   'input_attrs' => array(
		   'min' => 0, // Required. Minimum value for the slider
		   'max' => 800, // Required. Maximum value for the slider
		   'step' => 1, // Required. The size of each interval or step the slider takes between the minimum and maximum values
	   ),
   )
) );

$wp_customize->add_setting( 'mobile_vertical_top_margin',
   array(
	   'default' => 10,
	   'sanitize_callback' => 'skyrocket_sanitize_integer'
   )
);
$wp_customize->add_control( new Skyrocket_Slider_Custom_Control( $wp_customize, 'mobile_vertical_top_margin',
   array(
	'priority' => 11,
	   'label' => esc_html__( 'Mobile CTA Top Margin (Vertical) (px)' ),
	   'section' => 'static_front_page',
	   'input_attrs' => array(
		   'min' => 0, // Required. Minimum value for the slider
		   'max' => 800, // Required. Maximum value for the slider
		   'step' => 1, // Required. The size of each interval or step the slider takes between the minimum and maximum values
	   ),
   )
) );


$wp_customize->add_setting( 'header_overlay_color',
	array(
		'default' => '',
		'sanitize_callback' => 'skyrocket_hex_rgba_sanitization'
	)
);
$wp_customize->add_control( new Skyrocket_Alpha_Color_Control( $wp_customize, 'header_overlay_color',
	array(
		'label' => __( 'Transparent Header Overlay' ),
		'description' => esc_html__( 'This is a control for Transparent Header Overlay if there is a backgroud image' ),
		'section' => 'title_tagline',
	)
) );


$wp_customize->add_control( 'background_top_margin', array(
	'type' => 'number',
    'priority' => 0, // Within the section.
  'section' => 'background_image', // Required, core or custom.
  'label' => __( 'Background Top Margin' ),
  'input_attrs' => array(
    'min' => 0,
    'max' => 800,
    'step' => 1,
  ),
  'description' => __( 'This is a control for a margin to push the background image down.' ),
   ) );



$wp_customize->add_section( 'baltic_form_settings', array(
    'title' => __( 'Form Settings', '' ),
    'description' => __( 'Change Form Attributes', '' ),
    'priority' => '5'
));

$wp_customize->add_setting( 'form_border_radius', array(
    'default' => '0',
     // Sanitize on insertion
  'sanitize_callback' => $pgwp_sanitize,
) );

$wp_customize->add_control( 'form_border_radius', array(
    'type' => 'number',
    'priority' => 0, // Within the section.
  'section' => 'baltic_form_settings', // Required, core or custom.
  'label' => __( 'Border Radius' ),
  'input_attrs' => array(
    'min' => 0,
    'max' => 6,
    'step' => 2,
  ),
  'description' => __( 'This is a control for border radius.' ),
   ) );

   $wp_customize->add_setting( 'form_borders', array(
    'default' => 'none',
     // Sanitize on insertion
  'sanitize_callback' => $pgwp_sanitize,
) );

$wp_customize->add_control( 'form_borders', array(
    'type' => 'select',
    'priority' => 0, // Within the section.
  'section' => 'baltic_form_settings', // Required, core or custom.
  'label' => __( 'Add borders to forms?' ),
  'choices' => array(
    'none' => 'No borders',
    '1px solid' => '1px Solid',
  ),
  'description' => __( 'Add Borders to Forms' ),
   ) );

   $wp_customize->add_setting( 'border_color', array(
	'default' => '#fff',
	'type' => 'theme_mod',
     // Sanitize on insertion
  'sanitize_callback' => 'sanitize_hex_color',
) );

// add color picker control
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'border_color', array(
	'label' => 'Border Color',
	'section' => 'baltic_form_settings',
	'settings' => 'border_color',
) ) );

$wp_customize->add_setting( 'input_color', array(
	'default' => '#fff',
	'type' => 'theme_mod',
     // Sanitize on insertion
  'sanitize_callback' => 'sanitize_hex_color',
) );

// add color picker control
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'input_color', array(
	'label' => 'Form Text Color',
	'section' => 'baltic_form_settings',
	'settings' => 'input_color',
) ) );

    // add color picker setting
$wp_customize->add_setting( 'primary_color', array(
	'default' => '#ff0000',
	'type' => 'theme_mod',
     // Sanitize on insertion
  'sanitize_callback' => 'sanitize_hex_color',
) );

// add color picker control
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
	'label' => 'Primary Color',
	'section' => 'colors',
	'settings' => 'primary_color',
) ) );

$wp_customize->add_setting( 'cta_color', array(
	'default' => '#ff0000',
	'type' => 'theme_mod',
     // Sanitize on insertion
  'sanitize_callback' => 'sanitize_hex_color',
) );

// add color picker control
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cta_color', array(
	'label' => 'Call to action colour',
	'section' => 'colors',
	'settings' => 'cta_color',
) ) );

$wp_customize->add_setting( 'cta_color_hover', array(
	'default' => '#ff0000',
	'type' => 'theme_mod',
     // Sanitize on insertion
  'sanitize_callback' => 'sanitize_hex_color',
) );

// add color picker control
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cta_color_hover', array(
	'label' => 'Call to action :hover colour',
	'section' => 'colors',
	'settings' => 'cta_color_hover',
) ) );

$wp_customize->add_setting( 'page_overlay_color',
	array(
		'default' => '',
		'sanitize_callback' => 'skyrocket_hex_rgba_sanitization'
	)
);
$wp_customize->add_control( new Skyrocket_Alpha_Color_Control( $wp_customize, 'page_overlay_color',
	array(
		'label' => __( 'Transparent Overlay' ),
		'description' => esc_html__( 'This is a control for Transparent Overlay if there is a backgroud image' ),
		'section' => 'background_image',
	)
) );

$wp_customize->add_setting( 'content_overlay_color',
	array(
		'default' => '',
		'sanitize_callback' => 'skyrocket_hex_rgba_sanitization'
	)
);
$wp_customize->add_control( new Skyrocket_Alpha_Color_Control( $wp_customize, 'content_overlay_color',
	array(
		'label' => __( 'Content Background' ),
		'description' => esc_html__( 'This is a control for Content Background if there is a backgroud image' ),
		'section' => 'background_image',
	)
) );
  
  

$wp_customize->add_setting( 'accent_color1', array(
	'default' => '#ff0000',
	'type' => 'theme_mod',
     // Sanitize on insertion
  'sanitize_callback' => 'sanitize_hex_color',
) );

// add color picker control
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color1', array(
	'label' => 'Accent Color 1',
	'section' => 'colors',
	'settings' => 'accent_color1',
) ) );

/*$wp_customize->add_setting( 'accent_color1_hover', array(
	'default' => '#ff0000',
	'type' => 'theme_mod',
     // Sanitize on insertion
  'sanitize_callback' => 'sanitize_hex_color',
) );

// add color picker control
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color1_hover', array(
	'label' => 'Accent Color 1 : Hover',
	'section' => 'colors',
	'settings' => 'accent_color1_hover',
) ) ); */

$wp_customize->add_setting( 'accent_color2', array(
	'default' => '#ff0000',
	'type' => 'theme_mod',
     // Sanitize on insertion
  'sanitize_callback' => 'sanitize_hex_color',
) );

// add color picker control
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color2', array(
	'label' => 'Accent Color 2',
	'section' => 'colors',
	'settings' => 'accent_color2',
) ) );

/*$wp_customize->add_setting( 'accent_color2_hover', array(
	'default' => '#ff0000',
	'type' => 'theme_mod',
     // Sanitize on insertion
  'sanitize_callback' => 'sanitize_hex_color',
) );

// add color picker control
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color2_hover', array(
	'label' => 'Accent Color 2 : Hover',
	'section' => 'colors',
	'settings' => 'accent_color2_hover',
) ) ); */
	}
} // endif function_exists( 'understrap_theme_customize_register' ).
add_action( 'customize_register', 'understrap_theme_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
if ( ! function_exists( 'understrap_customize_preview_js' ) ) {
	/**
	 * Setup JS integration for live previewing.
	 */
	function understrap_customize_preview_js() {
		wp_enqueue_script(
			'understrap_customizer',
			get_template_directory_uri() . '/js/customizer.js',
			array( 'customize-preview' ),
			'20130508',
			true
		);
	}
}
add_action( 'customize_preview_init', 'understrap_customize_preview_js' );
