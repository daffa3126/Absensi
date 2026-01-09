@extends('layouts.admin')

@section('title', 'Laporan Absensi')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Laporan Absensi Karyawan</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <form action="{{ route('admin.absensi.index') }}" method="GET" class="row mb-4">
                <div class="col-md-3">
                    <label for="bulan">Bulan</label>
                    <select name="bulan" id="bulan" class="form-control">
                        <option value="">-- Semua Bulan --</option>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->locale('id')->translatedFormat('F') }}
                            </option>
                            @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tahun">Tahun</label>
                    <select name="tahun" id="tahun" class="form-control">
                        <option value="">-- Semua Tahun --</option>
                        @for ($y = now()->year; $y >= 2022; $y--)
                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end mt-2">
                    <button type="submit" class="btn text-white bg-success">Filter</button>
                    <a href="{{ route('admin.absensi.index') }}" class="btn text-white bg-success ml-2">Reset</a>
                </div>
            </form>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="text-white bg-success">
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Status Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Status Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                        <td>{{ $item->jam_masuk ?? '-' }}</td>
                        <td>
                            @if($item->status_masuk === 'Tepat Waktu')
                            <span class="badge badge-success">{{ $item->status_masuk }}</span>
                            @else
                            <span class="badge badge-warning">{{ $item->status_masuk }}</span>
                            @endif
                        </td>
                        <td>{{ $item->jam_keluar ?? '-' }}</td>
                        <td>
                            @php
                            $tanggalAbsensi = \Carbon\Carbon::parse($item->tanggal)->locale('id');
                            @endphp

                            @if(!$item->status_keluar)
                            @if($tanggalAbsensi->isBefore(\Carbon\Carbon::today()))
                            <span class="badge badge-danger">Tidak Absen</span>
                            @else
                            <span>-</span>
                            @endif
                            @elseif($item->status_keluar === 'Pulang')
                            <span class="badge badge-success">{{ $item->status_keluar }}</span>
                            @else
                            <span>-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data absensi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        if (!$.fn.dataTable.isDataTable('#dataTable')) {
            var t = $('#dataTable').DataTable({
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                "order": []
            });

            t.on('order.dt search.dt', function() {
                let i = 1;
                t.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell) {
                    cell.innerHTML = i++;
                });
            }).draw();
        }
    });
</script>
@endpush