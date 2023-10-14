<?php
$permalink = esc_url( get_permalink( $resource_id ));
$target = '';

$project_principal_investigators = get_field( 'project_principal_investigators', $resource_id );
$project_date                    = get_field( 'project_date', $resource_id );
$show['date']                    = 'true';
?>

<div class="col-12 item">
	<article <?php post_class(); ?>>									
										
		<div class="row no-gutters">
				
			<div class="col-12">
				<?php if ( $show['thumbnails'] == 'true' ): ?>
					<div class="image">
            <a href="<?php echo $permalink; ?>">
              <?php echo get_the_post_thumbnail( $resource_id, 'medium' ); ?>
            </a>
					</div>	
				<?php endif; ?>
				
				<div class="inner">												
					<div class="title">
						<h3><a href="<?php echo $permalink; ?>" target="<?php echo $target; ?>"><?php echo get_the_title( $resource_id ); ?></a></h3>
					</div>

          <?php if ($project_principal_investigators):				
					// Display principal investigators and their links.
					$posts = $project_principal_investigators; ?>
						<p class="authors">
							<strong><?php 
								if (count($project_principal_investigators) == 1):
									_e( 'Principal Investigator', 'socialwork');
								else:
									_e( 'Principal Investigators', 'socialwork');
								endif; ?>:
							</strong>
							<?php
							$i = 1;
							foreach ($posts as $post):
								setup_postdata($post); ?>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								<?php
								if ($i < count($posts)):
									echo ' | ';
								endif;
								$i++;
							endforeach;
							wp_reset_postdata(); ?>
						</p>
						<?php
					endif;
				  ?>          

					<?php if ( $show['date'] == 'true' AND $project_date ): ?>
						<p class="project-date">
							<strong><?php _e( 'Date', 'socialwork');?>:</strong> <?php echo $project_date; ?>																
						</p>
					<?php endif; ?>						
					
				</div>
				
			</div>      
							
		</div>

	</article>
</div>