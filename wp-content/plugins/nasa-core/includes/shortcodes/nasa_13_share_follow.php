<?php
/**
 * Shortcode [nasa_share ...]
 * 
 * @global type $post
 * @global type $nasa_opt
 * @global type $wp
 * @param type $atts
 * @param string $content
 * @return string
 */
function nasa_sc_share($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'title' => '',
        'el_class' => '',
        'label' => ''
    ), $atts));
    
    global $post, $nasa_opt;
    
    if (isset($post->ID)) {
        $permalink = get_permalink($post->ID);
        $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
        $featured_image_2 = isset($featured_image['0']) ? $featured_image['0'] : (isset($nasa_opt['site_logo']) ? $nasa_opt['site_logo'] : '#');
        $post_title = rawurlencode(get_the_title($post->ID));
    } else {
        global $wp;
        $permalink = home_url($wp->request);
        $featured_image_2 = isset($nasa_opt['site_logo']) ? $nasa_opt['site_logo'] : '#';
        $post_title = get_bloginfo('name', 'display');
    }
    
    $class_wrap = 'social-icons nasa-share';
    $class_wrap .= $el_class != '' ? ' ' . esc_attr($el_class) : '';
    
    $share_wrap_start = $title ? '<div class="nasa-share-title">' . $title . '</div>' : '';
    
    if ($label === '1') {
        $label_content = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="20" height="20" viewBox="0 0 32 32" fill="currentColor">
<path d="M26.129 2.139c-2.355 0-4.265 1.91-4.265 4.265 0 0.409 0.061 0.803 0.168 1.178l-12.469 5.226c-0.737-1.277-2.114-2.139-3.693-2.139-2.355 0-4.265 1.91-4.265 4.265s1.91 4.265 4.265 4.265c1.234 0 2.343-0.527 3.122-1.366l8.034 5.774c-0.314 0.594-0.494 1.27-0.494 1.988 0 2.356 1.91 4.266 4.265 4.266s4.265-1.91 4.265-4.266c0-2.355-1.91-4.264-4.265-4.264-1.253 0-2.376 0.544-3.157 1.404l-8.023-5.765c0.33-0.605 0.518-1.299 0.518-2.037 0-0.396-0.058-0.778-0.159-1.143l12.478-5.23c0.741 1.26 2.107 2.108 3.675 2.108 2.355 0 4.265-1.91 4.265-4.266 0-2.355-1.91-4.265-4.265-4.265zM20.798 22.398c1.764 0 3.199 1.435 3.199 3.198s-1.435 3.199-3.199 3.199c-1.764 0-3.199-1.435-3.199-3.199s1.435-3.198 3.199-3.198zM5.871 18.133c-1.764 0-3.199-1.435-3.199-3.199s1.435-3.199 3.199-3.199 3.199 1.435 3.199 3.199c0 1.764-1.435 3.199-3.199 3.199zM26.129 9.603c-1.764 0-3.199-1.435-3.199-3.199s1.435-3.199 3.199-3.199c1.764 0 3.199 1.435 3.199 3.199s-1.435 3.199-3.199 3.199z"/>
</svg>&nbsp;&nbsp;' . esc_html__('Share', 'nasa-core');
        $share_wrap_start .= '<div class="nasa-share-label">' . $label_content . '</div>';
    }
    
    $share_wrap_start .= '<ul class="' . $class_wrap . '">';
    
    $share = '';
    
    /**
     * Twitter - X
     */
    if (isset($nasa_opt['social_icons']['twitter']) && $nasa_opt['social_icons']['twitter']) {
        $share .=
        '<li>' .
            '<a href="https://twitter.com/share?url=' . esc_url($permalink) . '" target="_blank" class="icon nasa-tip" title="' . esc_attr__('Share on X', 'nasa-core') . '" rel="nofollow">' .
                '<svg viewBox="0 0 24 24" with="14.5" height="14.5" aria-hidden="true" fill="currentColor"><g><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path></g></svg>' .
            '</a>' .
        '</li>';
    }
        
    /**
     * FaceBook
     */
    if (isset($nasa_opt['social_icons']['facebook']) && $nasa_opt['social_icons']['facebook']) {
        $share .=
        '<li>' .
            '<a href="https://www.facebook.com/sharer.php?u=' . esc_url($permalink) . '" target="_blank" class="icon nasa-tip" title="' . esc_attr__('Share on Facebook', 'nasa-core') . '" rel="nofollow">' .
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" with="15" height="15" fill="currentColor"><path d="M 19.253906 2 C 15.311906 2 13 4.0821719 13 8.8261719 L 13 13 L 8 13 L 8 18 L 13 18 L 13 30 L 18 30 L 18 18 L 22 18 L 23 13 L 18 13 L 18 9.671875 C 18 7.884875 18.582766 7 20.259766 7 L 23 7 L 23 2.2050781 C 22.526 2.1410781 21.144906 2 19.253906 2 z"></path></svg>' .
            '</a>' .
        '</li>';
    }
    
    /**
     * Pinterest
     */
    if (isset($nasa_opt['social_icons']['pinterest']) && $nasa_opt['social_icons']['pinterest']) {
        $share .=
        '<li>' .
            '<a href="https://pinterest.com/pin/create/button/?url=' . esc_url($permalink) . '&amp;media=' . esc_attr($featured_image_2) . '&amp;description=' . esc_attr($post_title) . '" target="_blank" class="icon nasa-tip" title="' . esc_attr__('Pin on Pinterest', 'nasa-core') . '" rel="nofollow">' .
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16" fill="currentColor"><path d="M 7.5 1 C 3.910156 1 1 3.910156 1 7.5 C 1 10.253906 2.714844 12.605469 5.132813 13.554688 C 5.074219 13.039063 5.023438 12.25 5.152344 11.6875 C 5.273438 11.183594 5.914063 8.457031 5.914063 8.457031 C 5.914063 8.457031 5.722656 8.066406 5.722656 7.492188 C 5.722656 6.589844 6.246094 5.914063 6.898438 5.914063 C 7.453125 5.914063 7.71875 6.332031 7.71875 6.828125 C 7.71875 7.386719 7.363281 8.222656 7.183594 8.992188 C 7.027344 9.640625 7.507813 10.167969 8.144531 10.167969 C 9.300781 10.167969 10.1875 8.949219 10.1875 7.191406 C 10.1875 5.636719 9.070313 4.546875 7.472656 4.546875 C 5.625 4.546875 4.539063 5.933594 4.539063 7.367188 C 4.539063 7.925781 4.753906 8.527344 5.023438 8.851563 C 5.074219 8.917969 5.082031 8.972656 5.066406 9.039063 C 5.019531 9.242188 4.90625 9.6875 4.886719 9.777344 C 4.859375 9.894531 4.792969 9.921875 4.667969 9.863281 C 3.855469 9.484375 3.347656 8.296875 3.347656 7.34375 C 3.347656 5.292969 4.839844 3.410156 7.644531 3.410156 C 9.898438 3.410156 11.652344 5.015625 11.652344 7.164063 C 11.652344 9.402344 10.238281 11.207031 8.277344 11.207031 C 7.617188 11.207031 7 10.863281 6.789063 10.460938 C 6.789063 10.460938 6.460938 11.703125 6.382813 12.007813 C 6.234375 12.570313 5.839844 13.277344 5.574219 13.710938 C 6.183594 13.898438 6.828125 14 7.5 14 C 11.089844 14 14 11.089844 14 7.5 C 14 3.910156 11.089844 1 7.5 1 Z"></path></svg>' .
            '</a>' .
        '</li>';
    }
    
    /**
     * Linkedin
     */
    if (isset($nasa_opt['social_icons']['linkedin']) && $nasa_opt['social_icons']['linkedin']) {
        $share .=
        '<li>' .
            '<a href="https://linkedin.com/shareArticle?mini=true&amp;url=' . esc_url($permalink) . '" target="_blank" class="icon nasa-tip" title="' . esc_attr__('Share on Linkedin', 'nasa-core') . '" rel="nofollow">' .
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="16" height="16" fill="currentColor"><path d="M9,25H4V10h5V25z M6.501,8C5.118,8,4,6.879,4,5.499S5.12,3,6.501,3C7.879,3,9,4.121,9,5.499C9,6.879,7.879,8,6.501,8z M27,25h-4.807v-7.3c0-1.741-0.033-3.98-2.499-3.98c-2.503,0-2.888,1.896-2.888,3.854V25H12V9.989h4.614v2.051h0.065 c0.642-1.18,2.211-2.424,4.551-2.424c4.87,0,5.77,3.109,5.77,7.151C27,16.767,27,25,27,25z"></path></svg>' .
            '</a>' .
        '</li>';
    }
    
    /**
     * Telegram
     */
    if (isset($nasa_opt['social_icons']['telegram']) && $nasa_opt['social_icons']['telegram']) {
        $share .=
        '<li>' .
            '<a href="https://telegram.me/share/?url=' . esc_url($permalink) . '" target="_blank" class="icon nasa-tip" title="' . esc_attr__('Share on Telegram', 'nasa-core') . '" rel="nofollow">' .
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="16" height="16" fill="currentColor"><path d="M25,2c12.703,0,23,10.297,23,23S37.703,48,25,48S2,37.703,2,25S12.297,2,25,2z M32.934,34.375 c0.423-1.298,2.405-14.234,2.65-16.783c0.074-0.772-0.17-1.285-0.648-1.514c-0.578-0.278-1.434-0.139-2.427,0.219 c-1.362,0.491-18.774,7.884-19.78,8.312c-0.954,0.405-1.856,0.847-1.856,1.487c0,0.45,0.267,0.703,1.003,0.966 c0.766,0.273,2.695,0.858,3.834,1.172c1.097,0.303,2.346,0.04,3.046-0.395c0.742-0.461,9.305-6.191,9.92-6.693 c0.614-0.502,1.104,0.141,0.602,0.644c-0.502,0.502-6.38,6.207-7.155,6.997c-0.941,0.959-0.273,1.953,0.358,2.351 c0.721,0.454,5.906,3.932,6.687,4.49c0.781,0.558,1.573,0.811,2.298,0.811C32.191,36.439,32.573,35.484,32.934,34.375z"></path></svg>' .
            '</a>' .
        '</li>';
    }
    
    /**
     * WhatsApp
     */
    if (isset($nasa_opt['social_icons']['whatsapp']) && $nasa_opt['social_icons']['whatsapp']) {
        $share .=
        '<li>' .
            '<a href="https://api.whatsapp.com/send?text=' . esc_url($permalink) . '" target="_blank" class="icon nasa-tip" title="' . esc_attr__('Share on WhatsApp', 'nasa-core') . '" rel="nofollow">' .
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17" fill="currentColor"><path d="M 12.011719 2 C 6.5057187 2 2.0234844 6.478375 2.0214844 11.984375 C 2.0204844 13.744375 2.4814687 15.462563 3.3554688 16.976562 L 2 22 L 7.2324219 20.763672 C 8.6914219 21.559672 10.333859 21.977516 12.005859 21.978516 L 12.009766 21.978516 C 17.514766 21.978516 21.995047 17.499141 21.998047 11.994141 C 22.000047 9.3251406 20.962172 6.8157344 19.076172 4.9277344 C 17.190172 3.0407344 14.683719 2.001 12.011719 2 z M 12.009766 4 C 14.145766 4.001 16.153109 4.8337969 17.662109 6.3417969 C 19.171109 7.8517969 20.000047 9.8581875 19.998047 11.992188 C 19.996047 16.396187 16.413812 19.978516 12.007812 19.978516 C 10.674812 19.977516 9.3544062 19.642812 8.1914062 19.007812 L 7.5175781 18.640625 L 6.7734375 18.816406 L 4.8046875 19.28125 L 5.2851562 17.496094 L 5.5019531 16.695312 L 5.0878906 15.976562 C 4.3898906 14.768562 4.0204844 13.387375 4.0214844 11.984375 C 4.0234844 7.582375 7.6067656 4 12.009766 4 z M 8.4765625 7.375 C 8.3095625 7.375 8.0395469 7.4375 7.8105469 7.6875 C 7.5815469 7.9365 6.9355469 8.5395781 6.9355469 9.7675781 C 6.9355469 10.995578 7.8300781 12.182609 7.9550781 12.349609 C 8.0790781 12.515609 9.68175 15.115234 12.21875 16.115234 C 14.32675 16.946234 14.754891 16.782234 15.212891 16.740234 C 15.670891 16.699234 16.690438 16.137687 16.898438 15.554688 C 17.106437 14.971687 17.106922 14.470187 17.044922 14.367188 C 16.982922 14.263188 16.816406 14.201172 16.566406 14.076172 C 16.317406 13.951172 15.090328 13.348625 14.861328 13.265625 C 14.632328 13.182625 14.464828 13.140625 14.298828 13.390625 C 14.132828 13.640625 13.655766 14.201187 13.509766 14.367188 C 13.363766 14.534188 13.21875 14.556641 12.96875 14.431641 C 12.71875 14.305641 11.914938 14.041406 10.960938 13.191406 C 10.218937 12.530406 9.7182656 11.714844 9.5722656 11.464844 C 9.4272656 11.215844 9.5585938 11.079078 9.6835938 10.955078 C 9.7955938 10.843078 9.9316406 10.663578 10.056641 10.517578 C 10.180641 10.371578 10.223641 10.267562 10.306641 10.101562 C 10.389641 9.9355625 10.347156 9.7890625 10.285156 9.6640625 C 10.223156 9.5390625 9.737625 8.3065 9.515625 7.8125 C 9.328625 7.3975 9.131125 7.3878594 8.953125 7.3808594 C 8.808125 7.3748594 8.6425625 7.375 8.4765625 7.375 z"></path></svg>' .
            '</a>' .
        '</li>';
    }
    
    /**
     * Viber
     */
    /* if (isset($nasa_opt['social_icons']['viber']) && $nasa_opt['social_icons']['viber']) {
        $share .=
        '<li>' .
            '<a href="viber://forward?text=' . esc_url($permalink) . '" target="_blank" class="icon nasa-tip" title="' . esc_attr__('Share on Viber', 'nasa-core') . '" rel="nofollow">' .
                '<i class="fa fab fa-viber"></i>' .
            '</a>' .
        '</li>';
    } */
    
    /**
     * VK
     */
    if (isset($nasa_opt['social_icons']['vk']) && $nasa_opt['social_icons']['vk']) {
        $share .=
        '<li>' .
            '<a href="https://vk.com/share.php?url=' . esc_url($permalink) . '&amp;title=' . esc_attr($post_title) . '&amp;image=' . esc_attr($featured_image_2) . '" target="_blank" class="icon nasa-tip" title="' . esc_attr__('Share on VK', 'nasa-core') . '" rel="nofollow">' .
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="18" height="18" fill="currentColor"><path d="M45.763,35.202c-1.797-3.234-6.426-7.12-8.337-8.811c-0.523-0.463-0.579-1.264-0.103-1.776 c3.647-3.919,6.564-8.422,7.568-11.143C45.334,12.27,44.417,11,43.125,11l-3.753,0c-1.237,0-1.961,0.444-2.306,1.151 c-3.031,6.211-5.631,8.899-7.451,10.47c-1.019,0.88-2.608,0.151-2.608-1.188c0-2.58,0-5.915,0-8.28 c0-1.147-0.938-2.075-2.095-2.075L18.056,11c-0.863,0-1.356,0.977-0.838,1.662l1.132,1.625c0.426,0.563,0.656,1.248,0.656,1.951 L19,23.556c0,1.273-1.543,1.895-2.459,1.003c-3.099-3.018-5.788-9.181-6.756-12.128C9.505,11.578,8.706,11.002,7.8,11l-3.697-0.009 c-1.387,0-2.401,1.315-2.024,2.639c3.378,11.857,10.309,23.137,22.661,24.36c1.217,0.12,2.267-0.86,2.267-2.073l0-3.846 c0-1.103,0.865-2.051,1.977-2.079c0.039-0.001,0.078-0.001,0.117-0.001c3.267,0,6.926,4.755,8.206,6.979 c0.368,0.64,1.056,1.03,1.8,1.03l4.973,0C45.531,38,46.462,36.461,45.763,35.202z"></path></svg>' .
            '</a>' .
        '</li>';
    }
    
    /**
     * Email
     */
    if (isset($nasa_opt['social_icons']['email']) && $nasa_opt['social_icons']['email']) {
        $share .=
        '<li>' .
            '<a href="mailto:enter-your-mail@domain-here.com?subject=' . esc_attr($post_title) . '&amp;body=Check%20this%20out:%20' . esc_url($permalink) . '" target="_blank" class="icon nasa-tip" title="' . esc_attr__('Email to your friends', 'nasa-core') . '" rel="nofollow">' .
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17" fill="currentColor"><path d="M19,4H5A3,3,0,0,0,2,7V17a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V7A3,3,0,0,0,19,4ZM5,6H19a1,1,0,0,1,1,1l-8,4.88L4,7A1,1,0,0,1,5,6ZM20,17a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V9.28l7.48,4.57a1,1,0,0,0,1,0L20,9.28Z"></path></svg>' .
            '</a>' .
        '</li>';
    }

    $share_content = apply_filters('nasa_share_content', $share);
    
    $share_wrap_end = '</ul>';

    return $share_content ? $share_wrap_start . $share_content . $share_wrap_end : '';
}

/**
 * Shortcode [nasa_follow ...]
 * 
 * @global type $nasa_opt
 * @param type $atts
 * @param string $content
 * @return string
 */
function nasa_sc_follow($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'title' => '',
        'twitter' => '',
        'facebook' => '',
        'vk' => '',
        'pinterest' => '',
        'email' => '',
        'instagram' => '',
        'rss' => '',
        'linkedin' => '',
        'youtube' => '',
        'flickr' => '',
        'telegram' => '',
        'whatsapp' => '',
        'tiktok' => '',
        'tumblr' => '',
        'weibo' => '',
        'amazon' => '',
        'tip' => '',
        'el_class' => ''
    ), $atts));
    
    global $nasa_opt;
    $facebook   = $facebook ? $facebook : (isset($nasa_opt['facebook_url_follow']) ? $nasa_opt['facebook_url_follow'] : '');
    $twitter    = $twitter ? $twitter : (isset($nasa_opt['twitter_url_follow']) ? $nasa_opt['twitter_url_follow'] : '');
    $email      = $email ? $email : (isset($nasa_opt['email_url_follow']) ? $nasa_opt['email_url_follow'] : '');
    $pinterest  = $pinterest ? $pinterest : (isset($nasa_opt['pinterest_url_follow']) ? $nasa_opt['pinterest_url_follow'] : '');
    $instagram  = $instagram ? $instagram : (isset($nasa_opt['instagram_url']) ? $nasa_opt['instagram_url'] : '');
    $rss        = $rss ? $rss : (isset($nasa_opt['rss_url_follow']) ? $nasa_opt['rss_url_follow'] : '');
    $linkedin   = $linkedin ? $linkedin : (isset($nasa_opt['linkedin_url_follow']) ? $nasa_opt['linkedin_url_follow'] : '');
    $youtube    = $youtube ? $youtube : (isset($nasa_opt['youtube_url_follow']) ? $nasa_opt['youtube_url_follow'] : '');
    $flickr     = $flickr ? $flickr : (isset($nasa_opt['flickr_url_follow']) ? $nasa_opt['flickr_url_follow'] : '');
    $telegram   = $telegram ? $telegram : (isset($nasa_opt['telegram_url_follow']) ? $nasa_opt['telegram_url_follow'] : '');
    $whatsapp   = $whatsapp ? $whatsapp : (isset($nasa_opt['whatsapp_url_follow']) ? $nasa_opt['whatsapp_url_follow'] : '');
    $tiktok     = $tiktok ? $tiktok : (isset($nasa_opt['tiktok_url_follow']) ? $nasa_opt['tiktok_url_follow'] : '');
    $amazon     = $amazon ? $amazon : (isset($nasa_opt['amazon_url_follow']) ? $nasa_opt['amazon_url_follow'] : '');
    $tumblr     = $tumblr ? $tumblr : (isset($nasa_opt['tumblr_url_follow']) ? $nasa_opt['tumblr_url_follow'] : '');
    $vk         = $vk ? $vk : (isset($nasa_opt['vk_url_follow']) ? $nasa_opt['vk_url_follow'] : '');
    $weibo      = $weibo ? $weibo : (isset($nasa_opt['weibo_url_follow']) ? $nasa_opt['weibo_url_follow'] : '');
    
    $follow_wrap_start = '<div class="social-icons nasa-follow' . ($el_class ? ' ' . esc_attr($el_class) : '') . '">';
    $follow_wrap_start .= $title ? '<div class="nasa-follow-title">' . $title . '</div>' : '';
    $follow_wrap_start .= '<div class="follow-icon nasa-iflex flex-wrap">';
    
    $follow = '';
    
    $class_tip = 'nasa-tip';
    if (isset($tip)) {
        $class_tip .= $tip == 'left' ? ' nasa-tip-left' : '';
        $class_tip .= $tip == 'right' ? ' nasa-tip-right' : '';
        $class_tip .= $tip == 'bottom' ? ' nasa-tip-bottom' : '';
    }

    /**
     * Twitter
     */
    if ($twitter) {
        $follow .= '<a href="' . esc_url($twitter) . '" target="_blank" class="icon icon_twitter ' . esc_attr($class_tip) . '" title="' . esc_attr__('Follow us on X', 'nasa-core') . '" rel="nofollow"><svg viewBox="0 0 24 24" with="14" height="14" aria-hidden="true" fill="currentColor"><g><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path></g></svg></a>';
    }

    /**
     * FaceBook
     */
    if ($facebook) {
        $follow .= '<a href="' . esc_url($facebook) . '" target="_blank" class="icon icon_facebook ' . esc_attr($class_tip) . '" title="' . esc_attr__('Follow us on Facebook', 'nasa-core') . '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" with="14" height="14" fill="currentColor"><path d="M 19.253906 2 C 15.311906 2 13 4.0821719 13 8.8261719 L 13 13 L 8 13 L 8 18 L 13 18 L 13 30 L 18 30 L 18 18 L 22 18 L 23 13 L 18 13 L 18 9.671875 C 18 7.884875 18.582766 7 20.259766 7 L 23 7 L 23 2.2050781 C 22.526 2.1410781 21.144906 2 19.253906 2 z"></path></svg></a>';
    }
    
    /**
     * VK
     */
    if ($vk) {
        $follow .= '<a href="' . esc_url($vk) . '" target="_blank" class="icon icon_vk ' . esc_attr($class_tip) . '" title="' . esc_attr__('Follow us on VK', 'nasa-core') . '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="16" height="16" fill="currentColor"><path d="M45.763,35.202c-1.797-3.234-6.426-7.12-8.337-8.811c-0.523-0.463-0.579-1.264-0.103-1.776 c3.647-3.919,6.564-8.422,7.568-11.143C45.334,12.27,44.417,11,43.125,11l-3.753,0c-1.237,0-1.961,0.444-2.306,1.151 c-3.031,6.211-5.631,8.899-7.451,10.47c-1.019,0.88-2.608,0.151-2.608-1.188c0-2.58,0-5.915,0-8.28 c0-1.147-0.938-2.075-2.095-2.075L18.056,11c-0.863,0-1.356,0.977-0.838,1.662l1.132,1.625c0.426,0.563,0.656,1.248,0.656,1.951 L19,23.556c0,1.273-1.543,1.895-2.459,1.003c-3.099-3.018-5.788-9.181-6.756-12.128C9.505,11.578,8.706,11.002,7.8,11l-3.697-0.009 c-1.387,0-2.401,1.315-2.024,2.639c3.378,11.857,10.309,23.137,22.661,24.36c1.217,0.12,2.267-0.86,2.267-2.073l0-3.846 c0-1.103,0.865-2.051,1.977-2.079c0.039-0.001,0.078-0.001,0.117-0.001c3.267,0,6.926,4.755,8.206,6.979 c0.368,0.64,1.056,1.03,1.8,1.03l4.973,0C45.531,38,46.462,36.461,45.763,35.202z"></path></svg></a>';
    }

    /**
     * Email
     */
    if ($email) {
        $follow .= '<a href="mailto:' . $email . '" target="_blank" class="icon icon_email ' . esc_attr($class_tip) . '" title="' . esc_attr__('Send us an email', 'nasa-core') . '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17" fill="currentColor"><path d="M19,4H5A3,3,0,0,0,2,7V17a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V7A3,3,0,0,0,19,4ZM5,6H19a1,1,0,0,1,1,1l-8,4.88L4,7A1,1,0,0,1,5,6ZM20,17a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V9.28l7.48,4.57a1,1,0,0,0,1,0L20,9.28Z"></path></svg></a>';
    }

    /**
     * Pinterest
     */
    if ($pinterest) {
        $follow .= '<a href="' . esc_url($pinterest) . '" target="_blank" class="icon icon_pintrest ' . esc_attr($class_tip) . '" title="' . esc_attr__('Follow us on Pinterest', 'nasa-core') . '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16" fill="currentColor"><path d="M 7.5 1 C 3.910156 1 1 3.910156 1 7.5 C 1 10.253906 2.714844 12.605469 5.132813 13.554688 C 5.074219 13.039063 5.023438 12.25 5.152344 11.6875 C 5.273438 11.183594 5.914063 8.457031 5.914063 8.457031 C 5.914063 8.457031 5.722656 8.066406 5.722656 7.492188 C 5.722656 6.589844 6.246094 5.914063 6.898438 5.914063 C 7.453125 5.914063 7.71875 6.332031 7.71875 6.828125 C 7.71875 7.386719 7.363281 8.222656 7.183594 8.992188 C 7.027344 9.640625 7.507813 10.167969 8.144531 10.167969 C 9.300781 10.167969 10.1875 8.949219 10.1875 7.191406 C 10.1875 5.636719 9.070313 4.546875 7.472656 4.546875 C 5.625 4.546875 4.539063 5.933594 4.539063 7.367188 C 4.539063 7.925781 4.753906 8.527344 5.023438 8.851563 C 5.074219 8.917969 5.082031 8.972656 5.066406 9.039063 C 5.019531 9.242188 4.90625 9.6875 4.886719 9.777344 C 4.859375 9.894531 4.792969 9.921875 4.667969 9.863281 C 3.855469 9.484375 3.347656 8.296875 3.347656 7.34375 C 3.347656 5.292969 4.839844 3.410156 7.644531 3.410156 C 9.898438 3.410156 11.652344 5.015625 11.652344 7.164063 C 11.652344 9.402344 10.238281 11.207031 8.277344 11.207031 C 7.617188 11.207031 7 10.863281 6.789063 10.460938 C 6.789063 10.460938 6.460938 11.703125 6.382813 12.007813 C 6.234375 12.570313 5.839844 13.277344 5.574219 13.710938 C 6.183594 13.898438 6.828125 14 7.5 14 C 11.089844 14 14 11.089844 14 7.5 C 14 3.910156 11.089844 1 7.5 1 Z"></path></svg></a>';
    }

    /**
     * Instagram
     */
    if ($instagram) {
        $follow .= '<a href="' . esc_url($instagram) . '" target="_blank" class="icon icon_instagram ' . esc_attr($class_tip) . '" title="' . esc_attr__('Follow us on Instagram', 'nasa-core') . '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="16" height="16" fill="currentColor"><path d="M 16.5 5 C 10.16639 5 5 10.16639 5 16.5 L 5 31.5 C 5 37.832757 10.166209 43 16.5 43 L 31.5 43 C 37.832938 43 43 37.832938 43 31.5 L 43 16.5 C 43 10.166209 37.832757 5 31.5 5 L 16.5 5 z M 16.5 8 L 31.5 8 C 36.211243 8 40 11.787791 40 16.5 L 40 31.5 C 40 36.211062 36.211062 40 31.5 40 L 16.5 40 C 11.787791 40 8 36.211243 8 31.5 L 8 16.5 C 8 11.78761 11.78761 8 16.5 8 z M 34 12 C 32.895 12 32 12.895 32 14 C 32 15.105 32.895 16 34 16 C 35.105 16 36 15.105 36 14 C 36 12.895 35.105 12 34 12 z M 24 14 C 18.495178 14 14 18.495178 14 24 C 14 29.504822 18.495178 34 24 34 C 29.504822 34 34 29.504822 34 24 C 34 18.495178 29.504822 14 24 14 z M 24 17 C 27.883178 17 31 20.116822 31 24 C 31 27.883178 27.883178 31 24 31 C 20.116822 31 17 27.883178 17 24 C 17 20.116822 20.116822 17 24 17 z"></path></svg></a>';
    }

    /**
     * Rss
     */
    if ($rss) {
        $follow .= '<a href="' . esc_url($rss) . '" target="_blank" class="icon icon_rss ' . esc_attr($class_tip) . '" title="' . esc_attr__('Subscribe to RSS', 'nasa-core') . '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="16" height="16" fill="currentColor"><path d="M 5 5 L 5 9 C 14.93 9 23 17.07 23 27 L 27 27 C 27 14.85 17.15 5 5 5 z M 5 12 L 5 16 C 11.07 16 16 20.93 16 27 L 20 27 C 20 18.72 13.28 12 5 12 z M 8 21 A 3 3 0 0 0 8 27 A 3 3 0 0 0 8 21 z"></path></svg></a>';
    }

    /**
     * LinkedIn
     */
    if ($linkedin) {
        $follow .= '<a href="' . esc_url($linkedin) . '" target="_blank" class="icon icon_linkedin ' . esc_attr($class_tip) . '" title="' . esc_attr__('Follow us on LinkedIn', 'nasa-core') . '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="16" height="16" fill="currentColor"><path d="M9,25H4V10h5V25z M6.501,8C5.118,8,4,6.879,4,5.499S5.12,3,6.501,3C7.879,3,9,4.121,9,5.499C9,6.879,7.879,8,6.501,8z M27,25h-4.807v-7.3c0-1.741-0.033-3.98-2.499-3.98c-2.503,0-2.888,1.896-2.888,3.854V25H12V9.989h4.614v2.051h0.065 c0.642-1.18,2.211-2.424,4.551-2.424c4.87,0,5.77,3.109,5.77,7.151C27,16.767,27,25,27,25z"></path></svg></a>';
    }

    /**
     * YouTube
     */
    if ($youtube) {
        $follow .= '<a href="' . esc_url($youtube) . '" target="_blank" class="icon icon_youtube ' . esc_attr($class_tip) . '" title="' . esc_attr__('Follow us on YouTube', 'nasa-core') . '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M21.582,6.186c-0.23-0.86-0.908-1.538-1.768-1.768C18.254,4,12,4,12,4S5.746,4,4.186,4.418 c-0.86,0.23-1.538,0.908-1.768,1.768C2,7.746,2,12,2,12s0,4.254,0.418,5.814c0.23,0.86,0.908,1.538,1.768,1.768 C5.746,20,12,20,12,20s6.254,0,7.814-0.418c0.861-0.23,1.538-0.908,1.768-1.768C22,16.254,22,12,22,12S22,7.746,21.582,6.186z M10,14.598V9.402c0-0.385,0.417-0.625,0.75-0.433l4.5,2.598c0.333,0.192,0.333,0.674,0,0.866l-4.5,2.598 C10.417,15.224,10,14.983,10,14.598z"></path></svg></a>';
    }

    /**
     * Flickr
     */
    if ($flickr) {
        $follow .= '<a href="' . esc_url($flickr) . '" target="_blank" class="icon icon_flickr ' . esc_attr($class_tip) . '" title="' . esc_attr__('Follow us on Flickr', 'nasa-core') . '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="16" height="16" fill="currentColor"><path d="M36.5,6h-25C8.468,6,6,8.467,6,11.5v25c0,3.033,2.468,5.5,5.5,5.5h25c3.032,0,5.5-2.467,5.5-5.5v-25 C42,8.467,39.532,6,36.5,6z M16.5,29c-3.038,0-5.5-2.462-5.5-5.5c0-3.038,2.462-5.5,5.5-5.5s5.5,2.462,5.5,5.5 C22,26.538,19.538,29,16.5,29z M31.5,29c-3.038,0-5.5-2.462-5.5-5.5c0-3.038,2.462-5.5,5.5-5.5s5.5,2.462,5.5,5.5 C37,26.538,34.538,29,31.5,29z"></path></svg></a>';
    }
    
    /**
     * Tumblr
     */
    if ($tumblr) {
        $follow .= '<a href="' . esc_url($tumblr) . '" target="_blank" class="icon icon_tumblr ' . esc_attr($class_tip) . '" title="' . esc_attr__('Follow us on Tumblr', 'nasa-core') . '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="17" height="17" fill="currentColor"><path d="M17.594,23.641h-2.681c-0.692,0-1.253-0.561-1.253-1.253v-4.613c0-0.758,0.475-1.428,1.189-1.681 c1.738-0.614,4.822-2.439,5.33-7.712C20.255,7.605,20.892,7,21.674,7h4.993c0.681,0,1.234,0.552,1.234,1.234v7.267h5.053 c0.692,0,1.253,0.561,1.253,1.253v5.635c0,0.692-0.561,1.253-1.253,1.253h-5.053v8.142c0,1.85,0.893,2.559,1.745,2.559 c0.67,0,1.828-0.306,2.685-0.538c0.712-0.193,1.196,0.026,1.444,0.747s1.598,4.557,1.598,4.557c0.246,0.703-0.006,1.477-0.615,1.906 c-1.152,0.812-3.319,1.924-6.547,1.924c-5.014,0-10.617-2.228-10.617-10.542C17.594,30.745,17.594,23.641,17.594,23.641z"></path></svg></a>';
    }

    /**
     * Telegram
     */
    if ($telegram) {
        $follow .= '<a href="' . esc_url($telegram) . '" target="_blank" class="icon icon_telegram ' . esc_attr($class_tip) . '" title="' . esc_attr__('Follow us on Telegram', 'nasa-core') . '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="15" height="15" fill="currentColor"><path d="M25,2c12.703,0,23,10.297,23,23S37.703,48,25,48S2,37.703,2,25S12.297,2,25,2z M32.934,34.375 c0.423-1.298,2.405-14.234,2.65-16.783c0.074-0.772-0.17-1.285-0.648-1.514c-0.578-0.278-1.434-0.139-2.427,0.219 c-1.362,0.491-18.774,7.884-19.78,8.312c-0.954,0.405-1.856,0.847-1.856,1.487c0,0.45,0.267,0.703,1.003,0.966 c0.766,0.273,2.695,0.858,3.834,1.172c1.097,0.303,2.346,0.04,3.046-0.395c0.742-0.461,9.305-6.191,9.92-6.693 c0.614-0.502,1.104,0.141,0.602,0.644c-0.502,0.502-6.38,6.207-7.155,6.997c-0.941,0.959-0.273,1.953,0.358,2.351 c0.721,0.454,5.906,3.932,6.687,4.49c0.781,0.558,1.573,0.811,2.298,0.811C32.191,36.439,32.573,35.484,32.934,34.375z"></path></svg></a>';
    }

    /**
     * Whatsapp
     */
    if ($whatsapp) {
        $follow .= '<a href="' . esc_url($whatsapp) . '" target="_blank" class="icon icon_whatsapp ' . esc_attr($class_tip) . '" title="' . esc_attr__('Follow us on Whatsapp', 'nasa-core') . '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17" fill="currentColor"><path d="M 12.011719 2 C 6.5057187 2 2.0234844 6.478375 2.0214844 11.984375 C 2.0204844 13.744375 2.4814687 15.462563 3.3554688 16.976562 L 2 22 L 7.2324219 20.763672 C 8.6914219 21.559672 10.333859 21.977516 12.005859 21.978516 L 12.009766 21.978516 C 17.514766 21.978516 21.995047 17.499141 21.998047 11.994141 C 22.000047 9.3251406 20.962172 6.8157344 19.076172 4.9277344 C 17.190172 3.0407344 14.683719 2.001 12.011719 2 z M 12.009766 4 C 14.145766 4.001 16.153109 4.8337969 17.662109 6.3417969 C 19.171109 7.8517969 20.000047 9.8581875 19.998047 11.992188 C 19.996047 16.396187 16.413812 19.978516 12.007812 19.978516 C 10.674812 19.977516 9.3544062 19.642812 8.1914062 19.007812 L 7.5175781 18.640625 L 6.7734375 18.816406 L 4.8046875 19.28125 L 5.2851562 17.496094 L 5.5019531 16.695312 L 5.0878906 15.976562 C 4.3898906 14.768562 4.0204844 13.387375 4.0214844 11.984375 C 4.0234844 7.582375 7.6067656 4 12.009766 4 z M 8.4765625 7.375 C 8.3095625 7.375 8.0395469 7.4375 7.8105469 7.6875 C 7.5815469 7.9365 6.9355469 8.5395781 6.9355469 9.7675781 C 6.9355469 10.995578 7.8300781 12.182609 7.9550781 12.349609 C 8.0790781 12.515609 9.68175 15.115234 12.21875 16.115234 C 14.32675 16.946234 14.754891 16.782234 15.212891 16.740234 C 15.670891 16.699234 16.690438 16.137687 16.898438 15.554688 C 17.106437 14.971687 17.106922 14.470187 17.044922 14.367188 C 16.982922 14.263188 16.816406 14.201172 16.566406 14.076172 C 16.317406 13.951172 15.090328 13.348625 14.861328 13.265625 C 14.632328 13.182625 14.464828 13.140625 14.298828 13.390625 C 14.132828 13.640625 13.655766 14.201187 13.509766 14.367188 C 13.363766 14.534188 13.21875 14.556641 12.96875 14.431641 C 12.71875 14.305641 11.914938 14.041406 10.960938 13.191406 C 10.218937 12.530406 9.7182656 11.714844 9.5722656 11.464844 C 9.4272656 11.215844 9.5585938 11.079078 9.6835938 10.955078 C 9.7955938 10.843078 9.9316406 10.663578 10.056641 10.517578 C 10.180641 10.371578 10.223641 10.267562 10.306641 10.101562 C 10.389641 9.9355625 10.347156 9.7890625 10.285156 9.6640625 C 10.223156 9.5390625 9.737625 8.3065 9.515625 7.8125 C 9.328625 7.3975 9.131125 7.3878594 8.953125 7.3808594 C 8.808125 7.3748594 8.6425625 7.375 8.4765625 7.375 z"></path></svg></a>';
    }
    
    /**
     * Tiktok
     */
    if ($tiktok) {
        $follow .= '<a href="' . esc_url($tiktok) . '" target="_blank" class="icon icon_tiktok ' . esc_attr($class_tip) . '" title="' . esc_attr__('Follow us on Tiktok', 'nasa-core') . '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2859 3333" width="14" height="14" fill="currentColor"><path d="M2081 0c55 473 319 755 778 785v532c-266 26-499-61-770-225v995c0 1264-1378 1659-1932 753-356-583-138-1606 1004-1647v561c-87 14-180 36-265 65-254 86-398 247-358 531 77 544 1075 705 992-358V1h551z"></path></svg></a>';
    }
    
    /**
     * Weibo
     */
    if ($weibo) {
        $follow .= '<a href="' . esc_url($weibo) . '" target="_blank" class="icon icon_weibo ' . esc_attr($class_tip) . '" title="' . esc_attr__('Follow us on Weibo', 'nasa-core') . '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="17" height="17" fill="currentColor"><path d="M 35 6 C 34.222656 6 33.472656 6.078125 32.75 6.207031 C 32.207031 6.300781 31.84375 6.820313 31.9375 7.363281 C 32.03125 7.910156 32.550781 8.273438 33.09375 8.179688 C 33.726563 8.066406 34.359375 8 35 8 C 41.085938 8 46 12.914063 46 19 C 46 20.316406 45.757813 21.574219 45.328125 22.753906 C 45.195313 23.09375 45.253906 23.476563 45.484375 23.757813 C 45.71875 24.039063 46.082031 24.171875 46.441406 24.105469 C 46.800781 24.039063 47.09375 23.78125 47.207031 23.4375 C 47.710938 22.054688 48 20.566406 48 19 C 48 11.832031 42.167969 6 35 6 Z M 35 12 C 34.574219 12 34.171875 12.042969 33.789063 12.109375 C 33.246094 12.207031 32.878906 12.722656 32.976563 13.269531 C 33.070313 13.8125 33.589844 14.175781 34.132813 14.082031 C 34.425781 14.03125 34.714844 14 35 14 C 37.773438 14 40 16.226563 40 19 C 40 19.597656 39.890625 20.167969 39.691406 20.707031 C 39.503906 21.226563 39.773438 21.800781 40.292969 21.988281 C 40.8125 22.175781 41.386719 21.910156 41.574219 21.390625 C 41.84375 20.648438 42 19.84375 42 19 C 42 15.144531 38.855469 12 35 12 Z M 21.175781 12.40625 C 17.964844 12.34375 13.121094 14.878906 8.804688 19.113281 C 4.511719 23.40625 2 27.90625 2 31.78125 C 2 39.3125 11.628906 43.8125 21.152344 43.8125 C 33.5 43.8125 41.765625 36.699219 41.765625 31.046875 C 41.765625 27.59375 38.835938 25.707031 36.21875 24.871094 C 35.59375 24.660156 35.175781 24.558594 35.488281 23.71875 C 35.695313 23.21875 36 22.265625 36 21 C 36 19.5625 35 18.316406 33 18.09375 C 32.007813 17.984375 28 18 25.339844 19.113281 C 25.339844 19.113281 23.871094 19.746094 24.289063 18.59375 C 25.023438 16.292969 24.917969 14.40625 23.765625 13.359375 C 23.140625 12.730469 22.25 12.425781 21.175781 12.40625 Z M 20.3125 23.933594 C 28.117188 23.933594 34.441406 27.914063 34.441406 32.828125 C 34.441406 37.738281 28.117188 41.71875 20.3125 41.71875 C 12.511719 41.71875 6.1875 37.738281 6.1875 32.828125 C 6.1875 27.914063 12.511719 23.933594 20.3125 23.933594 Z M 19.265625 26.023438 C 16.246094 26.046875 13.3125 27.699219 12.039063 30.246094 C 10.46875 33.484375 11.933594 37.042969 15.699219 38.191406 C 19.464844 39.445313 23.960938 37.5625 25.53125 34.113281 C 27.097656 30.769531 25.113281 27.214844 21.347656 26.277344 C 20.660156 26.097656 19.960938 26.019531 19.265625 26.023438 Z M 20.824219 30.25 C 21.402344 30.25 21.871094 30.714844 21.871094 31.292969 C 21.871094 31.871094 21.402344 32.339844 20.824219 32.339844 C 20.246094 32.339844 19.777344 31.871094 19.777344 31.292969 C 19.777344 30.714844 20.246094 30.25 20.824219 30.25 Z M 16.417969 31.292969 C 16.746094 31.296875 17.074219 31.347656 17.382813 31.453125 C 18.722656 31.878906 19.132813 33.148438 18.308594 34.207031 C 17.589844 35.265625 15.945313 35.792969 14.707031 35.265625 C 13.476563 34.738281 13.167969 33.464844 13.886719 32.515625 C 14.425781 31.71875 15.429688 31.28125 16.417969 31.292969 Z"></path></svg></a>';
    }
    
    /**
     * Amazon
     */
    if ($amazon) {
        $follow .= '<a href="' . esc_url($amazon) . '" target="_blank" class="icon icon_amazon ' . esc_attr($class_tip) . '" title="' . esc_attr__('Follow us on Amazon', 'nasa-core') . '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="16" height="16" fill="currentColor"><path d="M 15.183594 3 C 11.820594 3 8.0848281 4.2580938 7.2988281 8.3710938 C 7.2148281 8.8090937 7.5215469 9.0336562 7.8105469 9.0976562 L 11.224609 9.4453125 C 11.545609 9.4283125 11.801281 9.1304531 11.863281 8.8144531 C 12.157281 7.3974531 13.357125 6.6972656 14.703125 6.6972656 C 15.430125 6.6972656 16.253594 6.9692812 16.683594 7.6132812 C 17.180594 8.3322813 17.097656 9.3095781 17.097656 10.142578 L 17.097656 10.615234 C 15.048656 10.843234 12.376937 10.982406 10.460938 11.816406 C 8.2469375 12.763406 6.6933594 14.695156 6.6933594 17.535156 C 6.6933594 21.169156 9.0171875 23.001953 11.992188 23.001953 C 14.505187 23.001953 15.860781 22.399359 17.800781 20.443359 C 18.441781 21.362359 18.66975 21.81425 19.84375 22.78125 C 20.10775 22.92125 20.440828 22.8955 20.673828 22.6875 L 20.673828 22.71875 C 21.378828 22.09675 22.664766 20.981859 23.384766 20.380859 C 23.671766 20.146859 23.609766 19.781891 23.384766 19.462891 C 22.738766 18.579891 22.076172 17.847031 22.076172 16.207031 L 22.076172 10.771484 C 22.076172 8.4624844 22.232672 6.3263281 20.513672 4.7363281 C 19.156672 3.4483281 16.901594 3 15.183594 3 z M 16.140625 13.425781 C 16.459625 13.404781 16.777656 13.425781 17.097656 13.425781 L 17.097656 14.183594 C 17.098656 15.547594 17.152984 16.668859 16.458984 17.880859 C 15.896984 18.864859 14.993953 19.460938 14.001953 19.460938 C 12.645953 19.460938 11.861328 18.445641 11.861328 16.931641 C 11.861328 14.326641 13.910625 13.570781 16.140625 13.425781 z M 26.080078 22.220703 C 25.171078 22.233703 24.106016 22.424234 23.291016 22.990234 C 23.041016 23.164234 23.077469 23.409953 23.355469 23.376953 C 24.272469 23.267953 26.299063 23.011656 26.664062 23.472656 C 27.028063 23.934656 26.261922 25.832641 25.919922 26.681641 C 25.815922 26.937641 26.041391 27.036797 26.275391 26.841797 C 27.801391 25.577797 28.208484 22.956266 27.896484 22.572266 C 27.741484 22.385266 26.990078 22.207703 26.080078 22.220703 z M 2.1777344 22.701172 C 1.9877344 22.726172 1.9132812 22.973344 2.1132812 23.152344 C 5.5052812 26.184344 9.9770781 28 14.955078 28 C 18.506078 28 22.651094 26.899312 25.496094 24.820312 C 25.966094 24.475313 25.557172 23.943484 25.076172 24.146484 C 21.887172 25.486484 18.401047 26.136719 15.248047 26.136719 C 10.573047 26.136719 6.06525 24.873625 2.40625 22.765625 C 2.32525 22.719625 2.2397344 22.693172 2.1777344 22.701172 z"></path></svg></a>';
    }
    
    $follow_content = apply_filters('nasa_follow_content', $follow);
    
    $follow_wrap_end = '</div></div>';

    return $follow_content ? $follow_wrap_start . $follow_content . $follow_wrap_end : '';
}

/**
 * Register Params
 */
function nasa_register_share_follow(){
    $share_params = array(
        "name" => "Share",
        "base" => "nasa_share",
        'icon' => 'icon-wpb-nasatheme',
        'description' => __("Display share icon social.", 'nasa-core'),
        "content_element" => true,
        "category" => 'Nasa Core',
        "show_settings_on_create" => false,
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __('Title', 'nasa-core'),
                "param_name" => 'title'
            ),
            array(
                "type" => "textfield",
                "heading" => __("Extra class name", 'nasa-core'),
                "param_name" => "el_class",
                "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nasa-core')
            )
        )
    );
    vc_map($share_params);

    // **********************************************************************// 
    // ! Register New Element: Follow
    // **********************************************************************//
    $follow = array(
        "name" => "Follow",
        "base" => "nasa_follow",
        'icon' => 'icon-wpb-nasatheme',
        'description' => __("Display Follow icon social.", 'nasa-core'),
        "content_element" => true,
        "category" => 'Nasa Core',
        "show_settings_on_create" => false,
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __('Title', 'nasa-core'),
                "param_name" => 'title'
            ),
            array(
                "type" => "textfield",
                "heading" => __('X', 'nasa-core'),
                "param_name" => 'twitter'
            ),
            array(
                "type" => "textfield",
                "heading" => __('Facebook', 'nasa-core'),
                "param_name" => 'facebook'
            ),
            array(
                "type" => "textfield",
                "heading" => __('Pinterest', 'nasa-core'),
                "param_name" => 'pinterest'
            ),
            array(
                "type" => "textfield",
                "heading" => __('Email', 'nasa-core'),
                "param_name" => 'email'
            ),
            array(
                "type" => "textfield",
                "heading" => __('Instagram', 'nasa-core'),
                "param_name" => 'instagram'
            ),
            array(
                "type" => "textfield",
                "heading" => __('RSS', 'nasa-core'),
                "param_name" => 'rss'
            ),
            array(
                "type" => "textfield",
                "heading" => __('Linkedin', 'nasa-core'),
                "param_name" => 'linkedin'
            ),
            array(
                "type" => "textfield",
                "heading" => __('Youtube', 'nasa-core'),
                "param_name" => 'youtube'
            ),
            array(
                "type" => "textfield",
                "heading" => __('Flickr', 'nasa-core'),
                "param_name" => 'flickr'
            ),
            array(
                "type" => "textfield",
                "heading" => __('Telegram', 'nasa-core'),
                "param_name" => 'telegram'
            ),
            array(
                "type" => "textfield",
                "heading" => __('Whatsapp', 'nasa-core'),
                "param_name" => 'whatsapp'
            ),
            array(
                "type" => "textfield",
                "heading" => __('Tiktok', 'nasa-core'),
                "param_name" => 'tiktok'
            ),
            array(
                "type" => "textfield",
                "heading" => __('Weibo', 'nasa-core'),
                "param_name" => 'weibo'
            ),
            array(
                "type" => "textfield",
                "heading" => __('Amazon', 'nasa-core'),
                "param_name" => 'amazon'
            ),
            array(
                "type" => "textfield",
                "heading" => __('Tumblr', 'nasa-core'),
                "param_name" => 'tumblr'
            ),
            array(
                "type" => "textfield",
                "heading" => __("Extra class name", 'nasa-core'),
                "param_name" => "el_class",
                "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nasa-core')
            )
        )
    );

    vc_map($follow);
}
