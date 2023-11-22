<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * WooCommerce - Function get Query - new version
 */
function nasa_woo_query($args = array()) {
    if (!NASA_WOO_ACTIVED) {
        return array();
    }
    
    global $nasa_opt;
    
    $defaults = array(
        'type' => '',
        'post_per_page' => -1,
        'paged' => '',
        'cat' => '',
        'ns_brand' => '',
        'pwb_brand' => '',
        'not' => array(),
        'deal_time' => null,
    );
    
    $new_args = wp_parse_args($args, $defaults);
    
    if (!isset($nasa_opt['enable_nasa_brands']) || !$nasa_opt['enable_nasa_brands']) {
        $new_args['ns_brand'] = '';
    }
    
    if (!defined('PWB_PLUGIN_NAME')) {
        $new_args['pwb_brand'] = '';
    }
    
    $paged = $new_args['paged'];
    $new_args['paged'] = $paged == '' ? ($paged = get_query_var('paged') ? (int) get_query_var('paged') : 1) : (int) $paged;
    
    $data = nasa_woo_query_args($new_args);
    
    remove_filter('posts_clauses', 'nasa_order_by_rating_post_clauses');
    remove_filter('posts_clauses', 'nasa_order_by_recent_review_post_clauses');
    
    return $data;
}

/**
 * Build query for Nasa WooCommerce Products - New Version
 * 
 * @param type $inputs
 * @return Obj WP_Query
 */
function nasa_woo_query_args($inputs = array()) {
    if (!NASA_WOO_ACTIVED) {
        return array();
    }
    
    $defaults = array(
        'type' => '',
        'post_per_page' => -1,
        'paged' => '',
        'cat' => '',
        'ns_brand' => '',
        'pwb_brand' => '',
        'not' => array(),
        'deal_time' => null,
    );
    
    $new_inputs = wp_parse_args($inputs, $defaults);

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $new_inputs['post_per_page'],
        'post_status' => 'publish',
        'paged' => $new_inputs['paged']
    );

    $args['meta_query'] = array();
    $args['meta_query'][] = WC()->query->stock_status_meta_query();
    $args['tax_query'] = array('relation' => 'AND');
    
    $visibility_terms = wc_get_product_visibility_term_ids();
    $terms_not_in = array($visibility_terms['exclude-from-catalog']);

    // Hide out of stock products.
    if ('yes' === get_option('woocommerce_hide_out_of_stock_items')) {
        $terms_not_in[] = $visibility_terms['outofstock'];
    }

    if (!empty($terms_not_in)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_visibility',
            'field' => 'term_taxonomy_id',
            'terms' => $terms_not_in,
            'operator' => 'NOT IN',
        );
    }
    
    switch ($new_inputs['type']) {
        case 'best_selling':
            $args['ignore_sticky_posts'] = 1;
            
            $args['meta_key']   = 'total_sales';
            $args['order']      = 'DESC';
            $args['orderby']    = 'meta_value_num';
            
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            
            break;
        
        case 'featured_product':
            $args['ignore_sticky_posts'] = 1;
            $terms_in = isset($visibility_terms['featured']) && !empty($visibility_terms['featured']) ?
                array($visibility_terms['featured']) : null;

            $args['tax_query'][] = $terms_in ? array(
                'taxonomy' => 'product_visibility',
                'field' => 'term_taxonomy_id',
                'terms' => $terms_in,
                'operator' => 'IN',
            ) : array(
                'taxonomy' => 'product_visibility',
                'field' => 'name',
                'terms' => 'featured'
            );
            
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            
            break;
        
        case 'top_rate':
            add_filter('posts_clauses', 'nasa_order_by_rating_post_clauses');
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            break;
        
        case 'recent_review':
            // nasa_order_by_recent_review_post_clauses
            add_filter('posts_clauses', 'nasa_order_by_recent_review_post_clauses');
            $args['meta_query'][] = WC()->query->visibility_meta_query();

            break;
        
        case 'on_sale':
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            $args['post__in'] = array_merge(array(0), wc_get_product_ids_on_sale());
            
            break;
        
        /**
         * Product Deal
         */
        case 'deals':
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            
            $args['meta_query'][] = array(
                'key' => '_sale_price_dates_from',
                'value' => NASA_TIME_NOW,
                'compare' => '<=',
                'type' => 'numeric'
            );
            
            $args['meta_query'][] = array(
                'key' => '_sale_price_dates_to',
                'value' => NASA_TIME_NOW,
                'compare' => '>',
                'type' => 'numeric'
            );
            
            $args['post_type'] = array('product', 'product_variation');

            if ($new_inputs['deal_time'] > 0) {
                $args['meta_query'][] = array(
                    'key' => '_sale_price_dates_to',
                    'value' => $new_inputs['deal_time'],
                    'compare' => '>=',
                    'type' => 'numeric'
                );
            }
            
            $args['post__in'] = array_merge(array(0), nasa_get_product_deal_ids($new_inputs['cat']));
            
            $args['orderby'] = 'date ID';
            $args['order']   = 'DESC';

            break;
        
        /**
         * Order by stock quantity
         */
        case 'stock_desc':
            $args['ignore_sticky_posts'] = 1;
            
            $args['meta_key']   = '_stock';
            $args['order']      = 'DESC';
            $args['orderby']    = 'meta_value_num';
            
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            
            $args['meta_query'][] = array(
                'key' => '_manage_stock',
                'value' => 'yes',
                'compare' => '=',
                'type' => 'string'
            );
            
            break;

        case 'recent_product':
        default:
            $args['orderby'] = 'date ID';
            $args['order']   = 'DESC';
            
            break;
    }

    if (!empty($new_inputs['not'])) {
        $args['post__not_in'] = $new_inputs['not'];
        
        if (!empty($args['post__in'])) {
            $args['post__in'] = array_diff($args['post__in'], $args['post__not_in']);
        }
    }

    if ($new_inputs['type'] !== 'deals' && $new_inputs['cat']) {
        
        // Find by cat id
        if (is_numeric($new_inputs['cat'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => array($new_inputs['cat'])
            );
        }

        // Find by cat array id
        elseif (is_array($new_inputs['cat'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $new_inputs['cat']
            );
        }

        // Find by Cat slug
        elseif (is_string($new_inputs['cat'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $new_inputs['cat']
            );
        }
    }
    
    if ($new_inputs['ns_brand']) {
        // Find by brand id
        if (is_numeric($new_inputs['ns_brand'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_brand',
                'field' => 'id',
                'terms' => array($new_inputs['ns_brand'])
            );
        }

        // Find by Brand array id
        elseif (is_array($new_inputs['ns_brand'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_brand',
                'field' => 'id',
                'terms' => $new_inputs['ns_brand']
            );
        }

        // Find by Brand slug
        elseif (is_string($new_inputs['ns_brand'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_brand',
                'field' => 'slug',
                'terms' => $new_inputs['ns_brand']
            );
        }
    }
    
    /**
     * Compatible Perfect Brands for WooCommerce Plugin
     */
    if ($new_inputs['pwb_brand']) {
        // Find by brand id
        if (is_numeric($new_inputs['pwb_brand'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'pwb-brand',
                'field' => 'id',
                'terms' => array($new_inputs['pwb_brand'])
            );
        }

        // Find by Brand array id
        elseif (is_array($new_inputs['ns_brand'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'pwb-brand',
                'field' => 'id',
                'terms' => $new_inputs['pwb_brand']
            );
        }

        // Find by Brand slug
        elseif (is_string($new_inputs['pwb_brand'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'pwb-brand',
                'field' => 'slug',
                'terms' => $new_inputs['pwb_brand']
            );
        }
    }
    
    if (empty($args['orderby']) || empty($args['order'])) {
        $ordering_args      = WC()->query->get_catalog_ordering_args();
        $args['orderby']    = empty($args['orderby']) ? $ordering_args['orderby'] : $args['orderby'];
        $args['order']      = empty($args['order']) ? $ordering_args['order'] : $args['order'];
    }

    return new WP_Query(apply_filters('nasa_woocommerce_query_args', $args));
}

/**
 * WooCommerce - Function get Query
 */
function nasa_woocommerce_query($type = '', $post_per_page = -1, $cat = '', $paged = '', $not = array(), $deal_time = null) {
    if (!NASA_WOO_ACTIVED) {
        return array();
    }
    
    $page = $paged == '' ? ($paged = get_query_var('paged') ? (int) get_query_var('paged') : 1) : (int) $paged;
    
    $data = nasa_woocommerce_query_args($type, $post_per_page, $cat, $page, $not, $deal_time);
    remove_filter('posts_clauses', 'nasa_order_by_rating_post_clauses');
    remove_filter('posts_clauses', 'nasa_order_by_recent_review_post_clauses');
    
    return $data;
}

/**
 * Order by rating review
 * 
 * @global type $wpdb
 * @param type $args
 * @return array
 */
function nasa_order_by_rating_post_clauses($args) {
    global $wpdb;

    $args['fields'] .= ', AVG(' . $wpdb->commentmeta . '.meta_value) as average_rating';
    $args['where'] .= ' AND (' . $wpdb->commentmeta . '.meta_key = "rating" OR ' . $wpdb->commentmeta . '.meta_key IS null) AND ' . $wpdb->comments . '.comment_approved=1 ';
    $args['join'] .= ' LEFT OUTER JOIN ' . $wpdb->comments . ' ON(' . $wpdb->posts . '.ID = ' . $wpdb->comments . '.comment_post_ID) LEFT JOIN ' . $wpdb->commentmeta . ' ON(' . $wpdb->comments . '.comment_ID = ' . $wpdb->commentmeta . '.comment_id) ';
    $args['orderby'] = 'average_rating DESC, ' . $wpdb->posts . '.post_date DESC';
    $args['groupby'] = $wpdb->posts . '.ID';

    return $args;
}

/**
 * Order by recent review
 * 
 * @global type $wpdb
 * @param type $args
 * @return array
 */
function nasa_order_by_recent_review_post_clauses($args) {
    global $wpdb;

    $args['where'] .= ' AND ' . $wpdb->comments . '.comment_approved=1 ';
    $args['join'] .= ' LEFT JOIN ' . $wpdb->comments . ' ON(' . $wpdb->posts . '.ID = ' . $wpdb->comments . '.comment_post_ID)';
    $args['orderby'] = $wpdb->comments . '.comment_date DESC, ' . $wpdb->comments . '.comment_post_ID DESC';
    $args['groupby'] = $wpdb->posts . '.ID';

    return $args;
}

/**
 * Build query for Nasa WooCommerce Products
 * 
 * @param type $type
 * @param type $post_per_page
 * @param type $cat
 * @param type $paged
 * @param type $not
 * @param type $deal_time
 * @return type
 */
function nasa_woocommerce_query_args($type = '', $post_per_page = -1, $cat = '', $paged = 1, $not = array(), $deal_time = null) {
    if (!NASA_WOO_ACTIVED) {
        return array();
    }

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $post_per_page,
        'post_status' => 'publish',
        'paged' => $paged
    );

    $args['meta_query'] = array();
    $args['meta_query'][] = WC()->query->stock_status_meta_query();
    $args['tax_query'] = array('relation' => 'AND');
    
    $visibility_terms = wc_get_product_visibility_term_ids();
    $terms_not_in = array($visibility_terms['exclude-from-catalog']);

    // Hide out of stock products.
    if ('yes' === get_option('woocommerce_hide_out_of_stock_items')) {
        $terms_not_in[] = $visibility_terms['outofstock'];
    }

    if (!empty($terms_not_in)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_visibility',
            'field' => 'term_taxonomy_id',
            'terms' => $terms_not_in,
            'operator' => 'NOT IN',
        );
    }
    
    switch ($type) {
        case 'best_selling':
            $args['ignore_sticky_posts'] = 1;
            
            $args['meta_key']   = 'total_sales';
            $args['order']      = 'DESC';
            $args['orderby']    = 'meta_value_num';
            
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            
            break;
        
        case 'featured_product':
            $args['ignore_sticky_posts'] = 1;
            $terms_in = isset($visibility_terms['featured']) && !empty($visibility_terms['featured']) ?
                array($visibility_terms['featured']) : null;

            $args['tax_query'][] = $terms_in ? array(
                'taxonomy' => 'product_visibility',
                'field' => 'term_taxonomy_id',
                'terms' => $terms_in,
                'operator' => 'IN',
            ) : array(
                'taxonomy' => 'product_visibility',
                'field' => 'name',
                'terms' => 'featured'
            );
            
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            
            break;
        
        case 'top_rate':
            add_filter('posts_clauses', 'nasa_order_by_rating_post_clauses');
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            break;
        
        case 'recent_review':
            // nasa_order_by_recent_review_post_clauses
            add_filter('posts_clauses', 'nasa_order_by_recent_review_post_clauses');
            $args['meta_query'][] = WC()->query->visibility_meta_query();

            break;
        
        case 'on_sale':
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            $args['post__in'] = array_merge(array(0), wc_get_product_ids_on_sale());
            
            break;
        
        /**
         * Product Deal
         */
        case 'deals':
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            
            $args['meta_query'][] = array(
                'key' => '_sale_price_dates_from',
                'value' => NASA_TIME_NOW,
                'compare' => '<=',
                'type' => 'numeric'
            );
            
            $args['meta_query'][] = array(
                'key' => '_sale_price_dates_to',
                'value' => NASA_TIME_NOW,
                'compare' => '>',
                'type' => 'numeric'
            );
            
            $args['post_type'] = array('product', 'product_variation');

            if ($deal_time > 0) {
                $args['meta_query'][] = array(
                    'key' => '_sale_price_dates_to',
                    'value' => $deal_time,
                    'compare' => '>=',
                    'type' => 'numeric'
                );
            }
            
            $args['post__in'] = array_merge(array(0), nasa_get_product_deal_ids($cat));
            
            $args['orderby'] = 'date ID';
            $args['order']   = 'DESC';

            break;
        
        /**
         * Order by stock quantity
         */
        case 'stock_desc':
            $args['ignore_sticky_posts'] = 1;
            
            $args['meta_key']   = '_stock';
            $args['order']      = 'DESC';
            $args['orderby']    = 'meta_value_num';
            
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            
            $args['meta_query'][] = array(
                'key' => '_manage_stock',
                'value' => 'yes',
                'compare' => '=',
                'type' => 'string'
            );
            
            break;

        case 'recent_product':
        default:
            $args['orderby'] = 'date ID';
            $args['order']   = 'DESC';
            
            break;
    }

    if (!empty($not)) {
        $args['post__not_in'] = $not;
        
        if (!empty($args['post__in'])) {
            $args['post__in'] = array_diff($args['post__in'], $args['post__not_in']);
        }
    }

    if ($type !== 'deals' && $cat) {
        
        // Find by cat id
        if (is_numeric($cat)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => array($cat)
            );
        }

        // Find by cat array id
        elseif (is_array($cat)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $cat
            );
        }

        // Find by slug
        elseif (is_string($cat)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $cat
            );
        }
    }
    
    if (empty($args['orderby']) || empty($args['order'])) {
        $ordering_args      = WC()->query->get_catalog_ordering_args();
        $args['orderby']    = empty($args['orderby']) ? $ordering_args['orderby'] : $args['orderby'];
        $args['order']      = empty($args['order']) ? $ordering_args['order'] : $args['order'];
    }

    return new WP_Query(apply_filters('nasa_woocommerce_query_args', $args));
}

/**
 * Get List products deal
 * @global type $product
 * @return array
 */
function nasa_get_list_products_deal($key_first = false) {
    if (!function_exists('WC')) {
        return array();
    }
    
    $key = !$key_first ? 'nasa_products_deal_in_admin' : 'nasa_products_deal_in_admin_key';
    
    $list = get_transient($key);

    if (!$list) {
        $list = array();
        
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => apply_filters('nasa_limit_admin_products_deal', 100),
            'post_status' => 'publish',
            'paged' => 1
        );

        $args['tax_query'] = array('relation' => 'AND');
        $args['meta_query'] = array();
        $args['meta_query'][] = WC()->query->stock_status_meta_query();
        $args['meta_query'][] = WC()->query->visibility_meta_query();
        $args['meta_query'][] = array(
            'key' => '_sale_price_dates_from',
            'value' => NASA_TIME_NOW,
            'compare' => '<=',
            'type' => 'numeric'
        );
        $args['meta_query'][] = array(
            'key' => '_sale_price_dates_to',
            'value' => NASA_TIME_NOW,
            'compare' => '>',
            'type' => 'numeric'
        );

        $args['post_type'] = array('product', 'product_variation');

        $args['post__in'] = array_merge(array(0), nasa_get_product_deal_ids());

        /**
         * exclude
         */
        $product_visibility_terms = wc_get_product_visibility_term_ids();
        $arr_not_in = array($product_visibility_terms['exclude-from-catalog']);

        // Hide out of stock products.
        if ('yes' === get_option('woocommerce_hide_out_of_stock_items')) {
            $arr_not_in[] = $product_visibility_terms['outofstock'];
        }

        if (!empty($arr_not_in)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field' => 'term_taxonomy_id',
                'terms' => $arr_not_in,
                'operator' => 'NOT IN',
            );
        }

        $args['orderby'] = 'date ID';
        $args['order']   = 'DESC';

        $products = new WP_Query($args);

        if ($products->have_posts()) {
            while ($products->have_posts()) {
                $products->the_post();

                global $product;
                
                if (!$product->is_visible()){
                    continue;
                }
                
                $title = html_entity_decode(get_the_title());
                if (!$key_first) {
                    $list[$title] = $product->get_id();
                } else {
                    $list[$product->get_id()] = $title;
                }
            }
        }
        
        set_transient($key, $list, DAY_IN_SECONDS);
    }

    return $list;
}

/**
 * Get ids include for deal product
 * 
 * @global type $wpdb
 * @param type $cat
 * @return type
 */
function nasa_get_product_deal_ids($cat = null) {
    if (!NASA_WOO_ACTIVED) {
        return null;
    }
    
    $key = 'nasa_products_deal';
    if ($cat) {
        if (is_numeric($cat)) {
            $key .= '_cat_' . $cat;
        }
        
        if (is_array($cat)) {
            $key .= '_cats_' . implode('_', $cat);
        }
        
        if (is_string($cat)) {
            $key .= '_catslug_' . $cat;
        }
    }
    
    $product_ids = get_transient($key);
    
    if (!$product_ids) {
        
        $onsale_ids = array_merge(array(0), wc_get_product_ids_on_sale());
        
        $args = array(
            'post_type'         => array('product', 'product_variation'),
            'numberposts'       => -1,
            'post_status'       => 'publish',
            'fields'            => 'ids'
        );

        $args['tax_query'] = array('relation' => 'AND');

        $args['post__in'] = $onsale_ids;

        // Find by cat id
        if (is_numeric($cat) && $cat) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => array($cat)
            );
        }

        // Find by cat array id
        elseif (is_array($cat) && $cat) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $cat
            );
        }

        // Find by slug
        elseif (is_string($cat) && $cat) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $cat
            );
        }
        
        $args['meta_query'][] = WC()->query->visibility_meta_query();
            
        $args['meta_query'][] = array(
            'key' => '_sale_price_dates_from',
            'value' => NASA_TIME_NOW,
            'compare' => '<=',
            'type' => 'numeric'
        );

        $args['meta_query'][] = array(
            'key' => '_sale_price_dates_to',
            'value' => NASA_TIME_NOW,
            'compare' => '>',
            'type' => 'numeric'
        );

        $product_ids = get_posts($args);
        $product_ids_str = $product_ids ? implode(', ', $product_ids) : false;

        if ($product_ids_str) {
            global $wpdb;
            $variation_obj = $wpdb->get_results('SELECT ID FROM ' . $wpdb->posts . ' WHERE post_parent IN (' . $product_ids_str . ')');

            $variation_ids = $variation_obj ? wp_list_pluck($variation_obj, 'ID') : null;

            if ($variation_ids) {
                foreach ($variation_ids as $v_id) {
                    $product_ids[] = (int) $v_id;
                }
            }
        }

        set_transient($key, $product_ids, DAY_IN_SECONDS);
    }
    
    return $product_ids;
}

/**
 * Get product_ids variation
 */
function nasa_get_deal_product_variation_ids() {
    $key = 'nasa_variation_products_deal';
    $product_ids = get_transient($key);
    
    if (!$product_ids) {
        $v_args = array(
            'post_type'         => 'product_variation',
            'numberposts'       => -1,
            'post_status'       => 'publish',
            'fields'            => 'ids'
        );

        $v_args['tax_query'] = array('relation' => 'AND');
        $v_args['post__in'] = array_merge(array(0), wc_get_product_ids_on_sale());
        
        $v_args['meta_query'][] = WC()->query->visibility_meta_query();

        $v_args['meta_query'][] = array(
            'key' => '_sale_price_dates_from',
            'value' => NASA_TIME_NOW,
            'compare' => '<=',
            'type' => 'numeric'
        );

        $v_args['meta_query'][] = array(
            'key' => '_sale_price_dates_to',
            'value' => NASA_TIME_NOW,
            'compare' => '>',
            'type' => 'numeric'
        );

        $v_ids = get_posts($v_args);
        $product_ids = array(0);
        if ($v_ids) {
            foreach ($v_ids as $v_id) {
                $product_ids[] = (int) $v_id;
            }
        }
        
        set_transient($key, $product_ids, DAY_IN_SECONDS);
    }
    
    return empty($product_ids) ? null : $product_ids;
}

/**
 * Get Products by array id
 * 
 * @param type $ids
 * @return \WP_Query
 */
function nasa_get_products_by_ids($ids = array()) {
    if (!NASA_WOO_ACTIVED || empty($ids)) {
        return null;
    }
    
    $args = array(
        'post_type' => 'product',
        'post__in' => $ids,
        'posts_per_page' => count($ids),
        'post_status' => 'publish',
        'paged' => 1
    );
    
    return new WP_Query($args);
}

/**
 * Recommended product
 * @param type $cat
 */
add_action('nasa_recommend_product', 'nasa_get_recommend_product', 10, 1);
function nasa_get_recommend_product() {
    global $nasa_opt, $wp_query;

    if (!NASA_WOO_ACTIVED || (isset($nasa_opt['enable_recommend_product']) && $nasa_opt['enable_recommend_product'] != '1')) {
        return '';
    }
    
    /**
     * get Featured from Category
     */
    $cat = 0;
    $nasa_obj = $wp_query->get_queried_object();
    if (isset($nasa_obj->term_id) && isset($nasa_obj->taxonomy) && $nasa_obj->taxonomy == 'product_cat') {
        $cat = (int) $nasa_obj->term_id;
    }

    $columns_number = isset($nasa_opt['recommend_columns_desk']) ? (int) $nasa_opt['recommend_columns_desk'] : 5;

    $columns_number_small = isset($nasa_opt['recommend_columns_small']) ? $nasa_opt['recommend_columns_small'] : 2;
    $columns_number_small_slider = $columns_number_small == '1.5-cols' ? '1.5' : (int) $columns_number_small;
    
    $columns_number_tablet = isset($nasa_opt['recommend_columns_tablet']) ? (int) $nasa_opt['recommend_columns_tablet'] : 3;

    $number = (isset($nasa_opt['recommend_product_limit']) && ((int) $nasa_opt['recommend_product_limit'] >= $columns_number)) ? (int) $nasa_opt['recommend_product_limit'] : 9;
    
    $auto_slide = isset($nasa_opt['recommend_slide_auto']) && $nasa_opt['recommend_slide_auto'] ? 'true' : 'false';

    $loop_slide = isset($nasa_opt['infinite_slide']) && $nasa_opt['infinite_slide'] ? 'true' : 'false';

    $loop = nasa_woo_query(array(
        'type' => 'featured_product',
        'post_per_page' => $number,
        'paged' => 1,
        'cat' => (int) $cat ? (int) $cat : null
    ));
    
    if ($loop->found_posts) {
        $class_wrap = 'margin-bottom-50 mobile-margin-bottom-20 nasa-recommend-product';
        if (isset($nasa_opt['recommend_product_position']) && $nasa_opt['recommend_product_position'] == 'bot') :
            $class_wrap .= ' large-12 columns';
        endif;
        ?>
        <div class="<?php echo esc_attr($class_wrap); ?>">
            <div class="woocommerce">
                <?php
                $type = null;
                $height_auto = 'false';
                $arrows = 1;
                $title_shortcode = esc_html__('Recommended Products', 'nasa-core');

                $nasa_args = array(
                    'loop' => $loop,
                    'cat' => $cat,
                    'columns_number' => $columns_number,
                    'columns_number_small_slider' => $columns_number_small_slider,
                    'columns_number_tablet' => $columns_number_tablet,
                    'number' => $number,
                    'auto_slide' => $auto_slide,
                    'loop_slide' => $loop_slide,
                    'type' => $type,
                    'height_auto' => $height_auto,
                    'arrows' => $arrows,
                    'title_shortcode' => $title_shortcode,
                    'title_align' => 'center',
                    'nav_radius' => true,
                    'pos_nav' => 'both',
                    'nasa_opt' => $nasa_opt
                );

                nasa_template('products/nasa_products/carousel.php', $nasa_args);
                ?>
            </div>
            <?php
            if (isset($nasa_opt['recommend_product_position']) && $nasa_opt['recommend_product_position'] == 'top') :
                echo '<hr class="nasa-separator" />';
            endif;
            ?>
        </div>
        <?php
    }
}

/**
 * Get product Deal by id
 * 
 * @param type $id
 * @return type
 */
function nasa_get_product_deal($id = null) {
    if (!(int) $id || !NASA_WOO_ACTIVED) {
        return null;
    }

    $product = wc_get_product((int) $id);

    if ($product) {
        $time_sale = get_post_meta((int) $id, '_sale_price_dates_to', true);
        $time_from = get_post_meta((int) $id, '_sale_price_dates_from', true);

        if ($time_sale > NASA_TIME_NOW && (!$time_from || $time_from < NASA_TIME_NOW)) {
            $product->time_sale = $time_sale;
            
            return $product;
        }
    }

    return null;
}

/**
 * Get products in grid
 * 
 * @param type $notid
 * @param type $catIds
 * @param type $type
 * @param type $limit
 * @return type
 */
function nasa_get_products_grid($notid = null, $catIds = null, $type = 'best_selling', $limit = 6) {
    $notIn = $notid ? array($notid) : array();
    
    return nasa_woocommerce_query($type, $limit, $catIds, 1, $notIn);
}

/**
 * Set cookie products viewed
 */
remove_action('template_redirect', 'wc_track_product_view', 25);
add_action('template_redirect', 'nasa_set_products_viewed', 20);
function nasa_set_products_viewed() {
    global $nasa_opt;

    if (!NASA_WOO_ACTIVED || !is_singular('product') || (isset($nasa_opt['enable-viewed']) && !$nasa_opt['enable-viewed'])) {
        return;
    }

    global $post;

    $product_id = isset($post->ID) ? (int) $post->ID : 0;
    if ($product_id) {
        $limit = !isset($nasa_opt['limit_product_viewed']) || !(int) $nasa_opt['limit_product_viewed'] ?
            12 : (int) $nasa_opt['limit_product_viewed'];

        $list_viewed = !empty($_COOKIE[NASA_COOKIE_VIEWED]) ? explode('|', $_COOKIE[NASA_COOKIE_VIEWED]) : array();
        if (!in_array((int) $product_id, $list_viewed)) {
            $new_array = array(0 => $product_id);
            
            for ($i = 1; $i < $limit; $i++) {
                if (isset($list_viewed[$i-1])) {
                    $new_array[$i] = $list_viewed[$i-1];
                }
            }
            
            $new_array_str = !empty($new_array) ? implode('|', $new_array) : '';
            setcookie(NASA_COOKIE_VIEWED, $new_array_str, 0, COOKIEPATH, COOKIE_DOMAIN, false, false);
        }
    }
}

/**
 * Check category products page
 */
add_action('template_redirect', 'nasa_check_category_product_page');
if (!function_exists('nasa_check_category_product_page')) :
    function nasa_check_category_product_page() {
        if (NASA_WOO_ACTIVED && is_product_category()) {
            add_action('nasa_after_breadcrumb', 'nasa_cat_after_breadcrumb');
        }
    }
endif;

/**
 * After Breadcrumb for category Products
 */
if (!function_exists('nasa_cat_after_breadcrumb')) :
    function nasa_cat_after_breadcrumb() {
        global $wp_query;
            
        $current_cat = $wp_query->get_queried_object();
        
        if (!isset($current_cat->term_id) || !$current_cat->term_id) {
            return;
        }

        $brdc_blk = get_term_meta($current_cat->term_id, 'cat_bread_after', true);
        
        if ($brdc_blk) {
            $do_content = nasa_get_block($brdc_blk);
            
            if (trim($do_content) != '') {
                echo '<div class="nasa-archive-after-breadcrumb large-12 columns">';
                echo $do_content;
                echo '</div>';
            }
        }
    }
endif;

/**
 * set nasa_opt - Single Product page
 */
add_action('template_redirect', 'nasa_single_product_opts', 999);
function nasa_single_product_opts() {
    if (!NASA_WOO_ACTIVED || !is_product()) {
        return;
    }
    
    global $nasa_opt, $post;
    
    if (!isset($post->ID)) {
        return;
    }
    
    $in_mobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
    $mobile_app = ($in_mobile && isset($nasa_opt['mobile_layout']) && $nasa_opt['mobile_layout'] == 'app') ? true : false;
    
    $product_id = $post->ID;
    $root_cat_id = nasa_root_term_id();
    
    $layouts_role = array('classic', 'new', 'new-2', 'full', 'modern-1', 'modern-2', 'modern-3');
    $sidebars_role = array('left', 'right', 'no');
    
    /**
     * Layout: New | Classic
     */
    $nasa_opt['product_detail_layout'] = isset($nasa_opt['product_detail_layout']) && in_array($nasa_opt['product_detail_layout'], $layouts_role) ? $nasa_opt['product_detail_layout'] : 'new';

    $nasa_opt['product_thumbs_style'] = isset($nasa_opt['product_thumbs_style']) && $nasa_opt['product_thumbs_style'] == 'hoz' ? $nasa_opt['product_thumbs_style'] : 'ver';
    
    /**
     * Image Layout Style
     */
    $image_layout = 'single';
    $image_style = 'slide';

    if ($nasa_opt['product_detail_layout'] == 'new') {
        $image_layout = (!isset($nasa_opt['product_image_layout']) || $nasa_opt['product_image_layout'] == 'double') ? 'double' : 'single';
        $image_style = (!isset($nasa_opt['product_image_style']) || $nasa_opt['product_image_style'] == 'slide') ? 'slide' : 'scroll';
    }

    if ($nasa_opt['product_detail_layout'] == 'new-2') {
        $image_layout = 'grid-2';
        $image_style = 'grid-2';
    }

    $nasa_opt['product_image_layout'] = $image_layout;
    $nasa_opt['product_image_style'] = $image_style;
    
    /**
     * Sidebar Position
     */
    $single_sidebar = nasa_get_product_meta_value($product_id, 'nasa_sidebar');
    if ($single_sidebar) {
        if (in_array($single_sidebar, $sidebars_role)) {
            $nasa_opt['product_sidebar'] = $single_sidebar;
        }
    } elseif ($root_cat_id) {
        $single_sidebar = get_term_meta($root_cat_id, 'single_product_sidebar', true);

        if (in_array($single_sidebar, $sidebars_role)) {
            $nasa_opt['product_sidebar'] = $single_sidebar;
        }
    }
    
    /**
     * Product Layout
     */
    $single_layout = $mobile_app ? 'classic' : nasa_get_product_meta_value($product_id, 'nasa_layout');
    
    if ($single_layout) {
        if (in_array($single_layout, $layouts_role)) {
            $nasa_opt['product_detail_layout'] = $single_layout;
        }

        if ($single_layout == 'new') {
            $single_imageLayouts = nasa_get_product_meta_value($product_id, 'nasa_image_layout');
            
            $nasa_opt['product_image_layout'] = $single_imageLayouts ? $single_imageLayouts : $nasa_opt['product_image_layout'];

            $single_imageStyle = nasa_get_product_meta_value($product_id, 'nasa_image_style');
            
            $nasa_opt['product_image_style'] = $single_imageStyle ? $single_imageStyle : $nasa_opt['product_image_style'];
        }

        if ($single_layout == 'new-2') {
            $nasa_opt['product_image_layout'] = 'grid-2';
            $nasa_opt['product_image_style'] = 'grid-2';
        }

        if ($single_layout == 'classic') {
            $single_thumbStyle = nasa_get_product_meta_value($product_id, 'nasa_thumb_style');
            
            $nasa_opt['product_image_style'] = 'slide';
            $nasa_opt['product_thumbs_style'] = $single_thumbStyle ? $single_thumbStyle : $nasa_opt['product_thumbs_style'];
        }
        
        if ($single_layout == 'full') {
            $nasa_opt['product_image_style'] = 'slide';
            
            $half_item = nasa_get_product_meta_value($product_id, 'nasa_half_full_slide');
            $nasa_opt['half_full_slide'] = $half_item;
            
            $info_columns = nasa_get_product_meta_value($product_id, 'nasa_full_info_col');
            $nasa_opt['full_info_col'] = $info_columns;
        }
        
        if (in_array($single_layout, array('modern-2', 'modern-3'))) {
            $_product_layout_bg = nasa_get_product_meta_value($product_id, 'nasa_layout_bg');
            if ($_product_layout_bg) {
                $nasa_opt['sp_bgl'] = $_product_layout_bg;
                
                add_action('wp_enqueue_scripts', 'nasa_single_product_css_modern', 1000);
            }
        }
        
        if (in_array($single_layout, array('modern-1', 'modern-2', 'modern-3'))) {
            $nasa_opt['product_image_style'] = 'slide';
        }

        if (in_array($single_layout, array('modern-1', 'modern-2', 'modern-3','classic','new'))) {
            $infinite_slide = nasa_get_product_meta_value($product_id, 'nasa_infinite_slide');

            $nasa_opt['product_slide_loop'] = $infinite_slide;
        }
    }

    /**
     * Override with root Category - Product Layout
     */
    elseif ($root_cat_id) {
        /**
         * Sidebar Layout
         */
        $_product_layout = $mobile_app ? 'classic' : get_term_meta($root_cat_id, 'single_product_layout', true);

        if (in_array($_product_layout, $layouts_role)) {
            $nasa_opt['product_detail_layout'] = $_product_layout;
        }

        if ($_product_layout == 'new') {
            $product_image_layout = get_term_meta($root_cat_id, 'single_product_image_layout', true);
            $nasa_opt['product_image_layout'] = $product_image_layout ? $product_image_layout : $nasa_opt['product_image_layout'];

            $product_image_style = get_term_meta($root_cat_id, 'single_product_image_style', true);
            $nasa_opt['product_image_style'] = $product_image_style ? $product_image_style : $nasa_opt['product_image_style'];
        }

        if ($_product_layout == 'new-2') {
            $nasa_opt['product_image_layout'] = 'grid-2';
            $nasa_opt['product_image_style'] = 'grid-2';
        }

        if ($_product_layout == 'classic') {
            $nasa_opt['product_image_style'] = 'slide';

            $product_thumbs_style = get_term_meta($root_cat_id, 'single_product_thumbs_style', true);
            
            $nasa_opt['product_thumbs_style'] = $product_thumbs_style ? $product_thumbs_style : $nasa_opt['product_thumbs_style'];
        }
        
        if ($_product_layout == 'full') {
            $nasa_opt['product_image_style'] = 'slide';
            
            $half_item = get_term_meta($root_cat_id, 'single_product_half_full_slide', true);
            $nasa_opt['half_full_slide'] = $half_item;
            
            $info_columns = get_term_meta($root_cat_id, 'single_product_full_info_col', true);
            $nasa_opt['full_info_col'] = $info_columns;
        }
        
        if (in_array($_product_layout, array('modern-2', 'modern-3'))) {
            $_product_layout_bg = get_term_meta($root_cat_id, 'single_product_layout_bg', true);
            if ($_product_layout_bg) {
                $nasa_opt['sp_bgl'] = $_product_layout_bg;
                
                add_action('wp_enqueue_scripts', 'nasa_single_product_css_modern', 1000);
            }
        }
        
        if (in_array($_product_layout, array('modern-1', 'modern-2', 'modern-3'))) {
            $nasa_opt['product_image_style'] = 'slide';
        }
    }
    
    /**
     * Single Product Info Columns
     */
    if (isset($nasa_opt['product_detail_layout'])) {
        
        /**
         * Slide Full-width 2 columns
         */
        if (
            $nasa_opt['product_detail_layout'] == 'full' &&
            isset($nasa_opt['full_info_col']) &&
            $nasa_opt['full_info_col'] == 2
        ) {
            add_action('woocommerce_single_product_summary', 'nasa_single_product_full_open_wrap', 7);
            add_action('woocommerce_single_product_summary', 'nasa_single_product_tag_close', 9999);

            add_action('woocommerce_single_product_summary', 'nasa_single_product_full_open_col', 8);
            add_action('woocommerce_single_product_summary', 'nasa_single_product_tag_close', 999);

            add_action('woocommerce_single_product_summary', 'nasa_single_product_full_open_col', 1005);
            add_action('woocommerce_single_product_summary', 'nasa_single_product_tag_close', 9998);

            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 20);
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 1010);

            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 1020);

            remove_action('woocommerce_single_product_summary', 'nasa_after_add_to_cart_form', 50);
            add_action('woocommerce_single_product_summary', 'nasa_after_add_to_cart_form', 1030);
        }
        
        /**
         * Slide | Info | Cart form => Layout Modern #1
         */
        if ($nasa_opt['product_detail_layout'] == 'modern-1') {
            add_action('woocommerce_single_product_summary', 'nasa_single_product_md_1_open_wrap', 1);
            add_action('woocommerce_single_product_summary', 'nasa_single_product_tag_close', 9999);

            add_action('woocommerce_single_product_summary', 'nasa_single_product_md_1_open_col', 2);
            add_action('woocommerce_single_product_summary', 'nasa_single_product_tag_close', 999);

            add_action('woocommerce_single_product_summary', 'nasa_single_product_md_1_open_col', 1005);
            add_action('woocommerce_single_product_summary', 'nasa_single_product_tag_close', 9998);

            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 20);
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 1010);
            
            // Deal time for Single product
            if (!isset($nasa_opt['single-product-deal']) || $nasa_opt['single-product-deal']) {
                remove_action('woocommerce_single_product_summary', 'elessi_deal_time_single', 29);
                add_action('woocommerce_single_product_summary', 'elessi_deal_time_single', 1030);
            }

            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 1040);
        }
    }
    
    /**
     * Override in Single Product Tab style
     */
    $tab_style = $mobile_app ? 'ver-2' : nasa_get_product_meta_value($product_id, 'nasa_tab_style');
    if ($tab_style) {
        $nasa_opt['tab_style_info'] = $tab_style;
    }

    /**
     * Override in Root Category - Single Product Tab style
     */
    else {
        if ($root_cat_id) {
            $tab_style = $mobile_app ? 'small-accordion' : get_term_meta($root_cat_id, 'single_product_tabs_style', true);
            if ($tab_style) {
                $nasa_opt['tab_style_info'] = $tab_style;
            }
        }
    }
    
    /**
     * Single Product WooCommerce Tabs - Actions
     */
    if (isset($nasa_opt['tab_style_info']) && $nasa_opt['tab_style_info'] == 'small-accordion') {
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
        
        add_action('woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 99990);
        
        if (!isset($nasa_opt['pmeta_info']) || $nasa_opt['pmeta_info'] !== 'df') {
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 99999);
            
            if (function_exists('elessi_clearboth')) {
                remove_action('woocommerce_after_single_product_summary', 'elessi_clearboth', 11);
            }

            if (function_exists('elessi_open_wrap_12_cols')) {
                remove_action('woocommerce_after_single_product_summary', 'elessi_open_wrap_12_cols', 11);
            }

            remove_action('woocommerce_after_single_product_summary', 'woocommerce_template_single_meta', 11);

            if (function_exists('elessi_open_wrap_12_cols')) {
                remove_action('woocommerce_after_single_product_summary', 'elessi_close_wrap_12_cols', 11);
            }
        }
    }
    
    $GLOBALS['nasa_opt'] = $nasa_opt;
}

function nasa_single_product_css_modern() {
    if (!wp_style_is('elessi-style-dynamic')) {
        return;
    }
    
    global $nasa_opt;
    
    if (isset($nasa_opt['sp_bgl']) && $nasa_opt['sp_bgl']) {
        $style = '.single-product.nasa-spl-modern-2 .site-header, .single-product.nasa-spl-modern-3 .site-header, .single-product.nasa-spl-modern-2 .nasa-breadcrumb, .single-product.nasa-spl-modern-3 .nasa-breadcrumb {background-color: ' . esc_attr($nasa_opt['sp_bgl']) . ';}';
        wp_add_inline_style('elessi-style-dynamic', $style);
    }
}

function nasa_single_product_full_open_wrap() {
    echo '<div class="nasa-wrap-flex nasa-flex text-left rtl-text-right jst">';
}

function nasa_single_product_full_open_col() {
    echo '<div class="nasa-col-flex">';
}

function nasa_single_product_md_1_open_wrap() {
    echo '<div class="nasa-wrap-flex nasa-flex info-modern-1 text-left rtl-text-right jst align-start">';
}

function nasa_single_product_md_1_open_col() {
    echo '<div class="nasa-col-flex nasa-relative">';
}

function nasa_single_product_tag_close() {
    echo '</div>';
}

/**
 * Get cookie products viewed
 */
function nasa_get_products_viewed() {
    global $nasa_opt;
    $query = null;

    if (!NASA_WOO_ACTIVED || (isset($nasa_opt['enable-viewed']) && !$nasa_opt['enable-viewed'])) {
        return $query;
    }

    $viewed_products = !empty($_COOKIE[NASA_COOKIE_VIEWED]) ? explode('|', $_COOKIE[NASA_COOKIE_VIEWED]) : array();
    if (!empty($viewed_products)) {

        $limit = !isset($nasa_opt['limit_product_viewed']) || !(int) $nasa_opt['limit_product_viewed'] ? 12 : (int) $nasa_opt['limit_product_viewed'];

        $query_args = array(
            'posts_per_page' => $limit,
            'no_found_rows' => 1,
            'post_status' => 'publish',
            'post_type' => 'product',
            'post__in' => $viewed_products,
            'orderby' => 'post__in',
        );

        if ('yes' === get_option('woocommerce_hide_out_of_stock_items')) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field' => 'name',
                    'terms' => 'outofstock',
                    'operator' => 'NOT IN',
                ),
            );
        }

        $query = new WP_Query($query_args);
    }

    return $query;
}

/**
 * Static Viewed Sidebar
 */
add_action('nasa_static_content', 'nasa_static_viewed_sidebar', 15);
function nasa_static_viewed_sidebar() {
    global $nasa_opt;
    
    if (!NASA_WOO_ACTIVED || (isset($nasa_opt['enable-viewed']) && !$nasa_opt['enable-viewed'])) {
        return;
    }
    
    /**
     * Turn off Viewed Canvas
     */
    if ((isset($nasa_opt['viewed_canvas']) && !$nasa_opt['viewed_canvas'])) {
        return;
    }
    
    $nasa_viewed_style = 'nasa-static-sidebar ';
    $nasa_viewed_style .= isset($nasa_opt['style-viewed']) ? $nasa_opt['style-viewed'] : 'style-1'; ?>
    
    <!-- viewed product -->
    <div id="nasa-viewed-sidebar" class="<?php echo esc_attr($nasa_viewed_style); ?>">
        <div class="viewed-close nasa-sidebar-close">
            <a href="javascript:void(0);" title="<?php esc_attr_e('Close', 'nasa-core'); ?>" rel="nofollow"><?php esc_html_e('Close', 'nasa-core'); ?></a>
            
            <span class="nasa-tit-viewed nasa-sidebar-tit text-center">
                <?php echo esc_html__("Recently Viewed", 'nasa-core'); ?>
            </span>
        </div>
        
        <div id="nasa-viewed-sidebar-content" class="nasa-absolute">
            <div class="nasa-loader"></div>
        </div>
    </div>
    <?php
}

/**
 * Viewed icon button
 */
add_action('nasa_static_group_btns', 'nasa_static_viewed_btns', 15);
function nasa_static_viewed_btns() {
    global $nasa_opt;
    if (!NASA_WOO_ACTIVED || (isset($nasa_opt['enable-viewed']) && !$nasa_opt['enable-viewed'])) {
        return;
    }
    
    /**
     * Turn off Viewed Canvas
     */
    if ((isset($nasa_opt['viewed_canvas']) && !$nasa_opt['viewed_canvas'])) {
        return;
    }
    ?>
    
    <?php
    $nasa_viewed_icon = 'nasa-tip nasa-tip-left ';
    $nasa_viewed_icon .= isset($nasa_opt['style-viewed-icon']) ? esc_attr($nasa_opt['style-viewed-icon']) : 'style-1';
    ?>
    <a id="nasa-init-viewed" class="<?php echo esc_attr($nasa_viewed_icon); ?>" href="javascript:void(0);" data-tip="<?php esc_attr_e('Recently Viewed', 'nasa-core'); ?>" title="<?php esc_attr_e('Recently Viewed', 'nasa-core'); ?>" rel="nofollow">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="26" height="26" viewBox="0 0 32 32" fill="currentColor">
            <path d="M16 3.205c-7.066 0-12.795 5.729-12.795 12.795s5.729 12.795 12.795 12.795 12.795-5.729 12.795-12.795c0-7.066-5.729-12.795-12.795-12.795zM16 27.729c-6.467 0-11.729-5.261-11.729-11.729s5.261-11.729 11.729-11.729 11.729 5.261 11.729 11.729c0 6.467-5.261 11.729-11.729 11.729z"/>
            <path d="M16 17.066h-6.398v1.066h7.464v-10.619h-1.066z"/>
        </svg>
    </a>
    <?php
}

/**
 * Get product meta value
 */
function nasa_get_product_meta_value($product_id = 0, $field = null) {
    $meta_value = '';
    
    if (!$product_id) {
        return $meta_value;
    }
    
    global $nasa_product_meta;
    
    if (isset($nasa_product_meta[$product_id])) {
        $meta_value = $nasa_product_meta[$product_id];
    } else {
        $get_meta_value = get_post_meta($product_id, 'wc_productdata_options', true);
        $meta_value = isset($get_meta_value[0]) ? $get_meta_value[0] : $get_meta_value;
        
        $nasa_product_meta = !$nasa_product_meta ? array() : $nasa_product_meta;
        $nasa_product_meta[$product_id] = $meta_value;
        
        $GLOBALS['nasa_product_meta'] = $nasa_product_meta;
    }
    
    if (is_array($meta_value) && $field) {
        return isset($meta_value[$field]) ? $meta_value[$field] : '';
    }

    return $meta_value;
}

/**
 * Get variation meta value
 */
function nasa_get_variation_meta_value($variation_id = 0, $field = null) {
    $meta_value = '';
    
    if (!$variation_id) {
        return $meta_value;
    }
    
    global $nasa_variation_meta;
    
    if (isset($nasa_variation_meta[$variation_id])) {
        $meta_value = $nasa_variation_meta[$variation_id];
    } else {
        $meta_value = get_post_meta($variation_id, 'wc_variation_custom_fields', true);
        
        $nasa_variation_meta = !$nasa_variation_meta ? array() : $nasa_variation_meta;
        $nasa_variation_meta[$variation_id] = $meta_value;
        
        $GLOBALS['nasa_variation_meta'] = $nasa_variation_meta;
    }
    
    if (is_array($meta_value) && $field) {
        return isset($meta_value[$field]) ? $meta_value[$field] : '';
    }

    return $meta_value;
}

/**
 * variation gallery images
 */
add_filter('woocommerce_available_variation', 'nasa_variation_gallery_images');
function nasa_variation_gallery_images($variation) {
    global $nasa_opt;
    
    if (!isset($nasa_opt['gallery_images_variation']) || $nasa_opt['gallery_images_variation']) {
        if (!isset($variation['nasa_gallery_variation'])) {
            $variation['nasa_gallery_variation'] = array();
            // $variation['nasa_variation_back_img'] = '';
            $gallery = get_post_meta($variation['variation_id'], 'nasa_variation_gallery_images', true);

            if ($gallery) {
                $variation['nasa_gallery_variation'] = $gallery;
                
                $gallery_ids = explode(',', $gallery);
                
                $image_size = apply_filters('single_product_archive_thumbnail_size', 'woocommerce_thumbnail');
                
                if ($gallery_ids) {
                    $variation['nasa_variation_back_gallery'] = array();
                    
                    foreach ($gallery_ids as $gallery_id) {
                        $img = wp_get_attachment_image_src($gallery_id, $image_size);

                        if ($img) {
                            $variation['nasa_variation_back_gallery'][] = array(
                                'src' => $img[0],
                                'w' => $img[1],
                                'h' => $img[2]
                            );

                            if (!isset($variation['nasa_variation_back_img'])) {
                                $variation['nasa_variation_back_img'] = $img[0];
                            }
                        }
                    }
                }
            }
        }
    }
    
    return $variation;
}

/**
 * Enable Gallery images variation in front-end
 */
add_action('woocommerce_after_add_to_cart_button', 'nasa_enable_variation_gallery_images', 30);
function nasa_enable_variation_gallery_images() {
    global $product, $nasa_opt;
    
    if (isset($nasa_opt['gallery_images_variation']) && !$nasa_opt['gallery_images_variation']) {
        return;
    }

    $productType = $product->get_type();
    if ($productType == 'variable' || $productType == 'variation') {
        $main_product = ($productType == 'variation') ?
            wc_get_product(wp_get_post_parent_id($product->get_id())) : $product;

        $variations = $main_product ? $main_product->get_available_variations() : null;
        if (!empty($variations)) {
            foreach ($variations as $vari) {
                if (isset($vari['nasa_gallery_variation']) && !empty($vari['nasa_gallery_variation'])) {
                    echo '<input type="hidden" name="nasa-gallery-variation-supported" class="nasa-gallery-variation-supported" value="1" />';
                    return;
                }
            }
        }
    }
}

/**
 * Size Guide Product - Delivery & Return
 */
add_action('woocommerce_single_product_summary', 'nasa_single_product_popup_nodes', 35);
function nasa_single_product_popup_nodes() {
    global $nasa_opt, $product;
    
    /**
     * Size Guide - New Feature get content from static Block
     */
    $size_guide = false;
    
    $product_id = $product->get_id();
    $p_sizeguide = nasa_get_product_meta_value($product_id, '_product_size_guide');
    
    if ($p_sizeguide == '-1') {
        $size_guide = 'not-show';
    }
    
    /**
     * Get size_guide from category
     */
    elseif ($p_sizeguide == '') {
        $term_id = nasa_root_term_id();

        if ($term_id) {
            $size_guide_cat = get_term_meta($term_id, 'cat_size_guide_block', true);
            
            if ($size_guide_cat) {
                $size_guide = $size_guide_cat != '-1' ? nasa_get_block($size_guide_cat) : 'not-show';
            }
        }
    }
    
    /**
     * For Private Product
     */
    else {
        $size_guide = nasa_get_block($p_sizeguide);
    }

    /**
     * Get size_guide from Theme Options
     */
    if (!$size_guide && isset($nasa_opt['size_guide_product']) && $nasa_opt['size_guide_product']) {
        $size_guide = nasa_get_block($nasa_opt['size_guide_product']);
    }
    
    /**
     * Not show from Category
     */
    if ($size_guide == 'not-show') {
        $size_guide = false;
    }
    
    /**
     * Delivery & Return
     */
    $delivery_return = false;
    if (isset($nasa_opt['delivery_return_single_product']) && $nasa_opt['delivery_return_single_product']) {
        $delivery_return = nasa_get_block($nasa_opt['delivery_return_single_product']);
    }
    
    /**
     * Ask a Question
     */
    $ask_a_question = false;
    if (isset($nasa_opt['ask_a_question']) && $nasa_opt['ask_a_question']) {
        $ask_a_question = shortcode_exists('contact-form-7') ? do_shortcode('[contact-form-7 id="' . ((int) $nasa_opt['ask_a_question']) . '"]') : false;
        
        if ($ask_a_question == '[contact-form-7 404 "Not Found"]') {
            $ask_a_question = false;
        }
    }
    
    /**
     * Request a Call Back
     */
    $request_a_callback = false;
    if (isset($nasa_opt['request_a_callback']) && $nasa_opt['request_a_callback']) {
        $request_a_callback = shortcode_exists('contact-form-7') ? do_shortcode('[contact-form-7 id="' . ((int) $nasa_opt['request_a_callback']) . '"]') : false;
        
        if ($request_a_callback == '[contact-form-7 404 "Not Found"]') {
            $request_a_callback = false;
        }
    }
    
    /**
     * Args Template
     */
    $nasa_args = array(
        'size_guide' => $size_guide,
        'delivery_return' => $delivery_return,
        'ask_a_question' => $ask_a_question,
        'request_a_callback' => $request_a_callback,
        'single_product' => $product
    );
    
    /**
     * Include template
     */
    nasa_template('products/nasa_single_product/nasa-single-product-popup-nodes.php', $nasa_args);
}

/**
 * Viewed icon button
 */
add_action('nasa_static_group_btns', 'nasa_static_request_callback', 12);
function nasa_static_request_callback() {
    global $nasa_opt;
    
    if (!isset($nasa_opt['request_a_callback']) || !$nasa_opt['request_a_callback']) {
        return;
    }
    
    if (!NASA_WOO_ACTIVED || !is_product()) {
        return;
    } ?>
    
    <a class="nasa-node-popup hidden-tag nasa-tip nasa-tip-left" href="javascript:void(0);" data-target="#nasa-content-request-a-callback" data-tip="<?php echo esc_attr__('Request a Call Back', 'nasa-core'); ?>" title="<?php echo esc_attr__('Request a Call Back', 'nasa-core'); ?>" rel="nofollow">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="22" height="22" viewBox="0 0 64 64" fill="currentColor">
            <g transform="translate(0,64) scale(0.0125,-0.0125)">
                <path d="M2310 5004 c-395 -53 -762 -234 -1048 -517 -277 -274 -463 -632 -522 -1002 -18 -116 -17 -113 -68 -139 -56 -29 -102 -75 -131 -133 -17 -35 -29 -44 -71 -58 -84 -28 -141 -65 -216 -139 -85 -85 -143 -180 -190 -311 -53 -149 -67 -251 -61 -445 5 -183 28 -295 85 -422 87 -192 231 -338 378 -385 46 -14 57 -23 75 -57 122 -239 474 -221 568 28 21 56 21 64 21 881 0 797 -1 826 -20 877 -25 67 -69 121 -126 154 l-45 26 6 47 c4 25 17 91 30 146 137 583 602 1054 1185 1200 146 36 242 48 400 48 158 0 254 -12 400 -48 583 -146 1048 -617 1185 -1200 13 -55 26 -121 30 -146 l6 -47 -45 -26 c-57 -33 -101 -87 -126 -154 -19 -51 -20 -80 -20 -877 0 -817 0 -825 21 -881 25 -68 82 -133 139 -160 40 -19 40 -19 34 -64 -22 -166 -79 -287 -183 -390 -83 -83 -154 -123 -281 -161 -66 -19 -105 -22 -315 -26 l-240 -4 -37 59 c-39 62 -92 105 -155 128 -29 10 -115 13 -360 14 -298 0 -326 -1 -376 -20 -59 -22 -129 -85 -158 -143 -69 -134 -31 -303 89 -394 77 -58 111 -63 448 -63 285 0 307 1 360 21 66 25 137 86 165 141 l19 38 138 0 c311 0 483 27 639 100 166 77 287 195 367 357 54 110 96 261 96 348 0 26 6 34 35 48 52 25 118 89 143 140 19 38 29 46 68 57 143 40 295 191 380 376 63 137 86 246 91 434 6 194 -8 296 -61 445 -47 131 -105 226 -190 311 -75 74 -132 111 -216 139 -42 14 -54 23 -71 58 -29 58 -75 104 -131 133 -51 26 -50 23 -68 139 -59 370 -245 728 -522 1002 -406 403 -976 593 -1548 517z m-1428 -1861 c10 -9 23 -32 29 -52 7 -24 9 -294 7 -814 l-3 -779 -33 -29 c-42 -38 -82 -38 -124 0 l-33 29 0 805 c0 791 0 805 20 827 38 43 98 49 137 13z m3488 -8 l25 -25 0 -806 0 -806 -33 -29 c-42 -38 -82 -38 -124 0 l-33 29 -3 789 c-2 736 -1 790 15 823 33 64 102 75 153 25z m-3860 -830 l0 -636 -27 15 c-93 48 -200 215 -245 381 -31 116 -31 365 1 479 43 159 127 297 225 368 21 15 41 28 43 28 1 0 3 -286 3 -635z m4216 542 c63 -68 124 -186 155 -303 32 -114 32 -363 1 -479 -45 -166 -152 -333 -244 -381 l-28 -15 0 636 0 636 31 -18 c17 -10 55 -44 85 -76z m-1816 -2252 c84 -44 59 -163 -38 -179 -62 -10 -494 -7 -534 4 -88 25 -104 133 -27 176 37 21 559 20 599 -1z"/>
            </g>
        </svg>
    </a>
    
    <?php
}

/**
 * After Add To Cart Button
 */
// add_action('woocommerce_after_add_to_cart_form', 'nasa_after_add_to_cart_form');
add_action('woocommerce_single_product_summary', 'nasa_after_add_to_cart_form', 50);
function nasa_after_add_to_cart_form() {
    global $nasa_opt;
    
    if (isset($nasa_opt['after_single_addtocart_form']) && $nasa_opt['after_single_addtocart_form']) {
        echo nasa_get_block($nasa_opt['after_single_addtocart_form']);
    }
}

/**
 * After Process To Checkout Button
 */
add_action('woocommerce_proceed_to_checkout', 'nasa_after_process_checkout_button', 100);
function nasa_after_process_checkout_button() {
    global $nasa_opt;
    
    if (isset($nasa_opt['after_process_checkout']) && $nasa_opt['after_process_checkout']) {
        echo nasa_get_block($nasa_opt['after_process_checkout']);
    }
}

/**
 * After Cart Table
 */
add_action('woocommerce_after_cart_table', 'nasa_after_cart_table');
function nasa_after_cart_table() {
    global $nasa_opt;
    
    if (isset($nasa_opt['after_cart_table']) && $nasa_opt['after_cart_table']) {
        echo nasa_get_block($nasa_opt['after_cart_table']);
    }
}

/**
 * After Cart content
 */
add_action('woocommerce_after_cart', 'nasa_after_cart', 5);
function nasa_after_cart() {
    global $nasa_opt;
    
    if (isset($nasa_opt['after_cart']) && $nasa_opt['after_cart']) {
        echo nasa_get_block($nasa_opt['after_cart']);
    }
}

/**
 * After Place Order Button
 */
add_action('woocommerce_review_order_after_payment', 'nasa_after_place_order_button');
function nasa_after_place_order_button() {
    global $nasa_opt;
    
    if (isset($nasa_opt['after_place_order']) && $nasa_opt['after_place_order']) {
        echo nasa_get_block($nasa_opt['after_place_order']);
    }
}

/**
 * After review order
 */
if (defined('NASA_THEME_ACTIVE') && NASA_THEME_ACTIVE) {
    add_action('nasa_checkout_after_order_review', 'nasa_after_review_order_payment');
} else {
    add_action('woocommerce_checkout_after_order_review', 'nasa_after_review_order_payment');
}
function nasa_after_review_order_payment() {
    global $nasa_opt;
    
    if (isset($nasa_opt['after_review_order']) && $nasa_opt['after_review_order']) {
        echo nasa_get_block($nasa_opt['after_review_order']);
    }
}

/**
 * After Checkout Customer Detail
 */
add_action('woocommerce_checkout_after_customer_details', 'nasa_checkout_after_customer_details', 100);
function nasa_checkout_after_customer_details() {
    global $nasa_opt;
    
    if (isset($nasa_opt['after_checkout_customer']) && $nasa_opt['after_checkout_customer']) {
        echo nasa_get_block($nasa_opt['after_checkout_customer']);
    }
}

/**
 * Custom Slug Nasa Custom Categories
 */
add_filter('nasa_taxonomy_custom_cateogory', 'nasa_custom_slug_categories');
function nasa_custom_slug_categories($slug) {
    global $nasa_opt;
    
    if (!NASA_WOO_ACTIVED || !isset($nasa_opt['enable_nasa_custom_categories']) || !$nasa_opt['enable_nasa_custom_categories']) {
        return $slug;
    }
    
    /**
     * Get From Option
     */
    if (!isset($nasa_opt['nasa_custom_categories_slug'])) {
        $nasa_opt['nasa_custom_categories_slug'] = get_option('nasa_custom_categories_slug', 'nasa_product_cat');
    }
    
    if (trim($nasa_opt['nasa_custom_categories_slug']) === '') {
        return $slug;
    }
    
    $new_slug = sanitize_title(trim($nasa_opt['nasa_custom_categories_slug']));
    
    return $new_slug;
}

/**
 * Custom nasa-taxonomy
 */
add_action('nasa_before_archive_products', 'nasa_custom_filter_taxonomies');
function nasa_custom_filter_taxonomies() {
    global $nasa_opt;
    
    if (!NASA_WOO_ACTIVED || !isset($nasa_opt['enable_nasa_custom_categories']) || !$nasa_opt['enable_nasa_custom_categories']) {
        return;
    }
    
    $root_cat_id = nasa_root_term_id();
    
    $show = '';
    if ($root_cat_id) {
        $show = get_term_meta($root_cat_id, 'nasa_custom_tax', true);
    }
    
    if ($show == '') {
        $show = isset($nasa_opt['archive_product_nasa_custom_categories']) && $nasa_opt['archive_product_nasa_custom_categories'] ? 'show' : 'hide';
    }
    
    if ($show === 'hide') {
        return;
    }

    $class = 'large-12 columns';
    $max = isset($nasa_opt['max_level_nasa_custom_categories']) ? (int) $nasa_opt['max_level_nasa_custom_categories'] : 3;
    $max_level = $max > 3 || $max < 1 ? 3 : $max;
    
    echo '<div class="' . esc_attr($class) . '">';
    echo do_shortcode('[nasa_product_nasa_categories deep_level="' . esc_attr($max_level) . '" el_class="margin-top-15 mobile-margin-top-10"]');
    echo '</div>';
}

/**
 * 360 Degree Product Viewer
 */
add_action('nasa_single_buttons', 'nasa_360_product_viewer', 25);
function nasa_360_product_viewer() {
    global $nasa_opt, $product;
    if (isset($nasa_opt['product_360_degree']) && !$nasa_opt['product_360_degree']) {
        return;
    }
    
    /**
     * 360 Degree Product Viewer
     * 
     * jQuery lib
     */
    wp_enqueue_script('jquery-threesixty', NASA_CORE_PLUGIN_URL . 'assets/js/min/threesixty.min.js', array('jquery'), null, true);
    
    $id_imgs = nasa_get_product_meta_value($product->get_id(), '_product_360_degree');
    $id_imgs_str = $id_imgs ? trim($id_imgs, ',') : '';
    $id_imgs_arr = $id_imgs_str !== '' ? explode(',', $id_imgs_str) : array();
    
    if (empty($id_imgs_arr)) {
        return;
    }
    
    $img_src = array();
    $width = apply_filters('nasa_360_product_viewer_width_default', 500);
    $height = apply_filters('nasa_360_product_viewer_height_default', 500);
    $set = false;
    
    foreach ($id_imgs_arr as $id) {
        $image_full = wp_get_attachment_image_src($id, 'full');
        
        if (isset($image_full[0])) {
            $img_src[] = $image_full[0];
            
            if (!$set) {
                $set = true;
                $width = isset($image_full[1]) ? $image_full[1] : $width;
                $height = isset($image_full[2]) ? $image_full[2] : $height;
            }
        } else {
            $img_src[] = wp_get_attachment_url($id);
        }
    }
    
    if (!empty($img_src)) {
        $img_src_json = wp_json_encode($img_src);
        $dataimgs = function_exists('wc_esc_json') ?
            wc_esc_json($img_src_json) : _wp_specialchars($img_src_json, ENT_QUOTES, 'UTF-8', true);
        
        echo '<a id="nasa-360-degree" class="nasa-360-degree-popup nasa-tip nasa-tip-right" href="javascript:void(0);" data-close="' . esc_attr__('Close', 'nasa-core') . '" data-imgs="' . $dataimgs . '" data-width="' . $width . '" data-height="' . $height . '" data-tip="' . esc_html__('360&#176; View', 'nasa-core') . '" rel="nofollow">' . esc_html__('360&#176;', 'nasa-core')  . '</a>';
    }
}

/**
 * Custom Badge
 */
add_filter('nasa_badges', 'nasa_custom_badges');
function nasa_custom_badges($badges) {
    global $nasa_opt, $product;
    
    $product_id = $product->get_id();
    
    $custom_badge = '';
    
    /**
     * Video Badge
     */
    if (isset($nasa_opt['nasa_badge_video']) && $nasa_opt['nasa_badge_video']) {
        $video_link = nasa_get_product_meta_value($product_id, '_product_video_link');
        $custom_badge .= $video_link ? '<span class="badge video-label nasa-icon pe-7s-play"></span>' : '';
    }
    
    /**
     * 360 Degree Badge
     */
    if (isset($nasa_opt['nasa_badge_360']) && $nasa_opt['nasa_badge_360']) {
        $id_imgs = nasa_get_product_meta_value($product_id, '_product_360_degree');
        $id_imgs_str = $id_imgs ? trim($id_imgs, ',') : '';
        $custom_badge .= $id_imgs_str ? '<span class="badge b360-label">' . esc_html__('360&#176;', 'nasa-core') . '</span>' : '';
    }

    /**
     * Custom Badge
     */
    $badge_hot = nasa_get_product_meta_value($product_id, '_bubble_hot');
    $custom_badge .= $badge_hot ? '<span class="badge hot-label">' . $badge_hot . '</span>' : '';
    
    return $custom_badge . $badges;
}

/**
 * Add tab Bought Together
 */
add_filter('woocommerce_product_tabs', 'nasa_accessories_product_tab');
function nasa_accessories_product_tab($tabs) {
    global $product;
    
    if ($product && 'simple' === $product->get_type()) {
        $productIds = get_post_meta($product->get_id(), '_accessories_ids', true);
        
        if (!empty($productIds)) {
            $GLOBALS['accessories_ids'] = $productIds;
            
            $tabs['accessories_content'] = array(
                'title'     => esc_html__('Bought Together', 'nasa-core'),
                'priority'  => apply_filters('nasa_bought_together_tab_priority', 5),
                'callback'  => 'nasa_accessories_product_tab_content'
            );
        }
    }

    return $tabs;
}

/**
 * Content Bought Together of the current Product
 */
function nasa_accessories_product_tab_content() {
    global $product, $accessories_ids, $nasa_opt;
    if (!$product || !$accessories_ids) {
        return;
    }

    $accessories = array();
    foreach ($accessories_ids as $accessories_id) {
        $product_acc = wc_get_product($accessories_id);
        if (
            is_object($product_acc) &&
            $product_acc->get_status() === 'publish' &&
            $product_acc->get_type() == 'simple'
        ) {
            $accessories[] = $product_acc;
        }
    }

    if (empty($accessories)) {
        return;
    }
    
    $nasa_args = array(
        'nasa_opt' => $nasa_opt,
        'product' => $product,
        'accessories_ids' => $accessories_ids,
        'accessories' => $accessories,
    );

    nasa_template('products/nasa_single_product/nasa-single-product-accessories-tab-content.php', $nasa_args);
}

/**
 * Add tab Technical Specifications
 */
add_filter('woocommerce_product_tabs', 'nasa_specifications_product_tab');
function nasa_specifications_product_tab($tabs) {
    global $nasa_specifications, $product;
    if (!$product) {
        return $tabs;
    }
    
    $product_id = $product->get_id();
    if (!isset($nasa_specifications[$product_id])) {
        $specifications = nasa_get_product_meta_value($product_id, 'nasa_specifications');
        $nasa_specifications[$product->get_id()] = $specifications;
        $GLOBALS['nasa_specifications'] = $nasa_specifications;
    }
    
    if ($nasa_specifications[$product_id] == '') {
        return $tabs;
    }
    
    $tabs['specifications'] = array(
        'title'     => esc_html__('Specifications', 'nasa-core'),
        'priority'  => apply_filters('nasa_specifications_tab_priority', 15),
        'callback'  => 'nasa_specifications_product_tab_content'
    );

    return $tabs;
}

/**
 * Content Technical Specifications of the current Product
 */
function nasa_specifications_product_tab_content() {
    global $product, $nasa_specifications;
    
    if (!$product || !isset($nasa_specifications[$product->get_id()])) {
        return;
    }

    echo do_shortcode($nasa_specifications[$product->get_id()]);
}

/**
 * Addition Custom Tabs
 */
add_filter('woocommerce_product_tabs', 'nasa_custom_product_tabs', 990);
function nasa_custom_product_tabs($tabs) {
    global $product, $nasa_ct_tabs;
    
    if (!$product) {
        return $tabs;
    }
    
    $ct_tabs = get_post_meta($product->get_id(), '_nasa_ct_tabs', true);
    
    if (!is_array($ct_tabs) || empty($ct_tabs)) {
        return $tabs;
    }
    
    $nasa_ct_tabs = array();
    
    foreach ($ct_tabs as $key => $ct_tab) {
        $tab = nasa_get_block_obj($ct_tab);
        
        if ($tab) {
            $nasa_ct_tabs[$key] = $tab['content'];
            
            $tabs['ct_tab_' . $key] = array(
                'title'     => $tab['title'],
                'priority'  => apply_filters('nasa_ct_tabs_priority', 90),
                'callback'  => 'nasa_custom_product_tab_content_' . $key
            );
        }
        
        if ($key > 4) {
            break;
        }
    }
    
    $GLOBALS['nasa_ct_tabs'] = $nasa_ct_tabs;

    return $tabs;
}

/**
 * CT Tab #0
 * 
 * @global type $product
 * @return string
 */
function nasa_custom_product_tab_content_0() {
    global $nasa_ct_tabs;
    
    if (empty($nasa_ct_tabs) || !isset($nasa_ct_tabs[0])) {
        return;
    }
    
    echo $nasa_ct_tabs[0];
}

/**
 * CT Tab #1
 * 
 * @global type $product
 * @return string
 */
function nasa_custom_product_tab_content_1() {
    global $nasa_ct_tabs;
    
    if (empty($nasa_ct_tabs) || !isset($nasa_ct_tabs[1])) {
        return;
    }
    
    echo $nasa_ct_tabs[1];
}

/**
 * CT Tab #2
 * 
 * @global type $product
 * @return string
 */
function nasa_custom_product_tab_content_2() {
    global $nasa_ct_tabs;
    
    if (empty($nasa_ct_tabs) || !isset($nasa_ct_tabs[2])) {
        return;
    }
    
    echo $nasa_ct_tabs[2];
}

/**
 * CT Tab #3
 * 
 * @global type $product
 * @return string
 */
function nasa_custom_product_tab_content_3() {
    global $nasa_ct_tabs;
    
    if (empty($nasa_ct_tabs) || !isset($nasa_ct_tabs[3])) {
        return;
    }
    
    echo $nasa_ct_tabs[3];
}

/**
 * CT Tab #4
 * 
 * @global type $product
 * @return string
 */
function nasa_custom_product_tab_content_4() {
    global $nasa_ct_tabs;
    
    if (empty($nasa_ct_tabs) || !isset($nasa_ct_tabs[4])) {
        return;
    }
    
    echo $nasa_ct_tabs[4];
}

/**
 * Category Tab
 */
add_filter('woocommerce_product_tabs', 'nasa_product_cat_global_tab', 995);
function nasa_product_cat_global_tab($tabs) {
    global $product;
    
    if (!$product) {
        return $tabs;
    }
    
    $root_cat_id = nasa_root_term_id();
    
    if (!$root_cat_id) {
        return $tabs;
    }
    
    $slug = get_term_meta($root_cat_id, 'single_product_tab_glb', true);
    
    if ($slug) {
        $tab = nasa_get_block_obj($slug);
        
        if ($tab) {
            $GLOBALS['nasa_cat_tab'] = $tab['content'];

            $tabs['glb_cat_tab'] = array(
                'title'     => $tab['title'],
                'priority'  => apply_filters('nasa_cat_tab_priority', 95),
                'callback'  => 'nasa_glb_product_cat_tab_content'
            );
        }
    }

    return $tabs;
}

/**
 * Global Cat Tab Content
 */
function nasa_glb_product_cat_tab_content() {
    global $nasa_cat_tab;
    
    echo !empty($nasa_cat_tab) ? $nasa_cat_tab : '';
}

/**
 * Addition Global Tab
 */
add_filter('woocommerce_product_tabs', 'nasa_product_global_tab', 999);
function nasa_product_global_tab($tabs) {
    global $product, $nasa_opt;
    
    if (!$product) {
        return $tabs;
    }
    
    if (!isset($nasa_opt['tab_glb']) || !$nasa_opt['tab_glb'] || $nasa_opt['tab_glb'] == 'default') {
        return $tabs;
    }
    
    $tab = nasa_get_block_obj($nasa_opt['tab_glb']);
    
    if ($tab) {
        $GLOBALS['nasa_glb_tabs'] = $tab['content'];
        $tabs['glb_tab'] = array(
            'title'     => $tab['title'],
            'priority'  => apply_filters('nasa_glb_tab_priority', 100),
            'callback'  => 'nasa_glb_product_tab_content'
        );
    }

    return $tabs;
}

/**
 * Global Tab Content
 */
function nasa_glb_product_tab_content() {
    global $nasa_glb_tabs;
    
    echo !empty($nasa_glb_tabs) ? $nasa_glb_tabs : '';
}

/**
 * Loop layout buttons
 */
add_action('template_redirect', 'nasa_loop_product_opts');
function nasa_loop_product_opts() {
    if (!NASA_WOO_ACTIVED) {
        return false;
    }
    
    global $nasa_opt;
    
    /**
     * Page Preview Elementor
     */
    if (NASA_ELEMENTOR_ACTIVE && isset($_REQUEST['elementor-preview']) && $_REQUEST['elementor-preview']) {
        $preview_id = (int) $_REQUEST['elementor-preview'];
        
        /**
         * Swith loop_layout_buttons
         */
        if ($preview_id) {
            $type_override = get_post_meta($preview_id, '_nasa_loop_layout_buttons', true);
            if (!empty($type_override)) {
                $nasa_opt['loop_layout_buttons'] = $type_override;
            }
        }
        
    } else {
        
        $root_term_id = nasa_root_term_id();

        /**
         * Category products
         */
        if ($root_term_id) {
            $type_override = get_term_meta($root_term_id, 'nasa_loop_layout_buttons', true);
            if ($type_override) {
                $nasa_opt['loop_layout_buttons'] = $type_override;
            }
            
            $effect_product = get_term_meta($root_term_id, 'cat_effect_hover', true);
            if ($effect_product == 'no') {
                $nasa_opt['animated_products'] = '';
            } elseif ($effect_product !== '') {
                $nasa_opt['animated_products'] = $effect_product;
            }
        }

        /**
         * Pages
         */
        else {
            global $wp_query;

            $page_id = false;
            $is_shop = is_shop();
            $is_product_taxonomy = is_product_taxonomy();

            /**
             * Shop
             */
            if ($is_shop || $is_product_taxonomy) {
                $pageShop = wc_get_page_id('shop');

                if ($pageShop > 0) {
                    $page_id = $pageShop;
                }
            }

            /**
             * Page
             */
            else {
                $page_id = $wp_query->get_queried_object_id();
            }

            /**
             * Swith loop_layout_buttons for page
             */
            if ($page_id) {
                $type_override = get_post_meta($page_id, '_nasa_loop_layout_buttons', true);
                if (!empty($type_override)) {
                    $nasa_opt['loop_layout_buttons'] = $type_override;
                }
                
                $effect_product = get_post_meta($page_id, '_nasa_effect_hover', true);
                if ($effect_product == 'no') {
                    $nasa_opt['animated_products'] = '';
                } elseif ($effect_product !== '') {
                    $nasa_opt['animated_products'] = $effect_product;
                }
            }
        }
    }
    
    $GLOBALS['nasa_opt'] = $nasa_opt;
}

/**
 * Attributes Brands Single Product Page
 */
add_action('woocommerce_single_product_summary', 'nasa_single_attributes_brands', 16);
add_action('woocommerce_single_product_lightbox_summary', 'nasa_single_attributes_brands', 11);
function nasa_single_attributes_brands() {
    global $nasa_opt, $product;
    
    if (!$product) {
        return;
    }
    
    $nasa_brands = isset($nasa_opt['attr_brands']) && !empty($nasa_opt['attr_brands']) ? $nasa_opt['attr_brands'] : array();
    $brands = array();
    if (!empty($nasa_brands)) {
        foreach ($nasa_brands as $key => $val) {
            if ($val === '1') {
                $brands[] = $key;
            }
        }
    }
    if (empty($brands)) {
        return;
    }
    
    $attributes = $product->get_attributes();
    if (empty($attributes)) {
        return;
    }
    
    $brands_output = array();
    foreach ($attributes as $attribute_name => $attribute) {
        $attr_name = 0 === strpos($attribute_name, 'pa_') ? substr($attribute_name, 3) : $attribute_name;
        
        if (!in_array($attr_name, $brands)) {
            continue;
        }
        
        $terms = $attribute->get_terms();
        $is_link = false;
        $this_name = false;
        if ($attribute->is_taxonomy()) {
            $attribute_taxonomy = $attribute->get_taxonomy_object();
            $is_link = $attribute_taxonomy->attribute_public ? true : false;
            $this_name = $attribute->get_name();
        }
        
        if (!empty($terms)) {
            $brands_output[$attribute_name] = array(
                'is_link' => $is_link,
                'attr_name' => $this_name,
                'terms' => $terms
            );
        }
    }
    
    $nasa_args = array(
        'brands' => $brands_output
    );
    
    nasa_template('products/nasa_single_product/nasa-single-brands.php', $nasa_args);
}

/**
 * Fake Sold
 */
add_action('woocommerce_single_product_summary', 'nasa_fake_sold', 22);
function nasa_fake_sold() {
    global $nasa_opt, $product;
    
    if (!isset($nasa_opt['fake_sold']) || !$nasa_opt['fake_sold'] || !$product || "outofstock" === $product->get_stock_status()) {
        return;
    }
    
    $product_type = $product->get_type();
    $types_allow = apply_filters('nasa_types_allow_fake', array('simple', 'variable', 'variation'));
    
    if (empty($types_allow) || in_array($product_type, $types_allow)) {
        $product_id = $product_type == 'variation' ? $product->get_parent_id() : $product->get_id();
        
        if ('-1' === nasa_get_product_meta_value($product_id, "_fake_sold")) {
            return;
        }

        $key_name = 'nasa_fake_sold_' . $product_id;
        $fake_sold = get_transient($key_name);

        if (!$fake_sold) {
            /**
             * Build sold
             */
            $min = isset($nasa_opt['min_fake_sold']) && (int) $nasa_opt['min_fake_sold'] ? (int) $nasa_opt['min_fake_sold'] : 1;
            $max = isset($nasa_opt['max_fake_sold']) && (int) $nasa_opt['max_fake_sold'] ? (int) $nasa_opt['max_fake_sold'] : 20;
            $sold = rand($min, $max);

            /**
             * Build time
             */
            $min_time = isset($nasa_opt['min_fake_time']) && (int) $nasa_opt['min_fake_time'] ? (int) $nasa_opt['min_fake_time'] : 1;
            $max_time = isset($nasa_opt['max_fake_time']) && (int) $nasa_opt['max_fake_time'] ? (int) $nasa_opt['max_fake_time'] : 1;
            $times = rand($min_time, $max_time);

            /**
             * Live time - default 10 hours
             */
            $live_time = isset($nasa_opt['fake_time_live']) && (int) $nasa_opt['fake_time_live'] ? (int) $nasa_opt['fake_time_live'] : 36000;

            $fake_sold_data = '<div class="nasa-last-sold nasa-crazy-inline">';
            
            $fake_sold_data .= '<svg class="last-sold-img" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="18px" viewBox="-33 0 255 255" preserveAspectRatio="xMidYMid" fill="#000000"><g id="SVGRepo_iconCarrier"> <defs> <style> .cls-3 { fill: url(#linear-gradient-1); } .cls-4 { fill: #fc9502; } .cls-5 { fill: #fce202; } </style> <linearGradient id="linear-gradient-1" gradientUnits="userSpaceOnUse" x1="94.141" y1="255" x2="94.141" y2="0.188"> <stop offset="0" stop-color="#ff4c0d"/> <stop offset="1" stop-color="#fc9502"/> </linearGradient> </defs> <g id="fire"> <path d="M187.899,164.809 C185.803,214.868 144.574,254.812 94.000,254.812 C42.085,254.812 -0.000,211.312 -0.000,160.812 C-0.000,154.062 -0.121,140.572 10.000,117.812 C16.057,104.191 19.856,95.634 22.000,87.812 C23.178,83.513 25.469,76.683 32.000,87.812 C35.851,94.374 36.000,103.812 36.000,103.812 C36.000,103.812 50.328,92.817 60.000,71.812 C74.179,41.019 62.866,22.612 59.000,9.812 C57.662,5.384 56.822,-2.574 66.000,0.812 C75.352,4.263 100.076,21.570 113.000,39.812 C131.445,65.847 138.000,90.812 138.000,90.812 C138.000,90.812 143.906,83.482 146.000,75.812 C148.365,67.151 148.400,58.573 155.999,67.813 C163.226,76.600 173.959,93.113 180.000,108.812 C190.969,137.321 187.899,164.809 187.899,164.809 Z" id="path-1" class="cls-3" fill-rule="evenodd"/> <path d="M94.000,254.812 C58.101,254.812 29.000,225.711 29.000,189.812 C29.000,168.151 37.729,155.000 55.896,137.166 C67.528,125.747 78.415,111.722 83.042,102.172 C83.953,100.292 86.026,90.495 94.019,101.966 C98.212,107.982 104.785,118.681 109.000,127.812 C116.266,143.555 118.000,158.812 118.000,158.812 C118.000,158.812 125.121,154.616 130.000,143.812 C131.573,140.330 134.753,127.148 143.643,140.328 C150.166,150.000 159.127,167.390 159.000,189.812 C159.000,225.711 129.898,254.812 94.000,254.812 Z" id="path-2" class="cls-4" fill-rule="evenodd"/> <path d="M95.000,183.812 C104.250,183.812 104.250,200.941 116.000,223.812 C123.824,239.041 112.121,254.812 95.000,254.812 C77.879,254.812 69.000,240.933 69.000,223.812 C69.000,206.692 85.750,183.812 95.000,183.812 Z" id="path-3" class="cls-5" fill-rule="evenodd"/> </g> </g></svg>';
            
            $fake_sold_data .= $times > 1 ? sprintf(
                esc_html__('%s sold in last %s hours', 'nasa-core'),
                $sold,
                $times
            ) : sprintf(
                esc_html__('%s sold in last %s hour', 'nasa-core'),
                $sold,
                $times
            );
            
            $fake_sold_data .= '</div>';

            /**
             * Apply content fake sold
             */
            $fake_sold = apply_filters('nasa_fake_sold_content', $fake_sold_data, $product_id);

            /**
             * Set transient
             */
            set_transient($key_name, $fake_sold, $live_time);
        }

        echo $fake_sold ? $fake_sold : '';
    }
}


/**
 * Fake In Cart
 */
add_action('woocommerce_single_product_summary', 'nasa_fake_in_cart', 22);
function nasa_fake_in_cart() {
    global $nasa_opt, $product;
    
    if (!isset($nasa_opt['fake_in_cart']) || !$nasa_opt['fake_in_cart'] || !$product || "outofstock" === $product->get_stock_status()) {
        return;
    }
    
    $product_type = $product->get_type();
    $types_allow = apply_filters('nasa_types_allow_fake', array('simple', 'variable', 'variation'));
    
    if (empty($types_allow) || in_array($product_type, $types_allow)) {
        $product_id = $product_type == 'variation' ? $product->get_parent_id() : $product->get_id();
        
        if ('-1' === nasa_get_product_meta_value($product_id, "_fake_in_cart")) {
            return;
        }

        $key_name = 'nasa_fake_in_cart_' . $product_id;
        $fake_in_cart = get_transient($key_name);

        if (!$fake_in_cart) {
            /**
             * Build in cart
             */
            $min = isset($nasa_opt['min_fake_in_cart']) && (int) $nasa_opt['min_fake_in_cart'] ? (int) $nasa_opt['min_fake_in_cart'] : 1;
            $max = isset($nasa_opt['max_fake_in_cart']) && (int) $nasa_opt['max_fake_in_cart'] ? (int) $nasa_opt['max_fake_in_cart'] : 20;
            $in_cart = rand($min, $max);

            /**
             * Live time - default 10 hours
             */
            $live_time = isset($nasa_opt['fake_in_cart_time_live']) && (int) $nasa_opt['fake_in_cart_time_live'] ? (int) $nasa_opt['fake_in_cart_time_live'] : 36000;

            $fake_in_cart_data = '<div class="nasa-in-cart nasa-crazy-inline">';
            
            $fake_in_cart_data .= '<svg class="last-sold-img" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="18px" viewBox="-33 0 255 255" preserveAspectRatio="xMidYMid" fill="#000000"><g id="SVGRepo_iconCarrier"> <defs> <style> .cls-3 { fill: url(#linear-gradient-1); } .cls-4 { fill: #fc9502; } .cls-5 { fill: #fce202; } </style> <linearGradient id="linear-gradient-1" gradientUnits="userSpaceOnUse" x1="94.141" y1="255" x2="94.141" y2="0.188"> <stop offset="0" stop-color="#ff4c0d"/> <stop offset="1" stop-color="#fc9502"/> </linearGradient> </defs> <g id="fire"> <path d="M187.899,164.809 C185.803,214.868 144.574,254.812 94.000,254.812 C42.085,254.812 -0.000,211.312 -0.000,160.812 C-0.000,154.062 -0.121,140.572 10.000,117.812 C16.057,104.191 19.856,95.634 22.000,87.812 C23.178,83.513 25.469,76.683 32.000,87.812 C35.851,94.374 36.000,103.812 36.000,103.812 C36.000,103.812 50.328,92.817 60.000,71.812 C74.179,41.019 62.866,22.612 59.000,9.812 C57.662,5.384 56.822,-2.574 66.000,0.812 C75.352,4.263 100.076,21.570 113.000,39.812 C131.445,65.847 138.000,90.812 138.000,90.812 C138.000,90.812 143.906,83.482 146.000,75.812 C148.365,67.151 148.400,58.573 155.999,67.813 C163.226,76.600 173.959,93.113 180.000,108.812 C190.969,137.321 187.899,164.809 187.899,164.809 Z" id="path-1" class="cls-3" fill-rule="evenodd"/> <path d="M94.000,254.812 C58.101,254.812 29.000,225.711 29.000,189.812 C29.000,168.151 37.729,155.000 55.896,137.166 C67.528,125.747 78.415,111.722 83.042,102.172 C83.953,100.292 86.026,90.495 94.019,101.966 C98.212,107.982 104.785,118.681 109.000,127.812 C116.266,143.555 118.000,158.812 118.000,158.812 C118.000,158.812 125.121,154.616 130.000,143.812 C131.573,140.330 134.753,127.148 143.643,140.328 C150.166,150.000 159.127,167.390 159.000,189.812 C159.000,225.711 129.898,254.812 94.000,254.812 Z" id="path-2" class="cls-4" fill-rule="evenodd"/> <path d="M95.000,183.812 C104.250,183.812 104.250,200.941 116.000,223.812 C123.824,239.041 112.121,254.812 95.000,254.812 C77.879,254.812 69.000,240.933 69.000,223.812 C69.000,206.692 85.750,183.812 95.000,183.812 Z" id="path-3" class="cls-5" fill-rule="evenodd"/> </g> </g></svg>';
            
            $fake_in_cart_data .= sprintf(
                esc_html__('Hurry! Over %s people have this in their carts', 'nasa-core'),
                $in_cart
            );
            
            $fake_in_cart_data .= '</div>';
            
            /**
             * Apply content fake in cart
             */
            $fake_in_cart = apply_filters('nasa_fake_in_cart_content', $fake_in_cart_data, $product_id);

            /**
             * Set transient
             */
            set_transient($key_name, $fake_in_cart, $live_time);
        }

        echo $fake_in_cart ? $fake_in_cart : '';
    }
}
/**
 * Estimated Delivery
 */
add_action('woocommerce_single_product_summary', 'nasa_estimated_delivery', 35);
function nasa_estimated_delivery() {
    global $nasa_opt, $product;
    
    if (!isset($nasa_opt['est_delivery']) || !$nasa_opt['est_delivery'] || !$product || "outofstock" === $product->get_stock_status()) {
        return;
    }
    
    $product_id = (int) $product->get_id();
    
    $min = isset($nasa_opt['min_est_delivery']) && (int) $nasa_opt['min_est_delivery'] ? (int) $nasa_opt['min_est_delivery'] : 0;
    $from = '+' . $min;
    $from .= ' ' . ($min == 1 ? 'day' : 'days');
    
    $max = isset($nasa_opt['max_est_delivery']) && (int) $nasa_opt['max_est_delivery'] ? (int) $nasa_opt['max_est_delivery'] : 7;
    $to = '+' . $max;
    $to .= ' ' . ($max == 1 ? 'day' : 'days');
    
    $now = get_date_from_gmt(date('Y-m-d H:i:s'), 'Y-m-d');
    $est_days = array();
    
    $format = esc_html__('M d', 'nasa-core');
    // get_date_from_gmt(date('Y-m-d', strtotime($now . $from)), $format);
    
    $est_days[] = date_i18n($format, strtotime($now . $from), true);
    $est_days[] = date_i18n($format, strtotime($now . $to), true);
    
    if (!empty($est_days)) {
        $est_view = '<div class="nasa-est-delivery nasa-promote-sales nasa-crazy-inline">';
        $est_view .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor" height="22" width="22" version="1.1" id="Layer_1" viewBox="0 0 491.1 491.1" xml:space="preserve">
<g transform="translate(0 -540.36)">
<path d="M401.5,863.31c-12,0-23.4,4.7-32,13.2c-8.6,8.6-13.4,19.8-13.4,31.8s4.7,23.2,13.4,31.8c8.7,8.5,20,13.2,32,13.2 c24.6,0,44.6-20.2,44.6-45S426.1,863.31,401.5,863.31z M401.5,933.31c-13.8,0-25.4-11.4-25.4-25s11.6-25,25.4-25 c13.6,0,24.6,11.2,24.6,25S415.1,933.31,401.5,933.31z"/>
<path d="M413.1,713.41c-1.8-1.7-4.2-2.6-6.7-2.6h-51.3c-5.5,0-10,4.5-10,10v82c0,5.5,4.5,10,10,10h81.4c5.5,0,10-4.5,10-10v-54.9 c0-2.8-1.2-5.5-3.3-7.4L413.1,713.41z M426.5,792.81h-61.4v-62.1h37.4l24,21.6V792.81z"/>
<path d="M157.3,863.31c-12,0-23.4,4.7-32,13.2c-8.6,8.6-13.4,19.8-13.4,31.8s4.7,23.2,13.4,31.8c8.7,8.5,20,13.2,32,13.2 c24.6,0,44.6-20.2,44.6-45S181.9,863.31,157.3,863.31z M157.3,933.31c-13.8,0-25.4-11.4-25.4-25s11.6-25,25.4-25 c13.6,0,24.6,11.2,24.6,25S170.9,933.31,157.3,933.31z"/>
<path d="M90.6,875.61H70.5v-26.6c0-5.5-4.5-10-10-10s-10,4.5-10,10v36.6c0,5.5,4.5,10,10,10h30.1c5.5,0,10-4.5,10-10 S96.1,875.61,90.6,875.61z"/>
<path d="M141.3,821.11c0-5.5-4.5-10-10-10H10c-5.5,0-10,4.5-10,10s4.5,10,10,10h121.3C136.8,831.11,141.3,826.71,141.3,821.11z"/>
<path d="M30.3,785.01l121.3,0.7c5.5,0,10-4.4,10.1-9.9c0.1-5.6-4.4-10.1-9.9-10.1l-121.3-0.7c-0.1,0-0.1,0-0.1,0 c-5.5,0-10,4.4-10,9.9C20.3,780.51,24.8,785.01,30.3,785.01z"/>
<path d="M50.7,739.61H172c5.5,0,10-4.5,10-10s-4.5-10-10-10H50.7c-5.5,0-10,4.5-10,10S45.2,739.61,50.7,739.61z"/>
<path d="M487.4,726.11L487.4,726.11l-71.6-59.3c-1.8-1.5-4-2.3-6.4-2.3h-84.2v-36c0-5.5-4.5-10-10-10H60.5c-5.5,0-10,4.5-10,10 v73.2c0,5.5,4.5,10,10,10s10-4.5,10-10v-63.2h234.8v237.1h-82c-5.5,0-10,4.5-10,10s4.5,10,10,10h122.1c5.5,0,10-4.5,10-10 s-4.5-10-10-10h-20.1v-191.1h80.6l65.2,54l-0.7,136.9H460c-5.5,0-10,4.5-10,10s4.5,10,10,10h20.3c5.5,0,10-4.4,10-9.9l0.8-151.6 C491,730.91,489.7,728.01,487.4,726.11z"/>
</g>
</svg>&nbsp;&nbsp;';
        $est_view .= '<strong>' . esc_html__('Estimated Delivery:', 'nasa-core') . '</strong>&nbsp;';
        $est_view .= implode(' &ndash; ', $est_days);
        $est_view .= '</div>';
    
        /**
         * Output content estimated delivery view
         */
        echo apply_filters('nasa_estimated_delivery_content', $est_view, $product_id);
    }
}

/**
 * Fake Viewing
 */
add_action('woocommerce_single_product_summary', 'nasa_fake_view', 35);
function nasa_fake_view() {
    global $nasa_opt, $product;
    
    if ((isset($nasa_opt['fake_view']) && !$nasa_opt['fake_view']) || !$product) {
        return;
    }
    
    $product_id = (int) $product->get_id();
    
    if ('-1' === nasa_get_product_meta_value($product_id, "_fake_view")) {
        return;
    }
    
    $min = isset($nasa_opt['min_fake_view']) ? (int) $nasa_opt['min_fake_view'] : 10;
    $max = isset($nasa_opt['max_fake_view']) ? (int) $nasa_opt['max_fake_view'] : 50;
    $delay = isset($nasa_opt['delay_time_view']) ? (int) $nasa_opt['delay_time_view'] : 15;
    $change = isset($nasa_opt['max_change_view']) ? (int) $nasa_opt['max_change_view'] : 5;
    
    $allowed_html = array(
        'strong' => array()
    );
    
    $fake_view = '<div id="nasa-counter-viewing" class="nasa-viewing nasa-promote-sales nasa-crazy-inline" data-min="' . $min . '" data-max="' . $max . '" data-delay="' . ($delay * 1000) . '" data-change="' . $change . '" data-id="' . $product_id . '">';
    $fake_view .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="20" height="22" viewBox="0 0 26 32" fill="curentColor">
<path d="M12.8 3.2c-7.093 0-12.8 5.707-12.8 12.8s5.707 12.8 12.8 12.8c7.093 0 12.8-5.707 12.8-12.8s-5.707-12.8-12.8-12.8zM12.8 27.733c-6.453 0-11.733-5.28-11.733-11.733s5.28-11.733 11.733-11.733c6.453 0 11.733 5.28 11.733 11.733s-5.28 11.733-11.733 11.733z"/>
<path d="M19.467 19.040c-0.267-0.107-0.587-0.053-0.693 0.213-1.173 2.293-3.467 3.68-5.973 3.68-2.56 0-4.8-1.387-5.973-3.68-0.107-0.267-0.427-0.373-0.693-0.213-0.267 0.107-0.373 0.427-0.267 0.693 1.333 2.613 3.947 4.267 6.933 4.267 2.933 0 5.6-1.653 6.88-4.267 0.16-0.267 0.053-0.587-0.213-0.693z"/>
<path d="M10.133 13.333c0 0.884-0.716 1.6-1.6 1.6s-1.6-0.716-1.6-1.6c0-0.884 0.716-1.6 1.6-1.6s1.6 0.716 1.6 1.6z"/>
<path d="M18.667 13.333c0 0.884-0.716 1.6-1.6 1.6s-1.6-0.716-1.6-1.6c0-0.884 0.716-1.6 1.6-1.6s1.6 0.716 1.6 1.6z"/>
</svg>&nbsp;&nbsp;<strong class="nasa-count">...</strong>&nbsp;';
    $fake_view .= wp_kses(__('<strong>people</strong>&nbsp;are viewing this right now', 'nasa-core'), $allowed_html);
    $fake_view .= '</div>';
    
    /**
     * Output content fake view
     */
    echo apply_filters('nasa_fake_view_content', $fake_view, $product_id);
}

/**
 * Get Root Term id
 * 
 * @global type $wp_query
 * @global type $nasa_root_term_id
 * @global type $product
 * @global type $post
 * @return boolean
 */
function nasa_root_term_id() {
    if (!NASA_WOO_ACTIVED) {
        return false;
    }
    
    global $nasa_root_term_id;
    
    if (!isset($nasa_root_term_id)) {
        $is_product = is_product();
        $is_product_cat = is_product_category();
        $current_cat = null;
        
        /**
         * For Quick view
         */
        if (isset($_REQUEST['wc-ajax']) && $_REQUEST['wc-ajax'] === 'nasa_quick_view') {
            global $product;
            
            if (!$product) {
                return false;
            }

            $is_product = true;
        }

        $root_cat_id = 0;
        
        if ($is_product) {
            global $post;

            $product_cats = get_the_terms($post->ID, 'product_cat');
            if ($product_cats) {
                foreach ($product_cats as $cat) {
                    $current_cat = $cat;
                    if ($cat->parent == 0) {
                        break;
                    }
                }
            }
        }

        elseif ($is_product_cat) {
            global $wp_query;
            
            $current_cat = $wp_query->get_queried_object();
        }

        if ($current_cat && isset($current_cat->term_id)) {
            if (isset($current_cat->parent) && $current_cat->parent == 0) {
                $root_cat_id = $current_cat->term_id;
            } else {
                $ancestors = get_ancestors($current_cat->term_id, 'product_cat');
                $root_cat_id = end($ancestors);
            }
        }

        $GLOBALS['nasa_root_term_id'] = $root_cat_id ? $root_cat_id : 0;
        $nasa_root_term_id = $root_cat_id;
    }
    
    return $nasa_root_term_id;
}
