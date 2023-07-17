<?php
$permalink = esc_url( get_permalink( $resource_id ));
$target = '';
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