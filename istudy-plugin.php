<?php 
/**
 * @package IStudyPlugin
 */
/*
Plugin Name: IStudy Plugin
Plugin URI: http://istudy.com.kh/plugin
Description: This is the best plugin for costumization your courses
Version: 1.0.0
Author: Mr. Hong Daly & Mr. Va Winricha
Author URI: http://istudy.com
License: GPLv2 or later
Text Domain: istudy-plugin
*/

defined('ABSPATH') or die('Hey , what are you doing here ? You silly human!');

if ( file_exists(dirname(__FILE__).'/vendor/autoload.php'))
{
    require_once dirname(__FILE__).'/vendor/autoload.php';
}


function activate_istudy_plugin(){
    Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_istudy_plugin' );



function deactivate_istudy_plugin(){
    Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_istudy_plugin' );


if(class_exists('Inc\\Init')){
    Inc\Init::register_services();
}