@extends('layouts.admin')

@section('title', 'Daftar User')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Daftar User</h1>

<!-- @if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('admin.users.create') }}" class="btn text-white bg-success">
            <i class="fas fa-plus"></i>
            Tambah User
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="text-white bg-success">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>
                            <i class="fas fa-cog"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">
                            <span class="badge badge-{{ $user->role_view['badge'] }}">
                                {{ $user->role_view['label'] }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center" style="gap: 8px;">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<!-- Script agar data setelah di asc dan desc nomor tetap dari 1 -->
@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [
                [0, 'asc']
            ],
            "pageLength": 10,
            "drawCallback": function() {
                // Simple renumbering dari 1
                var counter = 1;
                this.api().column(0, {
                    page: 'current'
                }).nodes().each(function(cell) {
                    cell.innerHTML = counter++;
                });
            }
        });
    });
</script>
@endpush