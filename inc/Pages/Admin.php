<?php
/**
 * 
 * @package IStudyPlugin
 * 
 */

 namespace Inc\Pages;

 use \Inc\Base\BaseController;
 use \Inc\Api\SettingsApi;
 use \Inc\Api\Callbacks\AdminCallbacks;

 class Admin extends BaseController{
       
    public $settings;
    public $pages;
    public $subpages;

    public $callbacks;

    public function register(){

        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks();
        $this->set_pages();
        $this->set_subpages();
        $this->settings->add_pages($this->pages)->register();
        // $this->settings->add_pages($this->pages)->with_subpages()->add_subpages($this->subpages)->register();
    }
    public function set_pages(){
        $this->pages = array(
            array(
                'page_title' => "IStudy Plugin", 
                'menu_title'  => "Reorder",
                'capability' => 'manage_options',
                'menu_slug'  => 'istudy_plugin',
                'callback'   => array($this->callbacks,'admin_dashboard'),
                'icon_url'   => 'dashicons-book',
                'position'   => 110
              
            )
        );
    }
    public function set_subpages(){
        $this->subpages = array(
            array(
                'parent_slug' => 'istudy_plugin', 
                'page_title' => 'Custom Post Types', 
                'menu_title'  => 'CPT',
                'capability' => 'manage_options',
                'menu_slug'  => 'istudy_cpt',
                'callback'   => function(){echo '<h1>CPT</h1>';}
            ),
            array(
                'parent_slug' => 'istudy_plugin', 
                'page_title' => 'Custom Menu', 
                'menu_title'  => 'Menu Style',
                'capability' => 'manage_options',
                'menu_slug'  => 'istudy_menu',
                'callback'   => function(){echo '<h1>Menu</h1>';}
            ),
            array(
                'parent_slug' => 'istudy_plugin', 
                'page_title' => 'Page Style', 
                'menu_title'  => 'Page Style',
                'capability' => 'manage_options',
                'menu_slug'  => 'istudy_page_style',
                'callback'   => function(){echo '<h1>Page Style</h1>';}
            )
        );
    }

 }








