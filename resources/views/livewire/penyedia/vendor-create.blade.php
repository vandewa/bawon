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
                                    <label>Nama Perusahaan <span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('vendor.nama_perusahaan') is-invalid @enderror"
                                        wire:model.defer="vendor.nama_perusahaan">
                                    @error('vendor.nama_perusahaan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Alamat <span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('vendor.alamat') is-invalid @enderror"
                                        wire:model.defer="vendor.alamat">
                                    @error('vendor.alamat')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>NPWP</label>
                                    <input type="text"
                                        class="form-control @error('vendor.npwp') is-invalid @enderror"
                                        wire:model.defer="vendor.npwp">
                                    @error('vendor.npwp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>NIB/SBU <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('vendor.nib') is-invalid @enderror"
                                        wire:model.defer="vendor.nib">
                                    @error('vendor.nib')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Masa berlaku NIB <span class="text-danger">*</span></label>
                                    <input type="date"
                                        class="form-control @error('vendor.masa_berlaku_nib') is-invalid @enderror"
                                        wire:model.defer="vendor.masa_berlaku_nib">
                                    @error('vendor.masa_berlaku_nib')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Instansi Pemberi NIB</label>
                                    <input type="text"
                                        class="form-control @error('vendor.instansi_pemberi_nib') is-invalid @enderror"
                                        wire:model.defer="vendor.instansi_pemberi_nib">
                                    @error('vendor.instansi_pemberi_nib')
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
                                    <input type="email"
                                        class="form-control @error('vendor.email') is-invalid @enderror"
                                        wire:model.defer="vendor.email">
                                    @error('vendor.email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Telepon</label>
                                    <input type="text"
                                        class="form-control @error('vendor.telepon') is-invalid @enderror"
                                        wire:model.defer="vendor.telepon">
                                    @error('vendor.telepon')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Website</label>
                                    <input type="text"
                                        class="form-control @error('vendor.website') is-invalid @enderror"
                                        wire:model.defer="vendor.website">
                                    @error('vendor.website')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="p-3 mb-4 border rounded">
                            <legend class="w-auto font-weight-bold">Usaha & Legalitas</legend>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Nama Direktur <span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('vendor.nama_direktur') is-invalid @enderror"
                                        wire:model.defer="vendor.nama_direktur">
                                    @error('vendor.nama_direktur')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Jenis Usaha</label>
                                    <select class="form-control @error('vendor.jenis_usaha') is-invalid @enderror"
                                        wire:model.defer="vendor.jenis_usaha">
                                        <option value="">Pilih Jenis Usaha</option>
                                        @foreach ($listJenisUsaha as $jenis)
                                            <option value="{{ $jenis->com_cd }}">{{ $jenis->code_nm }}</option>
                                        @endforeach
                                    </select>
                                    @error('vendor.jenis_usaha')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kualifikasi</label>
                                    <select class="form-control @error('vendor.kualifikasi') is-invalid @enderror"
                                        wire:model.defer="vendor.kualifikasi">
                                        <option value="">Pilih Kualifikasi</option>
                                        @foreach ($listKualifikasi as $kualifikasi)
                                            <option value="{{ $kualifikasi->com_cd }}">{{ $kualifikasi->code_nm }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vendor.kualifikasi')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="p-3 mb-4 border rounded">
                                    <legend class="w-auto font-weight-bold">Klasifikasi Bidang Usaha</legend>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Klasifikasi Bidang Usaha</label>
                                            <select
                                                class="form-control @error('vendor.klasifikasi') is-invalid @enderror"
                                                wire:model="vendor.klasifikasi">
                                                <option value="">Pilih Klasifikasi</option>
                                                @foreach ($listKlasifikasi as $klasifikasi)
                                                    <option value="{{ $klasifikasi->id }}">
                                                        {{ $klasifikasi->kode_kbli }} - {{ $klasifikasi->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('vendor.klasifikasi')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Foto Usaha</label>
                                            <input type="file" wire:model="foto"
                                                class="form-control @error('foto') is-invalid @enderror"
                                                accept="image/*">
                                            @error('foto')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror

                                            @if ($foto)
                                                <div class="mt-2">
                                                    <img src="{{ $foto->temporaryUrl() }}" class="img-thumbnail"
                                                        style="max-height: 200px;">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Lokasi Usaha</label>
                                            <div wire:ignore id="map" style="height: 300px; width: 100%;"></div>

                                            <div class="mt-3">
                                                <label for="latitude">Latitude</label>
                                                <input type="text" wire:model.defer="latitude" id="latitude"
                                                    class="form-control @error('latitude') is-invalid @enderror"
                                                    readonly>
                                                @error('latitude')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror

                                                <label for="longitude" class="mt-2">Longitude</label>
                                                <input type="text" wire:model.defer="longitude" id="longitude"
                                                    class="form-control @error('longitude') is-invalid @enderror"
                                                    readonly>
                                                @error('longitude')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror

                                                <button type="button" wire:click="simpanKlasifikasiUsaha"
                                                    class="btn btn-primary mt-3">
                                                    <i class="fas fa-plus"></i> Tambah Klasifikasi Usaha
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="p-3 mb-4 border rounded">
                                    <legend class="w-auto font-weight-bold">Daftar Klasifikasi Usaha</legend>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Klasifikasi</th>
                                                    <th>Foto</th>
                                                    <th>Longitude</th>
                                                    <th>Latitude</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($klasifikasiUsaha as $index => $item)
                                                    <tr wire:key="klasifikasi-{{ $index }}">
                                                        <td>{{ $item['nama_text'] ?? 'N/A' }}</td>
                                                        <td>
                                                            @if ($item['foto'])
                                                                <a href="{{ Storage::url($item['foto']) }}"
                                                                    target="_blank">
                                                                    <img src="{{ Storage::url($item['foto']) }}"
                                                                        alt="Foto Usaha" class="img-thumbnail"
                                                                        style="max-height: 50px;">
                                                                </a>
                                                            @else
                                                                <span class="text-muted">Tidak ada foto</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ number_format($item['long'], 6) }}</td>
                                                        <td>{{ number_format($item['lat'], 6) }}</td>
                                                        <td>
                                                            <button type="button"
                                                                wire:click="deleteKlasifikasi({{ $index }})"
                                                                class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus klasifikasi ini?')">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted">
                                                            Belum ada klasifikasi usaha yang ditambahkan
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

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
                                        <input type="file"
                                            class="form-control @error($field) is-invalid @enderror"
                                            wire:model="{{ $field }}" accept=".pdf,.jpg,.jpeg,.png">
                                        @error($field)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        @if ($this->$field)
                                            <small class="text-success">
                                                <i class="fas fa-check"></i> File telah dipilih
                                            </small>
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
                        <h5 class="m-0 card-title">Data User Penyedia</h5>
                    </div>
                    <div class="p-3 card-body">
                        <fieldset class="p-3 border rounded">
                            <legend class="w-auto font-weight-bold">User Login</legend>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Nama User <span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('user.name') is-invalid @enderror"
                                        wire:model.defer="user.name">
                                    @error('user.name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email User <span class="text-danger">*</span></label>
                                    <input type="email"
                                        class="form-control @error('user.email') is-invalid @enderror"
                                        wire:model.defer="user.email">
                                    @error('user.email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <input type="password"
                                        class="form-control @error('user.password') is-invalid @enderror"
                                        wire:model.defer="user.password">
                                    @error('user.password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password"
                                        class="form-control @error('user.password_confirmation') is-invalid @enderror"
                                        wire:model.defer="user.password_confirmation">
                                    @error('user.password_confirmation')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
        let map;
        let marker;

        document.addEventListener('livewire:load', function() {
            // Initialize map when page loads
            initMap();

            // Listen for render-map event to re-initialize map
            Livewire.on('render-map', event => {
                setTimeout(() => {
                    initMap();
                }, 100);
            });
        });

        function initMap() {
            if (!document.getElementById("map")) {
                return;
            }

            const defaultLocation = {
                lat: -7.3594, // Wonosobo latitude
                lng: 109.8932 // Wonosobo longitude
            };

            // Get current values from Livewire if available
            const currentLat = parseFloat(document.getElementById('latitude').value) || defaultLocation.lat;
            const currentLng = parseFloat(document.getElementById('longitude').value) || defaultLocation.lng;

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 13,
                center: {
                    lat: currentLat,
                    lng: currentLng
                },
                mapTypeControl: true,
                streetViewControl: false,
                fullscreenControl: true,
            });

            marker = new google.maps.Marker({
                position: {
                    lat: currentLat,
                    lng: currentLng
                },
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
            });

            // Update coordinates when marker is dragged
            google.maps.event.addListener(marker, 'dragend', function() {
                const position = marker.getPosition();
                updateCoordinates(position.lat(), position.lng());
            });

            // Update marker position and coordinates when map is clicked
            map.addListener("click", (event) => {
                const lat = event.latLng.lat();
                const lng = event.latLng.lng();

                marker.setPosition(event.latLng);
                updateCoordinates(lat, lng);
            });
        }

        function updateCoordinates(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            // Update Livewire properties
            @this.set('latitude', lat);
            @this.set('longitude', lng);
        }

        // Reinitialize map when Livewire updates
        window.addEventListener('contentChanged', event => {
            setTimeout(() => {
                initMap();
            }, 100);
        });
    </script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvC1Y_TXjCN5au-UqPsFtq2VKXAbtNzFs&callback=initMap&libraries=places"
        async defer></script>
@endpush
