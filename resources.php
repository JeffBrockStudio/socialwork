<?php

// Get shortcode attributes.
$resource_atts = shortcode_atts(
	array(
		'pagination'      => 'links',
		'posts_per_page'  => '10',
		'post_type'       => 'resource',
		'show_search'     => 'true',
		'show_filters'    => 'true',
		'show_thumbnails' => 'true',
	),
	$atts
);

/**
 * Content settings
 */	

// Post type 
$post_type = $resource_atts['post_type'];  

// Taxonomies for this post type
$taxonomies = get_object_taxonomies( $post_type );		

// Custom post type variables
switch( $post_type ):

	// Project
	case 'project':
		$preselected_filter_name = '';
		$search_engine = 'project';
		break;
	
	// Publication
	case 'resource':
		$preselected_filter_name = 'publication_types';
		$search_engine = 'resource';
		break;		
		
	// Team
	case 'team':
		$preselected_filter_name = 'team_roles';
		$search_engine = 'team';
		
		$terms = get_sub_field( 'team_roles' );
		if ( $terms ):
			
			foreach( $terms AS $term ):	
				$first_role = get_term( $term['role'] )->slug;
				break;
			endforeach;
			
			if ( array_key_exists( 'team_roles', $_GET ) && $_GET['team_roles'] ) {
				$first_visit = FALSE;
				$team_roles = $_GET['team_roles'];
			} else {
				$first_visit = TRUE; 
				$team_roles = $first_role; 
				if ( count($terms) > 1 ): ?>
					<script>
						jQuery(function($) {		
							var queryParams = new URLSearchParams(window.location.search);    
							queryParams.set('team_roles', '<?php echo $team_roles;?>');
							history.pushState(null, null, '?'+queryParams.toString());
						});
					</script>
					<?php
				endif;
			}
			
		endif; ?>
		
		<?php		
		break;		
		
endswitch;
$preselected_filter = get_sub_field( $preselected_filter_name );

// Number of posts per page
$posts_per_page = $resource_atts['posts_per_page'];
if ( !$posts_per_page ):
	// If none is set manually, get WordPress default
	$posts_per_page = get_option( 'posts_per_page' );
endif;

// Pagination style
$pagination = $resource_atts['pagination'];

// Infinite Load button text
$load_more_text = 'Load More';

// Layout
$layout = 'list';


/**
 * Display settings
 */

// Show/hide choices
$show = array();
$show['author'] = 'false';
$show['button'] = 'false';
$show['date'] = 'false';
$show['excerpt'] = 'false';
$show['filters'] = $resource_atts['show_filters'];
$show['search'] = $resource_atts['show_search'];
$show['sticky'] = 'false';
$show['taxonomies'] = 'true';
$show['thumbnails'] = $resource_atts['show_thumbnails'];
$show['title'] = 'true';  


// Hide individual elements in meta data ?>	
<style>
	<?php if ( !$show['date'] ): ?>
		#<?php echo $block_id; ?>.block.filters article .posted-on {
			display: none !important;
		}
	<?php endif; ?>
	<?php if ( !$show['author'] ): ?>
		#<?php echo $block_id; ?>.block.filters article .byline {
			display: none !important;
		}
	<?php endif; ?>
</style>

<?php if ( $post_type == 'team' ):?>
	<?php if ( $terms AND count($terms) > 1 ): ?>
	
		<div id="team-type-wrapper" style="background-color: <?php echo $layout_settings['background_color'];?>">
			<div class="container">
				
				<div class="row">
					<div class="col-12">	
						<div class="buttons">
							<?php foreach( $terms AS $term ):
									$term_data = get_term( $term['role'] ); ?>								
									<a 
										data-team-role = "<?php echo $term_data->slug; ?>" 
										data-accent-color = "<?php echo $accent_color; ?>"
										data-svg-bg-color = "<?php echo $svg_bg_color; ?>"
										class="team-role btn 
										<?php if ( $team_roles == $term_data->slug ) {
											echo '"; ';?>
											style="background-color: <?php echo $accent_color; ?>; border-color: <?php echo $accent_color; ?>; color: <?php echo $svg_bg_color ?>"
											<?php
										} else { 
											echo 'btn-outline';};?>"
											style="background-color: #ffffff; border-color: <?php echo $accent_color; ?>; color: <?php echo $accent_color ?>"
										href="<?php global $wp; echo home_url( $wp->request ) ?>/?team_roles=<?php echo $term_data->slug; ?>">
										<?php echo $term_data->name; ?>
									</a>				 
							 <?php endforeach; ?>			
						</div>
					</div>
				</div>
			</div>
		</div>
		
	<?php endif; ?>
<?php endif; ?>
	

	<?php
	global $post;
	$post_id = $post->ID;
	
	// Get labels for post type
	$post_type_object = get_post_type_object( $post_type ); 
	$post_type_labels = $post_type_object->labels;
	
	// Sticky / featured item
	if ( (array_key_exists('sticky', $show)) AND $show['sticky'] ):
		
		$sticky_found = TRUE;
		$args = array( 
			'post_type' => $post_type,
			'posts_per_page' => '1',
			'post_status' => 'publish'
		);
		
		if ( $post_type == 'post' ):
			// Post uses WordPress default stickiness
			$sticky = get_option( 'sticky_posts' );
			
			if ( empty( $sticky ) ):			
				$sticky_found = FALSE;
			else:
				$args['post__in'] = get_option( 'sticky_posts' );
				$args['ignore_sticky_posts'] = 1;
			endif;

		else:		
			// Other post types don't offer stickiness by default
			$args['meta_key'] = $post_type . '_sticky';
			$args['meta_value'] = '1';
			
		endif;
		
		// Run query
		if ( $sticky_found ):
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ):
				while ( $the_query->have_posts() ):
					$the_query->the_post();
					
					// Include sticky template based on post type
					include( 'filters/sticky-' .$post_type. '.php' );	
					
				endwhile;
			endif;
			wp_reset_postdata();
		endif;

	endif;
	?>
		
	<?php if ( get_sub_field( 'heading' )):?>
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="row">
			
				<div class="col-12 col-heading">
					<div class="inner">				
						<<?php the_sub_field( 'heading_level' );?> style="color: <?php echo $accent_color; ?>"><?php the_sub_field( 'heading' );?></<?php the_sub_field( 'heading_level' );?>>
					</div>
				</div>
				
			</div>
		</div>
	<?php endif; ?>
		
	<?php
	if ( 	((array_key_exists('filters', $show)) AND $show['filters'] == 'true' ) 
		OR 	((array_key_exists('search', $show)) AND $show['search'] == 'true' ) ): ?>				
		<div id="<?php echo $post_type; ?>-filter-wrapper" class="filter-wrapper">
				<div class="row">
					
					<div class="col-12">	
						<div class="filters-search">
							<div class="filters"> 	
								
								<div class="row">

									<?php 
									if ( $show['filters'] == 'true' ): 
										if ( $show['search'] == 'false'):
											$col_styles = 'col-12 col-filters';
										else:
											$col_styles = 'col-12 col-md-5 offset-md-1 col-filters';
										endif; ?>
											<div class="<?php echo $col_styles;?>">
											
												<div class="label"><?php _e( 'Filter by', 'socialwork' ) ?>:</div>
												
												<div class="row">
													
													<?php								
													foreach ( $taxonomies AS $taxonomy ): 
														$taxonomy_details = get_taxonomy( $taxonomy );
														$taxonomy_labels = $taxonomy_details->labels;
														?>
														<?php if ( $taxonomy_details->publicly_queryable ): ?>
															<div class="col-12">		
																<div class="filter <?php echo $taxonomy; ?>">
																	<label for="select-<?php echo $taxonomy; ?>" class="sr-only"><?php echo $taxonomy_labels->menu_name; ?></label>
																	<select id="select-<?php echo $taxonomy; ?>" data-taxonomies='<?php echo json_encode( $taxonomies ) ?>' data-post_type="<?php echo $post_type; ?>">
																		<option value="" selected><?php echo $taxonomy_labels->menu_name; ?></option>
																		<?php
																		if ( isset( $_GET[$taxonomy] )):
																			$current = $_GET[$taxonomy];
																		elseif ( get_sub_field( $preselected_filter_name ) AND !(isset( $_GET['override'] ) )):
																			$catinfo = get_term( get_sub_field( $preselected_filter_name ) );    			 
																			$current = $catinfo->slug;
																		else:
																			$current = '';
																		endif; 		 
																		$terms = get_terms( array(
																			'taxonomy' => $taxonomy,
																			'hide_empty' => true
																		) );   
																		foreach ( $terms AS $term ) {
																			if ( $term->slug != 'members' ):?>
																				<option value="<?php echo $term->slug; ?>"<?php if ( $term->slug == $current) { echo ' selected'; };  ?>><?php echo $term->name; ?></option>
																				<?php 
																			endif;
																		};
																		wp_reset_postdata(); ?> 		                        
																	</select>
																</div>
															</div>
														<?php			
														endif;								
													endforeach;										
													?>
													
												</div>
																															
											</div>
										<?php 
									endif; ?>

									<?php 
									if ( $show['search'] == 'true' ): 
										if ( $show['filters'] == 'false'):
											$col_styles = 'col-12 col-md-8 offset-md-2';
										else:
											$col_styles = 'col-12 col-md-5';
										endif; ?>
										
									<div class="<?php echo $col_styles;?> col-search">		
									
											<div class="label"><?php echo $post_type_labels->search_items; ?></div>							
											
											<div class="search">
												<form id="<?php echo $post_type; ?>-search" class="filters-search-form" data-post_type="<?php echo $post_type; ?>" data-taxonomies='<?php echo json_encode( $taxonomies ) ?>'>
													<label class="sr-only" for="s"><?php _e( 'Search', 'socialwork' ); ?></label>
													<div class="input-group">														
														<input 
															id="<?php echo $post_type; ?>-search-query" 
															class="field form-control search-query" 
															type="text"
															placeholder="<?php if ( isset($_GET['search']) ) { esc_attr_e( $_GET['search'], 'socialwork' ); } else { esc_attr_e( $post_type_labels->search_items, 'socialwork' ); }; ?>" 
															value="">						
															<span class="input-group-append">
															<input 
																class="submit" 
																name="submit" 
																type="submit" 
																value="">
														</span>																				
													</div>
												</form>									
											</div>
										</div>
										
									<?php endif;?>
								</div>	
								
							</div>
							
						</div>
					</div>
					
			</div>
		</div>
				
	<?php endif; ?>
			
	<?php
	$querystring = '?';
	$sorting_array = array();								
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;					
		
	// Basic arguments
	$args = array( 
		'post_type' => $post_type,
		'posts_per_page' => $posts_per_page,
		'post_status' => 'publish',
		'paged' => $paged
	);
	
	// Don't move sticky items out of their original order
	$args['ignore_sticky_posts'] = 1;
	
	// For chronological items, don't include past items
	if ( $post_type == 'event') {
		$currentdate = date( "Ymd", mktime( 0,0,0, date("m"), date("d"), date("Y") ) );	
		$args['meta_query'] = array(
			array(
				'key' => 'event_start_date',
				'compare' => '>=',
				'value' => $currentdate,
				'type' => 'DATE',
			),
		);
	}
	
	// Order by
	if ( $post_type == 'team') {
		$args['orderby'] = 'meta_value';	
		$args['meta_key'] = 'team_last_name';	
	} elseif ( $post_type == 'event') {	
		$args['orderby'] = 'meta_value';	
		$args['meta_key'] = 'event_start_date';	
	} elseif ( array_key_exists( 'orderby', $_GET ) && $_GET['orderby'] ) {								
		$args['meta_key'] = $_GET['meta_key'];
		
		if ( $_GET['orderby'] == 'title' ) {
			$args['orderby'] = 'title';	
		} else if ( $_GET['orderby'] == 'taxonomy' ) {
			$args['orderby'] = 'title';	
			$orderby_taxonomy = $_GET['taxonomy'];
		} else {
			$args['orderby'] = 'meta_value';									
		}
		
	} else {
		$args['orderby'] = 'date';								
		$querystring .= 'orderby=title&';
	}	  
	
	// Order
	if ( $post_type == 'team') {
		$args['order'] = 'ASC';
	} elseif ( $post_type == 'event') {	
		$args['order'] = 'ASC';	
	} elseif ( array_key_exists( 'order', $_GET ) && $_GET['order'] ) {								
		$args['order'] = $_GET['order'];
		$querystring .= 'order=' . $_GET['order'] . '&';
		$order = $_GET['order'];
	} else {
		$args['order'] = 'DESC';								
		$querystring .= 'order=ASC&';
	}		
		
	// Get filters from URL
	$filters = array();
	
	if ( $post_type == 'team'):
		if ( $first_visit == TRUE ):
		 	$filter_roles = $first_role;
		 	$querystring .= 'team_roles=' . $filter_roles . '&';		    
		 	$filters[] = 'team_roles';   
		 	$_GET['team_roles'] = $first_role;
		endif;	
	endif;
	
	foreach ( $taxonomies AS $taxonomy ):
		if ( array_key_exists( $taxonomy, $_GET ) && $_GET[$taxonomy] ) {
			$filter_resource_topics = $_GET[$taxonomy];
			$querystring .= $taxonomy . '=' . $filter_resource_topics . '&';		    
			$filters[] = $taxonomy;          
		};
	endforeach;
	
	// Pre-selected filter
	if ( get_sub_field( $preselected_filter_name ) AND !isset( $_GET[$preselected_filter_name] ) AND !(isset( $_GET['override'] ) )):
		$catinfo = get_term( get_sub_field( $preselected_filter_name ) );    			 
		$querystring .= $preselected_filter_name . '=' . $catinfo->slug . '&';		
		$_GET[$preselected_filter_name] = $catinfo->slug;
		$filters[] = $preselected_filter_name;     
	endif;
		
	// Add filters, if any, to query
	if ( count( $filters )):
		if ( count( $filters ) == 1 ):
			$filter_name = $filters[0];
			$args['tax_query'] = array(	       
				array(
					'taxonomy' => $filter_name,      
					'field'    => 'slug',
					'terms'    => array( $_GET[$filter_name] )
				),
			);	          
		else:
		
			$tax_query = array();
			$tax_query['relation'] = 'OR';
			
			foreach ( $filters AS $filter ):
				array_push( $tax_query,
					array(
						'taxonomy' => $filter,
						'field'    => 'slug',
						'terms'    => array( $_GET[$filter] ),
					)
				);	    
			endforeach; 
			$args['tax_query'] = $tax_query;     
	
		endif;
		
	endif;
	
	
	// Search	
	if ( array_key_exists( 'search', $_GET ) && $_GET['search'] ) {
		$search_query = $_GET['search'];
		
		$args['fields'] = 'ids';
		$args['posts_per_page'] = '-1';
		$args['orderby'] = 'title';
	//	$args['order'] = $sort;
		$args['s'] = $_GET['search'];	    
		
		$args['engine'] = $search_engine;              					                          
					
		$search_results_query = new SWP_Query( $args );	
		
		$search_results_array = $search_results_query->posts;

		wp_reset_postdata();
		
		if ( count( $search_results_array ) ) {
		
			$args = array(
					'post_type' => $post_type,
					'post__in' => $search_results_array,
					'post_status' => 'publish',
					'posts_per_page' => $posts_per_page,
					'orderby' => 'date',
					//'order' => $sort,
					'paged' => $paged         	          									    
			);				
			$the_query = new WP_Query( $args );
		
		}
		
		$querystring .= '&search=' . $search_query;
		//$querystring .= '&search=' . $search_query . '&order=' . $sort;
		wp_reset_postdata();
	
	}	
	?>
	
	<div id="<?php echo $post_type; ?>-list-wrapper" class="list-wrapper layout-<?php echo $layout; ?>">
		<div id="posts-ajax" class="row <?php echo $post_type; ?>">
			<?php
			$args_count_only = $args;
			$args_count_only['posts_per_page'] = -1;
			$number_of_results = count(get_posts($args_count_only));			

			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ):
				
				$permalink_parent = get_permalink( $post->ID );									
				$resources_list = array();	

			
				while ( $the_query->have_posts() ):
					$the_query->the_post();										
					$resource_id = $post->ID;						
					$resources_list[$resource_id]['id'] = $post->ID;		
				endwhile;
				
				if (( array_key_exists( 'search', $_GET ) && $_GET['search'] ) OR
					(array_key_exists( 'team_roles', $_GET ) && $_GET['team_roles'] )) { ?>
					<div class="col-12 results-found">
						<div class="inner">
							<p><?php //echo $the_query->post_count; 
							echo $number_of_results;
							if ($the_query->post_count == 1):
								_e( ' result for', 'socialwork');
							else:
								_e( ' results for', 'socialwork');
							endif; ?>: 
							<?php if (array_key_exists( 'search', $_GET ) ): ?>
								"<?php esc_attr_e( $_GET['search'], 'socialwork' ); ?>"
							<?php elseif ( array_key_exists( 'team_roles', $_GET ) ): ?>"<?php
									// Get term name by slug
									$term = get_term_by( 'slug', $_GET['team_roles'], 'team_roles' );
									echo $term->name; ?>"<?php endif; ?>						
							</p>

							<div class="clear-filters" data-post_type="<?php echo $post_type; ?>" data-taxonomies='<?php echo json_encode( $taxonomies ) ?>' data-search_placeholder="<?php echo $post_type_labels->search_items; ?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
									<path id="clear-filters-button-background" d="M12.8286 25.6383C19.6904 25.6383 25.253 20.0756 25.253 13.2137C25.253 6.35175 19.6904 0.789062 12.8286 0.789062C5.96687 0.789062 0.404297 6.35175 0.404297 13.2137C0.404297 20.0756 5.96687 25.6383 12.8286 25.6383Z" fill="#85754D"/>
									<path d="M17.7679 8.15479L7.77051 18.1524" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M7.77051 8.15479L17.7679 18.1524" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
								<p><?php _e( 'Clear filters', 'socialwork' ); ?></p>
							</div>		
						</div>
					</div>
				<?php } ?>

				<?php
				if ( count($resources_list) > 0 ):
					$i = 1;
					
					if ( $post_type == 'team' ):?>							
						
							<?php
							$i = 1;
							foreach ( $resources_list AS $resource_item):			
								$resource_id = $resource_item['id'];
								include( 'inc/filters/article-' .$post_type. '-full.php' );	?>
								<?php
							$i++;
							endforeach;
							wp_reset_postdata();?>
						
						<?php
					else:						
						foreach ( $resources_list AS $resource_item):			
							$resource_id = $resource_item['id'];		
							
							$post = get_post( $resource_id ); 							
							if ( has_category( 'in-the-news' )): 
								$permalink = esc_url( get_field( 'news-external-url' ));
								$target = '_blank';
							else:
								$permalink = esc_url( get_permalink( $resource_id ));
								$target = '';
							endif;
							
							// Item: Event, Post, Resource, Team													
							include( 'inc/filters/article-' .$post_type. '.php' );	
							
							$i++; 
						endforeach;
						
					endif;												
						
				endif;
				
			else: ?>

				<div class="col-12 not-found">
					<div class="inner">
						<p><?php _e( 'No results for', 'socialwork');?>: "<?php esc_attr_e( $_GET['search'], 'socialwork' ); ?>"</p>

						<div class="clear-filters" data-post_type="<?php echo $post_type; ?>" data-taxonomies='<?php echo json_encode( $taxonomies ) ?>' data-search_placeholder="<?php echo $post_type_labels->search_items; ?>">
							<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
								<path id="clear-filters-button-background" d="M12.8286 25.6383C19.6904 25.6383 25.253 20.0756 25.253 13.2137C25.253 6.35175 19.6904 0.789062 12.8286 0.789062C5.96687 0.789062 0.404297 6.35175 0.404297 13.2137C0.404297 20.0756 5.96687 25.6383 12.8286 25.6383Z" fill="#85754D"/>
								<path d="M17.7679 8.15479L7.77051 18.1524" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M7.77051 8.15479L17.7679 18.1524" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<p><?php _e( 'Clear search', 'socialwork' ); ?></p>
						</div>		
					</div>
				</div>
				<?php
				
			endif; 									
			?>

			<div class="col-12 spinner-row">
				<div class="icon-spinner-circle"></div>
			</div>
				
				<?php 						
				if ( $pagination == 'ajax' ):
					$next_posts_link = get_next_posts_link($load_more_text . ' <i class="fa fas fa-arrow-down"></i>', $the_query->max_num_pages);
				
					if( $next_posts_link ): ?>
						<div class="row pagination-row">
							<div class="col-12">
								<?php 
								echo $next_posts_link; ?>
							</div>
						</div>
						<?php
					endif;
					wp_reset_postdata();				
					
				elseif ( $pagination == 'links' ): ?>
										
						<div class="col-12 pagination-row">
							<div class="pagination">
								<?php 
								$total_pages = $the_query->max_num_pages;
						
								if ($total_pages > 1){
						
										$current_page = max(1, get_query_var('paged'));
										
										$querystring_array = array();											
										if ( get_query_var('search') ):
											$querystring_array['search'] = get_query_var('search');
										endif;
										
										if ( get_query_var('news_topics') ):											
											$querystring_array['news_topics'] = get_query_var('news_topics');
										endif;
										
										if ( get_query_var('news_types') ):											
											$querystring_array['news_types'] = get_query_var('resource_topics');
										endif;
										
										// print ( '<pre>' );
										// print_r( $querystring_array );
										// print ( '</pre> ');
						
										echo paginate_links(array(
												'base' => preg_replace('/\?.*/', '/', get_pagenum_link(1)) . '%_%',
												'format' => 'page/%#%/',
												'current' => $current_page,
												'total' => $total_pages,
												'prev_text' => __('«'),
												'next_text' => __('»'),
												'add_args' => $querystring_array
										));
								}								
						
								wp_reset_postdata();	
								?>
							</div>
						</div>
					<?php
				endif;	
				wp_reset_postdata();	
				?>
			</div>
		</div>
			
</div>

<?php if ( get_sub_field( 'sticky_subnav' )): ?>
	<script>
	jQuery(document).ready(function($) {
		
		var $inView = $('#team-list-wrapper');
		var $sticky = $('#team-type-wrapper');
			
		var inview = new Waypoint.Inview({
			element: $inView[0],
			enter: function(direction) {
				// Add stickiness when parent container comes onscreen from scrolling up
				if (direction === 'up' && !$sticky.hasClass('stuck')) {
					$sticky.addClass('stuck');
				}				
			},
			exited: function(direction) {
				// Remove element's stickiness when it moves offscreen
				
				$sticky.removeClass('stuck');				
			},
			offset: {
				top: 300, // 300px
				bottom: 200 // 200px
			}
		});
		
		var sticky = new Waypoint.Sticky({
			element: $sticky[0],
			offset: 0,
		});
			
	});
	</script>
<?php endif; ?>