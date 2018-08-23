<?php 
/**
 * 
 * @package IStudyPlugin
 */
get_header();
$cat_id = get_query_var('cat');
$output = '';
$categories = get_terms( 'category', array(
    'orderby'    => 'name',
    'order'   => 'ASC',
    'hide_empty' => 0,
    'parent' => $cat_id
));
if(count($categories)>0){
    $output .= '<div class="row">';
    foreach($categories as $category){
        $output .= '<div class="col-3 cat-card">';
            $output .= '<div class="card">';
                $output .= '<a href="'.get_category_link( $category ).'">';
                    $output .= '<img class="cat-image" src='.
                        wp_get_attachment_image_src( get_term_meta ( $category->term_id, 'category-image-id', true ), 'full')[0].'>';
                    $output .= '<div class="card-body">';
                        $output .= '<p class="cat-title">'.$category->name.'</p>';
                    $output .='</div>';
                $output .='</a>';
            $output .= '</div>';
        $output .= '</div>';
    }
    $output .= '</div>';
    echo $output;
}else{
   require_once dirname(__FILE__).'/PostPageTemplate.php';
}
get_footer();