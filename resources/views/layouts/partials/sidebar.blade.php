<aside id="sidebar"
    class="fixed top-0 left-0 h-screen w-56 bg-gray-900 text-white
           transition-all duration-300 z-50 flex flex-col">

    {{-- LOGO + TOGGLE --}}
    <div class="h-[60px] flex items-center justify-between px-4 border-b border-gray-700">
        <div class="flex items-center gap-2">
            <img src="{{ asset('logo/intel amfibi.png') }}"
                 class="w-8 h-8 rounded">
            <span class="sidebar-text font-bold text-lg">SIMAK</span>
        </div>

        <button onclick="toggleSidebar()"
            class="text-gray-400 hover:text-white">
            <i class="bi bi-list text-xl"></i>
        </button>
    </div>

    {{-- MENU --}}
    <nav class="flex-1 px-3 py-4 space-y-6 text-sm">

        @role('admin')
        <div>
            <p class="sidebar-text text-xs text-gray-400 mb-2">ADMIN</p>
            <ul class="space-y-1">

                <a href="{{ route('dashboard') }}"
                   class="menu-item {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span class="sidebar-text">Dashboard Admin</span>
                </a>

                <a href="{{ route('approval.index') }}"
                   class="menu-item {{ request()->routeIs('approval.*') ? 'bg-gray-700' : '' }}">
                    <i class="bi bi-person-check"></i>
                    <span class="sidebar-text">User Approval</span>
                </a>

                <a href="#"
                   class="menu-item">
                    <i class="bi bi-gear"></i>
                    <span class="sidebar-text">Settings</span>
                </a>

            </ul>
        </div>
        @endrole

        @hasanyrole('manajemen|admin')
        <div>
            <p class="sidebar-text text-xs text-gray-400 mb-2">MANAJEMEN</p>
            <ul class="space-y-1">
                <a href="#" class="menu-item">
                    <i class="bi bi-box-seam"></i>
                    <span class="sidebar-text">Mlis 1</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bi bi-clipboard-data"></i>
                    <span class="sidebar-text">Mlis 2</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bi bi-journal-text"></i>
                    <span class="sidebar-text">Mlis 3</span>
                </a>
            </ul>
        </div>
        @endhasanyrole

        @hasanyrole('petugas|admin')
        <div>
            <p class="sidebar-text text-xs text-gray-400 mb-2">PETUGAS</p>
            <ul class="space-y-1">
                <a href="#" class="menu-item">
                    <i class="bi bi-truck"></i>
                    <span class="sidebar-text">Glis 1</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bi bi-box"></i>
                    <span class="sidebar-text">Glis 2</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bi bi-check2-circle"></i>
                    <span class="sidebar-text">Glis 3</span>
                </a>
            </ul>
        </div>
        @endhasanyrole
    </nav>

    {{-- LOGOUT --}}
    <form action="{{ route('logout') }}" method="POST"
          class="px-4 py-3 border-t border-gray-700">
        @csrf
        <button type="submit"
            class="menu-item text-red-400 hover:text-red-300 w-full">
            <i class="bi bi-box-arrow-right"></i>
            <span class="sidebar-text">Logout</span>
        </button>
    </form>
</aside>