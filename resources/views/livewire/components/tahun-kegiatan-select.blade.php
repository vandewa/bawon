<div class="d-inline align-middle">
    <label for="tahun-select" class="me-2 mb-0 fw-normal">Pilih Tahun</label>
    <select id="tahun-select" wire:model.live="selectedTahun" class="form-control form-select form-select-sm d-inline"
        style="width:auto; display:inline;">
        @foreach ($tahunList as $tahun)
            <option value="{{ $tahun }}">{{ $tahun }}</option>
        @endforeach
    </select>
</div>
