<?php
/**
 * Created by PhpStorm.
 * User: nguyenvanlam
 * Date: 8/14/16
 * Time: 8:32 PM
 *
 * Hi all, i have two tab general and social in my setting page of theme wordpress, but only one general tab saved, social tab when to press save button get a error: not found option page.
This is my code, please help me !
 */

add_action('admin_menu','hwp_add_menu_theme_settings');
function hwp_add_menu_theme_settings()
{
    //add a new menu item. This is a top level menu item i.e., this menu item can have sub menus
    add_theme_page(
        "Cài đặt giao diện", //Required. Text in browser title bar when the page associated with this menu item is displayed.
        "Cài đặt giao diện", //Required. Text to be displayed in the menu.
        "manage_options", //Required. The required capability of users to access this menu item.
        "hwp_settings", //Required. A unique identifier to identify this menu item.
        "hwp_settings_page" //Optional. This callback outputs the content of the page associated with this menu item.
    );

}

function hwp_settings_page(){
    ?>
    <div class="wrap">
        <h1>Cấu hình giao diện</h1>
        <?php
        $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general' ;
        ?>
        <h2 class="nav-tab-wrapper">
            <a href="<?php echo admin_url().'themes.php?page=hwp_settings&tab=general' ;?>" class="nav-tab <?php echo $tab == 'general' ? 'nav-tab-active' : ''; ?>">Cài đặt chung</a>
            <a href="<?php echo admin_url().'themes.php?page=hwp_settings&tab=social' ;?>" class="nav-tab <?php echo $tab == 'social' ? 'nav-tab-active' : ''; ?>">Mạng xã hội</a>
        </h2>

        <form action="options.php" method="post">
            <?php if($tab == 'general'): ?>
                <?php settings_fields('hwp_general'); ?>
                <?php do_settings_sections('hwp_general'); ?>
            <?php else: ?>
                <?php settings_fields('hwp_social'); ?>
                <?php do_settings_sections('hwp_social'); ?>
            <?php endif; ?>

            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

add_action( 'admin_init','hwp_display_options' );
function  hwp_display_options(){

    if( false == get_option('hwp_general') ){
        add_option('hwp_general');
    }

    if( false == get_option('hwp_social') ){
        add_option('hwp_social');
    }

    /**
     * Add section general
     */
    add_settings_section('hwp_general','','general_callback','hwp_general');

    //Add fields
    add_settings_field('company_name','Tên công ty','create_company_name_callback','hwp_general','hwp_general');
    add_settings_field('address',' Địa chỉ','create_address_callback','hwp_general','hwp_general');
    add_settings_field('email',' Email','create_email_callback','hwp_general','hwp_general');
    add_settings_field('phone',' Số điện thoại','create_phone_callback','hwp_general','hwp_general');
    add_settings_field('site_description','Mô tả website','create_site_description_callback','hwp_general','hwp_general');
    add_settings_field('header_ads','Header Ads','create_header_ads_callback','hwp_general','hwp_general');
    //Register field
    register_setting('hwp_general','hwp_general', 'hwp_general_sanitize_callback');

    /**
     * Add section socials
     */
    add_settings_section('hwp_social','','social_callback','hwp_social');
    //Add fields
    add_settings_field('facebook_url',' Facebook url','create_facebook_url_callback','hwp_social','hwp_social');
    add_settings_field('twitter_url',' Twitter url','create_twitter_url_callback','hwp_social','hwp_social');
    add_settings_field('google_plus',' Google Plus url','create_google_plus_url_callback','hwp_social','hwp_social');
    add_settings_field('youtube_url',' Youtube url','create_youtube_url_callback','hwp_social','hwp_social');

    //Register field
    register_setting('hwp_social','hwp_social','hwp_social_sanitize_callback');
}

function general_callback(){
    //echo 'General';
}

function social_callback(){
    //echo 'Social';
}

function hwp_general_sanitize_callback($data_general){
    $data_general['header_ads'] = json_encode(array(
        'src'   => $data_general['header_ads'],
        'link'   => $data_general['header_ads_link'],
    ));

    unset( $data_general['header_ads_link'] );
    /*echo '<pre>';
    print_r($data_general);
    echo '</pre>';
    die();*/
    return $data_general;
}

function hwp_social_sanitize_callback($data_social){
    echo '<pre>';
    print_r($data_social);
    echo '</pre>';
    return $data_social;
}


function create_company_name_callback(){
    $general_options = get_option('hwp_general');
    ?>
    <input type="text" name="hwp_general[company_name]" style="width: 50%;"
           value="<?php echo (!empty($general_options['company_name']))?$general_options['company_name']:''; ?>" placeholder="" />
<?php
}
function create_address_callback(){
    $general_options = get_option('hwp_general');
    ?>
    <input type="text" name="hwp_general[address]" style="width: 50%;"
           value="<?php echo (!empty($general_options['address']))? $general_options['address'] : ''; ?>" placeholder="" />
<?php
}
function create_email_callback(){
    $general_options = get_option('hwp_general');
    ?>
    <input type="text" name="hwp_general[email]" style="width: 50%;"
           value="<?php echo (!empty($general_options['email']))? $general_options['email'] : ''; ?>" placeholder="" />
<?php
}
function create_phone_callback(){
    $general_options = get_option('hwp_general');
    ?>
    <input type="text" name="hwp_general[phone]" style="width: 50%;"
           value="<?php echo (!empty($general_options['phone']))? $general_options['phone'] : ''; ?>" placeholder="Phone" />
<?php
}

function create_header_ads_callback(){
    $general_options = get_option('hwp_general');
    $obj = json_decode( $general_options['header_ads'] );
    ?>
    <div>
        <button type="button" id="header_ads_button" class="button header_ads_button"><span class="wp-media-buttons-icon"></span> Add Image</button>
        <input type="text" readonly="readonly" id="header_ads" name="hwp_general[header_ads]" style="width: 50%;"
           value="<?php echo (!empty($obj->src))? $obj->src : ''; ?>" placeholder="Header Ads" />
    <div>
        <span  style="min-width: 87px; font-weight: bold; display: inline-block;"><label for="header_ads_link">Link:&nbsp;</label></span>
        <input type="text" id="header_ads_link" name="hwp_general[header_ads_link]" value="<?php echo (!empty($obj->src))? $obj->src : ''; ?>" style="width: 50%;"/>
    </div>
    </div>
    <div style="border: 1px solid #ffffff; margin-top: 5px;">
        <img id="img_header_ads" src="<?php echo (!empty($obj->src))? $obj->src : ''; ?>" width="720" height="100" alt=""/>
    </div>

<?php
}


function create_site_description_callback(){
    $general_options = get_option('hwp_general');
    ?>
    <?php
        // Add TinyMCE visual editor
        wp_editor( (!empty($general_options['site_description']))? $general_options['site_description'] : '', "site_description",array(
            'wpautop'             => true,
            'media_buttons'       => true,
            'default_editor'      => '',
            'drag_drop_upload'    => false,
            'textarea_name'       => "hwp_general[site_description]",
            'textarea_rows'       => 10,
            'tabindex'            => '',
            'tabfocus_elements'   => ':prev,:next',
            'editor_css'          => '',
            'editor_class'        => '',
            'teeny'               => false,
            'dfw'                 => false,
            '_content_editor_dfw' => false,
            'tinymce'             => true,
            'quicktags'           => true
        ) );
    ?>
<?php
}

function create_facebook_url_callback(){
    $social_options = get_option('hwp_social');
    ?>
    <input type="text" name="hwp_social[facebook_url]" style="width: 50%;"
           value="<?php echo (!empty($social_options['facebook_url']))?$social_options['facebook_url']:''; ?>" placeholder="facebook url" />
<?php
}

function create_twitter_url_callback(){
    $social_options = get_option('hwp_social');
    ?>
    <input type="text" name="hwp_social[twitter_url]" style="width: 50%;"
           value="<?php echo (!empty($social_options['twitter_url']))?$social_options['twitter_url']:''; ?>" placeholder="Twitter url" />
<?php
}

function create_google_plus_url_callback(){
    $social_options = get_option('hwp_social');
    ?>
    <input type="text" name="hwp_social[google_plus_url]" style="width: 50%;"
           value="<?php echo (!empty($social_options['google_plus_url']))?$social_options['google_plus_url']:''; ?>" placeholder="Google plus url" />
<?php
}

function create_youtube_url_callback(){
    $social_options = get_option('hwp_social');
    ?>
    <input type="text" name="hwp_social[youtube_url]" style="width: 50%;"
           value="<?php echo (!empty($social_options['youtube_url']))?$social_options['youtube_url']:''; ?>" placeholder="Youtube url" />
<?php
}