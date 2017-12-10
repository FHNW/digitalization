
var NEBIS_URL = 'http://recherche.nebis.ch/primo_library/libweb/action/search.do?mode=Basic&vid=NEBIS&tab=default_tab';

define(['jquery'], function($) {
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
            // $('#id_load_order_info').click(function() {
            //     var $url = $('#id_library_url').val();
            //     module.load_order_data($url);
            // });
        },
        load_order_data: function(url) {
            $.get({
                url: url
            }).then(function(html) {
                var $html = $(html);
                var innerForm = $html.find('form[name="detailsForm"]');
               var get_attribute = function(name) {
                   return innerForm
                       .find('strong:contains(' + name + ')')
                       .next()
                       .text();
               };
               var order = {
                   'title': get_attribute('Titel'),
                   'alttitle': get_attribute('Titelvariante'),
                   'publisher': get_attribute('Ort, Verlag'),
                   'pubdate': get_attribute('Erscheinungsdatum'),
                   'language': get_attribute('Sprache'),
                   'type': get_attribute('Typ'),
                   'scope': get_attribute('Umfang'),
                   'stock': get_attribute('Bestand'),
               };
               debugger;
            });
        }
    };
    return module;
});
