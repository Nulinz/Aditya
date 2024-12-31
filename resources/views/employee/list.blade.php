@extends('layouts.app')
@section('content')

    <div class="sidebodydiv">
        <div class="sidebodyhead">
            <h4 class="m-0">Employee List</span></h4>
            <a href="{{route('employee.new')}}"><button class="listbtn">+ Add Employee</button></a>
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
                            <th>Employee Code</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Contact</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employee as $employees)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$employees->emp_code}}</td>
                                <td>{{$employees->vemp_name}}</td>
                                <td>{{$employees->emp_desg}}</td>
                                <td>{{$employees->contactno}}</td>
                                <td>
                                    <div class="d-flex gap-3">
                                       
                                        <a href="{{ route('employee.edit', ['id' => $employees->id]) }}">
                                            <i class="fa-solid fa-pen-to-square" data-bs-toggle="tooltip" data-bs-title="Edit"></i>
                                        </a>
                                        <a data-remote="{{ route('employee.destroy', ['id' => $employees->id]) }}" class="delete-confirm">
                                            <i class="fa-solid fa-trash text-danger" data-bs-toggle="tooltip" data-bs-title="Delete"></i>
                                        </a>
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