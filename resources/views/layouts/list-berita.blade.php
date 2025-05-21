  @extends('layouts.front')
  @section('content')
      <!-- Start -->
      <section class="section">
          <div class="container">
              <div class="row">
                  @foreach ($data as $list)
                      <div class="col-lg-4 col-md-6 mb-4 pb-2">
                          <div class="card blog blog-primary shadow rounded overflow-hidden">
                              <div class="image position-relative overflow-hidden">
                                  <img src="{{ asset('storage/' . $list->file_berita) }}" class="img-fluid" alt="">

                                  <div class="blog-tag">
                                      <a href="javascript:void(0)" class="badge text-bg-light">
                                          {{ \Carbon\Carbon::parse($list->created_at)->isoFormat('DD MMMM YYYY') }}</a>
                                  </div>
                              </div>

                              <div class="card-body content">
                                  <a href="{{ route('detail-berita', $list->slug) }}"
                                      class="h5 title text-dark d-block mb-0">
                                      {{ $list->judul }}
                                  </a>
                                  <p class="text-muted mt-2 mb-2">{!! Str::limit($list->isi_berita, 40) !!}</p>
                                  <a href="{{ route('detail-berita', $list->slug) }}" class="link text-dark">Baca
                                      Selengkapnya<i class="uil uil-arrow-right align-middle"></i></a>
                              </div>
                          </div>
                      </div><!--end col-->
                  @endforeach



                  <div class="row mt-4">
                      <div class="col-12">
                          <div class="d-flex justify-content-center">
                              {{ $data->links('vendor.pagination.bootstrap-5') }}
                          </div>
                      </div>
                  </div>
              </div><!--end container-->
      </section><!--end section-->
      <!-- End -->
  @endsection
