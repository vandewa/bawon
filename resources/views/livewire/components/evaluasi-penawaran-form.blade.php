<div>
    <form wire:submit.prevent="simpanEvaluasi">
        <!-- Evaluasi Administrasi -->
        <div class="form-group">
            <label for="suratKebenaranAda">Surat Pernyataan Kebenaran Usaha</label>
            <select wire:model="suratKebenaranAda" class="form-control">
                <option value="">Pilih Isian</option> <!-- Default option -->
                <option value="1">Ada</option>
                <option value="0">Tidak Ada</option>
            </select>
            @error('suratKebenaranAda')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="suratKebenaranHasil">Hasil Evaluasi</label>
            <input type="text" wire:model="suratKebenaranHasil" class="form-control"
                placeholder="Menenuhi/Tidak Memenuhi">
            @error('suratKebenaranHasil')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Evaluasi Teknis -->
        <div class="form-group">
            <label for="spesifikasiAda">Spesifikasi Teknis</label>
            <select wire:model="spesifikasiAda" class="form-control">
                <option value="">Pilih Isian</option> <!-- Default option -->
                <option value="1">Ada</option>
                <option value="0">Tidak Ada</option>
            </select>
            @error('spesifikasiAda')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="spesifikasiHasil">Hasil Evaluasi</label>
            <input type="text" wire:model="spesifikasiHasil" class="form-control" placeholder="Sesuai/Tidak Sesuai">
            @error('spesifikasiHasil')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="jadwalAda">Jadwal Pelaksanaan Pekerjaan</label>
            <select wire:model="jadwalAda" class="form-control">
                <option value="">Pilih Isian</option> <!-- Default option -->
                <option value="1">Ada</option>
                <option value="0">Tidak Ada</option>
            </select>
            @error('jadwalAda')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="jadwalHasil">Hasil Evaluasi</label>
            <input type="text" wire:model="jadwalHasil" class="form-control" placeholder="Sesuai/Tidak Sesuai">
            @error('jadwalHasil')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Evaluasi Harga -->
        <div class="form-group">
            <label for="hargaAda">Harga</label>
            <select wire:model="hargaAda" class="form-control">
                <option value="">Pilih Isian</option> <!-- Default option -->
                <option value="1">Ada</option>
                <option value="0">Tidak Ada</option>
            </select>
            @error('hargaAda')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="hargaHasil">Hasil Evaluasi</label>
            <input type="text" wire:model="hargaHasil" class="form-control"
                placeholder="Lulus/Tidak Lulus, % dari HPS">
            @error('hargaHasil')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Simpan Evaluasi</button>
    </form>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif
</div>
