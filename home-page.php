<?php
/**
* Template Name: Custom Home Page
*
* @package Fluffy-master
*/

get_header(); ?>

<div id="primary" class="content-area">
	<div id="main" class="site-main" role="main">
		<div class="gridBox">
			<!-- you can add a title for the overall page in this header -->
			<h2 class="grid-header"><?php _e('', 'rys'); ?></h2>
			<div class="boxes-container">	
			<?php
				//adding arguments for my custom posts in my home page
				$args = array(
						'post_type'         => 'post',         // replace "post" if you want to display different post-type
						'category_name'        => 'gallery',    // category slug
						'posts_per_page'    => -1            //  show all posts
					);
											
					//set the arguments for my query to show only 4 posts, from category 'Markup', in an ascending order
					$args=array ('showposts' =>4, 'order'=> 'ASC', 'cat'=>32);
					$my_query= new WP_Query($args);
					
				//loop for my posts starts here
					 if ($my_query->have_posts()) {
					 $c = 1;     // counter
					 $bpr = 2;     // number of columns per each row
					 while ($my_query->have_posts()): $my_query->the_post(); 			 
			?>
			<div class="grid-boxes <?php echo (($c != $bpr) ? 'margin_right' : ''); ?>">
					<div class="grid-thumbnail">
						<!-- the loop for my images, along with the posts' permalinks -->
						<?php if ( has_post_thumbnail()) { ?>
							<div class="alignleft">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php the_post_thumbnail(array(100, 100)); //specifies size of image
									?>
								</a>
							</div>
						<?php } else { ?>
							<!-- in case there was no thumbnail -->
							<img src="<?php bloginfo('template_directory'); ?>/images/no-thumbnail.jpg" alt="No Thumbnail" />
						<?php } ?>
					</div>
									
					<p class="grid-title">						
						<a href="<?php the_permalink() ?>" title="<?php printf(__('Permanent Link to %s','rys'), get_the_title()) ?>" rel="bookmark"><?php the_title(); ?></a>
					</p>
				</div> 
							
				<?php                       
                    // add a condition here to see if the counter is equal to the number of columns.
                    if( $c == $bpr ) { 
                    echo '<div class="clear"></div>';
                    $c = 0;     // back the counter to 0 if the condition above is true.
                    }
                    $c++;             // increment counter of 1 until it hits the limit of columns per row.
                        
						endwhile;
					} else {		 
						// a message when no posts are found
						_e( '<h2>Whoopsie daisy!</h2>', 'rys' );
						_e( '<p>Sorry, it seems like there are no posts at the moment.</p>', 'rys' );		 
					}
		 
					/* Restore original Post Data */
					wp_reset_postdata();
				?>
				
			</div> <!--#boxes-container -->
			<div class="clear"></div>
		</div> <!--#gridBox -->
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