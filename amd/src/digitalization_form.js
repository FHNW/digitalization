define(['core/str', 'jquery'], function(str, $) {
    var NEBIS_URL = 'http://recherche.nebis.ch/';
    var module = {
        init: function() {
            // add direct link to the library
            $('#id_library_url').after(
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
                    .attr('title', warningString)
                    .tooltip({
                        placement: 'top'
                    });
            });

            var helpPresent = str.get_string('import_from_opac_group_help', 'digitalization');
            $.when(helpPresent).done(function(helpString) {
                $('#id_load_order_info')
                    .attr('data-toggle', 'tooltip')
                    .attr('title', helpString)
                    .tooltip({
                        placement: 'right'
                    });
            });

        }
    };
    return module;
});
