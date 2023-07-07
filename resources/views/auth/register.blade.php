<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Poppins" rel="stylesheet">
    <!-- Scripts -->
    <link href='https://unpkg.com/boxicons@2.1.1/dist/boxicons.js' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <main class="flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 my-5">
                    <div class="card my-5">

                        <div class="card-body ">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row mb-3 py-2">
                                    <div class="col lg-6">
                                        <img src="img/logo.png" class="d-block mx-lg-auto img-fluid"
                                            alt="Bootstrap Themes" width="180" height="380" loading="lazy">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="name" class="col-md-6">{{ __('Name') }}</label>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label for="email" class="col-md-6">{{ __('Email Address') }}</label>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row mb-2">
                                    <label for="password" class="col-md-6">{{ __('Password') }}</label>
                                </div>
                                <div class="row mb-2">
                                    <div class="col form-password-toggle">
                                        <div class="input-group input-group-merge">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <span id="mybutton" onclick="change()" class="input-group-text">
                                                <i class='bx bx-hide'></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label for="password-confirm" class="col-md-6">{{ __('Confirm Password') }}</label>
                                </div>
                                <div class="row mb-3">
                                    <div class="col form-password-toggle">
                                        <div class="input-group input-group-merge">
                                            <input id="password-confirm" type="password" class="form-control"
                                                name="password_confirmation" required autocomplete="new-password">
                                            <span id="mybuttons" onclick="changes()" class="input-group-text">
                                                <i class='bx bx-hide'></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary active">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="col text-center">Have an account?<a class="btn btn-link link-primary active"
                                        href="{{ route('login') }}">
                                        {{ __('Login') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        function change() {
            var x = document.getElementById('password').type;

            if (x == 'password') {

                document.getElementById('password').type = 'text';
                document.getElementById('mybutton').innerHTML = `<i class='bx bx-show'></i>`;
            } else {

                document.getElementById('password').type = 'password';
                document.getElementById('mybutton').innerHTML = `<i class='bx bx-hide' ></i>`;
            }
        }
    </script>
    <script>
        function changes() {
            var x = document.getElementById('password-confirm').type;

            if (x == 'password') {

                document.getElementById('password-confirm').type = 'text';
                document.getElementById('mybuttons').innerHTML = `<i class='bx bx-show'></i>`;
            } else {

                document.getElementById('password-confirm').type = 'password';
                document.getElementById('mybuttons').innerHTML = `<i class='bx bx-hide' ></i>`;
            }
        }
    </script>
</body>

</html>
