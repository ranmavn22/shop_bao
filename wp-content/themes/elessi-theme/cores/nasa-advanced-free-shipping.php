<?php
defined('ABSPATH') or die(); // Exit if accessed directly
/**
 * Nasa Advanced Free Shipping
 */
class Nasa_Advanced_Free_Shipping {
    public $render = true;
    
    protected $value = 0;
    
    protected $conditions = array();

    /**
     * Constructor
     */
    public function __construct($conditions = array()) {
        $this->conditions = $conditions;
        $this->check_condition();
    }
    
    protected function check_condition() {
        /**
         * Check rule is subtotal
         */
        foreach ($this->conditions as $condition) {
            /**
             * Check subtotal
             */
            if (
                $condition['condition'] == 'subtotal' &&
                $condition['operator'] == '>=' &&
                $condition['value'] && 
                (!$this->value || $this->value > $condition['value'])
            ) {
                $this->value = $condition['value'];
            }

            /**
             * Check country
             */
            if (
                $condition['condition'] == 'country' &&
                $condition['operator'] == '==' &&
                $condition['value']
            ) {
                // $user_contry = WC()->customer->get_shipping_country();
                if (!$this->_check_country($condition['value'])) {
                    $this->render = false;
                    break;
                }
            }
        }
        
        if (!$this->value) {
            $this->render = false;
        }
    }
    
    protected function _check_country($country = '') {
        $user_country = WC()->customer->get_shipping_country();
        
        return $user_country == $country ? true : false;
    }

    public function output_html() {
        $content = '';
        
        if ($this->value && $this->render) {
            $subtotal_cart = WC()->cart->subtotal;
            $spend = 0;

            $content_cond = '';
            $content_desc = '';

            /**
             * Check free shipping
             */
            if ($subtotal_cart < $this->value) {
                $spend = $this->value - $subtotal_cart;
                $per = intval(($subtotal_cart/$this->value)*100);

                $allowed_html = array(
                    'strong' => array(),
                    'a' => array(
                        'class' => array(),
                        'href' => array(),
                        'title' => array()
                    ),
                    'span' => array(
                        'class' => array()
                    ),
                    'br' => array()
                );

                $content_desc .= '<div class="nasa-total-condition-desc text-center">' .
                sprintf(
                    wp_kses(__('Spend %s more to reach <strong>FREE SHIPPING!</strong> <a class="continue-cart hide-in-cart-sidebar" href="%s" title="Continue Shopping">Continue Shopping</a>', 'elessi-theme'), $allowed_html),
                    wc_price($spend),
                    esc_url(get_permalink(wc_get_page_id('shop')))
                ) . 
                '</div>';
            }
            /**
             * Congratulations! You've got free shipping!
             */
            else {
                $per = 100;
                $content_desc .= '<div class="nasa-total-condition-desc text-center">';
                $content_desc .= '<i class="pe-icon pe-7s-check text-success fs-20 margin-right-5 rtl-margin-right-0 rtl-margin-left-5"></i>';
                $content_desc .= esc_html__("Congratulations! You've got free shipping.", 'elessi-theme');
                $content_desc .= '</div>';
            }

            $class_cond = 'nasa-total-condition-wrap';

            $content_cond .= '<div class="nasa-total-condition" data-per="' . $per . '">' .
                '<div class="nasa-subtotal-condition primary-bg nasa-relative">' .
                    '<span class="nasa-total-number primary-border text-center nasa-flex jc">' . $per . '%</span>' .
                '</div>' .
            '</div>';

            $content .= '<div class="' . $class_cond . '">';
            $content .= $content_cond;
            $content .= '</div>';
            $content .= $content_desc;
        }
        
        return $content;
    }

}
