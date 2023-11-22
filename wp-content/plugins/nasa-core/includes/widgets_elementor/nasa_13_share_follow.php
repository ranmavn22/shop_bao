<?php
/**
 * Widget for Elementor
 */

/**
 * Nasa Share
 */
class Nasa_Share_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Constructor
     */
    public function __construct() {
        $this->shortcode = 'nasa_share';
        $this->widget_cssclass = 'nasa_share_wgsc';
        $this->widget_description = __('Display Share', 'nasa-core');
        $this->widget_id = 'nasa_share_sc';
        $this->widget_name = 'ELM - Nasa Share';
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Title', 'nasa-core')
            ),
            
            'el_class' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Extra class name', 'nasa-core')
            )
        );

        parent::__construct();
    }
}

/**
 * Nasa Follow
 */
class Nasa_Follow_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Constructor
     */
    public function __construct() {
        $this->shortcode = 'nasa_follow';
        $this->widget_cssclass = 'nasa_follow_wgsc';
        $this->widget_description = __('Display Follow', 'nasa-core');
        $this->widget_id = 'nasa_follow';
        $this->widget_name = 'ELM - Nasa Follow';
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Title', 'nasa-core')
            ),
            
            'twitter' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('X', 'nasa-core')
            ),
            
            'facebook' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Facebook', 'nasa-core')
            ),
            
            'pinterest' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Pinterest', 'nasa-core')
            ),
            
            'email' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Email', 'nasa-core')
            ),
            
            'instagram' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Instagram', 'nasa-core')
            ),
            
            'rss' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('RSS', 'nasa-core')
            ),
            
            'linkedin' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Linkedin', 'nasa-core')
            ),
            
            'youtube' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Youtube', 'nasa-core')
            ),
            
            'flickr' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Flickr', 'nasa-core')
            ),
            
            'telegram' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Telegram', 'nasa-core')
            ),
            
            'whatsapp' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Whatsapp', 'nasa-core')
            ),
            
            'tiktok' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Tiktok', 'nasa-core')
            ),
            
            'amazon' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Amazon', 'nasa-core')
            ),
            
            'tumblr' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Tumblr', 'nasa-core')
            ),
            
            'el_class' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Extra class name', 'nasa-core')
            )
        );

        parent::__construct();
    }
}
