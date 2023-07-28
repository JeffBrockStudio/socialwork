<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package uw_wp_theme
 */

//if ( ! is_active_sidebar( 'sidebar' ) ) {
	//return;
//}
?>

<?php //wp_print_styles( array( 'uw_wp_theme-sidebar', 'uw_wp_theme-widgets' ) ); ?>
<aside id="secondary" class="primary-sidebar uw-sidebar widget-area col-md-2">
	<?php uw_sidebar_menu(); ?>

  <?php
  global $sidebar_content;
  $items = $sidebar_content;

  if ($items !== ''):
    foreach ($items AS $item): ?>
      <h3 class="sidebar-heading"><?php echo $item['heading']; ?></h3>
      <?php
      if ($item['content']): ?>
        <div class="content">
          <?php
          echo $item['content'];
          ?>
        </div>
      <?php
      endif;
    endforeach;
  endif;
  ?>

	<?php dynamic_sidebar( 'sidebar' ); ?>
</aside><!-- #secondary -->
