<?php
function uw_breadcrumbs() {

if ( get_option( 'breadcrumb-hide' ) ) :
  return;
endif;

global $post;


if ( isset( $post ) && get_post_meta( $post->ID, 'breadcrumbs', true ) ) {
  return;
}

$ancestors = array_reverse( get_post_ancestors( $post ) );
$html      = '<li><a href="' . home_url( '/' ) . '" title="' . get_bloginfo( 'title' ) . '">' . get_bloginfo( 'title' ) . '</a>';

if ( is_404() ) {
  $html .= '<li class="current"><span>Woof!</span>';
} elseif ( is_search() ) {
  $html .= '<li class="current"><span>Search results for ' . get_search_query() . '</span>';
} elseif ( is_author() ) {
  $author = get_queried_object();
  $html  .= '<li class="current"><span> Author: ' . $author->display_name . '</span>';
} elseif ( get_queried_object_id() === (int) get_option( 'page_for_posts' ) ) {
  $html .= '<li class="current"><span> ' . get_the_title( get_queried_object_id() ) . ' </span>';
}

// If the current view is a post type other than page or attachment then the breadcrumbs will be taxonomies.
if ( is_category() || is_single() || is_post_type_archive() || is_tag() ) {

  if ( is_post_type_archive() ) {
    $posttype = get_post_type_object( get_post_type() );
    //$html .=  '<li class="current"><a href="'  . get_post_type_archive_link( $posttype->query_var ) .'" title="'. $posttype->labels->menu_name .'">'. $posttype->labels->menu_name  . '</a>';
    $html .= '<li class="current"><span>' . $posttype->labels->menu_name  . '</span>';
  }

  if ( is_category() ) {
    if ( 'post' === get_post_type() && get_option( 'page_for_posts', true ) ) {
      $html .= '<li><a href="' . esc_url( get_post_type_archive_link( 'post' ) ) . '">' . get_the_title( get_option( 'page_for_posts' ) ) . '</a>';
    }

    $category = get_category( get_query_var( 'cat' ) );
    //$html .=  '<li class="current"><a href="'  . get_category_link( $category->term_id ) .'" title="'. get_cat_name( $category->term_id ).'">'. get_cat_name($category->term_id ) . '</a>';
    $html .= '<li class="current"><span>' . get_cat_name( $category->term_id ) . '</span>';
  }

  if ( is_tag() ) {
    if ( 'post' === get_post_type() && get_option( 'page_for_posts', true ) ) {
      $html .= '<li><a href="' . esc_url( get_post_type_archive_link( 'post' ) ) . '">' . get_the_title( get_option( 'page_for_posts' ) ) . '</a>';
    }

    $tag   = get_tag( get_queried_object_id() );
    $html .= '<li class="current"><span>' . $tag->slug . '</span>';
  }

  if ( is_single() ) {
    if ( 'post' === get_post_type() ) {
      $page_for_posts = 769;
      $html .= '<li><a href="' . esc_url( get_permalink( $page_for_posts ) ) . '">' . get_the_title( $page_for_posts ) . '</a>';
      //if ( 'post' === get_post_type() && get_option( 'page_for_posts', true ) ) {  
      //$html .= '<li><a href="' . esc_url( get_post_type_archive_link( 'post' ) ) . '">' . get_the_title( get_option( 'page_for_posts' ) ) . '</a>';
    } elseif ( has_category() ) {
      $thecat   = get_the_category( $post->ID );
      $category = array_shift( $thecat );
      $html    .= '<li><a href="' . get_category_link( $category->term_id ) . '" title="' . get_cat_name( $category->term_id ) . ' ">' . get_cat_name( $category->term_id ) . '</a>';
    }
    // check if is Custom Post Type.
    if ( ! is_singular( array( 'page', 'attachment', 'post' ) ) ) {
      $posttype = get_post_type_object( get_post_type() );
      $html    .= '<li><a href="' . home_url( '/' ) . '" title="' . get_bloginfo( 'title' ) . '">' . get_bloginfo( 'title' ) . '</a>';
    }

    $html .= '<li class="current"><span>' . get_the_title( $post->ID ) . '</span>';
  }
} elseif ( is_page() ) {
  // If the current view is a page then the breadcrumbs will be parent pages.

  if ( ! is_home() || ! is_front_page() ) {
    $ancestors[] = $post->ID;
  }

  if ( ! is_front_page() ) {
    foreach ( array_filter( $ancestors ) as $index => $ancestor ) {

      $class      = $index + 1 === count( $ancestors ) ? ' class="current" ' : '';
      $page       = get_post( $ancestor );
      $url        = get_permalink( $page->ID );
      $title_attr = esc_attr( $page->post_title );

      if ( ! empty( $class ) ) {
        $html .= "<li $class><span>{$page->post_title}</span></li>";
      } else {
        $html .= "<li><a href=\"$url\" title=\"{$title_attr}\">{$page->post_title}</a></li>";
      }
    }
  }
}

return "<nav class='uw-breadcrumbs' aria-label='breadcrumbs'><ul>$html</ul></nav>";
}