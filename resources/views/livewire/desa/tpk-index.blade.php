<div>
    <div class="container">
        <x-slot name="header">
            <h1 class="m-0 text-dark">Manajemen TPK</h1>
        </x-slot>

        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


        <div class="card card-info card-outline card-tabs">
            <div class="tab-content">
                <div class="tab-pane fade show active">
                    <div class="card-body">
                        <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Tahun</label>
                                    <input wire:model="tahun" type="number" class="form-control" placeholder="Tahun">
                                    @error('tahun')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Aparatur</label>
                                    <select wire:model="aparatur_id" class="form-control">
                                        <option value="">-- Pilih Aparatur --</option>
                                        @foreach ($aparaturs as $aparatur)
                                            <option value="{{ $aparatur->id }}">{{ $aparatur->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('aparatur_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Jenis TPK</label>
                                    <select wire:model="tpk_type" class="form-control">
                                        <option value="">-- Pilih Jenis TPK --</option>
                                        @foreach ($jenis as $list)
                                            <option value="{{ $list->com_cd }}">{{ $list->code_nm }}</option>
                                        @endforeach
                                    </select>
                                    @error('tpk_type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>



                                <div class="col-md-12 mt-3 d-flex justify-content-between">
                                    <!-- Tombol Aksi -->
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-success mr-2" type="submit">
                                            <i class="fas fa-save"></i> {{ $isEdit ? 'Update' : 'Simpan' }}
                                        </button>
                                        <button type="button" class="btn btn-secondary mr-2" wire:click="resetForm">
                                            <i class="fas fa-undo"></i> Reset
                                        </button>

                                        <!-- Tombol Cetak -->
                                        <a href="{{ route('desa.generator-tpk', [$desa_id, $cari ?? date('Y')]) }}"
                                            target="_blank" class="btn btn-info">
                                            <i class="fas fa-print"></i> Cetak Surat Keputusan TPK
                                        </a>

                                    </div>

                                    <div class="form-group col-md-4">
                                        <select wire:model.live="cari" class="form-control">
                                            <option value="">🔍 Pencarian Tahun</option>
                                            @foreach ($tahunList as $tahun)
                                                <option value="{{ $tahun }}">{{ $tahun }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-hover table-borderless shadow rounded overflow-hidden">
                                <thead style="background-color: #404040; color: white;">
                                    <tr>
                                        <th class="px-3 py-2">No</th>
                                        <th class="px-3 py-2">Tahun</th>
                                        <th class="px-3 py-2">Aparatur</th>
                                        <th class="px-3 py-2">Jenis TPK</th>
                                        <th class="px-3 py-2 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tpks as $index => $tpk)
                                        <tr style="transition: background-color 0.2s;"
                                            onmouseover="this.style.background='#f0f9ff'"
                                            onmouseout="this.style.background='white'">
                                            <td class="px-3 py-2 align-middle">{{ $index + 1 }}</td>
                                            <td class="px-3 py-2 align-middle">{{ $tpk->tahun }}</td>
                                            <td class="px-3 py-2 align-middle">{{ $tpk->aparatur->nama }}</td>
                                            <td class="px-3 py-2 align-middle">{{ $tpk->jenis->code_nm }}</td>
                                            <td class="px-3 py-2 text-center align-middle text-nowrap">
                                                <button wire:click="edit({{ $tpk->id }})"
                                                    class="btn btn-sm btn-warning mb-1">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button wire:click="destroy({{ $tpk->id }})"
                                                    class="btn btn-sm btn-danger mb-1"
                                                    onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $tpks->links() }}


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
