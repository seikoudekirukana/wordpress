<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <main id="main" class="site-main" role="main">

                        <section class="error-404 not-found">
                            <header class="page-header">
                                <h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'hwp' ); ?></h1>
                            </header><!-- .page-header -->

                            <div class="page-content">
                                <p><?php _e( 'Enter other keywords and search again ', 'hwp' ); ?></p>

                            </div><!-- .page-content -->
                        </section><!-- .error-404 -->

                    </main><!-- .site-main -->
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>

	</div><!-- .content-area -->
<?php get_footer(); ?>
