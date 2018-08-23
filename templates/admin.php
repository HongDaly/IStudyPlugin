<?php
    $output = '';
    $categories = get_terms( 'category', array(
        'orderby'    => 'name',
        'order'   => 'ASC',
        'hide_empty' => 0,
        'parent' => 0
    ));
    function add_script() { ?>
        <script type="text/javascript" >
        $('#cat_selector').on('change', function() {
            data  = {
                action:'get_child_cat',
                'cat_id' : $('#cat_selector').val()
            }
            jQuery.post(ajaxurl,data, function(data) {
                document.getElementById('child_cat_selector').innerHTML = '';
                document.getElementById('child_cat_selector').innerHTML = data;
            });
        });

        $('#child_cat_selector').on('change', function() {
            data  = {
                action:'get_post_item',
                'parent_id' : $('#child_cat_selector').val()
            }
            jQuery.post(ajaxurl,data, function(data) {
                document.getElementById('post_list').innerHTML = '';
                document.getElementById('post_list').innerHTML = data;
            });
        });

        var $sortable = $('#post_list');
        var old_list;
        var new_list;
        $sortable.sortable({
            start: function(e, ui) {
                old_list  = $sortable.sortable('toArray');
            },
            update: function(e, ui) {
                new_list  = $sortable.sortable('toArray');
                data = {
                    action : 'reorder_post',
                    'old_list' : old_list,
                    'new_list' : new_list
                };
                jQuery.post(ajaxurl,data, function(data) {
                    console.log(data);
                });
            }      
        });
        </script> <?php
    }
    add_action( 'admin_footer', 'add_script' );
?>
<div class="mt-5">
    <form>
        <lable>Parent : </label>
        <select class="selectpicker" id="cat_selector">
            <option selected disabled>Select Category</option>
            <?php foreach($categories as $category){
                    $output ='<option value="'.$category->term_id.'">'.$category->name.'</option>';
                    echo $output;
                }?>
        </select>
        <lable class="ml-5"> Category : </label>
        <select class="selectpicker" id="child_cat_selector">
            <option selected disabled>Select Category</option>
        </select>
    </form>
    <hr>
    <div class="row mt-2">
        <div class ="col-12">
        <ul class="list-group col-12" id="post_list">
            <li class="list-group-item">No Post</li>
        </ul>
        </div>
    </div>
</div>

