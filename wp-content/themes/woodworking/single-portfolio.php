
<?php get_template_part( 'templates/portfolio', 'header' );?>
		<!-- end #menu -->
		<div id="page">
			<div id="page-bgtop">
				<div id="page-bgbtm">
					<div id="content">
						<div class="post">
						<?php 
							
							if ( have_posts() ) :
							while( have_posts() ): the_post(); ?>
							<h2 class="title"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a></h2>
							<p class="meta">Posted by <a href="#"><?php the_author(); ?></a> <?php echo get_the_date(); ?>
								&nbsp;&bull;&nbsp; <a href="#" class="comments">Comments (64)</a> &nbsp;&bull;&nbsp; <a href="#" class="permalink">Full article</a></p>
							<div class="entry">
								<p><?php the_post_thumbnail('thumbnail',array('class' => 'alignleft border'));?> <?php the_content(); ?></p>
								
							</div>
							<?php endwhile; ?>
							<?php endif; ?>
							</div>
						</div>
					</div>
					<?php get_sidebar();?>
					<div style="clear: both;">&nbsp;</div>
                    <?php comments_template('/comments.php');?>
                    
					
				</div>
			</div>
		</div>
        <?php get_template_part( 'templates/portfolio', 'footer' );?>

		<!-- end #page -->