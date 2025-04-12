<div>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active">User</li>
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
                                        <div class="card card-info card-outline card-tabs">
                                            <div class="tab-content" id="custom-tabs-six-tabContent">
                                                <div class="tab-pane fade show active" id="custom-tabs-six-riwayat-rm"
                                                    role="tabpanel" aria-labelledby="custom-tabs-six-riwayat-rm-tab">
                                                    <div class="card-body">
                                                        <div class="col-md-12">
                                                            <form class="form-horizontal mt-2" wire:submit='save'>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-8">
                                                                            <div class="row mb-2">
                                                                                <label for="inputEmail3"
                                                                                    class="col-sm-3 col-form-label">Nama
                                                                                    <small class="text-danger">*</small>
                                                                                </label>
                                                                                <div class="col-sm-9">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        wire:model='form.name'
                                                                                        placeholder="Nama">
                                                                                    @error('form.name')
                                                                                        <span
                                                                                            class="form-text text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>

                                                                            <div class="row mb-2">
                                                                                <label for="inputEmail3"
                                                                                    class="col-sm-3 col-form-label">Email
                                                                                    <small class="text-danger">*</small>
                                                                                </label>
                                                                                <div class="col-sm-9">
                                                                                    <input type="email"
                                                                                        class="form-control"
                                                                                        wire:model='form.email'
                                                                                        placeholder="Email">
                                                                                    @error('form.email')
                                                                                        <span
                                                                                            class="form-text text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>

                                                                            <div class="row mb-2">
                                                                                <label for="inputEmail3"
                                                                                    class="col-sm-3 col-form-label">WhatsApp
                                                                                </label>
                                                                                <div class="col-sm-9">
                                                                                    <input type="number"
                                                                                        class="form-control"
                                                                                        wire:model='form.whatsapp'
                                                                                        placeholder="Nomor WhatsApp">
                                                                                    @error('form.whatsapp')
                                                                                        <span
                                                                                            class="form-text text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>

                                                                            <div class="row mb-3">
                                                                                <label for="inputEmail3"
                                                                                    class="col-sm-3 col-form-label">Role</label>
                                                                                <div class="col-sm-9">
                                                                                    <select class="form-control"
                                                                                        wire:model.live='role'>
                                                                                        <option value="">Pilih
                                                                                            Role</option>
                                                                                        @foreach ($listRole ?? [] as $item)
                                                                                            <option
                                                                                                value="{{ $item['id'] }}">
                                                                                                {{ $item['name'] }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('role')
                                                                                        <span
                                                                                            class="form-text text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>

                                                                            @if ($role == '3')
                                                                                <div class="row mb-3">
                                                                                    <label for="inputEmail3"
                                                                                        class="col-sm-3 col-form-label">Perusahaan</label>
                                                                                    <div class="col-sm-9">
                                                                                        <select class="form-control"
                                                                                            wire:model.live='perusahaan'>
                                                                                            <option value="">Pilih
                                                                                                Perusahaan</option>
                                                                                            @foreach ($listPerusahaan ?? [] as $item)
                                                                                                <option
                                                                                                    value="{{ $item['id'] }}">
                                                                                                    {{ $item['nama'] }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        @error('perusahaan')
                                                                                            <span
                                                                                                class="form-text text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>

                                                                            @endif

                                                                            @if ($edit)
                                                                                <div class="mb-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                            type="checkbox"
                                                                                            wire:model.live="isGantiPassword"
                                                                                            id="defaultCheck1">
                                                                                        <label class="form-check-label"
                                                                                            for="defaultCheck1">
                                                                                            Ganti Password ?
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            @endif

                                                                            @if ($isGantiPassword)
                                                                                <div class="row mb-2">
                                                                                    <label for="inputEmail3"
                                                                                        class="col-sm-3 col-form-label">Password
                                                                                        <small
                                                                                            class="text-danger">*</small>
                                                                                    </label>
                                                                                    <div class="col-sm-9">
                                                                                        <input type="password"
                                                                                            class="form-control"
                                                                                            wire:model='form.password'
                                                                                            placeholder="Password">
                                                                                        @error('form.password')
                                                                                            <span
                                                                                                class="form-text text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row mb-2">
                                                                                    <label for="inputEmail3"
                                                                                        class="col-sm-3 col-form-label">Konfirmasi
                                                                                        Password
                                                                                        <small
                                                                                            class="text-danger">*</small>
                                                                                    </label>
                                                                                    <div class="col-sm-9">
                                                                                        <input type="password"
                                                                                            class="form-control"
                                                                                            wire:model='konfirmasi_password'
                                                                                            placeholder="Konfirmasi Password">
                                                                                        @error('konfirmasi_password')
                                                                                            <span
                                                                                                class="form-text text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer">
                                                                    <a href="{{ route('master.user-index') }}"
                                                                        class="btn btn-warning ">Kembali
                                                                    </a>
                                                                    <button type="submit"
                                                                        class="btn btn-info float-right">Simpan
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <br>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>
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
