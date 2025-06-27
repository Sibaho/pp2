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
                    <h4 class="mb-sm-0 font-size-18">Add Monitoring</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Monitoring</a></li>
                            <li class="breadcrumb-item active">Form Monitoring</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.monitoring.store') }}" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                @csrf
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">No PRJ</label>
                                        <input type="text" class="form-control" name="no_prj" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">DL</label>
                                        <input type="text" class="form-control" name="dl" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Tahun</label>
                                        <input type="text" class="form-control" name="tahun" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Mitra</label>
                                        <input type="text" class="form-control" name="mitra" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">CP Mitra</label>
                                        <input type="text" class="form-control" name="tahun" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Lokasi Aset</label>
                                        <input type="text" class="form-control" name="mitra" required>
                                    </div>
                                </div>
                                 <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Aset</label>
                                        <input type="text" class="form-control" name="tahun" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Tanggal Awal PRJ</label>
                                        <input type="text" class="form-control" name="mitra" required>
                                    </div>
                                </div>
                                 <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Tanggal Akhir PRJ</label>
                                        <input type="text" class="form-control" name="tahun" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Tenggat Waktu Permohonan</label>
                                        <input type="text" class="form-control" name="mitra" required>
                                    </div>
                                </div>
                                 <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Tahun</label>
                                        <input type="text" class="form-control" name="tahun" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Mitra</label>
                                        <input type="text" class="form-control" name="mitra" required>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('admin.view.users')}}" class="btn btn-light me-1">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
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