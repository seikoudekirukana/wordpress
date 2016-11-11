<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<?php if ( is_active_sidebar( 'hwp_sidebar_index_page' ) ) : ?>
    <div id="hwp-primary-sidebar" class="hwp-primary-sidebar widget-area" role="complementary">
        <!-- Start facebook fan page-->
        <?php hwp_facebook_page(); ?>
        <!-- End facebook fan page -->
        <?php dynamic_sidebar( 'hwp_sidebar_index_page' ); ?>
    </div><!-- #primary-sidebar -->
<?php endif; ?>
