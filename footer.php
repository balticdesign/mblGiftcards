<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="wrapper foot tertiary_background" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">

			<div class="col-md-12">

				<footer class="site-footer" id="colophon">

					<div class="site-info">
			
			

					<?php wp_nav_menu(
					array(
						'theme_location'  => 'footer_menu',
						'container_class' => '',
						'container_id'    => 'navbarNavDropdown',
						'menu_class'      => 'navbar-nav mr-auto',
						'fallback_cb'     => '',
						'menu_id'         => 'footer_menu',
						'depth'           => 1,
						'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
					)
				); ?>
<p> &copy; <a href="https://mblsolutions.co.uk/">MBL Solutions</a> 2020</p>

 </div><!-- .site-info -->
				</footer><!-- #colophon -->

			</div><!--col end -->

		</div><!-- row end -->

	</div><!-- container end -->

</div><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>
<script type="text/javascript">
function is_page($pageid) {
	if (jQuery('body').hasClass('page-id-'+$pageid)) { return true; } else { return false; }
}
    jQuery(document).ready(function(){
		jQuery('.slick').slick({
		autoplay: false,
		infinite: false,
    	arrows: true,
    	dots: false,
	  });

$val_no = jQuery(".gf_value").length;
$valsize = 100 / $val_no;
jQuery(".gf_value").css("width", $valsize + '%')

	  jQuery("input[name='attribute_pa_value']").change(function() {
	   wwswitch = jQuery("input[name='attribute_pa_value']:checked");
		swatch = wwswitch.val();
		if (swatch == 'other') { jQuery("#manual_price").show(); } else { jQuery("#manual_price").hide(); } 
	});

	  jQuery('.slick').on('afterChange', function (event, slick, currentSlide) {
                if (currentSlide === 0) {
					jQuery('.tertiary_background .one').addClass('select');
					jQuery('.tertiary_background .two').removeClass('select');
                } else if (currentSlide === 1)  {
					jQuery('.tertiary_background .two').addClass('select');
					jQuery('.tertiary_background .one').removeClass('select');

                }
            });

			<?php if ( is_page( 'cart' ) || is_cart() ) { ?>
				jQuery('.tertiary_background .three').addClass('select');
				jQuery('.tertiary_background .one').removeClass('select');
					jQuery('.tertiary_background .two').removeClass('select');
			<?php } ?>

			<?php if ( is_page( 'checkout' ) || is_checkout() ) { ?>
				jQuery('.tertiary_background .four').addClass('select');
				jQuery('.tertiary_background .three').removeClass('select');
				jQuery('.tertiary_background .one').removeClass('select');
					jQuery('.tertiary_background .two').removeClass('select');
			<?php } ?>
    });
  </script>
</body>

</html>

