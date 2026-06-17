@extends('layouts.app')

@section('title', 'Manajemen Siswa')
@section('header_title', 'Manajemen Siswa')
@section('header_subtitle', 'Kelola data siswa aktif dan alumni')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-5 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <form action="{{ route('admin.siswa.index') }}" method="GET" class="w-full md:w-1/3">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NISN atau Nama..." 
                       class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
            </div>
        </form>
        
        <button onclick="openSiswaModal('tambah')" class="bg-primary hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i> Tambah Siswa
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-medium">No</th>
                    <th class="px-6 py-4 font-medium">NISN</th>
                    <th class="px-6 py-4 font-medium">Nama Siswa</th>
                    <th class="px-6 py-4 font-medium text-center">Kelas</th>
                    <th class="px-6 py-4 font-medium">Tahun Ajaran</th>
                    <th class="px-6 py-4 font-medium text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($siswa as $index => $item)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-500">{{ $siswa->firstItem() + $index }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $item->nisn }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $item->nama }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 rounded text-xs {{ $item->kelas ? 'bg-blue-50 text-blue-600' : 'bg-gray-50 text-gray-400 italic' }}">
                            {{ $item->kelas->nama_kelas ?? 'Tanpa Kelas' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $item->tahunAjaran->tahun ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <button onclick="openEditSiswaModal({{ json_encode($item) }})" class="text-blue-500 hover:text-blue-700 transition-colors">
                                <i class="fa-regular fa-pen-to-square text-lg"></i>
                            </button>
                            <form action="{{ route('admin.siswa.destroy', $item->id) }}" method="POST" class="inline-block">
                                @csrf @method('DELETE')
                                <button type="button" class="text-red-500 hover:text-red-700 btn-delete">
                                    <i class="fa-regular fa-trash-can text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400 italic">Data siswa tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-gray-50">{{ $siswa->links() }}</div>
</div>

<div id="modal-siswa" class="fixed inset-0 z-50 hidden bg-gray-900/10 backdrop-blur-md flex items-center justify-center transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-8 transform scale-95 transition-transform duration-300" id="modal-siswa-content">
        <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6">
            <h3 class="text-xl font-bold text-gray-800" id="modal-title">Tambah Siswa</h3>
            <button type="button" onclick="closeSiswaModal()" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
        </div>
        
        <form id="form-siswa" method="POST">
            @csrf
            <div id="method-field"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">NISN</label>
                    <input type="text" name="nisn" id="input-nisn" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm transition-all">
                </div>

                <div class="md:col-span-1" style="display:none;">
                    <input type="hidden" name="status" value="aktif">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" id="input-nama" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm transition-all">
                </div>

                <div class="md:col-span-1" id="container-kelas">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kelas</label>
                    <select name="kelas_id" id="input-kelas" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm transition-all">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-1" id="container-ta">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tahun Ajaran</label>
                    <select name="tahun_ajaran_id" id="input-ta" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm transition-all">
                        <option value="">-- Pilih TA --</option>
                        @foreach($tahunAjaran as $ta)
                            <option value="{{ $ta->id }}">{{ $ta->tahun }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-10">
                <button type="button" onclick="closeSiswaModal()" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="px-8 py-2.5 bg-primary hover:bg-blue-600 text-white rounded-xl text-sm font-semibold transition-colors shadow-lg shadow-blue-100">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('modal-siswa');
    const content = document.getElementById('modal-siswa-content');
    const form = document.getElementById('form-siswa');
    const containerKelas = document.getElementById('container-kelas');

    function openSiswaModal(type) {
        modal.classList.remove('hidden');
        setTimeout(() => content.classList.replace('scale-95', 'scale-100'), 10);
        
        if (type === 'tambah') {
            document.getElementById('modal-title').innerText = "Tambah Siswa Baru";
            form.action = "{{ route('admin.siswa.store') }}";
            document.getElementById('method-field').innerHTML = "";
            form.reset();
        }
    }

    // Auto-Fill via NISN (AJAX)
    document.getElementById('input-nisn').addEventListener('input', function() {
        const nisn = this.value;
        if (nisn.length >= 5) {
            fetch(`/admin/siswa/search?nisn=${nisn}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const siswa = data.data;
                        document.getElementById('input-nama').value = siswa.nama;
                        
                        // Change form to edit mode dynamically
                        document.getElementById('modal-title').innerText = "Update Data Siswa (Ditemukan)";
                        form.action = `/admin/siswa/${siswa.id}`;
                        document.getElementById('method-field').innerHTML = '@method("PUT")';
                    } else {
                        // Reset if not found but was previously found
                        if (form.action.includes('/admin/siswa/')) {
                            document.getElementById('modal-title').innerText = "Tambah Siswa Baru";
                            form.action = "{{ route('admin.siswa.store') }}";
                            document.getElementById('method-field').innerHTML = "";
                        }
                    }
                });
        }
    });

    function openEditSiswaModal(siswa) {
        openSiswaModal('edit');
        document.getElementById('modal-title').innerText = "Edit Data Siswa";
        form.action = `/admin/siswa/${siswa.id}`;
        document.getElementById('method-field').innerHTML = '@method("PUT")';
        
        // Fill values
        document.getElementById('input-nisn').value = siswa.nisn;
        document.getElementById('input-nama').value = siswa.nama;
        document.getElementById('input-kelas').value = siswa.kelas_id ?? "";
        document.getElementById('input-ta').value = siswa.tahun_ajaran_id;
    }

    function closeSiswaModal() {
        content.classList.replace('scale-100', 'scale-95');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }

    // SweetAlert Handling for Validation Errors from controller
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $errors->first() }}',
            confirmButtonColor: '#3b82f6'
        });
    @endif

    // Hapus confirmation
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data siswa akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if (result.isConfirmed) this.closest('form').submit();
            });
        });
    });
</script>
@endsection