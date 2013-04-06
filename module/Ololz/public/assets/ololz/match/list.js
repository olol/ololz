$(function() {
    $('#search').find('[name="summoner[]"], [name="realm[]"], [name="champion[]"], [name="map[]"], [name="match_type[]"]').chosen();

    $('#search button[name=search]').click(loadMatches);

    var searchFields = ['date_min', 'date_max', 'champion[]', 'summoner[]', 'realm[]', 'map[]', 'match_type[]', 'limit'];

    $.each(searchFields, function(idx, field) {
        $('#search [name="' + field + '"]').keyup(function(e) {
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
            var value = $search.find('[name="' + fieldName + '"]').val();
            if (value != '' && value != null) {
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