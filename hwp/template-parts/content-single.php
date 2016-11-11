<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

hwp_SetPostViewedCount(get_the_ID());
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title('<h2 class="entry-title">', '</h2>'); ?>
    </header>
    <!-- .entry-header -->
    <div class="single_post_after_title">
        <span class="cats"><?php the_category("&nbsp;") ?></span>&nbsp;
        <span class="date"> <span class="glyphicon glyphicon-calendar"></span> <?php the_date("d-m-Y") ?></span>&nbsp;
        <span class="author"> <span class="glyphicon glyphicon-user"></span> <?php the_author() ?></span>
        <span class="comment"> <span class="glyphicon glyphicon-comment"></span> <?php comments_number() ?></span>
    </div>

    <div class="single_post_tags">
        <?php
        $tags_list = wp_get_post_tags(get_the_ID());
        ?>
        <span class="glyphicon glyphicon-tags"></span>&nbsp;
        <?php foreach ($tags_list as $k => $objTag): ?>
            <a href="<?php echo get_tag_link($objTag->term_id); ?>">
                <span class="label label-info"><?php echo $objTag->name; ?></span>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="hwp_wrap_posts_related bs-callout bs-callout-danger">
        <?php

        $posts_related = new WP_Query(array(
            'category__in'      => wp_get_post_categories( $post->ID ),
            'post__not_in'      => array($post->ID),
            'posts_per_page'    =>3,
            'orderby'           =>'date',
            'order'             =>'DESC'
        ));

        ?>
        <ul class="hwp_posts_related">
        <?php while( $posts_related->have_posts() ): $posts_related->the_post(); ?>
            <li>
                <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
            </li>
        <?php endwhile; ?>
        <?php wp_reset_query(); ?>
        </ul>
    </div>

    <div class=" pd-t20 pd-b20">
        <?php the_post_thumbnail("post-thumbnail", array( "class"=>"img-responsive hwp-single-post-image" )); ?>
    </div>
    <!--Share facebook buttons-->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=461689310704290";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
    <div class="hwp-fb-like fb-like" data-href="<?php the_permalink(); ?>" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
    <!--End Share facebook buttons-->

    <div class="entry-content pd-b20">
        <?php
        the_content();

        wp_link_pages(array(
            'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'hwp') . '</span>',
            'after' => '</div>',
            'link_before' => '<span>',
            'link_after' => '</span>',
            'pagelink' => '<span class="screen-reader-text">' . __('Page', 'hwp') . ' </span>%',
            'separator' => '<span class="screen-reader-text">, </span>',
        ));

        /*if ('' !== get_the_author_meta('description')) {
            get_template_part('template-parts/biography');
        }*/
        ?>
    </div>
    <!-- .entry-content -->

    <!--Start entry-author -->
    <div class="entry-author">
        <div class="category_post">
            <div class="box_title clearfix">
                <span class="pull-left"> <?php echo __("Author about", "hwp"); ?> </span>
            </div>
        </div>
        <div class="media">
            <div class="media-left">
                <?php echo get_avatar(  get_the_author_meta( "email" ), 60, "", "", array(
                    "class"         => "pull-left img-responsive",
                    "extra_attr"    => " style = 'margin-right:10px;' "
                ) ); ?>
                <div><?php the_author_link() ?></div>
            </div>
            <div class="media-body">

                <p class="author-bio">
                    <?php echo get_the_author_meta( 'description' ); ?>
                    <a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                        <?php printf( __( 'View all posts by %s', 'hwp' ), get_the_author() ); ?>
                    </a>
                </p><!-- .author-bio -->
            </div>
        </div>
    </div>

    <!-- Start entry-comment-->
    <div class="entry-comments">
        <div class="category_post">
            <div class="box_title clearfix">
                <span class="pull-left"> <?php echo _e("Comments", "hwp"); ?> </span>
            </div>
        </div>
        <h4> <?php comments_number(); ?> </h4>
        <?php comments_template(); ?>
    </div>

    <!-- Start entry-footer-->
    <footer class="entry-footer">
        <div class="category_post">
            <div class="box_title clearfix">
                <span class="pull-left"> <?php echo _e( "Send Respond", "hwp"); ?> </span>
            </div>
        </div>
        <?php
        comment_form(  );
        ?>
    </footer>
    <!-- .entry-footer -->
</article><!-- #post-## -->
