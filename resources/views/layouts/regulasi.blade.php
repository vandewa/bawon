@extends('layouts.front')
@section('content')
    <!-- Search Form -->
    <section class="bg-half-170 d-table w-100 pb-0">
        <div class="container mt-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5>Daftar Regulasi</h5>
                </div>

                <div class="card-body p-0">
                    <table id="regulasi-table" class="table table-striped table-bordered w-100">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Regulasi</th>
                                <th>Dokumen</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(function() {
            $('#regulasi-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('regulasi') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'dokumen',
                        name: 'dokumen',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endpush
