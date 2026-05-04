<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMAK</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen bg-cover bg-center flex items-center justify-center"
      style="background-image: url('{{ asset('image/background/RSUD_bg.jpeg') }}');">

<div class="bg-white/80 backdrop-blur-md shadow-xl rounded-2xl w-[400px] p-8">

    <!-- LOGO -->
    <div class="flex justify-center mb-6">
        <img src="{{ asset('image/logo/logo_rsud_rt_notopuro.png') }}"
            class="w-8 h-8 rounded">
    </div>

    <h2 class="text-center text-2xl font-bold text-gray-900">
        Sign in with email
    </h2>

    <p class="text-center text-gray-500 text-sm mb-6">
        Masukkan email dan password untuk masuk ke dashboard
    </p>

    {{-- ERROR MESSAGE --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 text-sm p-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf

        <!-- EMAIL -->
        <input type="email"
               name="email"
               placeholder="Email"
               value="{{ old('email') }}"
               required autofocus
               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-400">

        <!-- PASSWORD -->
        <div class="relative">
            <input id="password"
                   type="password"
                   name="password"
                   placeholder="Password"
                   required
                   class="w-full px-4 py-2 border rounded-lg pr-10 focus:ring-2 focus:ring-sky-400">

            <button type="button"
                    onclick="togglePassword()"
                    class="absolute right-3 top-2.5 text-gray-500">
                👁
            </button>
        </div>

        <!-- REMEMBER ME -->
        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2 text-gray-600">
                <input type="checkbox"
                       name="remember"
                       class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                Remember me
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sky-600 hover:underline">
                    Lupa password?
                </a>
            @endif
        </div>

        <!-- SUBMIT -->
        <button type="submit"
            class="w-full bg-black text-white py-2 rounded-lg font-semibold hover:bg-gray-800 transition">
            Login
        </button>

        <!-- 🔥 REGISTER LINK -->
        <div class="text-center mt-4">
            <p class="text-sm text-gray-500">
                Belum punya akun?
            </p>
            <a href="{{ route('register.form') }}"
               class="text-sm font-semibold text-sky-600 hover:underline">
                Daftar di sini
            </a>
        </div>

    </form>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>

</body>
</html>