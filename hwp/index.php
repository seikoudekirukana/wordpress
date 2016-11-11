<?php get_header(); ?>
<div id="index_page">
    <!-- #index_page top box-->

    <div class="container">
        <!-- Start CSlider -->
        <div id="da-slider" class="da-slider hidden-xs">

            <?php
            $query = new WP_Query(array(
                "posts_per_page"    => 6,
                "orderby"           => "date",
                "order"             =>"DESC"
            ));
            ?>
            <?php while( $query->have_posts() ): $query->the_post(); ?>
            <div class="da-slide">
                <h2 title="<?php the_title(); ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> <?php the_title(); ?> </a> </h2>
                <p><?php the_excerpt(); ?></p>
                <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" class="da-link"><?php _e( 'Read more', 'hwp' ); ?></a>
                <div class="da-img">
                    <?php the_post_thumbnail('post-thumbnail', array( 'class'=> 'img-responsive', 'style'=> 'height:100%' )); ?>
                </div>
            </div>
            <?php endwhile; wp_reset_query(); ?>

            <nav class="da-arrows">
                <span class="da-arrows-prev"></span>
                <span class="da-arrows-next"></span>
            </nav>

        </div>
        <!-- End CSlider -->

        <div class="row visible-xs">
            <?php
                $query = new WP_Query(array(
                    "posts_per_page"    => 6,
                    "orderby"           => "date",
                    "order"             =>"DESC"
                ));
                $allPost = $query->posts;
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div style="padding: 15px">
                    <div class="top_post">
                        <div class="row">
                            <?php foreach( $allPost as $index=>$post ):if( $index >=0 ): ?>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                    <div class="row hwp_wrap_figure_small"  style="background-image: url('<?php echo get_the_post_thumbnail_url($post->ID) ?>')">
                                        <!-- .item.small -->
                                        <div class="hwp_figure">
                                            <div class="desc_info">
                                                <h3><a href="<?php echo get_the_permalink($post->ID) ?>"><?php echo get_the_title( $post->ID ) ?></a></h3>

                                                <!--<p>
                                                    <span class="desc_info_date"> <?php /*echo get_the_date("d F Y",$post->ID) */?> </span>
                                                    <span class="desc_info_comment"> <span class="glyphicon glyphicon-comment"></span> <?php /*echo get_comments_number($post->ID); */?> <?php /*_e("Comments", "hwp") */?></span>
                                                </p>-->
                                            </div>
                                            <div class="hwp_figcaption">
                                                <h3><a href="<?php echo get_the_permalink($post->ID) ?>"><?php echo get_the_title( $post->ID ) ?></a></h3>

                                                <p>
                                                    <span class="figcaption_date"> <?php echo get_the_date("d F Y",$post->ID) ?> </span>
                                                    <span class="figcaption_comment"> <span class="glyphicon glyphicon-comment"></span> <?php echo get_comments_number($post->ID); ?> <?php _e("Comments", "hwp") ?></span>
                                                </p>

                                                <p><?php echo get_the_excerpt($post->ID); ?></p>

                                                <p><a href="<?php echo get_the_permalink($post->ID) ?>"><?php _e("Read more", "hwp"); ?></a></p>
                                            </div>
                                        </div>
                                        <!-- end .item.small -->
                                    </div>
                                </div>
                            <?php endif; endforeach; ?>
                        </div>
                    </div><!-- clearfix top_post -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col xs-12 col-md-8 col-lg-8">
                <!-- box list post by category-->
                <?php hwp_get_sidebar( 'hwp_sidebar_index_content' ); ?>
                <!-- end box list post by category-->

                <!-- Ads -->
                <div class="hwp_index_ads">

                </div>
                <!-- end Ads -->

            </div>
            <div class="col xs-12 col-md-4 col-lg-4">
                <?php get_sidebar(); ?>
            </div>
        </div>

    </div><!-- end .container -->

</div><!-- end "index_page -->

<?php get_footer(); ?>
