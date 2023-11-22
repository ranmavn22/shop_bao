<?php
add_action('init', 'elessi_type_heading');
if (!function_exists('elessi_type_heading')) {
    function elessi_type_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $google_fonts = elessi_get_google_fonts();
        $custom_fonts = elessi_get_custom_fonts();
        
        $of_options[] = array(
            "name" => __("Typography", 'elessi-theme'),
            "target" => 'fonts',
            "type" => "heading"
        );
        
        $of_options[] = array(
            "name" => __("Font Options", 'elessi-theme'),
            "std" => "<h4>" . __("Font Options", 'elessi-theme') . "</h4>",
            "type" => "info",
            'class' => 'first'
        );
        
        $of_options[] = array(
            "name" => __("Type Font", 'elessi-theme'),
            "id" => "type_font_select",
            "std" => "google",
            "type" => "select",
            "options" => array(
                "" => __("Default font", 'elessi-theme'),
                "custom" => __("Custom font", 'elessi-theme'),
                "google" => __("Google font", 'elessi-theme')
            ),
            'class' => 'nasa-type-font'
        );

        $of_options[] = array(
            "name" => __("Heading fonts (H1, H2, H3, H4, H5, H6)", 'elessi-theme'),
            "id" => "type_headings",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => '<strong>Heading</strong><br /><span style="font-size:60%!important">UPPERCASE TEXT</span>',
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-google'
        );
        
        $of_options[] = array(
            "name" => __("RTL - Heading fonts (H1, H2, H3, H4, H5, H6)", 'elessi-theme'),
            "id" => "type_headings_rtl",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => '<strong>Heading</strong><br /><span style="font-size:60%!important">UPPERCASE TEXT</span>',
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag nasa-d-rtl nasa-type-font-glb nasa-type-font-google'
        );

        $of_options[] = array(
            "name" => __("Text fonts (paragraphs, etc..)", 'elessi-theme'),
            "id" => "type_texts",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => 'Lorem ipsum dosectetur adipisicing elit, sed do.Lorem ipsum dolor sit amet, consectetur Nulla fringilla purus at leo dignissim congue. Mauris elementum accumsan leo vel tempor. Sit amet cursus nisl aliquam. Aliquam et elit eu nunc rhoncus viverra quis at felis..',
                "size" => "14px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-google'
        );
        
        $of_options[] = array(
            "name" => __("RTL - Text fonts (paragraphs, etc..)", 'elessi-theme'),
            "id" => "type_texts_rtl",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => 'Lorem ipsum dosectetur adipisicing elit, sed do.Lorem ipsum dolor sit amet, consectetur Nulla fringilla purus at leo dignissim congue. Mauris elementum accumsan leo vel tempor. Sit amet cursus nisl aliquam. Aliquam et elit eu nunc rhoncus viverra quis at felis..',
                "size" => "14px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag nasa-d-rtl nasa-type-font-glb nasa-type-font-google'
        );

        $of_options[] = array(
            "name" => __("Main navigation", 'elessi-theme'),
            "id" => "type_nav",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => "<span style='font-size:45%'>THIS IS THE TEXT.</span>",
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-google'
        );
        
        $of_options[] = array(
            "name" => __("RTL - Main navigation", 'elessi-theme'),
            "id" => "type_nav_rtl",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => "<span style='font-size:45%'>THIS IS THE TEXT.</span>",
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag nasa-d-rtl nasa-type-font-glb nasa-type-font-google'
        );

        $of_options[] = array(
            "name" => __("Banner font", 'elessi-theme'),
            "id" => "type_banner",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => 'This is the text.',
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-google'
        );
        
        $of_options[] = array(
            "name" => __("RTL - Banner font", 'elessi-theme'),
            "id" => "type_banner_rtl",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => 'This is the text.',
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag nasa-d-rtl nasa-type-font-glb nasa-type-font-google'
        );
        
        $of_options[] = array(
            "name" => __("Price font", 'elessi-theme'),
            "id" => "type_price",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => "$999",
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-google'
        );
        
        $of_options[] = array(
            "name" => __("RTL - Price font", 'elessi-theme'),
            "id" => "type_price_rtl",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => "$999",
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag nasa-d-rtl nasa-type-font-glb nasa-type-font-google'
        );
        
        $of_options[] = array(
            "name" => __("Font Weight", 'elessi-theme'),
            "id" => "max_font_weight",
            "std" => '',
            "type" => "select",
            "options" => array(
                '' => __("Default", 'elessi-theme'),
                '800' => __("Bold - 800", 'elessi-theme'),
                '700' => __("Bold - 700", 'elessi-theme'),
                '600' => __("Bold - 600", 'elessi-theme'),
                '500' => __("Bold - 500", 'elessi-theme')
            ),
            'override_numberic' => true
        );

        $of_options[] = array(
            "name" => __("Character Sub-sets", 'elessi-theme'),
            "id" => "type_subset",
            "std" => array("latin"),
            "type" => "multicheck",
            "options" => array(
                "latin"         => __("Latin", 'elessi-theme'),
                "latin-ext"     => __("Latin Extended", 'elessi-theme'),
                "arabic"        => __("Arabic", 'elessi-theme'),
                "cyrillic"      => __("Cyrillic", 'elessi-theme'),
                "cyrillic-ext"  => __("Cyrillic Extended", 'elessi-theme'),
                "greek"         => __("Greek", 'elessi-theme'),
                "greek-ext"     => __("Greek Extended", 'elessi-theme'),
                "vietnamese"    => __("Vietnamese", 'elessi-theme'),
            ),
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-google'
        );
        
        $of_options[] = array(
            "name" => __("Upload Custom Font", 'elessi-theme'),
            "std" => "",
            "type" => "nasa_upload_custom_font",
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-custom'
        );
        
        $of_options[] = array(
            "name" => __("Select Custom Font", 'elessi-theme'),
            "id" => "custom_font",
            "std" => "",
            "type" => "select",
            "options" => $custom_fonts,
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-custom'
        );
        
        $of_options[] = array(
            "name" => __("RTL - Select Custom Font", 'elessi-theme'),
            "id" => "custom_font_rtl",
            "std" => "",
            "type" => "select",
            "options" => $custom_fonts,
            'class' => 'hidden-tag nasa-type-font-glb nasa-type-font-custom'
        );
        
        $of_options[] = array(
            "name" => __("Minify Fonts Icons", 'elessi-theme'),
            "id" => "minify_font_icons",
            "std" => 1,
            "type" => "switch",
            "desc" => "Include: Font Nasa Icons, Font Awesome 4.7.0, Font Pe-icon-7-stroke"
        );
        
        $of_options[] = array(
            "name" => __("Preload Fonts Icons", 'elessi-theme'),
            "id" => "preload_font_icons",
            "std" => 1,
            "type" => "switch",
            "desc" => "Preload: Font Nasa Icons, Font Awesome 4.7.0, Font Pe-icon-7-stroke"
        );
        
        $of_options[] = array(
            "name" => __("Include FontAwesome 5 (Note: You only can use Free icons)", 'elessi-theme'),
            "id" => "include_font_awesome_new",
            "std" => 0,
            "type" => "switch"
        );
    }
}
