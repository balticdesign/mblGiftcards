<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<?php

$primary =  get_theme_mod( 'primary_color');        // <--- define the variable 
$secondary =   get_theme_mod( 'accent_color1');
$tertiary =   get_theme_mod( 'accent_color2');
$overlay =   get_theme_mod( 'page_overlay_color');
$contentbkg =   get_theme_mod( 'content_overlay_color');
if($contentbkg) { $padding = 'padding: 20px'; }
$radius =   get_theme_mod( 'form_border_radius').'px';
$header_margins =  get_theme_mod( 'logo_vertical_padding').'px';
$header_overlay_color = get_theme_mod( 'header_overlay_color');
$form_borders =  get_theme_mod( 'form_borders');
$border_color =  get_theme_mod( 'border_color');
$home_cta_color =  get_theme_mod( 'home_cta_color');
$input_color = get_theme_mod( 'input_color');
$cta_color =  get_theme_mod( 'cta_color');
$cta_color_hover = get_theme_mod( 'cta_color_hover');
$background_top_margin = get_theme_mod( 'background_top_margin' ).'px';
$cta_vertical_top_margin = get_theme_mod( 'cta_vertical_top_margin' ).'px';
$mobile_vertical_top_margin = get_theme_mod( 'mobile_vertical_top_margin' ).'px';
$hide_product_title_price = get_theme_mod( 'hide_product_title_price' );
if ( $hide_product_title_price == 1 ) { $archivetitle = 'none'; $pricing = 'none'; } else { $archivetitle = 'block'; $pricing = 'block'; }

echo <<<CSS
<STYLE type="text/css">
.primary_background { background-color: $primary; }
.woocommerce-message, .woocommerce-message::before, .baltic-gf-amount input, .baltic-gf-delivery input[type=date], input[type=number], .orientation .step, .site-footer a  { border-color: $border_color; color:$input_color;  }
.woocommerce-error, .woocommerce-info, .woocommerce-message, figure.woocommerce-product-gallery__wrapper, .gf_value label, .baltic-gf-delivery input[type=date], input[type=number], .baltic-gf-message textarea, .baltic-gf-shipping input, .baltic-gf-shipping select, .baltic-gf-amount input, .tertiary_background {  background-color: $tertiary;  }
.secondary_background, .gf_value input[type="radio"]:checked + label, a.button.wc-forward, .navbar-nav .current-menu-item a.nav-link, .select { background-color: $secondary;  }
h2.woocommerce-loop-product__title{
display:$archivetitle;
}
.woocommerce ul.products li.product .price { 
display:$pricing; 
}
.custom-background div#content {
	background-color: $contentbkg; border-radius:$radius;  $padding;
}
.dark_transp { background-color:$home_cta_color; }
.orientation, .gf_value label, .baltic-gf-delivery input[type=date], input[type=number], .baltic-gf-message textarea, .baltic-gf-shipping input, .baltic-gf-shipping select { border:$form_borders $border_color; color:$input_color; }
.slick-next:before, button.single_add_to_cart_button.btn.btn-primary { background-color: $cta_color; border-color:transparent; } 
a, .slick-prev:before, .text-cta, .btn-outline-primary, h3.cta.text-dark, .cta.btn-outline-dark, .cta.btn-outline-light:hover  { color: $cta_color !important; border-color: $cta_color; } 
a:hover { color: $cta_color_hover; }
.slick-prev:hover::before, button.single_add_to_cart_button.btn.btn-primary:hover, .slick-next:hover::before, .btn-outline-primary:hover, .cta.btn-outline-dark:hover, .cta.btn-outline-light { background-color: $cta_color_hover; color:#fff !important; } 
.choice_ctas {margin-top:$cta_vertical_top_margin;}
@media only screen and (max-width: 600px) {
.choice_ctas {margin-top:$mobile_vertical_top_margin;}
}
header#wrapper-navbar { background-color:$header_overlay_color; }
body.custom-background { background-position: 0 $background_top_margin; }
.select span {color:#fff;}
#overlay { background-color: $overlay; }
.design_thumb input[type="radio"]:checked + label, .site-footer { border-color: $secondary; color:$secondary;  }
.navbar-expand-md { padding: $header_margins 0px; }
@media only screen and (max-width: 600px) {
	.navbar-expand-md { padding: $header_margins 20px; }
}
.mbl_radius, .slick-next:before, .navbar-nav .current-menu-item a.nav-link, figure.woocommerce-product-gallery__wrapper, .design_thumb label, .gf_value label, .baltic-gf-delivery input[type=date], input[type=number], .baltic-gf-message textarea, .baltic-gf-shipping input, .baltic-gf-shipping select, button.single_add_to_cart_button.btn.btn-primary, .radius { border-radius:$radius; }
</STYLE>
CSS;
?>
</head>
<body <?php body_class(); ?> <?php understrap_body_attributes(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">
<div id="overlay"></div>
	<!-- ******************* The Navbar Area ******************* -->
	<header id="wrapper-navbar">

		<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'understrap' ); ?></a>

		<nav id="main-nav" class="navbar navbar-expand-md navbar-light" aria-labelledby="main-nav-label">

			<h2 id="main-nav-label" class="sr-only">
				<?php esc_html_e( 'Main Navigation', 'understrap' ); $logo_align =  get_theme_mod( 'header_configuration');  ?>
			</h2>

		<?php if ( 'container' === $container ) : ?>
			<div class="container"<?php if($logo_align =='center_logo') { ?>style="justify-content: center;"<?php } ?>>
		<?php endif; 
		
		?>

					<!-- Your site title as branding in the menu -->
					<?php if ( ! has_custom_logo() ) { ?>

						<?php if ( is_front_page() && is_home() ) : ?>

							<h1 class="navbar-brand mb-0<?php echo 'logo_'.$logo_align; ?>"><a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>

						<?php else : ?>

							<a class="navbar-brand <?php echo 'logo_'.$logo_align; ?>" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a>

						<?php endif; ?>

					<?php } else {
						 if (($logo_align =='left_logo') || ($logo_align =='center_logo'))  {
						the_custom_logo(); 
					} else { wp_nav_menu(
						array(
							'theme_location'  => 'primary',
							'container_class' => 'collapse navbar-collapse',
							'container_id'    => 'navbarNavDropdown',
							'menu_class'      => 'navbar-nav mr-auto',
							'fallback_cb'     => '',
							'menu_id'         => 'main-menu',
							'depth'           => 2,
							'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
						)
					);  }
					} ?><!-- end custom logo -->

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
					<span class="navbar-toggler-icon"></span>
				</button>

				<!-- The WordPress Menu goes here -->
				<?php  if (($logo_align =='left_logo') || ($logo_align =='center_logo')) { 
					if($logo_align =='center_logo') { $container = ''; $mauto = ''; } else { $container = 'collapse navbar-collapse';  $mauto = 'ml-auto'; } 
					
					wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'container_class' => $container,
						'container_id'    => 'navbarNavDropdown',
						'menu_class'      => 'navbar-nav '.$mauto,
						'fallback_cb'     => '',
						'menu_id'         => 'main-menu',
						'depth'           => 2,
						'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
					)
				); } else { the_custom_logo(); }  ?>
			<?php if ( 'container' === $container ) : ?>
			</div><!-- .container -->
			<?php endif; ?>

		</nav><!-- .site-navigation -->
		<?php if ((is_product()) || ( is_page( 'cart' ) || is_cart() ) || ( is_page( 'checkout' ) || is_checkout() )) { ?>
			<div class="container_mod">
		<div class="orientation row primary_background"> <!-- .orientation -->
                <div class="container tertiary_background d-flex">
					<div class="step one col-md-3 d-inline-flex text-center mx-auto select">
						<span>1. Personalise</span>
					</div>
					<div class="step two col-md-3 d-inline-flex text-center mx-auto">
						<span>2. Delivery</span>
					</div>
					<div class="step three col-md-3 d-inline-flex text-center mx-auto">
						<span>3. Summary</span>
					</div>
					<div class="step four col-md-3 d-inline-flex text-center mx-auto">
						<span>4. Payment</span>
					</div>
				</div>
			</div> <!-- .orientation END -->
			</div>
		<?php } else { ?> 
			<div class="container_mod"><div class="orientation row primary_background"> &nbsp; </div></div>
		<?php } ?>
			</header><!-- #wrapper-navbar end -->
