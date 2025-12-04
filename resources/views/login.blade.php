<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Santunan Kematian</title>
    
    <!-- Link ke CSS Utama -->
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
    
    <!-- Google Font (Poppins) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="login-body"> <!-- PASTIKAN CLASS INI ADA -->

    <div class="login-container">
        
        <!-- Kolom Kiri (Ilustrasi) -->
        <div class="left-panel">
            <div class="illustration">
                <!-- Ganti dengan gambar Anda -->
                <img src="{{ asset('images/logo_dinsos.png') }}" alt="Ilustrasi" style="width: 100%; max-width: 400px;">
            </div>
            <h1>Dinas Sosial</h1>
            <p>Maju Sejahtera, Terbaik!</p>
        </div>

        <!-- Kolom Kanan (Form Login) -->
        <div class="right-panel">
            <div class="login-form-container">
                <div class="logo">
                    SANTUNAN KEMATIAN
                </div>

                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf

                    <!-- Email (Diganti dari Username) -->
                    <div class="form-group-aligned">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <!-- Password -->
                    <div class="form-group-aligned">
                        <label for="password">Password</label>
                        <div class="password-wrapper">
                            <input id="password" type="password" name="password" required autocomplete="current-password">
                            <span id="togglePassword" class="toggle-password-icon">
                                <svg id="icon-show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639l4.43-4.44a1.012 1.012 0 0 1 1.433 0l4.43 4.44a1.012 1.012 0 0 1 0 .639l-4.43 4.44a1.012 1.012 0 0 1-1.433 0l-4.43-4.44Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <svg id="icon-hide" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243L6.228 6.228" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <a href="#" class="forgot-password-aligned">Forgot password?</a>
                    <button type="submit" class="btn btn-submit">Sign In</button>
                </form>

            </div>
        </div>

    </div>

    <!-- JavaScript untuk Toggle Password -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const iconShow = document.getElementById('icon-show');
            const iconHide = document.getElementById('icon-hide');

            if (togglePassword) {
                togglePassword.addEventListener('click', function (e) {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);

                    if (type === 'password') {
                        iconShow.style.display = 'block';
                        iconHide.style.display = 'none';
                    } else {
                        iconShow.style.display = 'none';
                        iconHide.style.display = 'block';
                    }
                });
            }
        });
    </script>

</body>
</html>