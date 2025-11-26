@extends('layouts.karyawan')

@section('title', 'Surat Izin Saya')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Daftar Surat Izin Saya</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('karyawan.suratizin.create') }}" class="btn text-white" style="background-color: #2ecc71;">
            <i class="fas fa-plus"></i>
            Buat Surat Izin
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="text-white" style="background-color: #2ecc71;">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th><i class="fas fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surats as $surat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($surat->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                        <td>{{ ucfirst($surat->jenis) }}</td>
                        <td>{{ $surat->alasan }}</td>
                        <td>
                            @if($surat->status === 'disetujui')
                            <span class="badge badge-success">Disetujui</span>
                            @elseif($surat->status === 'belum disetujui')
                            <span class="badge badge-warning">Belum Disetujui</span>
                            @else
                            <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center" style="gap: 8px;">
                                <a href="{{ route('karyawan.suratizin.edit', $surat->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('karyawan.suratizin.destroy', $surat->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>
                                </form>
                                <a href="{{ route('karyawan.suratizin.cetak', $surat->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-print"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada surat izin.</td>
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