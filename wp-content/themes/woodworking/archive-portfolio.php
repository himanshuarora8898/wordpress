<?php
/**
* Template Name: Full Width Page
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/
 
    get_template_part( 'templates/portfolio', 'header' );
    $loop = new WP_Query( array( 'post_type' => 'Portfolio', 'posts_per_page' => 10 ) );

    while ( $loop->have_posts() ) : $loop->the_post();

    the_title('<h2 class="entry-title"><a href="'.get_permalink().'" title="'. the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' );
?>
<div class="entry-content">
    <?php the_content(); ?>
    <?php get_sidebar();?>
</div>


<?php endwhile; ?>
<?php get_template_part( 'templates/portfolio', 'footer' ); ?>
