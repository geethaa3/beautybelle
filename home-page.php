<?php
/**
* Template Name: Custom Home Page
*
* @package BeautyBelle
*/

get_header(); ?>

<div id="primary" class="content-area">
	<div id="main" class="site-main" role="main">
		<?php 
			$args = array('showposts'=> 4, 'order'=>'ASC', 'cat'=> 32);
			$my_query = new WP_Query($args);
		?>

		<?php if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); ?>

	<article id="post-<?php the_ID(); ?>"<?php post_class(); ?>>
		<h2 class="post-title"><?php the_title(); ?></h2>
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-## -->
	
		<?php endwhile; endif; ?>

	</div><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>