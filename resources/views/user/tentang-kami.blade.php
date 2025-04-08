@extends('user.layouts.master')

@section('content')
    <section id="about" class="about section" style="margin-top: 5em; margin-bottom: 5em">
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
@endsection
