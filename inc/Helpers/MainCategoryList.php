<?php
/**
 * 
 * @package IStudyPlugin
 */
namespace Inc\Helpers;
use \Inc\Base\BaseController;

class MainCategoryList extends BaseController
{
    public function register(){
        add_shortcode('parent_cat', array($this,'get_list_category_ui'));
    }
    public function get_list_category_ui()
    {
        $output = '';
        $categories = get_terms( 'category', array(
            'orderby'    => 'name',
            'order'   => 'ASC',
            'hide_empty' => 0,
            'parent' => 0
        ));
        $output .= '<div class="row">';
        foreach($categories as $category){
            $output .= '<div class="col-4 cat-card">';
                $output .= '<div class="card">';
                    $output .= '<a href="'.get_category_link( $category ).'">';
                        $output .= '<img class="cat-image" src='.$this->get_cat_image($category->term_id)[0].'>';
                        $output .= '<div class="card-body">';
                            $output .= '<p class="cat-title">'.$category->name.'</p>';
                        $output .='</div>';
                    $output .='</a>';
                $output .= '</div>';
            $output .= '</div>';
        }
        $output .= '</div>';
        return $output;
    }
    private function get_cat_image($cat_id){
        $image_id = get_term_meta ( $cat_id, 'category-image-id', true );
        return wp_get_attachment_image_src( $image_id, 'full' );
    }
}