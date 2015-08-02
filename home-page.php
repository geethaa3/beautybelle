<?php
/**
* Template Name: Custom Home Page
*
* @package Fluffy-master
*/

get_header(); ?>

<div id="primary" class="content-area">
	<div id="main" class="site-main" role="main">
			<?php
				//loop for my posts starts here
					 if ($my_query->have_posts()) {
					 $c = 1;     // counter
					 $bpr = 2;     // number of columns per each row
					 while ($my_query->have_posts()): $my_query->the_post(); 			 
			?>
				<!--article div-->
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<!-- <h1 class="post-title"><?php the_title(); ?></h1> -->
					</header><!-- .entry-header -->
				
					<div class="entry-content">												
						<?php wp_link_pages( array('before'=>' <div class="page-links">'.__( 'Pages:', 'underscores' ),'after'=> '</div>',) ); ?>
					</div><!-- .entry-content -->
				</article><!--#post-##-->			
	</div><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>