<?php
$close = NASA_WOO_ACTIVED ? is_product() : false;
$is_close = apply_filters('nasa_close_mobile_bottom_bar', $close);

if (!$is_close) :
    $is_store = false;
    
    if (NASA_WOO_ACTIVED) :
        $is_product_taxonomy = is_product_taxonomy();
        $is_shop = is_shop();
        $is_store = $is_product_taxonomy || $is_shop ? true : false;
    endif;
    
    $shop_link = !$is_store && NASA_WOO_ACTIVED ? wc_get_page_permalink('shop') : home_url('/');
    $class_shop = 'nasa-bot-icons';
    $class_shop .= !$is_store ? ' nasa-bot-icon-shop' : ' nasa-bot-icon-home';

    $svg_shop = 
        '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" class="nasa-svg-shop" height="23px" width="22px" viewBox="0 0 32 32" fill="currentColor">
            <g transform="matrix(0.048565, 0, 0, 0.048565, 24.580261, 2.974931)">
                <g transform="matrix(1, 0, 0, 1, -518.638794, 10.322351)">
                <path d="M 325.775 138.986 L 325.775 3.106 L 226.224 3.106 L 206.439 139.36 C 206.645 170.27 234.133 190.889 268.991 190.889 C 303.978 190.889 325.803 170.085 325.803 139.017 C 325.803 139.007 325.803 138.997 325.803 138.986 L 325.775 138.986 Z M 184.112 137.888 L 203.681 3.106 L 97.891 3.106 L 58.284 139.43 C 58.584 170.266 86.435 190.733 121.233 190.733 C 156.222 190.733 184.07 170.085 184.07 139.017 C 184.07 138.63 184.088 138.254 184.128 137.89 L 184.112 137.888 Z M 594.367 -19.814 C 599.223 -19.831 603.454 -16.894 604.618 -12.712 L 646.637 136.813 C 646.84 137.534 646.943 138.276 646.947 139.019 C 646.947 180.185 613.869 209.926 567.511 209.926 C 531.02 209.926 499.688 193.287 489.208 175.252 C 478.646 193.118 453.202 209.443 416.701 209.443 C 380.201 209.443 352.393 193.307 341.803 175.252 C 331.352 193.145 304.741 212.29 268.25 212.29 C 231.749 212.29 205.105 193.207 194.551 175.252 C 184.058 193.315 157.589 211.144 121.098 211.144 C 74.74 211.144 36.736 180.185 36.736 139.019 C 36.741 138.277 36.843 137.534 37.048 136.813 L 79.14 -12.712 C 80.303 -16.894 84.542 -19.831 89.392 -19.814 L 594.367 -19.814 Z M 348.045 139.207 C 348.045 170.275 381.317 188.935 416.303 188.935 C 450.995 188.935 476.125 170.509 476.599 139.807 L 456.751 3.106 L 348.015 3.295 L 348.015 138.403 C 348.035 138.666 348.045 138.933 348.045 139.207 Z M 499.694 139.017 C 499.694 170.085 533.968 189.636 568.956 189.636 C 603.758 189.636 624.426 170.27 624.721 139.43 L 585.114 3.106 C 587.139 0.878 481.773 1.17 480.014 3.106 L 499.402 136.59 C 499.593 137.337 499.694 138.147 499.694 139.017 Z" style="stroke-width: 0px;"/>
                <path d="M 84.471 189.481 L 84.471 477.433 C 84.471 477.433 84.553 498.229 93.5 514.914 C 102.449 531.6 120.513 544.603 156.583 544.603 L 527.101 544.603 C 527.101 544.603 555.31 542.288 573.205 533.941 C 591.1 525.599 599.213 510.85 599.213 477.431 L 599.213 189.48 L 577.499 189.098 L 577.499 477.049 C 577.499 501.307 570.068 508.99 557.08 515.043 C 544.094 521.099 527.101 521.66 527.101 521.66 L 156.583 521.66 C 130.839 521.66 118.528 516.699 112.038 504.589 C 105.541 492.481 105.426 477.431 105.426 477.431 L 105.426 189.48 L 84.471 189.481 Z" style="stroke-width: 0px;"/>
                <path d="M 305.173 310.741 C 271.149 310.741 253.821 328.39 245.355 345.327 C 236.885 362.259 237.011 378.904 237.011 378.904 L 237.011 525.004 L 260 525.004 L 260 378.904 C 260 378.904 260.061 367.149 266.204 354.864 C 272.349 342.576 280.805 333.685 305.338 333.685 L 383.276 333.685 C 383.276 333.685 392.741 333.794 405.026 339.942 C 417.314 346.087 428.659 354.397 428.659 378.907 L 428.663 525.007 L 451.275 525.007 L 451.275 378.907 C 451.275 345.025 433.626 327.554 416.689 319.089 C 399.757 310.619 383.112 310.745 383.112 310.745 L 305.173 310.741 Z" style="stroke-width: 0px;"/>
                </g>
            </g>
        </svg>';
    
    $icon_home = apply_filters('nasa_bot_icon_home', (!$is_store ? $svg_shop : '<i class="nasa-icon pe-7s-home"></i>'));
    $icon_filter = apply_filters('nasa_bot_icon_filter', '<i class="nasa-icon pe-7s-filter"></i>');
    $icon_cats = apply_filters('nasa_bot_icon_filter_cats', '<i class="nasa-icon pe-7s-keypad"></i>');
    $icon_search = apply_filters('nasa_bot_icon_search', '<i class="nasa-icon icon-nasa-if-search"></i>');
    ?>

    <ul class="nasa-bottom-bar-icons nasa-transition">
        <li class="nasa-bot-item ns-bot-store">
            <a class="<?php echo esc_attr($class_shop); ?>" href="<?php echo esc_url($shop_link); ?>" title="<?php echo !$is_store ? esc_attr__('Shop', 'elessi-theme') : esc_attr__('Home', 'elessi-theme'); ?>">
                <?php echo $icon_home; ?>
                <?php echo !$is_store ? esc_html__('Shop', 'elessi-theme') : esc_html__('Home', 'elessi-theme'); ?>
            </a>
        </li>

        <li class="nasa-bot-item nasa-bot-item-sidebar hidden-tag">
            <a class="nasa-bot-icons nasa-bot-icon-sidebar" href="javascript:void(0);" title="<?php echo esc_attr__('Filters', 'elessi-theme'); ?>" rel="nofollow">
                <?php echo $icon_filter; ?>
                <?php echo esc_html__('Filters', 'elessi-theme'); ?>
            </a>
        </li>
        
        <?php if (NASA_WOO_ACTIVED) : ?>
            <li class="nasa-bot-item ns-bot-cats">
                <a class="nasa-bot-icons nasa-bot-icon-categories filter-cat-icon-mobile" href="javascript:void(0);" title="<?php echo esc_attr__('Categories', 'elessi-theme'); ?>" rel="nofollow">
                    <?php echo $icon_cats; ?>
                    <?php echo esc_html__('Categories', 'elessi-theme'); ?>
                </a>
            </li>
        <?php endif; ?>

        <li class="nasa-bot-item nasa-bot-item-search hidden-tag">
            <a class="nasa-bot-icons nasa-bot-icon-search botbar-mobile-search" href="javascript:void(0);" title="<?php echo esc_attr__('Search', 'elessi-theme'); ?>" rel="nofollow">
                <?php echo $icon_search; ?>
                <?php echo esc_html__('Search', 'elessi-theme'); ?>
            </a>
        </li>

        <?php
        /**
         * Wishlist bottom bar
         */
        $wishlist_icons = elessi_icon_wishlist();
        
        if ($wishlist_icons) : ?>
            
            <li class="nasa-bot-item ns-bot-wl">
                <a class="nasa-bot-icons nasa-bot-icon-wishlist botbar-wishlist-link" href="javascript:void(0);" title="<?php echo esc_attr__('Wishlist', 'elessi-theme'); ?>" rel="nofollow">
                    <i class="nasa-icon wishlist-icon icon-nasa-like"></i>
                    <?php echo esc_html__('Wishlist', 'elessi-theme'); ?>
                </a>
                <?php echo $wishlist_icons; ?>
            </li>

        <?php else:

            /**
             * Cart bottom bar If Has Not Wishlist Featured
             */
            $is_cart = !NASA_WOO_ACTIVED || (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart']) ? false : true;

            if ($is_cart) :
                $icon_class = elessi_mini_cart_icon();
                ?>
                <li class="nasa-bot-item ns-bot-cart nasa-icon-mini-cart">
                    <a class="nasa-bot-icons nasa-bot-icon-cart botbar-cart-link" href="javascript:void(0);" title="<?php echo esc_attr__('Cart', 'elessi-theme'); ?>" rel="nofollow">
                        <i class="nasa-icon <?php echo $icon_class; ?>"></i>
                        <?php echo esc_html__('Cart', 'elessi-theme'); ?>
                    </a>
                </li>
            <?php endif; ?>
            
        <?php endif; ?>
    </ul>

<?php
endif;