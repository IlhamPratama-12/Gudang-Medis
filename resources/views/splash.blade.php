<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Loading Sistem</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .spinner {
            width: 80px;
            height: 80px;
            border: 6px solid #e5e7eb;
            border-top: 6px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body class="bg-gray-900 flex items-center justify-center h-screen text-white">

<div class="text-center">

    {{-- LOGO --}}
    <img src="{{ asset('image/logo/logo_rsud_rt_notopuro.png') }}"
         class="w-24 mx-auto mb-5">

    {{-- SPINNER --}}
    <div class="spinner mx-auto mb-5"></div>

    <h1 class="text-xl font-bold">Masuk ke Sistem SIMAK</h1>
    <p class="text-gray-400 text-sm mt-1">Mohon tunggu sebentar...</p>

</div>

<script>
    setTimeout(() => {

        const role = "{{ $role }}";

        switch (role) {
            case 'admin':
                window.location.href = "/dashboard";
                break;

            case 'petugas':
                window.location.href = "/dashboard";
                break;

            case 'manajemen':
                window.location.href = "/manajemen/dashboard";
                break;

            default:
                window.location.href = "/dashboard";
        }

    }, 1500);
</script>

</body>
</html>