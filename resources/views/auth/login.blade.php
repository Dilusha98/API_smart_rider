<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <style>
body {
    font-family: 'figtree', sans-serif;
    background-color: #f3f4f6;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.card {
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* light gray shadow */
    background-color: #fff;
    padding: 30px;
    width: 100%;
    max-width: 400px;
}

.card-title {
    margin-bottom: 20px;
    font-size: 24px;
    text-align: center;
    color: #333;
    font-weight: bold; /* thicker font */
}

.form-label {
    font-weight: bold; /* thicker font */
    color: #555;
    margin-bottom: 8px; /* add margin bottom */
}

.form-control {
    width: calc(100% - 24px);
    padding: 10px;
    border: 2px solid #ccc; /* light gray border */
    border-radius: 5px;
    transition: border-color 0.3s;
    background-color: #fff; /* white background */
    font-weight: bold; /* thicker font */
    color: #555; /* gray font color */
}

.inputDiv{
    margin-bottom: 20px;
}

.form-control:focus {
    border-color: #a080f0; /* light purple border when focused */
    outline: none;
}

.form-check-label {
    font-weight: normal;
    color: #555;
}

.btn-primary {
    width: 100%;
    padding: 10px;
    font-weight: bold;
    border-radius: 5px;
    background-color: #000; /* matt black background */
    border: none;
    cursor: pointer;
    color: #fff;
    transition: background-color 0.3s;
}

.btn-primary:hover {
    background-color: #333; /* darker black on hover */
}

#logo {
    display: block;
    margin: 0 auto 20px;
    width: 150px;
    height: auto;
}

.text-danger{
    color: #DC3545;
}


        </style>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Test</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="card">
            <img src="/dist/img/logo.png" id="logo" alt="champions league" srcset="">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email Address -->
                <div class="mb-3 inputDiv">
                    @if ($errors->has('incorrect'))
                        <span class="text-danger form-label">{{ $errors->first('incorrect') }}</span>
                    @endif
                    <input id="email" class="form-control" type="text" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="User Name">
                </div>

                <!-- Password -->
                <div class="mb-3 inputDiv">
                    <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Password">
                </div>

                <!-- Remember Me -->
                {{-- <div class="mb-3 form-check">
                    <input id="remember_me" class="form-check-input" type="checkbox" name="remember">
                    <label class="form-check-label" for="remember_me">Remember me</label>
                </div> --}}

                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            </div>
        </div>
    </body>
</html>
