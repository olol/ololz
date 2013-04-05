$(function() {
    $('#search button[name=search]').click(loadMatches);

    var searchFields = ['date_min', 'date_max', 'champion', 'summoner', 'realm', 'position', 'map', 'match_type', 'limit'];

    $.each(searchFields, function(idx, field) {
        $('#search input[name=' + field + ']').keyup(function(e) {
            if(e.which == 13) {
                $('#search button[name=search]').click();
            }
        } );
    } );

    $('#search input[name=limit]').blur(function() {
        if (! $(this).val()) {
            $(this).val(20);
        }
    } );

    function getSearchCriteria() {
        var $search = $('#search');
        var criteria = {};

        $.each(searchFields, function(idx, fieldName) {
            if ((value = $search.find('input[name=' + fieldName + ']').val()) != '') {
                criteria[fieldName] = value;
            }
        } );

        return criteria;
    }

    function loadMatches() {
        var $loader = $('#matches > div.loader');
        var $list = $('#matches > ul');
        $loader.slideDown();
        $list.slideUp();

        var criteria = getSearchCriteria();

        $list.load('/matches/matches', criteria, function() {
            $list.slideDown();
            $('#matches > div.loader').slideUp('loader');
        } );
    }

    loadMatches();
} );