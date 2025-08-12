@extends('layouts.karyawan')

@section('title', 'Histori Absensi')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Histori Absensi</h1>

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered mt-3" id="dataTable">
            <thead class="thead-dark">
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
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                    <td>{{ $item->jam_masuk ?? '-' }}</td>
                    <td>
                        @if($item->status_masuk === 'Tepat Waktu')
                        <span class="badge badge-success">{{ $item->status_masuk }}</span>
                        @elseif($item->status_masuk === 'Terlambat')
                        <span class="badge badge-warning">{{ $item->status_masuk }}</span>
                        @else
                        -
                        @endif
                    </td>
                    <td>{{ $item->jam_keluar ?? '-' }}</td>
                    <td>@if($item->status_keluar === 'Pulang Tepat Waktu')
                        <span class="badge badge-success">{{ $item->status_keluar }}</span>
                        @elseif($item->status_keluar === 'Pulang Cepat')
                        <span class="badge badge-primary">{{ $item->status_keluar }}</span>
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