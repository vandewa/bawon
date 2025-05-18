<div class="container mt-5">
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <h4>Kelola Slider</h4>

    <!-- Form Upload -->
    <form wire:submit.prevent="addSlide" class="mb-4">
        <div class="input-group">
            <input type="file" wire:model="image" class="form-control" accept="image/*">
            <button type="submit" class="btn btn-primary">Tambah</button>
        </div>
    </form>

    <!-- Daftar Slide -->
    <div class="row g-3">
        @forelse ($slides as $slide)
            <div class="col-md-3 position-relative">
                <img src="{{ asset('storage/' . $slide->image) }}" class="img-fluid rounded shadow-sm w-100"
                    style="height: 150px; object-fit: cover;">
                <button wire:click="deleteSlide({{ $slide->id }})"
                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1">
                    &times;
                </button>
            </div>
        @empty
            <p>Belum ada foto.</p>
        @endforelse
    </div>
</div>


@push('js')
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('fileInputReset', () => {
                document.getElementById('slide-image').value = '';
            });
        });
    </script>
@endpush
