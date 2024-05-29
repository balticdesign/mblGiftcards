<?php
/**
 * Variable product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 *
 * Modified to use radio buttons instead of dropdowns
 * @author 8manos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$attribute_keys = array_keys( $attributes );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
	<?php else : ?>
	<div class="slick">
		<div class="variations tabs slide" cellspacing="0">
			
				<?php $i = 1; foreach ( $attributes as $name => $options ) : ?>
				<div name="tabs" id="tab-<?php echo sanitize_title($name); ?>">
						<label class="label tabsteps si_font" for="tab-<?php echo sanitize_title($name); ?>"><?php echo $i.'. '.wc_attribute_label( $name ); ?></label>
					<div class="panel attribute-<?php echo sanitize_title($name); ?>">
					
						<?php
						$sanitized_name = sanitize_title( $name );
						if ( isset( $_REQUEST[ 'attribute_' . $sanitized_name ] ) ) {
							$checked_value = $_REQUEST[ 'attribute_' . $sanitized_name ];
						} elseif ( isset( $selected_attributes[ $sanitized_name ] ) ) {
							$checked_value = $selected_attributes[ $sanitized_name ];
						} else {
							$checked_value = '';
						}
						?>
						
							<?php
						
							if ( ! empty( $options ) ) {
								if ( taxonomy_exists( $name ) ) {
									// Get terms if this is a taxonomy - ordered. We need the names too.
									$terms = wc_get_product_terms( $product->get_id(), $name, array( 'fields' => 'all' ) );

									if($name == 'pa_design') { ?>
								
								<div class="value design">
									<?php foreach ( $terms as $term ) {
										if ( ! in_array( $term->slug, $options ) ) {
											continue;
										}
										$acftermid = ''.$name.'_'.$term->term_id.'';
										$image = get_field('gift_card_design_image', $acftermid );
									
									print_attribute_radio( $checked_value, $term->slug, $term->name, $sanitized_name, $image  );
									} ?> 
									

								</div>
								
								
								<?php } elseif($name == 'pa_value') { ?>
								<div>
									<div class="value test">
								<?php
								$grp = '';
									foreach ( $terms as $term ) {
										if ( ! in_array( $term->slug, $options ) ) {
											continue;
										}
										$acftermid = ''.$name.'_'.$term->term_id.'';
										$grp = get_field('config_group', $acftermid );
										$image = get_field('config_image', $acftermid );
										$config_array[$grp][] = (object) array(
											'name' => $term->name,
											'slug' => $term->slug,
											'image' => $image,
											'sanitized' => $sanitized_name,
											'checked' => $checked_value,
									);
										
									}
									
									foreach ( $config_array as $grp => $group  ) {
										
										echo '<div class="configuration">';
										foreach ( $group as $config ) {
										
										print_attribute_radio( $config->checked, $config->slug, $config->name, $config->sanitized, $config->image  );
										
									}
									echo '</div></div>';
								}
								echo '</div>';
								 }
								 ?></div><?php
								} else {
									foreach ( $options as $option ) {
										print_attribute_radio( $checked_value, $option, $option, $sanitized_name );
									}
								}
								
							
							}

							echo end( $attribute_keys ) === $name ? apply_filters( 'woocommerce_reset_variations_link', '<a title="Clear" class="reset_variations" href="#">' . __( '', 'woocommerce' ) . '</a>' ) : '';
							?>
						
						</span>
				<?php $i++; endforeach; ?>
						</div>
						<div id="manual_price" class="baltic-gf-amount" style="display:none"><input placeholder="Add a custom amount" name="manual_price"></input></div>
						</div>
						<div class="woocommerce-product-gallery--columns-4 baltic-gf-message">
			<label class="label tabsteps si_font">3. Add Message</label>
            <div><textarea name="baltic_message"></textarea></div>
        </div>
		
						</div>

		<?php // do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap slide">
			<?php
				do_action( 'woocommerce_before_single_variation' );
				do_action( 'woocommerce_single_variation' );
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
<div>
<div>