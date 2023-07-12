<?php 
$taxonomy = 'team_roles';

if ( array_key_exists( 'team_roles', $_GET ) && $_GET['team_roles'] ) {
	$first_visit = FALSE;
	$team_roles = $_GET['team_roles'];
} else {
	$first_visit = TRUE; 
	$first_role = $atts['team_roles'];
	$team_roles =  $atts['team_roles']; ?>
	<?php	
} 
?>

<?php 
$querystring = '?';
$sorting_array = array();								
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;					
$post_type = 'team';
	
// Basic arguments
$args = array( 
	'post_type' => $post_type,
	'posts_per_page' => -1,
	'post_status' => 'publish',
	'paged' => $paged,
	'orderby' => 'menu_order',
	'order' => 'ASC'
);

	
// Get filters from URL
$filters = array();

if ( $first_visit == TRUE ):
	 $filter_roles = $first_role;
	 $querystring .= 'team_roles=' . $filter_roles . '&';		    
	 $filters[] = 'team_roles';   
	 $_GET['team_roles'] = $first_role;
endif;	

if ( array_key_exists( 'team_roles', $_GET ) && $_GET['team_roles'] ) {
	$filter_roles = $_GET['team_roles'];
	$querystring .= 'team_roles=' . $filter_roles . '&';		    
	$filters[] = 'team_roles';          
};

// Add filters, if any, to query
if ( count( $filters )):
	if ( count( $filters ) == 1 ):
		$filter_name = $filters[0];
		$args['tax_query'] = array(	             
			array(
				'taxonomy' => $filter_name,
				'field'    => 'slug',
				'terms'    => array( $_GET[$filter_name] ),
			)
		);	          
	else:
	
		$tax_query = array();
		$tax_query['relation'] = 'AND';
		
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
	
	$args = array( 
		'fields' => 'ids', 
		'post_type' => $post_type,
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'orderby' => 'menu_order',
		'order' => 'DESC',
		's' => $_GET['search']	                 					                          
	);
	
	$args['tax_query'] = array(	             
		array(
			'taxonomy' => 'team_roles',
			'field'    => 'slug',
			'terms'    => $first_role,
		)
	);	          
	
				
	$search_results_query = new SWP_Query( $args );	
	
	$search_results_array = $search_results_query->posts;
	wp_reset_postdata();
	
	if ( count( $search_results_array ) ) {
	
		// Get all resources that are in the array of search results.
		// For some reason, we can't get the original search results query
		// to include only resources, thus this extra query.
		$posts = get_posts(array(
				'post_type' => $post_type,
				'post__in' => $search_results_array,
				'post_status' => 'publish',
				'posts_per_page' => -1
		));									

		$args = array(
				'post_type' => $post_type,
				'post__in' => $search_results_array,
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'orderby' => 'menu_order',
				'order' => 'DESC',
				'paged' => $paged         	          									    
		);				
		$the_query = new WP_Query( $args );
		$results_found = TRUE;
	
	} else {
		$results_found = FALSE;
	}
	
	$querystring .= 'search=' . $search_query . '&sort=' . $sort;
	wp_reset_postdata();

} else {
	$results_found = TRUE;
	$the_query = new WP_Query( $args );
	wp_reset_postdata();
}

// print ( '<pre>' );
// print_r( $args );
// print ( '</pre> ');
?>

<div id="team-list-wrapper">
	<div class="row">
		<div class="col-12" id="posts-ajax">	

			<?php
				global $post;
				$the_query = new WP_Query( $args );
				if ( $the_query->have_posts() ):
							
					$resources_list = array();	
					while ( $the_query->have_posts() ):
						$the_query->the_post();			

						$resource_id = $post->ID;							
						$resources_list[$resource_id]['id'] = $post->ID;
						$resources_list[$resource_id]['title'] = get_the_title( $resource_id );
						
					endwhile;
			
					if ( count($resources_list) > 0 ):?>
						<div class="grid">
							<ul class="gridder">
								<?php
								
								$i = 1;
								foreach ( $resources_list AS $resource_item):			
									$resource_id = $resource_item['id'];?>
									
									<li class="gridder-list resource" data-griddercontent="#content<?php echo $i; ?>">
	
										<div class="inner">
											<div class="thumb">
                        <a href="<?php echo get_permalink( $resource_id ); ?>">
													<?php echo get_the_post_thumbnail( $resource_id, 'medium' ); ?>
                        </a>                      
											</div>
											<div class="text">
												<h3><?php echo get_the_title( $resource_id ); ?></h3>
												<?php if ( get_field( 'team_position', $resource_id )) { ?>
														<p><?php echo get_field( 'team_position', $resource_id ); ?></p>
												<?php } ?>	

                        <?php if ( get_field( 'team_additional_affiliations', $resource_id )) { ?>
														<p class="additional-affiliations"><?php echo get_field( 'team_additional_affiliations', $resource_id ); ?></p>
												<?php } ?>	

                        <?php if ( get_field( 'team_degrees', $resource_id )) { ?>
														<p class="degrees"><?php echo get_field( 'team_degrees', $resource_id ); ?></p>
												<?php } ?>	

                        <?php if ( get_field( 'team_email', $resource_id )) { ?>
														<p class="email"><svg width="24" height="15" viewBox="0 0 24 15" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M21.7118 0.445068H1.50163C0.67485 0.445068 0 1.11022 0 1.92513V2.77137H0.14133L8.15473 6.56729L11.6067 8.20058L15.0587 6.56729L23.0721 2.77137H23.2134V1.92513C23.2134 1.11022 22.5386 0.445068 21.7118 0.445068Z" fill="#4C2E82"/>
<path d="M16.5928 6.99951L21.6245 14.7303H21.7114C22.5382 14.7303 23.213 14.0651 23.213 13.2502V3.86353L16.5928 6.99951Z" fill="#4C2E82"/>
<path d="M15.5175 7.50885L11.6065 9.3591L7.69592 7.50885L7.5825 7.45557L2.8476 14.7301H20.3654L15.6305 7.45557L15.5175 7.50885Z" fill="#4C2E82"/>
<path d="M1.58855 14.7303L6.62025 6.99951L0 3.86353V13.2502C0 14.0651 0.67485 14.7303 1.50163 14.7303H1.58855Z" fill="#4C2E82"/>
</svg>
<?php echo get_field( 'team_email', $resource_id ); ?></p>
												<?php } ?>
                        
                        <?php if ( get_field( 'team_phone', $resource_id )) { ?>
														<p class="phone"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
  <path d="M15.7377 12.6C15.7377 12.6 14.5305 14.3236 13.6579 14.3476C11.0364 14.42 7.22929 9.89514 5.81531 7.30782C5.39658 6.54194 7.70691 4.56919 7.70691 4.56919L4.0908 0.765137L1.79513 3.04757C0.480053 4.36264 0.761834 6.79639 2.07691 8.11146L12.1723 18.2069C13.4874 19.5219 15.6393 19.5219 16.9541 18.2069L19.2129 16.1225L15.7377 12.6Z" fill="#4C2E82"/>
</svg><?php echo get_field( 'team_phone', $resource_id ); ?></p>
												<?php } ?>	

                        <?php if ( get_field( 'team_office_number', $resource_id )) { ?>
														<p class="room"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="23" viewBox="0 0 15 23" fill="none">
  <path d="M7.48989 0.40625C3.46567 0.40625 0.203125 3.66849 0.203125 7.69302C0.203125 9.77179 2.14735 13.5463 4.02723 16.71C4.58048 17.6411 5.12819 18.5194 5.61925 19.286C6.68942 20.9572 7.48989 22.0975 7.48989 22.0975C7.48989 22.0975 8.29314 20.9532 9.36639 19.2774C9.85098 18.5203 10.3907 17.6549 10.9365 16.7374C12.8214 13.5682 14.777 9.77794 14.777 7.69302C14.7767 3.66849 11.5144 0.40625 7.48989 0.40625ZM7.48989 11.3192C5.40528 11.3192 3.71536 9.62924 3.71536 7.54462C3.71536 5.46001 5.40528 3.77008 7.48989 3.77008C9.57451 3.77008 11.2644 5.46001 11.2644 7.54462C11.2644 9.62924 9.57451 11.3192 7.48989 11.3192Z" fill="#4C2E82"/>
</svg><?php echo get_field( 'team_office_number', $resource_id ); ?></p>
												<?php } ?>	

												<?php if ( get_field( 'team_pronouns', $resource_id ) OR  get_field( 'team_affinity_group', $resource_id )) { ?>
													<div class="pronouns">													
														<?php echo get_field( 'team_pronouns', $resource_id ); ?><?php if ( get_field( 'team_pronouns', $resource_id ) AND get_field( 'team_affinity_group', $resource_id )) { echo ', ';
														}?><?php echo get_field( 'team_affinity_group', $resource_id ); ?>
													</div>
												<?php } ?>
                        
											</div>
										</div>

									</li>
	
									<?php	     
									$i++; 
								endforeach;?>
							</ul>
						</div>
						
						<?php
					else:
						echo 'No resources found';
					endif;
				else:?>
					<div class="not-found">
						<h3><?php echo get_field( 'text_no_team_members_found', 'options' ); ?></h3>
					</div>
					<?php
				endif; 									
				?>

				<div class="row spinner-row">
					<div class="col-12">
						<div class="icon-spinner-circle"></div>
					</div>
				</div>
				
				<?php						
				$next_posts_link = get_next_posts_link('See More <i class="fa fas fa-arrow-down"></i>', $the_query->max_num_pages);
									
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
				?>
		</div>
	</div>
</div>