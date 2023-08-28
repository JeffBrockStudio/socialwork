<?php
/**
 * The template for displaying all pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package uw_wp_theme
 */

get_header();

//$sidebar = get_post_meta( $post->ID, 'sidebar' );
$sidebar_nav_menu = get_field( 'sidebar_nav_menu' );
$sidebar_content = get_field( 'sidebar_content' );

// get the hero header.
get_template_part( 'template-parts/header', 'hero' );

?>
<div class="container-fluid ">
<?php echo uw_breadcrumbs(); ?>
</div>
<div class="container-fluid uw-body">
	<div class="row">

		<?php
		if ( $sidebar_nav_menu OR $sidebar_content ) {
			get_sidebar();
		}
		?>

		<main id="primary" class="site-main uw-body-copy col-md-<?php echo ( ( $sidebar_nav_menu OR $sidebar_content ) ? '9' : '12' ); ?>">
		
		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'page' );

		endwhile; // End of the loop.
		?>

		</main><!-- #primary -->

		

	</div><!-- .row -->
</div><!-- .container -->

<?php
get_footer();
