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
                                        <input type="text" class="form-control" name="cp_mitra" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Lokasi Aset</label>
                                        <input type="text" class="form-control" name="lokasi_aset" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Aset</label>
                                        <input type="text" class="form-control" name="aset" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Tanggal Awal PRJ</label>
                                        <input type="date" class="form-control" name="tanggal_awal_prj" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Tanggal Akhir PRJ</label>
                                        <input type="date" class="form-control" name="tanggal_akhir_prf" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Tenggat Waktu Permohonan</label>
                                        <input type="date" class="form-control" name="tanggal_tenggat_waktu_permohonan_perpanjangan" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Reminder PRJ Berakhir</label>
                                        <input type="date" class="form-control" name="reminder_prj_berakhir" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Dua Bulan Pengawasan</label>
                                        <input type="date" class="form-control" name="dua_bulan_pengawasan" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Aktif</label>
                                        <select class="form-control" name="aktif" >
                                            <option value="">-- Select Status --</option>
                                            <option value="aktif">Aktif</option>
                                            <option value="tidak aktif">Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Due Date Invoice</label>
                                        <input type="date" class="form-control" name="due_date_invoice" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Due Date Pembayaran Uang Sewa Guna</label>
                                        <input type="text" class="form-control" name="due_date_pembayaran_sewa_guna" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Due Date</label>
                                        <input type="date" class="form-control" name="due_date" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Reminder</label>
                                        <input type="date" class="form-control" name="reminder" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Jumlah Bayar</label>
                                        <input type="text" class="form-control" name="jumlah_bayar" oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.value = formatRupiah(this.value);" placeholder="Rp 0">
                                        <script>
                                            function formatRupiah(angka) {
                                                let number_string = angka.replace(/[^,\d]/g, '').toString(),
                                                    split = number_string.split(','),
                                                    sisa = split[0].length % 3,
                                                    rupiah = split[0].substr(0, sisa),
                                                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                                                if (ribuan) {
                                                    let separator = sisa ? '.' : '';
                                                    rupiah += separator + ribuan.join('.');
                                                }

                                                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                                                return rupiah ? 'Rp ' + rupiah : '';
                                            }
                                        </script>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">PIC</label>
                                        <input type="text" class="form-control" name="pic" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Pending Issue</label>
                                        <input type="text" class="form-control" name="pending_issue" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Pembayaran PBB</label>
                                        <input type="text" class="form-control" name="pembayaran_pbb" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Arsip PRJ</label>
                                         <select class="form-control" name="arsip_prj" >
                                            <option value="">-- Select Status --</option>
                                            <option value="1">Ada</option>
                                            <option value="0">Tidak Ada</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="basicpill-firstname-input" class="form-label">Penilaian</label>
                                         <select class="form-control" name="penilaian" >
                                            <option value="">-- Select Status --</option>
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak </option>
                                        </select>
                                    </div>

                                </div>

                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('admin.monitoring.index')}}" class="btn btn-light me-1">Cancel</a>
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