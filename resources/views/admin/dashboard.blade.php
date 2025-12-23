@extends('layouts.dashboard')

@php
use Carbon\Carbon;
$today = Carbon::now('Asia/Jakarta')->startOfDay();
@endphp

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
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <!-- card -->
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">PRJ Aktif</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="{{ $aktifCount }}">0</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <!-- card -->
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">PRJ Selesai</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="{{ $selesaiCount }}">0</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col-->
            <div class="col-xl-3 col-md-6">
                <!-- card -->
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Aset Idle</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="{{ $idleAsetCount }}">0</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col-->
            <div class="col-xl-3 col-md-6">
                <!-- card -->
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Aset Optimized</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="{{ $optimizedAsetCount }}">0</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col-->
        </div><!-- end row-->

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Reminder & Due Date Monitoring</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>No. PRJ</th>
                                        <th>Mitra</th>
                                        <th>Aset</th>
                                        <th>Tanggal Akhir PRJ</th>
                                        <th>Sisa Hari</th>
                                        <th>PIC</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($monitorings as $index => $m)
                                    @php
                                    $dueDate = $m->tanggal_akhir_prf
                                    ? Carbon::parse($m->tanggal_akhir_prf)->startOfDay()
                                    : null;

                                    $daysLeft = $dueDate
                                    ? $today->diffInDays($dueDate, false)
                                    : null;

                                    // Default
                                    $rowClass = '';
                                    $badgeClass = 'bg-secondary';
                                    $icon = 'help-circle';
                                    $statusText = 'Tidak ada tanggal';

                                    if (!is_null($daysLeft)) {
                                    if ($daysLeft < 0) {
                                        $rowClass='table-danger' ;
                                        $badgeClass='bg-danger' ;
                                        $icon='alert-octagon' ;
                                        $statusText='Overdue' ;
                                        } elseif ($daysLeft <=7) {
                                        $rowClass='table-warning' ;
                                        $badgeClass='bg-warning' ;
                                        $icon='alert-circle' ;
                                        $statusText='≤ 7 Hari' ;
                                        } elseif ($daysLeft <=30) {
                                        $rowClass='table-info' ;
                                        $badgeClass='bg-info' ;
                                        $icon='clock' ;
                                        $statusText='≤ 30 Hari' ;
                                        } else {
                                        $rowClass='table-success' ;
                                        $badgeClass='bg-success' ;
                                        $icon='check-circle' ;
                                        $statusText='> 30 Hari' ;
                                        }
                                        }
                                        @endphp

                                        <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $m->no_prj }}</td>
                                        <td>{{ $m->mitra }}</td>
                                        <td>{{ $m->aset->nama_aset }}</td>
                                        <td>
                                            {{ $dueDate ? $dueDate->format('d M Y') : '-' }}
                                        </td>
                                        <td>
                                            @php
                                            $daysDisplay = is_null($daysLeft) ? null : floor($daysLeft);
                                            @endphp
                                            <span class="badge {{ $badgeClass }} d-inline-flex align-items-center gap-1">
                                                <i data-feather="{{ $icon }}" style="width:14px;height:14px;"></i>
                                                {{ $daysDisplay ?? '-' }} hari
                                            </span>
                                        </td>
                                        <td>{{ $m->pic }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">
                                                Tidak ada data
                                            </td>
                                        </tr>
                                        @endforelse
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
</div>
<!-- container-fluid -->
</div>
@endsection