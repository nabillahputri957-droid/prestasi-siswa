@extends('layouts.app')

@section('title', 'Master Tingkat Lomba')
@section('header_title', 'Master Tingkat Lomba')
@section('header_subtitle', 'Kelola pengelompokan tingkat prestasi (contoh: Nasional, Provinsi)')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-5 border-b border-gray-50 flex justify-between items-center">
        <h3 class="text-gray-800 font-medium">Daftar Tingkat Lomba</h3>
        <button onclick="openModal('modal-tambah')" class="bg-primary hover:bg-blue-200 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i> Tambah Tingkat
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-medium w-16">No</th>
                    <th class="px-6 py-4 font-medium">Nama Tingkat</th>
                    <th class="px-6 py-4 font-medium text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($tingkat as $index => $item)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-500">{{ $tingkat->firstItem() + $index }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $item->nama_tingkat }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <button onclick="openEditModal({{ $item->id }}, '{{ $item->nama_tingkat }}')" class="text-blue-500 hover:text-blue-700 transition-colors">
                                <i class="fa-regular fa-pen-to-square text-lg"></i>
                            </button>
                            <form action="{{ route('admin.tingkat.destroy', $item->id) }}" method="POST" class="delete-form inline-block">
                                @csrf @method('DELETE')
                                <button type="button" class="text-red-500 hover:text-red-700 transition-colors btn-delete"><i class="fa-regular fa-trash-can text-lg"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-6 py-8 text-center text-gray-500 italic">Belum ada data tingkat lomba.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-gray-50">{{ $tingkat->links() }}</div>
</div>

<div id="modal-tambah" class="fixed inset-0 z-50 hidden bg-gray-900/10 backdrop-blur-md flex items-center justify-center transition-opacity">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 transform scale-95 transition-transform duration-300" id="modal-tambah-content">
        <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Tambah Tingkat Lomba</h3>
            <button type="button" onclick="closeModal('modal-tambah')" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
        </div>
        <form action="{{ route('admin.tingkat.store') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Tingkat</label>
                <input type="text" name="nama_tingkat" placeholder="Contoh: Nasional, Provinsi, Kabupaten" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm transition-all">
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal('modal-tambah')" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2 bg-primary hover:bg-blue-200 text-white rounded-lg text-sm font-medium shadow-sm focus:ring-4 focus:ring-blue-100">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit" class="fixed inset-0 z-50 hidden bg-gray-900/10 backdrop-blur-md flex items-center justify-center transition-opacity">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 transform scale-95 transition-transform duration-300" id="modal-edit-content">
        <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Edit Tingkat Lomba</h3>
            <button type="button" onclick="closeModal('modal-edit')" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
        </div>
        <form id="form-edit" method="POST">
            @csrf @method('PUT')
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Tingkat</label>
                <input type="text" name="nama_tingkat" id="edit-nama" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm transition-all">
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal('modal-edit')" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2 bg-primary hover:bg-blue-200 text-white rounded-lg text-sm font-medium shadow-sm focus:ring-4 focus:ring-blue-100">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        const content = document.getElementById(id + '-content');
        modal.classList.remove('hidden');
        setTimeout(() => { content.classList.replace('scale-95', 'scale-100'); }, 10);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        const content = document.getElementById(id + '-content');
        content.classList.replace('scale-100', 'scale-95');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }

    function openEditModal(id, nama) {
        document.getElementById('form-edit').action = `/admin/tingkat/${id}`;
        document.getElementById('edit-nama').value = nama;
        openModal('modal-edit');
    }

    @if($errors->any()) 
        Swal.fire({ 
            icon: 'error', 
            title: 'Validasi Gagal', 
            text: '{{ $errors->first() }}', 
            confirmButtonColor: '#3b82f6' 
        }); 
    @endif

    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                title: 'Hapus Data?', 
                icon: 'warning', 
                showCancelButton: true, 
                confirmButtonColor: '#ef4444', 
                cancelButtonColor: '#9ca3af', 
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => { 
                if (result.isConfirmed) form.submit(); 
            })
        });
    });
</script>
@endsection