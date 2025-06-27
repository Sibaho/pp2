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

                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
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
                                    <!-- <th>Tanggal Akhir PRJ</th>
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
                                    <th>Arsip PRJ?</th>
                                    <th>Penilaian?</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($monitoringData as $key=> $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->no_prj }}</td>
                                    <td>{{ $item->dl }}</td>
                                    <td>{{ $item->tahun }}</td>
                                    <td>{{ $item->mitra }}</td>
                                    <td>{{ $item->cp_mitra }}</td>
                                    <td>{{ $item->lokasi_asal }}</td>
                                    <td>{{ $item->aset }}</td>
                                    <td>{{ $item->tanggal_awal_prj }}</td>
                                    <!-- <td>{{ $item->tanggal_awal_prf }}</td>
                                    <td>{{ $item->tanggal_tenggat_waktu_permohonan_perpanjangan }}</td>
                                    <td>{{ $item->reminder_prj_berakhir }}</td>
                                    <td>{{ $item->dua_bulan_pengawasan }}</td>
                                    <td>{{ $item->aktif }}</td>
                                    <td>{{ $item->due_date_invoice }}</td>
                                    <td>{{ $item->due_date_pembayaran_sewa_guna }}</td>
                                    <td>{{ $item->due_date }}</td>
                                    <td>{{ $item->reminder }}</td>
                                    <td>{{ $item->jumlah_bayar }}</td>
                                    <td>{{ $item->pic }}</td>
                                    <td>{{ $item->pending_issue }}</td>
                                    <td>{{ $item->pembayaran_pbb }}</td>
                                    <td>{{ $item->arsip_prj }}</td>
                                    <td>{{ $item->penilaian }}</td> -->
                                    <td>
                                        <a href="{{ route('admin.user.edit',$item['id']) }}" class="btn btn-info waves-effect waves-light"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
@endsection