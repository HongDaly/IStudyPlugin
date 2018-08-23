<?php 
            $cat_id = get_query_var('cat');
            
            if(!isset( $_GET['postid']))
            {
                $args = array(  'order'=>'ASC',
                'posts_per_page'=>'1',
                'cat' => $cat_id);
                get_post_item($args,0);
            }else{
                $post_id = $_GET['postid'];
                $args = array('p'=> $post_id,
                            'cat' => $cat_id);
                get_post_item($args,$post_id);
            }
            function get_post_item($args,$active_post_id)
            {
                $cat_id = get_query_var('cat');
                $post_output = '';
                $post_output .= '<div class="card p-2"><h6>'.get_cat_name( $cat_id ).'</h6></div>';
                $post_output .= '<hr class="mt-2">';
                $posts = new WP_Query($args);
                $post_output .='<div class="card-group row">';
                    $post_output .='<div id="istudy-sidebar" class="col-3 mt-2">';
                        $result = get_content_menu($cat_id,$active_post_id);
                        $post_output .= $result[0];
                        $post_lists = $result[1];
                    $post_output .='</div>';
                if ( $posts->have_posts() ) {
                    while ( $posts->have_posts() ) {
                        $posts->the_post();
                        $post_output .='<div id="istudy-content" class="col-9 p-2">';
                            $post_output .= '<div>';
                                $content = get_the_content();
                                $content = apply_filters('the_content', $content);
                                $content = str_replace(']]>', ']]&gt;', $content);
                                $post_output .= do_shortcode($content);         
                                $post_output .= init_pagination($post_lists,$active_post_id);                      
                            $post_output .='</div>';
                        $post_output .= '</div>';
                    } 
                    wp_reset_postdata();
                }
                $post_output .='</div>';
                echo $post_output;   
                
            }
            function get_content_menu($cat_id,$active_post_id)
            {             
                $post_lists =  array(); 
                $args = array( 'order'=>'ASC','cat' => $cat_id);
                $posts = new WP_Query($args);
                $view = '';
                $view .='<div class="list-group">';
                $first_post = 0;
                if ( $posts->have_posts() ) {
                    while ( $posts->have_posts() ) {
                        $posts->the_post();
                        $postid = get_the_ID();
                        $post_lists[] = $postid;
                        if($active_post_id == 0){
                            if($first_post == 0){
                                $view .='<a href="'.get_term_link( $cat_id ).'?postid='.$postid.'" class="list-group-item list-group-item-action active">'.get_the_title().'</a>';
                            }else{
                                $view .='<a href="'.get_term_link( $cat_id ).'?postid='.$postid.'" class="list-group-item list-group-item-action">'.get_the_title().'</a>';
                            }
                            $first_post = $first_post + 1;
                        }
                        else{
                            if($postid == $active_post_id){
                                $view .='<a href="'.get_term_link( $cat_id ).'?postid='.$postid.'" class="list-group-item list-group-item-action active">'.get_the_title().'</a>';
                            }else {
                                $view .='<a href="'.get_term_link( $cat_id ).'?postid='.$postid.'" class="list-group-item list-group-item-action">'.get_the_title().'</a>';
                            }
                        }
                  }
                    wp_reset_postdata();
                }
                $view .= '</div>';
                return [$view,$post_lists];
            }
            function init_pagination($posts,$active_post_id)
            {
                $view = '';
                $view .= '<div><hr>';
                if(count($posts)>=1)
                {
                    //echo '  <a class="istudy-menu-item" style="color: white" href="'.get_post_page_link($parent_category,$page,"Previous").'">Previous</a>';
                    $view .= '<div class="page-item float-left"><a class="page-link" href="'.get_previous_link($posts,$active_post_id).'">Previous</a></div>';
                    //echo '<a class="istudy-menu-item" style="color: white;float: right" href="'.get_post_page_link($parent_category,$page,"Next").'">Next</a></div>';
                    $view .= '<div class="page-item float-right"><a class="page-link" href="'.get_next_link($posts,$active_post_id).'">Next</a></div>';
                } 
                $view .= '</div>';
                return $view;
            }
            function get_next_link($posts , $current_post_id){
                if($current_post_id == 0){
                    $nextpage =  $posts[0];
                }else{
                    $nextpage =  $current_post_id;
                }
                for ($i = 0 ; $i < count($posts);$i++)
                {
                    if($posts[$i] == $nextpage){
                        $nextpage = $i+1;
                        break;
                    }
                }
                if($nextpage > count($posts)-1){
                    $nextpage =  $nextpage-1;
                }
                $cat_id = get_query_var('cat');
                return get_term_link( $cat_id ).'?postid='.$posts[$nextpage];
            }
            function get_previous_link($posts , $current_post_id){
                if($current_post_id == 0){
                    $previous =  $posts[0];
                }else{
                    $previous =  $current_post_id;
                }
                for ($i = 0 ; $i < count($posts);$i++)
                {
                    if($posts[$i] == $previous){
                        $previous = $i-1;
                        break;
                    }
                }
                if($previous < 0){
                    $previous =  $previous+1;
                }
                $cat_id = get_query_var('cat');
                return get_term_link( $cat_id ).'?postid='.$posts[$previous];
            }
?>