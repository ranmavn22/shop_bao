<?php
defined('ABSPATH') or die(); // Exit if accessed directly

add_action('init', 'nasa_custom_option_themes', 11);
function nasa_custom_option_themes() {
    global $of_options;
    if (empty($of_options)) {
        $of_options = array();
    }
    
    if (NASA_WOO_ACTIVED) {
        /**
         * Variations Swatches
         */
        $of_options = nasa_options_variation_swatches($of_options);
    
        /**
         * WooCommerce Open
         */
        $of_options = nasa_options_woo_open($of_options);
    
        /**
         * Promote Sales
         */
        $of_options = nasa_options_promote_sales($of_options);
    
        /**
         * Brand Product
         */
        $of_options = nasa_options_brand_product($of_options);
    
        /**
         * Group Product
         */
        $of_options = nasa_options_group_product($of_options);
    }

    /**
     * Shares and follows
     */
    $of_options = nasa_options_share_follow($of_options);
    
    /**
     * Mobile Detect - Caching - etc..
     */
    $of_options = nasa_options_global_nasa_core($of_options);
    
    /**
     * Portfolio - Project
     */
    $of_options = nasa_options_portfolio($of_options);
}

/**
 * Color - Label (Size) - Image Swatches
 */
function nasa_options_variation_swatches($of_options = array()) {
    $of_options[] = array(
        "name" => __("Variation Swatches", 'nasa-core'),
        "target" => 'nasa-variation-swatches',
        "type" => "heading"
    );

    $of_options[] = array(
        "name" => __('Enable UX Variations (Color - Label (Size) - Image Swatches)', 'nasa-core'),
        "id" => "enable_nasa_variations_ux",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __('UX Variations in Grid - Loop', 'nasa-core'),
        "id" => "nasa_variations_ux_item",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __('Add To Cart UX Variations in Grid', 'nasa-core'),
        "id" => "nasa_variations_ux_add_to_cart_grid",
        "std" => 1,
        "type" => "switch"
    );

    $of_options[] = array(
        "name" => __('Attributes - the type "Select", "Custom" in Grid', 'nasa-core'),
        "id" => "enable_nasa_ux_select",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __('Show the first item - Type Select, Custom', 'nasa-core'),
        "id" => "show_nasa_ux_select_first",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __('Load UX Variations in Grid After Click', 'nasa-core'),
        "id" => "nasa_variations_after",
        "std" => "",
        "type" => "select",
        "options" => array(
            "" => __("None", 'nasa-core'),
            "select" => __("Select Options", 'nasa-core'),
            "badge" => __("Badge Variants", 'nasa-core')
        )
    );
    
    // limit_show num of 1 variation
    $of_options[] = array(
        "name" => __('Limit in Product Grid', 'nasa-core'),
        "desc" => __('Limit show variations/1 attribute in product grid. Empty input to show all', 'nasa-core'),
        "id" => "limit_nasa_variations_ux",
        "std" => "3",
        "type" => "text"
    );
    
    // More - Less items
    $of_options[] = array(
        "name" => __('Show Less, More Items', 'nasa-core'),
        "desc" => __('Show Less, Show More variation items', 'nasa-core'),
        "id" => "nasa_ux_less_more",
        "std" => 0,
        "type" => "switch"
    );

    $of_options[] = array(
        "name" => __("Image Attribute Style - All", 'nasa-core'),
        "id" => "nasa_attr_image_style",
        "std" => "round",
        "type" => "select",
        "options" => array(
            "round" => __("Round", 'nasa-core'),
            "square" => __("Square", 'nasa-core')
        )
    );
    
    $of_options[] = array(
        "name" => __("Image Attribute Style - Only use for Single or Quickview", 'nasa-core'),
        "id" => "nasa_attr_image_single_style",
        "std" => "extends",
        "type" => "select",
        "options" => array(
            "extends" => __("Extends from Image Attribute Style - All", 'nasa-core'),
            "square-caption" => __("Square has Caption", 'nasa-core')
        )
    );
    
    $of_options[] = array(
        "name" => __("Color Attribute Style - Only use for Single or Quickview", 'nasa-core'),
        "id" => "nasa_attr_color_style",
        "std" => "radio",
        "type" => "select",
        "options" => array(
            "radio" => __("Radio Style - Tooltip", 'nasa-core'),
            "round" => __("Round Wrapper - Tooltip", 'nasa-core'),
            "small-square" => __("Small Square", 'nasa-core'),
            "big-square" => __("Big Square", 'nasa-core')
        )
    );
    
    $of_options[] = array(
        "name" => __("Label Attribute Style - Only use for Single or Quickview", 'nasa-core'),
        "id" => "nasa_attr_label_style",
        "std" => "radio",
        "type" => "select",
        "options" => array(
            "radio" => __("Radio Style", 'nasa-core'),
            "round" => __("Round Wrapper", 'nasa-core'),
            "small-square-1" => __("Small Square 1", 'nasa-core'),
            "small-square-2" => __("Small Square 2", 'nasa-core'),
            "big-square" => __("Big Square", 'nasa-core')
        )
    );

    $of_options[] = array(
        "name" => __('Gallery for Variation', 'nasa-core'),
        "id" => "gallery_images_variation",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __('Label Attribute Selected - Single / Quick view Product', 'nasa-core'),
        "id" => "label_attribute_single",
        "std" => 0,
        "type" => "switch"
    );
    
    return $of_options;
}

/**
 * WooCommerce Open
 */
function nasa_options_woo_open($of_options = array()) {
    $contact_forms = nasa_get_contact_form7();
    
    $blocks = nasa_get_blocks_options();
    if (isset($blocks['-1'])) {
        unset($blocks['-1']);
    }
    
    $of_options[] = array(
        "name" => __("WooCommerce Extended", 'nasa-core'),
        "target" => 'nasa-option-woo-open',
        "type" => "heading",
    );
    
    $of_options[] = array(
        "name" => __("General", 'nasa-core'),
        "std" => "<h4>" . __("General", 'nasa-core') . "</h4>",
        "type" => "info",
        'class' => 'first'
    );
    
    $of_options[] = array(
        "name" => __("Product 360&#176; Viewer", 'nasa-core'),
        "id" => "product_360_degree",
        "std" => '1',
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __("360&#176; Viewer Badge In Grid", 'nasa-core'),
        "id" => "nasa_badge_360",
        "std" => '0',
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __("Video Badge In Grid", 'nasa-core'),
        "id" => "nasa_badge_video",
        "std" => '0',
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __("Size Guide - Single Product Page", 'nasa-core'),
        "id" => "size_guide_product",
        "type" => "select",
        "options" => $blocks,
        "desc" => __("Please create Static Blocks (or Custom Block of Elementor Header & Footer Builder) and select here.", 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => __("Delivery &#38; Return - Single Product Page", 'nasa-core'),
        "id" => "delivery_return_single_product",
        "type" => "select",
        "options" => $blocks,
        "desc" => __("Please create Static Blocks (or Custom Block of Elementor Header & Footer Builder) and select here.", 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => __("Ask a Question - Single Product Page", 'nasa-core'),
        "id" => "ask_a_question",
        "type" => "select",
        'override_numberic' => true,
        "options" => $contact_forms
    );
    
    $of_options[] = array(
        "name" => __("Request a Call Back - Single Product Page", 'nasa-core'),
        "id" => "request_a_callback",
        "type" => "select",
        'override_numberic' => true,
        "options" => $contact_forms
    );
    
    $of_options[] = array(
        "name" => __("After Single Product Add To Cart Form", 'nasa-core'),
        "id" => "after_single_addtocart_form",
        "type" => "select",
        "options" => $blocks,
        "desc" => __("Please create Static Blocks (or Custom Block of Elementor Header & Footer Builder) and select here.", 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => __("After Process Checkout Button - Shopping Cart", 'nasa-core'),
        "id" => "after_process_checkout",
        "type" => "select",
        "options" => $blocks,
        "desc" => __("Please create Static Blocks (or Custom Block of Elementor Header & Footer Builder) and select here.", 'nasa-core'),
    );
    
    // woocommerce_after_cart_table
    $of_options[] = array(
        "name" => __("After Cart Table - Shopping Cart", 'nasa-core'),
        "id" => "after_cart_table",
        "type" => "select",
        "options" => $blocks,
        "desc" => __("Please create Static Blocks (or Custom Block of Elementor Header & Footer Builder) and select here.", 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => __("After Cart Content - Shopping Cart", 'nasa-core'),
        "id" => "after_cart",
        "type" => "select",
        "options" => $blocks,
        "desc" => __("Please create Static Blocks (or Custom Block of Elementor Header & Footer Builder) and select here.", 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => __("After Customer Details - Checkout", 'nasa-core'),
        "id" => "after_checkout_customer",
        "type" => "select",
        "options" => $blocks,
        "desc" => __("Please create Static Blocks (or Custom Block of Elementor Header & Footer Builder) and select here.", 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => __("After Place Order Button - Checkout", 'nasa-core'),
        "id" => "after_place_order",
        "type" => "select",
        "options" => $blocks,
        "desc" => __("Please create Static Blocks (or Custom Block of Elementor Header & Footer Builder) and select here.", 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => __("After Review Order Payment - Checkout", 'nasa-core'),
        "id" => "after_review_order",
        "type" => "select",
        "options" => $blocks,
        "desc" => __("Please create Static Blocks (or Custom Block of Elementor Header & Footer Builder) and select here.", 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => __("Recommended In Archive Products", 'nasa-core'),
        "std" => "<h4>" . __("Recommended In Archive Products Page", 'nasa-core') . "</h4>",
        "type" => "info"
    );
    
    /**
     * Recommended - Viewed Products
     */
    $of_options[] = array(
        "name" => __("Enable", 'nasa-core'),
        "id" => "enable_recommend_product",
        "std" => "1",
        "type" => "switch"
    );

    $of_options[] = array(
        "name" => __("Limit", 'nasa-core'),
        "id" => "recommend_product_limit",
        "std" => "9",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => __("Desktop Columns", 'nasa-core'),
        "id" => "recommend_columns_desk",
        "std" => "5-cols",
        "type" => "select",
        "options" => array(
            "6-cols" => __("6 columns", 'nasa-core'),
            "5-cols" => __("5 columns", 'nasa-core'),
            "4-cols" => __("4 columns", 'nasa-core'),
            "3-cols" => __("3 columns", 'nasa-core'),
            "2-cols" => __("2 columns", 'nasa-core'),
        )
    );

    $of_options[] = array(
        "name" => __("Mobile Columns", 'nasa-core'),
        "id" => "recommend_columns_small",
        "std" => "2-cols",
        "type" => "select",
        "options" => array(
            "2-cols" => __("2 columns", 'nasa-core'),
            "1.5-cols" => __("1.5 column", 'nasa-core'),
            "1-col" => __("1 column", 'nasa-core'),
        )
    );

    $of_options[] = array(
        "name" => __("Tablet Columns", 'nasa-core'),
        "id" => "recommend_columns_tablet",
        "std" => "3-cols",
        "type" => "select",
        "options" => array(
            "4-cols" => __("4 columns", 'nasa-core'),
            "3-cols" => __("3 columns", 'nasa-core'),
            "2-cols" => __("2 columns", 'nasa-core'),
        )
    );

    $of_options[] = array(
        "name" => __("Position", 'nasa-core'),
        "id" => "recommend_product_position",
        "std" => "bot",
        "type" => "select",
        "options" => array(
            "top" => __("Top", 'nasa-core'),
            "bot" => __("Bottom", 'nasa-core')
        )
    );
    
    $of_options[] = array(
            "name" => __("Auto Slide", 'nasa-core'),
            "id" => "recommend_slide_auto",
            "std" => 0,
            "type" => "switch"
        );

    $of_options[] = array(
        "name" => __("Infinite Slide", 'nasa-core'),
        "id" => "infinite_slide",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __("Viewed Products", 'nasa-core'),
        "std" => "<h4>" . __("Viewed Products", 'nasa-core') . "</h4>",
        "type" => "info"
    );
    
    $of_options[] = array(
        "name" => __("Enable", 'nasa-core'),
        "id" => "enable-viewed",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __("Viewed Sidebar Off-Canvas", 'nasa-core'),
        "id" => "viewed_canvas",
        "std" => 1,
        "type" => "switch"
    );

    $of_options[] = array(
        "name" => __("Limit", 'nasa-core'),
        "id" => "limit_product_viewed",
        "std" => "12",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => __("Icon Viewed Style", 'nasa-core'),
        "id" => "style-viewed-icon",
        "std" => "style-1",
        "type" => "select",
        "options" => array(
            'style-1' => __('Light', 'nasa-core'),
            'style-2' => __('Dark', 'nasa-core')
        )
    );

    $of_options[] = array(
        "name" => __("Sidebar Layout", 'nasa-core'),
        "id" => "style-viewed",
        "std" => "style-1",
        "type" => "select",
        "options" => array(
            'style-1' => __('Light', 'nasa-core'),
            'style-2' => __('Dark', 'nasa-core')
        )
    );
    
    $of_options[] = array(
        "name" => __("Personalize product", 'nasa-core'),
        "std" => "<h4>" . __("Personalize product", 'nasa-core') . "</h4>",
        "type" => "info"
    );
    
    $of_options[] = array(
        "name" => __("Enable", 'nasa-core'),
        "id" => "enable_personalize",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __("List Font Types for Personalize product", 'nasa-core'),
        "id" => "personalize_font_types",
        "std" => 'Font One, Font Two, Font Three, Font Four',
        "type" => "textarea",
        "desc" => __('Separated by ", "', 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => __("List Font Colours for Personalize product", 'nasa-core'),
        "id" => "personalize_font_colours",
        "std" => 'Black, White, Silver, Gold',
        "type" => "textarea",
        "desc" => __('Separated by ", "', 'nasa-core'),
    );
    
    return $of_options;
}

/**
 * Promote Sales
 */
function nasa_options_promote_sales($of_options = array()) {
    $of_options[] = array(
        "name" => __("Promote Sales", 'nasa-core'),
        "target" => 'nasa-option-promote-sales',
        "type" => "heading"
    );
    
    /**
     * Bulk Discount
     */
    $of_options[] = array(
        "name" => __("Bulk Discounts", 'nasa-core'),
        "std" => "<h4>" . __("Bulk Discounts", 'nasa-core') . "</h4>",
        "type" => "info",
        'class' => 'first'
    );
    
    $of_options[] = array(
        "name" => __("Enable", 'nasa-core'),
        "id" => "bulk_dsct",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __("Bulk Discounts Badge", 'nasa-core'),
        "id" => "bulk_dsct_badge",
        "std" => "0",
        "type" => "switch"
    );
    
    /**
     * Fake Sold
     */
    $of_options[] = array(
        "name" => __("Fake Sold", 'nasa-core'),
        "std" => "<h4>" . __("Fake Sold", 'nasa-core') . "</h4>",
        "type" => "info"
    );
    
    $of_options[] = array(
        "name" => __("Enable", 'nasa-core'),
        "id" => "fake_sold",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __("Min Fake Sold", 'nasa-core'),
        "id" => "min_fake_sold",
        "std" => "1",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => __("Max Fake Sold", 'nasa-core'),
        "id" => "max_fake_sold",
        "std" => "20",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => __("Min Fake Time (number hours ago)", 'nasa-core'),
        "id" => "min_fake_time",
        "std" => "1",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => __("Max Fake Time (number hours ago)", 'nasa-core'),
        "id" => "max_fake_time",
        "std" => "20",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => __("Live Time Fake (s)", 'nasa-core'),
        "id" => "fake_time_live",
        "std" => "36000",
        "type" => "text",
        "desc" => '<a href="javascript:void(0);" class="button-primary nasa-clear-fake-sold-cache" data-ok="' . esc_attr__('Reset Fake Sold Success !', 'nasa-core') . '" data-miss="' . esc_attr__('Fake Sold is Empty!', 'nasa-core') . '" data-fail="' . esc_attr__('Error!', 'nasa-core') . '">' . esc_html__('Reset Fake Sold', 'nasa-core') . '</a><span class="nasa-admin-loader hidden-tag"><img src="' . NASA_CORE_PLUGIN_URL . 'admin/assets/ajax-loader.gif" /></span>',
    );

    /**
     * Fake in cart
     */
    $of_options[] = array(
        "name" => __("Fake Number Of Products In Cart", 'nasa-core'),
        "std" => "<h4>" . __("Fake In Cart", 'nasa-core') . "</h4>",
        "type" => "info"
    );

    $of_options[] = array(
        "name" => __("Enable", 'nasa-core'),
        "id" => "fake_in_cart",
        "std" => 0,
        "type" => "switch"
    );

    $of_options[] = array(
        "name" => __("Min - Fake In Cart", 'nasa-core'),
        "id" => "min_fake_in_cart",
        "std" => "1",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => __("Max - Fake In Cart", 'nasa-core'),
        "id" => "max_fake_in_cart",
        "std" => "20",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => __("Live Time Fake (s)", 'nasa-core'),
        "id" => "fake_in_cart_time_live",
        "std" => "36000",
        "type" => "text",
        "desc" => '<a href="javascript:void(0);" class="button-primary nasa-clear-fake-incart-cache" data-ok="' . esc_attr__('Reset Fake In Cart Success !', 'nasa-core') . '" data-miss="' . esc_attr__('Fake In Cart is Empty!', 'nasa-core') . '" data-fail="' . esc_attr__('Error!', 'nasa-core') . '">' . esc_html__('Reset Fake In Cart', 'nasa-core') . '</a><span class="nasa-admin-loader hidden-tag"><img src="' . NASA_CORE_PLUGIN_URL . 'admin/assets/ajax-loader.gif" /></span>',
    );
    
    /* Estimated Delivery */
    $of_options[] = array(
        "name" => __("Estimated Delivery", 'nasa-core'),
        "std" => "<h4>" . __("Estimated Delivery", 'nasa-core') . "</h4>",
        "type" => "info"
    );
    
    $of_options[] = array(
        "name" => __("Enable", 'nasa-core'),
        "id" => "est_delivery",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __("From - Estimated Days", 'nasa-core'),
        "id" => "min_est_delivery",
        "std" => "3",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => __("To - Estimated Days", 'nasa-core'),
        "id" => "max_est_delivery",
        "std" => "7",
        "type" => "text"
    );
    
    /* Fake viewing */
    $of_options[] = array(
        "name" => __("Fake Viewing", 'nasa-core'),
        "std" => "<h4>" . __("Fake Viewing", 'nasa-core') . "</h4>",
        "type" => "info"
    );
    
    $of_options[] = array(
        "name" => __("Enable", 'nasa-core'),
        "id" => "fake_view",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __("Begin - Min Counter", 'nasa-core'),
        "id" => "min_fake_view",
        "std" => "10",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => __("Begin - Max Counter", 'nasa-core'),
        "id" => "max_fake_view",
        "std" => "50",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => __("Change Time Delay (s)", 'nasa-core'),
        "id" => "delay_time_view",
        "std" => "15",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => __("Max Change", 'nasa-core'),
        "id" => "max_change_view",
        "std" => "5",
        "type" => "text"
    );
    
    /**
     * Fake Purchase
     */
    $of_options[] = array(
        "name" => __("Fake Purchased", 'nasa-core'),
        "std" => "<h4>" . __("Fake Purchased", 'nasa-core') . "</h4>",
        "type" => "info"
    );

    $of_options[] = array(
        "name" => __("Enable", 'nasa-core'),
        "id" => "fake_purchase",
        "std" => 0,
        "type" => "switch",
        "desc" => '<p class="red-color">' . __("Note: This feature does not apply to mobiles or devices with small screens", 'nasa-core') . '</p>',
    );

    $of_options[] = array(
        "name" => __("Products Fake Purchase", 'nasa-core'),
        "id" => "fake_purchase_ct",
        "std" => '',
        "type" => "fake_purchases"
    );
    
    return $of_options;
}

/**
 * Brand Products
 */
function nasa_options_brand_product($of_options = array()) {
    $of_options[] = array(
        "name" => __("Product Brands", 'nasa-core'),
        "target" => 'nasa-option-brand-products',
        "type" => "heading"
    );
    
    $of_options[] = array(
        "name" => __("Product Brand - Taxonomies", 'nasa-core'),
        "std" => "<h4>" . __("Turn On Product Brand - Taxonomies", 'nasa-core') . "</h4>",
        "type" => "info",
        'class' => 'first'
    );
    
    $of_options[] = array(
        "name" => __('Enable', 'nasa-core'),
        "id" => "enable_nasa_brands",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __('Display brand on product Grid', 'nasa-core'),
        "id" => "loop_brands",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __("Using Image Attributes To Do Brands", 'nasa-core'),
        "std" => "<h4>" . __("Using Image Attributes To Do Brands", 'nasa-core') . "</h4>",
        "type" => "info"
    );
    
    $brands = Nasa_Abstract_WC_Attr_UX::get_tax_images_to_brands();
    $of_options[] = array(
        "name" => __("Image Attributes To Do Brands", 'nasa-core'),
        "id" => "attr_brands",
        "std" => array(),
        "type" => "multicheck",
        "options" => $brands,
        'desc' => $brands ? '' : __("Please create a Product Attribute type Image to use this feature.", 'nasa-core'),
    );
    
    return $of_options;
}

/**
 * Group Products
 */
function nasa_options_group_product($of_options = array()) {
    $of_options[] = array(
        "name" => __("Product Group", 'nasa-core'),
        "target" => 'nasa-option-group-products',
        "type" => "heading"
    );
    
    $of_options[] = array(
        "name" => __('Enable', 'nasa-core'),
        "id" => "enable_nasa_custom_categories",
        "std" => 0,
        "type" => "switch"
    );
    
    $std_group = get_option('nasa_custom_categories_slug', 'nasa_product_cat');
    $of_options[] = array(
        "name" => __("Slug of Products Group", 'nasa-core'),
        "id" => "nasa_custom_categories_slug",
        "std" => $std_group,
        "type" => "ajax_field",
        "action" => "nasa_change_slug_group"
    );
    
    $of_options[] = array(
        "name" => __('Enable in Archive Products', 'nasa-core'),
        "id" => "archive_product_nasa_custom_categories",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __("Max Deep in Archive Products Page", 'nasa-core'),
        "id" => "max_level_nasa_custom_categories",
        "std" => "3-levels",
        "type" => "select",
        "options" => array(
            "1-level" => __("1 level", 'nasa-core'),
            "2-levels" => __("2 levels", 'nasa-core'),
            "3-levels" => __("3 levels", 'nasa-core')
        )
    );
    
    return $of_options;
}

/**
 * Share and Follow
 */
function nasa_options_share_follow($of_options = array()) {
    $of_options[] = array(
        "name" => __("Share & Follow", 'nasa-core'),
        "target" => 'nasa-option-share-follow',
        "type" => "heading"
    );
    
    $of_options[] = array(
        "name" => __("Options Shares", 'nasa-core'),
        "std" => "<h4>" . __("Options Shares", 'nasa-core') . "</h4>",
        "type" => "info",
        'class' => 'first'
    );

    $of_options[] = array(
        "name" => __("Share Icons", 'nasa-core'),
        "desc" => __("Select icons to be shown on share icons on product page, blog page and [share] shortcode", 'nasa-core'),
        "id" => "social_icons",
        "std" => array(),
        "type" => "multicheck",
        "options" => array(
            "facebook" => __("Facebook", 'nasa-core'),
            "twitter" => __("X", 'nasa-core'),
            "pinterest" => __("Pinterest", 'nasa-core'),
            "linkedin" => __("Linkedin", 'nasa-core'),
            "telegram" => __("Telegram", 'nasa-core'),
            "whatsapp" => __("WhatsApp", 'nasa-core'),
            // "viber" => __("Viber", 'nasa-core'),
            "vk" => __("VK", 'nasa-core'),
            "email" => __("Email", 'nasa-core')
        )
    );
    
    $of_options[] = array(
        "name" => __('Share in Single Product Page', 'nasa-core'),
        "id" => "ns_share_spp",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __("Options Follows", 'nasa-core'),
        "std" => "<h4>" . __("Options Follows", 'nasa-core') . "</h4>",
        "type" => "info"
    );

    $of_options[] = array(
        "name" => __("Facebook URL Follow", 'nasa-core'),
        "id" => "facebook_url_follow",
        "std" => "",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => __("VK URL Follow", 'nasa-core'),
        "id" => "vk_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => __("X URL Follow", 'nasa-core'),
        "id" => "twitter_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => __("Email URL", 'nasa-core'),
        "id" => "email_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => __("Pinterest URL Follow", 'nasa-core'),
        "id" => "pinterest_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => __("Instagram URL Follow", 'nasa-core'),
        "id" => "instagram_url",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => __("RSS URL Follow", 'nasa-core'),
        "id" => "rss_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => __("Linkedin URL Follow", 'nasa-core'),
        "id" => "linkedin_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => __("Youtube URL Follow", 'nasa-core'),
        "id" => "youtube_url_follow",
        "std" => "",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => __("Tumblr URL Follow", 'nasa-core'),
        "id" => "tumblr_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => __("Flickr URL Follow", 'nasa-core'),
        "id" => "flickr_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => __("Telegram URL Follow", 'nasa-core'),
        "id" => "telegram_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => __("Whatsapp URL Follow", 'nasa-core'),
        "id" => "whatsapp_url_follow",
        "std" => "",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => __("Tiktok URL Follow", 'nasa-core'),
        "id" => "tiktok_url_follow",
        "std" => "",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => __("Weibo URL Follow", 'nasa-core'),
        "id" => "weibo_url_follow",
        "std" => "",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => __("Amazon URL", 'nasa-core'),
        "id" => "amazon_url_follow",
        "std" => "",
        "type" => "text"
    );
    
    return $of_options;
}

/**
 * Global Option Nasa Core
 */
function nasa_options_global_nasa_core($of_options = array()) {
    $of_options[] = array(
        "name" => __("Core Options", 'nasa-core'),
        "target" => 'nasa-option',
        "type" => "heading"
    );
    
    $of_options[] = array(
        "name" => __('Cache Files', 'nasa-core'),
        "id" => "enable_nasa_cache",
        "std" => 1,
        "type" => "switch",
        "desc" => '<strong class="red-color">' . __("Please don't turn off with this option to increase website performance", 'nasa-core') . '</strong>',
    );
    
    $of_options[] = array(
        "name" => __("Cache Mode", 'nasa-core'),
        "id" => "nasa_cache_mode",
        "std" => "file",
        "type" => "select",
        "options" => array(
            "file" => __("Files - directory uploads / nasa-caches", 'nasa-core'),
            "transient" => __("Transients - of default Wordpress", 'nasa-core')
        )
    );
    
    $of_options[] = array(
        "name" => __('Cache Shortcodes (Apply with Cache Files)', 'nasa-core'),
        "id" => "nasa_cache_shortcodes",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __('Cache Quickview (Apply with Cache Files)', 'nasa-core'),
        "id" => "nasa_cache_qv",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __('Cache Variable Loop Products (Apply with Cache Files)', 'nasa-core'),
        "id" => "nasa_cache_variables",
        "std" => 1,
        "type" => "switch",
        "desc" => '<strong class="red-color">' . __("Please don't turn off with this option to increase website performance", 'nasa-core') . '</strong>',
    );
    
    $of_options[] = array(
        "name" => __('Expire Time (Seconds - Expire time live file.)', 'nasa-core'),
        "desc" => '<a href="javascript:void(0);" class="button-primary nasa-clear-themes-cache" data-ok="' . esc_attr__('Clear Cache Success !', 'nasa-core') . '" data-miss="' . esc_attr__('Cache Empty!', 'nasa-core') . '" data-fail="' . esc_attr__('Error!', 'nasa-core') . '">' . esc_html__('Clear Cache', 'nasa-core') . '</a><span class="nasa-admin-loader hidden-tag"><img src="' . NASA_CORE_PLUGIN_URL . 'admin/assets/ajax-loader.gif" /></span>',
        "id" => "nasa_cache_expire",
        "std" => '36000',
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => __('WP Smilies', 'nasa-core'),
        "id" => "enable_use_smilies",
        "std" => 0,
        "type" => "switch",
        'desc' => '<a href="https://wordpress.org/documentation/article/what-are-smilies/" target="_blank">What are smilies?</a>'
    );
    
    $of_options[] = array(
        "name" => __('CDN Media', 'nasa-core'),
        "id" => "enable_nasa_cdn_images",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __('CDN CNAME.', 'nasa-core'),
        "desc" => __('Input CNAME. It will be replaced for home URL of images your site. (Ex: https://elessi-cdn.nasatheme.com)', 'nasa-core'),
        "id" => "nasa_cname_images",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => __("Effect Pin Space (Pin Banner)", 'nasa-core'),
        "id" => "effect_pin_product_banner",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __("Optimize HTML", 'nasa-core'),
        "id" => "tmpl_html",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => __('Support Menu - Description', 'nasa-core'),
        "id" => "ns_menu_desc",
        "std" => 0,
        "type" => "switch",
        // 'desc' => __('Not only is layout responsive, but also the theme uses the device detect technology to switch the web layout compatible on each type of user device', 'nasa-core')
    );
    
    /**
     * Site Offline
     */
    $of_options[] = array(
        "name" => __("Site Mode Options", 'nasa-core'),
        "std" => "<h4>" . __("Site Mode Options", 'nasa-core') . "</h4>",
        "type" => "info"
    );

    $of_options[] = array(
        "name" => __("Site Offline", 'nasa-core'),
        "id" => "site_offline",
        "std" => 0,
        "type" => "switch"
    );

    $of_options[] = array(
        "name" => __("Coming Soon Tittle", 'nasa-core'),
        "id" => "coming_soon_title",
        "std" => "Comming Soon",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => __("Coming Soon Info", 'nasa-core'),
        "id" => "coming_soon_info",
        "std" => "Condimentum ipsum a adipiscing hac dolor set consectetur urna commodo elit parturient<br />a molestie ut nisl partu cl vallier ullamcorpe",
        "type" => "textarea"
    );

    $of_options[] = array(
        "name" => __("Coming Soon Image", 'nasa-core'),
        "id" => "coming_soon_img",
        "std" => NASA_CORE_PLUGIN_URL . "/assets/images/comming-soon.jpg",
        "type" => "media"
    );

    $of_options[] = array(
        "name" => __("Coming Soon Time", 'nasa-core'),
        "id" => "coming_soon_time",
        "desc" => __("Please enter a time to return the site to Online (YYYY/mm/dd | YYYY-mm-dd).", 'nasa-core'),
        "std" => "",
        "type" => "text"
    );
    
    return $of_options;
}

/**
 * Portfolio - Project
 */
function nasa_options_portfolio($of_options = array()) {
    $of_options[] = array(
        "name" => __("Portfolio", 'nasa-core'),
        "target" => 'portfolio',
        "type" => "heading"
    );

    $of_options[] = array(
        "name" => __("Enable Portfolio", 'nasa-core'),
        "id" => "enable_portfolio",
        "std" => 1,
        "type" => "switch"
    );

    /* $of_options[] = array(
        "name" => __("Page view Portfolio", 'nasa-core'),
        "id" => "nasa-page-view-portfolio",
        "type" => "select",
        "options" => elessi_get_pages_temp_portfolio()
    ); */

    $of_options[] = array(
        "name" => __("Recent Projects", 'nasa-core'),
        "id" => "recent_projects",
        "std" => 1,
        "type" => "switch"
    );
    $of_options[] = array(
        "name" => __("Portfolio Comments", 'nasa-core'),
        "id" => "portfolio_comments",
        "std" => 1,
        "type" => "switch"
    );
    $of_options[] = array(
        "name" => __("Portfolio Count", 'nasa-core'),
        "id" => "portfolio_count",
        "std" => 10,
        "type" => "text"
    );
    $of_options[] = array(
        "name" => __("Project Category", 'nasa-core'),
        "id" => "project_byline",
        "std" => 1,
        "type" => "switch"
    );
    $of_options[] = array(
        "name" => __("Project Name", 'nasa-core'),
        "id" => "project_name",
        "std" => 1,
        "type" => "switch"
    );

    $of_options[] = array(
        "name" => __("Portfolio Columns", 'nasa-core'),
        "id" => "portfolio_columns",
        "std" => "5-cols",
        "type" => "select",
        "options" => array(
            "5-cols" => __("5 columns", 'nasa-core'),
            "4-cols" => __("4 columns", 'nasa-core'),
            "3-cols" => __("3 columns", 'nasa-core'),
            "2-cols" => __("2 columns", 'nasa-core')
        )
    );

    $of_options[] = array(
        "name" => __("Portfolio Lightbox", 'nasa-core'),
        "id" => "portfolio_lightbox",
        "std" => 1,
        "type" => "switch"
    );
        
    return $of_options;
}
