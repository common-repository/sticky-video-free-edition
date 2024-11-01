<?php

/*
 * @package    Sticky_Video
 * @version    2.1.0
 * @author     Octave - http://octave.systems
 * @license    GPL-2.0 - http://www.gnu.org/licenses/gpl-2.0.txt
 */

defined('WPINC') or die( 'Restricted access' );

class Sticky_Video_WP_Admin {

    /**
     *
     * Vars & params
     *
     */

    const PLUGIN_SLUG = 'sticky-video';

    static private $default_options;
    static private $stored_options;

    static public function init_default_options(){

        Sticky_Video_WP_Admin::$default_options = array(
            'video-width' => '300',
            'video-width-mobile' => '150',
            'video-position' => 'top-right',
            'transition-type' => 'none',
            'enable-close-button' => 'false',
            'selecting-method' => 'auto-select',
            'position-vertical-offset' => '20',
            'position-vertical-offset-mobile' => '10',
            'position-side-offset' => '20',
            'position-side-offset-mobile' => '10',
            'enable-on-mobile' => 'true',
            'mobile-breakpoint' => '768',
            'placeholder-bg-color' => '#F6F6F6',
            'enable-on-pause' => 'true'
        );

    }

    static public function get_default_options(){

        return Sticky_Video_WP_Admin::$default_options;

    }

    static public function init_admin_options(){

        // delete_option( 'sticky_video_options' ); // Uncomment this to reset options
        add_option( // Note: It does nothing if the option already exists
            'sticky_video_options',
            Sticky_Video_WP_Admin::$default_options
        );
        Sticky_Video_WP_Admin::$stored_options = get_option( 'sticky_video_options' );

        // Check options' validity
        foreach( Sticky_Video_WP_Admin::$default_options as $key => $value ){
            if(
                !isset( Sticky_Video_WP_Admin::$stored_options[ $key ] ) ||
                Sticky_Video_WP_Admin::$stored_options[ $key ] === '' // Reset option if empty
            ){
                Sticky_Video_WP_Admin::$stored_options[ $key ] = $value;
            }
        }

    }

    /**
     *
     * Install/Deactivation/Uninstall stuff
     *
     */

    static public function on_plugin_activation(){
        add_option(
            'sticky_video_options',
            Sticky_Video_WP_Admin::$default_options
        );
    }

    static public function on_plugin_deactivation(){
        // Nothing for now
    }

    static public function on_plugin_uninstall(){
        delete_option( 'sticky_video_options' );
    }

    static public function register_plugin_admin_hooks(){

        register_activation_hook( __FILE__, array('Sticky_Video_WP_Admin', 'on_plugin_activation') );
        register_deactivation_hook( __FILE__, array('Sticky_Video_WP_Admin', 'on_plugin_deactivation') );
        register_uninstall_hook( __FILE__, array('Sticky_Video_WP_Admin', 'on_plugin_uninstall') );

    }

    /**
     *
     * Admin options page
     *
     */

    static public function declare_admin_page(){

        add_options_page(
            'Sticky Video',
            'Sticky Video',
            'administrator',
            Sticky_Video_WP_Admin::PLUGIN_SLUG,
            array('Sticky_Video_WP_Admin', 'admin_form' )
        );

    }

    static public function admin_form(){

        echo '<h1>Sticky Video <span style="font-size:85%">(Free edition)</span> <sup><a href="http://stickyvideo.octave.systems/" style="font-size:.8rem;display:inline-block;color:#FFF;background:#0073aa;padding:5px 8px;text-decoration:none;border-radius:3px;" target="_blank" >Get the Pro version!</a></sup></h1>';
        echo '<style>.sticky-video-wp-admin--section-heading{display:block;margin:1em 0;padding:1em 0;font-size:1.5em;font-weight:normal;border-bottom:1px solid rgba(0,0,0,.2);}.sticky-video-wp-admin--settings-divider{margin:0;padding:0;max-width:15em;border:0;border-bottom:1px dashed rgba(0,0,0,.2);}.sticky-video-wp-admin--right-text-alignment-box{display:table;white-space:nowrap;text-align:right;margin:0;}.sticky-video-wp-admin--free-edition-desc{font-size:90%;border-left:3px solid rgba(0, 103, 153, 0.39);background:rgba(255,255,255,.7);display:block;line-height:1.6;padding:0 .6em .05em .4em;margin:0 !important;float:left;}.sticky-video-wp-admin--free-edition-desc strong{font-style:italic;}</style>';
        echo '<div class="wrap"><form class="sticky-video-admin-form" method="post" action="options.php" enctype="multipart/form-data">';
        settings_fields( 'sticky_video_options' );
        do_settings_sections( Sticky_Video_WP_Admin::PLUGIN_SLUG );
        echo '<div style="padding-top:2em"></div>';
        submit_button( 'Save Changes', 'primary', 'submit-form', false );
        echo '<div style="padding-top:2em"></div>';
        echo '</form></div>';

    }

    static public function define_admin_fields(){

        register_setting(
            'sticky_video_options',
            'sticky_video_options',
            array('Sticky_Video_WP_Admin', 'sanitize_options' )
        );

        add_settings_section(
            'sticky_video_options__mainSection',
            '<h3 class="sticky-video-wp-admin--section-heading">General Settings</h3>',
            array('Sticky_Video_WP_Admin', 'mainSection_optionContent' ),
            Sticky_Video_WP_Admin::PLUGIN_SLUG
        );

        add_settings_field(
            'video-position',
            'Position when sticky',
            array('Sticky_Video_WP_Admin', 'videoPosition_optionContent' ),
            Sticky_Video_WP_Admin::PLUGIN_SLUG,
            'sticky_video_options__mainSection'
        );

        add_settings_field(
            'enable-close-button',
            'Enable close button?',
            array('Sticky_Video_WP_Admin', 'enableCloseButton_optionContent' ),
            Sticky_Video_WP_Admin::PLUGIN_SLUG,
            'sticky_video_options__mainSection'
        );

        add_settings_field(
            'enable-on-mobile',
            'Enable on mobile?',
            array('Sticky_Video_WP_Admin', 'disableOnMobile_optionContent' ),
            Sticky_Video_WP_Admin::PLUGIN_SLUG,
            'sticky_video_options__mainSection'
        );

        add_settings_field(
            'transition-type',
            'Transition type?',
            array('Sticky_Video_WP_Admin', 'transitionType_optionContent' ),
            Sticky_Video_WP_Admin::PLUGIN_SLUG,
            'sticky_video_options__mainSection'
        );

        add_settings_field(
            'main-section-divider-1',
            '<hr class="sticky-video-wp-admin--settings-divider"/>',
            array('Sticky_Video_WP_Admin', 'sectionDivider_optionContent' ),
            Sticky_Video_WP_Admin::PLUGIN_SLUG,
            'sticky_video_options__mainSection'
        );

        add_settings_field(
            'video-width',
            'Sticky video width',
            array('Sticky_Video_WP_Admin', 'videoWidth_optionContent' ),
            Sticky_Video_WP_Admin::PLUGIN_SLUG,
            'sticky_video_options__mainSection'
        );

        add_settings_field(
            'position-vertical-offset',
            'Vertical offset when sticky',
            array('Sticky_Video_WP_Admin', 'positionVerticalOffset_optionContent' ),
            Sticky_Video_WP_Admin::PLUGIN_SLUG,
            'sticky_video_options__mainSection'
        );

        add_settings_field(
            'position-side-offset',
            'Horizontal offset when sticky',
            array('Sticky_Video_WP_Admin', 'positionSideOffset_optionContent' ),
            Sticky_Video_WP_Admin::PLUGIN_SLUG,
            'sticky_video_options__mainSection'
        );

        add_settings_field(
            'main-section-divider-2',
            '<hr class="sticky-video-wp-admin--settings-divider"/>',
            array('Sticky_Video_WP_Admin', 'sectionDivider_optionContent' ),
            Sticky_Video_WP_Admin::PLUGIN_SLUG,
            'sticky_video_options__mainSection'
        );

        add_settings_field(
            'placeholder-bg-color',
            'Placeholder background color',
            array('Sticky_Video_WP_Admin', 'placeholderBgColor_optionContent' ),
            Sticky_Video_WP_Admin::PLUGIN_SLUG,
            'sticky_video_options__mainSection'
        );

        add_settings_section(
            'sticky_video_options__advancedSection',
            '<h3 class="sticky-video-wp-admin--section-heading">Advanced Settings</h3>',
            array('Sticky_Video_WP_Admin', 'advancedSection_optionContent' ),
            Sticky_Video_WP_Admin::PLUGIN_SLUG
        );

        add_settings_field(
            'selecting-method',
            'Video selecting method',
            array('Sticky_Video_WP_Admin', 'selectingMethod_optionContent' ),
            Sticky_Video_WP_Admin::PLUGIN_SLUG,
            'sticky_video_options__advancedSection'
        );

        add_settings_field(
            'mobile-breakpoint',
            'Mobile breakpoint',
            array('Sticky_Video_WP_Admin', 'mobileBreakpoint_optionContent' ),
            Sticky_Video_WP_Admin::PLUGIN_SLUG,
            'sticky_video_options__advancedSection'
        );

        add_settings_field(
            'enable-on-pause',
            'Enable stickiness on paused videos?',
            array('Sticky_Video_WP_Admin', 'enableOnPause_optionContent' ),
            Sticky_Video_WP_Admin::PLUGIN_SLUG,
            'sticky_video_options__advancedSection'
        );

    }

    static public function mainSection_optionContent(){}
    static public function sectionDivider_optionContent(){}

    static public function videoWidth_optionContent() {

        echo '<p class="sticky-video-wp-admin--free-edition-desc">Not available in free edition. Default values: 300px Desktop - 150px Mobile.</p>';

    }

    static public function videoPosition_optionContent() {

        echo '<p class="sticky-video-wp-admin--free-edition-desc">Not available in free edition. Options available in Pro edition: <strong>Top - Left</strong>, <strong>Top - Right</strong>, <strong>Bottom - Left</strong>, <strong>Bottom - Right</strong>.</p>';

    }

    static public function positionVerticalOffset_optionContent() {

        echo '<div class="sticky-video-wp-admin--right-text-alignment-box">';

        echo
            'Desktop/Tablet: <input type="number" style="width:5em" min="-9999" max="9999" name="sticky_video_options[position-vertical-offset]" value="'.
                Sticky_Video_WP_Admin::$stored_options['position-vertical-offset'].
            '"/><span class="sticky-video-wp-admin--text.-input-unit">px</span>';
        echo
            '<br/>Mobile: <input type="number" style="width:5em" min="-9999" max="9999" name="sticky_video_options[position-vertical-offset-mobile]" value="'.
                Sticky_Video_WP_Admin::$stored_options['position-vertical-offset-mobile'].
            '"/><span class="sticky-video-wp-admin--text-input-unit">px</span>';

        echo '</div>';

    }

    static public function positionSideOffset_optionContent() {

        echo '<div class="sticky-video-wp-admin--right-text-alignment-box">';

        echo
            'Desktop/Tablet: <input type="number" style="width:5em" min="-9999" max="9999" name="sticky_video_options[position-side-offset]" value="'.
                Sticky_Video_WP_Admin::$stored_options['position-side-offset'].
            '"/><span class="sticky-video-wp-admin--text-input-unit">px</span>';
        echo
            '<br/>Mobile: <input type="number" style="width:5em" min="-9999" max="9999" name="sticky_video_options[position-side-offset-mobile]" value="'.
                Sticky_Video_WP_Admin::$stored_options['position-side-offset-mobile'].
            '"/><span class="sticky-video-wp-admin--text-input-unit">px</span>';

        echo '</div>';

    }

    static public function enableCloseButton_optionContent() {

        echo '<p class="sticky-video-wp-admin--free-edition-desc">Not available in free edition.</p>';

    }

    static public function transitionType_optionContent() {

        echo '<p class="sticky-video-wp-admin--free-edition-desc">Not available in free edition. Options available in Pro edition: <strong>Motion</strong>, <strong>Fade</strong>, <strong>Scale</strong></p>';

    }

    static public function advancedSection_optionContent(){}

    static public function selectingMethod_optionContent() {

        echo
            '<select name="sticky_video_options[selecting-method]">'.
                '<option '.
                    (Sticky_Video_WP_Admin::$stored_options['selecting-method'] === 'auto-select' ? 'selected' : '' )
                . ' value="auto-select">Auto select first video on page (1)</option>'.
                '<option '.
                    (Sticky_Video_WP_Admin::$stored_options['selecting-method'] === 'class' ? 'selected' : '' )
                . ' value="class">HTML class "sticky-video"(2) or "contains-sticky-video"(3) or "forced-sticky-video"(4)</option>'.
            '</select>';
        echo '<ul style="font-size:80%;line-height:1.2;"><li><sup>(1)</sup> The plugin will auto-apply stickiness to the first supported video detected in the page</li><li><sup>(2)</sup> "sticky-video": add this class to a supported video source (e.g. &lt;iframe&gt; or &lt;video&gt;) to make it stickty</li><li><sup>(3)</sup> "contains-sticky-video": add this class to a wrapper container (e.g. &lt;div&gt;) to apply stickiness to the first supported video inside the container</li><li><sup>(4)</sup> "forced-sticky-video": use this class to force stickiness to any element in the page. This class may be useful to apply stickiness to unsupported video sources.</li></ul>';

    }

    static public function disableOnMobile_optionContent() {

        echo
            '<select name="sticky_video_options[enable-on-mobile]">'.
                '<option '.
                    (Sticky_Video_WP_Admin::$stored_options['enable-on-mobile'] === 'true' ? 'selected' : '' )
                . ' value="true">Yes</option>'.
                '<option '.
                    (Sticky_Video_WP_Admin::$stored_options['enable-on-mobile'] === 'false' ? 'selected' : '' )
                . ' value="false">No</option>'.
            '</select>';

    }

    static public function mobileBreakpoint_optionContent() {

        echo
            '<input type="number" style="width:5em" min="-9999" max="9999" name="sticky_video_options[mobile-breakpoint]" value="'.
                Sticky_Video_WP_Admin::$stored_options['mobile-breakpoint'].
            '"/><span class="sticky-video-wp-admin--text-input-unit">px</span>';

    }

    static public function enableOnPause_optionContent() {

        echo
            '<select name="sticky_video_options[enable-on-pause]">'.
                '<option '.
                    (Sticky_Video_WP_Admin::$stored_options['enable-on-pause'] === 'true' ? 'selected' : '' )
                . ' value="true">Yes (stickiness always enabled)</option>'.
                '<option '.
                    (Sticky_Video_WP_Admin::$stored_options['enable-on-pause'] === 'false' ? 'selected' : '' )
                . ' value="false">No (disabled if video is not playing) (*)</option>'.
            '</select><span style="font-size:80%;line-height:1.2;"></span>';
        echo '<p style="font-size:80%;line-height:1.2;">(*) Please note: This feature only works with HTML5 videos and JavaScript players (e.g. videos from the WP Media Library). It is NOT available for iframe embedded videos.</p>';

    }

    static public function placeholderBgColor_optionContent() {

        echo
            '<input type="text" class="sticky-video-wp-admin--wp-color-picker" data-default-color="#F6F6F6" name="sticky_video_options[placeholder-bg-color]" value="'.
                Sticky_Video_WP_Admin::$stored_options['placeholder-bg-color'].
            '"/>';
        echo '<p style="font-size:80%;line-height:1.2;">Note: Further CSS customizations can be made by targeting #sticky-video--placeholder</p>';

    }

    /**
     *
     * Admin page assets
     *
     */

    static public function require_admin_assets( $hook ){

        if($hook !== 'settings_page_sticky-video') return;

        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        if( function_exists('wp_add_inline_script') ) // WP > 4.5.0
            wp_add_inline_script( 'wp-color-picker', 'jQuery(".sticky-video-wp-admin--wp-color-picker").wpColorPicker()' );
        else
            echo '<script>window.addEventListener("load",function(){ jQuery(".sticky-video-wp-admin--wp-color-picker").wpColorPicker(); });</script>';

    }

    /**
     *
     * Helpers
     *
     */

    static public function sanitize_options( $options ){
        foreach ($options as $key => $value) {
            $options[$key] = preg_replace('/[^a-zA-Z0-9 #-]+/', '', $value);
        }
        return $options;
    }

}
