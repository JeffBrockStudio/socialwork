<?php
$permalink = esc_url( get_permalink( $resource_id ));
$target = '';

$resource_authors          = get_field( 'resource_authors', $resource_id );
$resource_publication_name = get_field( 'resource_publication_name', $resource_id );
$resource_locator_url      = get_field( 'resource_locator_url', $resource_id );
$resource_locator_doi      = get_field( 'resource_locator_doi', $resource_id );
?>

<div class="col-12 item">
	<article <?php post_class(); ?>>									
										
		<div class="row">
				
			<div class="col-12">
				<?php if ( $show['thumbnails'] ): ?>
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

          <?php if ($resource_authors):				
					// Display authors and their links.
					$posts = $resource_authors; ?>
						<p class="authors">
							<strong><?php 
								if (count($resource_authors) == 1):
									_e( 'Authors', 'socialwork');
								else:
									_e( 'Author(s)', 'socialwork');
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

          <?php if ($resource_publication_name) {?>
            <p class="publication-name">
              <strong><?php _e( 'Publication', 'socialwork');?>:</strong> 
              <?php echo $resource_publication_name;              

              if ($resource_locator_url): ?>
                <br><strong><?php _e( 'URL', 'socialwork');?>:</strong> <a href="<?php echo $resource_locator_url; ?>" target="_blank"><?php echo $resource_locator_url; ?></a>
                <?php
              endif; 
              
              if ($resource_locator_doi): ?>
                <br><strong><?php _e( 'DOI', 'socialwork');?>:</strong> <?php echo $resource_locator_doi; ?>
                <?php
              endif; 
              ?>
            </p>
				<?php } ?>	

					<?php if ( $show['date'] ): ?>
						<div class="entry-meta">
							<?php echo ( get_the_date( get_option('date_format'), $resource_id )); ?>																
						</div>
					<?php endif; ?>						
										
					<?php if ( $show['excerpt'] ): ?>
						<div class="text">
							<?php echo apply_filters( 'the_content', get_field( 'resource_short_description_text', $resource_id )); ?>	
						</div>
					<?php endif; ?>
					
					<?php if ( $show['button'] ): ?>
						<div class="buttons">
							<a class="btn btn-primary" href="<?php echo $permalink; ?>" target="<?php echo $target; ?>">
                <?php _e( 'Read More', 'socialwork'); ?>
              </a>
						</div>
					<?php endif; ?>
					
				</div>
				
			</div>
							
		</div>

	</article>
</div>