@extends('layouts.front')
@section('content')
    <!-- Hero Section: Bagian Header dengan Background -->
    <section class="bg-half-170 d-table w-100" style="background: url('images/bg/about.jpg') center;">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-1 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <!-- Judul Kecil -->
                        <small class="text-white-50 mb-1 fw-medium text-uppercase mx-auto">Hubungi</small>
                        <!-- Judul Utama -->
                        <h5 class="heading fw-semibold mb-0 page-heading text-white title-dark">Kontak Kami</h5>
                    </div>
                </div><!--end col-->
            </div><!--end row -->
        </div><!--end container -->
    </section><!--end section -->

    <!-- Main Content Section -->
    <section class="section pb-0">
        <div class="container">
            <div class="row">

                <!-- Kolom 1: Telepon -->
                <div class="col-md-4">
                    <div class="card border-0 text-center features feature-clean bg-transparent">
                        <div class="icons text-primary text-center mx-auto">
                            <i class="uil uil-phone d-block rounded h3 mb-0"></i>
                        </div>
                        <div class="content mt-3">
                            <h5 class="footer-head">Nomor Telepon</h5>
                            <p class="text-muted">Hubungi kami melalui saluran telepon untuk informasi lebih lanjut.</p>
                            <a href="tel:+6282220250005" class="text-foot">+62 822-2025-0005</a>
                        </div>
                    </div>
                </div>

                <!-- Kolom 2: Email -->
                <div class="col-md-4 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <div class="card border-0 text-center features feature-clean bg-transparent">
                        <div class="icons text-primary text-center mx-auto">
                            <i class="uil uil-envelope d-block rounded h3 mb-0"></i>
                        </div>
                        <div class="content mt-3">
                            <h5 class="footer-head">Alamat Email</h5>
                            <p class="text-muted">Kirim pesan atau pertanyaan melalui email resmi kami.</p>
                            <a href="mailto:dinsospm.wsb@gmail.com" class="text-foot">dinsospm.wsb@gmail.com</a>
                        </div>
                    </div>
                </div>

                <!-- Kolom 3: Lokasi -->
                <div class="col-md-4 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <div class="card border-0 text-center features feature-clean bg-transparent">
                        <div class="icons text-primary text-center mx-auto">
                            <i class="uil uil-map-marker d-block rounded h3 mb-0"></i>
                        </div>
                        <div class="content mt-3">
                            <h5 class="footer-head">Lokasi</h5>
                            <p class="text-muted">
                                Jl. Sabuk Alu No.35, Wonosobo Timur, Wonosobo Tim., Kec. Wonosobo, Kabupaten Wonosobo,
                                Jawa Tengah 56311
                            </p>
                            <a href="https://maps.app.goo.gl/u5eBbmSbVqhBT1Hv6" target="_blank">Lihat di Google Maps</a>
                        </div>
                    </div>
                </div>

            </div> <!-- end row -->
        </div> <!-- end container -->

        <!-- Peta Google Maps -->
        <div class="container-fluid mt-100 mt-60">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="card map border-0">
                        <div class="card-body p-0">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.976935393263!2d109.9061179!3d-7.3564815999999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7aa0571dded831%3A0x201e58d29aebb99c!2sDinas%20Sosial%2C%20Pemberdayaan%20Masyarakat%20Dan%20Desa!5e0!3m2!1sid!2sid!4v1747813082898!5m2!1sid!2sid"
                                style="border:0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container-fluid -->
    </section> <!-- end section -->
@endsection
