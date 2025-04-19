<div>
    <x-slot name="header">
        <div class="mb-1 row">
            <div class="col-sm-6">
                <h3 class="m-0">Data Vendor / Penyedia</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Vendor</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <div class="card card-primary card-outline">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div class="mb-2 mb-md-0" style="width: 250px;">
                        <input type="text" class="form-control" placeholder="Cari nama/NIB..."
                            wire:model.live="search">
                    </div>
                    <div>
                        <button class="btn btn-primary" wire:click="create">
                            <i class="fas fa-plus-circle"></i> Tambah Vendor
                        </button>
                    </div>
                </div>
                <div class="p-0 card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Perusahaan</th>
                                <th>NIB</th>
                                <th>Direktur</th>
                                <th>Jenis Usaha</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendors as $vendor)
                                <tr>
                                    <td>{{ $vendor->nama_perusahaan }}</td>
                                    <td>{{ $vendor->nib }}</td>
                                    <td>{{ $vendor->nama_direktur }}</td>
                                    <td>{{ $vendor->jenis_usaha }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info"
                                            wire:click="showDetail({{ $vendor->id }})">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                        <button class="btn btn-sm btn-warning" wire:click="edit({{ $vendor->id }})">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $vendor->id }})">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="p-3">
                        {{ $vendors->links() }}
                    </div>
                </div>
            </div>

            @if ($showModal)
                <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
                    <div class="modal-dialog modal-xl">
                        <form wire:submit="save" class="modal-content" style="max-height: 90vh; overflow-y: auto;">
                            <div class="modal-header">
                                <h4 class="modal-title font-weight-bold">{{ $isEdit ? 'Edit Vendor' : 'Tambah Vendor' }}
                                </h4>
                                <button type="button" class="close" wire:click="resetForm">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Perusahaan</label>
                                            <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror" wire:model.defer="nama_perusahaan">
                                            @error('nama_perusahaan') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>NIB</label>
                                            <input type="text" class="form-control @error('nib') is-invalid @enderror" wire:model.defer="nib">
                                            @error('nib') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>NPWP</label>
                                            <input type="text" class="form-control @error('npwp') is-invalid @enderror" wire:model.defer="npwp">
                                            @error('npwp') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" wire:model.defer="alamat">
                                            @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Provinsi</label>
                                            <input type="text" class="form-control @error('provinsi') is-invalid @enderror" wire:model.defer="provinsi">
                                            @error('provinsi') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Kabupaten</label>
                                            <input type="text" class="form-control @error('kabupaten') is-invalid @enderror" wire:model.defer="kabupaten">
                                            @error('kabupaten') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Kode Pos</label>
                                            <input type="text" class="form-control @error('kode_pos') is-invalid @enderror" wire:model.defer="kode_pos">
                                            @error('kode_pos') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Direktur</label>
                                            <input type="text" class="form-control @error('nama_direktur') is-invalid @enderror" wire:model.defer="nama_direktur">
                                            @error('nama_direktur') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Jenis Usaha</label>
                                            <input type="text" class="form-control @error('jenis_usaha') is-invalid @enderror" wire:model.defer="jenis_usaha">
                                            @error('jenis_usaha') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Klasifikasi</label>
                                            <input type="text" class="form-control @error('klasifikasi') is-invalid @enderror" wire:model.defer="klasifikasi">
                                            @error('klasifikasi') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Kualifikasi</label>
                                            <input type="text" class="form-control @error('kualifikasi') is-invalid @enderror" wire:model.defer="kualifikasi">
                                            @error('kualifikasi') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model.defer="email">
                                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Telepon</label>
                                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" wire:model.defer="telepon">
                                            @error('telepon') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <h5 class="font-weight-bold text-dark">Upload Dokumen</h5>
                                <div class="row">
                                    @foreach ([
                                        'akta_pendirian' => 'Akta Pendirian',
                                        'nib_file' => 'File NIB',
                                        'npwp_file' => 'File NPWP',
                                        'siup' => 'SIUP / Izin Usaha',
                                        'izin_usaha_lain' => 'Izin Usaha Lain',
                                        'ktp_direktur' => 'KTP Direktur',
                                        'rekening_perusahaan' => 'Rekening Perusahaan',
                                    ] as $field => $label)
                                        <div class="form-group col-md-6">
                                            <label>{{ $label }}</label>
                                            <input type="file" class="form-control @error($field) is-invalid @enderror" wire:model="{{ $field }}">
                                            @error($field) <small class="text-danger">{{ $message }}</small> @enderror

                                            @if ($vendorId && ($vendor = App\Models\Vendor::find($vendorId)))
                                                @if ($vendor->$field)
                                                    <a href="{{ Storage::url($vendor->$field) }}" target="_blank" class="mt-1 btn btn-sm btn-outline-info">
                                                        <i class="fas fa-eye"></i> Lihat Dokumen
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    wire:click="resetForm">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
