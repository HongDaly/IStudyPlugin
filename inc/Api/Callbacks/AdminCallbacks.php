<?php
/**
 * 
 * @package IStudyPlugin
 */
 namespace Inc\Api\Callbacks;
 use \Inc\Base\BaseController;

 class AdminCallbacks extends BaseController
 {
    public function admin_dashboard(){
        return require_once("$this->plugin_path/templates/admin.php");
    }
 }