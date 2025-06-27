@extends('layouts.dashboard')

@section('title_dashboard')
Admin Dashboard
@endsection

@section('profile_url')
{{ route('admin.profile') }}
@endsection

@section('logout_url')
{{ route('admin.logout') }}
@endsection

@section('home_url')
{{ route('admin.dashboard') }}
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Add User</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                            <li class="breadcrumb-item active">Form User</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="basicpill-firstname-input" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="basicpill-lastname-input" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="basicpill-lastname-input" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="user-kind" class="form-label">User</label>
                                <div class="input-group">
                                    <select class="form-control" name="kind" id="user-kind" required>
                                        <option value="" disabled selected>Select user</option>
                                        <option value="staff">Staff</option>
                                        <option value="timpp2">Tim PP2</option>
                                    </select>
                                    <span class="input-group-text">
                                        <i class="fas fa-chevrson-down"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.view.users')}}" class="btn btn-light me-1">Cancel</a>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div>
@endsection