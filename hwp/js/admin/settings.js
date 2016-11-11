/**
 * Created by nguyenvanlam on 11/5/16.
 */
jQuery(document).ready(function($){
    var frame = null;

    function open_media_uploader_multiple_images(){
        // Uploading files
        var file_frame;

        event.preventDefault();

        // If the media frame already exists, reopen it.
        if ( file_frame ) {
            file_frame.open();
            return;
        }

        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title       : "Chọn ảnh",
            button: {
                text    : "Chèn ảnh đã chọn"
            },
            multiple    : false  // Set to true to allow multiple files to be selected
        });

        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            images = file_frame.state().get('selection').first().toJSON();
            // Do something with attachment.id and/or attachment.url here
            $("#header_ads").val( images.url );
            $("#img_header_ads").attr( "src", images.url );
        });

        // Finally, open the modal
        file_frame.open();
    }

    jQuery('#header_ads_button').click(function () {
        open_media_uploader_multiple_images();
    });

    
    /* Start create mega-menu button edit */
    $( "ul#menu-to-edit li.menu-item").each(function(e){
        var currentID = $(this).attr('id') ;
        var thisID = '#' + currentID;

        var html = ' <span class="hwp-dashicon-wrap">hwp-mega</span> ';
        if( $(this).hasClass( 'menu-item-depth-0' ) ){
            $(thisID + " .menu-item-bar .menu-item-handle .item-title .is-submenu").after( html );
        }
    });
    /* End create mega-menu button edit */

    /* Start even mega-menu button click */
    $( '.hwp-dashicon-wrap').click(function(){

        /* Start get id menu item */
        var menuIdHtml = $(this).parent().parent().parent().parent().attr('id');
        //console.log( menuIdHtml );
        var arrContentID = menuIdHtml.split( '-');
        var menuCurrentID = arrContentID[2];
        /* End Get id menu item */

        var data = {
            'action'    :'hwp_ajax',
            'menu_id' : menuCurrentID
        };

        /* Start post ajax */
        $.post( ajaxurl, data, function(response){
            $.colorbox({
                html:response,
                width: '70%',
                height: '90%',
                close: '<span class = "dashicons dashicons-no"></span>'
            });

            var success_status = '<div class="notice notice-success">'+hwp.success_txt+'</div>';
            var warning_status = '<div class="notice notice-warning">'+hwp.failed_txt+'</div>';

            /* Start button Save mega menu */
            $('#hwp-save-mega-menu').click(function(e){
                e.preventDefault();
                var hwpArr = '';
                var colNumber = 3;
                $( '.hwpWidget-className' ).each(function () {
                    if( $(this).is(':checked') ){
                        hwpArr += $(this).val();
                    }
                });
                $( '.hwpMega-colNumber' ).each(function () {
                    if( $(this).is(':checked') ){
                        colNumber = $(this).val();
                    }
                });
                /* Start post ajax to save mega for menu item */
                $.post( ajaxurl,{
                    'action'              : 'hwp_ajax_add_mega_menu',
                    'menu_id'             : menuCurrentID,
                    'listWidgetClassName' : hwpArr ,
                    'megaColumn'          : colNumber
                }, function (data) {
                    if( data === '0' ){
                        $( '#hwp_notices' ).html( warning_status );
                    }else{
                        $( '#hwp_notices' ).html( success_status );
                    }
                    setInterval( function () {
                        $( '#hwp_notices' ).html('');
                    } ,3000);

                });
                /* End post ajax to save mega for menu item */
                
                return false;
            });/* End button Save mega menu */

            /* Start Delete Mega Menu for item with ID */
            $( '#hwp-delete-mega-menu' ).click( function (e) {
                $(this).text( hwp.deleting_txt );
                e.preventDefault();
                var menuID = $( this ).attr( 'data-menu-id' );

                $.post( ajaxurl,{
                    'action' : 'hwp_delete_mega_menu_by_item_id',
                    'menu_id': menuID
                },function (data) {
                    if( data === '0' ){
                        $( '#hwp_notices' ).html( warning_status );
                    }else{
                        $( '#hwp_notices' ).html( success_status );
                    }
                    setInterval( function () {
                        $( '#hwp_notices' ).html('');
                        $('#cboxClose').trigger( 'click' );
                    } ,3000);

                } );

            } );
            /* End Delete Mega Menu for item with ID */

        } );/*End post Ajax */
    });
    /* End even mega-menu button click */

});
