@extends('layouts.dashboard.main')

@section('content')
<main>
    <div class="container-fluid" id="app">
        <h1 class="mt-4"><img class="card-img-top img-thumbnail" style="height: 60px; width : 60px" src="{{ asset('assets/quick_links/doctor.png') }}" alt="Patient Management">Doctors Management</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Doctor Schedules</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Doctor Schedules
            </div>
            <div class="card-body">
                <div class="table-responsive">  
                    <div class="form-group">
                        <a href="{{ route('create-schedule') }}" class="btn btn-info"><i class="fa fa-plus" data-toggle="modal" data-target="#exampleModal"></i> New Schedule</a>
                    </div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Doctor ID</th>
                                <th>Doctor Name</th>
                                <th>Date Schedule</th>
                                <th>Time From</th>
                                <th>Time To</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                                <tr>
                                    <td><a href="{{ route('delete-schedule', $schedule->id) }}"><button class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i> </button></a></td>
                                    <td>{{ 'DC' . str_pad($schedule->doctor_infor->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{$schedule->doctor_infor->fullname}}</td>
                                    <td>{{date('F d, Y',strtotime($schedule->schedule_date))}}</td>
                                    <td>{{$schedule->date_from}}</td>
                                    <td>{{$schedule->date_to}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>
@include('doctors-management.new_schedule')
@include('layouts.dashboard.footer')
@endsection
