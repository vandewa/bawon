<div>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Manajemen Aparatur</h1>
    </x-slot>

    <section class="content">
        <div class="container-fluid">

            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('message') }}
                </div>
            @endif

            <!-- Form Input -->
            <div class="card">
                <div class="text-white card-header bg-primary">
                    <h5 class="m-0 card-title">Form Aparatur</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Nama</label>
                                <input wire:model="nama" type="text" class="form-control" placeholder="Nama lengkap">
                                @error('nama')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>NIK</label>
                                <input wire:model="nik" type="number" class="form-control"
                                    placeholder="Nomor Induk Kependudukan">
                                @error('nik')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="jabatan">Jabatan</label>
                                <select wire:model="jabatan" id="jabatan" class="form-control">
                                    <option value="">-- Pilih Jabatan --</option>
                                    <option value="Kepala Desa">Kepala Desa</option>
                                    <option value="Sekretaris Desa">Sekretaris Desa</option>
                                    <option value="Kepala Urusan Keuangan">Kepala Urusan Keuangan</option>
                                    <option value="Kepala Urusan Perencanaan">Kepala Urusan Perencanaan</option>
                                    <option value="Kepala Urusan Tata Usaha dan Umum">Kepala Urusan Tata Usaha dan Umum
                                    </option>
                                    <option value="Kepala Seksi Pemerintahan">Kepala Seksi Pemerintahan</option>
                                    <option value="Kepala Seksi Kesejahteraan">Kepala Seksi Kesejahteraan</option>
                                    <option value="Kepala Seksi Pelayanan">Kepala Seksi Pelayanan</option>
                                    <option value="Kepala Dusun">Kepala Dusun</option>
                                    <option value="Staf">Staf</option>
                                    <option value="Anggota BPD">Anggota BPD</option>
                                    <option value="Ketua BPD">Ketua BPD</option>
                                </select>
                                @error('jabatan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>Bidang</label>
                                <input wire:model="bidang" type="text" class="form-control">
                                @error('bidang')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>Alamat</label>
                                <input wire:model="alamat" type="text" class="form-control">
                                @error('alamat')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>Telp</label>
                                <input wire:model="telp" type="text" class="form-control">
                                @error('telp')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>Tempat Lahir</label>
                                <input wire:model="tempat_lahir" type="text" class="form-control">
                                @error('tempat_lahir')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>Tanggal Lahir</label>
                                <input wire:model="tanggal_lahir" type="date" class="form-control">
                                @error('tanggal_lahir')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>TMT Awal</label>
                                <input wire:model="tmt_awal" type="date" class="form-control">
                                @error('tmt_awal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>TMT Akhir</label>
                                <input wire:model="tmt_akhir" type="date" class="form-control">
                                @error('tmt_akhir')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-success" type="submit">
                                <i class="fas fa-save"></i> {{ $isEdit ? 'Update' : 'Simpan' }}
                            </button>
                            <button type="button" class="btn btn-secondary" wire:click="resetForm">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="mt-4 table-responsive">
                <table class="table overflow-hidden rounded shadow table-hover table-borderless">
                    <thead style="background-color: #404040; color: white;">
                        <tr>
                            <th class="px-3 py-2">#</th>
                            <th class="px-3 py-2">Nama</th>
                            <th class="px-3 py-2">Jabatan</th>
                            <th class="px-3 py-2">Bidang</th>
                            <th class="px-3 py-2">TMT Awal</th>
                            <th class="px-3 py-2">TMT Akhir</th>
                            <th class="px-3 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lists as $index => $row)
                            <tr style="transition: background-color 0.2s;" onmouseover="this.style.background='#f0f9ff'"
                                onmouseout="this.style.background='white'">
                                <td class="px-3 py-2 align-middle">{{ $index + 1 }}</td>
                                <td class="px-3 py-2 align-middle">{{ $row->nama ?? '-' }}</td>
                                <td class="px-3 py-2 align-middle">{{ $row->jabatan ?? '-' }}</td>
                                <td class="px-3 py-2 align-middle">{{ $row->bidang ?? '-' }}</td>
                                <td class="px-3 py-2 align-middle">{{ $row->tmt_awal ?? '-' }}</td>
                                <td class="px-3 py-2 align-middle">{{ $row->tmt_akhir ?? '-' }}</td>
                                <td class="px-3 py-2 text-center align-middle text-nowrap">
                                    <button wire:click="edit({{ $row->id }})"
                                        class="mb-1 btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button wire:click="destroy({{ $row->id }})"
                                        class="mb-1 btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-muted">
                                    <i class="fas fa-folder-open"></i> Belum ada data.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="mt-3">
                {{ $lists->links() }}
            </div>

        </div>
    </section>
</div>
