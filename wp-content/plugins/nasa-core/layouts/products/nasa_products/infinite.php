<?php
$style_item = (isset($nasa_opt['loop_layout_buttons']) && $nasa_opt['loop_layout_buttons'] != '') ? $nasa_opt['loop_layout_buttons'] : '';
$loop_cats = isset($nasa_opt['loop_categories']) && $nasa_opt['loop_categories'] ? '1' : '0';
?>
<div class="nasa-products-infinite-wrap">
    <div class="products grid products-infinite nasa-products-infinite "
        data-next-page="2"
        data-product-type="<?php echo esc_attr($type); ?>"
        data-post-per-page="<?php echo esc_attr($number); ?>"
        data-post-per-row="<?php echo esc_attr($columns_number); ?>"
        data-post-per-row-medium="<?php echo esc_attr($columns_number_tablet); ?>"
        data-post-per-row-small="<?php echo esc_attr($columns_number_small); ?>"
        data-max-pages="<?php echo esc_attr($loop->max_num_pages); ?>"
        data-loop-cat="<?php echo esc_attr($loop_cats); ?>"
        data-cat="<?php echo esc_attr($cat); ?>"
        data-style-item="<?php echo esc_attr($style_item); ?>">
        <?php nasa_template('products/globals/row_layout.php', $nasa_args); ?>
    </div>
    
    <div class="nasa-relative nasa-clear-both text-center margin-top-0 margin-bottom-30">
        <?php if ($loop->max_num_pages > 1) :
            $style_viewmore = 'nasa-more-type-' . (isset($style_viewmore) ? $style_viewmore : '1');
            ?>
            <a href="javascript:void(0);" class="load-more-btn load-more <?php echo esc_attr($style_viewmore); ?>" data-nodata="<?php esc_attr_e('ALL PRODUCTS LOADED', 'nasa-core'); ?>" rel="nofollow">
                <div class="load-more-content">
                    <span class="load-more-icon icon-nasa-refresh"></span>
                    <span class="load-more-text"><?php esc_html_e('LOAD MORE ...', 'nasa-core'); ?></span>
                </div>
            </a>
        <?php endif; ?>
    </div>
</div>
