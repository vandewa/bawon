  @extends('layouts.front')
  @section('content')
      <!-- Hero Start -->
      <section class="home-slider position-relative">
          <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
              <div class="carousel-inner">
                  <div class="carousel-item active" data-bs-interval="3000">
                      <div class="bg-home pb-md-0 d-flex align-items-center"
                          style="background: url('{{ asset('starty/images/shop/01.jpg') }}') center">
                          <div class="bg-overlay bg-gradient-white-overlay"></div>
                          <div class="container">
                              <div class="row mt-5 mt-sm-0 align-items-center">
                                  <div class="col-lg-6 offset-lg-6 col-md-8 offset-md-4">
                                      <div class="title-heading mt-4 position-relative">
                                          <h4 class="heading fw-bold mb-3 animated fadeInUpBig animation-delay-1">Selamat
                                              Datang di
                                              <span class="position-relative text-type-element">Portal Berita</span>
                                          </h4>
                                          <p
                                              class="text-muted title-dark mx-auto para-desc animated fadeInUpBig animation-delay-2">
                                              Dapatkan berita terbaru dan terpercaya setiap hari!</p>
                                          <div class="mt-4 pt-2">
                                              <a href="{{ route('master.berita-index') }}"
                                                  class="btn btn-primary animated fadeInUpBig animation-delay-3">Lihat
                                                  Berita</a>
                                          </div>
                                          <div class="position-absolute top-0 start-50 translate-middle">
                                              <img src="{{ asset('starty/images/shop/rounded-shape.png') }}" class="mover"
                                                  alt="">
                                          </div>
                                      </div>
                                  </div>
                              </div>

                          </div>
                      </div>
                  </div>
                  <div class="carousel-item" data-bs-interval="3000">
                      <div class="bg-home pb-md-0 d-flex align-items-center"
                          style="background: url('{{ asset('starty/images/shop/02.jpg') }}') top">
                          <div class="bg-overlay bg-gradient-white-overlay"></div>
                          <div class="container">
                              <div class="row mt-5 mt-sm-0 align-items-center">
                                  <div class="col-lg-6 col-md-8">
                                      <div class="title-heading mt-4 position-relative">
                                          <h4 class="heading fw-bold mb-3 animated fadeInUpBig animation-delay-1">Berita
                                              <br> <span class="position-relative text-type-element">Terkini</span>
                                          </h4>
                                          <p
                                              class="text-muted title-dark mx-auto para-desc animated fadeInUpBig animation-delay-2">
                                              Jangan lewatkan update berita terbaru dari kami!</p>
                                          <div class="mt-4 pt-2">
                                              <a href="{{ route('master.berita-index') }}"
                                                  class="btn btn-primary animated fadeInUpBig animation-delay-3">Baca
                                                  Sekarang</a>
                                          </div>
                                          <div class="position-absolute top-0 start-0 translate-middle">
                                              <img src="{{ asset('starty/images/shop/rounded-shape.png') }}" class="mover"
                                                  alt="">
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                      aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                      aria-label="Slide 2"></button>
              </div>
          </div>
      </section><!--end section-->
      <!-- Hero End -->

      <!-- Start Berita Terbaru -->
      <section class="section pt-5">

          <div class="container mt-100 mt-60">
              <div class="row justify-content-center">
                  <div class="col-12">
                      <div class="section-title text-center mb-4 pb-2">
                          <h4 class="title mb-3">Berita Terkini</h4>
                          {{-- <p class="text-muted para-desc mx-auto mb-0">Baca berita pilihan kami untuk informasi mendalam!
                          </p> --}}
                      </div>
                  </div>
              </div>
              <div class="row justify-content-center">
                  @foreach ($berita as $list)
                      <div class="col-lg-4 col-md-6 mt-4 pt-2">
                          <div class="card blog blog-primary shadow rounded overflow-hidden">
                              <div class="image position-relative overflow-hidden">
                                  <img src="{{ asset('starty/images/blog/01.jpg') }}" class="img-fluid" alt="">
                                  <div class="blog-tag">
                                      <a href="#"
                                          class="badge text-bg-light">{{ \Carbon\Carbon::parse($list->created_at)->translatedFormat('d F Y') }}</a>
                                  </div>
                              </div>
                              <div class="card-body content">
                                  <a href="#" class="h5 title text-dark d-block mb-0">{{ $list->judul }}</a>
                                  <p class="text-muted mt-2 mb-2">{!! Str::limit($list->isi_berita, 40) !!}</p>
                                  <a href="#" class="link text-dark">Baca Selengkapnya <i
                                          class="uil uil-arrow-right align-middle"></i></a>
                              </div>
                          </div>
                      </div>
                  @endforeach

              </div>
          </div>
      </section><!--end section-->
      <!-- End Berita Terbaru -->
  @endsection
