@extends('layouts.app')
@section('content')

{{-- {{dd(auth()->user()->id)}} --}}
<div class="sidebodydiv">
    <div class="sidebodyhead">
        <h4 class="m-0">Dashboard - Aditya</h4>

    </div>
    <div class="container px-0 mt-2 headbtns">
        <div class="my-3">
            <a href="{{route('dashboard')}}"><button class="listbtn {{ Request::routeIs('dashboard') ? 'active' : '' }}">Dashboard 1</button></a>
        </div>
        <div class="my-3">
            <a href="{{route('dashboard2.index')}}"><button class="listbtn {{ Request::routeIs('dashboard2.index') ? 'active' : '' }}">Dashboard 2</button></a>
        </div>
        <div class="my-3">
            <a href="{{route('dashboard3.index')}}"><button class="listbtn {{ Request::routeIs('dashboard3.index') ? 'active' : '' }}">Dashboard 3</button></a>
        </div>
        <div class="my-3">
            <a href="{{route('dashboard4.index')}}"><button class="listbtn {{ Request::routeIs('dashboard4.index') ? 'active' : '' }}">Dashboard 4</button></a>
        </div>
    </div>

    <div class="container px-0 my-4">
        <div class="sidebodyhead">
            <h4 class="m-2">In Process | <span class="txtgray">Project List</span></h4>
        </div>

        <div class="container-fluid listtable">
            <div class="filter-container row mb-3">
                <div class="custom-search-container col-sm-12 col-md-8">
                    <select class="headerDropdown form-select filter-option">
                        <option value="All" selected>All</option>
                    </select>
                    <input type="text" id="customSearch" class="form-control filterInput"
                        placeholder=" Search">
                </div>

                <div class="select1 col-sm-12 col-md-3 mx-auto">
                    <div class="d-flex gap-3">
                        <a href="" id="print" data-bs-toggle="tooltip" data-bs-title="Print"><i
                                class="fa-solid fa-print"></i></a>
                        <a href="" id="excel" data-bs-toggle="tooltip" data-bs-title="Excel"><i
                                class="fa-solid fa-file-csv"></i></a>
                    </div>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="example table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Project Code</th>
                            <th>Title</th>
                            <th>Cost</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $index => $project)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $project->pro_code }}</td>
                            <td>{{ $project->pro_title }}</td>
                            <td>{{ $project->pro_cost }}</td>
                            <td>{{ $project->remarks }}</td>
                            <td>
                                <div class="d-flex gap-3">
                                    <a href="{{ route('project.profile', ['project_id' => $project->id]) }}">
                                        <i class="fa-solid fa-arrow-up-right-from-square" data-bs-toggle="tooltip" data-bs-title="View Profile"></i>
                                    </a>
                                    @if (auth()->user()->emp_desg === 'Admin')
                                    <a href="{{ route('project.edit', ['id' => $project->id]) }}">
                                        <i class="fas fa-pen-to-square" data-bs-toggle="tooltip" data-bs-title="Edit"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <div class="sidebodyhead my-4">
            <h4 class="m-0">Overhead Vs Sales</h4>
        </div>
        <div class="charts">
            <div class="chartdiv">
                <div id="over_head" class="chart"></div>
            </div>
        </div>

        <div class="sidebodyhead my-4">
            <h4 class="m-0">Total</h4>
        </div>
        <div class="charts col-sm-12 col-md-6 col-xl-6">
            <div class="chartdiv w-100">
                <div id="piechart" class="chart"></div>
            </div>
        </div>

        <div class="sidebodyhead my-4">
            <h4 class="m-0">Overhead Master Vs Expenses</h4>
        </div>
        <div class="charts">
            @foreach ($projects as $project)
            <div class="chartdiv col-sm-12 col-md-12 col-xl-12 mb-4">
                <h5 class="fw-bold">{{ $project->pro_code }}</h5>
                <div id="pie-{{ $project->id }}" class="chart"></div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const graphData_{{ $project->id }} = @json($project->expenseGraphData ?? ['per' => [], 'code' => []]);
                        const options = {
                            series: [{
                                name: 'Expenditure',
                                data: graphData_{{ $project->id }}.per
                            }],
                            chart: {
                                type: 'bar',
                                height: 300,
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    endingShape: 'flat',
                                },
                            },
                            legend: {
                                position: 'bottom',
                            },
                            xaxis: {
                                categories: graphData_{{ $project->id }}.code,
                            },
                        };
                        const chart = new ApexCharts(document.querySelector("#pie-{{ $project->id }}"), options);
                        chart.render();
                    });
                </script>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Overhead/Sales Chart
            const cat = @json($proCd);
            const over = @json($salesChart);
            const full = @json($proChart);

            const options = {
                series: [
                    { name: 'Sales', data: full },
                    { name: 'Over Head', data: over }
                ],
                chart: {
                    type: 'bar',
                    height: 400,
                    stacked: true,
                    stackType: '100%',
                },
                xaxis: {
                    categories: cat,
                },
            };
            const chart = new ApexCharts(document.querySelector("#over_head"), options);
            chart.render();

            // Total Pie Chart
            const cn = @json($overData);
            const pieData = [cn.over1, cn.tt_pro1];
            const pieOptions = {
                series: pieData,
                chart: {
                    type: 'pie',
                },
                labels: ['Overhead', 'Sales'],
            };
            const pieChart = new ApexCharts(document.querySelector("#piechart"), pieOptions);
            pieChart.render();
        });
    </script>
    @endsection
