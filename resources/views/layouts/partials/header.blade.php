<header
    class="fixed top-0 left-0 right-0 h-[60px]
           bg-white shadow z-50
           flex items-center justify-between px-6">

    {{-- LOGO + TOGGLE --}}
    <div class="flex items-center gap-3">
        <button onclick="toggleSidebar()"
            class="text-gray-600 hover:text-black">
            <i class="bi bi-list text-xl"></i>
        </button>

        <span class="font-bold text-lg">Gudang alkes</span>
    </div>

    {{-- USER --}}
    <div class="flex items-center gap-3">
        <span class="text-sm text-gray-600">
            {{ Auth::user()->name }}
        </span>
        <img class="w-9 h-9 rounded-full"
             src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4e73df&color=fff">
    </div>
</header>
