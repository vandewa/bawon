<div>
    <x-slot name="header">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h3 class="m-0">Tambah Vendor & User</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('penyedia.vendor-index') }}">Vendor</a></li>
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
                                    @error('vendor.npwp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                            <legend class="w-auto font-weight-bold">Kontak Perusahaan</legend>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Email</label>
                                    <input type="email" class="form-control" wire:model.defer="vendor.email">
                                    @error('vendor.email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Telepon</label>
                                    <input type="text" class="form-control" wire:model.defer="vendor.telepon">
                                    @error('vendor.telepon')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="p-3 mb-4 border rounded">
                            <legend class="w-auto font-weight-bold">Usaha & Legalitas</legend>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Nama Direktur</label>
                                    <input type="text" class="form-control" wire:model.defer="vendor.nama_direktur">
                                    @error('vendor.nama_direktur')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Jenis Usaha</label>
                                    <input type="text" class="form-control" wire:model.defer="vendor.jenis_usaha">
                                    @error('vendor.jenis_usaha')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Klasifikasi</label>
                                    <input type="text" class="form-control" wire:model.defer="vendor.klasifikasi">
                                    @error('vendor.klasifikasi')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kualifikasi</label>
                                    <input type="text" class="form-control" wire:model.defer="vendor.kualifikasi">
                                    @error('vendor.kualifikasi')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="p-3 border rounded">
                            <legend class="w-auto font-weight-bold">Lokasi Perusahaan</legend>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Provinsi</label>
                                    <input type="text" class="form-control" wire:model.defer="vendor.provinsi">
                                    @error('vendor.provinsi')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Kabupaten/Kota</label>
                                    <input type="text" class="form-control" wire:model.defer="vendor.kabupaten">
                                    @error('vendor.kabupaten')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Kode Pos</label>
                                    <input type="text" class="form-control" wire:model.defer="vendor.kode_pos">
                                    @error('vendor.kode_pos')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="p-3 mb-4 border rounded">
                            <legend class="w-auto font-weight-bold">Pilih Lokasi Toko</legend>
                            <div class="form-group">
                                <label>Cari Lokasi</label>
                                <input type="text" id="locationSearch" class="form-control"
                                    placeholder="Contoh: Pasar Wonosobo">
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Latitude</label>
                                    <input type="text" class="form-control" wire:model.live="vendor.latitude"
                                        id="latInput">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Longitude</label>
                                    <input type="text" class="form-control" wire:model.live="vendor.longitude"
                                        id="lngInput">
                                </div>
                            </div>
                            <div class="form-group col-md-12" wire:ignore>
                                <div id="map" style="height: 300px; border: 1px solid #ccc;"></div>
                            </div>
                        </fieldset>

                        <fieldset class="p-3 mb-4 border rounded">
                            <legend class="w-auto font-weight-bold">Upload Foto Vendor</legend>

                            <div x-data x-on:dragover.prevent
                                x-on:drop.prevent="
                                    const files = $event.dataTransfer.files;
                                    [...files].forEach(file => $wire.call('addDroppedFile', file));
                                "
                                class="border border-dashed rounded p-4 text-center"
                                style="min-height: 150px; background-color: #f9f9f9; cursor: pointer;">
                                <p><i class="fas fa-cloud-upload-alt fa-2x"></i></p>
                                <p>Drag & drop file ke sini atau klik di bawah</p>

                                <input type="file" wire:model="single_foto" accept="image/*"
                                    class="form-control mt-2" />
                                <div wire:loading wire:target="single_foto">
                                    <small class="text-muted"><i class="fas fa-spinner fa-spin"></i> Mengunggah foto
                                        tambahan...</small>
                                </div>
                                @error('single_foto')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            @if ($foto_vendor)
                                <div class="row mt-3">
                                    @foreach ($foto_vendor as $index => $preview)
                                        <div class="col-md-3 mb-3" style="position: relative;">
                                            <img src="{{ $preview->temporaryUrl() }}" class="img-thumbnail"
                                                style="width: 100%; display: block;">
                                            <button type="button" wire:click="removeFotoVendor({{ $index }})"
                                                style="
                                                position: absolute;
                                                top: 5px;
                                                right: 5px;
                                                z-index: 10;
                                                background: rgba(255, 0, 0, 0.8);
                                                color: white;
                                                border: none;
                                                border-radius: 50%;
                                                width: 24px;
                                                height: 24px;
                                                line-height: 20px;
                                                text-align: center;
                                                font-size: 14px;
                                                cursor: pointer;
                                            ">
                                                &times;
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
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
                                        <div>
                                            <input type="file"
                                                class="form-control @error($field) is-invalid @enderror"
                                                wire:model="{{ $field }}">
                                            @if (!empty($vendor[$field]))
                                                <div class="mt-2">
                                                    <a href="{{ Storage::url($vendor[$field]) }}" target="_blank"
                                                        class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-eye"></i> Lihat File
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        @error($field)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
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

                <div class="mb-4">
                    <a href="{{ route('penyedia.vendor-index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="float-right btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>

@push('js')
    <script>
        let map, marker;

        // pastikan Livewire tersedia
        document.addEventListener('livewire:init', () => {
            initLeaflet();
        });

        function initLeaflet() {
            const latInput = document.getElementById('latInput');
            const lngInput = document.getElementById('lngInput');
            const searchInput = document.getElementById('locationSearch');

            if (!latInput || !lngInput || !document.getElementById('map')) return;

            const lat = parseFloat(latInput.value) || -7.3614;
            const lng = parseFloat(lngInput.value) || 109.9011;

            if (!map) {
                map = L.map('map').setView([lat, lng], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                marker = L.marker([lat, lng], {
                    draggable: true
                }).addTo(map);

                marker.on('dragend', function(e) {
                    const pos = e.target.getLatLng();
                    updateCoordinates(pos.lat, pos.lng);
                });

                map.on('click', function(e) {
                    updateCoordinates(e.latlng.lat, e.latlng.lng);
                });
            }

            setTimeout(() => map.invalidateSize(), 100);

            latInput.addEventListener('change', () => {
                const newLat = parseFloat(latInput.value);
                const newLng = parseFloat(lngInput.value);
                if (!isNaN(newLat) && !isNaN(newLng)) {
                    updateCoordinates(newLat, newLng);
                }
            });

            lngInput.addEventListener('change', () => {
                const newLat = parseFloat(latInput.value);
                const newLng = parseFloat(lngInput.value);
                if (!isNaN(newLat) && !isNaN(newLng)) {
                    updateCoordinates(newLat, newLng);
                }
            });

            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const query = searchInput.value.trim();
                    if (!query) return;

                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.length > 0) {
                                const result = data[0];
                                updateCoordinates(parseFloat(result.lat), parseFloat(result.lon));
                            } else {
                                alert('Lokasi tidak ditemukan');
                            }
                        });
                }
            });
        }

        function updateCoordinates(newLat, newLng) {
            if (marker && map) {
                marker.setLatLng([newLat, newLng]);
                map.setView([newLat, newLng], 13);
                document.getElementById('latInput').value = newLat.toFixed(6);
                document.getElementById('lngInput').value = newLng.toFixed(6);
                Livewire.dispatch('setCoordinate', {
                    lat: newLat,
                    lng: newLng
                });
            }
        }

        Livewire.hook('commit', () => {
            setTimeout(() => {
                if (map) map.invalidateSize();
            }, 100);
        });
    </script>
@endpush
