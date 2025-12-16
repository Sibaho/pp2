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
                    <h4 class="mb-sm-0 font-size-18">All Monitoring</h4>

                    <div class="page-title-right">
                        <a href="{{ route('admin.monitoring.add') }}" class="btn btn-primary waves-effect waves-light">Add Monitoring</a>
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
                                        <th>Sl</th>
                                        <th>No. PRJ</th>
                                        <th>DL</th>
                                        <th>Tahun</th>
                                        <th>Mitra</th>
                                        <th>CP Mitra</th>
                                        <th>Lokasi Asal</th>
                                        <th>Aset</th>
                                        <th>Tanggal Awal PRJ</th>
                                        <th>Tanggal Akhir PRJ</th>
                                        <th>Tgl Tenggat Waktu Permohonan Perpanjangan</th>
                                        <th>Reminder PRJ Berakhir</th>
                                        <th>2 Bulan Pengawasan</th>
                                        <th>Aktif</th>
                                        <th>Due Date Invoice</th>
                                        <th>Due Date Pembayaran Uang Sewa Guna</th>
                                        <th>Due Date</th>
                                        <th>Reminder</th>
                                        <th>Jumlah Bayar</th>
                                        <th>PIC</th>
                                        <th>Pending Issue</th>
                                        <th>Pembayaran PBB</th>
                                        <th>Arsip PRJ-nya sudah ada?</th>
                                        <th>Apakah sudah ada penilaiannya?</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($monitoringData as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->no_prj }}</td>
                                        <td>{{ $item->dl }}</td>
                                        <td>{{ $item->tahun }}</td>
                                        <td>{{ $item->mitra }}</td>
                                        <td>{{ $item->cp_mitra }}</td>
                                        <td>{{ $item->aset->lokasi_aset }}</td>
                                        <td>{{ $item->aset->nama_aset }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_awal_prj)->locale('id')->translatedFormat('d F Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_akhir_prf)->locale('id')->translatedFormat('d F Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_tenggat_waktu_permohonan_perpanjangan)->locale('id')->translatedFormat('d F Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->reminder_prj_berakhir)->locale('id')->translatedFormat('d F Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->dua_bulan_pengawasan)->locale('id')->translatedFormat('d F Y') }}</td>
                                        <td>{{ $item->aktif }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->due_date_invoice)->locale('id')->translatedFormat('d F Y') }}</td>
                                        <td>{{ $item->due_date_pembayaran_sewa_guna }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->due_date)->locale('id')->translatedFormat('d F Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->reminder)->locale('id')->translatedFormat('d F Y') }}</td>
                                        <td>{{ $item->jumlah_bayar }}</td>
                                        <td>{{ $item->pic }}</td>
                                        <td>{{ $item->pending_issue }}</td>
                                        <td>{{ $item->pembayaran_pbb }}</td>
                                        <td>{{ $item->arsip_prj == 1 ? 'Ada' : '' }}</td>
                                        <td>{{ $item->penilaian == 1 ? 'Ya' : 'Tidak' }}</td>
                                        <td>
                                            <a href="{{ route('admin.monitoring.edit',$item['uuid']) }}" class="btn btn-info waves-effect waves-light">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.monitoring.delete',$item['uuid']) }}" class="btn btn-danger waves-effect waves-light">
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