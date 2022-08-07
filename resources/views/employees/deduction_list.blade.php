@extends('layouts.dashboard.main')

@section('content')
<main>
    <div class="container-fluid" id="app">
        <h1 class="mt-4"><img class="card-img-top img-thumbnail" style="height: 60px; width : 60px" src="{{ asset('assets/quick_links/human_resource.JPG') }}" alt="Patient Management">Employees</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Deductions List</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Deductions List - per cut off
                
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Deduction</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deductions as $deduction)

                            <tr>
                                <td>
                                    @include('employees.edit_deduction')
                                    <button data-target="#edit_deduction{{$deduction->id}}" data-toggle="modal"  class="btn btn-warning">
                                        <i class="far fa-edit"></i>
                                        Edit
                                    </button>

                                </td>
                                <td>{{$deduction->deduction}}</td>
                                <td>@if($deduction->percent){{number_format($deduction->amount,2)}} %  @else{{number_format($deduction->amount,2)}} @endif</td>
                            </tr>
                          
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>
@include('layouts.dashboard.footer')
@endsection
