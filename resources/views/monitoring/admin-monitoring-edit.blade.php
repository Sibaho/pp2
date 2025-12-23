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
                    <h4 class="mb-sm-0 font-size-18">Edit Monitoring</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.monitoring.index') }}">Monitoring</a></li>
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
                        <form action="{{ route('admin.monitoring.update', ['uuid' => $monitoringData->uuid]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">No PRJ</label>
                                        <input type="text" class="form-control" name="no_prj"
                                            value="{{ old('no_prj', $monitoringData->no_prj) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Dokumen Perjanjian</label>
                                        <input type="file"
                                            class="form-control"
                                            name="dokumen_perjanjian"
                                            accept="application/pdf">

                                        @if ($monitoringData->dokumen_perjanjian)
                                        <div class="mt-2">
                                            <a href="{{ route('monitoring.dokumen.preview', $monitoringData->uuid) }}"
                                                target="_blank"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Preview
                                            </a>

                                            <a href="{{ route('monitoring.dokumen.download', $monitoringData->uuid) }}"
                                                download
                                                class="btn btn-sm btn-success">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">PIC</label>
                                        <input type="text" class="form-control" name="pic"
                                            value="{{ old('pic', $monitoringData->pic) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tahun</label>
                                        <input type="text" class="form-control" name="tahun"
                                            value="{{ old('tahun', $monitoringData->tahun) }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Mitra</label>
                                        <input type="text" class="form-control" name="mitra"
                                            value="{{ old('mitra', $monitoringData->mitra) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">CP Mitra</label>
                                        <input type="text" class="form-control" name="cp_mitra"
                                            value="{{ old('cp_mitra', $monitoringData->cp_mitra) }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Aset</label>
                                        <select class="form-control" name="aset_id">
                                            <option value="">-- Select Aset --</option>
                                            @foreach($asets as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $monitoringData->aset_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_aset }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Status Perjanjian</label>
                                        <select class="form-control" name="aktif">
                                            <option value="">-- Select Status --</option>
                                            <option value="aktif"
                                                {{ $monitoringData->aktif == 'aktif' ? 'selected' : '' }}>
                                                Aktif
                                            </option>
                                            <option value="tidak aktif"
                                                {{ $monitoringData->aktif == 'tidak aktif' ? 'selected' : '' }}>
                                                Tidak Aktif
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Awal PRJ</label>
                                        <input type="date" class="form-control" name="tanggal_awal_prj"
                                            value="{{ old('tanggal_awal_prj', $monitoringData->tanggal_awal_prj) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Akhir PRJ</label>
                                        <input type="date" class="form-control" name="tanggal_akhir_prf"
                                            value="{{ old('tanggal_akhir_prf', $monitoringData->tanggal_akhir_prf) }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Biaya Sewa Guna</label>
                                        <input type="text"
                                            class="form-control"
                                            name="jumlah_bayar"
                                            value="{{ old('jumlah_bayar', $monitoringData->jumlah_bayar) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Pending Issue</label>
                                        <input type="text" class="form-control" name="pending_issue"
                                            value="{{ old('pending_issue', $monitoringData->pending_issue) }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Due Date</label>
                                        <input type="date" class="form-control" name="due_date"
                                            value="{{ old('due_date', $monitoringData->due_date) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Reminder</label>
                                        <input type="date" class="form-control" name="reminder"
                                            value="{{ old('reminder', $monitoringData->reminder) }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pembayaran PBB</label>
                                        <input type="text" class="form-control" name="pembayaran_pbb"
                                            value="{{ old('pembayaran_pbb', $monitoringData->pembayaran_pbb) }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Due Date Invoice</label>
                                        <input type="date" class="form-control" name="due_date_invoice"
                                            value="{{ old('due_date_invoice', $monitoringData->due_date_invoice) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tahapan Pembayaran Uang Sewa Guna</label>
                                        <input type="text" class="form-control" name="due_date_pembayaran_sewa_guna"
                                            value="{{ old('due_date_pembayaran_sewa_guna', $monitoringData->due_date_pembayaran_sewa_guna) }}">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('admin.monitoring.index') }}" class="btn btn-light me-1">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- end row -->
    </div> <!-- container-fluid -->
</div>
@endsection