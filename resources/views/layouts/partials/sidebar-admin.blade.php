<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-sm flex flex-col h-full border-r border-gray-100 transform -translate-x-full lg:relative lg:translate-x-0 transition-transform duration-300 ease-in-out">
    
    <div class="h-16 flex items-center justify-between px-6 border-b border-gray-50">
        <div class="flex items-center gap-3 text-primary">
            <i class="fa-solid fa-medal text-2xl"></i>
            <div>
                <h1 class="font-bold text-sm leading-tight text-gray-800">Prestasi</h1>
                <p class="text-[10px] text-gray-500">Siswa & Alumni</p>
            </div>
        </div>
        <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-red-500">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <div class="p-4 mx-4 mt-4 bg-gray-50 rounded-lg flex items-center gap-3">
        <img src="https://ui-avatars.com/api/?name=Admin+TU&background=eff6ff&color=3b82f6" alt="User Avatar" class="w-10 h-10 rounded-full">
        <div class="overflow-hidden">
            <p class="text-sm font-semibold text-gray-800 truncate">Admin TU</p>
            <p class="text-xs text-gray-500 truncate">Tata Usaha</p>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto mt-4 px-4 pb-4 space-y-1">
        
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors mb-2
                  {{ request()->routeIs('admin.dashboard') ? 'bg-primary-light text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
            <i class="fa-solid fa-house w-5 text-center"></i> Dashboard
        </a>

        @php
            $isMasterActive = request()->routeIs('admin.siswa.*', 'admin.kelas.*', 'admin.tahun-ajaran.*');
        @endphp
        
        <div>
            <button onclick="document.getElementById('dropdown-master').classList.toggle('hidden'); document.getElementById('icon-master').classList.toggle('rotate-90');"
                    class="w-full flex justify-between items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $isMasterActive ? 'text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-folder-open w-5 text-center"></i> 
                    <span>Data Master</span>
                </div>
                <i id="icon-master" class="fa-solid fa-chevron-right text-[10px] transition-transform duration-200 {{ $isMasterActive ? 'rotate-90' : '' }}"></i>
            </button>

            <div id="dropdown-master" class="mt-1 space-y-1 pl-4 {{ $isMasterActive ? '' : 'hidden' }}">
                <a href="{{ route('admin.siswa.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                  {{ request()->routeIs('admin.siswa.*') ? 'bg-primary-light text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                    <i class="fa-solid fa-users w-5 text-center"></i> Manajemen Siswa
                </a>
                
                <a href="{{ route('admin.kelas.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                  {{ request()->routeIs('admin.kelas.*') ? 'bg-primary-light text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                    <i class="fa-solid fa-chalkboard-user w-5 text-center"></i> Master Kelas
                </a>

                <a href="{{ route('admin.tahun-ajaran.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                  {{ request()->routeIs('admin.tahun-ajaran.*') ? 'bg-primary-light text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                    <i class="fa-solid fa-calendar-alt w-5 text-center"></i> Tahun Ajaran
                </a>
            </div>
        </div>

        @php
            $isPrestasiActive = request()->routeIs('admin.kategori.*', 'admin.tingkat.*');
        @endphp
        
        <div class="mt-2 mb-2">
            <button onclick="document.getElementById('dropdown-prestasi').classList.toggle('hidden'); document.getElementById('icon-prestasi').classList.toggle('rotate-90');"
                    class="w-full flex justify-between items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $isPrestasiActive ? 'text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-trophy w-5 text-center"></i> 
                    <span>Modul Prestasi</span>
                </div>
                <i id="icon-prestasi" class="fa-solid fa-chevron-right text-[10px] transition-transform duration-200 {{ $isPrestasiActive ? 'rotate-90' : '' }}"></i>
            </button>

            <div id="dropdown-prestasi" class="mt-1 space-y-1 pl-4 {{ $isPrestasiActive ? '' : 'hidden' }}">
                <a href="{{ route('admin.kategori.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                          {{ request()->routeIs('admin.kategori.*') ? 'bg-primary-light text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                    <i class="fa-solid fa-tags w-5 text-center"></i> Kategori Prestasi
                </a>
                
                <a href="{{ route('admin.tingkat.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                          {{ request()->routeIs('admin.tingkat.*') ? 'bg-primary-light text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                    <i class="fa-solid fa-layer-group w-5 text-center"></i> Tingkat Lomba
                </a>
            </div>
        </div>

        <a href="{{ route('admin.prestasi.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
          {{ request()->routeIs('admin.prestasi.*') ? 'bg-primary-light text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
            <i class="fa-solid fa-medal w-5 text-center"></i> Data Prestasi
        </a>

        <a href="{{ route('admin.validasi.index') }}"
            class="flex justify-between items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
          {{ request()->routeIs('admin.validasi.*') ? 'bg-primary-light text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-check-double w-5 text-center"></i> Status Validasi
            </div>
            @php $pendingMenuCount = \App\Models\Prestasi::where('status', 'pending')->count(); @endphp
            @if ($pendingMenuCount > 0)
                <span class="bg-orange-100 text-orange-600 py-0.5 px-2 rounded-full text-[10px] font-bold">{{ $pendingMenuCount }}</span>
            @endif
        </a>
        
        <a href="{{ route('admin.laporan.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
          {{ request()->routeIs('admin.laporan.*') ? 'bg-primary-light text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
            <i class="fa-solid fa-file-export w-5 text-center"></i> Laporan & Export
        </a>

        <div class="mt-2 pt-2 border-t border-gray-100">
            <a href="{{ route('admin.pengaturan.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('admin.pengaturan.*') ? 'bg-primary-light text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                <i class="fa-solid fa-sliders w-5 text-center"></i> Pengaturan
            </a>
        </div>


        <div class="pt-4 mt-4 border-t border-gray-100 space-y-1">
            <a href="{{ route('admin.notifikasi.index') }}"
                class="flex justify-between items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
          {{ request()->routeIs('admin.notifikasi.*') ? 'bg-primary-light text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-regular fa-bell w-5 text-center"></i> Notifikasi
                </div>
                @php $unreadCountSidebar = auth()->user()->unreadNotifications->count(); @endphp
                @if ($unreadCountSidebar > 0)
                    <span class="bg-red-100 text-red-600 py-0.5 px-2 rounded-full text-[10px] font-bold">{{ $unreadCountSidebar }}</span>
                @endif
            </a>
            
            <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            <button onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();" class="w-full flex items-center gap-3 px-3 py-2.5 text-red-600 hover:bg-red-50 rounded-lg text-sm font-medium transition-colors mt-2">
                <i class="fa-solid fa-sign-out-alt w-5 text-center"></i> Keluar
            </button>
        </div>
        
    </nav>
</aside>