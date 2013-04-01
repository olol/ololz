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

        $.each(['date_min', 'date_max', 'champion', 'limit'], function(idx, fieldName) {
            if ((value = $search.find('input[name=' + fieldName + ']').val()) != '') {
                criteria[fieldName] = value;
            }
        } );

        return criteria;
    }

    function loadInvocations() {
        var $loader = $('#matches > div.loader');
        var $list = $('#matches > ul');
        $loader.show();
        $list.hide();

        var criteria = getSearchCriteria();

        $list.load('/summoner/' + ololz.summoner.id + '/invocations', criteria, function() {
            $list.show();
            $('#matches > div.loader').hide('loader');
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