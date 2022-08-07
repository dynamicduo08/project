@extends('layouts.dashboard.main')

@section('content')
<main>
    <div class="container-fluid" id="app">
        <h1 class="mt-4"><img class="card-img-top img-thumbnail" style="height: 60px; width : 60px" src="{{ asset('assets/quick_links/human_resource.JPG') }}" alt="Patient Management">Employees</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Holiday List</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Holiday List
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="form-group">
                            <a href='#' class="btn btn-info" data-target="#new_holiday"  data-toggle="modal" ><i class="fa fa-plus"></i> New Holiday</a>
                    </div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                              
                                <th>Holiday Name</th>
                                <th>Holiday Type</th>
                                <th>Holiday Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($holidays as $holiday)
                                <tr>
                                    <td>{{$holiday->holiday_name}}</td>
                                    <td>{{$holiday->holiday_type}}</td>
                                    <td>{{date('M. d, ',strtotime($holiday->holiday_date)).date('Y')}}</td>
                                    <td>{{$holiday->status}}</td>
                                </tr>
                            @endforeach

                            @foreach($holidays_a as $holiday_a)
                            <tr>
                                <td>{{$holiday_a->holiday_name}}</td>
                                <td>{{$holiday_a->holiday_type}}</td>
                                <td>{{date('M. d, Y',strtotime($holiday_a->holiday_date))}}</td>
                                <td>
                                    <a href="delete-holiday/{{$holiday_a->id}}"  onclick="return confirm('Are you sure you want to delete this holiday?')" class="btn btn-danger">
                                        <span class="pe-7s-close"></span>
                                        Delete
                                    </a>
                                </td>
                                @include('employees.edit_holiday')
                            </tr>
                            @endforeach
                       
                        </tbody>
                    </table>
                    @include('employees.new_holiday')
                </div>
            </div>
        </div>

    </div>
</main>
@include('layouts.dashboard.footer')
@endsection
