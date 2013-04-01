$(function() {
    function loadInvocations() {
        $('#matches > ul').load('/summoner/' + ololz.summoner.id + '/invocations', null, function() {
            $('#matches').removeClass('loader');
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