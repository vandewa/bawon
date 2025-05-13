<div>
    <x-slot name="header">
        <div class="mb-2 row align-items-center">
            <div class="col-sm-6">
                <h3 class="m-0 animate__animated animate__fadeIn">Profil Penyedia</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('penyedia.vendor-index') }}">Penyedia</a></li>
                    <li class="breadcrumb-item active">Profil</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Data Penyedia -->
            <div class="mb-3 card card-primary shadow-sm">
                <div class="card-header d-flex align-items-center bg-primary text-white">
                    <i class="mr-2 fas fa-building"></i>
                    <h5 class="m-0 card-title">Data Penyedia</h5>
                </div>
                <div class="p-3 card-body">
                    <!-- Identitas Perusahaan -->
                    <fieldset class="p-3 mb-4 border rounded">
                        <legend class="w-auto font-weight-bold">Identitas Perusahaan</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nama Perusahaan:</strong> {{ $vendor->nama_perusahaan ?: '-' }}</p>
                                <p><strong>Alamat:</strong> {{ $vendor->alamat ?: '-' }}</p>
                                <p><strong>Provinsi:</strong> {{ $vendor->provinsi ?: '-' }}</p>
                                <p><strong>Kabupaten:</strong> {{ $vendor->kabupaten ?: '-' }}</p>
                                <p><strong>Kode Pos:</strong> {{ $vendor->kode_pos ?: '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>NIB:</strong> {{ $vendor->nib ?: '-' }}</p>
                                <p><strong>NPWP:</strong> {{ $vendor->npwp ?: '-' }}</p>
                                <p><strong>Masa Berlaku NIB:</strong> {{ $formattedData['masa_berlaku_nib'] }}</p>
                                <p><strong>Instansi Pemberi NIB:</strong> {{ $vendor->instansi_pemberi_nib ?: '-' }}
                                </p>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Kontak Perusahaan -->
                    <fieldset class="p-3 mb-4 border rounded">
                        <legend class="w-auto font-weight-bold">Kontak Perusahaan</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Email:</strong> {{ $vendor->email ?: '-' }}</p>
                                <p><strong>Telepon:</strong> {{ $vendor->telepon ?: '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Website:</strong> <a href="{{ $vendor->website ?: '#' }}"
                                        target="_blank">{{ $vendor->website ?: '-' }}</a></p>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Rekening -->
                    <fieldset class="p-3 mb-4 border rounded">
                        <legend class="w-auto font-weight-bold">Rekening</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Bank:</strong> {{ $formattedData['bank_st'] }}</p>
                                <p><strong>Nomor Rekening:</strong> {{ $vendor->no_rekening ?: '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Atas Nama:</strong> {{ $vendor->atas_nama_rekening ?: '-' }}</p>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Usaha & Legalitas -->
                    <fieldset class="p-3 mb-4 border rounded">
                        <legend class="w-auto font-weight-bold">Usaha & Legalitas</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nama Direktur:</strong> {{ $vendor->nama_direktur ?: '-' }}</p>
                                <p><strong>Jenis Usaha:</strong> {{ $formattedData['jenis_usaha'] }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Kualifikasi:</strong> {{ $formattedData['kualifikasi'] }}</p>
                                <p><strong>Klasifikasi:</strong> {{ $vendor->klasifikasi ?: '-' }}</p>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>

            <!-- Klasifikasi Usaha -->
            <div class="mb-3 card card-success shadow-sm">
                <div class="card-header d-flex align-items-center bg-success text-white">
                    <i class="mr-2 fas fa-list"></i>
                    <h5 class="m-0 card-title">Klasifikasi Bidang Usaha</h5>
                </div>
                <div class="p-3 card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Klasifikasi</th>
                                    <th>Foto</th>
                                    <th>Longitude</th>
                                    <th>Latitude</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($klasifikasiUsaha as $index => $item)
                                    <tr wire:key="klasifikasi-{{ $index }}">
                                        <td>{{ $item['nama_text'] ?? 'N/A' }}</td>
                                        <td>
                                            @if ($item['foto'])
                                                <a href="{{ Storage::url($item['foto']) }}" data-bs-toggle="lightbox"
                                                    data-gallery="vendor-gallery">
                                                    <img src="{{ Storage::url($item['foto']) }}" alt="Foto Usaha"
                                                        class="img-thumbnail" style="max-height: 50px;" loading="lazy">
                                                </a>
                                            @else
                                                <span class="text-muted">Tidak ada foto</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($item['longitude'], 6) }}</td>
                                        <td>{{ number_format($item['latitude'], 6) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada klasifikasi usaha
                                            yang ditambahkan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Dokumen Legalitas -->
            <div class="mb-3 card card-warning shadow-sm">
                <div class="card-header d-flex align-items-center bg-warning text-white">
                    <i class="mr-2 fas fa-file-alt"></i>
                    <h5 class="m-0 card-title">Dokumen Legalitas</h5>
                </div>
                <div class="p-3 card-body">
                    <div class="row">
                        @foreach ([
        'akta_pendirian' => 'Akta Pendirian',
        'nib_file' => 'File NIB',
        'npwp_file' => 'File NPWP',
        'siup' => 'SIUP / Izin Usaha',
        'izin_usaha_lain' => 'Izin Usaha Lain',
        'ktp_direktur' => 'KTP Direktur',
        'dok_kebenaran_usaha_file' => 'Dokumen Kebenaran Usaha',
        'bukti_setor_pajak_file' => 'Bukti Setor Pajak',
    ] as $field => $label)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                        <h6>{{ $label }}</h6>
                                        @if ($vendor->$field)
                                            {{-- Embed preview PDF --}}
                                            <embed
                                                src="{{ route('helper.show-picture', ['path' => $vendor->$field]) }}"
                                                type="application/pdf" width="100%" height="150" class="mt-2" />
                                            <a href="{{ route('helper.show-picture', ['path' => $vendor->$field]) }}"
                                                target="_blank" class="mt-2 btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> Lihat Full
                                            </a>
                                        @else
                                            <span class="mt-2 text-muted small d-block">Belum diunggah</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Data Pengguna -->
            <div class="mb-3 card card-info shadow-sm">
                <div class="card-header d-flex align-items-center bg-info text-white">
                    <i class="mr-2 fas fa-user"></i>
                    <h5 class="m-0 card-title">Data Pengguna</h5>
                </div>
                <div class="p-3 card-body">
                    @if ($user)
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nama:</strong> {{ $user->name }}</p>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Terdaftar Sejak:</strong>
                                    {{ \Carbon\Carbon::parse($user->created_at)->locale('id')->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>
                    @else
                        <p class="text-center text-muted">Belum ada pengguna terkait.</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="mb-4">
                <a href="{{ route('penyedia.vendor-index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('penyedia.vendor-edit', $vendor->id) }}" class="btn btn-primary float-right">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
            </div>
        </div>
    </section>
</div>

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lightbox for photo gallery
            document.querySelectorAll('a[data-bs-toggle="lightbox"]').forEach(el => {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                    const lightbox = new EkkoLightbox({
                        alwaysShowClose: true,
                        gallery: el.getAttribute('data-gallery'),
                        type: 'image'
                    });
                    lightbox.show(el.getAttribute('href'));
                });
            });

            // Google Maps initialization
            let map, marker;

            function initMap() {
                if (!document.getElementById('map')) return;

                const lat = parseFloat('{{ $vendor->latitude ?? -7.3594 }}');
                const lng = parseFloat('{{ $vendor->longitude ?? 109.8932 }}');
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 15,
                    center: {
                        lat,
                        lng
                    },
                    mapTypeControl: true,
                    streetViewControl: false,
                    fullscreenControl: true,
                });
                marker = new google.maps.Marker({
                    position: {
                        lat,
                        lng
                    },
                    map,
                    title: '{{ $vendor->nama_perusahaan }}',
                    animation: google.maps.Animation.DROP,
                });
            }

            // Load Google Maps asynchronously
            const script = document.createElement('script');
            script.src =
                `https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap&libraries=places`;
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
        });
    </script>
@endpush
