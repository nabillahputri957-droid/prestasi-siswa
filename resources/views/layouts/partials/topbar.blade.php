<header class="bg-blue-200 h-16 border-b border-gray-100 flex items-center justify-between px-4 sm:px-6 shadow-sm z-10 shrink-0">
    
    <!-- Bagian Kiri: Tombol Menu Mobile & Judul -->
    <div class="flex items-center gap-3 sm:gap-4">
        <!-- Tombol Toggle Sidebar (Hanya tampil di Mobile/Tablet) -->
        <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-primary p-1 rounded-md focus:outline-none transition-colors">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>

        <div>
            <h2 class="text-base sm:text-lg font-semibold text-gray-800 truncate max-w-[150px] sm:max-w-full">
                @yield('header_title', 'Dashboard')
            </h2>
            <!-- Subtitle disembunyikan di HP agar tidak terlalu padat -->
            <p class="text-[10px] sm:text-xs text-gray-500 hidden sm:block truncate">
                @yield('header_subtitle', 'Ringkasan data prestasi siswa')
            </p>
        </div>
    </div>

    <!-- Bagian Kanan: Tahun Ajaran & Notifikasi -->
    <div class="flex items-center gap-3 sm:gap-6">
        
        <div class="flex flex-col items-end">
            <!-- Label disembunyikan di HP -->
            <span class="hidden sm:block text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Tahun Ajaran Aktif</span>
            @php
                $semuaTa = \App\Models\TahunAjaran::orderBy('tahun', 'desc')->get();
                $taAktif = $semuaTa->firstWhere('status', 'aktif');
            @endphp
            <select class="text-xs sm:text-sm font-medium text-gray-800 bg-transparent border-none focus:ring-0 cursor-pointer outline-none pr-6 sm:pr-8 py-1" disabled title="Tahun Ajaran Aktif (hanya baca)">
                @if($semuaTa->isEmpty())
                    <option value="">Belum Ada Data</option>
                @else
                    @foreach($semuaTa as $ta)
                        <option value="{{ $ta->id }}" {{ $ta->status == 'aktif' ? 'selected' : '' }}>{{ $ta->tahun }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="hidden sm:block h-8 w-px bg-gray-200"></div>

        <!-- Lonceng Notifikasi Dinamis (Menyesuaikan Role) -->
        @php 
            $notifRoute = auth()->user()->role == 'admin' ? route('admin.notifikasi.index') : route('kepsek.notifikasi.index');
        @endphp
        
        <a href="{{ $notifRoute }}" class="relative text-gray-400 hover:text-primary transition-colors p-1 mr-1 sm:mr-0">
            <i class="fa-regular fa-bell text-[1.35rem]"></i>
            
            @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
            @if($unreadCount > 0)
                <span class="absolute -top-1 -right-1.5 sm:-top-1.5 sm:-right-2 bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">
                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                </span>
            @endif
        </a>
        
    </div>
</header>