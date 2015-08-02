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
				//adding arguments for my custom posts in my home page
				$args = array(
						'post_type'         => 'post',         // replace "post" if you want to display different post-type
						'category_name'        => 'gallery',    // category slug
						'posts_per_page'    => -1            //  show all posts
					);
											
					//Finally set the arguments for my query to show only 5 posts, from category 'Markup', in an ascending order
					$args=array ('showposts' =>5, 'order'=> 'ASC', 'cat'=>32);
					$my_query= new WP_Query($args);
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