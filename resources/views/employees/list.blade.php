@extends('layouts.dashboard.main')

@section('content')
<main>
    <div class="container-fluid" id="app">
        <h1 class="mt-4"><img class="card-img-top img-thumbnail" style="height: 60px; width : 60px" src="{{ asset('assets/quick_links/human_resource.JPG') }}" alt="Patient Management">Employees</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Employees List</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Employees List
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Position</th>
                                <th>Daily Rate</th>
                                <th>Leave Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($data['employees']->count())
                            
                            @foreach($data['employees'] as $employee)
                            {{-- {{ dd($employee) }} --}}
                                <tr>
                                    <td>
                                        @if($employee->daily_rate == '')
                                            <button class="btn btn-info" title="Set daily rate first!" disabled="disabled"><i class="fa fa-calendar" ></i> Timesheet</button>
                                        @else
                                            <a href="{{ route('employee-timesheet', $employee['id'] ) }}"><button  onclick='show()' class="btn btn-info" title="Edit daily rate"><i class="fa fa-calendar"></i> Timesheet</button></a>
                                        @endif
                                        @if(count(($employee->daily_rates)->where('status','')) == 0)
                                        <a href="{{ route('edit-daily-rate', $employee['id'] ) }}"><button onclick='show()' class="btn btn-info" title="Edit"><i class="fa fa-coins"></i> Update Daily Rate</button></a>
                                        @endif

                                        @if(count($employee->attendance))
                                        <a href="{{ route('reset-time-out',$employee->id) }}" ><button onclick='show()' type="button" class="btn btn-sm btn-danger" title='Decline'> Reset Time Out </button></a>
                                        @endif
                                        
                                    </td>
                                    <td>{{ 'EP' . str_pad($employee->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $employee->user->name }}{{ count($employee->attendance) }}</td>
                                    <td>{{ $employee->user->usertype->name }}</td>
                                    <td>{{ ($employee->daily_rate == '') ? 0 : $employee->daily_rate }} PHP 
                                        @if(count(($employee->daily_rates)->where('status','')))
                                        <hr>
                                        @if(auth()->user()->type == 5)
                                        {{ number_format((($employee->daily_rates)->where('status','')->first()->daily_rate),2) }} <span class="label label-warning">Pending</span> <a href="{{ route('cancel-daily-rate',(($employee->daily_rates)->where('status','')->first()->id)) }}" ><button onclick='show()' type="button" class="btn btn-sm btn-danger" title='Cancel'><i class="fa fa-ban" ></i></button></a>
                                        @else
                                        
                                        <small>Request By:{{ ($employee->daily_rates)->where('status','')->first()->user_info->name }} </small><Br>
                                        Amount : {{ number_format((($employee->daily_rates)->where('status','')->first()->daily_rate),2) }} 
                                        <a href="{{ route('approve-daily-rate',(($employee->daily_rates)->where('status','')->first()->id)) }}" > <button onclick='show()' type="button" class="btn btn-sm btn-success" title='Approve'><i class="fa fa-check" ></i></button> </a>
                                        <a href="{{ route('reject-daily-rate',(($employee->daily_rates)->where('status','')->first()->id)) }}" ><button onclick='show()' type="button" class="btn btn-sm btn-danger" title='Decline'><i class="fa fa-ban" ></i></button></a>
                                        @endif
                                        @endif
                                    </td>
                                    <td>{{ $employee->leave_credit }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">
                                    <center>
                                        No Records to Show
                                    </center>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>
@include('layouts.dashboard.footer')
@endsection
