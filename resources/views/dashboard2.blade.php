@extends('layouts.app')
@section('content')

<div class="sidebodydiv ">
    <div class="sidebodyhead">
        <h4 class="m-0">Dashboard 2</h4>
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
            
            @foreach ($dashboardData as $project)
            <div class="chartdiv mb-4">
                <h5 class="fw-bold">{{ $project['name'] }}</h5>
                <div id="col-{{ $loop->index }}" class="chart"></div>

                <script>
                    var options = {
                        series: [
                            { name: 'Sales', data: @json(array_column($project['data'], 'sales')) },
                            { name: 'Zero', data: @json(array_column($project['data'], 'zero')) },
                            { name: 'Actual', data: @json(array_column($project['data'], 'actual')) }
                        ],
                        chart: {
                            type: 'bar',
                            height: 400,
                            stacked: false,
                            width: '1800px',
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                endingShape: 'rounded',
                                columnWidth: '35%',
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        xaxis: {
                            categories: @json(array_column($project['data'], 'boq')),
                        },
                        yaxis: {
                            title: {
                                text: 'Amount'
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            shared: true,
                            intersect: false
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#col-{{ $loop->index }}"), options);
                    chart.render();
                </script>
            </div>
        @endforeach
    </div>

</div>

</div>

@endsection