define(['jquery'], function($) {
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
        }
    };
    return module;
});
