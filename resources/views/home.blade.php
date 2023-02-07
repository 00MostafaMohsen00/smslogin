@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile shadow">
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <a href="{{ route('user.create') }}" class="btn btn-dark"><i class="fa fa-plus"></i>Create User</a>
                                    </div><!-- end of row -->
                                </div>
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="table-responsive">

                                                <table class="table datatable" id="admins-table" style="width: 100%;">
                                                    <thead class="alldata">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone Number</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                    <tbody class="alldata">
                                                    @foreach($users as $user)
                                                        <tr id="sid{{ $user->id}}">
                                                            <td>
                                                                {{$user->user_name}}</td>
                                                            <td>
                                                                {{$user->email}}
                                                            </td>
                                                            <td>
                                                                {{$user->mobile_number}}
                                                            </td>
                                                            <td><a href="{{ route('user.show',$user->id) }}" class="btn btn-secondary btn-sm">Edit</a></td>
                                                            <td><a href="{{ route('users.destroy',$user->id) }}" class="btn btn-danger btn-sm">Delete</a></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            </div><!-- end of table responsive -->

                                        </div><!-- end of col -->

                                    </div><!-- end of row -->

                                </div><!-- end of tile -->

                            </div><!-- end of col -->
                        </div><!-- end of row -->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
