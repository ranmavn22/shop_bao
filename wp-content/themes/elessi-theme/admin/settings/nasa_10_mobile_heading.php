<?php
add_action('init', 'elessi_mobile_heading');
if (!function_exists('elessi_mobile_heading')) {
    function elessi_mobile_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $static_blocks = elessi_admin_get_static_blocks();
        
        $of_options[] = array(
            "name" => __("Mobile Layout", 'elessi-theme'),
            "target" => "mobile-layout",
            "type" => "heading"
        );
        
        $of_options[] = array(
            "name" => __("Global Options", 'elessi-theme'),
            "std" => "<h4>" . __("Global Options", 'elessi-theme') . "</h4>",
            "type" => "info",
            'class' => 'first'
        );
        
        $of_options[] = array(
            "name" => __('Enable Mobile Layout', 'elessi-theme'),
            "id" => "enable_nasa_mobile",
            "std" => 0,
            "type" => "switch",
            'desc' => __('Not only is layout responsive, but also the theme uses the device detect technology to switch the web layout compatible on each type of user device', 'elessi-theme')
        );

        $of_options[] = array(
            "name" => __("Mobile Layout Mode", 'elessi-theme'),
            "id" => "mobile_layout",
            "std" => "df",
            "type" => "select",
            "options" => array(
                "df" => __("Default", 'elessi-theme'),
                "app" => __("App Simulation", 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => __("Mobile Bottom Bar Options", 'elessi-theme'),
            "std" => "<h4>" . __("Mobile Bottom Bar Options", 'elessi-theme') . "</h4>",
            "type" => "info"
        );
        
        /**
         * On | Off Mobile Bottom Bar
         */
        $of_options[] = array(
            "name" => __("Mobile Bottom Bar", 'elessi-theme'),
            "id" => "m_bot_bar",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => __("Mobile Bottom Bar Content", 'elessi-theme'),
            "desc" => __("Please create Static Blocks (or Custom Block of Elementor Header & Footer Builder) and select here.", 'elessi-theme'),
            "id" => "m_bot_bar_ct",
            "type" => "select",
            "options" => $static_blocks
        );
        
    }
}
