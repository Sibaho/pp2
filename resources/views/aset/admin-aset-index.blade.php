@extends('layouts.dashboard')

@section('title_dashboard')
Aset Dashboard
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
                    <h4 class="mb-sm-0 font-size-18">All Aset</h4>

                    <div class="page-title-right">
                        <a href="{{ route('admin.asets.add') }}" class="btn btn-primary waves-effect waves-light">Add Aset</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Tambahkan div table-responsive di sini -->
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table-striped nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Aset</th>
                                        <th>Nama Aset</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Deskripsi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($asets as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->kode_aset }}</td>
                                        <td>{{ $item->nama_aset }}</td>
                                        <td>{{ $item->lokasi_aset }}</td>
                                        <td>{{ $item->status_aset }}</td>
                                        <td>{{ $item->deskripsi }}</td>
                                        <td>
                                            <a href="{{ route('admin.asets.edit',$item['uuid']) }}" class="btn btn-info waves-effect waves-light">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.asets.delete',$item['uuid']) }}" class="btn btn-danger waves-effect waves-light">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive -->
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>
@endsection