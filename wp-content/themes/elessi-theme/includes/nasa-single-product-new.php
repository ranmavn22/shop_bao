<?php
if (!isset($nasa_opt)) :
    global $nasa_opt;
endif;

global $product;

$columnImage = '6';
$columnInfo = '6';

if ($nasa_opt['product_image_layout'] != 'single') {
    if ($nasa_opt['product_image_style'] === 'slide') {
        $columnImage = '8';
        $columnInfo = '4';
    } else {
        $columnImage = '7';
        $columnInfo = '5';
    }
}

$dots = isset($nasa_opt['product_slide_dot']) && $nasa_opt['product_slide_dot'] ? 'true' : 'false';
$auto = isset($nasa_opt['product_slide_auto']) && $nasa_opt['product_slide_auto'] ? 'true' : 'false';
$loop_slide = isset($nasa_opt['product_slide_loop']) && $nasa_opt['product_slide_loop'] ? 'true' : 'false';

$main_attrs = apply_filters('nasa_single_product_new_slide_attrs', array(
    'class="' . esc_attr($main_class) . '"',
    'data-num_main="' . (($nasa_opt['product_image_layout'] == 'double') ? '2' : '1') . '"',
    'data-num_thumb="' . (($nasa_opt['product_image_layout'] == 'double') ? '4' : '6') . '"',
    'data-speed="300"',
    'data-dots="' . esc_attr($dots) . '"',
    'data-autoplay="' . esc_attr($auto) . '"',
    'data-infinite="' . esc_attr($loop_slide) . '"',
));
?>

<div id="product-<?php echo (int) $product->get_id(); ?>" <?php post_class(); ?>>
    <?php if ($nasa_actsidebar && $nasa_sidebar != 'no') : ?>
        <div class="nasa-toggle-layout-side-sidebar nasa-sidebar-single-product <?php echo esc_attr($nasa_sidebar); ?>">
            <div class="li-toggle-sidebar">
                <a class="toggle-sidebar-shop nasa-tip" data-tip="<?php echo esc_attr__('Filters', 'elessi-theme'); ?>" href="javascript:void(0);" rel="nofollow">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="26px" height="24px" fill="currentColor"><path d="M 4 7 L 4 9 L 28 9 L 28 7 Z M 4 15 L 4 17 L 28 17 L 28 15 Z M 4 23 L 4 25 L 28 25 L 28 23 Z"></path></svg>
                </a>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="nasa-row nasa-product-details-page modern nasa-layout-new">
        <div<?php echo !empty($main_attrs) ? ' ' . implode(' ', $main_attrs) : ''; ?>>

            <div class="row focus-info">
                <div class="large-<?php echo esc_attr($columnImage); ?> small-12 columns product-gallery rtl-right"> 
                    <?php do_action('woocommerce_before_single_product_summary'); ?>
                </div>
                
                <div class="large-<?php echo esc_attr($columnInfo); ?> small-12 columns product-info summary entry-summary rtl-left">
                    <div class="nasa-product-info-wrap">
                        <div class="nasa-product-info-scroll">
                            <?php do_action('woocommerce_single_product_summary'); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php do_action('woocommerce_after_single_product_summary'); ?>

        </div>

        <?php if ($nasa_actsidebar && $nasa_sidebar != 'no') : ?>
            <div class="<?php echo esc_attr($bar_class); ?>">
                <a href="javascript:void(0);" title="<?php echo esc_attr__('Close', 'elessi-theme'); ?>" class="hidden-tag nasa-close-sidebar" rel="nofollow">
                    <?php echo esc_html__('Close', 'elessi-theme'); ?>
                </a>
                
                <div class="nasa-sidebar-off-canvas">
                    <?php dynamic_sidebar('product-sidebar'); ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>
