@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add User</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @include('layouts._errors')
                    <form method="post" action="{{ route('user.store') }}">
                        @csrf
                        @method('post')

                        {{--name--}}
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" name="user_name" autofocus class="form-control" value="{{ old('user_name') }}" required>
                        </div>

                        {{--email--}}
                        <div class="form-group">
                            <label>Email<span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>



                        {{--email--}}
                        <div class="form-group">
                            <label>Phone Number<span class="text-danger">*</span></label>
                            <input type="text" name="mobile_number" class="form-control" value="{{ old('mobile_number') }}" required>
                        </div>





                        {{--password--}}

                        <div class="form-group">
                            <label>Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" autofocus class="form-control" value="{{ old('password') }}" required>
                        </div>

                        {{--password_confirmation--}}
                        <div class="form-group">
                            <label>Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" autofocus class="form-control" value="{{ old('password_confirmation') }}" required>
                        </div>


                            <button type="submit" class="btn btn-secondary"><i class="fa fa-plus"></i>Save</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of tile -->

            </div><!-- end of col -->

        </div><!-- end of row -->

@endsection
