/**
 * Created by nguyenvanlam on 10/28/16.
 */
jQuery(document).ready(function ($) {

    /*
    *   hwp.home_url
    *   hwp.ajax_url
    * */

    // scroll body to 0px on click
    $('#hwp_scroll_top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    //select category search
    $( "#hwp_categories_search").change(function(){
        if( $(this).val() === "0" ){
           window.location.href = hwp.home_url;
        }
        if( $( "#catID").length ){
            $( "#catID").remove();
        }
        if( $(this).val() !== "0" ){
            $(this).after( "<input type='hidden' nam = 'cat' value='"+$(this).val()+"' />" );
        }
    });

    /* toggle menu navbar */
    $( "#hwp-toggle-search-form span").click(function(){
        var thisClass = $(this).attr( "class" );
        if( thisClass === "glyphicon glyphicon-search" ){
            $("#hwp-toggle-search-form span").removeClass( "glyphicon glyphicon-search").addClass( "glyphicon glyphicon-remove" );
        }
        else if( thisClass === "glyphicon glyphicon-remove" ){
            $("#hwp-toggle-search-form span").removeClass( "glyphicon glyphicon-remove").addClass( "glyphicon glyphicon-search" );
        }

    });

    $("#hwp_close_navbar").click(function () {
        $("#hwp-button-toggle-menu-main").trigger( "click" );
    });

    /* Star material-cards */
    $('.material-card > .mc-btn-action').click(function () {
        var card = $(this).parent('.material-card');
        var icon = $(this).children('i');
        icon.addClass('fa-spin-fast');

        if (card.hasClass('mc-active')) {
            card.removeClass('mc-active');

            window.setTimeout(function() {
                icon
                    .removeClass('fa-arrow-left')
                    .removeClass('fa-spin-fast')
                    .addClass('fa-bars');

            }, 800);
        } else {
            card.addClass('mc-active');

            window.setTimeout(function() {
                icon
                    .removeClass('fa-bars')
                    .removeClass('fa-spin-fast')
                    .addClass('fa-arrow-left');

            }, 800);
        }
    });
    /* End material-cards */

    /* Start Cslider */
    $('#da-slider').cslider({

        current		: 0,
        // index of current slide

        bgincrement	: 100,
        // increment the background position
        // (parallax effect) when sliding

        autoplay	: true,
        // slideshow on / off

        interval	: 4000
        // time between transitions

    });
    /* End Cslider */

});
