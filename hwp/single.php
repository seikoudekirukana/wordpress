<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main container post-type" role="main">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-8 col-lg-8">
                <?php
                // Start the loop.
                while ( have_posts() ) : the_post();

                    // Include the single post content template.
                    get_template_part( 'template-parts/content', 'single' );



                    // End of the loop.
                endwhile;
                ?>
            </div>
            <div class="col-xs-12 col-md-4 col-md-4 col-lg-4">
                <!-- Sidebar -->
                <?php get_sidebar(); ?>
            </div>
        </div>
	</main><!-- .site-main -->

</div><!-- .content-area -->
<?php get_footer(); ?>
