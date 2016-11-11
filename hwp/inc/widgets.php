<?php
/**
 * Created by PhpStorm.
 * User: nguyenvanlam
 * Date: 10/29/16
 * Time: 6:27 PM
 */
/**
 * Adds Foo_Widget widget.
 */
class TabsPost_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'hwp_tabs_post', // Base ID
            esc_html__( 'HWP Tabs Posts', 'hwp' ), // Name
            array( 'description' => esc_html__( 'A Tabs Post Widget', 'hwp' ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        ?>
        <!-- Block tabs -->
        <div>
            <!-- Nav tabs -->
            <ul class="hwp_tabs nav nav-tabs" role="tablist">
                <?php for( $i = 1; $i <=3; $i++): ?>
                    <li role="presentation" class="<?php echo ($i == 1)? 'active':'' ?>"><a href="#<?php echo $instance["content_tab{$i}"]; ?>" aria-controls="<?php echo $instance["content_tab{$i}"]; ?>" role="tab" data-toggle="tab"><?php echo $instance["title_tab{$i}"] ?> </a></li>
                <?php endfor; ?>
            </ul>

            <!-- Tab panes -->
            <?php
            $query_new_most = new WP_Query(array(
                "post_type" => "post",
                "orderby"   => "date",
                "order"     => "DESC",
                "posts_per_page" => $instance["number_post"]
            ));
            $query_view_most = new WP_Query(array(
                "post_type" => "post",
                "orderby"   => "meta_value_num",
                "meta_key"  => "hwp_view_count",
                "order"     => "DESC",
                "posts_per_page" => $instance["number_post"]
            ));
            $query_comment_most = new WP_Query(array(
                "post_type" => "post",
                "orderby"   => "comment_count",
                "order"     => "DESC",
                "posts_per_page" => $instance["number_post"]
            ));
            ?>
            <div class="hwp_tab_content tab-content">
                <?php for( $i = 1; $i <=3; $i++): ?>
                    <div role="tabpanel" class="tab-pane fade <?php echo ($i == 1)? 'in active':'' ?>" id="<?php echo $instance["content_tab{$i}"]; ?>">
                        <?php
                        $main_query = array();
                        if( $instance["content_tab{$i}"] == "new_most" ){
                            $main_query = $query_new_most->posts;
                        }elseif( $instance["content_tab{$i}"] == "view_most" ){
                            $main_query = $query_view_most->posts;
                        }else{
                            $main_query = $query_comment_most->posts;
                        }
                        ?>
                        <div class="category_post">
                            <div class="list-item">
                                <?php foreach( $main_query as $k=> $post ): ?>
                                    <div class="item">
                                        <div class="img pull-left">
                                            <a href="<?php echo get_the_permalink($post->ID) ?>"
                                               title="<?php echo get_the_title($post->ID); ?>">
                                                <img class="img-responsive" src="<?php echo get_the_post_thumbnail_url($post->ID)?>"
                                                     title="<?php echo get_the_title($post->ID) ?>" alt="<?php echo get_the_title($post->ID) ?>"/>
                                            </a>
                                        </div>
                                        <h5 title="<?php echo get_the_title($post->ID) ?>">
                                            <a href="<?php echo get_the_permalink($post->ID) ?>" title="<?php echo get_the_title($post->ID) ?>">
                                                <?php echo get_the_title($post->ID) ?><span class="title_newest"><span class="glyphicon glyphicon-flash"></span>new</span>
                                            </a>
                                        </h5>
                                        <div class="small_after_title">
                                            <span class="date_post"><span class="glyphicon glyphicon-calendar"></span> <?php echo get_the_date("d-m-Y", $post->ID) ?></span>&nbsp;
                                            <?php if( $instance["content_tab{$i}"] == "comment_most" ){ ?>
                                                <span class="date_post"><span class="glyphicon glyphicon-comment"></span> <?php echo get_comments_number($post->ID); ?></span>
                                            <?php }elseif( $instance["content_tab{$i}"] == "view_most" ){; ?>
                                                <div class="date_post"><span class="glyphicon glyphicon-eye-open"></span> <?php echo hwp_GetPostViewedCount($post->ID) ?></div>
                                            <?php }; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

        </div>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $number_post = ! empty( $instance['number_post'] ) ? $instance['number_post'] : esc_html__( '5', 'hwp' );
        $title_tab1 = ! empty( $instance['title_tab1'] ) ? $instance['title_tab1'] : esc_html__( 'Title Tab 1', 'hwp' );
        $title_tab2 = ! empty( $instance['title_tab2'] ) ? $instance['title_tab2'] : esc_html__( 'Title Tab 2', 'hwp' );
        $title_tab3 = ! empty( $instance['title_tab3'] ) ? $instance['title_tab3'] : esc_html__( 'Title Tab 3', 'hwp' );
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number_post' ) ); ?>"><strong><?php esc_attr_e( 'Number Posts:', 'hwp' ); ?></strong></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number_post' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_post' ) ); ?>" type="text" value="<?php echo esc_attr( $number_post ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title_tab1' ) ); ?>"><?php esc_attr_e( 'Title Tab 1:', 'hwp' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_tab1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_tab1' ) ); ?>" type="text" value="<?php echo esc_attr( $title_tab1 ); ?>">
        </p>

        <!-- select tags -->
        <?php
        $options = array(
            "new_most"        => "New Most",
            "view_most"     => "View Most",
            "comment_most"  => "Comment Most"
        );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'content_tab1' ) ); ?>">
                <strong>
                    <?php esc_attr_e( 'Content Tab1:', 'text_domain' ); ?>
                </strong>
            </label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'content_tab1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_tab1' ) ); ?>">
                <?php foreach( $options as $k=>$v ): ?>
                    <option <?php echo ($k == $instance["content_tab1"]) ? "selected = true":"" ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title_tab2' ) ); ?>"><strong><?php esc_attr_e( 'Title Tab 2:', 'hwp' ); ?></strong></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_tab2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_tab2' ) ); ?>" type="text" value="<?php echo esc_attr( $title_tab2 ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'content_tab2' ) ); ?>">
                <strong><?php esc_attr_e( 'Content Tab 2:', 'text_domain' ); ?></strong>
            </label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'content_tab2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_tab2' ) ); ?>">
                <?php foreach( $options as $k=>$v ): ?>
                    <option <?php echo ($k == $instance["content_tab2"]) ? "selected = true":"" ?>  value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title_tab3' ) ); ?>">
                <strong><?php esc_attr_e( 'Title Tab 3:', 'hwp' ); ?></strong>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_tab3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_tab3' ) ); ?>" type="text" value="<?php echo esc_attr( $title_tab3 ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'content_tab3' ) ); ?>">
                <strong><?php esc_attr_e( 'Content Tab 3:', 'text_domain' ); ?></strong>
            </label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'content_tab3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_tab3' ) ); ?>">
                <?php foreach( $options as $k=>$v ): ?>
                    <option <?php echo ($k == $instance["content_tab3"]) ? "selected = true":"" ?>  value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php endforeach; ?>
            </select>
        </p>

    <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['number_post'] = ( ! empty( $new_instance['number_post'] ) ) ? strip_tags( $new_instance['number_post'] ) : '';
        $instance['title_tab1'] = ( ! empty( $new_instance['title_tab1'] ) ) ? strip_tags( $new_instance['title_tab1'] ) : '';
        $instance['title_tab2'] = ( ! empty( $new_instance['title_tab2'] ) ) ? strip_tags( $new_instance['title_tab2'] ) : '';
        $instance['title_tab3'] = ( ! empty( $new_instance['title_tab3'] ) ) ? strip_tags( $new_instance['title_tab3'] ) : '';

        $instance['content_tab1'] = ( ! empty( $new_instance['content_tab1'] ) ) ? strip_tags( $new_instance['content_tab1'] ) : '';
        $instance['content_tab2'] = ( ! empty( $new_instance['content_tab2'] ) ) ? strip_tags( $new_instance['content_tab2'] ) : '';
        $instance['content_tab3'] = ( ! empty( $new_instance['content_tab3'] ) ) ? strip_tags( $new_instance['content_tab3'] ) : '';

        return $instance;
    }

} // class Foo_Widget
// register Foo_Widget widget
function register_tabs_post_widget() {
    register_widget( 'TabsPost_Widget' );
}
add_action( 'widgets_init', 'register_tabs_post_widget' );


/* Start widget category by ID */
class Hwp_Posts_By_CatId_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'Hwp_Posts_By_CatId', // Base ID
            esc_html__( 'HWP Posts By Cat ID', 'hwp' ), // Name
            array( 'description' => esc_html__( 'A Posts By Category Id  Widget', 'hwp' ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        echo $args['before_widget']; ?>
        <!-- start box list posts by category id-->
        <?php
            $old_list_cat_id = json_decode($instance[ 'list_cat_id' ]);
        ?>
        <div class="row">
            <?php foreach( $old_list_cat_id as $index => $catID ): ?>
                <?php
                $arrPosts = new WP_Query(array(
                    "post_type"         => "post",
                    "cat"            => $catID,
                    "posts_per_page"    => 5
                ));
                $listPost = $arrPosts->posts;
                ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="category_post">
                        <div class="box_title clearfix">
                            <a class="pull-left" href="<?php echo get_category_link($catID); ?>"><?php echo get_category($catID)->name; ?></a>
                            <a class="pull-right" href="<?php echo get_category_link($catID); ?>">View all <span class="glyphicon glyphicon-chevron-right"></span></a>
                        </div>
                        <a class="big_img" href="<?php echo get_the_permalink($listPost[0]->ID); ?>">
                            <img class="img-responsive" src="<?php echo get_the_post_thumbnail_url($listPost[0]->ID); ?>" alt="<?php echo get_the_title($listPost[0]->ID); ?>"/>
                        </a>
                        <h4 class="big_title" title="<?php echo get_the_title($listPost[0]->ID); ?>">
                            <a href="<?php echo get_the_permalink($listPost[0]->ID) ?>" title="<?php echo get_the_title($listPost[0]->ID) ?>"><?php echo get_the_title($listPost[0]->ID) ?></a></h4>
                        <div class="big_after_title">
                            <?php  the_category( ",","", $listPost[0]->ID ); ?>&nbsp;
                            <span class="date_post"><span class="glyphicon glyphicon-calendar"></span> <?php echo get_the_date("d-m-Y", $listPost[0]->ID) ?></span>&nbsp;
                            <span class="date_post"><span class="glyphicon glyphicon-comment"></span> <?php echo get_comments_number($listPost[0]->ID); ?></span>
                        </div>
                        <div class="big_excerpt">
                            <?php echo get_the_excerpt($listPost[0]->ID); ?>
                        </div>
                        <div class="list-item">
                            <?php foreach( $listPost as $k=> $post ): if( $k != 0 ): ?>
                                <div class="item">
                                    <div class="img pull-left">
                                        <a href="<?php the_permalink($post->ID); ?>"
                                           title="<?php echo get_the_title($post->ID); ?>">
                                            <img class="img-responsive" src="<?php echo get_the_post_thumbnail_url($post->ID)?>"
                                                 title="<?php echo get_the_title($post->ID) ?>" alt="<?php echo get_the_title($post->ID) ?>"/>
                                        </a>
                                    </div>
                                    <h5 title="<?php echo get_the_title($post->ID) ?>">
                                        <a href="<?php echo get_the_permalink($post->ID) ?>" title="<?php echo get_the_title($post->ID) ?>">
                                            <?php echo get_the_title($post->ID) ?>
                                        </a>
                                    </h5>
                                    <div class="small_after_title">
                                        <span class="date_post"><span class="glyphicon glyphicon-calendar"></span> <?php echo get_the_date("d-m-Y", $post->ID) ?></span>&nbsp;
                                        <span class="date_post"><span class="glyphicon glyphicon-comment"></span> <?php echo get_comments_number( $post->ID ) ?></span>
                                    </div>
                                </div>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php echo ( ( ($index+1) % 2 == 0 )) ? '<div class="clearfix"></div>' : ''; ?>
            <?php endforeach; ?>
        </div>
        <!-- end box list post by category-->

        <?php
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {

        $categories = get_categories();
        $list_cat_id = array();
        foreach($categories as $k=>$v){
            $list_cat_id[] = $v->term_id;
        }
        $old_list_cat_id  = ( count( json_decode($instance['list_cat_id']) ) > 0 ) ? json_decode($instance['list_cat_id']): array(0);

        $instance['list_cat_id'] = ( !empty($instance['list_cat_id']) ) ? $instance['list_cat_id'] : json_encode( $list_cat_id );

        $catID = esc_attr( $instance['list_cat_id'] );
        ?>
            <p>
                <?php foreach( $categories as $k=>$category ): ?>
                    <input <?php echo ( in_array( $category->term_id, $old_list_cat_id ) ) ? "checked":"" ?> class='checkbox' type="checkbox" id="<?php echo $category->term_id; ?>" value="<?php echo $category->term_id; ?>" name="list_cat_id[]" />
                    <label for="<?php echo $category->term_id; ?>"><?php echo $category->name; ?>;&nbsp;</label>
                <?php endforeach; ?>
            </p>
    <?php }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['list_cat_id'] = strip_tags(json_encode( $_POST['list_cat_id'] ));
        return $instance;
    }

} // class Foo_Widget
// register Foo_Widget widget
function register_Hwp_Posts_By_CatId_Widget() {
    register_widget( 'Hwp_Posts_By_CatId_Widget' );
}
add_action( 'widgets_init', 'register_Hwp_Posts_By_CatId_Widget' );