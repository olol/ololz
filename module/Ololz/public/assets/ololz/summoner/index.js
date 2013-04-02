$(function() {
    $('#search button[name=search]').click(loadInvocations);

    $('#search input[name=limit]').blur(function() {
        if (! $(this).val()) {
            $(this).val(20);
        }
    } );

    function getSearchCriteria() {
        var $search = $('#search');
        var criteria = {};

        $.each(['date_min', 'date_max', 'champion', 'position', 'map', 'match_type', 'limit'], function(idx, fieldName) {
            if ((value = $search.find('input[name=' + fieldName + ']').val()) != '') {
                criteria[fieldName] = value;
            }
        } );

        return criteria;
    }

    function loadInvocations() {
        var $loader = $('#matches > div.loader');
        var $list = $('#matches > ul');
        $loader.slideDown();
        $list.slideUp();

        var criteria = getSearchCriteria();

        $list.load('/summoner/' + ololz.summoner.id + '/invocations', criteria, function() {
            $list.slideDown();
            $('#matches > div.loader').slideUp('loader');
        } );
    }

    $('a[data-toggle="tab"]').on('shown', function (e) {
        switch ($(e.target).attr('href')) {
            case '#matches':
                if ($('#matches > ul > li').length == 0) {
                    loadInvocations();
                }
            break;
        }
    } );
} );