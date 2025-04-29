<div class="container">
    <div class="row">
        @php
            $cards = [
                [
                    'label' => 'Users',
                    'count' => \App\Models\User::count(),
                    'icon' => 'fas fa-users',
                    'gradient' => 'linear-gradient(135deg, rgba(67,206,162,0.7), rgba(24,90,157,0.7))',
                    'shadow' => '0 8px 25px rgba(67,206,162,0.3)',
                ],
                [
                    'label' => 'Vendors',
                    'count' => \App\Models\Vendor::count(),
                    'icon' => 'fas fa-building',
                    'gradient' => 'linear-gradient(135deg, rgba(0,198,255,0.7), rgba(0,114,255,0.7))',
                    'shadow' => '0 8px 25px rgba(0,114,255,0.3)',
                ],
                [
                    'label' => 'Paket',
                    'count' => \App\Models\PaketPekerjaan::count(),
                    'icon' => 'fas fa-folder-open',
                    'gradient' => 'linear-gradient(135deg, rgba(247,151,30,0.7), rgba(255,210,0,0.7))',
                    'shadow' => '0 8px 25px rgba(255,180,0,0.3)',
                ],
                [
                    'label' => 'Kegiatan',
                    'count' => \App\Models\PaketKegiatan::count(),
                    'icon' => 'fas fa-tasks',
                    'gradient' => 'linear-gradient(135deg, rgba(248,80,50,0.7), rgba(231,56,39,0.7))',
                    'shadow' => '0 8px 25px rgba(231,56,39,0.3)',
                ],
            ];
        @endphp

        @foreach ($cards as $index => $card)
            <div class="col-md-3 mb-4 fade-in" style="animation-delay: {{ $index * 0.1 }}s;">
                <div class="card-stat shadow-lg"
                    style="
                        background: {{ $card['gradient'] }};
                        border-radius: 16px;
                        box-shadow: {{ $card['shadow'] }};
                        backdrop-filter: blur(12px);
                        transition: transform 0.3s ease, box-shadow 0.3s ease;
                        color: white;
                        padding: 24px 20px;
                        cursor: pointer;
                    "
                    onmouseover="this.style.transform='scale(1.03)'; this.style.boxShadow='0 12px 35px rgba(0,0,0,0.2)'"
                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='{{ $card['shadow'] }}'">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="font-weight: 600; font-size: 1rem; opacity: 0.85;">{{ $card['label'] }}</div>
                            <div style="font-weight: bold; font-size: 2rem;">{{ $card['count'] }}</div>
                        </div>
                        <i class="{{ $card['icon'] }} fa-2x" style="opacity: 0.8;"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


@push('css')
    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush
