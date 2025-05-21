  @extends('layouts.front')
  @section('content')
      <!-- Start Hero -->
      <section class="bg-half-170 bg-light bg-gradient">
          <div class="container">
              <div class="row justify-content-center">
                  <div class="col-lg-10">
                      <div class="title-heading">
                          <h4 class="heading fw-semibold">{{ $data->judul }}</h4>

                          <!-- Baris Info Penulis & Tanggal -->
                          <div class="d-flex align-items-center justify-content-between mt-4 pb-4 border-bottom">
                              <!-- Informasi Penulis -->
                              <div class="d-flex author align-items-center">
                                  <img src="{{ asset('logo.png') }}" class="avatar avatar-md-sm rounded-pill" alt="">
                                  <div class="ms-2">
                                      <h6 class="user d-block mb-0">
                                          <a href="javascript:void(0)" class="text-dark">
                                              {{ $data->creator->name ?? '' }}
                                          </a>
                                      </h6>
                                      <small class="date text-muted mb-0">Content Writer</small>
                                  </div>
                              </div>

                              <!-- Tanggal dan Jam -->
                              <div class="text-end">
                                  <small class="text-muted d-flex align-items-center">
                                      <i class="uil uil-calendar h5 text-dark me-1 mb-0"></i>
                                      {{ \Carbon\Carbon::parse($data->created_at)->isoFormat('LLLL') }} WIB
                                  </small>
                              </div>
                          </div>
                      </div>

                      <!-- Gambar Konten -->
                      <div class="mt-5 text-center">
                          <img src="{{ asset('storage/' . $data->file_berita) }}" class="img-fluid rounded shadow"
                              alt="" style="display: inline-block; max-width: 800px;">
                      </div>

                      <!-- Isi Berita -->
                      <div class="mt-5">
                          {!! $data->isi_berita !!}
                      </div>
                  </div><!--end col-->
              </div><!--end row-->
          </div><!--end container-->
      </section><!--end section-->
  @endsection
