<?php
/**
 * Template part for displaying page content in single-resource.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package socialwork
 */

?>
<?php $resource_id = get_the_ID();
$resource_authors          = get_field( 'resource_authors', $resource_id );
$resource_author_list      = get_field( 'resource_author_list', $resource_id );
$resource_type             = get_the_terms( $resource_id, 'publication_types' );
$resource_publication_name = get_field( 'resource_publication_name', $resource_id );
$resource_year             = get_field( 'resource_year', $resource_id );
$resource_volume           = get_field( 'resource_volume', $resource_id );
$resource_issue            = get_field( 'resource_issue', $resource_id );
$resource_pagination       = get_field( 'resource_pagination', $resource_id );
$resource_date_published   = get_field( 'resource_date_published', $resource_id );
$resource_locator_url      = get_field( 'resource_locator_url', $resource_id );
$resource_locator_doi      = get_field( 'resource_locator_doi', $resource_id );
$resource_identifier       = get_field( 'resource_identifier', $resource_id );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<div class="row no-gutters">
			<div class="col-12 col-md-8 offset-md-1">
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header><!-- .entry-header -->

				<?php 
				if ($resource_author_list): ?>
					<p class="authors">
						<strong><?php _e( 'Author(s)', 'socialwork');?>:</strong> <?php echo $resource_author_list; ?>
					</p>
					<?php
				endif;

				/*
				if ($resource_authors):				
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
					*/
				?>

				<?php if ($resource_publication_name) {?>
					<p class="publication-name">
						<strong><?php _e( 'Publication', 'socialwork');?>:</strong> 
						<?php 
						if ($resource_year): echo $resource_year . '. ' ; endif;
						echo '<cite>"' . $resource_publication_name . '"</cite>';

						if ($resource_volume): echo ' ' . $resource_volume; endif;

						if ($resource_volume && $resource_issue): echo ', '; endif;

						if ($resource_issue): echo $resource_issue; endif;

						if ($resource_date_published): echo ' (' . $resource_date_published . ')'; endif;

						if ($resource_pagination): echo ': ' . $resource_pagination; endif;

						echo '. ';

						if ($resource_identifier): ?>						 
							<p class="publication-type"><strong><?php _e( 'Identifier(s)', 'socialwork');?>:</strong> <?php echo $resource_identifier; ?></p>
							<?php						 
						endif;

						if ($resource_locator_url): ?>
							<p class="publication-type"><strong><?php _e( 'URL', 'socialwork');?>:</strong> <a href="<?php echo $resource_locator_url; ?>" target="_blank"><?php echo $resource_locator_url; ?></a></p>
							<?php
						endif; 
						
						if ($resource_locator_doi): ?>
							<p class="publication-type"><strong><?php _e( 'DOI', 'socialwork');?>:</strong> <a href="https://doi.org/<?php echo $resource_locator_doi; ?>" target="_blank">https://doi.org/<?php echo $resource_locator_doi; ?></a></p>
							<?php
						endif; 
						?>
					</p>
				<?php } ?>	

				<?php
				if ($resource_type != ''): ?>
					<p class="publication-type">
						<strong><?php _e( 'Publication type', 'socialwork');?>:</strong> 
						<?php
						$i = 1;
						foreach ($resource_type as $type):
							echo $type->name;
							if ($i < count($resource_type)):
								echo ', ';
							endif;
							$i++;
						endforeach; ?>
					</p>
					<?php
				endif;				
				?>
				
				<p class="access">
					<strong><?php _e( 'Access', 'socialwork');?>:</strong>
					<a href="<?php echo generate_google_scholar_link($resource_id); ?>" target="_blank"><?php _e( 'Google Scholar', 'socialwork');?></a> | 
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/create-endnote-enw-file.php?publication_id=<?php echo $resource_id; ?>" target="_blank"><?php _e( 'Tagged', 'socialwork');?></a> |
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/create-endnote-xml-file.php?publication_id=<?php the_ID(); ?>" target="_blank" ><?php _e( 'XML', 'socialwork');?></a>
				</p>

				<?php if ( !empty( get_the_content() ) ): ?>
					<div class="abstract">
						<p><strong><?php _e( 'Abstract', 'socialwork'); ?>:</strong></p>
						<div class="entry">
							<?php the_content(); ?>
						</div>						
					</div>
				<?php endif; ?>

		</div>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
