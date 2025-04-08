@extends('user.layouts.master')

@section('content')
    <section id="team" class="team section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Dokter Kami</h2>
            <p>
                Necessitatibus eius consequatur ex aliquid fuga eum quidem sint
                consectetur velit
            </p>
        </div>

        <div class="container">
            <div class="row gy-4 justify-content-center">
                @foreach ($doctors as $doctor)
                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                        <div class="member">
                            <img src="{{ $doctor->foto_dokter }}" class="img-fluid" alt="" />
                            <h4>{{ $doctor->nama_depan }} {{ $doctor->nama_belakang }}</h4>
                            <span>Dokter {{ $doctor->spesialisasi }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
