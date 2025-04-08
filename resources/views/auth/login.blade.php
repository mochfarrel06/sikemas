<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <link href="{{ asset('assets/user/img/hospital.svg') }}" rel="icon" />

    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/izitoast/css/iziToast.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a><b>DENTHIS.PLUS</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body" style="padding-bottom: 30px">
                <p class="login-box-msg">Login untuk memulai aplikasi</p>

                <form action="{{ route('login.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="Email" name="email" id="email" value="{{ old('email') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        @error('email')
                            <div class="text-danger" style="font-size: 0.8em">*{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" id="password" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        @error('password')
                            <div class="text-danger" style="font-size: 0.8em">*{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                </form>

                {{-- <p class="mb-1 mt-2">
                    <a href="{{ route('forgot-password') }}">Lupa Password?</a>
                </p> --}}
                <p class="mb-1 mt-1">
                    <a href="{{ route('register') }}">Buat akun baru?</a>
                </p>

                {{-- <div class="mt-3 text-center">
                    <button class="btn btn-secondary"
                        onclick="fillLogin('admin@example.com', '123456789')">Admin</button>
                    <button class="btn btn-secondary"
                        onclick="fillLogin('pasien@example.com', 'password')">Pasien</button>
                    <button class="btn btn-secondary"
                        onclick="fillLogin('dokter@example.com', 'password')">Dokter</button>
                </div> --}}
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/izitoast/js/iziToast.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if (session('success'))
                iziToast.success({
                    title: 'Berhasil',
                    message: '{{ session('success') }}',
                    position: 'topRight'
                });
            @endif

            @if (session('error'))
                iziToast.error({
                    title: 'Error',
                    message: '{{ session('error') }}',
                    position: 'topRight'
                });
            @endif

            @if (session('info'))
                iziToast.info({
                    title: 'Info',
                    message: '{{ session('info') }}',
                    position: 'topRight'
                });
            @endif
        });
    </script>

    <script>
        function fillLogin(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</body>

</html>
