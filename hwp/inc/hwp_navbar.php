<?php
/**
 * Created by PhpStorm.
 * User: nguyenvanlam
 * Date: 10/28/16
 * Time: 6:27 PM
 */
class hwp_navbar extends Walker_Nav_Menu{
    /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }
    /**
     * Start the element output.
     *
     * @see Walker::start_el()
     *
     * @since 3.0.0
     * @since 4.4.0 'nav_menu_item_args' filter was added.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        if( $args->walker->has_children){
            $classes[] = "dropdown";
        }

        /* Start get mega config */
        $mega_config = get_term_meta( $item->ID,'mega_config', true );
        if( strlen( $mega_config ) > 0){
            $classes[] = "dropdown megamenu-fw";
        }
        if( in_array( "current-menu-item", $item->classes ) ){
            $classes[] = "active";
        }

        /**
         * Filter the arguments for a single nav menu item.
         *
         * @since 4.4.0
         *
         * @param array  $args  An array of arguments.
         * @param object $item  Menu item data object.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

        /**
         * Filter the CSS class(es) applied to a menu item's list item element.
         *
         * @since 3.0.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        /**
         * Filter the ID applied to a menu item's list item element.
         *
         * @since 3.0.1
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        if( $args->walker->has_children || isset( $mega_config )){
            $atts['data-toggle']    = 'dropdown';
            $atts['class']          = 'dropdown-toggle';
            $atts['role']           = 'button';
            $atts['href']           = '#';
        }

        /**
         * Filter the HTML attributes applied to a menu item's anchor element.
         *
         * @since 3.6.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         *     @type string $title  Title attribute.
         *     @type string $target Target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param object $item  The current menu item.
         * @param array  $args  An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        /** This filter is documented in wp-includes/post-template.php */
        $title = apply_filters( 'the_title', $item->title, $item->ID );

        /**
         * Filter a menu item's title.
         *
         * @since 4.4.0
         *
         * @param string $title The menu item's title.
         * @param object $item  The current menu item.
         * @param array  $args  An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        if( in_array('menu-item-home', $item->classes) ){
            $item_output.= "<span class=\"glyphicon glyphicon-home\"></span>&nbsp;";
        }

        $item_output .= $args->link_before . $title . $args->link_after;
        if( $args->walker->has_children ){
            //$item_output .= "<span class=\"caret\"></span>";
        }
        $item_output .= '</a>';
        /* Start mega menu */
        if(  strlen( $mega_config ) > 0 ){
            $objMega_config = json_decode( $mega_config );
            $item_output.='<ul class="dropdown-menu megamenu-content" role="menu">
                                <li>
                                    <div class="row" style="overflow-y: auto">';
                    if( is_array($objMega_config->listWidgetClassName) ):
                        $hwp_count = 1;
                        foreach ( $objMega_config->listWidgetClassName as $k => $widgetClassName ):
                            ob_start(); the_widget( $widgetClassName ); $hwp_widget_html = ob_get_clean();
                            $item_output.='<div class="col-menu col-md-'.$objMega_config->megaColumn.' ">';
                            $item_output.= $hwp_widget_html;
                            $item_output.='</div><!-- end col-'.$objMega_config->megaColumn.' -->';
                            if( $hwp_count % ( 12/$objMega_config->megaColumn ) == 0 ):
                                $item_output.='<div class="clearfix"></div>';
                            endif;
                            $hwp_count ++;
                        endforeach;
                    endif;
                    $item_output.='</div><!-- end row -->
                                </li>
                            </ul>';
        }
        /* End mega menu */
        $item_output .= $args->after;

        /**
         * Filter a menu item's starting output.
         *
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of {@see wp_nav_menu()} arguments.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}