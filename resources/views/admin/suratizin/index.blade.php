@extends('layouts.admin')

@section('title', 'Daftar Surat Izin Karyawan')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Daftar Surat Izin Karyawan</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="text-white" style="background-color: #2ecc71;">
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
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
                        <td>{{ $surat->user->name }}</td>
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
                                <a href="{{ route('admin.suratizin.lihat', $surat->id) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <!-- <form action="{{ route('admin.suratizin.setujui', $surat->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-sm btn-success">
                                        <i class="fas fa-solid fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.suratizin.tolak', $surat->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-solid fa-times"></i>
                                    </button>
                                </form> -->
                                @if($surat->status === 'belum disetujui')
                                <form action="{{ route('admin.suratizin.setujui', $surat->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-sm btn-success">
                                        <i class="fas fa-solid fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.suratizin.tolak', $surat->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-solid fa-times"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada surat izin.</td>
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