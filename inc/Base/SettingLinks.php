<?php
/**
 * 
 * @package IStudyPlugin
 */

 namespace Inc\Base;

 use \Inc\Base\BaseController;
 class SettingLinks extends BaseController{
    
    public function register(){
        add_filter("plugin_action_links_".$this->plugin_basename ,array($this,'setting_link'));
    }
 
    public function setting_link($links){
        $settings_link = '<a href="admin.php?page=istudy_plugin">IStudy</a>';
        array_push($links,$settings_link);
        return $links;
    }
 }