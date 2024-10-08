<?php
/**
 * Template part for displaying page content in single-team.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package socialwork
 */

?>
<?php $resource_id = get_the_ID(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<div class="row no-gutters">
			<div class="col-12 col-md-3">
				<?php if ( has_post_thumbnail() ) { ?>
					<div class="image">
						<?php
						the_post_thumbnail( 'medium', array( 'class' => 'img-fluid' ) );
						?>
					</div>
					<?php
				}
				?>

				<?php if ( get_field( 'team_email', $resource_id )) { ?>
					<p class="email">
						<svg width="24" height="15" viewBox="0 0 24 15" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M21.7118 0.445068H1.50163C0.67485 0.445068 0 1.11022 0 1.92513V2.77137H0.14133L8.15473 6.56729L11.6067 8.20058L15.0587 6.56729L23.0721 2.77137H23.2134V1.92513C23.2134 1.11022 22.5386 0.445068 21.7118 0.445068Z" fill="#4C2E82"/>
							<path d="M16.5928 6.99951L21.6245 14.7303H21.7114C22.5382 14.7303 23.213 14.0651 23.213 13.2502V3.86353L16.5928 6.99951Z" fill="#4C2E82"/>
							<path d="M15.5175 7.50885L11.6065 9.3591L7.69592 7.50885L7.5825 7.45557L2.8476 14.7301H20.3654L15.6305 7.45557L15.5175 7.50885Z" fill="#4C2E82"/>
							<path d="M1.58855 14.7303L6.62025 6.99951L0 3.86353V13.2502C0 14.0651 0.67485 14.7303 1.50163 14.7303H1.58855Z" fill="#4C2E82"/>
						</svg>
						<?php echo get_field( 'team_email', $resource_id ); ?>
					</p>
				<?php } ?>
                        
				<?php if ( get_field( 'team_phone', $resource_id )) { ?>
					<p class="phone">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
							<path d="M15.7377 12.6C15.7377 12.6 14.5305 14.3236 13.6579 14.3476C11.0364 14.42 7.22929 9.89514 5.81531 7.30782C5.39658 6.54194 7.70691 4.56919 7.70691 4.56919L4.0908 0.765137L1.79513 3.04757C0.480053 4.36264 0.761834 6.79639 2.07691 8.11146L12.1723 18.2069C13.4874 19.5219 15.6393 19.5219 16.9541 18.2069L19.2129 16.1225L15.7377 12.6Z" fill="#4C2E82"/>
						</svg>
						<?php echo get_field( 'team_phone', $resource_id ); ?>
					</p>
				<?php } ?>	

				<?php if ( get_field( 'team_office_number', $resource_id )) { ?>
					<p class="room">
						<svg xmlns="http://www.w3.org/2000/svg" width="15" height="23" viewBox="0 0 15 23" fill="none">
							<path d="M7.48989 0.40625C3.46567 0.40625 0.203125 3.66849 0.203125 7.69302C0.203125 9.77179 2.14735 13.5463 4.02723 16.71C4.58048 17.6411 5.12819 18.5194 5.61925 19.286C6.68942 20.9572 7.48989 22.0975 7.48989 22.0975C7.48989 22.0975 8.29314 20.9532 9.36639 19.2774C9.85098 18.5203 10.3907 17.6549 10.9365 16.7374C12.8214 13.5682 14.777 9.77794 14.777 7.69302C14.7767 3.66849 11.5144 0.40625 7.48989 0.40625ZM7.48989 11.3192C5.40528 11.3192 3.71536 9.62924 3.71536 7.54462C3.71536 5.46001 5.40528 3.77008 7.48989 3.77008C9.57451 3.77008 11.2644 5.46001 11.2644 7.54462C11.2644 9.62924 9.57451 11.3192 7.48989 11.3192Z" fill="#4C2E82"/>
						</svg>
						<?php echo get_field( 'team_office_number', $resource_id ); ?>
					</p>
				<?php } ?>	

				<?php 
				$team_cv = get_field( 'team_cv', $resource_id );
				if ( $team_cv != '') { ?>
					<p class="cv">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" viewBox="0 0 20 25" fill="none">
							<path d="M13.583 0.982666V6.44742H19.0478L13.583 0.982666Z" fill="#4C2E82"/>
							<path d="M4.43096 12.303C4.34487 12.303 4.24943 12.309 4.14537 12.3217C4.04094 12.3337 3.94887 12.3464 3.86914 12.3584V14.9478C3.95485 14.9597 4.0488 14.9695 4.14986 14.9755C4.2513 14.9815 4.34487 14.9845 4.43096 14.9845C4.6765 14.9845 4.88536 14.9612 5.05754 14.9156C5.22971 14.8692 5.36746 14.7924 5.47226 14.6854C5.57669 14.5776 5.65342 14.4395 5.70245 14.2707C5.75149 14.1011 5.77619 13.8941 5.77619 13.6482C5.77619 13.1631 5.67663 12.8173 5.47675 12.6118C5.27725 12.4055 4.9284 12.303 4.43096 12.303Z" fill="#4C2E82"/>
							<path d="M11.0235 12.8285C10.891 12.6379 10.7177 12.5009 10.5028 12.4182C10.2876 12.3351 10.0237 12.2936 9.71008 12.2936C9.58731 12.2936 9.47839 12.2981 9.38295 12.3071C9.28787 12.3168 9.19692 12.3303 9.11121 12.349V17.1767C9.26467 17.1954 9.3923 17.2081 9.49374 17.2141C9.59517 17.2201 9.68875 17.2231 9.77484 17.2231C10.0694 17.2231 10.3198 17.1819 10.5253 17.0984C10.7312 17.0154 10.8974 16.8787 11.0231 16.6882C11.1489 16.4977 11.241 16.2443 11.2994 15.9276C11.3574 15.6121 11.3866 15.2168 11.3866 14.7437C11.3866 14.2833 11.3592 13.8963 11.3038 13.583C11.2488 13.2697 11.1549 13.0182 11.0231 12.8277L11.0235 12.8285Z" fill="#4C2E82"/>
							<path d="M12.4606 7.57032V0.677246H0.310547V24.6772H19.0483V7.57032H12.4606ZM6.42134 15.4594C5.97293 15.8374 5.25727 16.0257 4.27436 16.0257H3.869V18.1547H2.57879V11.3814C2.85503 11.3328 3.13201 11.2976 3.40824 11.2755C3.68447 11.2534 3.95808 11.2433 4.22833 11.2433C5.22995 11.2433 5.95758 11.4338 6.41236 11.8149C6.86675 12.1959 7.09395 12.8071 7.09395 13.6482C7.09395 14.4776 6.86975 15.0817 6.42134 15.4594ZM12.5306 16.3757C12.4075 16.8241 12.2114 17.1902 11.9407 17.4728C11.6705 17.7554 11.3231 17.9608 10.8994 18.09C10.4754 18.2191 9.95958 18.2835 9.35135 18.2835C9.14249 18.2835 8.91978 18.276 8.68322 18.2603C8.44667 18.2453 8.16894 18.2221 7.84929 18.1914V11.3635C8.21797 11.3208 8.52976 11.2916 8.78466 11.2759C9.03918 11.2609 9.27723 11.2527 9.49844 11.2527C10.076 11.2527 10.5689 11.317 10.9777 11.4462C11.386 11.5753 11.7192 11.7816 11.9774 12.0641C12.2353 12.3467 12.4228 12.7091 12.5396 13.1515C12.6564 13.5932 12.7148 14.128 12.7148 14.7546C12.7148 15.3875 12.6534 15.9277 12.5306 16.3757ZM17.4418 12.4231H14.8711V14.3032H17.2026V15.3905H14.8711V18.1547H13.5809V11.3358H17.4418V12.4231Z" fill="#4C2E82"/>
						</svg>
						<a href="<?php echo $team_cv['url'];?>" target="_blank" download>Download Curriculum Vitae</a>
					</p>
				<?php } ?>

				<?php
				if ( get_field( 'team_professional_interests', $resource_id )) { ?>
					<div class="professional-interests">
						<h3>Professional interests</h3>
						<?php echo get_field( 'team_professional_interests', $resource_id ); ?>
					</div>
				<?php 
				} ?>

				<?php
				$posts = get_field('team_news', $resource_id);
				if ($posts): ?>
					<div class="related-news">						
						<h3><?php _e( 'Related news', 'socialwork'); ?></h3>

						<ul>
							<?php
							foreach ($posts as $post):
								setup_postdata($post); ?>
								<li>
									<div class="meta-data">
										<?php
										$news_date = get_the_date( 'F j, Y' );
										echo $news_date;
										?>
									</div>

									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</li>
								
								<?php
							endforeach;
							wp_reset_postdata();
							?>
						</ul>
					</div>
					<?php
				endif;
				?>

				
			</div>

			<div class="col-12 col-md-8 offset-md-1">
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header><!-- .entry-header -->

				<?php if ( get_field( 'team_position', $resource_id )) { ?>
						<p class="title"><?php echo get_field( 'team_position', $resource_id ); ?></p>
				<?php } ?>	

				<?php if ( get_field( 'team_additional_affiliations', $resource_id )) { ?>
						<p class="additional-affiliations"><?php echo get_field( 'team_additional_affiliations', $resource_id ); ?></p>
				<?php } ?>	

				<?php if ( get_field( 'team_degrees', $resource_id )) { ?>
						<p class="degrees"><?php echo get_field( 'team_degrees', $resource_id ); ?></p>
				<?php } ?>	

				<div class="bio">
					<?php
					the_content();
					?>
				</div>

				<?php
				$posts = get_field('team_publications', $resource_id);
				if ($posts): ?>
					<div class="published-research">						
						<h3><?php _e( 'Published research', 'socialwork'); ?></h3>

						<ul>
							<?php
							foreach ($posts as $post):
								setup_postdata($post); ?>
								<li>
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</li>
								
								<?php
							endforeach;
							wp_reset_postdata();
							?>
						</ul>
					</div>
					<?php
				endif;
				?>

				<?php
				// Query research projects.
				$loop_count = 1;
				$max_projects = 5;
				$research_projects = array();

				// First group: Principal investigator.
				$posts = get_field('team_projects_principal_investigator', $resource_id);
				if ($posts): 
					foreach ($posts as $post):
						setup_postdata($post);
						$research_projects[$loop_count]['title'] = get_the_title();
						$research_projects[$loop_count]['permalink'] = get_permalink();
						$loop_count++;
					endforeach;
				endif;

				// Second group: Co-investigator.
				$posts = get_field('team_projects_co_investigator', $resource_id);
				if ($posts): 
					foreach ($posts as $post):
						setup_postdata($post);
						$research_projects[$loop_count]['title'] = get_the_title();
						$research_projects[$loop_count]['permalink'] = get_permalink();
						$loop_count++;
					endforeach;
				endif;

				// Third group:	Other investigator.
				$posts = get_field('team_projects_other_investigator', $resource_id);
				if ($posts): 
					foreach ($posts as $post):
						setup_postdata($post);
						$research_projects[$loop_count]['title'] = get_the_title();
						$research_projects[$loop_count]['permalink'] = get_permalink();
						$loop_count++;
					endforeach;
				endif;

				wp_reset_postdata();
				?>				

				<?php
				if (count($research_projects)): ?>
					<div class="research-projects">						
						<h3><?php _e( 'Research projects', 'socialwork'); ?></h3>

						<ul>
							<?php 
							$i = 1;
							foreach ($research_projects as $research_project): 
								if ( $i > $max_projects ):
									break; 
								endif; ?>
								<li>
									<a href="<?php echo $research_project['permalink']; ?>"><?php echo  $research_project['title']; ?></a>
								</li>								
								<?php
								$i++;
							endforeach;
							?>
						</ul>
					</div>
					<?php
				endif;
				?>
				
			</div>

		</div>
		<?php
		

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'uw_wp_theme' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
