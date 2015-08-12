<?php
/**
 * Archives template for testimonials
 */

get_header(); ?>

	<section id="primary" class="site-content">

		<div id="content" role="main">
			<header class="archive-header">
				<h1 class="archive-title">Testimonials</h1>
			</header><!-- #archive-header -->
			
			<!-- This is a loop which displays the testimonial data. This data includes the meta data, name of the client for which the testimonial is from, the data source, 
				as well as the link. Each of these pieces of data have variables assigned to them which enables them to be displayed, given certain parameters. --> 
			<?php while ( have_posts() ) : the_post();
				$testimonial_data = get_post_meta( get_the_ID(), '_testimonial', true );
				$client_name = ( empty( $testimonial_data['client_name'] ) ) ? '' : $testimonial_data['client_name'];
				$source = ( empty( $testimonial_data['source'] ) ) ? '' : ' - ' . $testimonial_data['source'];
				$link = ( empty( $testimonial_data['link'] ) ) ? '' : $testimonial_data['link'];
				$cite = ( $link ) ? '<a href="' . esc_url( $link ) . '" target="_blank">' . $client_name . $source . '</a>' : $client_name . $source;
				?>
			<?php wpb_display_testimonials(); ?>
			
			<!-- Here we have fittingly assigned each aspect of the testimonial an article, span class, div, class or p tag. This allows us to style each aspect of the plugin in the style sheet. -->
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'testimonial' ); ?>>
					<span class="quote">&ldquo;</span>
					<div class="entry-content">
						<p class="testimonial-text"><?php echo get_the_content(); ?><span></span></p>
						<p class="testimonial-client-name"><cite><?php echo $cite; ?></cite></p>
					</div>
				</article>

			<?php endwhile; ?>

			<?php
			global $wp_query;

			if (  1 < $wp_query->max_num_pages ) : ?>
				<nav class="archive-navigation" role="navigation">
					<div class="nav-previous alignleft"><?php next_posts_link( '<span class="meta-nav">&larr;</span> Older posts' ); ?></div>
					<div class="nav-next alignright"><?php previous_posts_link( 'Newer posts <span class="meta-nav">&rarr;</span>' ); ?></div>
				</nav><!-- .archive-navigation -->
				<?php
			endif;
			?>
		</div>

	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php die(); ?>