<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SIMAK</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen bg-cover bg-center flex items-center justify-center"
      style="background-image: url('{{ asset('image/background/RSUD_bg.jpeg') }}');">

<div class="bg-white/80 backdrop-blur-md shadow-xl rounded-2xl w-[400px] p-8">

    <!-- LOGO -->
    <div class="flex justify-center mb-6">
        <img src="{{ asset('image/logo/logo_rsud_rt_notopuro.png') }}"
             class="h-16 w-16 rounded-full shadow-md">
    </div>

    <!-- TITLE -->
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">
        Registrasi Akun
    </h2>

    <p class="text-center text-sm text-gray-500 mb-6">
        Setelah daftar, akun akan menunggu persetujuan admin.
    </p>

    <!-- ERROR -->
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 text-sm p-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- SUCCESS -->
    @if (session('success'))
        <div class="bg-green-100 text-green-700 text-sm p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- FORM -->
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- NAMA -->
        <input type="text" name="name" required
            placeholder="Nama Lengkap"
            value="{{ old('name') }}"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-400">

        <!-- NIP -->
        <input type="text" name="nip" required
            placeholder="NIP"
            value="{{ old('nip') }}"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-400">

        <!-- EMAIL -->
        <input type="email" name="email" required
            placeholder="Email"
            value="{{ old('email') }}"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-400">

        <!-- ROLE -->
        <select name="role" required
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-400">
            <option value="">-- Pilih Jabatan --</option>
            <option value="manajemen">Manajemen Gudang</option>
            <option value="petugas">Petugas Gudang</option>
        </select>

        <!-- SUBMIT -->
        <button type="submit"
            class="w-full bg-black text-white py-2 rounded-lg font-semibold hover:bg-gray-800">
            Daftar
        </button>
    </form>

    <!-- LOGIN LINK -->
    <div class="text-center mt-6">
        <a href="{{ route('login.form') }}"
           class="text-sm text-sky-600 hover:underline">
            Sudah punya akun? Login
        </a>
    </div>

</div>

</body>
</html>