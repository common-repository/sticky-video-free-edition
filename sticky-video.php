<?php

/**
 * @link              http://stickyvideo.octave.systems
 * @since             2.1.0
 * @package           Sticky-Video
 *
 * @wordpress-plugin
 * Plugin Name:       Sticky-Video (Free edition)
 * Plugin URI:        http://stickyvideo.octave.systems
 * Description:       Sticky Video plugin allows you to watch videos continuously while scrolling through a page or a post.
 * Version:           2.1.0
 * Author:            Octave
 * Author URI:        http://octave.systems
 * License:           GPL-2.0 - http://www.gnu.org/licenses/gpl-2.0.txt
 */

defined('WPINC') or die( 'Restricted access' );

// Debugger
// ini_set('display_errors', 1);
// error_reporting(E_ALL | E_STRICT);

if( !is_admin() ){

    require_once plugin_dir_path( __FILE__ ) . './Sticky_Video_WP_Admin.php';
    require_once plugin_dir_path( __FILE__ ) . './Sticky_Video_WP.php';

    add_action( 'wp', array('Sticky_Video_WP', 'run') );

} else {

    require_once plugin_dir_path( __FILE__ ) . './Sticky_Video_WP_Admin.php';

    add_action( 'admin_menu', array('Sticky_Video_WP_Admin', 'init_default_options') );
    add_action( 'admin_menu', array('Sticky_Video_WP_Admin', 'init_admin_options') );
    add_action( 'admin_menu', array('Sticky_Video_WP_Admin', 'register_plugin_admin_hooks') );
    add_action( 'admin_menu', array('Sticky_Video_WP_Admin', 'declare_admin_page') );
    add_action( 'admin_init', array('Sticky_Video_WP_Admin', 'define_admin_fields') );
    add_action( 'admin_enqueue_scripts', array('Sticky_Video_WP_Admin', 'require_admin_assets') );

}
