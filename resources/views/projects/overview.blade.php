<div class="container-fluid mt-3 listtable">
    <div class="sidebodyhead mb-3">
        <h4 class="m-0">Overview</h4>
    </div>
@php
    $proSales = DB::table('project_sales')
            ->where('pro_id', $projectId)
            ->where('status', 1)
            ->get();

        $proSale1 = $proSales->sum(fn($sale) => (float) str_replace(',', '', $sale->pro_sale_amt));
        $proZero1 = $proSales->sum(fn($sale) => (float) str_replace(',', '', $sale->pro_zero_amt));

        $labAmt1 = DB::table('labs')
            ->where('pro_id', $projectId)
            ->where('status', 1)
            ->sum('amount');

        $purAmt1 = DB::table('purchases')
            ->where('pro_id', $projectId)
            ->where('status', 1)
            ->sum('amount');

        $hireAmt1 = DB::table('hires')
            ->where('pro_id', $projectId)
            ->where('status', 1)
            ->sum('amount');

        $assetAmt = DB::table('values')
            ->where('pro_id', $projectId)
            ->where('status', 1)
            ->sum('value');


        $hdexpAmt1 = DB::table('head_expenses')
            ->where('pro_id', $projectId)
            ->where('status', 1)
            ->sum('amt');

        $totalExp = $labAmt1 + $hireAmt1 + $purAmt1 + $hdexpAmt1;


        $expend = $assetAmt - $totalExp;

        $actRec = $expend - $proSale1;
        $actZero = $expend - $proZero1;

@endphp

    <div class="table-wrapper">
        <table class="table table-hover table-striped" id="table1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Expenditure</td>
                    <td>{{ number_format(round($totalExp ?? 0, 2)) }}</td>
                </tr>
                <tr>
                    <td class="d-flex gap-5">
                        <span>Value of Inventory and Asset</span>
                        <span data-bs-toggle="modal" data-bs-target="#modal1">
                            <i class="fas fa-pen-to-square"></i>
                        </span>
                    </td>
                    <td>{{ number_format(round($assetAmt?? 0 , 2)) }}</td>
                </tr>
                <tr>
                    <td>Expenditure Deducting Inventory and Asset</td>
                    <td>{{ number_format(round($expend ?? 0, 2)) }}</td>
                </tr>
                <tr>
                    <td>Zero Cost for Work Completed</td>
                    <td>{{ number_format(round($proZero1 ?? 0, 2)) }}</td>
                </tr>
                <tr>
                    <td>Receivable for Work Completed</td>
                    <td>{{ number_format(round($proSale1 ?? 0, 2)) }}</td>
                </tr>
                <tr>
                    <td>Actual vs Receivable</td>
                    <td>{{ number_format(round($actRec ?? 0, 2)) }}</td>
                </tr>
                <tr>
                    <td>Actual vs Zero Cost</td>
                    <td>{{ number_format(round($actZero ?? 0, 2)) }}</td>
                </tr>
                <tr>
                    <th>Expenditure Breakup</th>
                    <td></td>
                </tr>
                <tr>
                    <td>Labour</td>
                    <td>{{ number_format(round($labAmt1 ?? 0, 2)) }}</td>
                </tr>
                <tr>
                    <td>Material</td>
                    <td>{{ number_format(round($purAmt1 ?? 0, 2)) }}</td>
                </tr>
                <tr>
                    <td>Hiring</td>
                    <td>{{ number_format(round($hireAmt1 ?? 0, 2)) }}</td>
                </tr>
                <tr>
                    <td>Overhead Expense</td>
                    <td>{{ number_format(round($hdexpAmt1 ?? 0, 2)) }}</td>
                </tr>
                <tr>
                    <td>Total Expenditure</td>
                    <td>{{ number_format(round($totalExp ?? 0, 2)) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">Value of Inventory and Asset</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('overview.updateAssetValue')}}" method="POST">
                @csrf
                <input type="hidden" name="pro_id" value="{{$projectId }}">
                <div class="modal-body">
                    <div class="col-sm-12 col-md-12 mb-3">
                        <label for="valueassetinv" class="col-form-label">Value of Inventory and Asset</label>
                        <input type="number" class="form-control" name="value" id="valueassetinv" min="0" >
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button type="submit" class="modalbtn">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#table1').DataTable({
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
</script>
