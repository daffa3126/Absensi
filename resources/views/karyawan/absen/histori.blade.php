@extends('layouts.karyawan')

@section('title', 'Histori Absensi')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Histori Absensi</h1>

<div class="card-body">
    <div class="table-responsive">

        <form action="{{ route('karyawan.absen.histori') }}" method="GET" class="row mb-4">
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
                <a href="{{ route('karyawan.absen.histori') }}" class="btn text-white ml-2 bg-success">Reset</a>
            </div>
        </form>
        <table class="table table-bordered mt-3" id="dataTable">
            <thead class="text-white bg-success">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Status Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Status Keluar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $index => $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->format_tanggal }}</td>
                    <td>{{ $item->jam_masuk ?? '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $item->status_masuk_badge }}">
                            {{ $item->status_masuk }}
                        </span>
                    </td>
                    <td>{{ $item->jam_keluar ?? '-' }}</td>
                    <td>
                        @if($item->status_keluar_view)
                        <span class="badge badge-{{ $item->status_keluar_view['badge'] }}">
                            {{ $item->status_keluar_view['label'] }}
                        </span>
                        @else
                        -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data absensi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
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