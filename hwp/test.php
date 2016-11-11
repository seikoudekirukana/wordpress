<div class="row">
    <div class="col xs-12 col-md-8 col-lg-8">
        <!-- box list post by category-->
        <?php
        $arrCats = get_categories();
        ?>
        <div class="row">
            <?php $hwp_counter = 1; ?>
            <?php if( count($arrCats) > 0 ): foreach( $arrCats as $index => $cat ): ?>
                <?php
                $arrPosts = new WP_Query(array(
                    "post_type"         => "post",
                    "cat"            => $cat->term_id,
                    "posts_per_page"    => 5
                ));
                $listPost = $arrPosts->posts;
                ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 column_cat_<?php echo $hwp_counter; ?>">
                    <div class="category_post">
                        <div class="box_title clearfix">
                            <a class="pull-left" href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->name; ?></a>
                            <a class="pull-right" href="<?php echo get_category_link($cat->term_id); ?>">View all <span class="glyphicon glyphicon-chevron-right"></span></a>
                        </div>
                        <a class="big_img" href="<?php echo get_the_permalink($listPost[0]->ID); ?>">
                            <img class="img-responsive" src="<?php echo get_the_post_thumbnail_url($listPost[0]->ID); ?>" alt="<?php echo get_the_title($listPost[0]->ID); ?>"/>
                        </a>
                        <h4 class="big_title" title="<?php echo get_the_title($listPost[0]->ID); ?>">
                            <a href="<?php echo get_the_permalink($listPost[0]->ID) ?>" title="<?php echo get_the_title($listPost[0]->ID) ?>"><?php echo get_the_title($listPost[0]->ID) ?></a></h4>
                        <div class="big_after_title">
                            <?php  the_category( ",","", $listPost[0]->ID ); ?>&nbsp;
                            <span class="date_post"><span class="glyphicon glyphicon-calendar"></span> <?php echo get_the_date("d-m-Y", $listPost[0]->ID) ?></span>&nbsp;
                            <span class="date_post"><span class="glyphicon glyphicon-comment"></span> <?php echo get_comments_number($listPost[0]->ID); ?></span>
                        </div>
                        <div class="big_excerpt">
                            <?php echo get_the_excerpt($listPost[0]->ID); ?>
                        </div>
                        <div class="list-item">
                            <?php foreach( $listPost as $k=> $post ): if( $k != 0 ): ?>
                                <div class="item">
                                    <div class="img pull-left">
                                        <a href="<?php the_permalink($post->ID); ?>"
                                           title="<?php echo get_the_title($post->ID); ?>">
                                            <img class="img-responsive" src="<?php echo get_the_post_thumbnail_url($post->ID)?>"
                                                 title="<?php echo get_the_title($post->ID) ?>" alt="<?php echo get_the_title($post->ID) ?>"/>
                                        </a>
                                    </div>
                                    <h5 title="<?php echo get_the_title($post->ID) ?>">
                                        <a href="<?php echo get_the_permalink($post->ID) ?>" title="<?php echo get_the_title($post->ID) ?>">
                                            <?php echo get_the_title($post->ID) ?>
                                        </a>
                                    </h5>
                                    <div class="small_after_title">
                                        <span class="date_post"><span class="glyphicon glyphicon-calendar"></span> <?php echo get_the_date("d-m-Y", $post->ID) ?></span>&nbsp;
                                        <span class="date_post"><span class="glyphicon glyphicon-comment"></span> <?php echo get_comments_number( $post->ID ) ?></span>
                                    </div>
                                </div>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php if( $hwp_counter % 2 == 0 ): ?>
                    <div class="clearfix"></div>
                <?php endif; $hwp_counter ++; ?>
            <?php endforeach; endif; ?>
        </div>
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