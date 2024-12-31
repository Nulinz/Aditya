@extends('layouts.app')
@section('content')

    <div class="sidebodydiv">
        <div class="sidebodyhead">
            <h4 class="m-0">In Process | <span class="txtgray">Project List</span></h4>
                <a href="{{route('projects.new')}}"><button class="listbtn">+ Add Project</button></a>
        </div>

        <div class="container-fluid mt-4 listtable">
            <div class="filter-container row mb-3">
                <div class="custom-search-container col-sm-12 col-md-8">
                    <select class="headerDropdown form-select filter-option">
                        <option value="All" selected>All</option>
                    </select>
                    <input type="text" id="customSearch" class="form-control filterInput" placeholder=" Search">
                </div>

                <div class="select1 col-sm-12 col-md-4 mx-auto">
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
                            @foreach($project as $projects)
                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $projects->pro_code }}</td>
                                    <td>{{ $projects->pro_title }}</td>
                                    <td>{{ $projects->pro_cost }}</td>
                                    <td>{{ $projects->remarks }}</td>
                                    <td>
                                        <div class="d-flex gap-3">
                                            @if(Auth::user()->emp_desg == 'Admin')
                                                <a href="{{ route('project.profile', ['project_id' => $projects->id]) }}">
                                                    <i class="fa-solid fa-arrow-up-right-from-square" data-bs-toggle="tooltip" data-bs-title="View Profile"></i>
                                                </a>
                                                <a href="{{ route('project.edit', ['id' => $projects->id]) }}">
                                                    <i class="fas fa-pen-to-square" data-bs-toggle="tooltip" data-bs-title="Edit"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('project.profile', ['project_id' => $projects->id]) }}">
                                                    <i class="fa-solid fa-arrow-up-right-from-square" data-bs-toggle="tooltip" data-bs-title="View Profile"></i>
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
    </div>
@endsection
