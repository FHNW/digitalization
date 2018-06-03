define(['core/str', 'jquery', 'theme_bootstrapbase/bootstrap'], function(str, $) {
    // var tooltip = $.fn.tooltip.noConflict();
    var NEBIS_URL = 'http://recherche.nebis.ch/';
    var module = {
        init: function() {
            // add direct link to the library
            $('#id_library_url').before(
                $('<a />')
                    .attr('id', 'library_search_link')
                    .attr('href', NEBIS_URL)
                    .attr('target', '_blank')
            );

            $('#id_back_to_automatic').click(function() {
                // prevent validation erros
                $('#id_author, #id_atitle, #id_title, #id_pub_date, #id_pages').each(function() {
                    if ($(this).val() === '') {
                        $(this).val(' ');
                    }
                });
            });

            var warningPresent = str.get_string('warning_submit_order', 'digitalization');
            $.when(warningPresent).done(function(warningString) {
                    $('#id_submitbutton2')
                        .attr('data-toggle', 'tooltip')
                        .attr('data-placement', 'top')
                        .attr('title', warningString)
                        .tooltip();
            });

            var helpPresent = str.get_string('to_library_catalogue', 'digitalization');
            $.when(helpPresent).done(function(helpString) {
                    $('#library_search_link')
                        .attr('data-toggle', 'tooltip')
                        .attr('data-placement', 'right')
                        .attr('title', helpString)
                        .tooltip();
            });

        }
    };
    return module;
});
