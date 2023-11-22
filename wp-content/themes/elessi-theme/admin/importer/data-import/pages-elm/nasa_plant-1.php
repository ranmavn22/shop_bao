<?php
function nasa_elm_plant_1() {
    $imgs_1 = elessi_import_upload('/elementor/wp-content/uploads/2022/07/plant1-service-icon1.png', '2914', array(
        'post_title' => 'plant1-service-icon1',
        'post_name' => 'plant1-service-icon1'
    ));
    
    $imgs_2 = elessi_import_upload('/elementor/wp-content/uploads/2022/07/plant1-service-icon2.png', '2915', array(
        'post_title' => 'plant1-service-icon2',
        'post_name' => 'plant1-service-icon2'
    ));
    
    $imgs_3 = elessi_import_upload('/elementor/wp-content/uploads/2022/07/plant1-service-icon3.png', '2916', array(
        'post_title' => 'plant1-service-icon3',
        'post_name' => 'plant1-service-icon3'
    ));
    
    $imgs_4 = elessi_import_upload('/elementor/wp-content/uploads/2022/07/plant1-service-icon4.png', '2917', array(
        'post_title' => 'plant1-service-icon4',
        'post_name' => 'plant1-service-icon4'
    ));
    
    $imgs_5 = elessi_import_upload('/elementor/wp-content/uploads/2022/07/plant1-banner1.jpg', '3108', array(
        'post_title' => 'plant1-banner1',
        'post_name' => 'plant1-banner1'
    ));
    
    $imgs_6 = elessi_import_upload('/elementor/wp-content/uploads/2022/07/plant1-banner2.jpg', '3129', array(
        'post_title' => 'plant1-banner2',
        'post_name' => 'plant1-banner2'
    ));
    
    $imgs_7 = elessi_import_upload('/elementor/wp-content/uploads/2022/07/plant1-banner3.jpg', '3129', array(
        'post_title' => 'plant1-banner3',
        'post_name' => 'plant1-banner3'
    ));
    
    $imgs_url_1 = elessi_import_upload('/elementor/wp-content/uploads/2022/07/plant1-testimonial-bg.jpg', '3197', array(
        'post_title' => 'plant1-testimonial-bg',
        'post_name' => 'plant1-testimonial-bg',
    ));
    $imgs_url_src_1 = $imgs_url_1 ? wp_get_attachment_image_url($imgs_url_1, 'full') : 'https://via.placeholder.com/1920x448?text=1920x448';
    
    $result = array(
        'post' => array(
            'post_title' => 'ELM Plant V1',
            'post_name' => 'elm-plant-v1',
        ),
        
        'post_meta' => array(
            '_elementor_data' => '[{"id":"53c6c068","elType":"section","settings":{"layout":"full_width","gap":"no","margin":{"unit":"px","top":"30","right":0,"bottom":"80","left":0,"isLinked":false},"margin_mobile":{"unit":"px","top":"30","right":0,"bottom":"40","left":0,"isLinked":false},"margin_tablet":{"unit":"px","top":"0","right":0,"bottom":"30","left":0,"isLinked":false}},"elements":[{"id":"195155cb","elType":"column","settings":{"_column_size":100,"_inline_size":null},"elements":[{"id":"356a56bb","elType":"widget","settings":{"wp":{"title_shortcode":"","type":"featured_product","style":"slide_slick","style_viewmore":"1","style_row":"1","pos_nav":"top","title_align":"left","shop_url":"0","arrows":"0","dots":"false","auto_slide":"false","number":"5","auto_delay_time":"6","columns_number":"3","columns_number_small":"1","columns_number_small_slider":"1","columns_number_tablet":"2","cat":"","not_in":"","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_products_sc"}],"isInner":false}],"isInner":false},{"id":"324f6b0e","elType":"section","settings":{"structure":"40","margin":{"unit":"px","top":"0","right":0,"bottom":"80","left":0,"isLinked":false},"margin_mobile":{"unit":"px","top":"0","right":0,"bottom":"50","left":0,"isLinked":false},"gap":"no","background_background":"classic","background_color":"#F8F8F8","padding":{"unit":"px","top":"80","right":"0","bottom":"80","left":"0","isLinked":false},"margin_tablet":{"unit":"px","top":"0","right":0,"bottom":"60","left":0,"isLinked":false},"padding_mobile":{"unit":"px","top":"50","right":"0","bottom":"50","left":"0","isLinked":false}},"elements":[{"id":"496e1c36","elType":"column","settings":{"_column_size":25,"_inline_size":null,"_inline_size_tablet":50,"margin_tablet":{"unit":"px","top":"0","right":"0","bottom":"30","left":"0","isLinked":false},"margin_mobile":{"unit":"px","top":"0","right":"0","bottom":"50","left":"0","isLinked":false},"padding":{"unit":"px","top":"0","right":"30","bottom":"0","left":"30","isLinked":false}},"elements":[{"id":"5e0eed3d","elType":"widget","settings":{"wp":{"box_img":"' . $imgs_1 . '","box_title":"Garden Care","box_desc":"Lorem ipsum dolor sit amet, consectetuer adipiscing elit","box_link":"#","box_blank":"","box_style":"ver","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_icon_box"}],"isInner":false},{"id":"53ffe928","elType":"column","settings":{"_column_size":25,"_inline_size":null,"_inline_size_tablet":50,"margin_tablet":{"unit":"px","top":"0","right":"0","bottom":"30","left":"0","isLinked":false},"margin_mobile":{"unit":"px","top":"0","right":"0","bottom":"50","left":"0","isLinked":false},"padding":{"unit":"px","top":"0","right":"30","bottom":"0","left":"30","isLinked":false}},"elements":[{"id":"5f422935","elType":"widget","settings":{"wp":{"box_img":"' . $imgs_2 . '","box_title":"Plant Renovation","box_desc":"Lorem ipsum dolor sit amet, consectetuer adipiscing elit","box_link":"#","box_blank":"","box_style":"ver","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_icon_box"}],"isInner":false},{"id":"2a7c73fa","elType":"column","settings":{"_column_size":25,"_inline_size":null,"_inline_size_tablet":50,"margin_mobile":{"unit":"px","top":"0","right":"0","bottom":"50","left":"0","isLinked":false},"padding":{"unit":"px","top":"0","right":"30","bottom":"0","left":"30","isLinked":false}},"elements":[{"id":"5a5e8dfa","elType":"widget","settings":{"wp":{"box_img":"' . $imgs_3 . '","box_title":"Seed Supply","box_desc":"Lorem ipsum dolor sit amet, consectetuer adipiscing elit","box_link":"#","box_blank":"","box_style":"ver","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_icon_box"}],"isInner":false},{"id":"4d4a3c76","elType":"column","settings":{"_column_size":25,"_inline_size":null,"_inline_size_tablet":50,"padding":{"unit":"px","top":"0","right":"30","bottom":"0","left":"30","isLinked":false}},"elements":[{"id":"36e925f3","elType":"widget","settings":{"wp":{"box_img":"' . $imgs_4 . '","box_title":"Watering Garen","box_desc":"Lorem ipsum dolor sit amet, consectetuer adipiscing elit","box_link":"#","box_blank":"","box_style":"ver","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_icon_box"}],"isInner":false}],"isInner":false},{"id":"2849df63","elType":"section","settings":{"margin":{"unit":"px","top":"0","right":0,"bottom":"50","left":0,"isLinked":false},"margin_mobile":{"unit":"px","top":"0","right":0,"bottom":"0","left":0,"isLinked":false},"margin_tablet":{"unit":"px","top":"0","right":0,"bottom":"0","left":0,"isLinked":true}},"elements":[{"id":"641be610","elType":"column","settings":{"_column_size":100,"_inline_size":null},"elements":[{"id":"1c5e8225","elType":"widget","settings":{"title":"new arrivals","align":"center","typography_typography":"custom","typography_font_size":{"unit":"px","size":18,"sizes":[]},"typography_text_transform":"uppercase","_css_classes":"primary-color margin-bottom-10","header_size":"span"},"elements":[],"widgetType":"heading"},{"id":"49582597","elType":"widget","settings":{"title":"Recommended for you","align":"center","title_color":"#333333","typography_typography":"custom","typography_font_weight":"800","header_size":"h3","typography_font_size":{"unit":"px","size":35,"sizes":[]},"typography_font_size_mobile":{"unit":"px","size":32,"sizes":[]}},"elements":[],"widgetType":"heading"},{"id":"6e9dcdfa","elType":"widget","settings":{"wp":{"title":"","title_font_size":"","desc":"","alignment":"center","style":"2d-radius-dashed","tabs":{"1603386304507":{"tab_title":"SMALL PLANTS","type":"recent_product","style":"grid","style_viewmore":"1","style_row":"2","pos_nav":"top","title_align":"left","shop_url":"1","arrows":"1","dots":"false","auto_slide":"false","number":"8","auto_delay_time":"6","columns_number":"4","columns_number_small":"2","columns_number_small_slider":"2","columns_number_tablet":"3","cat":"","not_in":"","el_class":""},"1603386427250":{"tab_title":"TERRARIUMS","type":"best_selling","style":"grid","style_viewmore":"1","style_row":"2","pos_nav":"top","title_align":"left","shop_url":"0","arrows":"0","dots":"false","auto_slide":"false","number":"8","auto_delay_time":"6","columns_number":"4","columns_number_small":"2","columns_number_small_slider":"2","columns_number_tablet":"3","cat":"","not_in":"","el_class":""},"1603386467942":{"tab_title":"HOUSE PLANTS","type":"featured_product","style":"grid","style_viewmore":"1","style_row":"2","pos_nav":"top","title_align":"left","shop_url":"1","arrows":"0","dots":"false","auto_slide":"false","number":"8","auto_delay_time":"6","columns_number":"4","columns_number_small":"2","columns_number_small_slider":"2","columns_number_tablet":"3","cat":"","not_in":"","el_class":""},"1603386510457":{"tab_title":"SUCCULENTS","type":"recent_product","style":"grid","style_viewmore":"1","style_row":"2","pos_nav":"top","title_align":"left","shop_url":"1","arrows":"0","dots":"false","auto_slide":"false","number":"8","auto_delay_time":"6","columns_number":"4","columns_number_small":"2","columns_number_small_slider":"2","columns_number_tablet":"3","cat":"","not_in":"","el_class":""}},"el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_products_tabs_sc"}],"isInner":false}],"isInner":false},{"id":"70b975e8","elType":"section","settings":{"structure":"20","margin":{"unit":"px","top":"0","right":0,"bottom":"60","left":0,"isLinked":false},"margin_tablet":{"unit":"px","top":"0","right":0,"bottom":"50","left":0,"isLinked":false},"margin_mobile":{"unit":"px","top":"0","right":0,"bottom":"60","left":0,"isLinked":false},"padding":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":false}},"elements":[{"id":"6e05fe11","elType":"column","settings":{"_column_size":50,"_inline_size":41.742,"padding":{"unit":"px","top":"0","right":"10","bottom":"0","left":"10","isLinked":false},"padding_mobile":{"unit":"px","top":"0","right":"10","bottom":"15","left":"10","isLinked":false},"_inline_size_tablet":42,"padding_tablet":{"unit":"px","top":"0","right":"10","bottom":"0","left":"10","isLinked":false}},"elements":[{"id":"19858481","elType":"widget","settings":{"wp":{"img_src":"' . $imgs_5 . '","link":"","content_width":"","align":"left","move_x":"9%","valign":"middle","text_align":"text-left","content":"<h2 class=\"fs-32 tablet-fs-30 mobile-fs-20 margin-bottom-50 mobile-margin-bottom-30\" style=\"line-height: 1.2\">Bonsai\r\nPlants\r\nCollections<\/h2>\r\n<h6 class=\"fs-14 tablet-fs-10 margin-bottom-20\" style=\"line-height: 1.4;color: #c0c2bd\">JUST ONLY\r\n<span class=\"fs-29 tablet-fs-16 mobile-fs-15 primary-color\">$19.99<\/span><\/h6>\r\n<a class=\"fs-16 tablet-fs-12 mobile-fs-12\" style=\"text-decoration: underline\" title=\"Shop now\" href=\"#\">Shop now<\/a>","effect_text":"fadeInLeft","data_delay":"300ms","hover":"zoom","border_inner":"no","border_outner":"no","hide_in_m":"","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_banner_2_sc"}],"isInner":false},{"id":"7fc27af9","elType":"column","settings":{"_column_size":50,"_inline_size":58.217,"padding":{"unit":"px","top":"0","right":"10","bottom":"0","left":"10","isLinked":false},"_inline_size_tablet":58,"padding_mobile":{"unit":"px","top":"0","right":"10","bottom":"0","left":"10","isLinked":false},"padding_tablet":{"unit":"px","top":"0","right":"10","bottom":"0","left":"10","isLinked":false}},"elements":[{"id":"60655431","elType":"widget","settings":{"wp":{"img_src":"' . $imgs_6 . '","link":"","content_width":"","align":"left","move_x":"","valign":"middle","text_align":"text-left","content":"<h3 class=\"fs-32 tablet-fs-16 mobile-fs-20 margin-top-0 margin-bottom-20\" style=\"line-height: 1.2\">Plants\r\nFor Interior<\/h3>\r\n<a class=\"primary-color nasa-bold-500 button small fs-16 tablet-fs-11 mobile-fs-12 force-radius-5\" style=\"text-transform: none;letter-spacing: 0;padding: 8px 18px\" title=\"Shop now\" href=\"#\">Shop now<\/a>","effect_text":"fadeInLeft","data_delay":"100ms","hover":"zoom","border_inner":"no","border_outner":"no","hide_in_m":"","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_banner_2_sc"},{"id":"59c09083","elType":"widget","settings":{"wp":{"img_src":"' . $imgs_7 . '","link":"","content_width":"","align":"left","move_x":"","valign":"middle","text_align":"text-left","content":"<h4 class=\"fs-32 tablet-fs-16 mobile-fs-20 margin-bottom-40 tablet-margin-bottom-10 mobile-margin-bottom-15\" style=\"line-height: 1.2\">Ceramic \r\nPot &amp; Plants<\/h4>\r\n<h6 class=\"fs-18 margin-bottom-30 tablet-margin-bottom-10 mobile-margin-bottom-15\" style=\"color: #a9a9a9\">Sale off <span class=\"fs-33 tablet-fs-16 mobile-fs-15 primary-color\">25%<\/span><\/h6>\r\n<a class=\"fs-16 tablet-fs-12 mobile-fs-12\" style=\"text-decoration: underline\" title=\"Shop now\" href=\"#\">Shop now<\/a>","effect_text":"fadeInLeft","data_delay":"200ms","hover":"zoom","border_inner":"no","border_outner":"no","hide_in_m":"","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_banner_2_sc"}],"isInner":false}],"isInner":false},{"id":"1e96887","elType":"section","settings":{"structure":"30","margin_mobile":{"unit":"px","top":"0","right":0,"bottom":"30","left":0,"isLinked":false},"margin":{"unit":"px","top":"0","right":0,"bottom":"50","left":0,"isLinked":false},"margin_tablet":{"unit":"px","top":"0","right":0,"bottom":"30","left":0,"isLinked":false}},"elements":[{"id":"6f8d96c1","elType":"column","settings":{"_column_size":33,"_inline_size":null,"margin_mobile":{"unit":"px","top":"0","right":"0","bottom":"20","left":"0","isLinked":false},"margin_tablet":{"unit":"px","top":"0","right":"0","bottom":"30","left":"0","isLinked":false}},"elements":[{"id":"25ee1d72","elType":"widget","settings":{"title":"Top Rated","header_size":"h4","title_color":"#333333","typography_typography":"custom","typography_font_weight":"800","text_shadow_text_shadow_type":"yes","text_shadow_text_shadow":{"horizontal":0,"vertical":0,"blur":0,"color":"rgba(0,0,0,0.3)"},"_margin":{"unit":"px","top":"0","right":"0","bottom":"10","left":"0","isLinked":false},"_margin_mobile":{"unit":"px","top":"0","right":"0","bottom":"10","left":"0","isLinked":false}},"elements":[],"widgetType":"heading"},{"id":"1a83d97e","elType":"widget","settings":{"wp":{"title_shortcode":"","type":"top_rate","style":"list","style_viewmore":"1","style_row":"3","pos_nav":"top","title_align":"left","shop_url":"1","arrows":"1","dots":"true","auto_slide":"false","number":"4","auto_delay_time":"6","columns_number":"1","columns_number_small":"1","columns_number_small_slider":"1","columns_number_tablet":"1","cat":"","not_in":"","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_products_sc"}],"isInner":false},{"id":"20e0dddf","elType":"column","settings":{"_column_size":33,"_inline_size":null,"margin_mobile":{"unit":"px","top":"0","right":"0","bottom":"20","left":"0","isLinked":false},"margin_tablet":{"unit":"px","top":"0","right":"0","bottom":"30","left":"0","isLinked":false}},"elements":[{"id":"1a1f65f6","elType":"widget","settings":{"title":"Best Selling","header_size":"h4","title_color":"#333333","typography_typography":"custom","typography_font_weight":"800","text_shadow_text_shadow_type":"yes","text_shadow_text_shadow":{"horizontal":0,"vertical":0,"blur":0,"color":"rgba(0,0,0,0.3)"},"_margin":{"unit":"px","top":"0","right":"0","bottom":"10","left":"0","isLinked":false},"_margin_mobile":{"unit":"px","top":"0","right":"0","bottom":"10","left":"0","isLinked":false}},"elements":[],"widgetType":"heading"},{"id":"4370674d","elType":"widget","settings":{"wp":{"title_shortcode":"","type":"best_selling","style":"list","style_viewmore":"1","style_row":"3","pos_nav":"top","title_align":"left","shop_url":"1","arrows":"1","dots":"true","auto_slide":"false","number":"4","auto_delay_time":"6","columns_number":"1","columns_number_small":"1","columns_number_small_slider":"1","columns_number_tablet":"1","cat":"","not_in":"","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_products_sc"}],"isInner":false},{"id":"2c13728a","elType":"column","settings":{"_column_size":33,"_inline_size":null},"elements":[{"id":"f29274c","elType":"widget","settings":{"title":"On Sale\u200b","header_size":"h4","title_color":"#333333","typography_typography":"custom","typography_font_weight":"800","text_shadow_text_shadow_type":"yes","text_shadow_text_shadow":{"horizontal":0,"vertical":0,"blur":0,"color":"rgba(0,0,0,0.3)"},"_margin":{"unit":"px","top":"0","right":"0","bottom":"10","left":"0","isLinked":false},"_margin_mobile":{"unit":"px","top":"0","right":"0","bottom":"10","left":"0","isLinked":false}},"elements":[],"widgetType":"heading"},{"id":"20ca789c","elType":"widget","settings":{"wp":{"title_shortcode":"","type":"on_sale","style":"list","style_viewmore":"1","style_row":"3","pos_nav":"top","title_align":"left","shop_url":"1","arrows":"1","dots":"true","auto_slide":"false","number":"4","auto_delay_time":"6","columns_number":"1","columns_number_small":"1","columns_number_small_slider":"1","columns_number_tablet":"1","cat":"","not_in":"","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_products_sc"}],"isInner":false}],"isInner":false},{"id":"3a113cb9","elType":"section","settings":{"structure":"34","background_background":"classic","background_image":{"id":3197,"url":' . json_encode($imgs_url_src_1) . ',"alt":"","source":"library"},"background_repeat":"no-repeat","background_size":"cover","padding":{"unit":"px","top":"0","right":"0","bottom":"50","left":"0","isLinked":false},"background_image_mobile":{"url":' . json_encode($imgs_url_src_1) . ',"id":3197,"alt":"","source":"library"},"margin":{"unit":"px","top":"0","right":0,"bottom":"80","left":0,"isLinked":false},"margin_mobile":{"unit":"px","top":"0","right":0,"bottom":"60","left":0,"isLinked":false},"padding_mobile":{"unit":"px","top":"0","right":"0","bottom":"80","left":"0","isLinked":false},"margin_tablet":{"unit":"px","top":"0","right":0,"bottom":"60","left":0,"isLinked":false},"padding_tablet":{"unit":"px","top":"0","right":"0","bottom":"50","left":"0","isLinked":false},"background_position_tablet":"bottom center","background_size_tablet":"cover","background_size_mobile":"cover"},"elements":[{"id":"38a0956","elType":"column","settings":{"_column_size":16,"_inline_size":20,"padding":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":false},"_inline_size_tablet":5},"elements":[{"id":"142d84b5","elType":"widget","settings":{"hide_mobile":"hidden-phone"},"elements":[],"widgetType":"spacer"}],"isInner":false},{"id":"6fe6ec22","elType":"column","settings":{"_column_size":66,"_inline_size":58.665,"padding":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":false},"_inline_size_tablet":90},"elements":[{"id":"216bcf26","elType":"widget","settings":{"wp":{"title":"","align":"center","sliders":{"1657703235680":{"img_src":"2883","name":"John Doe","style":"full","company":"Web Developer","content":"\"We connect buyers and sellers of natural, organic, environmentally sound products. The point of using Lorem Ipsum is that it has a more-or-less normal\"","text_align":"center","el_class":""},"1657703240125":{"img_src":"2883","name":"Johnny","style":"full","company":"CEO & Founder NasaTheme","content":"\"Vestibulum quis porttitor dui! Quisque viverra nunc mi, a pulvinar purus condimentum a. Aliquam condimentum mattis neque sed pretium\"","text_align":"center","el_class":""}},"bullets":"true","bullets_pos":"","bullets_align":"center","navigation":"true","column_number":"1","column_number_small":"1","column_number_tablet":"1","padding_item":"","padding_item_small":"","padding_item_medium":"","force":"true","autoplay":"false","paginationspeed":"800","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_client_slider_sc"}],"isInner":false},{"id":"235361d4","elType":"column","settings":{"_column_size":16,"_inline_size":20,"padding":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":false},"_inline_size_tablet":5},"elements":[{"id":"66e78c21","elType":"widget","settings":{"hide_mobile":"hidden-phone"},"elements":[],"widgetType":"spacer"}],"isInner":false}],"isInner":false},{"id":"233bbfdb","elType":"section","settings":{"margin":{"unit":"px","top":"0","right":0,"bottom":"30","left":0,"isLinked":false},"margin_mobile":{"unit":"px","top":"0","right":0,"bottom":"0","left":0,"isLinked":true}},"elements":[{"id":"32e4fdde","elType":"column","settings":{"_column_size":100,"_inline_size":null,"padding":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":true}},"elements":[{"id":"b5d963a","elType":"widget","settings":{"wp":{"title":"Latest Posts","title_desc":"The freshest and most exciting news","show_type":"grid_3","auto_slide":"false","arrows":"0","dots":"false","posts":"5","columns_number":"1","columns_number_small":"1","columns_number_small_slider":"1","columns_number_tablet":"2","category":"","cats_enable":"no","date_enable":"no","author_enable":"no","readmore":"no","date_author":"bot","des_enable":"yes","page_blogs":"no","info_align":"left","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_post_sc"}],"isInner":false}],"isInner":false}]',
            '_elementor_controls_usage' => '',
            '_elementor_css' => 'a:6:{s:4:"time";i:1641047222;s:5:"fonts";a:1:{i:0;s:4:"Jost";}s:5:"icons";a:0:{}s:20:"dynamic_elements_ids";a:0:{}s:6:"status";s:4:"file";i:0;s:0:"";}',
            // '_nasa_pri_color_flag' => 'on',
            // '_nasa_pri_color' => '#6bac0a',
        ),
        
        'globals' => array(
            'header-type' => '1',
            
            // 'fixed_nav' => '0',
            
            // 'plus_wide_width' => '400',
            'color_primary' => '#6bac0a',
            
            // 'bg_color_topbar' => '28aeb1',
            // 'text_color_topbar' => '#ffffff',
            
            // 'fullwidth_main_menu' => '1',
            
            // 'bg_color_main_menu' => '#e4272c',
            // 'text_color_main_menu' => '#ffffff',
            
            // 'v_root' => '1',
            // 'v_root_limit' => '10',
            
            // 'bg_color_v_menu' => '#000000',
            // 'text_color_v_menu' => '#ffffff',
            
            'footer_mode' => 'builder-e',
            'footer_elm' => elessi_elm_fid_by_slug('hfe-footer-light-2-bg'),
            'footer_elm_mobile' => elessi_elm_fid_by_slug('hfe-footer-mobile'),
            
            // 'category_sidebar' => 'left-classic',
            
            // 'product_detail_layout' => 'classic',
            'product_image_layout' => 'single',
            'product_image_style' => 'slide',
            // 'single_product_layout_bg' => '#f6f6f6',
            // 'tab_style_info' => '2d-no-border',
            
            // 'single_product_thumbs_style' => 'hoz',
            
            'loop_layout_buttons' => 'modern-5',
            
            // 'animated_products' => 'hover-carousel',
            
            // 'nasa_attr_image_style' => 'square',
            // 'nasa_attr_image_single_style' => 'extends',
            // 'nasa_attr_color_style' => 'round',
            'nasa_attr_label_style' => 'small-square-1',
            
            // 'breadcrumb_row' => 'single',
            // 'breadcrumb_type' => 'default',
            // 'breadcrumb_bg_color' => '#f8f8f8',
            // 'breadcrumb_align' => 'text-left',
            // 'breadcrumb_height' => '60',
        ),

        'css' => '.elementor-[inserted_id] .elementor-element.elementor-element-53c6c068{margin-top:30px;margin-bottom:80px;}.elementor-[inserted_id] .elementor-element.elementor-element-324f6b0e:not(.elementor-motion-effects-element-type-background), .elementor-[inserted_id] .elementor-element.elementor-element-324f6b0e > .elementor-motion-effects-container > .elementor-motion-effects-layer{background-color:#F8F8F8;}.elementor-[inserted_id] .elementor-element.elementor-element-324f6b0e{transition:background 0.3s, border 0.3s, border-radius 0.3s, box-shadow 0.3s;margin-top:0px;margin-bottom:80px;padding:80px 0px 80px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-324f6b0e > .elementor-background-overlay{transition:background 0.3s, border-radius 0.3s, opacity 0.3s;}.elementor-[inserted_id] .elementor-element.elementor-element-496e1c36 > .elementor-element-populated{padding:0px 30px 0px 30px;}.elementor-[inserted_id] .elementor-element.elementor-element-53ffe928 > .elementor-element-populated{padding:0px 30px 0px 30px;}.elementor-[inserted_id] .elementor-element.elementor-element-2a7c73fa > .elementor-element-populated{padding:0px 30px 0px 30px;}.elementor-[inserted_id] .elementor-element.elementor-element-4d4a3c76 > .elementor-element-populated{padding:0px 30px 0px 30px;}.elementor-[inserted_id] .elementor-element.elementor-element-2849df63{margin-top:0px;margin-bottom:50px;}.elementor-[inserted_id] .elementor-element.elementor-element-1c5e8225{text-align:center;}.elementor-[inserted_id] .elementor-element.elementor-element-1c5e8225 .elementor-heading-title{font-size:18px;text-transform:uppercase;}.elementor-[inserted_id] .elementor-element.elementor-element-49582597{text-align:center;}.elementor-[inserted_id] .elementor-element.elementor-element-49582597 .elementor-heading-title{color:#333333;font-size:35px;font-weight:800;}.elementor-[inserted_id] .elementor-element.elementor-element-70b975e8{margin-top:0px;margin-bottom:60px;padding:0px 0px 0px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-6e05fe11 > .elementor-element-populated{padding:0px 10px 0px 10px;}.elementor-[inserted_id] .elementor-element.elementor-element-7fc27af9 > .elementor-element-populated{padding:0px 10px 0px 10px;}.elementor-[inserted_id] .elementor-element.elementor-element-1e96887{margin-top:0px;margin-bottom:50px;}.elementor-[inserted_id] .elementor-element.elementor-element-25ee1d72 .elementor-heading-title{color:#333333;font-weight:800;text-shadow:0px 0px 0px rgba(0,0,0,0.3);}.elementor-[inserted_id] .elementor-element.elementor-element-25ee1d72 > .elementor-widget-container{margin:0px 0px 10px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-1a1f65f6 .elementor-heading-title{color:#333333;font-weight:800;text-shadow:0px 0px 0px rgba(0,0,0,0.3);}.elementor-[inserted_id] .elementor-element.elementor-element-1a1f65f6 > .elementor-widget-container{margin:0px 0px 10px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-f29274c .elementor-heading-title{color:#333333;font-weight:800;text-shadow:0px 0px 0px rgba(0,0,0,0.3);}.elementor-[inserted_id] .elementor-element.elementor-element-f29274c > .elementor-widget-container{margin:0px 0px 10px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-3a113cb9:not(.elementor-motion-effects-element-type-background), .elementor-[inserted_id] .elementor-element.elementor-element-3a113cb9 > .elementor-motion-effects-container > .elementor-motion-effects-layer{background-image:url("' . $imgs_url_src_1 . '");background-repeat:no-repeat;background-size:cover;}.elementor-[inserted_id] .elementor-element.elementor-element-3a113cb9{transition:background 0.3s, border 0.3s, border-radius 0.3s, box-shadow 0.3s;margin-top:0px;margin-bottom:80px;padding:0px 0px 50px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-3a113cb9 > .elementor-background-overlay{transition:background 0.3s, border-radius 0.3s, opacity 0.3s;}.elementor-[inserted_id] .elementor-element.elementor-element-38a0956 > .elementor-element-populated{padding:0px 0px 0px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-142d84b5 .elementor-spacer-inner{height:50px;}.elementor-[inserted_id] .elementor-element.elementor-element-6fe6ec22 > .elementor-element-populated{padding:0px 0px 0px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-235361d4 > .elementor-element-populated{padding:0px 0px 0px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-66e78c21 .elementor-spacer-inner{height:50px;}.elementor-[inserted_id] .elementor-element.elementor-element-233bbfdb{margin-top:0px;margin-bottom:30px;}.elementor-[inserted_id] .elementor-element.elementor-element-32e4fdde > .elementor-element-populated{padding:0px 0px 0px 0px;}@media(min-width:768px){.elementor-[inserted_id] .elementor-element.elementor-element-6e05fe11{width:41.742%;}.elementor-[inserted_id] .elementor-element.elementor-element-7fc27af9{width:58.217%;}.elementor-[inserted_id] .elementor-element.elementor-element-38a0956{width:20%;}.elementor-[inserted_id] .elementor-element.elementor-element-6fe6ec22{width:58.665%;}.elementor-[inserted_id] .elementor-element.elementor-element-235361d4{width:20%;}}@media(max-width:1024px){.elementor-[inserted_id] .elementor-element.elementor-element-53c6c068{margin-top:0px;margin-bottom:30px;}.elementor-[inserted_id] .elementor-element.elementor-element-324f6b0e{margin-top:0px;margin-bottom:60px;}.elementor-[inserted_id] .elementor-element.elementor-element-496e1c36 > .elementor-element-populated{margin:0px 0px 30px 0px;--e-column-margin-right:0px;--e-column-margin-left:0px;}.elementor-[inserted_id] .elementor-element.elementor-element-53ffe928 > .elementor-element-populated{margin:0px 0px 30px 0px;--e-column-margin-right:0px;--e-column-margin-left:0px;}.elementor-[inserted_id] .elementor-element.elementor-element-2849df63{margin-top:0px;margin-bottom:0px;}.elementor-[inserted_id] .elementor-element.elementor-element-70b975e8{margin-top:0px;margin-bottom:50px;}.elementor-[inserted_id] .elementor-element.elementor-element-6e05fe11 > .elementor-element-populated{padding:0px 10px 0px 10px;}.elementor-[inserted_id] .elementor-element.elementor-element-7fc27af9 > .elementor-element-populated{padding:0px 10px 0px 10px;}.elementor-[inserted_id] .elementor-element.elementor-element-1e96887{margin-top:0px;margin-bottom:30px;}.elementor-[inserted_id] .elementor-element.elementor-element-6f8d96c1 > .elementor-element-populated{margin:0px 0px 30px 0px;--e-column-margin-right:0px;--e-column-margin-left:0px;}.elementor-[inserted_id] .elementor-element.elementor-element-20e0dddf > .elementor-element-populated{margin:0px 0px 30px 0px;--e-column-margin-right:0px;--e-column-margin-left:0px;}.elementor-[inserted_id] .elementor-element.elementor-element-3a113cb9:not(.elementor-motion-effects-element-type-background), .elementor-[inserted_id] .elementor-element.elementor-element-3a113cb9 > .elementor-motion-effects-container > .elementor-motion-effects-layer{background-position:bottom center;background-size:cover;}.elementor-[inserted_id] .elementor-element.elementor-element-3a113cb9{margin-top:0px;margin-bottom:60px;padding:0px 0px 50px 0px;}}@media(max-width:767px){.elementor-[inserted_id] .elementor-element.elementor-element-53c6c068{margin-top:30px;margin-bottom:40px;}.elementor-[inserted_id] .elementor-element.elementor-element-324f6b0e{margin-top:0px;margin-bottom:50px;padding:50px 0px 50px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-496e1c36 > .elementor-element-populated{margin:0px 0px 50px 0px;--e-column-margin-right:0px;--e-column-margin-left:0px;}.elementor-[inserted_id] .elementor-element.elementor-element-53ffe928 > .elementor-element-populated{margin:0px 0px 50px 0px;--e-column-margin-right:0px;--e-column-margin-left:0px;}.elementor-[inserted_id] .elementor-element.elementor-element-2a7c73fa > .elementor-element-populated{margin:0px 0px 50px 0px;--e-column-margin-right:0px;--e-column-margin-left:0px;}.elementor-[inserted_id] .elementor-element.elementor-element-2849df63{margin-top:0px;margin-bottom:0px;}.elementor-[inserted_id] .elementor-element.elementor-element-49582597 .elementor-heading-title{font-size:32px;}.elementor-[inserted_id] .elementor-element.elementor-element-70b975e8{margin-top:0px;margin-bottom:60px;}.elementor-[inserted_id] .elementor-element.elementor-element-6e05fe11 > .elementor-element-populated{padding:0px 10px 15px 10px;}.elementor-[inserted_id] .elementor-element.elementor-element-7fc27af9 > .elementor-element-populated{padding:0px 10px 0px 10px;}.elementor-[inserted_id] .elementor-element.elementor-element-1e96887{margin-top:0px;margin-bottom:30px;}.elementor-[inserted_id] .elementor-element.elementor-element-6f8d96c1 > .elementor-element-populated{margin:0px 0px 20px 0px;--e-column-margin-right:0px;--e-column-margin-left:0px;}.elementor-[inserted_id] .elementor-element.elementor-element-25ee1d72 > .elementor-widget-container{margin:0px 0px 10px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-20e0dddf > .elementor-element-populated{margin:0px 0px 20px 0px;--e-column-margin-right:0px;--e-column-margin-left:0px;}.elementor-[inserted_id] .elementor-element.elementor-element-1a1f65f6 > .elementor-widget-container{margin:0px 0px 10px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-f29274c > .elementor-widget-container{margin:0px 0px 10px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-3a113cb9:not(.elementor-motion-effects-element-type-background), .elementor-[inserted_id] .elementor-element.elementor-element-3a113cb9 > .elementor-motion-effects-container > .elementor-motion-effects-layer{background-image:url("' . $imgs_url_src_1 . '");background-size:cover;}.elementor-[inserted_id] .elementor-element.elementor-element-3a113cb9{margin-top:0px;margin-bottom:60px;padding:0px 0px 80px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-233bbfdb{margin-top:0px;margin-bottom:0px;}}@media(max-width:1024px) and (min-width:768px){.elementor-[inserted_id] .elementor-element.elementor-element-496e1c36{width:50%;}.elementor-[inserted_id] .elementor-element.elementor-element-53ffe928{width:50%;}.elementor-[inserted_id] .elementor-element.elementor-element-2a7c73fa{width:50%;}.elementor-[inserted_id] .elementor-element.elementor-element-4d4a3c76{width:50%;}.elementor-[inserted_id] .elementor-element.elementor-element-6e05fe11{width:42%;}.elementor-[inserted_id] .elementor-element.elementor-element-7fc27af9{width:58%;}.elementor-[inserted_id] .elementor-element.elementor-element-38a0956{width:5%;}.elementor-[inserted_id] .elementor-element.elementor-element-6fe6ec22{width:90%;}.elementor-[inserted_id] .elementor-element.elementor-element-235361d4{width:5%;}}'
    );
    
    /* if (function_exists('hfe_init')) {
        if (isset($result['post_meta']['_nasa_footer_build_in'])) {
            unset($result['post_meta']['_nasa_footer_build_in']);
            unset($result['post_meta']['_nasa_footer_build_in_mobile']);
        }
        
        $result['post_meta']['_nasa_footer_mode'] = 'builder-e';
        $result['post_meta']['_nasa_footer_builder_e'] = elessi_elm_fid_by_slug('hfe-footer-light-2-bg');
        $result['post_meta']['_nasa_footer_builder_e_mobile'] = elessi_elm_fid_by_slug('hfe-footer-mobile');
    } */
    
    return $result;
}
