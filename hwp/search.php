<?php
/**
 * The template for displaying search results pages
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <main id="main" class="site-main" role="main">

                        <?php if ( have_posts() ) : ?>

                            <header class="page-header">
                                <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentysixteen' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
                            </header><!-- .page-header -->

                            <?php
                            // Start the loop.
                            while ( have_posts() ) : the_post();

                                /**
                                 * Run the loop for the search to output the results.
                                 * If you want to overload this in a child theme then include a file
                                 * called content-search.php and that will be used instead.
                                 */
                                get_template_part( 'template-parts/content', '' );

                                // End the loop.
                            endwhile;

                        // If no content, include the "No posts found" template.
                        else :
                            get_template_part( 'template-parts/content', 'none' );

                        endif;
                        ?>

                    </main><!-- .site-main -->
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <!-- Sidebar -->
                    <?php  get_sidebar(); ?>
                </div>
            </div>
        </div>
	</section><!-- .content-area -->

<?php get_footer(); ?>
