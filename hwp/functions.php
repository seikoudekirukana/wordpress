<?php
define('hwp', get_template_directory_uri() . '/');
define('hwp_relative', get_template_directory() . '/');
require_once get_template_directory(). "/inc/hwp_navbar.php" ;
require_once get_template_directory(). "/inc/widgets.php" ;
require_once get_template_directory(). "/settings/settings.php" ;

function hwp_vardump( $var ){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}
if (!function_exists('hwp_setup')) {
	function hwp_setup()
	{
		add_theme_support('content-width', 600);
		/**
		 * Add logo custom to theme
		 */
		add_theme_support('custom-logo', array(
			'height' => 100,
			'width' => 240,
			'flex-width' => true,
		));
		/**
		 * This feature enables Custom_Backgrounds support for a theme.
		 * Note that you can add default arguments using:
		 */
		$defaults = array(
			'default-color' => '',
			'default-image' => '',
			'wp-head-callback' => '_custom_background_cb',
			'admin-head-callback' => '',
			'admin-preview-callback' => ''
		);
		add_theme_support('custom-background', $defaults);

		/**
		 * This feature enables Automatic Feed Links for post and comment in the head.
		 * This should be used in place of the deprecated automatic_feed_links() function.
		 */
		add_theme_support('automatic-feed-links');

		/**
		 * This feature allows the use of HTML5 markup for the search forms, comment forms, comment lists, gallery, and caption.
		 */
		add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));


		/**
		 * Them chung nang thumbnail cho post khi soan thao
		 */
		add_theme_support('post-thumbnails');
		set_post_thumbnail_size(604, 270, true);
		
		/**
		 * Add title-tag support
		 */
		add_theme_support('title-tag');

		/**
		 * Support Post Format
		 */
		add_theme_support('post-format', array(
			'image',
			'video',
			'gallery',
			'link',
			'quote'
		));

		// This theme uses wp_nav_menu() in one location.
		register_nav_menu('hwp_menu_top', __('HWP Menu Top', 'hwp'));
		register_nav_menu('hwp_menu_main', __('HWP Menu Main', 'hwp'));


        /**
         * Register sidebar index content
         */
        register_sidebar(array(
            'name' => sprintf(__('Sidebar Index Content')),
            'id' => "hwp_sidebar_index_content",
            'description' => 'Sidebar Index Content',
            'class' => 'hwp_sidebar_index_content',
            'before_widget' => '<div id="%1$s" class="widget %1$s">',
            'after_widget' => "</div>\n",
            'before_title' => '',
            'after_title' => "",
        ));

		/**
		 * Register sidebar
		 */
		register_sidebar(array(
			'name' => sprintf(__('Sidebar Main at Right Page')),
			'id' => "hwp_sidebar_index_page",
			'description' => 'Sidebar Main at Right Page',
			'class' => 'hwp_sidebar_index_page',
			'before_widget' => '<div id="%1$s" class="widget card hwp_widget %1$s">',
			'after_widget' => "</div>\n",
			'before_title' => '<h4 class="title hwp_widget_title"><span>',
			'after_title' => "</span></h4>\n",
		));
		
		/**
		 * Register sidebar right
		 */
		register_sidebar(array(
			'name' => sprintf(__('Sidebar at Footer')),
			'id' => "hwp_sidebar_footer",
			'description' => 'Sidebar at Footer',
			'class' => 'hwp_sidebar_index_page clearfix',
			'before_widget' => '<div id="%1$s" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 widget card hwp_widget %1$s">',
			'after_widget' => "</div>\n",
			'before_title' => '<h4 class="widgettitle title hwp_widget_title"><span>',
			'after_title' => "</span></h4>\n",
		));

        load_theme_textdomain( 'hwp', get_template_directory() . '/languages' );

	}
} //End hwp_setup
add_action('init', 'hwp_setup');

/*
 * get options
 * */
function hwp_get_options_group( $options_name, $options_value ){
    $options_group = (object)get_option( $options_name );
    return $options_group->{$options_value};
}

function hwp_getNav($location, $classes, $attrs = null)
{
    $args_with_walker = array(
        'items_wrap'        => '<ul '.$attrs.' id="%1$s" class="%2$s ' . $classes . '">%3$s</ul>',
        'walker'            => new hwp_navbar(),
        'theme_location'    => $location,
        'container' => ''
    );

    $args_without_walker = array(
        'items_wrap'        => '<ul id="%1$s" class="%2$s ' . $classes . '">%3$s</ul>',
        'theme_location'    => $location,
        'container' => ''
    );
    if( $location == "hwp_menu_main" ){
        wp_nav_menu($args_with_walker);
    }else{
        wp_nav_menu( $args_without_walker );
    }
}

if( !function_exists( 'hwp_scripts' ) ):

	function hwp_scripts(){
        /* Style */
		wp_enqueue_style( 'font-awesome', hwp . 'css/font-awesome.css' );
        wp_enqueue_style( 'bootstrap', hwp . 'css/bootstrap.css' );
        wp_enqueue_style( 'animate', hwp . 'css/menu/animate.css' );
		wp_enqueue_style( 'bootsnav', hwp . 'css/menu/bootsnav.css' );
		wp_enqueue_style( 'style_bootsnav', hwp . 'css/menu/style.css' );
		wp_enqueue_style( 'responsive', hwp . 'css/responsive.css' );
		wp_enqueue_style( 'style', get_stylesheet_uri() );

        /* Scripts */
        wp_enqueue_script('jquery');
        wp_enqueue_script( 'bootstrap', hwp . 'js/bootstrap.js', array(), '1.0.0', true );
        wp_enqueue_script( 'bootsnav', hwp . 'js/bootsnav.js', array(), '1.0.0', true );
		wp_enqueue_script( 'main', hwp . 'js/main.js', array(), '1.0.0', true );

        /* Comment */
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

         /* Slider */
        if( is_home() ){
            wp_enqueue_style( 'cslider', hwp . 'css/style.css' );
            wp_enqueue_script( 'cslider-js', hwp . 'js/cslider/jquery.cslider.js', array(), '1.0.0', true );
            wp_enqueue_script( 'modernizr.custom.28468', hwp . 'js/cslider/modernizr.custom.28468.js', array(), '1.0.0', true );
        }

        /* tao bien script toan cuc trong website */
        $hwp_vars_global = array(
            'home_url'          => home_url(),
            'ajax_url'          => admin_url() . 'admin-ajax.php',
            'save_txt'      => _e( 'Save', 'hwp' ),
            'saving_txt'      => _e( 'Saving...', 'hwp' ),
            'delete_txt'      => _e( 'Delete', 'hwp' ),
            'deleting_txt'      => _e( 'Deleting...', 'hwp' )
            
        );
        wp_localize_script(
            "main",// ten handle file chu k phai ten file scripts ma muon goi 2 bien tren ra dung
            "hwp",// ten doi tuong dai dien khi goi 2 bien ra dung
            $hwp_vars_global
        );
	}

	add_action( 'wp_enqueue_scripts', 'hwp_scripts' );

    function hwp_admin_scripts(){
        wp_enqueue_style( 'hwp-admin', hwp . 'css/hwp-admin-menu-custom.css' );
        wp_enqueue_style( 'admin-colorbox', hwp . 'css/admin-colorbox.css' );
        wp_enqueue_script( 'hwp-colorbox-js', hwp . 'js/admin/colorbox1.4.25.js', array(), '1.0.0', true );
        wp_enqueue_script( 'hwp-settings', hwp . 'js/admin/settings.js', array(), '1.0.0', false );

        $hwp_vars_global = array(
            'home_url'          => home_url(),
            'ajax_url'          => admin_url() . 'admin-ajax.php',
            'save_txt'      => __('Save', 'hwp'),
            'saving_txt'      => __('Saving...', 'hwp'),
            'delete_txt'      => __('Delete', 'hwp'),
            'deleting_txt'      => __( 'Deleting...', 'hwp' ),
            'success_txt'      => __( 'Success', 'hwp' ),
            'failed_txt'      => __( 'Failed', 'hwp' )
        );
        wp_localize_script(
            "hwp-settings",// file scripts ma muon goi 2 bien tren ra dung
            "hwp",// ten doi tuong dai dien khi goi 2 bien ra dung
            $hwp_vars_global
        );
    }
    add_action( 'admin_enqueue_scripts', 'hwp_admin_scripts' );

endif;
/**
 * Count viewer
 */
function hwp_SetPostViewedCount($postID) {
    $count_key = 'hwp_view_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function hwp_GetPostViewedCount($postID)
{
    $count_key = 'hwp_view_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return 0;
    }
    return $count;
}
/**
 * Tranh 1 luot truy cap ma cong toi 2 lan
 */
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function hwp_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
    <div <?php comment_class(array("media")); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>" class="hwp_comment_item">
            <div class="media-left">
                <?php echo get_avatar( $comment, 48 ); ?>
            </div>
            <div class="media-body">
                <div class="comment-media-heading media-heading clearfix">
                    <div class="pull-left"><strong><?php echo get_comment_author_link(); ?></strong></div>
                    <div class="pull-left" style="margin-left: 5px;font-size: 11px"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></div>
                </div>
                <div class="comment_content">
                    <?php comment_text() ?>
                </div>
                <div class="reply reply_button">
                    <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                    <?php edit_comment_link(__('( Edit )'),'  ','') ?>
                </div>
            </div>
        </div>
    </div>

<?php
}
/**
 * Custom Submit button comment
 */
function filter_comment_form_submit_button( $submit_button, $args ) {
    $submit_button = '<button data-position="right" data-delay="50" data-tooltip="Gửi phản hổi" name="'.$args['name_submit'].'" type="submit" id="'.$args['id_submit'].'"
    class="submit"> '.__( 'Post Comment' ).' <span class="glyphicon glyphicon-comment"></span></button>';
    return  $submit_button;
};
// add the filter
add_filter( 'comment_form_submit_button', 'filter_comment_form_submit_button', 10, 2 );

function hwp_pagination() {
    global $wp_query, $wp_rewrite;

    // Don't print empty markup if there's only one page.
    if ( $wp_query->max_num_pages < 2 ) {
        return;
    }

    $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
    $pagenum_link = html_entity_decode( get_pagenum_link() );
    $query_args   = array();
    $url_parts    = explode( '?', $pagenum_link );

    if ( isset( $url_parts[1] ) ) {
        wp_parse_str( $url_parts[1], $query_args );
    }

    $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
    $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

    $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
    $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

    // Set up paginated links.
    $links = paginate_links( array(
        'base'     => $pagenum_link,
        'format'   => $format,
        'total'    => $wp_query->max_num_pages,
        'current'  => $paged,
        'mid_size' => 1,
        'add_args' => array_map( 'urlencode', $query_args ),
        'prev_text' => '<span class="glyphicon glyphicon-chevron-left"></span>',
        'next_text' => '<span class="glyphicon glyphicon-chevron-right"></span>',
    ) );

    if ( $links ) :

        ?>
        <nav class="navigation paging-navigation" role="navigation">
            <div class="pagination loop-pagination">
                <?php echo $links; ?>
            </div><!-- .pagination -->
        </nav><!-- .navigation -->
    <?php
    endif;
}
/**
 * Filter the except length to 20 characters.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function wpdocs_custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );
/**
 * Pre get post add custom post type
 */
add_action('pre_get_posts', 'hwp_post_types_to_query');
function hwp_post_types_to_query($query)
{
    if ( !is_admin() && $query->is_main_query() ) {
        if ($query->is_search) {
            if( $_GET['cat'] == 0 ){
                wp_redirect( home_url() );
            }
            $query->set('post_type', 'post');
            $query->set('cat', $_GET['cat']);
        }
    }
    return $query;
}

function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', hwp . 'css/style-login.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

function hwp_facebook_page(){
    ?>
    <div class="hwp_box_facebook pd-b20 widget card hwp_widget">
        <h4 class="title hwp_widget_title"><span><?php _e("Find us", "hwp"); ?></span></h4>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=461689310704290";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <div class="fb-page" data-href="https://www.facebook.com/lamvnjp.net/" data-tabs="" data-small-header="false"
             data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
            <blockquote cite="https://www.facebook.com/lamvnjp.net/" class="fb-xfbml-parse-ignore">
                <a href="https://www.facebook.com/lamvnjp.net/">lamvnjp.net</a>
            </blockquote>
        </div>
    </div>
    <div class="clearfix"></div>
<?php
}

/* hwp search form */
function hwp_search_form(){?>
    <form action="<?php echo home_url(); ?>" method="get" id="hwp_search_form">
        <div class="input-group">
            <div class="input-group-addon" id="col1">
                <?php wp_dropdown_categories( array(
                    "id"                => "hwp_categories_search",
                    "class"             => "search_select",
                    "show_option_all"   => "All Categories",
                    'option_none_value' => "All",
                    "name"              =>"cat",
                    "value_field"       => get_query_var( "cat", "" ),
                )) ?>
            </div>
            <input type="search" class="form-control" id="col2" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder' ) ; ?>" value="<?php echo get_search_query(); ?>" name="s" />
                                <span class="input-group-addon" id="col3">
                                    <button type="submit" class="search-submit"><span class="glyphicon glyphicon-search"></span></button>
                                </span>
        </div>
    </form><!-- end #hwp_search_form-->
<?php
}
function hwp_get_sidebar( $sidebar_name ){
    ?>
    <?php if ( is_active_sidebar( $sidebar_name ) ) : ?>
        <div id="<?php echo $sidebar_name; ?>" class="<?php echo $sidebar_name; ?> widget-area" role="complementary">
            <!-- End facebook fan page -->
            <?php dynamic_sidebar( $sidebar_name ); ?>
        </div><!-- #primary-sidebar -->
    <?php endif; ?>
    <?php
}

/*
 * Ajax
 * */
function hwp_ajax_callback(){
    if( is_user_logged_in() ):
    ?>
    <div class="hwp-box-menu-config">
        <div id="hwp_notices"></div>
        <?php
        //$sidebars_widgets = get_option( 'sidebars_widgets' );
        $menuID = $_POST['menu_id'];
        if ( empty ( $GLOBALS['wp_widget_factory'] ) )
            return;
        ?>
        <form id="hwp-mega-menu-config-form">
            <?php $mega_config = get_term_meta( $menuID,'mega_config', true ); $objMega_config = json_decode( $mega_config );  ?>
            <!-- Start list all widgets -->
            <h3 class="hwp-title-box" tabindex="0"><?php _e( 'Select a widget' ,'hwp' ); ?></h3>
            <div class="row">
                <?php foreach( $GLOBALS['wp_widget_factory']->widgets as $widgetClassName => $widget ):  ?>
                    <div class="col-4">
                        <label for="<?php echo $widgetClassName; ?>">
                            <input id="<?php echo $widgetClassName; ?>" type="checkbox"
                                <?php echo ( in_array( $widgetClassName, $objMega_config->listWidgetClassName ) ) ? 'checked' : ''; ?>
                                   class="checkbox hwpWidget-className"
                                   value="<?php echo $widgetClassName; ?>" /> <?php _e( $widget->name,'hwp' ); ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- End list all widgets -->

            <!-- Start list columns -->
            <h3 class="hwp-title-box" tabindex="0"><?php _e( 'Select column number' ,'hwp' ); ?></h3>
            <div class="row">
                <?php for( $i = 2; $i <= 6; $i ++ ):  ?>
                    <div class="col-2">
                        <label for="<?php echo $i.'column'; ?>">
                            <input id="<?php echo $i.'column'; ?>" type="radio"
                                   name="<?php echo 'radio'; ?>"
                                   class="checkbox hwpMega-colNumber" <?php echo ( $objMega_config->megaColumn == $i ) ? 'checked': ''; ?>
                                   value="<?php echo $i; ?>" /> <?php echo $i.'&nbsp;'.__( 'Column','hwp' ); ?>
                        </label>
                    </div>
                <?php endfor; ?>
            </div><br>
            <!-- End list columns -->

            <!-- Save button-->
            <div class="row">
                <button id="hwp-save-mega-menu" type="button" class="button button-primary"><?php _e( 'Save', 'hwp' ); ?></button>
                <?php if( !is_null($objMega_config->listWidgetClassName) ): ?>
                <button id="hwp-delete-mega-menu" data-menu-id="<?php echo $menuID; ?>" type="button" class="button"><?php _e( 'Delete', 'hwp' ); ?></button>
                <?php endif; ?>
            </div>
        </form>
    </div>
<?php endif; die();
}
add_action( 'wp_ajax_hwp_ajax', 'hwp_ajax_callback' );

function hwp_ajax_add_mega_menu_callback(){

    $menuID = $_POST['menu_id'];
    $listWidgetClassName  =  $_POST['listWidgetClassName'];
    $megaColumn           = $_POST['megaColumn'];
    

    /*$meta_value = array( 'listWidgetClassName' => $listWidgetClassName, 'megaColumn' => $megaColumn );
    $status = update_term_meta( $menuID, 'mega_config', json_encode( $meta_value ) );
    die($status);*/
}
add_action( 'wp_ajax_hwp_ajax_add_mega_menu', 'hwp_ajax_add_mega_menu_callback' );

/*
 * Delete Mega menu by menu-item-id
 * */
function hwp_delete_mega_menu_by_item_id_callback(){
    $menu_id = $_POST[ 'menu_id' ];
    $status = update_term_meta($menu_id, 'mega_config');
    die($status);
}

add_action( 'wp_ajax_hwp_delete_mega_menu_by_item_id', 'hwp_delete_mega_menu_by_item_id_callback' );
