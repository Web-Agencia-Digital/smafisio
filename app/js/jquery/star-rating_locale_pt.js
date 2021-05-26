/*!
 * Star Rating <LANG> Translations
 *
 * This file must be loaded after 'fileinput.js'. Patterns in braces '{}', or
 * any HTML markup tags in the messages must not be converted or translated.
 *
 * @see http://github.com/kartik-v/bootstrap-star-rating
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 *
 * NOTE: this file must be saved in UTF-8 encoding.
 */
(function () {
    "use strict";
    $.fn.ratingLocales['pt'] = {
        defaultCaption: '{rating} Estrelas',
        starCaptions: {
            1: 'Muito Ruim',
            2: 'Ruim',
            3: 'Razoável',
            4: 'Bom',
            5: 'Excelente'
        },
        clearButtonTitle: 'Limpar',
        clearCaption: 'Não avaliado',
        showClear: false,
        showCaption: false        
        
    };
})(window.jQuery);