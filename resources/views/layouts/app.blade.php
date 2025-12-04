<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://dinsos.banjarmasinkota.go.id/favicon.ico" rel="icon" type="image/x-icon">
    <title>@yield('title', 'Dashboard')
        - Santunan Kematian
    </title>
    
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="dashboard-body">

    <div class="dashboard-container">
        
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="sidebar-logo-text">
                    SANTUNAN KEMATIAN
                </a>
            </div>

            <nav class="sidebar-nav">
                <ul class="nav-menu">
                    <li class="nav-item-header">MENU</li>
                    <li>
                        <a href="{{ route('dashboard') }}" 
                           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tahapans.index') }}" 
                           class="nav-link {{ (request()->routeIs('tahapans.*') || request()->routeIs('permohonans.*')) ? 'active' : '' }}">
                            <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span>Santunan Kematian</span>
                        </a>
                    </li>
                    @if(Auth::user()->isAdmin())
                        <li class="nav-item-header">ADMINISTRATOR</li>
                        <li>
                            <a href="{{ route('users.index') }}" 
                               class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z"/>
                                </svg>
                                <span>Pengguna</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" class="logout-button">
                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="main-content">
            
            <header class="main-header">
                <div class="header-title-breadcrumb">
                    <h1>@yield('page-title', 'Selamat Datang')</h1>
                    
                    <div class="header-breadcrumb">
                        @yield('breadcrumb')
                    </div>
                </div>

                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <div class="user-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A1.125 1.125 0 0 1 18.374 21H5.625a1.125 1.125 0 0 1-1.124-.882Z" />
                        </svg>
                    </div>
                </div>
            </header>

            <main class="page-content">
                @yield('content')
            </main>
        </div>
    </div>

    <div class="toast-container" id="toastContainer">
        </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            /**
             * Fungsi untuk menampilkan notifikasi toast
             * @param {string} message - Pesan yang akan ditampilkan
             * @param {string} type - 'success' atau 'error'
             */
            function showToast(message, type = 'success') {
                const toastContainer = document.getElementById('toastContainer');
                if (!toastContainer) return;

                const toast = document.createElement('div');
                toast.className = `toast toast-${type}`;
                
                // Ikon (opsional, bisa ditambah SVG)
                let icon = type === 'success' ? '✓' : 'X'; 
                
                toast.innerHTML = `<div class="toast-icon">${icon}</div> <div class="toast-message">${message}</div>`;
                
                toastContainer.appendChild(toast);

                // Tampilkan toast
                setTimeout(() => {
                    toast.classList.add('show');
                }, 100); // Sedikit delay untuk memicu transisi CSS

                // Sembunyikan dan hapus toast setelah 4 detik
                setTimeout(() => {
                    toast.classList.remove('show');
                    // Hapus elemen setelah transisi selesai
                    toast.addEventListener('transitionend', () => {
                        if (toast.parentNode) {
                            toast.parentNode.removeChild(toast);
                        }
                    });
                }, 4000);
            }

            // Cek jika ada pesan flash dari session PHP (Login, Tambah/Hapus User)
            const sessionSuccess = {!! json_encode(session('toast_success')) !!};
            const sessionError = {!! json_encode(session('toast_error')) !!};

            if (sessionSuccess) {
                showToast(sessionSuccess, 'success');
            }

            if (sessionError) {
                showToast(sessionError, 'error');
            }

        });
    </script>
</body>
</html>