<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\ProjectTeam;
use App\Models\ProjectSale;
use App\Models\HeadExpense;
use App\Models\Boq;
use App\Models\Purchase;
use App\Models\Lab;
use App\Models\Hire;


class DashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $emp_desg = $user->emp_desg;
    $userId = $user->id;

    if ($emp_desg === 'Admin') {
        $projects = Project::orderBy('id', 'ASC')->get();
    } else {
        $projectIds = ProjectTeam::where('mb_id', $userId)
            ->where('status', 1)
            ->pluck('pro_id');

        $projects = Project::whereIn('id', $projectIds)
            ->where('status', 1)
            ->orderBy('id', 'ASC')
            ->get();
    }

    $projectSales = ProjectSale::select('pro_id', DB::raw('SUM(pro_sale_amt) as actual'))
        ->where('status', 1)
        ->groupBy('pro_id')
        ->get()
        ->keyBy('pro_id');

    $overheadData = HeadExpense::select('pro_id', DB::raw('SUM(amt) as total_overhead'))
        ->whereIn('pro_id', $projectSales->keys())
        ->groupBy('pro_id')
        ->pluck('total_overhead', 'pro_id');

    $boqCosts = Boq::select('pro_id', DB::raw('SUM(boq_amount) as total_boq'))
        ->whereIn('pro_id', $projectSales->keys())
        ->groupBy('pro_id')
        ->pluck('total_boq', 'pro_id');

    $salesChart = [];
    $proChart = [];
    $proCd = [];
    $totalOverheadPercent = 0;
    $totalCompletionPercent = 0;
    $count = 0;

    foreach ($projectSales as $pro_id => $sale) {
        $boqCost = $boqCosts[$pro_id] ?? 0;
        $overhead = $overheadData[$pro_id] ?? 0;

        $completionPercent = $boqCost > 0 ? round(($sale['actual'] / $boqCost) * 100) : 0;
        $overheadPercent = $sale['actual'] > 0 ? round(($overhead / $sale['actual']) * 100) : 0;

        $salesChart[] = $overheadPercent;
        $proChart[] = 100 - $overheadPercent;
        $proCd[] = "Project Completion - {$completionPercent}%";

        $totalOverheadPercent += $overheadPercent;
        $totalCompletionPercent += (100 - $overheadPercent);
        $count++;
    }

    $overData = [
        'over1' => $count > 0 ? round($totalOverheadPercent / $count) : 0,
        'tt_pro1' => $count > 0 ? round($totalCompletionPercent / $count) : 0,
    ];

    return view('dashboard', [
        'projects' => $projects,
        'salesChart' => json_encode($salesChart),
        'proChart' => json_encode($proChart),
        'proCd' => json_encode($proCd),
        'overData' => $overData,
    ]);
}


public function index2()
{
          $projects = Project::where('status',1)->get();

          $dashboardData = [];

          foreach ($projects as $project) {

              $projectId = $project->id;

              $overheadAmount = HeadExpense::where('pro_id', $projectId)->where('status',1)->sum('amt');

              $exp = round(($overheadAmount / $this->getOverview($projectId)[1]) * 100);

              $boqs = Boq::where('pro_id', $projectId)
                    ->where('status', 1)
                    ->selectRaw('MAX(id) as id, pro_id, code')
                    ->groupBy('pro_id', 'code')
                    ->get();


              $boqData = [];

              foreach ($boqs as $boq) {

                  $sales = $boq->sl;

                  $zero = $boq->ze;

                  $labAmt = Lab::where('code', $boq->code)->where('pro_id', $projectId)->sum('amount');

                  $purAmt = Purchase::where('code', $boq->code)->where('pro_id', $projectId)->sum('amount');

                  $hireAmt = Hire::where('code', $boq->code)->where('pro_id', $projectId)->sum('amount');

                  $actualAmt = $labAmt + $purAmt + $hireAmt;

                  $withAct = round($actualAmt + ($actualAmt * ($exp / 100)));

                  if ($actualAmt > 0) {
                      $boqData[] = [
                          'pro_code' => $project->pro_code,
                          'boq' => $boq->code,
                          'sales' => $sales,
                          'zero' => $zero,
                          'actual' => $withAct
                      ];
                  }
              }

              $dashboardData[] = [
                  'name' => $project->pro_code,
                  'data' => $boqData,
              ];
          }

          return view('dashboard2',['dashboardData'=>$dashboardData]);
      }



     private function getOverview($projectId)
      {
          return [0, 100];
      }

        public function index3()
        {
            $projects = Project::where('status',1)->get();

            foreach ($projects as $project) {

                $all_data = [];

                $boq_data = [];

                $project->boqs = Boq::selectRaw('code, sum(boq_amount) as sl, sum(zero_amount) as ze')
                                    ->where('pro_id', $project->id)
                                    ->where('status', 1)
                                    ->groupBy('pro_id', 'code')
                                    ->get();

                foreach ($project->boqs as $boq) {
                    $lab_amt = Lab::where('code', $boq->code)
                                  ->where('pro_id', $project->id)
                                  ->where('status', 1)
                                  ->sum('amount');

                    $pro_sale = ProjectSale::where('code', $boq->code)
                                       ->where('pro_id', $project->id)
                                       ->where('status',1)
                                       ->first();

                    $pro_qt = $pro_sale->qty ?? 1;
                    $pro_unit = $pro_sale->unit ?? "Nil";

                    if ($lab_amt == 0 && ($pro_qt == 1 || $pro_unit == "Nil")) {
                        continue;
                    }

                    $sum = round($lab_amt / $pro_qt);

                    $all_data[] = $sum;

                    $boq_data[] = $boq->code . " [" . $pro_unit . "]";
                }

                $project->all_data = json_encode($all_data);

                $project->boq_data = json_encode($boq_data);
            }
            return view('dashboard3',['projects'=>$projects]);
        }

        public function index4()
        {
            $projects = Project::where('status',1)->get();

            $totalExpenditure = 0;

            foreach ($projects as $project) {

                $labAmount = Lab::where('pro_id', $project->id)->where('status',1)->sum('amount');

                $purchaseAmount = Purchase::where('pro_id', $project->id)->where('status',1)->sum('amount');

                $hireAmount = Hire::where('pro_id', $project->id)->where('status',1)->sum('amount');

                $overheadAmount = HeadExpense::where('pro_id', $project->id)->where('status',1)->sum('amt');

                $totalAmount = $labAmount + $purchaseAmount + $hireAmount + $overheadAmount;

                $totalExpenditure += $totalAmount;


                if ($totalAmount > 0) {
                    $pieData = [
                        round(($labAmount / $totalAmount) * 100),
                        round(($purchaseAmount / $totalAmount) * 100),
                        round(($hireAmount / $totalAmount) * 100),
                        round(($overheadAmount / $totalAmount) * 100)
                    ];
                } else {

                    $pieData = [0, 0, 0, 0];
                }


                $project->pieData = $pieData;
            }

            return view('dashboard4',['projects'=>$projects,'totalExpenditure'=>$totalExpenditure]);
        }


}
