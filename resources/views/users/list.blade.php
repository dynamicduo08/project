@extends('layouts.dashboard.main')

@section('content')
<main>
    <div class="container-fluid" id="app">
        <h1 class="mt-4"><img class="card-img-top img-thumbnail" style="height: 60px; width : 60px" src="{{ asset('assets/quick_links/user_management.JPG') }}" alt="Patient Management">Users</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Users List</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Users List
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="form-group">
                        <a href="{{ route('create-user') }}" class="btn btn-info"><i class="fa fa-plus"></i> New User</a>
                    </div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>Date Created</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($data['users'])
                            @foreach($data['users'] as $user)
                                <tr>
                                    <td>
                                        @if($user->status == "Deactivated")
                                            <label class='text-danger'>Deactivated</label>
                                            <a href="{{ route('activate-user',$user->id) }}"><button class="btn btn-success" title="Activate"><i class="fa fa-check"></i></button></a>

                                        @else
                                            <a href="{{ route('edit-user',$user->id) }}"><button class="btn btn-info" title="Edit"><i class="fa fa-edit"></i></button></a>
                                            <a href="{{ route('delete-user', $user->id) }}"><button class="btn btn-danger" title="Deactivate"><i class="fa fa-window-close"></i></button></a>
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->usertype->name }}</td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
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
