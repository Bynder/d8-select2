(function ($, Drupal) {
    Drupal.behaviors.select2 = {
        attach: function (context, drupalSettings) {
            if (typeof drupalSettings.select2 != 'undefined') {
                $.each(drupalSettings.select2, function (id, options) {
                    $(options.selector).css({'width': '150px'}).select2({
                        multiple: options.multiple,
                        placeholder: options.placeholder_text
                    });
                });
            }
        }
    };
}(jQuery, Drupal));