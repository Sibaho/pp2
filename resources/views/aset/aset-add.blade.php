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
                    <h4 class="mb-sm-0 font-size-18">Add Aset</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.asets.index') }}">Aset</a></li>
                            <li class="breadcrumb-item active">Form Aset</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <form action="{{ route('admin.asets.store') }}" method="POST">
            <div class="row">
                @csrf
                <div class="col-12">
                    <div>
                        <div class="mb-3">
                            <label for="example-text-input" class="form-label">Kode Aset</label>
                            <input class="form-control" type="text" name="kode_aset">
                        </div>
                        <div class="mb-3">
                            <label for="example-text-input" class="form-label">Nama Aset</label>
                            <input class="form-control" type="text" name="nama_aset">
                        </div>
                        <div class="mb-3">
                            <label for="example-text-input" class="form-label">Lokasi Aset</label>
                            <input class="form-control" type="text" name="lokasi_aset">
                        </div>
                        <div class="mb-3">
                            <label for="example-text-input" class="form-label">Status </label>
                            <input class="form-control" type="text" name="status_aset">
                        </div>
                        <div class="mb-3">
                            <label for="example-text-input" class="form-label">Deskripsi</label>
                            <input class="form-control" type="text" name="deskripsi">
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.asets.index')}}" class="btn btn-light me-1">Cancel</a>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                <!-- end col -->
            </div>
        </form>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div>
@endsection