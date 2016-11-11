<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(array( "hwp_item_catPage" )); ?>>
    <div class="row">
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
            <div class="entry-image pull-left">
                <a href="<?php the_permalink(); ?>" title=""> <?php the_post_thumbnail( "medium", array( "class"=>"img-responsive" )); ?> </a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
            <div class="entry-header">
                <h3 title=""><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> <?php the_title(); ?> </a> </h3>
                <p class="after_title">
                    <div class="cat_of_item"><?php the_category( "&nbsp;" ); ?></div>
                    <div class="info_small">
                        <span class="glyphicon glyphicon-calendar"></span> <span> <?php the_date( "d-m-Y" ) ?> </span>
                        <span class="glyphicon glyphicon-comment"></span> <span> <?php  comments_number(); ?> </span>
                    </div>
                </p>
            </div>
            <!-- .entry-header -->

            <div class="entry-content">
                <?php the_excerpt(); ?>
            </div>
            <!-- .entry-content -->

            <div class="entry-footer">
                <a href="<?php the_permalink(); ?>" title=""> Read more <span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
            <!-- .entry-footer -->
        </div>
    </div>


    <!-- #post-## -->
</div>
