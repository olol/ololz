$(function() {
    $('#search').find('[name="champion[]"], [name="position[]"], [name="map[]"], [name="match_type[]"]').chosen();

    $('.chzn-choices .search-field input').focusin(function() {
        $(this).parents('.chzn-choices').first().addClass('chzn-choices-focus');
    } ).focusout(function() {
        $(this).parents('.chzn-choices').first().removeClass('chzn-choices-focus');
    } );

    $('.input-daterange').datepicker({autoclose: true, weekStart: 1});

    $('#search button[name=search]').click(loadInvocations);

    var searchFields = ['date_min', 'date_max', 'champion[]', 'position[]', 'map[]', 'match_type[]', 'limit'];

    $.each(searchFields, function(idx, field) {
        $('#search [name="' + field + '"]').keyup(function(e) {
            if(e.which == 13) {
                $('#search button[name=search]').click();
            }
        } );
    } );

    $('.search-field input').keyup(function(e) {
        if(e.which == 13) {
            $('#search button[name=search]').click();
        }
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