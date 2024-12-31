// DataTable Script
$(document).ready(function () {
    var table = $('#table1').DataTable({
        "paging": true,
        "searching": true,
        "ordering": false,
        "bDestroy": true,
        "info": false,
        "responsive": true,
        "pageLength": 20,
        "dom": '<"top"f>rt<"bottom"lp><"clear">'
    });
});

// Tabs Tables
$(document).ready(function () {
    function initTable(tableId, dropdownId, filterInputId) {
        var table = $(tableId).DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "bDestroy": true,
            "info": false,
            "responsive": true,
            "pageLength": 30,
            "dom": '<"top"f>rt<"bottom"ilp><"clear">',
        });

        $(tableId + ' thead th').each(function (index) {
            var headerText = $(this).text();
            $(dropdownId).append('<option value="' + index + '">' + headerText + '</option>');
        });

        $(filterInputId).on('keyup', function () {
            var selectedColumn = $(dropdownId).val();
            if (selectedColumn !== 'All') {
                table.column(selectedColumn).search($(this).val()).draw();
            } else {
                table.search($(this).val()).draw();
            }
        });

        $(dropdownId).on('change', function () {
            $(filterInputId).val('');
            table.search('').columns().search('').draw();
        });

        $(filterInputId).on('keyup', function () {
            table.search($(this).val()).draw();
        });

    }

    // Initialize each table
    initTable('#table2', '#headerDropdown2', '#filterInput2');
    initTable('#table3', '#headerDropdown3', '#filterInput3');
    initTable('#table4', '#headerDropdown4', '#filterInput4');
    initTable('#table5', '#headerDropdown5', '#filterInput5');
    initTable('#table6', '#headerDropdown6', '#filterInput6');
    initTable('#table7', '#headerDropdown7', '#filterInput7');
    initTable('#table8', '#headerDropdown8', '#filterInput8');
    initTable('#table9', '#headerDropdown9', '#filterInput9');
    initTable('#table10', '#headerDropdown10', '#filterInput10');
    initTable('#table11', '#headerDropdown11', '#filterInput11');
    initTable('#table12', '#headerDropdown12', '#filterInput12');
});