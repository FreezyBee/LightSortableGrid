$(function () {

    // sortableTable
    var sortableTable = false;

    $('.btn-sort-show').click(function (e) {
        e.preventDefault();
        sortableTable = $('table.sortable tbody').sortable().disableSelection();
        $('.sortable-hidden').hide();
        $('.sortable-displayed').show();
        return false;
    });

    $('.btn-sort-save').click(function (e) {
        e.preventDefault();

        if (sortableTable === false) {
            alert('error');
            return false;
        }

        var url = $('table.sortable').data('link');
        var m = url.match(/[?&]do=([^&]+)/);
        if (m && m.length) {
            var valueName = m[1].substring(0, m[1].length - 5);
        } else {
            alert('error');
            return;
        }

        var data = {};

        data[valueName + '-order'] = JSON.stringify(sortableTable.sortable('toArray', {attribute: 'data-id'}))

        $.nette.ajax({
            type: 'GET',
            url: url,
            data: data
        });

        sortableTable.sortable('destroy');
        sortableTable = false;
        $('.sortable-hidden').show();
        $('.sortable-displayed').hide();
        return false;
    });

    $(document).on('change', '.light-sortable-grid select', function () {
        $('.light-sortable-grid-btn-filter').click();
    });

});