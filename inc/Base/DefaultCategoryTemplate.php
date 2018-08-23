<?php
/**
 * 
 * @package IStudyPlugin
 */
namespace Inc\Base;
use \Inc\Base\BaseController;

class DefaultCategoryTemplate extends BaseController{
    public function register(){
        add_filter('category_template', array($this,'custom_category_template'));
    }
    public function  custom_category_template() {
        return require_once("$this->plugin_path/templates/CustomCategoryTemplate.php");
    }
}