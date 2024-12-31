@extends('layouts.app')
@section('content')

<div class="sidebodydiv">
    <div class="sidebodyhead">
        <h4 class="m-0">Dashboard 4</h4>
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
            <h4 class="m-0">Expenditure</h4>
        </div>

        <div class="charts row">
            @foreach($projects as $project)
                <div class="col-sm-12 col-md-6 col-xl-6 px-2">
                    <div class="chartdiv mb-4">
                        <h5 class="fw-bold">{{ $project->pro_code }}</h5>
                        <div id="pie-{{ $project->id }}" class="chart"></div>
                        <!-- Charts -->
                        <script>
                            var data = @json($project->pieData);
                            var options = {
                                series: data,
                                chart: {
                                    type: 'pie',
                                },
                                legend: {
                                    position: 'bottom'
                                },
                                labels: ['Labour', 'Purchase', 'Hire', 'Overhead'],
                                responsive: [{
                                    breakpoint: 480,
                                    options: {
                                        chart: {
                                            width: 300,
                                        },
                                        legend: {
                                            position: 'bottom'
                                        }
                                    }
                                }]
                            };
                            var chart = new ApexCharts(document.querySelector("#pie-{{ $project->id }}"), options);
                            chart.render();
                        </script>
                    </div>
                </div>
            @endforeach
        </div>


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