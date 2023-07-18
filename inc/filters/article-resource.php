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
										
		<div class="row no-gutters">
				
			<div class="col-12 col-md-9">
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

          <?php if ($resource_authors):				
					// Display authors and their links.
					$posts = $resource_authors; ?>
						<p class="authors">
							<strong><?php 
								if (count($resource_authors) == 1):
									_e( 'Author', 'socialwork');
								else:
									_e( 'Authors', 'socialwork');
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

					<?php if ( $show['date'] == 'true' ): ?>
						<div class="entry-meta">
							<?php echo ( get_the_date( get_option('date_format'), $resource_id )); ?>																
						</div>
					<?php endif; ?>						
										
					<?php if ( $show['excerpt'] == 'true' ): ?>
						<div class="text">
							<?php echo apply_filters( 'the_content', get_field( 'resource_short_description_text', $resource_id )); ?>	
						</div>
					<?php endif; ?>
					
					<?php if ( $show['button'] == 'true' ): ?>
						<div class="buttons">
							<a class="btn btn-primary" href="<?php echo $permalink; ?>" target="<?php echo $target; ?>">
                <?php _e( 'Read More', 'socialwork'); ?>
              </a>
						</div>
					<?php endif; ?>
					
				</div>
				
			</div>

      <div class="col-12 col-md-2 offset-md-1">
        <ul class="access">
					<li><a href="#" target="_blank"><?php _e( 'Google Scholar', 'socialwork');?></a></li>
					<li><a href="#" target="_blank"><?php _e( 'Tagged', 'socialwork');?></a></li>
					<li><a href="#" target="_blank"><?php _e( 'XML', 'socialwork');?></a></li>
				</ul>
      </div>
							
		</div>

	</article>
</div>