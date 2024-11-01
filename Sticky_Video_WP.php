<?php

/*
 * @package    Sticky_Video
 * @version    2.1.0
 * @author     Octave - http://octave.systems
 * @license    GPL-2.0 - http://www.gnu.org/licenses/gpl-2.0.txt
 */

defined('WPINC') or die( 'Restricted access' );

class Sticky_Video_WP {

    /**
     *
     * Vars & Inits
     *
     */

    static private $wp_admin_options;

    static private function prepare_admin_options(){

        Sticky_Video_WP::$wp_admin_options = get_option('sticky_video_options');

        // Check options' validity
        Sticky_Video_WP_Admin::init_default_options();
        foreach( Sticky_Video_WP_Admin::get_default_options() as $key => $value ){
            if( !isset( Sticky_Video_WP::$wp_admin_options[ $key ] ) ){
                Sticky_Video_WP::$wp_admin_options[ $key ] = $value;
            }
        }

    }

    /**
     *
     * JS bridge
     *
     */

    static public function define_js_sticky_video_instance(){

        echo '<script type="text/javascript">' .
             'window.stickyVideo=window.stickyVideo||{};' . // needed if <script> has "defer" attribute
             'window.stickyVideo.params={' .
                 '"video-width":' . Sticky_Video_WP::$wp_admin_options['video-width'] . ',' .
                 '"video-width-mobile":' . Sticky_Video_WP::$wp_admin_options['video-width-mobile'] . ',' .
                 '"video-position":"' . Sticky_Video_WP::$wp_admin_options['video-position'] . '",' .
                 '"transition-type":"' . Sticky_Video_WP::$wp_admin_options['transition-type'] . '",' .
                 '"enable-close-button":' . Sticky_Video_WP::$wp_admin_options['enable-close-button'] . ',' .
                 '"selecting-method":"' . Sticky_Video_WP::$wp_admin_options['selecting-method'] . '",' .
                 '"position-vertical-offset":' . Sticky_Video_WP::$wp_admin_options['position-vertical-offset'] . ',' .
                 '"position-vertical-offset-mobile":' . Sticky_Video_WP::$wp_admin_options['position-vertical-offset-mobile'] . ',' .
                 '"position-side-offset":' . Sticky_Video_WP::$wp_admin_options['position-side-offset'] . ',' .
                 '"position-side-offset-mobile":' . Sticky_Video_WP::$wp_admin_options['position-side-offset-mobile'] . ',' .
                 '"enable-on-mobile":' . Sticky_Video_WP::$wp_admin_options['enable-on-mobile'] . ',' .
                 '"mobile-breakpoint":' . Sticky_Video_WP::$wp_admin_options['mobile-breakpoint'] . ',' .
                 '"enable-on-pause":' . Sticky_Video_WP::$wp_admin_options['enable-on-pause'] .
             '};' .
             // Note: leave the outer anonymous function cause we've had issues with minifing plugins
             // messing around with scripts' order ...
             'if(window.addEventListener)window.addEventListener("load",function(){window.stickyVideo.init()});' .
             '</script>';

    }

    static private function new_js_sticky_video_instance(){

        add_action( 'wp_print_footer_scripts', array('Sticky_Video_WP', 'define_js_sticky_video_instance') );

    }

    /**
     *
     * WP's assets inclusion
     *
     */

    static private function require_sticky_video_assets(){

        // https://developer.wordpress.org/reference/functions/wp_enqueue_script/
        wp_enqueue_script(
            'sticky-video', // $handle
            plugins_url( 'assets/sticky-video.min.js', __FILE__ ),
            array(), // $deps
            '2.1.0', // $ver
            true // $in_footer
        );

    }

    /**
     *
     * CSS Style WP inclusion
     *
     */

    static public function define_sticky_video_style(){

        echo 
        '<style type="text/css">'.


            // --------- Placeholder --------- //
            '#sticky-video--placeholder{'.
                'width:100%;'.
                'top:0;left:0;'. // Needed if position === absolute
                'background:'.Sticky_Video_WP::$wp_admin_options['placeholder-bg-color'].';'.
            '}'.

        '</style>';

    }

    static private function add_sticky_video_style(){

        add_action('wp_head', array('Sticky_Video_WP', 'define_sticky_video_style'));

    }

    /**
     *
     * Main
     *
     */

    static public function run(){

        Sticky_Video_WP::prepare_admin_options();

        if( !is_page() && !is_single() ) return;

        Sticky_Video_WP::require_sticky_video_assets();
        Sticky_Video_WP::add_sticky_video_style();
        Sticky_Video_WP::new_js_sticky_video_instance();

    }

}
