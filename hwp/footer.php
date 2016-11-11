</div><!--End #index-->
<?php wp_footer(); ?>
<div id="hwp_footer">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <?php if ( is_active_sidebar( 'hwp_sidebar_footer' ) ) : ?>
                <div id="hwp-primary-sidebar" class="hwp-footer-sidebar widget-area" role="complementary">
                    <?php dynamic_sidebar( 'hwp_sidebar_footer' ); ?>
                </div><!-- #primary-sidebar -->
            <?php endif; ?>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 hwp_widget">
                <h4 class="widgettitle title hwp_widget_title"><span>About</span></h4>
                <div class="hwp_footer_description"><?php echo hwp_get_options_group( "hwp_general", "site_description" ); ?></div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 hwp_widget">
                <h4 class="widgettitle title hwp_widget_title"><span>Contact</span></h4>
                <p class="hwp_footer_address"> <i class="fa fa-map-marker"></i> <?php echo hwp_get_options_group( "hwp_general", "address" ); ?></p>
                <p class="hwp_footer_email"> <i class="fa fa-envelope-o"></i> <?php echo hwp_get_options_group( "hwp_general", "email" ); ?></p>
                <p class="hwp_footer_phone"> <i class="fa fa-phone"></i> <?php echo hwp_get_options_group( "hwp_general", "phone" ); ?></p>
            </div>
        </div>

        <div class="clearfix footer_bottom">
            <div class="row">
                <div class="col-xs-12 col-sm- col-md-6 col-lg-6"> <p class="text-center">&copy; 2016 <?php echo hwp_get_options_group( "hwp_general", "company_name" ); ?><p> </div>
                <div class="col-xs-12 col-sm- col-md-6 col-lg-6"> <p class="text-center"> Design by <?php echo hwp_get_options_group( "hwp_general", "company_name" ) ?> </p> </div>
            </div>
            <!-- Scroll button-->
            <span id="hwp_scroll_top" href="#">
                <span class="glyphicon glyphicon-hand-up"></span>
            </span>
            <!-- Scroll button-->
        </div>
    </div><!-- End .container-->



</div>
</body>
</html>
