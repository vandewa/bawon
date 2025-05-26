<div>
    <div class="mb-3">
        <label for="desa-select" class="form-label">Pilih Desa</label>
        <select class="form-control" wire:model.live="kodeDesa" @disabled($isProcessing)>
            <option value="">-- Pilih Desa --</option>
            @foreach ($desaList as $desa)
                <option value="{{ $desa->kode_desa }}">{{ $desa->name }}</option>
            @endforeach
        </select>
    </div>

    <button class="mb-3 btn btn-primary" wire:click="sync" wire:loading.attr="disabled" @disabled(!$kodeDesa)>
        <span wire:loading.remove>Sinkron</span>
        <span wire:loading>Sedang proses...</span>
    </button>

    <!-- Animasi selama loading -->
    <div wire:loading class="my-4">
        <div class="gap-2 d-flex align-items-center">
            <div class="spinner-border text-primary" role="status" style="width: 2.5rem; height: 2.5rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div>
                <span class="fw-bold">Sinkronisasi sedang berlangsung</span>
                <div class="mt-1 loading-dots">
                    <span>.</span><span>.</span><span>.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Jika sukses/error -->
    @if ($message)
        <div class="mt-3 alert alert-info">
            {!! nl2br(e($message)) !!}
        </div>
    @endif

    <style>
        .loading-dots span {
            opacity: 0.2;
            animation: blink 1.4s infinite both;
            font-size: 1.8em;
            margin-left: 1px;
        }

        .loading-dots span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .loading-dots span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes blink {

            0%,
            80%,
            100% {
                opacity: 0.2;
            }

            40% {
                opacity: 1;
            }
        }
    </style>
</div>

@push('js')
    <script>
        window.addEventListener('sync-progress', event => {
            let info = document.getElementById('progress-info');
            if (info) info.textContent = event.detail.msg;
        });
    </script>
@endpush
