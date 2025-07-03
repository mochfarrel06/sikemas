@extends('user.layouts.master')

@section('content')
    <section id="hero" class="hero section">
        <div class="container position-relative" >
            <div class="row gy-5 justify-content-between">
                <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
                    <h2>Sikemas</h2>
                    <p class="hero-description">
                        Revolusi pelayanan kesehatan digital yang menghubungkan admin, dokter, dan pasien dalam satu platform terintegrasi. 
                        Dengan akses mobile yang mudah untuk pasien, Sikemas hadir memberikan solusi kesehatan yang lebih efisien dan terjangkau.
                    </p>                
                </div>
                <div class="col-lg-4 order-1 order-lg-2 d-flex justify-content-center">
                    <img src="{{ asset('assets/user/img/hero/medical.png') }}" class="img-fluid" alt="" />
                </div>
            </div>
        </div>

    
    </section>
    <!-- /Hero Section -->

    <!-- Services Section -->
    <section id="services" class="services section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Proses Kerja</h2>
            <p>Bagaimana Kami Bekerja?</p>
        </div>
        <!-- End Section Title -->

        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-activity"></i>
                        </div>
                        <h3>Pendaftaran</h3>
                        <p>
                            Pasien dapat melakukan pendaftaran terlebih dahulu untuk melakukan perawatan
                        </p>
                    </div>
                </div>
                <!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-broadcast"></i>
                        </div>
                        <h3>Buat Janji Temu</h3>
                        <p>
                            Pasien dapat memesan janji temu dengan dokter di halaman pasien
                        </p>
                    </div>
                </div>
                <!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-easel"></i>
                        </div>
                        <h3>Lakukan Perawatan</h3>
                        <p>
                            Dokter dapat berinteraksi dengan pasien dan melakukan
                            perawatan terkait.
                        </p>
                    </div>
                </div>
                <!-- End Service Item -->
            </div>
        </div>
    </section>

    <!-- Mobile JKN Section -->
    <section class="mobile-jkn-section">
        <div class="decorative-elements">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="container">
                    <div class="download-section">
                        <div class="download-buttons">
                            <a href="#" class="download-btn">
                                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.71 19.5C17.88 20.74 17 21.95 15.66 21.97C14.32 22 13.89 21.18 12.37 21.18C10.84 21.18 10.37 21.95 9.09997 22C7.78997 22.05 6.79997 20.68 5.95997 19.47C4.24997 17 2.93997 12.45 4.69997 9.39C5.56997 7.87 7.13997 6.91 8.89997 6.88C10.1 6.86 11.25 7.75 12.12 7.75C12.98 7.75 14.31 6.68 15.87 6.84C16.65 6.87 18.4 7.18 19.56 8.82C19.47 8.88 17.39 10.1 17.41 12.63C17.44 15.65 20.06 16.66 20.09 16.67C20.06 16.74 19.67 18.11 18.71 19.5ZM13 3.5C13.73 2.67 14.94 2.04 15.94 2C16.07 3.17 15.6 4.35 14.9 5.19C14.21 6.04 13.07 6.7 11.95 6.61C11.8 5.46 12.36 4.26 13 3.5Z" fill="#333"/>
                                </svg>
                                <div class="btn-text">
                                    <small>Available on the</small>
                                    <span>App Store</span>
                                </div>
                            </a>

                            <a href="#" class="download-btn">
                                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.53,12.9 20.18,13.18L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z" fill="#333"/>
                                </svg>
                                <div class="btn-text">
                                    <small>Get it on</small>
                                    <span>Google Play</span>
                                </div>
                            </a>
                        </div>
                        
                        <div class="app-info">
                            <h1 class="app-title">Mobile Sikemas</h1>
                            <p class="app-description">
                                Segera unduh aplikasi Mobile Sikemas untuk memberikan kemudahan akses dan pelayanan yang optimal bagi peserta secara cepat dan mudah, dimanapun dan kapanpun.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
