/* Document ready */
jQuery(document).ready(function($) {
    "use strict";
    
    /**
     * Images exists be checked
     * @type Array
     */
    var _ns_img_checked = [];
    var touchstart = 0;
    var touchend  = 0;
    var distance =60;  

    $('body').on('ns_btns_fixed', function() {
        if ($('.ns_btn-fixed').length <= 0) {
            $('body').append('<div class="ns_btn-fixed nasa-flex"></div>');
        }
        
        var has_padding_bottom = false;
    
        if ($('.nasa-single-product-in-mobile .single_add_to_cart_button').length) {
            if ($('.ns_btn-fixed').find('.single_add_to_cart_button').length <= 0) {
                var _text = $('.nasa-single-product-in-mobile .single_add_to_cart_button').text();
                $('.ns_btn-fixed').append('<a href="javascript:void(0);" class="single_add_to_cart_button button">' + _text + '</a>');
            }
            
            has_padding_bottom = true;
        }
    
        if ($('.nasa-single-product-in-mobile .nasa-buy-now').length) {
            if ($('.ns_btn-fixed').find('.nasa-buy-now').length <= 0) {
                var _text = $('.nasa-single-product-in-mobile .nasa-buy-now').text();
                $('.ns_btn-fixed').append('<a href="javascript:void(0);" class="nasa-buy-now button">' + _text + '</a>');
            }
            
            has_padding_bottom = true;
        }
        
        if (has_padding_bottom) {
            var _padding_bottom = $('.ns_btn-fixed').outerHeight();
            $('body').css({'padding-bottom': _padding_bottom});
        }
        
    }).trigger('ns_btns_fixed');
    
    /**
     * ADD TO CART - show in variations form
     */
    $('body').on('click', '.ns_btn-fixed .single_add_to_cart_button, .ns-open-var-form', function() {
        if ($('.nasa-single-product-in-mobile form.cart').length) {
            var _form = $('.nasa-single-product-in-mobile form.cart');
            var _btn = $(_form).find('.single_add_to_cart_button');

            $('body').trigger('slick_go_to_0',[$('.main-images')]);

            if ($(_form).hasClass('variations_form')) {
                if (!$(_form).hasClass('ns-show')) {
                    $(_form).addClass('ns-show ns_add_to_cart_button_show');
                    
                    $('.black-window').fadeIn(200).addClass('desk-window');
                    
                    if (!$('body').hasClass('ovhd')) {
                        $('body').addClass('ovhd');
                    }
                }
            } else {
                if ($(_btn).length) {
                    if ($('.ns_btn-fixed .single_add_to_cart_button').length) {
                        $('.ns_btn-fixed .single_add_to_cart_button').each(function() {
                            var _thisbtn = $(this);
                            if (!$(_thisbtn).hasClass('loading')) {
                                $(_thisbtn).addClass('loading');
                            }
                        });
                    }
                    
                    $(_btn).trigger('click');
                }
            }
        }
    });
    
    /**
     * BUY NOW - show in variations form
     */
    $('body').on('click', '.ns_btn-fixed .nasa-buy-now', function() {
        if ($('.nasa-single-product-in-mobile form.cart').length) {
            var _this = $(this);
            
            if (!$(_this).hasClass('loading')) {
                $(_this).addClass('loading');
            }
            
            var _form = $('.nasa-single-product-in-mobile form.cart');
            var _btn = $(_form).find('.nasa-buy-now');
            
            $('body').trigger('slick_go_to_0',[$('.main-images')]);
            
            if ($(_form).hasClass('variations_form')) {
                if (!$(_form).hasClass('ns-show')) {
                    $(_form).addClass('ns-show ns_buy_now_button_show');
                    
                    $(_this).removeClass('loading');
                    
                    $('.black-window').fadeIn(200).addClass('desk-window');
                    
                    if (!$('body').hasClass('ovhd')) {
                        $('body').addClass('ovhd');
                    }
                }
            } else {
                if ($(_btn).length) {
                    $(_btn).trigger('click');
                }
            }
        }
    });

    /**
     * NEW REVIEW
     */
    $('body').on('click', '.btn-add-new-review ', function() {
        if ($('.nasa-single-product-in-mobile #review_form_wrapper').length) {
            var _form = $('.nasa-single-product-in-mobile #review_form_wrapper');

            if (!$(_form).hasClass('ns-show')) {
                $(_form).addClass('ns-show');

                $('.black-window').fadeIn(200).addClass('desk-window');

                if (!$('body').hasClass('ovhd')) {
                    $('body').addClass('ovhd');
                }
            }
        }
    });
    
    /**
     * Hide simple product - cart form
     */
    $('body').on('ns_hide_simple_cart_form', function() {
        if (
            $('.nasa-single-product-in-mobile form.cart').length &&
            $('.nasa-single-product-in-mobile form.cart').find('input[name="data-type"]').length
        ) {
            if ($('.nasa-single-product-in-mobile form.cart').find('input[name="data-type"]').val() === 'simple') {
                /**
                 * Compatible WCPA
                 */
                if ($('.nasa-single-product-in-mobile form.cart').find('.wcpa_form_outer').length) {
                    $('.nasa-single-product-in-mobile form.cart').find('>*').each(function() {
                        if (!$(this).hasClass('wcpa_form_outer')) {
                            $(this).hide();
                        }
                    });
                } else {
                    $('.nasa-single-product-in-mobile form.cart').hide();
                }
            }
        }
    }).trigger('ns_hide_simple_cart_form');
    
    /**
     * Checkout Plugins - Stripe for WooCommerce
     */
    $('body').on('ns_ppc_woo', function() {
        var _form = $('.nasa-single-product-in-mobile form.cart');
        
        if ($(_form).length && ($('#ppcp-messages').length || $('.ppc-button-wrapper').length)) {
            
            if ($('.ns-ppc-wrap').length <= 0) {
                $(_form).after('<div class="ns-ppc-wrap ns-begin-wrap nasa-crazy-box"></div>');
            }
            
            /**
             * Checkout Plugins - Stripe for WooCommerce - Mess
             */
            if ($('#ppcp-messages').length) {
                var _ppcp_mess = $('#ppcp-messages');
                $('.ns-ppc-wrap').append(_ppcp_mess);
            }

            /**
             * Checkout Plugins - Stripe for WooCommerce - Button
             */
            if ($('.ppc-button-wrapper').length) {
                var _ppc_btns = $('.ppc-button-wrapper');
                $('.ns-ppc-wrap').append(_ppc_btns);
            }
        }
    }).trigger('ns_ppc_woo');
    
    /**
     * triger price load
     */
    $('body').on('ns_add_nasa_price_loading', function(e, _form) {
        var _org_price = null,
            _sub_price = null,
            _sub_price_1st = null,
            _sub_price_2nd = null;

        if ($(_form).find('.ns-form-info .ns-info-wrap').length <= 0) {
            $(_form).find('.ns-form-info').append('<div class="ns-info-wrap"></div>');
        }
        
        $(_form).find('.ns-form-info .ns-info-wrap').html('');

        if ($(_form).find('.ns-form-info .ns-info-wrap .ns-price-wrap').length <= 0) {
            $(_form).find('.ns-form-info .ns-info-wrap').append('<div class="ns-price-wrap"></div>');
        }
        
        /**
         * nasa-single-product-price - Orgirin
         */
        if ($('.nasa-single-product-in-mobile .price.nasa-single-product-price').length) {
            if (!$('.nasa-single-product-in-mobile .price.nasa-single-product-price').hasClass('org-price')) {
                $('.nasa-single-product-in-mobile .price.nasa-single-product-price').addClass('org-price');
            }
            
            _org_price = $('.nasa-single-product-in-mobile .price.nasa-single-product-price').clone();
            
            $(_org_price).removeClass('nasa-single-product-price');
        }
        
        if (_org_price) {
            $(_form).find('.ns-form-info .ns-price-wrap').append(_org_price);
        }

        if ($(_form).find('.ns-info-variants .single_variation_wrap .woocommerce-variation-price .price').length) {
            _sub_price = $(_form).find('.ns-info-variants .single_variation_wrap .woocommerce-variation-price .price').html();
        } else if ($('.nasa-single-product-in-mobile .nasa-bulk-price').length) {
            _sub_price = $('.nasa-single-product-in-mobile .nasa-bulk-price').html();
        }
        
        if (_sub_price) {
            /**
             * For Bulk Price OUT Form
             */
            _sub_price_1st = '<p class="price nasa-bulk-price">' + _sub_price + '</p>';

            if ($('.nasa-single-product-in-mobile .nasa-bulk-price').length <= 0) {
                $('.nasa-single-product-in-mobile .nasa-single-product-price').after(_sub_price_1st);
            } else {
                $('.nasa-single-product-in-mobile .nasa-bulk-price').replaceWith(_sub_price_1st);
            }
            
            /**
             * For Bulk Price IN Form
             */
            _sub_price_2nd = '<p class="price sub-price sub-price-2nd">' + _sub_price + '</p>';
            
            if ($(_form).find('.ns-form-info .sub-price.sub-price-2nd').length <= 0) {
                $(_form).find('.ns-form-info .ns-price-wrap').append(_sub_price_2nd);
            } else {
                $(_form).find('.ns-form-info .sub-price.sub-price-2nd').replaceWith(_sub_price_2nd);
            }
            
            $('.price.org-price').hide();
        }
        
        /**
         * availability
         */
        if ($(_form).find('.ns-info-variants .single_variation_wrap .woocommerce-variation-availability').length) {
            var _availability = $(_form).find('.ns-info-variants .single_variation_wrap .woocommerce-variation-availability ').html();

            if (_availability && $(_form).find('.ns-form-info .ns-info-wrap .stock').length <= 0) {
                $(_form).find('.ns-form-info .ns-info-wrap').append(_availability);
                // $(_form).find('.ns-form-info .price').append(_availability);
            }
        }
    });

    /**
     * triger img load
     */
    $('body').on('ns_add_nasa_img_loading', function(e,_form) {

        var _img = null;

        if ($('.nasa-single-product-in-mobile .main-images .nasa-item-main-image-wrap[data-key="0"] img').length) {
            _img = $('.nasa-single-product-in-mobile .main-images .item-wrap:not(.slick-cloned) .nasa-item-main-image-wrap[data-key="0"] img').clone();
        }
        
        if (_img) {
            
            if ($(_form).find('.ns-form-info').length <= 0) {
                $(_form).prepend('<div class="ns-form-info nasa-flex align-start margin-bottom-20"></div>');
            }
            
            var _img_src = $(_img).attr('src');

            if ($(_form).find('.ns-form-info .main_min_img').length <= 0) {
                $(_form).find('.ns-form-info').prepend('<div class="main_min_img"></div>');
            }
    
            if ($.inArray(_img_src, _ns_img_checked) !== -1) {
                $(_form).find('.ns-form-info .main_min_img').html('');
                
                if ($('body').hasClass('product-zoom')) {
                    $(_form).find('.ns-form-info .main_min_img').html('<a class="ns-popup-img" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" width="20" height="20"><path d="M3,20V12a1,1,0,0,1,2,0v5.585L17.586,5H12a1,1,0,0,1,0-2h8a1,1,0,0,1,1,1v8a1,1,0,0,1-2,0V6.414L6.414,19H12a1,1,0,0,1,0,2H4A1,1,0,0,1,3,20Z"></path></svg></a>');
                }

                $(_form).find('.ns-form-info .main_min_img').append(_img);

                $(_form).find('.ns-form-info .main_min_img').removeClass('nasa-img-loading');
    
            } else {
                if (!$(_form).find('.ns-form-info .main_min_img').hasClass('nasa-img-loading')) {
                    $(_form).find('.ns-form-info .main_min_img').addClass('nasa-img-loading');
                }
                
                var _interval = setInterval(function() {
                    var _main_src = _img.attr('src');
                    var _img_main = new Image();
                    _img_main.src = _main_src;
                    _img_main.onload = function() {
                        $(_form).find('.ns-form-info .main_min_img').removeClass('nasa-img-loading');
    
                        $(_form).find('.ns-form-info .main_min_img').html('');
                
                        if ($('body').hasClass('product-zoom')) {
                            $(_form).find('.ns-form-info .main_min_img').html('<a class="ns-popup-img" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" width="20" height="20"><path d="M3,20V12a1,1,0,0,1,2,0v5.585L17.586,5H12a1,1,0,0,1,0-2h8a1,1,0,0,1,1,1v8a1,1,0,0,1-2,0V6.414L6.414,19H12a1,1,0,0,1,0,2H4A1,1,0,0,1,3,20Z"></path></svg></a>');
                        }

                        $(_form).find('.ns-form-info .main_min_img').append(_img);

                        _ns_img_checked.push(_img_src);
                        
                        clearInterval(_interval);
                    };
        
                }, 1000);
                
            }
        }
    });
    
    /**
     * Fixed Variation Form
     */
    $('body').on('ns_variation_form_fixed', function() {
        if ($('.nasa-single-product-in-mobile form.cart.variations_form').length) {
            
            $('body').trigger('ns_before_variation_form_fixed');
            
            var _form = $('.nasa-single-product-in-mobile form.cart.variations_form');
            
            if ($(_form).find('.ns-form-close').length <= 0) {
                $(_form).append('<a class="ns-form-close nasa-stclose" href="javascript:void(0);"></a>');
            }
            
            if ($(_form).find('.ns-form-info').length <= 0) {
                $(_form).prepend('<div class="ns-form-info nasa-flex align-start margin-bottom-20"></div>');
            }
            
            if ($(_form).find('.ns-form-info .ns-info-wrap').length <= 0) {
                $(_form).find('.ns-form-info').append('<div class="ns-info-wrap"></div>');
            }
            
            if ($(_form).find('.ns-form-info .ns-info-wrap .ns-price-wrap').length <= 0) {
                $(_form).find('.ns-form-info .ns-info-wrap').append('<div class="ns-price-wrap"></div>');
            }
            
            /**
             * img change
             */
            $('body').trigger('ns_add_nasa_img_loading', [_form]);

            /**
             * price change
             */
            $('body').trigger('ns_add_nasa_price_loading', [_form]);
            
            /**
             * Size Guide
             */
            if ($('.nasa-single-product-in-mobile .nasa-wrap-popup-nodes .nasa-size-guide').length) {
                var _side_guide = $('.nasa-single-product-in-mobile .nasa-wrap-popup-nodes .nasa-size-guide .nasa-node-popup').clone();
                
                if (_side_guide && $(_form).find('.ns-info-variants .nasa-node-popup').length <= 0) {
                    _side_guide.text(_side_guide.text().trim());
                    $(_form).find('table.variations tbody tr:last-child .label').append(_side_guide);
                }
            }
            
            /**
             * Move Btns
             */
            if ($(_form).find('.ns-info-btns .variations_button').length <= 0) {
                if ($(_form).find('.ns-info-btns').length <= 0) {
                    $(_form).append('<div class="ns-info-btns"></div>');
                }
                
                var _btn = $(_form).find('.variations_button');
                
                if ($(_btn).length) {
                    $(_form).find('.ns-info-btns').append(_btn);
                }
                
                /**
                 * Compatible Woocommerce Custom Product Addons
                 */
                if ($(_form).find('.ns-info-btns .wcpa_form_outer').length) {
                    var _wcpa_form_outer = $(_form).find('.ns-info-btns .wcpa_form_outer');
                    
                    if ($(_form).find('.ns-info-variants').length) {
                        $(_form).find('.ns-info-variants').append(_wcpa_form_outer);
                    } else {
                        $(_form).find('.ns-info-btns').before(_wcpa_form_outer);
                    }
                }
            }
            
            /**
             * Checkout Plugins - Stripe for WooCommerce
             */
            if ($('.ns-ppc-wrap').length) {
                var _ppc = $('.ns-ppc-wrap');
                if ($(_form).find('.ns-info-variants').length) {
                    $(_form).find('.ns-info-variants').append(_ppc);
                } else {
                    $(_form).find('.ns-info-btns').before(_ppc);
                }
            }
            
            /**
             * Choose Variations
             */
            $('body').trigger('ns_variants_clone_render', [_form]);
            
            $('body').trigger('ns_after_variation_form_fixed');
        }
    }).trigger('ns_variation_form_fixed');
    
    /**
     * Variants Clone render
     */
    $('body').on('ns_variants_clone_render', function(e, _form) {
        if ($('.ns-variants-first').length <= 0) {
            $(_form).before('<div class="ns-begin-wrap ns-variants-first"></div>');
        }
        
        var _choose = '';
        
        $(_form).find('.variations tr:first-child').each(function() {
            var _this = $(this);
    
            var _label = $(_this).find('th.label').length ? $(_this).find('th.label').clone() : null;
            
            if ($(_label).find('.nasa-node-popup').length) {
                $(_label).find('.nasa-node-popup').remove();
            }

            _choose += _label !== null ? '<div class="ns-variant-lbl">' + $(_label).html() + '</div>' : '';
    
            var _value = $(_this).find('td.value').length ? $(_this).find('td.value').clone() : null;
            
            if (_value !== null) {
                if ($(_value).find('.reset_variations').length) {
                    $(_value).find('.reset_variations').remove();
                }
    
                if ($(_value).find('[id]').length) {
                    $(_value).find('[id]').removeAttr('id');
                }

                if($(_value).find('>select').length){
                    $('.ns-variants-first').addClass('nasa-attribute-select');
                }
    
                _choose += '<div class="ns-variant-val">' + $(_value).html() + '</div>';
            }
        });
        
        if (_choose !== '') {
            $('.ns-variants-first').html('<div class="ns-variants-clone"><a href="javascript:void(0);" class="ns-open-var-form"></a>' + _choose + '</div>');
        }
    });
    
    /**
     * Image Variation Changed
     */
    $('body').on('nasa_changed_gallery_variable_single nasa_after_changed_src_main_img', function() {
        var _form = $('.nasa-single-product-in-mobile form.cart.variations_form');
        
        /**
         * img change
         */
        $('body').trigger('ns_add_nasa_img_loading', [_form]);
        $('body').trigger('load_mini_popup');
        
        /**
         * Count items Slides
         * @type type
         */
        var _wrap = $('.nasa-main-image-default-wrap').parents('.product-images-slider');
        var _total_gallery = $('.main-images .item-wrap:not(.slick-cloned)').length;
        var _count = $(_wrap).find('.ns-img-count .ns-img-now');
        var _total = $(_wrap).find('.ns-img-count .ns-img-total');
        $(_count).text('1');
        $(_total).text(_total_gallery);
    
        if ($(_wrap).find('.nasa-single-arrow').length) {
            $(_wrap).find('.nasa-single-arrow[data-action="prev"]').addClass('nasa-disabled');
            
            if (_total_gallery > 1) {
                $(_wrap).find('.nasa-single-arrow[data-action="next"]').removeClass('nasa-disabled');
            } else {
                $(_wrap).find('.nasa-single-arrow[data-action="next"]').addClass('nasa-disabled');
            }
        }
    
    });
    
    /**
     * Form Close event
     */
    $('body').on('click', '.ns-form-close', function() {
        var _form = $(this).parents('form');
        $(_form).removeClass('ns-show');
    
        if ($(_form).hasClass('ns_add_to_cart_button_show')) {
            setTimeout(function() {
                $(_form).removeClass('ns_add_to_cart_button_show');
            }, 400);
        }
    
        if ($(_form).hasClass('ns_buy_now_button_show')) {
            setTimeout(function() {
                $(_form).removeClass('ns_buy_now_button_show');
            }, 400);
        }   

        if ($(this).hasClass('close-review-form')) {
            var _form = $(this).parents('#review_form_wrapper');
            $(_form).removeClass('ns-show');
        }
        
        $('.black-window').fadeOut(400).removeClass('desk-window');

        $('body').removeClass('ovhd');
    });
    
    /**
     * Added To Cart - Then Close form
     */
    $('body').on('added_to_cart', function() {
        if ($('form.cart .ns-form-close').length) {
            $('form.cart .ns-form-close').trigger('click');
        }
        
        $('.ns_btn-fixed .single_add_to_cart_button').removeClass('loading');
    });
    
    /**
     * Change Count slide items
     */
    $('body').on('nasa_single_gallery_after_change', function(_ev, _main) {
        var _wrap = $(_main).parents('.product-images-slider');
        
        if ($(_wrap).find('.ns-img-count .ns-img-now').length) {
            var _slides = $(_wrap).find('.nasa-single-product-main-image');
            var _count = $(_wrap).find('.ns-img-count .ns-img-now');
            var _imgnow = $(_slides).find('.slick-track .item-wrap.slick-slide.slick-active');
            $(_count).text(parseInt(_imgnow.attr('data-slick-index')) + 1);
        }
    });
    
    /**
     * Zoom mini image - magnificPopup
     */
    $('body').on('load_mini_popup', function() {
        var arr_img =[];
        var first_img = $('body').find('.main-images .item-wrap.first  .product-image').attr('href');
        
        $('body').find('.main-images .item-wrap:not(.first) .product-image').each(function() {
            var _this = $(this);
            arr_img.push($(_this).attr('href'));
        });

        $('.main_min_img').magnificPopup({
            items: {
                src: first_img
              },
            type: 'image',
            closeOnContentClick: true,
            closeMarkup: '<a class="nasa-mfp-close nasa-stclose" href="javascript:void(0);" title="' + $('input[name="nasa-close-string"]').val() + '"></a>',
            gallery: {
                enabled: true,
                navigateByImgClick: false,
                preload: [0,1],
                tCounter: '<div class="mfp-counter">%curr% / %total%</div>'
            },
            image: {
                verticalFit: false,
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
            },
            callbacks: {
                beforeOpen: function() {
                    var galeryPopup = $.magnificPopup.instance;
                    $.each(arr_img, function(index, value) {
                        galeryPopup.items.push({
                            src: value,
                            type: 'image'
                        });
                    });

                    galeryPopup.updateItemHTML();
                },
                open: function() {

                }
            }
        });

    });
    /**
     * Show variation
     */
    $('body').on('show_variation', function() {
        var _form = $('.nasa-single-product-in-mobile form.cart.variations_form');
        
        /**
         * Price change
         */
        $('body').trigger('ns_add_nasa_price_loading', [_form]);
        
        /**
         * Choose Variations
         */
        $('body').trigger('ns_variants_clone_render', [_form]);
    });
    
    /**
     * Reset Variation
     */
    $('body').on('reset_data', function() {
        var _form = $('.nasa-single-product-in-mobile form.cart.variations_form');
        
        /**
         * Reset Stock
         */
        if ($(_form).find('.ns-form-info .ns-info-wrap .stock').length) {
            $(_form).find('.ns-form-info .ns-info-wrap .stock').remove();
        }
        
        /**
         * Reset Price
         */
        $('.price.org-price').show();
        $('.price.sub-price').remove();
        
        /**
         * Choose Variations
         */
        $('body').trigger('ns_variants_clone_render', [_form]);
    });
    
    /**
     * Bulk Discount price changed
     */
    $('body').on('ns_bulk_discount_changed', function() {
        var _form = $('.nasa-single-product-in-mobile form.cart.variations_form');
        
        if ($(_form).find('.nasa-variation-bulk-dsct').length <= 0 && $('.nasa-single-product-in-mobile .nasa-variation-bulk-dsct').length) {
            var _bulk = $('.nasa-single-product-in-mobile .nasa-variation-bulk-dsct');
            $(_form).find('.ns-info-variants .variations').after(_bulk);
        }
        
        // $('body').trigger('ns_variation_form_fixed');
        $('body').trigger('ns_add_nasa_price_loading', [_form]);
    });
    
    /**
     * Even Click Read more Tab content
     */
    $('body').on('click','.ns-btn-read-more', function() {
        var _this = $(this);
        //var _row = $(_this).parents('.row:not(.nasa-product-details-page)');
        var _row = $(_this).parents('.ns-tab-item');
        // var _read =$(_row).find('.ns-read-more');
        if (!$(_row).hasClass('ns-row-active')) {
            $(_row).addClass('ns-row-active');
            $(_this).html($(_this).attr('data-show-less'));
        } else {
            $(_row).removeClass('ns-row-active');
            $('body').trigger('nasa_animate_scroll_to_top', [$, _row, 500]);
            $(_this).html($(_this).attr('data-show-more'));
        }
    });
    
    /**
     * Add Read more for WooCommerce Tab content
     */
    $('body').on('ns_add_read_more', function() {
        if ($('.woocommerce-tabs .ns-tab-item').length && $('#tmp-read-more-tab').length) {
            var _ns_readmore = $('#tmp-read-more-tab').html();
            
            $('.woocommerce-tabs .ns-tab-item').each(function() {
                var _this = $(this);
                
                if ($(_this).find('.ns-read-more').length <= 0) {
                    $(_this).append(_ns_readmore);
                }
        
                if ($(_this).find('.nasa-content-accessories_content, .nasa-content-additional_information, .cr-reviews-ajax-reviews').length) {
                    $(_this).removeClass('ns-tab-item');
                    $(_this).addClass('ns-tab-no-read-more');
                }
        
                if ($(_this).find('.nasa-content-reviews').length) {
                    $(_this).addClass('ns-tab-reviews');
                }
            });
        }
    }).trigger('ns_add_read_more');
    
    /**
     * After Loaded Ajax complete
     */
    $('body').on('nasa_after_loaded_ajax_complete', function() {
        if ($('body').find('.ns_btn-fixed').length) {
            $('body').find('.ns_btn-fixed').remove();
        }
        
        $('body').trigger('ns_btns_fixed');
        $('body').trigger('ns_hide_simple_cart_form');
        $('body').trigger('ns_variation_form_fixed');
        $('body').trigger('ns_add_read_more');
    });

    $('body').on('touchstart', '.mfp-container',function(e) {
        touchstart = e.touches[0].clientX;
    });

    $('body').on('touchend', '.mfp-container',function(e) {
        touchend  = e.changedTouches[0].clientX;
        
        if (touchstart != touchend && touchstart != 0 && Math.abs(touchstart - touchend) > distance) {
            if (touchstart > touchend) {
                $('.mfp-arrow.mfp-arrow-right').trigger('click');
            } else {
                $('.mfp-arrow.mfp-arrow-left').trigger('click');
            }
        }
        
        touchend = 0;
        touchstart = 0;
    });
    
    //swipe down to close variations_form, size-guide, delivery-return, ask-a-quetion.
    $('body').on('touchstart', '.variations_form, #nasa-content-size-guide, #nasa-content-delivery-return, #nasa-content-ask-a-quetion, #review_form_wrapper, #nasa-content-request-a-callback', function(e) {
        var scrollTop = $(this).find('.ns-inct').scrollTop();

        if ($(e.target).parents('.nasa-popup-content-contact').length) {
            scrollTop = $(this).find('.nasa-wrap').scrollTop();
            if ($(e.target).attr('name') == 'your-message') {
                var st = $(e.target).scrollTop();
                if(st > 0) {
                    scrollTop = 100;
                }
            }
        }

        if ($(e.target).parents('.variations_form').length) {
            scrollTop = $(this).find('.ns-info-variants').scrollTop();
        }

        if ($(e.target).parents('#review_form_wrapper').length) {
            scrollTop = $(this).scrollTop();

            if ($(e.target).attr('id') == 'comment') {
                var st = $(e.target).scrollTop();
                if(st > 0) {
                    scrollTop = 100;
                }
            }
        }

        console.log($(e.target));

        if ($(e.target).hasClass('nasa-product') || $(e.target).attr('id') == 'nasa-content-size-guide'|| $(e.target).attr('id') == 'nasa-content-delivery-return') {
            scrollTop = 0;
        }
        if (scrollTop <= 0) {
            touchstart = e.touches[0].clientY;
        }
    });
    
    $('body').on('touchend', '.variations_form, #nasa-content-size-guide, #nasa-content-delivery-return, #nasa-content-ask-a-quetion, #review_form_wrapper, #nasa-content-request-a-callback', function(e) {
        touchend = e.changedTouches[0].clientY;
        
        if (touchstart != touchend && touchstart != 0 && Math.abs(touchstart - touchend) > distance) {
            if (touchstart < touchend) {
                $(this).find('a.nasa-stclose').trigger('click');
            }
        }
        
        touchend = 0;
        touchstart = 0;
    });


    $('body').on('click', '.svg_image_upload', function() {
        $('#nasa-comment-media').trigger('click');
    });

    if ($('.related-product .nasa-title-relate').length) {
        $('.related-product .nasa-title-relate').removeClass('text-center');
    }
});
/* End Document Ready */


    