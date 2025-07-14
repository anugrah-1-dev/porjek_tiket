@extends('adminlte::page')

@section('title', 'Manajemen Periode')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Daftar Periode</h1>
        <x-adminlte-button label="Tambah Periode" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#createPeriodModal" />
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card theme="lightblue" theme-mode="outline" title="List Periode">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan tanggal...">
                        </div>
                    </div>
                </div>

                <div class="table-responsive scrollable-table-wrapper">
                    <table class="table table-hover table-bordered table-striped" id="periodTable">
                        <thead class="bg-lightblue text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Tanggal Periode</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($periods as $index => $period)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="far fa-calendar-alt mr-2 text-lightblue"></i>
                                        {{ \Carbon\Carbon::parse($period->date)->translatedFormat('d F Y') }}
                                    </div>
                                </td>
                                <td>
                                    @if($period->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $period->created_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button
                                            class="btn btn-warning btn-sm mr-1 btn-edit-period"
                                            data-id="{{ $period->id }}"
                                            data-date="{{ $period->date->format('Y-m-d') }}"
                                            data-is-active="{{ $period->is_active }}"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.periods.destroy', $period->id) }}" method="POST" onsubmit="confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data periode.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($periods instanceof \Illuminate\Pagination\LengthAwarePaginator && $periods->hasPages())
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="dataTables_info">
                            Menampilkan {{ $periods->firstItem() }} sampai {{ $periods->lastItem() }} dari {{ $periods->total() }} entri
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="float-right">
                            {{ $periods->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                @endif
            </x-adminlte-card>
        </div>
    </div>

    {{-- Modal Create --}}
    <x-adminlte-modal id="createPeriodModal" title="Tambah Periode Baru" theme="lightblue" size="lg" static-backdrop>
        <form action="{{ route('admin.periods.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="date" label="Tanggal" type="date" required/>
                </div>
                    <div class="col-md-6">
                        <x-adminlte-input-switch name="is_active" label="Status Aktif" data-on-text="YA" data-off-text="TIDAK"/>
                    </div>
            </div>
            <div class="d-flex justify-content-end mt-3 w-100">
                <button type="button" class="btn btn-secondary btn-sm mr-2" data-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
        <x-slot name="footerSlot">
            <style>
                #createPeriodModal .modal-footer {
                    display: none;
                }
            </style>
        </x-slot>
    </x-adminlte-modal>

    {{-- Modal Edit --}}
    <x-adminlte-modal id="editPeriodModal" title="Edit Periode" theme="lightblue" size="lg" static-backdrop>
        <form id="editPeriodForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="editId">
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="date" label="Tanggal" id="editDate" type="date" required/>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input-switch name="is_active" id="editIsActive" label="Status Aktif" data-on-text="YA" data-off-text="TIDAK"/>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3 w-100">
                <button type="button" class="btn btn-secondary btn-sm mr-2" data-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
        <x-slot name="footerSlot">
            <style>
                #editPeriodModal .modal-footer {
                    display: none;
                }
            </style>
        </x-slot>
    </x-adminlte-modal>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css">
    <style>
        .table thead th {
            vertical-align: middle;
        }
        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.765625rem;
        }
        .scrollable-table-wrapper {
            max-height: 350px;
            overflow-y: auto;
        }
        #periodTable th:nth-child(1),
        #periodTable td:nth-child(1) {
            min-width: 40px;
        }
        #periodTable th:nth-child(2),
        #periodTable td:nth-child(2) {
            min-width: 200px;
        }
        #periodTable th:nth-child(3),
        #periodTable td:nth-child(3) {
            min-width: 120px;
        }
        #periodTable th:nth-child(4),
        #periodTable td:nth-child(4) {
            min-width: 150px;
        }
        #periodTable th:nth-child(5),
        #periodTable td:nth-child(5) {
            min-width: 130px;
        }
        .bootstrap-switch .bootstrap-switch-handle-on {
            background-color: #3c8dbc;
            color: white;
        }
        .bootstrap-switch .bootstrap-switch-handle-off {
            background-color: #d2d6de;
            color: #333;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        $(document).ready(function () {
            // Initialize switches
            $('[name="is_active"]').bootstrapSwitch({
                onText: 'YA',
                offText: 'TIDAK',
                onColor: 'primary',
                offColor: 'default'
            });

            // Search functionality
            $('#searchInput').on('keyup', function () {
                const searchValue = $(this).val().toLowerCase();
                $('#periodTable tbody tr').each(function () {
                    const rowText = $(this).text().toLowerCase();
                    $(this).toggle(rowText.includes(searchValue));
                });
            });

            // Edit modal setup
            $('.btn-edit-period').on('click', function () {
                const id = $(this).data('id');
                const date = $(this).data('date');
                const isActive = $(this).data('is-active');

                $('#editId').val(id);
                $('#editDate').val(date);

                // Set the switch state based on is_active
                $('#editIsActive').bootstrapSwitch('state', isActive);

                const actionUrl = `/admin/periods/${id}`;
                $('#editPeriodForm').attr('action', actionUrl);

                $('#editPeriodModal').modal('show');
            });
        });
    </script>

    @if(session('alert'))
    <script>
        Swal.fire(@json(session('alert')));
    </script>
    @endif
@stop
