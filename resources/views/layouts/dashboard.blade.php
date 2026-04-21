<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    @include('layouts.partials.sidebar')

    {{-- MAIN AREA --}}
    <div id="mainContent"
         class="flex-1 ml-56 transition-all duration-300 flex flex-col">

        {{-- HEADER --}}
        @include('layouts.partials.header')

        {{-- CONTENT --}}
        <main class="flex-1 p-6 mt-[60px]">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        @include('layouts.partials.footer')

    </div>
</div>

{{-- SCRIPT GLOBAL --}}
<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('mainContent');
    const texts = document.querySelectorAll('.sidebar-text');

    sidebar.classList.toggle('w-56');
    sidebar.classList.toggle('w-16');

    content.classList.toggle('ml-56');
    content.classList.toggle('ml-16');

    texts.forEach(el => {
        el.classList.toggle('opacity-0');
        el.classList.toggle('w-0');
        el.classList.toggle('overflow-hidden');
    });
}
</script>

<style>
.sidebar-text {
    transition: all 0.3s ease;
    white-space: nowrap;
}
.menu-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 10px;
    border-radius: 8px;
    cursor: pointer;
}
.menu-item i {
    font-size: 1.1rem;
    min-width: 20px;
    text-align: center;
}
.menu-item:hover {
    background-color: rgba(255,255,255,0.1);
}
</style>

</body>
</html>
