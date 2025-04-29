<div>
    <x-slot name="header">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h3 class="m-0">Profil Penyedia</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('penyedia.vendor-index') }}">Vendor</a></li>
                    <li class="breadcrumb-item active">Profil Vendor</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">

            <div class="mb-3 card">
                <div class="text-white card-header bg-primary d-flex align-items-center">
                    <i class="mr-2 fas fa-building"></i>
                    <h5 class="m-0 card-title">Data Perusahaan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama Perusahaan:</strong> {{ $vendor->nama_perusahaan ?? '' }}</p>
                            <p><strong>NIB:</strong> {{ $vendor->nib ?? '' }}</p>
                            <p><strong>NPWP:</strong> {{ $vendor->npwp ?? '' }}</p>
                            <p><strong>Alamat:</strong> {{ $vendor->alamat ?? '' }}</p>
                            <p><strong>Provinsi:</strong> {{ $vendor->provinsi ?? '' }}</p>
                            <p><strong>Kabupaten:</strong> {{ $vendor->kabupaten ?? '' }}</p>
                            <p><strong>Kode Pos:</strong> {{ $vendor->kode_pos ?? '' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Nama Direktur:</strong> {{ $vendor->nama_direktur ?? '' }}</p>
                            <p><strong>Email:</strong> {{ $vendor->email ?? '' }}</p>
                            <p><strong>Telepon:</strong> {{ $vendor->telepon ?? '' }}</p>
                            <p><strong>Jenis Usaha:</strong> {{ $vendor->jenis_usaha ?? '' }}</p>
                            <p><strong>Klasifikasi:</strong> {{ $vendor->klasifikasi ?? '' }}</p>
                            <p><strong>Kualifikasi:</strong> {{ $vendor->kualifikasi ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if ($vendor)
                <div class="mb-4 card">
                    <div class="text-white card-header bg-info d-flex align-items-center">
                        <i class="mr-2 fas fa-file-alt"></i>
                        <h5 class="m-0 card-title">Dokumen Legalitas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ([
        'akta_pendirian' => 'Akta Pendirian',
        'nib_file' => 'File NIB',
        'npwp_file' => 'File NPWP',
        'siup' => 'SIUP / Izin Usaha',
        'izin_usaha_lain' => 'Izin Usaha Lain',
        'ktp_direktur' => 'KTP Direktur',
    ] as $field => $label)
                                <div class="mb-3 col-md-4">
                                    <div class="border shadow-sm card h-100">
                                        <div class="text-center card-body">
                                            <i class="mb-2 fas fa-file-pdf fa-3x text-danger"></i>
                                            <h5 class="mt-2">{{ $label }}</h5> {{-- Ganti h6 jadi h5 di sini --}}
                                            @if ($vendor->$field)
                                                <a href="{{ Storage::url($vendor->$field) }}" target="_blank"
                                                    class="mt-2 btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Lihat
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
            @endif

            {{-- <div class="mb-4">
                <a href="{{ route('penyedia.vendor-index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Vendor
                </a>
            </div> --}}

        </div>
    </section>
</div>
