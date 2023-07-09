<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package uw_wp_theme
 */

?>

		<footer id="colophon" class="site-footer">
      <a href="<?php echo get_bloginfo('url');?>" title="<?php echo get_bloginfo('name');?> Home" class="footer-wordmark" tabindex="-1" aria-hidden="true"><?php echo get_bloginfo('name');?></a>

			<div class="h4" id="social_preface">Connect with us:</div>
			<nav aria-labelledby="social_preface">
				<ul class="footer-social">
					<li><a class="facebook" href="http://www.facebook.com/UWSSW">Facebook</a></li>
					<li><a class="twitter" href="http://twitter.com/uwsocialwork">Twitter</a></li>
					<li><a class="instagram" href="http://instagram.com/uwsocialwork">Instagram</a></li>
					<li><a class="youtube" href="http://www.youtube.com/user/uwsswmedia/videos">YouTube</a></li>
					<li><a class="linkedin" href="https://www.linkedin.com/school/university-of-washington-school-of-social-work/">LinkedIn</a></li>
				</ul>
			</nav>

			<nav aria-label="footer navigation">
				<!--<ul class="footer-links"> -->
				<?php uw_wp_theme_footer_menu(); ?>

				<!-- </ul> -->
			</nav>

			<div class="site-info">
				<p>&copy; 2015-<?php echo date( 'Y' ); ?> School of Social Work  |  University of Washington  |  Seattle, WA</p>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page-inner -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
