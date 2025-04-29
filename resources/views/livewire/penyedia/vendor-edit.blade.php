<div>
    <x-slot name="header">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h3 class="m-0">Edit Vendor & User</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('penyedia.vendor-index') }}">Vendor</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <form wire:submit.prevent="save">
                <div class="mb-3 card card-primary">
                    <div class="card-header d-flex align-items-center">
                        <i class="mr-2 fas fa-building"></i>
                        <h5 class="m-0 card-title">Data Vendor</h5>
                    </div>
                    <div class="p-3 card-body">
                        <fieldset class="p-3 mb-4 border rounded">
                            <legend class="w-auto font-weight-bold">Identitas Perusahaan</legend>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Nama Perusahaan</label>
                                    <input type="text" class="form-control"
                                        wire:model.defer="vendor.nama_perusahaan">
                                    @error('vendor.nama_perusahaan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>NIB</label>
                                    <input type="text" class="form-control" wire:model.defer="vendor.nib">
                                    @error('vendor.nib')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" wire:model.defer="vendor.npwp">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" wire:model.defer="vendor.alamat">
                                    @error('vendor.alamat')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="p-3 mb-4 border rounded">
                            <legend class="w-auto font-weight-bold">Kontak & Lokasi</legend>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Email</label>
                                    <input type="email" class="form-control" wire:model.defer="vendor.email">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Telepon</label>
                                    <input type="text" class="form-control" wire:model.defer="vendor.telepon">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Provinsi</label>
                                    <input type="text" class="form-control" wire:model.defer="vendor.provinsi">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Kabupaten/Kota</label>
                                    <input type="text" class="form-control" wire:model.defer="vendor.kabupaten">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Kode Pos</label>
                                    <input type="text" class="form-control" wire:model.defer="vendor.kode_pos">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="p-3 mb-4 border rounded">
                            <legend class="w-auto font-weight-bold">Upload Dokumen Legalitas</legend>
                            <div class="row">
                                @foreach ([
        'akta_pendirian' => 'Akta Pendirian',
        'nib_file' => 'File NIB',
        'npwp_file' => 'File NPWP',
        'siup' => 'SIUP / Izin Usaha',
        'izin_usaha_lain' => 'Izin Usaha Lain',
        'ktp_direktur' => 'KTP Direktur',
    ] as $field => $label)
                                    <div class="form-group col-md-6">
                                        <label>{{ $label }}</label>
                                        <input type="file" class="form-control @error($field) is-invalid @enderror"
                                            wire:model="{{ $field }}">
                                        @error($field)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        @php
                                            $vendorModel = \App\Models\Vendor::find($vendorId);
                                        @endphp

                                        @if ($vendorModel && $vendorModel->$field)
                                            <a href="{{ Storage::url($vendorModel->$field) }}" target="_blank"
                                                class="mt-1 btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i> Lihat Dokumen
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>

                    </div>
                </div>

                <div class="mb-3 card card-success">
                    <div class="card-header d-flex align-items-center">
                        <i class="mr-2 fas fa-user"></i>
                        <h5 class="m-0 card-title">Data User Vendor</h5>
                    </div>
                    <div class="p-3 card-body">
                        <fieldset class="p-3 border rounded">
                            <legend class="w-auto font-weight-bold">User Login</legend>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Nama User</label>
                                    <input type="text" class="form-control" wire:model.defer="user.name">
                                    @error('user.name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email User</label>
                                    <input type="email" class="form-control" wire:model.defer="user.email">
                                    @error('user.email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Password Baru (Opsional)</label>
                                    <input type="password" class="form-control" wire:model.defer="user.password">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control"
                                        wire:model.defer="user.password_confirmation">
                                </div>
                            </div>
                            <small class="text-muted">Kosongkan password jika tidak ingin mengganti.</small>
                        </fieldset>
                    </div>
                </div>

                <div class="mb-4">
                    <a href="{{ route('penyedia.vendor-index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="float-right btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
