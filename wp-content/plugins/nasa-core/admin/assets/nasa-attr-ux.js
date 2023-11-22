jQuery(document).ready(function ($) {
    'use strict';
    if (typeof wp === 'undefined') {
        var wp = window.wp;
    }

    // $('#term-nasa_color').wpColorPicker();
    
    $('input.ns-color-picker').wpColorPicker({
        change: function () {
            setTimeout(function() {
                var _val = '';
        
                $('input.ns-color-picker').each(function () {
                    var _cval = $(this).val();
                    if (_cval !== '') {
                        _val += _val !== '' ? ',' + _cval : _cval;
                    }
                });

                $('#ns-values-colors').val(_val).trigger('change');
            }, 10);
        },
        clear: function () {
            setTimeout(function() {
                var _val = '';
        
                $('input.ns-color-picker').each(function () {
                    var _cval = $(this).val();
                    if (_cval !== '') {
                        _val += _val !== '' ? ',' + _cval : _cval;
                    }
                });

                $('#ns-values-colors').val(_val).trigger('change');
            }, 10);
        }
    });

    // Toggle add new attribute term modal
    var $modal = $('#nasa-attr-ux-modal-container'),
        $spinner = $modal.find('.spinner'),
        $msg = $modal.find('.message'),
        $metabox = null;

    $('body').on('click', '.nasa-attr-ux_add_new_attribute', function (e) {
        e.preventDefault();
        var $button = $(this),
            taxInputTemplate = wp.template('nasa-attr-ux-input-tax'),
            data = {
                type: $button.data('type'),
                tax: $button.closest('.woocommerce_attribute').data('taxonomy')
            };

        // Insert input
        $modal.find('.nasa-attr-ux-term-val').html($('#tmpl-nasa-attr-ux-input-' + data.type).html());
        $modal.find('.nasa-attr-ux-term-tax').html(taxInputTemplate(data));

        if ('nasa_color' === data.type) {
            $modal.find('input.nasa-attr-ux-input-color').wpColorPicker();
        }

        $metabox = $button.closest('.woocommerce_attribute.wc-metabox');
        $modal.show();
    }).on('click', '.nasa-attr-ux-modal-close, .nasa-attr-ux-modal-backdrop', function (e) {
        e.preventDefault();
        closeModal();
    });

    // Send ajax request to add new attribute term
    $('body').on('click', '.nasa-attr-ux-new-attribute-submit', function (e) {
        e.preventDefault();

        var $button = $(this),
            type = $button.data('type'),
            error = false,
            data = {};

        // Validate
        $modal.find('.nasa-attr-ux-input').each(function () {
            var $this = $(this);

            if ($this.attr('name') !== 'slug' && !$this.val()) {
                $this.addClass('error');
                error = true;
            } else {
                $this.removeClass('error');
            }

            data[$this.attr('name')] = $this.val();
        });

        if (error) {
            return;
        }

        // Send ajax request
        $spinner.addClass('is-active');
        $msg.hide();
        wp.ajax.send('nasa_attr_ux_add_new_attribute', {
            data: data,
            error: function (res) {
                $spinner.removeClass('is-active');
                $msg.addClass('error').text(res).show();
            },
            success: function (res) {
                $spinner.removeClass('is-active');
                $msg.addClass('success').text(res.msg).show();

                $metabox.find('select.attribute_values').append('<option value="' + res.id + '" selected="selected">' + res.name + '</option>');
                $metabox.find('select.attribute_values').trigger('change');

                closeModal();
            }
        });
    });

    /**
     * Close modal
     */
    function closeModal() {
        $modal.find('.nasa-attr-ux-term-name input, .nasa-attr-ux-term-slug input').val('');
        $spinner.removeClass('is-active');
        $msg.removeClass('error success').hide();
        $modal.hide();
    }

    $('#woocommerce-product-data').on('woocommerce_variations_loaded', function () {
        nasaGalleryVariation($);
    }).on('woocommerce_variations_added', function () {
        nasaGalleryVariation($);
    });

    // Remove Image
    $('body').on('click', '.nasa-variation-gallery-images .actions a.delete', function () {
        var _this = $(this);
        var _woo_variation = $(_this).parents('.woocommerce_variation');
        var _wrap = $(_this).parents('.nasa-variation-gallery-images');
        var _variation_id = $(_wrap).attr('data-variation_id');
        $(_this).parents('li.image').remove();

        var attachment_ids = '';

        $(_wrap).find('li.image').each(function () {
            var attachment_id = $(this).attr('data-attachment_id');
            attachment_ids = attachment_ids + attachment_id + ',';
        });

        $('#nasa_variation_gallery_images-' + _variation_id).val(attachment_ids);

        $(_woo_variation).addClass('variation-needs-update');
        $('button.cancel-variation-changes, button.save-variation-changes').removeAttr('disabled');
        $('#variable_product_options').trigger('woocommerce_variations_input_changed');

        return false;
    });
});

function nasaGalleryVariation($) {
    if ($('.woocommerce_variation').length) {
        $('.woocommerce_variation').each(function () {
            var _this = $(this);
            var _gallery = $(_this).find('.nasa-variation-gallery-wrapper').wrap('<div>').parent().html();
            $(_this).find('.nasa-variation-gallery-wrapper').remove();
            $(_this).find('.upload_image').after(_gallery);
        });
    }

    $('.nasa-variation-gallery-images').each(function () {
        var _this = $(this);
        var _variation_id = $(_this).attr('data-variation_id');
        var _woo_variation = $(_this).parents('.woocommerce_variation');
        _this.sortable({
            items: 'li.image',
            cursor: 'move',
            scrollSensitivity: 40,
            forcePlaceholderSize: true,
            forceHelperSize: false,
            helper: 'clone',
            opacity: 0.65,
            placeholder: 'wc-metabox-sortable-placeholder',
            start: function (event, ui) {
                ui.item.css('background-color', '#f6f6f6');
            },
            stop: function (event, ui) {
                ui.item.removeAttr('style');
            },
            update: function () {
                var attachment_ids = '';

                $(_this).find('li.image').css('cursor', 'default').each(function () {
                    var attachment_id = $(this).attr('data-attachment_id');
                    attachment_ids = attachment_ids + attachment_id + ',';
                });

                $('#nasa_variation_gallery_images-' + _variation_id).val(attachment_ids);

                $(_woo_variation).addClass('variation-needs-update');
                $('button.cancel-variation-changes, button.save-variation-changes').removeAttr('disabled');
                $('#variable_product_options').trigger('woocommerce_variations_input_changed');
            }
        });
    });
}
