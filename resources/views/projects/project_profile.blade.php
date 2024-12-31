@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .swal2-toast .swal2-title.toast-title {
        color: rgb(236, 228, 228) !important;
        /* Ensures the text is black */
    }
</style>
<div class="sidebodydiv">
    <div class="sidebodyback my-3" onclick="goBack()">
        <div class="backhead">
            <h5><i class="fas fa-arrow-left"></i></h5>
            <h6>{{ $project->pro_code }} {{ $project->pro_title }}</h6>
        </div>
    </div>

    {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
        @php
        $tabs = [
        'overview' => 'Overview',
        'boq' => 'Sale / Zero Cost',
        'pro_sale' => 'Progress - Sales / Zero Cost',
        'hire' => 'Hire',
        'petty' => 'Petty Cash',
        'addpetty' => 'Add Petty Cash',
        'boq_pur' => 'BOQ Purchase',
        'boq_lab' => 'BOQ Labour',
        'headexpense' => 'Overhead Expense',
        'ateam' => 'Assign Team',
        'scbill' => 'SC Bill',
        'rateapproval' => 'Rate Approval',
        'report' => 'Report'
        ];
        @endphp

        @foreach ($tabs as $key => $label)
        <li class="nav-item">
            <button class="nav-link" data-tab="{{ $key }}">{{ $label }}</button>
        </li>
        @endforeach
    </ul> --}}
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        @php
            // Default tabs for non-admin users
            $tabs = [
                'petty' => 'Petty Cash',
                'addpetty' => 'Add Petty Cash',
                'scbill' => 'SC Bill',
            ];

            // If the user is an admin, show all tabs
            if (auth()->user()->emp_desg === 'Admin') {
                $tabs = [
                    'overview' => 'Overview',
                    'boq' => 'Sale / Zero Cost',
                    'pro_sale' => 'Progress - Sales / Zero Cost',
                    'hire' => 'Hire',
                    'petty' => 'Petty Cash',
                    'addpetty' => 'Add Petty Cash',
                    'boq_pur' => 'BOQ Purchase',
                    'boq_lab' => 'BOQ Labour',
                    'headexpense' => 'Overhead Expense',
                    'ateam' => 'Assign Team',
                    'scbill' => 'SC Bill',
                    'rateapproval' => 'Rate Approval',
                    'report' => 'Report'
                ];
            }
        @endphp

        @foreach ($tabs as $key => $label)
            <li class="nav-item">
                <button class="nav-link" data-tab="{{ $key }}">{{ $label }}</button>
            </li>
        @endforeach
    </ul>

    <div id="tab-content">
        <!-- Tab content will be dynamically loaded here -->
    </div>
</div>


<!-- <script>
    $(document).ready(function () {
        function initTable(tableId, dropdownId, filterInputId) {
            var table = $(tableId).DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "order": [0, "asc"],
                "bDestroy": true,
                "info": false,
                "responsive": true,
                "pageLength": 30,
                "dom": '<"top"f>rt<"bottom"ilp><"clear">',
            });

            $(tableId + ' thead th').each(function (index) {
                var headerText = $(this).text();
                if (headerText != "" && headerText.toLowerCase() != "action") {
                    $(dropdownId).append('<option value="' + index + '">' + headerText + '</option>');
                }
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
        initTable('#table13', '#headerDropdown13', '#filterInput13');
        initTable('#table14', '#headerDropdown14', '#filterInput14');
        initTable('#table15', '#headerDropdown15', '#filterInput15');
        initTable('#table16', '#headerDropdown16', '#filterInput16');
        initTable('#table17', '#headerDropdown16', '#filterInput17');
    });
</script> -->

<script>
    $(document).ready(function () {
        const tabs = $('.nav-link');
        const activeTabKey = 'activeTab';


        function loadTabContent(tabName) {
            $.ajax({
                url: "{{ route('load.tab') }}",
                method: 'POST',
                data: {
                    tab: tabName,
                    project_id: "{{ $project->id }}",
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    $('#tab-content').html(response.html);
                },
                error: function () {
                    $('#tab-content').html('<div class="alert alert-danger">Error loading tab content.</div>');
                }
            });
        }

        tabs.on('click', function () {
            const tabName = $(this).data('tab');
            loadTabContent(tabName);
            localStorage.setItem(activeTabKey, tabName);
            tabs.removeClass('active');
            $(this).addClass('active');
        });

        const activeTab = localStorage.getItem(activeTabKey) || 'overview';
        $(`.nav-link[data-tab="${activeTab}"]`).trigger('click');
    });
</script>
@endsection