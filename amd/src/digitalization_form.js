define(['jquery'], function($) {
    var NEBIS_URL = 'http://recherche.nebis.ch/primo_library/libweb/action/search.do?mode=Basic&vid=NEBIS&tab=default_tab';
    var module = {
        init: function() {
            // add direct link to the library
            $('#id_library_url').after(
                $('<a />')
                    .attr('id', 'library_search_link')
                    .attr('href', 'http://recherche.nebis.ch/primo_library/libweb/action/search.do?mode=Basic')
                    .attr('target', '_blank')
            );
            $('#id_import_from_opac').click(function(event) {
                event.preventDefault();
                window.open(NEBIS_URL);
            });
        }
    };
    return module;
});
