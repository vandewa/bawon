<div>
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

                            <div class="form-group col-md-4">
                                <label>Tahun</label>
                                <input wire:model="tahun" type="number" class="form-control" placeholder="Tahun">
                                @error('tahun')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-12 mt-3">
                                <button class="btn btn-success" type="submit">
                                    <i class="fas fa-save"></i> {{ $isEdit ? 'Update' : 'Simpan' }}
                                </button>
                                <button type="button" class="btn btn-secondary" wire:click="resetForm">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="mt-4 table-responsive">
                        <table class="table table-bordered table-hover table-sm">
                            <thead style="background-color: #404040; color: white;">
                                <tr>
                                    <th>#</th>
                                    <th>Aparatur</th>
                                    <th>Jenis TPK</th>
                                    <th>Tahun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tpks as $index => $tpk)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $tpk->aparatur->nama }}</td>
                                        <td>{{ $tpk->jenis->code_nm }}</td>
                                        <td>{{ $tpk->tahun }}</td>
                                        <td>
                                            <button wire:click="edit({{ $tpk->id }})"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button wire:click="destroy({{ $tpk->id }})"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $tpks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
