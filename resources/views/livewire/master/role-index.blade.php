<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6 d-flex align-items-center">
                <h3 class="m-0">
                    <i class="fas fa-user-shield mr-2"></i> Role
                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="fas fa-cogs"></i> Admin</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fas fa-user-tag"></i> Role
                    </li>
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
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="mb-3">
                                        <a href="{{ route('master.role') }}" class="btn btn-info">
                                            <i class="fas fa-plus-square mr-2"></i> Tambah Data
                                        </a>
                                    </div>

                                    <div class="card card-info card-outline card-tabs">
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active">
                                                <div class="card-body">

                                                    <div class="mb-3 row">
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control"
                                                                placeholder="🔍 Cari Role..."
                                                                wire:model.debounce.500ms="cari">
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-hover table-borderless shadow rounded overflow-hidden">
                                                            <thead style="background-color: #404040; color: white;">
                                                                <tr>
                                                                    <th class="px-3 py-2">No</th>
                                                                    <th class="px-3 py-2">Name</th>
                                                                    <th class="px-3 py-2">Display Name</th>
                                                                    <th class="px-3 py-2">Deskripsi</th>
                                                                    <th class="px-3 py-2 text-center">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($post as $item)
                                                                    <tr style="transition: background-color 0.2s;"
                                                                        onmouseover="this.style.background='#f0f9ff'"
                                                                        onmouseout="this.style.background='white'"
                                                                        wire:key='{{ $item->id }}'>
                                                                        <td class="px-3 py-2 align-middle">
                                                                            {{ $loop->index + $post->firstItem() }}</td>
                                                                        <td class="px-3 py-2 align-middle">
                                                                            {{ $item->name ?? '-' }}</td>
                                                                        <td class="px-3 py-2 align-middle">
                                                                            {{ $item->display_name ?? '-' }}</td>
                                                                        <td class="px-3 py-2 align-middle">
                                                                            {{ $item->description ?? '-' }}</td>
                                                                        <td
                                                                            class="px-3 py-2 text-center align-middle text-nowrap">
                                                                            <a href="{{ route('master.role', $item->id) }}"
                                                                                class="btn btn-sm btn-warning mb-1">
                                                                                <i class="fas fa-pencil-alt"></i> Edit
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="5"
                                                                            class="text-center text-muted py-4">
                                                                            <i class="fas fa-folder-open"></i> Tidak ada
                                                                            data role.
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="mt-3">
                                                        {{ $post->links() }}
                                                    </div>

                                                </div> <!-- /.card-body -->
                                            </div> <!-- /.tab-pane -->
                                        </div> <!-- /.tab-content -->
                                    </div> <!-- /.card -->

                                </div>
                            </div>
                        </div>
                    </div> <!-- /.card-body -->
                </div>
            </div>

        </div>
    </section>
</div>
