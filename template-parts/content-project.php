<?php
/**
 * Template part for displaying page content in single-project.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package socialwork
 */

?>
<?php $resource_id = get_the_ID();

$project_principal_investigators = get_field( 'project_principal_investigators', $resource_id );
$project_co_investigators        = get_field( 'project_co_investigators', $resource_id );
$project_other_investigators     = get_field( 'project_other_investigators', $resource_id );
$project_other_names             = get_field( 'project_other_names', $resource_id );
$project_funding                 = get_field( 'project_funding', $resource_id );
$project_date                    = get_field( 'project_date', $resource_id );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<div class="row no-gutters">
			<div class="col-12 col-md-8 offset-md-1">
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header><!-- .entry-header -->

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

				<?php if ($project_co_investigators):				
					// Display co-investigators and their links.
					$posts = $project_co_investigators; ?>
						<p class="authors">
							<strong><?php 
								if (count($project_co_investigators) == 1):
									_e( 'Co-Investigator', 'socialwork');
								else:
									_e( 'Co-Investigators', 'socialwork');
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

				<?php if ($project_other_investigators):				
					// Display other investigators and their links.
					$posts = $project_other_investigators; ?>
						<p class="authors">
							<strong><?php 
								if (count($project_other_investigators) == 1):
									_e( 'Other Investigator', 'socialwork');
								else:
									_e( 'Other Investigators', 'socialwork');
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

				<?php if ($project_funding): ?>
					<p class="funding">
						<strong><?php _e( 'Funding', 'socialwork');?>:</strong> 
						<?php echo $project_funding; ?>
					</p>
				<?php endif; ?>	

				<?php if ($project_date): ?>
					<p class="project-date">
						<strong><?php _e( 'Date', 'socialwork');?>:</strong> 
						<?php echo $project_date; ?>
					</p>
				<?php endif; ?>	
				
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
