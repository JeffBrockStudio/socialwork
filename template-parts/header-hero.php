<?php
$top_ancestor_id = get_top_ancestor_id();  
if ($top_ancestor_id == $post->ID):
  $landing_page = true;
else:
  $landing_page = false;
endif;
$top_ancestor_title = get_the_title( $top_ancestor_id );

$featured_image_url = get_the_post_thumbnail_url( $top_ancestor_id, 'large' );
?>


<div class="container-fluid">
  <div class="hero-default card text-left large purple img-right">
    <div class="image-large" style="background-image: url(<?php echo $featured_image_url;?>)"></div>
    <div class="card-body">
      <div class="inner-card-body">
        <?php
        if ($landing_page): ?>
          <h1 class="card-title"><?php echo $top_ancestor_title;?></h1>
          <?php
        else: ?>
          <h2 class="card-title"><?php echo $top_ancestor_title;?></h2>
          <?php
        endif;
        ?>
      </div>
    </div>
  </div>
</div>