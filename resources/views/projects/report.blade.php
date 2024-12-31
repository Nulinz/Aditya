@include('layouts.header')

<!-- Table -->
<div class="container-fluid mt-3 listtable">
    <div class="filter-container row mb-3">
        <div class="custom-search-container col-sm-12 col-md-8">
            <select id="headerDropdown16" class="form-select filter-option">
                <option value="All" selected>All</option>
            </select>
            <input type="text" id="filterInput16" class="form-control" placeholder=" Search">
        </div>
        <div class="select1 col-sm-12 col-md-4 mx-auto">
            <div class="d-flex gap-3">
                <a href="" id="export"><i class="fa-solid fa-file-export"></i></a>
                <a href="" id="import"><i class="fa-solid fa-file-import"></i></a>
            </div>
        </div>
    </div>
    @php
        $boqData = DB::table('boqs')
            ->select('code', DB::raw('SUM(boq_amount) as sales'), DB::raw('SUM(zero_amount) as zero'))
            ->where('pro_id', $projectId)
            ->where('status', 1)
            ->groupBy('code')
            ->get();

        $overheadAmount = DB::table('head_expenses')
            ->where('pro_id', $projectId)
            ->where('status', 1)
            ->sum('amt');

        $totalExpenditure = DB::table('boqs')
            ->where('pro_id', $projectId)
            ->where('status', 1)
            ->sum('boq_amount');

        $overheadPercentage = $totalExpenditure > 0
            ? round(($overheadAmount / $totalExpenditure) * 100)
            : 0;

        function calculateActual($projectId, $code)
        {
            $labTotal = DB::table('labs')
                ->where('pro_id', $projectId)
                ->where('code', $code)
                ->where('status', 1)
                ->sum('amount');

            $purchaseTotal = DB::table('purchases')
                ->where('pro_id', $projectId)
                ->where('code', $code)
                ->where('status', 1)
                ->sum('amount');

            $hireTotal = DB::table('hires')
                ->where('pro_id', $projectId)
                ->where('code', $code)
                ->where('status', 1)
                ->sum('amount');

            return $labTotal + $purchaseTotal + $hireTotal;
        }
    @endphp
    <div class="table-wrapper">
        <table class="table table-hover table-striped" id="table16">
            <thead>
                <tr>
                    <th>#</th>
                    <th>BOQ</th>
                    <th>Sales</th>
                    <th>Zero</th>
                    <th>Actual</th>
                    <th>Actual with Overhead</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                    $totals = ['sales' => 0, 'zero' => 0, 'actual' => 0, 'actual_with_overhead' => 0];
                @endphp
                @foreach ($boqData as $data)
                                @php
                                    $actual = calculateActual($projectId, $data->code);
                                    $actualWithOverhead = round($actual * (1 + ($overheadPercentage / 100)));
                                @endphp
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $data->code }}</td>
                                    <td>{{ $data->sales }}</td>
                                    <td>{{ $data->zero }}</td>
                                    <td>{{ $actual }}</td>
                                    <td>{{ $actualWithOverhead }}</td>
                                </tr>
                                {{-- @php
                                $totals['sales'] += $data->sales;
                                $totals['zero'] += $data->zero;
                                $totals['actual'] += $actual;
                                $totals['actual_with_overhead'] += $actualWithOverhead;
                                @endphp --}}
                @endforeach
                {{-- <tr>
                    <td colspan="2"><strong>Total</strong></td>
                    <td>{{ $totals['sales'] }}</td>
                    <td>{{ $totals['zero'] }}</td>
                    <td>{{ $totals['actual'] }}</td>
                    <td>{{ $totals['actual_with_overhead'] }}</td>
                </tr> --}}
            </tbody>
        </table>
    </div>
</div>

<script>
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
        initTable('#table16', '#headerDropdown16', '#filterInput16');
    });
</script>
@include('layouts.footer')
