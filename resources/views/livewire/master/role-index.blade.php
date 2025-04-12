<div>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="m-0">Role</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item active">Role</li>
                </ol>
            </div>
        </div>
    </x-slot>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="tab-pane fade active show">
                            <div class="tab-pane active show fade" id="custom-tabs-one-rm" role="tabpanel"
                                aria-labelledby="custom-tabs-one-rm-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <a href="{{ route('master.role') }}" class="btn btn-info"><i
                                                    class="fas fa-plus-square mr-2"></i>Tambah
                                                Data</a>
                                        </div>
                                        <div class="card card-info card-outline card-tabs">
                                            <div class="tab-content" id="custom-tabs-six-tabContent">
                                                <div class="tab-pane fade show active" id="custom-tabs-six-riwayat-rm"
                                                    role="tabpanel" aria-labelledby="custom-tabs-six-riwayat-rm-tab">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-2 mb-2">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Search" wire:model.live='cari'>
                                                            </div>
                                                        </div>

                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <th>No</th>
                                                                    <th>Name</th>
                                                                    <th>Display Name</th>
                                                                    <th>Deskripsi</th>
                                                                    <th>Action</th>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($post as $item)
                                                                        <tr wire:key='{{ $item->id }}'>
                                                                            <td>{{ $loop->index + $post->firstItem() }}
                                                                            </td>
                                                                            <td> {{ $item->name ?? '-' }}
                                                                            </td>
                                                                            <td> {{ $item->display_name ?? '-' }}
                                                                            </td>
                                                                            <td> {{ $item->description ?? '-' }}
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="gap-3 table-actions d-flex align-items-center fs-6">
                                                                                    <div class="mr-2">
                                                                                        <a href="{{ route('master.role', $item->id) }}"
                                                                                            class="btn btn-warning btn-flat btn-sm"
                                                                                            data-toggle="tooltip"
                                                                                            data-placement="left"
                                                                                            title="Edit"><i
                                                                                                class="fas fa-pencil-alt"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        {{ $post->links() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>
