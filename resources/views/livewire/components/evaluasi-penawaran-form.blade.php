<div>
    <form wire:submit.prevent="simpanEvaluasi">

        {{-- Evaluasi: Surat Pernyataan Kebenaran Usaha --}}
        <div class="mb-3 form-row">
            <div class="col-md-6">
                <label>Surat Kebenaran Usaha</label>
                <select wire:model="suratKebenaranAda" class="form-control">
                    <option value="">Pilih Isian</option>
                    <option value="1">Ada</option>
                    <option value="0">Tidak Ada</option>
                </select>
                @error('suratKebenaranAda')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label>Hasil Evaluasi</label>
                <select wire:model="suratKebenaranHasil" class="form-control">
                    <option value="">Pilih Hasil</option>
                    <option value="Memenuhi">Memenuhi</option>
                    <option value="Tidak Memenuhi">Tidak Memenuhi</option>
                </select>
                @error('suratKebenaranHasil')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Evaluasi: Spesifikasi Teknis --}}
        <div class="mb-3 form-row">
            <div class="col-md-6">
                <label>Spesifikasi Teknis</label>
                <select wire:model="spesifikasiAda" class="form-control">
                    <option value="">Pilih Isian</option>
                    <option value="1">Ada</option>
                    <option value="0">Tidak Ada</option>
                </select>
                @error('spesifikasiAda')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label>Hasil Evaluasi</label>
                <select wire:model="spesifikasiHasil" class="form-control">
                    <option value="">Pilih Hasil</option>
                    <option value="Sesuai">Sesuai</option>
                    <option value="Tidak Sesuai">Tidak Sesuai</option>
                </select>
                @error('spesifikasiHasil')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Evaluasi: Jadwal Pelaksanaan --}}
        <div class="mb-3 form-row">
            <div class="col-md-6">
                <label>Jadwal Pelaksanaan</label>
                <select wire:model="jadwalAda" class="form-control">
                    <option value="">Pilih Isian</option>
                    <option value="1">Ada</option>
                    <option value="0">Tidak Ada</option>
                </select>
                @error('jadwalAda')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label>Hasil Evaluasi</label>
                <select wire:model="jadwalHasil" class="form-control">
                    <option value="">Pilih Hasil</option>
                    <option value="Sesuai">Sesuai</option>
                    <option value="Tidak Sesuai">Tidak Sesuai</option>
                </select>
                @error('jadwalHasil')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Evaluasi: Harga --}}
        <div class="mb-3 form-row">
            <div class="col-md-6">
                <label>Harga</label>
                <select wire:model="hargaAda" class="form-control">
                    <option value="">Pilih Isian</option>
                    <option value="1">Ada</option>
                    <option value="0">Tidak Ada</option>
                </select>
                @error('hargaAda')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label>Hasil Evaluasi</label>
                <input type="text" wire:model="hargaHasil" class="form-control"
                    placeholder="Lulus/Tidak Lulus, % dari HPS">
                @error('hargaHasil')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit" class="mt-2 btn btn-primary">Simpan Evaluasi</button>

        {{-- Flash Message --}}
        @if (session()->has('message'))
            <div class="mt-3 alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </form>
</div>
