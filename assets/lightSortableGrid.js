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
        var data = {};
        data[url.substr(5, url.length - 9) + 'order'] = JSON.stringify(sortableTable.sortable('toArray', {attribute: 'data-id'}))

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

    $('.light-sortable-grid select').change(function () {
        $('.light-sortable-grid-btn-filter').click();
    });

});