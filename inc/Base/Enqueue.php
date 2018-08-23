<?php
/**
 * 
 * @package IStudyPlugin
 */

 namespace Inc\Base;
 use \Inc\Base\BaseController;
 class Enqueue extends BaseController{
       
    public function register(){
        add_action( 'admin_enqueue_scripts',  array($this,"enqueue")); 
        add_action( 'wp_enqueue_scripts',  array($this,"enqueue"));
        add_action( 'wp_ajax_get_child_cat',array($this,'get_child_cat'));
        add_action( 'wp_ajax_get_post_item',array($this,'get_post_item'));
        
        add_action( 'wp_ajax_reorder_post',array($this,'reorder_post'));
    }
    function enqueue(){
        wp_enqueue_style( "istudystyle", $this->plugin_url.'assets/css/istudy.css');
        wp_enqueue_style( "istudystyle1", $this->plugin_url.'assets/css/bootstrap.css');
        wp_enqueue_style( "istudystyle2", $this->plugin_url.'assets/css/bootstrap.min.css');
        


      //  wp_enqueue_script( "istudyscript1", $this->plugin_url.'assets/js/jquery-3.3.1.min.js');
        wp_enqueue_script( "istudyscript", $this->plugin_url.'assets/js/istudy.js');
        wp_enqueue_script( "istudyscript2", $this->plugin_url.'assets/js/bootstrap.js');
        wp_enqueue_script( "istudyscript3", $this->plugin_url.'assets/js/bootstrap.min.js');
        wp_enqueue_script( "jquery.ui", $this->plugin_url.'assets/js/jquery-ui.min.js');
        wp_localize_script( 'ajax-script', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );    
    }
    function get_child_cat() {
        $parent_id = $_POST['cat_id'];
        $categories = get_terms( 'category', array(
            'orderby'    => 'name',
            'order'   => 'ASC',
            'hide_empty' => 0,
            'parent' => $parent_id
        ));
        $output = '<option selected disabled>Select Category</option>';
        foreach($categories as $category){
            $output .='<option value="'.$category->term_id.'">'.$category->name.'</option>';
        }
        echo $output;
        wp_die();
    }
    function get_post_item(){
        $cat_id = $_POST['parent_id'];
        $view = '';
        $args = array('order'   => 'ASC', 'posts_per_page' => -1, 'category' => $cat_id );
        $posts = get_posts($args);
    
        if( count($posts) > 0 ){
            foreach ($posts as $post){
                $title = $post->post_title;
                $view .= '<li class="list-group-item" id = "'.$post->ID.'">'. $title.'</li>';
                
            }
        }else{
            $view = '<li class="list-group-item">Sorry No post on the category!</li>';
        }
        echo $view;
        wp_die();
    }
    function reorder_post(){
        $old_list = $_POST['old_list'];
        $new_list = $_POST['new_list'];
        if(isset($old_list,$new_list)){
            $date_list = $this->get_post_date_order($old_list); 
            for ($i = 0 ; $i < count($new_list);$i++){
                $this->set_postdate($date_list[$i],$new_list[$i]);
            }
        }
        wp_die();
    }
    function get_post_date_order($old_list){
        $list = array();
        $date_format = "Y/m/d H:i:s";
        foreach ($old_list as $postid) {
            array_push($list,get_the_date($date_format,$postid));
        }
        return $list;
    }
    function set_postdate($date,$postid){ 
        global $wpdb;    
        $wpdb->query( "UPDATE `$wpdb->posts` SET 
                                            `post_date` = '".$date."'
                                             WHERE `ID` = '".$postid."'" );
    }
 }