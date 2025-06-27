@extends('components.auth-be-main')
@section('title')
Login
@endsection

@section('title_body')
Welcome Back!
@endsection

@section('sub_title_body')
Sign in
@endsection

@section('form')
<form class="mt-4 pt-2" action="{{ route('admin.login.authenticate') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <div class="mb-3">
        <div class="d-flex align-items-start">
            <div class="flex-grow-1">
                <label class="form-label">Password</label>
            </div>
        </div>

        <div class="input-group auth-pass-inputgroup">
            <input type="password" class="form-control" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon" name="password">
            <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
        </div>
    </div>

    <div class="mb-3">
        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log In</button>
    </div>
</form>
@endsection