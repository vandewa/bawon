<div>
    <x-slot name="header">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h3 class="m-0">Tambah Data Desa & User</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('desa.desa-index') }}">Desa</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
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

                {{-- Card Data Desa --}}
                <div class="mb-3 card card-primary">
                    <div class="card-header d-flex align-items-center">
                        <i class="mr-2 fas fa-home"></i>
                        <h5 class="m-0 card-title">Data Desa</h5>
                    </div>
                    <div class="p-3 card-body">

                        {{-- Fieldset: Wilayah --}}
                        <fieldset class="p-3 mb-4 border rounded">
                            <legend class="w-auto font-weight-bold">Data Wilayah</legend>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Kabupaten</label>
                                    <input type="text" class="form-control" wire:model.defer="desa.kabupaten">
                                    @error('desa.kabupaten')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kode Desa</label>
                                    <input type="text" class="form-control" wire:model.defer="desa.kode_desa">
                                    @error('desa.kode_desa')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kecamatan</label>
                                    <input type="text" class="form-control" wire:model.defer="desa.kecamatan_id">
                                    @error('desa.kecamatan_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Nama Desa</label>
                                    <input type="text" class="form-control" wire:model.defer="desa.name">
                                    @error('desa.name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        {{-- Fieldset: Kontak Desa --}}
                        <fieldset class="p-3 mb-4 border rounded">
                            <legend class="w-auto font-weight-bold">Kontak & Alamat Desa</legend>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Kode Pos</label>
                                    <input type="text" class="form-control" wire:model.defer="desa.kode_pos">
                                </div>
                                <div class="form-group col-md-8">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" wire:model.defer="desa.alamat">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Website</label>
                                    <input type="url" class="form-control" wire:model.defer="desa.web">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email Desa</label>
                                    <input type="email" class="form-control" wire:model.defer="desa.email">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Telepon Desa</label>
                                    <input type="text" class="form-control" wire:model.defer="desa.telp">
                                </div>
                            </div>
                        </fieldset>

                    </div>
                </div>

                {{-- Card Data User --}}
                <div class="mb-4 card card-success">
                    <div class="card-header d-flex align-items-center">
                        <i class="mr-2 fas fa-user"></i>
                        <h5 class="m-0 card-title">Data User Desa</h5>
                    </div>
                    <div class="p-3 card-body">
                        {{-- Fieldset: User Login --}}
                        <fieldset class="p-3 border rounded">
                            <legend class="w-auto font-weight-bold">User Login Desa</legend>
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
                                    <label>Password</label>
                                    <input type="password" class="form-control" wire:model.defer="user.password">
                                    @error('user.password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Konfirmasi Password</label>
                                    <input type="password" class="form-control"
                                        wire:model.defer="user.password_confirmation">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="mb-4">
                    <a href="{{ route('desa.desa-index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="float-right btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Desa & User
                    </button>
                </div>

            </form>
        </div>
    </section>
</div>
