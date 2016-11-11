<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?php if (is_singular() && pings_open(get_queried_object())) : ?>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="index">
    <!--   #header_top  -->
    <div id="header_top" class="visible-sm-block visible-md-block visible-lg-block">
        <div class="navbar navbar-default">
            <div class="clearfix container" id="hwp_header_top">
                <div class="navbar-left">
                    <span class="glyphicon glyphicon-earphone"></span>&nbsp;<?php _e("Call us now", "hwp") ?>: <?php echo hwp_get_options_group( "hwp_general", "phone" );  ?>
                </div>
                <div class="navbar-right">
                    <?php hwp_getNav( "hwp_menu_top","list-inline " ); ?>
                </div>
            </div><!-- end # hwp_header_top-->
        </div>
    </div>

    <!-- Start header middle -->
    <div id="hwp_header_middle" class="visible-lg-block visible-md-block">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">
                    <h3 id="hwp-logo-desktop" title="<?php bloginfo( 'name' ); ?>">
                        <a href="<?php echo home_url(); ?>"> <?php echo get_custom_logo(); ?> </a>
                    </h3>
                </div>
                <div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
                    <div id="hwp_header_middle_ads">
                        <?php $objHeaderAds = json_decode( hwp_get_options_group( "hwp_general", "header_ads" ) ); ?>
                        <a href="<?php echo $objHeaderAds->link ?>" target="_blank"> <img class="img-responsive" src="<?php echo $objHeaderAds->src; ?>" alt=""/> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End header middle -->

    <!-- Navigation  -->
    <nav class="navbar navbar-inverse navbar-sticky navbar-scrollspy navbar-mobile bootsnav on" id="hwp-nav">

        <!--Start Top Search-->
        <div class="top-search hwp-top-search">
            <div class="container">
                <div class="input-group">
                    <!--<span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search">-->

                    <?php  hwp_search_form(); ?>

                    <!--<span class="input-group-addon close-search"><i class="fa fa-times"></i></span>-->
                </div>
            </div>
        </div>
        <!--End Top Search-->

        <div class="container">

            <!-- Start Atribute Navigation -->
            <div class="attr-nav">
                <ul>
                    <li class="search"><a href="#" id="hwp-toggle-search-form"><span class="glyphicon glyphicon-search"></span></a></li>
                </ul>
            </div>
            <!-- End Atribute Navigation -->

            <!-- Start logo mobile mode -->
            <div class="hwp-logo-mobile visible-xs-block">
                <h3 title="<?php bloginfo( 'name' ) ?>">
                    <a href="<?php echo home_url(); ?>" title="<?php bloginfo( 'name' ) ?>"> <?php bloginfo( 'name' ); ?> </a>
                </h3>
            </div>
            <!-- End logo mobile mode -->

            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <button type="button" id="hwp-button-toggle-menu-main" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>&nbsp;<span class="hwp-navbar-toggle-text">Menu</span>
                </button>
            </div>
            <!-- End Header Navigation -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <!--<div class="visible-xs-block" id="hwp_close_navbar">
                    <a href="#"><span class="glyphicon glyphicon-remove"></span>&nbsp;Close</a>
                </div>-->
                <?php hwp_getNav("hwp_menu_main", "nav navbar-nav navbar-default", 'data-in="fadeInDown" data-out="fadeOutUp"'); ?>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>
    <!-- End Navigation -->