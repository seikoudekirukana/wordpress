<?php
/**
 * Created by PhpStorm.
 * User: nguyenvanlam
 * Date: 11/8/16
 * Time: 7:37 PM
 */

?>
<div class="hwp-box-menu-config">
    <?php
    if( is_user_logged_in() ){
        $menuID = $_POST['menu_id'];
        if(update_term_meta ($menuID, 'mega-menu', 1, true)){
            _e('Success', 'hwp');
        }else{
            _e( 'Failed', 'hwp' );
        }
        update_term_meta ($menuID, 'mega-menu', 1);
    }
    $sidebars_widgets = get_option( 'sidebars_widgets' );
    if ( empty ( $GLOBALS['wp_widget_factory'] ) )
        return;
    $widgets = array_keys( $GLOBALS['wp_widget_factory']->widgets );
    //hwp_vardump($GLOBALS['wp_widget_factory']);
    ?>

    <select name="hwp-menu-widgets" id="hwp-menu-widgets">
        <option value="0">Chon Widgets</option>

        <?php foreach( $GLOBALS['wp_widget_factory']->widgets as $widgetClassName => $widget ):  ?>
            <?php $oldWidgetClassName = get_term_meta($menuID, 'widgetClassName'); ?>
            <option <?php echo ( $oldWidgetClassName == $widgetClassName ) ? 'selected': ''; ?> value="<?php echo $widgetClassName; ?>"> <?php echo $widget->name; ?> </option>
        <?php endforeach; ?>
    </select>

</div>
