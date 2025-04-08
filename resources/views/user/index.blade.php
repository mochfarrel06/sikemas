@extends('user.layouts.master')

@section('content')
    <section id="hero" class="hero section">
        <div class="container position-relative">
            <div class="row gy-5 justify-content-between">
                <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
                    <h2>Lindungi Kesehatan Gigi Andi</h2>
                    <p>Kami Menyediakan Solusi Perawatan Kesehatan Gigi</p>
                    <div class="d-flex">
                        <a href="#about" class="btn-get-started">Ayo Ambil Antrian</a>
                    </div>
                </div>
                <div class="col-lg-5 order-1 order-lg-2 d-flex justify-content-center">
                    <img src="{{ asset('assets/user/img/hero/coba2.svg') }}" class="img-fluid" alt="" />
                </div>
            </div>
        </div>

        <div class="icon-boxes position-relative" data-aos="fade-up" data-aos-delay="200">
            <div class="container position-relative">
                <div class="row gy-4 mt-5">
                    <div class="col-xl-4 col-md-6">
                        <div class="icon-box">
                            <h4 class="title">
                                <a href="" class="stretched-link">SISTEM ANTREAN ONLINE DENTHIS.PLUS</a>
                                <p class="desk-card">
                                    Dapatkan kemudahan dalam mengatur jadwal kunjungan Anda
                                    dengan sistem antrean online Klinik Gigi kami! Pesan
                                    jadwal kapan saja dan di mana saja melalui website atau
                                    aplikasi kami, tanpa perlu antre panjang.
                                </p>
                            </h4>
                        </div>
                    </div>
                    <!--End Icon Box -->

                    <div class="col-xl-4 col-md-6">
                        <div class="icon-box">
                            <div class="icon"><i class="bi bi-gem"></i></div>
                            <h4 class="title">
                                <a href="" class="stretched-link">Klinik Gigi</a>
                                <p class="desk-card">
                                    Klinik Gigi Sehat adalah solusi terpercaya untuk perawatan
                                    kesehatan gigi dan mulut Anda. Dengan layanan profesional
                                    seperti pembersihan karang gigi, tambal gigi, hingga
                                    pemasangan behel.
                                </p>
                            </h4>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="icon-box">
                            <div class="icon"><i class="bi bi-hospital"></i></div>
                            <h4 class="title">
                                <a href="" class="stretched-link">Dokter Spesialis Gigi</a>
                                <p class="desk-card">
                                    Layanan Dokter Spesialis Gigi yang berpengalaman dalam menangani berbagai
                                    permasalahan gigi, mulai dari pencabutan gigi bungsu, perawatan saluran akar,
                                    hingga pemasangan gigi palsu dengan teknologi terbaru.
                                </p>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Tentang Kami<br /></h2>
            <p>
                Selamat datang di DENTHIS.PLUS, tempat di mana senyum Anda menjadi
                prioritas kami! Kami adalah klinik gigi yang didedikasikan untuk
                memberikan perawatan kesehatan gigi dan mulut terbaik kepada setiap
                pasien.
            </p>
        </div>
        <!-- End Section Title -->

        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <h3>
                        Dengan tim dokter gigi profesional, teknologi modern, dan
                        lingkungan yang nyaman,
                    </h3>
                    <img src="{{ asset('assets/user/img/about/about2.jpg') }}" class="img-fluid rounded-4 mb-4"
                        alt="" />
                    <p>
                        kami berkomitmen untuk menghadirkan pengalaman perawatan gigi
                        yang aman, ramah, dan berkualitas tinggi. Layanan kami mencakup
                        perawatan umum, estetika, hingga spesialis, dirancang untuk
                        memenuhi kebutuhan Anda dengan standar terbaik.
                    </p>
                </div>
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="250">
                    <div class="content ps-0 ps-lg-5">
                        <p class="fst-italic">
                            Kami percaya bahwa senyuman yang sehat adalah kunci
                            kepercayaan diri. Bersama kami, wujudkan senyuman indah dan
                            sehat yang selalu Anda impikan! Kunjungi kami dan rasakan
                            perbedaan
                        </p>
                        <div class="position-relative mt-4">
                            <img src="{{ asset('assets/user/img/about/about1.jpg') }}" class="img-fluid rounded-4"
                                alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /About Section -->

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
    <!-- /Services Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Kontak</h2>
            <p>
                Kami siap membantu Anda merawat kesehatan gigi dan mulut Anda.
                Jangan ragu untuk menghubungi kami atau mengunjungi klinik kami.
            </p>
        </div>
        <!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gx-lg-0 gy-4">
                <div class="col-lg-4">
                    <div class="info-container d-flex flex-column align-items-center justify-content-center">
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Alamat</h3>
                                <p>Kediri</p>
                            </div>
                        </div>
                        <!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Nomor</h3>
                                <p>+628233222832</p>
                            </div>
                        </div>
                        <!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Email Us</h3>
                                <p>denthis.plus@gmail.com</p>
                            </div>
                        </div>
                        <!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                            <i class="bi bi-clock flex-shrink-0"></i>
                            <div>
                                <h3>Jam Buka</h3>
                                <p>Senin-Minggu: 08.00 - 16:00</p>
                            </div>
                        </div>
                        <!-- End Info Item -->
                    </div>
                </div>

                <div class="col-lg-8">
                    <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade"
                        data-aos-delay="100">
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap"
                                    required="" />
                            </div>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" placeholder="Email"
                                    required="" />
                            </div>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="subject" placeholder="Subject"
                                    required="" />
                            </div>

                            <div class="col-md-12">
                                <textarea class="form-control" name="message" rows="8" placeholder="Pesan" required=""></textarea>
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">
                                    Your message has been sent. Thank you!
                                </div>

                                <button type="submit">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End Contact Form -->
            </div>
        </div>
    </section>
    <!-- /Contact Section -->
@endsection
