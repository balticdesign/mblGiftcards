<?php
/**
* Template Name: Homepage Email/Post Choice
*
* @package understrap
* 
*
*/

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' ); $cta_text_color = get_theme_mod( 'cta_text_color'); $home_bkg = get_theme_mod( 'home_bkg'); $home_bkg_size = get_theme_mod( 'home_bkg_size'); $home_bkg_pos = get_theme_mod( 'home_bkg_pos');
if ( $cta_text_color == 'text-light') { $bttn_col = '-light'; } else { $bttn_col = '-dark'; }

?>
<div class="wrapper" style="min-height:<?php the_field('set_minimum_page_height'); ?>px; background-repeat: no-repeat; background-position:<?php echo $home_bkg_pos; ?>; background-size:<?php echo $home_bkg_size; ?>; background-image:url('<?php echo $home_bkg; ?>');" id="top-page-wrapper">
<div class="container choice_ctas">
<div class="row">
<?php $ctaselect = get_field('select_calls_to_action'); if (( $ctaselect == 'email' ) || ( $ctaselect == 'both'))  { ?>
<div class="col-sm dark_transp radius m-4 p-4 text-center">
<h3 class="cta <?php echo $cta_text_color; ?>"><?php the_field('email_option_title'); ?></h3>
<p class="p-5 cta <?php echo $cta_text_color; ?>"><?php the_field('email_option_text'); ?></p>
<a href="<?php the_field('email_button_link'); ?>" class="btn cta btn-outline<?php echo $bttn_col; ?> btn-lg btn-block"><?php the_field('email_option_button_text'); ?></a>
 </div>
<?php } if (( $ctaselect == 'post' ) || ( $ctaselect == 'both')) { ?>

 <div class="col-sm dark_transp radius m-4 p-4 text-center">
 <h3 class="cta <?php echo $cta_text_color; ?>"><?php the_field('post_option_title'); ?></h3>
<p class="p-5 cta <?php echo $cta_text_color; ?>"><?php the_field('post_option_text'); ?></p>
<a href="<?php the_field('post_button_link'); ?>" class="btn cta btn-outline<?php echo $bttn_col; ?> btn-lg btn-block"><?php the_field('post_option_button_text'); ?></a>
 </div>
 <?php } ?>
 </div>
 </div>
 </div>
 <?php if( get_field('add_body_text') == '1' ) { ?>
<div class="wrapper bg-white" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main text-center" id="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'loop-templates/content', 'page' ); ?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->
 <?php } ?>
<?php get_footer();
