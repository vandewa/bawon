<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6 d-flex align-items-center">
                <h3 class="m-0">
                    <i class="fas fa-users mr-2"></i> User
                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="fas fa-folder-open"></i> Master</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fas fa-user"></i> User
                    </li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">

            @if (session()->has('message'))
                <div class="alert alert-success">
                    <i class="fa fa-check-circle"></i> {{ session('message') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="tab-pane fade active show">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="mb-3">
                                        <a href="{{ route('master.user') }}" class="btn btn-info">
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
                                                                placeholder="🔍 Cari User..."
                                                                wire:model.debounce.500ms="cari">
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-hover table-borderless shadow rounded overflow-hidden">
                                                            <thead style="background-color: #404040; color: white;">
                                                                <tr>
                                                                    <th class="px-3 py-2">Nama</th>
                                                                    <th class="px-3 py-2">Email</th>
                                                                    <th class="px-3 py-2">Role</th>
                                                                    <th class="px-3 py-2 text-center">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($posts as $item)
                                                                    <tr style="transition: background-color 0.2s;"
                                                                        onmouseover="this.style.background='#f0f9ff'"
                                                                        onmouseout="this.style.background='white'">
                                                                        <td class="px-3 py-2 align-middle">
                                                                            {{ $item->name ?? '' }}</td>
                                                                        <td class="px-3 py-2 align-middle">
                                                                            {{ $item->email ?? '' }}</td>
                                                                        <td class="px-3 py-2 align-middle">
                                                                            {{ $item->roles()->first()->name ?? '-' }}
                                                                        </td>
                                                                        <td
                                                                            class="px-3 py-2 text-center align-middle text-nowrap">
                                                                            <a href="{{ route('master.user', $item->id) }}"
                                                                                class="btn btn-sm btn-primary mb-1">
                                                                                <i class="fas fa-eye"></i> Detail
                                                                            </a>
                                                                            <button type="button"
                                                                                wire:click="delete('{{ $item->id }}')"
                                                                                class="btn btn-sm btn-danger mb-1">
                                                                                <i class="fas fa-trash"></i> Hapus
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="4"
                                                                            class="text-center text-muted py-4">
                                                                            <i class="fas fa-folder-open"></i> Tidak ada
                                                                            data user.
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="mt-3">
                                                        {{ $posts->links() }}
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
