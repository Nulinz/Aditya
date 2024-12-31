@extends('layouts.app')
@section('content')

<div class="sidebodydiv">
    <div class="sidebodyhead">
        <h4 class="m-0">Dashboard 3</h4>
        <!-- <div class="sdbdysearch">
            <input type="text" class="form-control border-0" name="" id="">
            <button>
                <i class="fa-solid fa-search"></i>
            </button>
        </div> -->
    </div>
    <div class="container px-0 mt-2 headbtns">
        <div class="my-3">
            <a href="{{route('dashboard')}}"><button class="listbtn ">Dashboard 1</button></a>
        </div>
        <div class="my-3">
            <a href="{{route('dashboard2.index')}}"><button class="listbtn ">Dashboard 2</button></a>
        </div>
        <div class="my-3">
            <a href="{{route('dashboard3.index')}}"><button class="listbtn ">Dashboard 3</button></a>
        </div>
        <div class="my-3">
            <a href="{{route('dashboard4.index')}}"><button class="listbtn ">Dashboard 4</button></a>
        </div>
    </div>
    <div class="container px-0 my-4">

        <div class="sidebodyhead my-4">
            <h4 class="m-0">Sales / Zero / Actual</h4>
        </div>

        <div class="charts">
            @foreach($projects as $project)
                <div class="chartdiv mb-4">
                    <h5 class="fw-bold">{{ $project->pro_code }}</h5>
                    <div id="col-{{ $project->id }}" class="chart"></div>

                    <!-- Charts -->
                    <script>
                        var seriesData = [{
                            name: 'Series 1', // Name your series
                            data: JSON.parse(@json($project->all_data))
                        }];
                        var cat = JSON.parse(@json($project->boq_data));

                        var options = {
                            chart: {
                                type: 'bar',
                                height: 400,
                                width: '1800px',
                            },
                            series: seriesData,
                            xaxis: {
                                categories: cat,
                                labels: {
                                    style: {
                                        fontSize: '12px',
                                        colors: ['#000'],
                                    },
                                }
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    dataLabels: {
                                        position: 'top'
                                    }
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            colors: ['#008FFB', '#FF4560', '#00E396'],
                        };

                        var chart = new ApexCharts(document.querySelector("#col-{{ $project->id }}"), options);
                        chart.render();
                    </script>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        // DataTables List
        $(document).ready(function () {
            var table = $('.example').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "bDestroy": true,
                "info": false,
                "responsive": true,
                "pageLength": 10,
                "dom": '<"top"f>rt<"bottom"lp><"clear">'
            });
        });
    </script>
@endsection