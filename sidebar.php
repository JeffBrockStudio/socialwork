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

  <?php global $sidebar_nav_menu; 
  if ( $sidebar_nav_menu ):
    wp_nav_menu(
      array(
        'fallback_cb'     => '',
        'menu'             => $sidebar_nav_menu->term_id,
        'depth'           => 3,
        'container_class'      => 'sidebar-menu',
      )
    );
  endif;
  ?>

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
	
</aside><!-- #secondary -->
