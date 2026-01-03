@extends('layouts.install')

@section('content')
<div class="col-lg-10">


    <form method="post" action="{{ route('install.finish') }}" autocomplete="off">
        @csrf

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Administrator</h3>
            </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                                <div class="form-group">
                                        <label class="form-label">Administrator full name</label>
                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Full name" required="">
                                    </div>
                    
                                    <div class="form-group">
                                        <label class="form-label">Administrator E-mail</label>
                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="E-mail" required="">
                                    </div>
                        </div>
                        <div class="col-lg-6">
                                <div class="form-group">
                                        <label class="form-label">Administrator password</label>
                                        <input type="password" name="password" value="" class="form-control" placeholder="Password" required="">
                                    </div>
                    
                                    <div class="form-group">
                                        <label class="form-label">Confirm password</label>
                                        <input type="password" name="password_confirmation" value="" class="form-control" placeholder="Confirm password" required="">
                                    </div>
                        </div>
                    </div>
                

            </div>
            <div class="card-footer">
                <button class="btn btn-block btn-primary">Finish installation</button>
            </div>
        </div>

    </form>
</div>
@endsection