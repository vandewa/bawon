  @extends('layouts.front')
  @section('content')
      @if ($slides->isNotEmpty())
          <section class="home-slider position-relative">
              <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
                  <div class="carousel-inner">

                      @foreach ($slides as $index => $slide)
                          <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                              <div class="bg-home d-flex align-items-center"
                                  style="background: url('{{ asset('storage/' . $slide->image) }}') center; background-size: cover; height: 600px;">
                              </div>
                          </div>
                      @endforeach

                  </div>

                  <!-- Indikator -->
                  <div class="carousel-indicators">
                      @foreach ($slides as $index => $slide)
                          <button type="button" data-bs-target="#carouselExampleIndicators"
                              data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"
                              aria-label="Slide {{ $index + 1 }}"></button>
                      @endforeach
                  </div>
              </div>
          </section>
      @else
          <p class="text-center text-muted">Tidak ada slide tersedia.</p>
      @endisset

      <!-- Start Berita Terbaru -->
      <section class="section pt-5">
          <div class="container mt-100 mt-60">
              <div class="row justify-content-center">
                  <div class="col-12 position-relative">
                      <div class="section-title text-center mb-4 pb-2">
                          <h4 class="title mb-3">Berita Terkini</h4>
                      </div>

                      <!-- Tombol "Berita Lainnya" -->
                      @if ($jumlah_berita > 6)
                          <a href="{{ route('list-berita') }}" class="btn btn-primary position-absolute top-0 end-0">
                              Berita Lainnya
                          </a>
                      @endif
                  </div>
              </div>

              <div class="row justify-content-center">
                  @foreach ($berita as $list)
                      <div class="col-lg-4 col-md-6 mt-4 pt-2">
                          <div class="card blog blog-primary shadow rounded overflow-hidden">
                              <div class="image position-relative overflow-hidden">
                                  <img src="{{ asset('storage/' . $list->file_berita) }}" class="img-fluid"
                                      alt="">
                                  <div class="blog-tag">
                                      <a href="#" class="badge text-bg-light">
                                          {{ \Carbon\Carbon::parse($list->created_at)->translatedFormat('d F Y') }}
                                      </a>
                                  </div>
                              </div>
                              <div class="card-body content">
                                  <a href="#" class="h5 title text-dark d-block mb-0">{{ $list->judul }}</a>
                                  <p class="text-muted mt-2 mb-2">{!! Str::limit($list->isi_berita, 40) !!}</p>
                                  <a href="{{ route('detail-berita', $list->slug) }}" class="link text-dark">
                                      Baca Selengkapnya <i class="uil uil-arrow-right align-middle"></i>
                                  </a>
                              </div>
                          </div>
                      </div>
                  @endforeach
              </div>
          </div>
      </section>
  @endsection
