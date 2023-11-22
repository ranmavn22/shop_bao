<?php
/**
 * The template for displaying search forms in nasatheme
 *
 * @package nasatheme
 */

global $nasa_opt, $nasa_search_form_id;

$_id = isset($nasa_search_form_id) ? $nasa_search_form_id : 1;
$GLOBALS['nasa_search_form_id'] = $_id + 1;

$mobile_search = !isset($args['mobile']) || !$args['mobile'] ? false : true;

$fibo_search = shortcode_exists('fibosearch') ? true : false;
$aws_search = !$fibo_search && function_exists('aws_get_search_form') ? true : false;

$popkeys = array();

$post_type = apply_filters('nasa_search_post_type', 'post');

/**
 * Search Form - Desktop
 */
if (!$mobile_search) :
    $class_input = 'search-field search-input';
    
    $place_holder = esc_attr__("Start typing ...", 'elessi-theme');
    $hotkeys = '';
    
    $class_wrap = 'search-wrapper nasa-search-form-container';
    $form_wrap = 'nasa-search nasa-search-form';
    
    if ($post_type === 'product') :
        $class_input .= ' live-search-input';
        $form_wrap = 'nasa-search nasa-ajax-search-form';
        $class_wrap = 'search-wrapper nasa-ajax-search-form-container';
        $class_wrap .= isset($nasa_opt['search_layout']) ? ' ' . $nasa_opt['search_layout'] : '';

        $place_holder = esc_attr__("I'm shopping for ...", 'elessi-theme');
        
        if (isset($nasa_opt['hotkeys_search']) && trim($nasa_opt['hotkeys_search']) !== '') :
            $hotkeys = ' data-suggestions="' . esc_attr($nasa_opt['hotkeys_search']) . '"';
        endif;
        
        if (isset($nasa_opt['popkeys_search']) && trim($nasa_opt['popkeys_search']) !== '') :
            $pops = explode(',', $nasa_opt['popkeys_search']);
            
            if (!empty($pops)) :
                foreach ($pops as $pop) :
                    $popkeys[] = trim($pop);
                endforeach;
            endif;
        endif;
    endif;
    
    /**
     * Compatible with Fibo Search
     */
    $class_wrap .= $fibo_search ? ' sp-fibo-search' : '';
    $class_wrap .= $aws_search ? ' sp-aws-search' : '';

    $has_post_type = apply_filters('nasa_searh_form_has_post_type', (bool) $post_type);
    ?>

    <div class="<?php echo esc_attr($class_wrap); ?>">
        <?php 
        /**
         * Compatible with Fibo Search
         */
        if ($fibo_search) :
            echo do_shortcode('[fibosearch]');
        elseif ($aws_search) :
            aws_get_search_form();
        else :
        ?>
            <form role="search" method="get" class="<?php echo esc_attr($form_wrap); ?>" action="<?php echo esc_url(home_url('/')); ?>">
                <label for="nasa-input-<?php echo esc_attr($_id); ?>" class="hidden-tag">
                    <?php esc_html_e('Search here', 'elessi-theme'); ?>
                </label>

                <input type="text" name="s" id="nasa-input-<?php echo esc_attr($_id); ?>" class="<?php echo esc_attr($class_input); ?>" value="<?php echo get_search_query(); ?>" placeholder="<?php echo $place_holder; ?>"<?php echo $hotkeys;?> />
                
                <?php if (!empty($popkeys)) : ?>
                    <div class="ns-popular-keys-wrap hidden-tag">
                        <span class="ns-popular-keys">
                            <span class="ns-label">
                                <?php esc_html_e('Popular Searches:', 'elessi-theme'); ?>
                            </span>

                            <?php foreach($popkeys as $popkey) : ?>
                                <a class="nasa-bold ns-popular-keyword" href="javascript:void(0);" rel="nofollow" data-word="<?php echo esc_attr($popkey); ?>">
                                    <?php echo esc_html($popkey); ?>
                                </a>
                            <?php endforeach; ?>
                        </span>
                    </div>
                <?php endif; ?>

                <span class="nasa-icon-submit-page">
                    <button class="nasa-submit-search hidden-tag">
                        <?php esc_attr_e('Search', 'elessi-theme'); ?>
                    </button>
                </span>

                <?php if ($has_post_type) : ?>
                    <input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>" />
                <?php endif; ?>
            </form>
        <?php endif; ?>
        
        <a href="javascript:void(0);" title="<?php esc_attr_e('Close search', 'elessi-theme'); ?>" class="nasa-close-search nasa-stclose" rel="nofollow"></a>
    </div>

<?php
/**
 * Search Form - Mobile
 */
else :
    $class_input = 'search-field search-input force-radius-5';
    $place_holder = esc_attr__("Start typing ...", 'elessi-theme');
    $class_wrap = 'nasa-search nasa-search-form';

    // $post_type = apply_filters('nasa_mobile_search_post_type', 'product');
    if ($post_type === 'product') :
        $class_input .= ' live-search-input';
        $class_wrap = 'nasa-search nasa-ajax-search-form';
        $place_holder = esc_attr__("I'm shopping for ...", 'elessi-theme');
        
        if (isset($nasa_opt['popkeys_search']) && trim($nasa_opt['popkeys_search']) !== '') :
            $pops = explode(',', $nasa_opt['popkeys_search']);
            
            if (!empty($pops)) :
                foreach ($pops as $pop) :
                    $popkeys[] = trim($pop);
                endforeach;
            endif;
        endif;
    endif;
    
    /**
     * Compatible with Fibo Search
     */
    $class_wrap .= $fibo_search ? ' sp-fibo-search' : '';
    $class_wrap .= $aws_search ? ' sp-aws-search' : '';

    $has_post_type = apply_filters('nasa_searh_form_has_post_type', (bool) $post_type);
    ?>
    
    <div class="search-wrapper <?php echo esc_attr($class_wrap); ?>-container nasa-flex">
        <?php
        /**
         * Compatible with Fibo Search
         */
        if ($fibo_search) :
            echo do_shortcode('[fibosearch]');
        elseif ($aws_search) :
            aws_get_search_form();
        else :
        ?>
            <form method="get" class="<?php echo esc_attr($class_wrap); ?> nasa-transition" action="<?php echo esc_url(home_url('/')); ?>">
                <label for="nasa-input-mobile-search" class="label-search hidden-tag text-left fs-17">
                    <?php esc_html_e('Search', 'elessi-theme'); ?>
                </label>

                <input id="nasa-input-mobile-search" type="text" class="<?php echo esc_attr($class_input); ?>" value="<?php echo get_search_query();?>" name="s" placeholder="<?php echo $place_holder; ?>" />
                
                <?php if (!empty($popkeys)) : ?>
                    <span class="ns-popular-keys nasa-flex">
                        <span class="ns-label">
                            <?php esc_html_e('Popular Searches:', 'elessi-theme'); ?>
                        </span>
                        
                        <?php foreach($popkeys as $popkey) : ?>
                            <a class="ns-popular-keyword" href="javascript:void(0);" rel="nofollow" data-word="<?php echo esc_attr($popkey); ?>">
                                <?php echo esc_html($popkey); ?>
                            </a>
                        <?php endforeach; ?>
                    </span>
                <?php endif; ?>

                <div class="nasa-vitual-hidden">
                    <?php if ($has_post_type) : ?>
                        <input type="submit" name="post_type" value="<?php echo esc_attr($post_type); ?>" />
                    <?php else: ?>
                        <input type="submit" name="submit" value="<?php esc_attr_e('search', 'elessi-theme'); ?>" />
                    <?php endif; ?>
                </div>
            </form>
        <?php endif; ?>
        <a href="javascript:void(0);" title="<?php esc_attr_e('Close search', 'elessi-theme'); ?>" class="nasa-close-search-mobile margin-left-10 rtl-margin-left-0 rtl-margin-right-10 nasa-stclose" rel="nofollow"></a>
    </div>
<?php
endif;
