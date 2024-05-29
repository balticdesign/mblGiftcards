<?php
/**
 * Add WooCommerce support
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'understrap_woocommerce_support' );
if ( ! function_exists( 'understrap_woocommerce_support' ) ) {
	/**
	 * Declares WooCommerce theme support.
	 */
	function understrap_woocommerce_support() {
		add_theme_support( 'woocommerce' );

		// Add New Woocommerce 3.0.0 Product Gallery support.
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-slider' );

		// hook in and customizer form fields.
		add_filter( 'woocommerce_form_field_args', 'understrap_wc_form_field_args', 10, 3 );
	}
}

/**
 * First unhook the WooCommerce wrappers
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Then hook in your own functions to display the wrappers your theme requires
 */
add_action( 'woocommerce_before_main_content', 'understrap_woocommerce_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'understrap_woocommerce_wrapper_end', 10 );
if ( ! function_exists( 'understrap_woocommerce_wrapper_start' ) ) {
	function understrap_woocommerce_wrapper_start() {
		$container = get_theme_mod( 'understrap_container_type' );
		echo '<div class="wrapper" id="woocommerce-wrapper">';
		echo '<div class="' . esc_attr( $container ) . '" id="content" tabindex="-1">';
		echo '<div class="row">';
		get_template_part( 'global-templates/left-sidebar-check' );
		echo '<main class="site-main" id="main">';
	}
}
if ( ! function_exists( 'understrap_woocommerce_wrapper_end' ) ) {
	function understrap_woocommerce_wrapper_end() {
		echo '</main><!-- #main -->';
		get_template_part( 'global-templates/right-sidebar-check' );
		echo '</div><!-- .row -->';
		echo '</div><!-- Container end -->';
		echo '</div><!-- Wrapper end -->';
	}
}


/**
 * Filter hook function monkey patching form classes
 * Author: Adriano Monecchi http://stackoverflow.com/a/36724593/307826
 *
 * @param string $args Form attributes.
 * @param string $key Not in use.
 * @param null   $value Not in use.
 *
 * @return mixed
 */
if ( ! function_exists( 'understrap_wc_form_field_args' ) ) {
	function understrap_wc_form_field_args( $args, $key, $value = null ) {
		// Start field type switch case.
		switch ( $args['type'] ) {
			/* Targets all select input type elements, except the country and state select input types */
			case 'select':
				// Add a class to the field's html element wrapper - woocommerce
				// input types (fields) are often wrapped within a <p></p> tag.
				$args['class'][] = 'form-group';
				// Add a class to the form input itself.
				$args['input_class']       = array( 'form-control', 'input-lg' );
				$args['label_class']       = array( 'control-label' );
				$args['custom_attributes'] = array(
					'data-plugin'      => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden'      => 'true',
					// Add custom data attributes to the form input itself.
				);
				break;
			// By default WooCommerce will populate a select with the country names - $args
			// defined for this specific input type targets only the country select element.
			case 'country':
				$args['class'][]     = 'form-group single-country';
				$args['label_class'] = array( 'control-label' );
				break;
			// By default WooCommerce will populate a select with state names - $args defined
			// for this specific input type targets only the country select element.
			case 'state':
				// Add class to the field's html element wrapper.
				$args['class'][] = 'form-group';
				// add class to the form input itself.
				$args['input_class']       = array( '', 'input-lg' );
				$args['label_class']       = array( 'control-label' );
				$args['custom_attributes'] = array(
					'data-plugin'      => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden'      => 'true',
				);
				break;
			case 'password':
			case 'text':
			case 'email':
			case 'tel':
			case 'number':
				$args['class'][]     = 'form-group';
				$args['input_class'] = array( 'form-control', 'input-lg' );
				$args['label_class'] = array( 'control-label' );
				break;
			case 'textarea':
				$args['input_class'] = array( 'form-control', 'input-lg' );
				$args['label_class'] = array( 'control-label' );
				break;
			case 'checkbox':
				$args['label_class'] = array( 'custom-control custom-checkbox' );
				$args['input_class'] = array( 'custom-control-input', 'input-lg' );
				break;
			case 'radio':
				$args['label_class'] = array( 'custom-control custom-radio' );
				$args['input_class'] = array( 'custom-control-input', 'input-lg' );
				break;
			default:
				$args['class'][]     = 'form-group';
				$args['input_class'] = array( 'form-control', 'input-lg' );
				$args['label_class'] = array( 'control-label' );
				break;
		} // end switch ($args).
		return $args;
	}
}

if ( ! is_admin() && ! function_exists( 'wc_review_ratings_enabled' ) ) {
	/**
	 * Check if reviews are enabled.
	 *
	 * Function introduced in WooCommerce 3.6.0., include it for backward compatibility.
	 *
	 * @return bool
	 */
	function wc_reviews_enabled() {
		return 'yes' === get_option( 'woocommerce_enable_reviews' );
	}

	/**
	 * Check if reviews ratings are enabled.
	 *
	 * Function introduced in WooCommerce 3.6.0., include it for backward compatibility.
	 *
	 * @return bool
	 */
	function wc_review_ratings_enabled() {
		return wc_reviews_enabled() && 'yes' === get_option( 'woocommerce_enable_review_rating' );
	}
}
add_action('woocommerce_before_add_to_cart_button','baltic_add_custom_fields');
function baltic_add_custom_fields()
{

    global $product;

    ob_start();

    ?>
        <div class="baltic-gf-message">
			<label class="label tabsteps si_font">3. Add Message</label>
            <div><textarea name="baltic_message"></textarea></div>
        </div>
		<div class="clear"></div>
		
		<div class="baltic-gf-shipping">
		<label class="label tabsteps si_font">4. Delivery Informartion</label>
		<input id="shipping_first_name" name="shipping_first_name"  placeholder="First Name"/>
		<input id="shipping_last_name" name="shipping_last_name"  placeholder="Surname"/>
		<input id="shipping_address_1" name="shipping_address_1"  placeholder="Address Line 1"/>
		<input id="shipping_address_2" name="shipping_address_2" placeholder="Address Line 2"/>
		<input id="shipping_city" name="shipping_city" placeholder="Town/City"/>
		<input id="shipping_postcode" name="shipping_postcode" placeholder="Postcode"/>
</div>
    <?php

    ob_end_flush();

}
add_filter('woocommerce_add_cart_item_data','baltic_add_item_data',20,2);

/**
 * Add custom data to Cart
 * @param  [type] $cart_item_data [description]
 * @param  [type] $product_id     [description]
 * @param  [type] $variation_id   [description]
 * @return [type]                 [description]
 */
function baltic_add_item_data($cart_item_data, $product_id )
{

    if(isset($_REQUEST['baltic_message']))
    
		$cart_item_data['baltic_data']['1'] = array( 
			'label' => 'Message',
			'value' => sanitize_text_field($_REQUEST['baltic_message']),
	);
	
	
	if(isset($_REQUEST['shipping_first_name']))
   
        $cart_item_data['baltic_data']['2'] = array( 
			'label' => 'Name',
			'value' =>  sanitize_text_field($_REQUEST['shipping_first_name']),
		);

		if(isset($_REQUEST['shipping_last_name']))
   
        $cart_item_data['baltic_data']['3'] = array( 
			'label' => 'Name',
			'value' =>  sanitize_text_field($_REQUEST['shipping_last_name']),
		);

		if(isset($_REQUEST['shipping_address_1']))
   
        $cart_item_data['baltic_data']['2'] = array( 
			'label' => 'Name',
			'value' =>  sanitize_text_field($_REQUEST['shipping_address_1']),
		);
	if(isset($_REQUEST['shipping_postcode']))
    
        $cart_item_data['baltic_data']['3'] = array( 
			'label' => 'Postcode',
			'value' =>  sanitize_text_field($_REQUEST['shipping_postcode']),
		);

    return $cart_item_data;
}

add_filter('woocommerce_get_item_data','baltic_add_item_meta',10,2);

/**
 * Display information as Meta on Cart page
 * @param  [type] $item_data [description]
 * @param  [type] $cart_item [description]
 * @return [type]            [description]
 */
function baltic_add_item_meta($item_data, $cart_item)
{

    $custom_items = array();

    if( !empty( $cart_data ) )
        $custom_items = $item_data;

    if( isset( $cart_item['baltic_data'] ) ) {
        foreach( $cart_item['baltic_data'] as $key => $custom_data ){
            if( $key != 'key' ){
                $custom_items[] = array(
                    'name' => $custom_data['label'],
                    'value' => $custom_data['value'],
                );
            }
        }
    }
    return $custom_items;
}

add_action( 'woocommerce_checkout_create_order_line_item', 'baltic_add_custom_order_line_item_meta',10,4 );

function baltic_add_custom_order_line_item_meta($item, $cart_item_key, $values, $order)
{

    if(array_key_exists('baltic_message', $values))
    {
        $item->add_meta_data('_baltic_message',$values['baltic_message']);
    }
}

/**
 * Dynamically pre-populate Woocommerce checkout fields with exact named meta field
 * Eg. field 'shipping_first_name' will check for that exact field and will not fallback to any other field eg 'first_name'
 *
 * @author Joe Mottershaw | https://cloudeight.co
 */
add_filter('woocommerce_checkout_get_value', function($input, $key) {
	
	global $current_user;
	
	// Return the user property if it exists, false otherwise
	return ($current_user->$key
		? $current_user->$key
		: false
	      	);
}, 10, 2);