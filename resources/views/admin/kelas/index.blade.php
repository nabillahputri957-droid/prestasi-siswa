@extends('layouts.app')

@section('title', 'Manajemen Kelas')
@section('header_title', 'Master Data Kelas')
@section('header_subtitle', 'Kelola daftar kelas sekolah')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-5 border-b border-gray-50 flex justify-between items-center">
        <h3 class="text-gray-800 font-medium">Daftar Kelas</h3>
        <button onclick="openModal('modal-tambah')" class="bg-primary hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i> Tambah Kelas
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-medium w-16">No</th>
                    <th class="px-6 py-4 font-medium">Nama Kelas</th>
                    <th class="px-6 py-4 font-medium text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($kelas as $index => $item)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-500">{{ $kelas->firstItem() + $index }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $item->nama_kelas }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <button onclick="openEditModal({{ $item->id }}, '{{ $item->nama_kelas }}')" class="text-blue-500 hover:text-blue-700 transition-colors" title="Edit">
                                <i class="fa-regular fa-pen-to-square text-lg"></i>
                            </button>

                            <form action="{{ route('admin.kelas.destroy', $item->id) }}" method="POST" class="delete-form inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-500 hover:text-red-700 transition-colors btn-delete" title="Hapus">
                                    <i class="fa-regular fa-trash-can text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                        <i class="fa-regular fa-folder-open text-3xl mb-2 text-gray-300 block"></i>
                        Belum ada data kelas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-gray-50">{{ $kelas->links() }}</div>
</div>

<div id="modal-tambah" class="fixed inset-0 z-50 hidden bg-gray-900/10 backdrop-blur-md flex items-center justify-center transition-opacity">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 transform scale-95 transition-transform duration-300" id="modal-tambah-content">
        <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Tambah Kelas Baru</h3>
            <button type="button" onclick="closeModal('modal-tambah')" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
        </div>
        <form action="{{ route('admin.kelas.store') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kelas</label>
                <input type="text" name="nama_kelas" placeholder="Contoh: X IPA 1" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm transition-all">
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal('modal-tambah')" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2 bg-primary hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors shadow-sm focus:ring-4 focus:ring-blue-100">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit" class="fixed inset-0 z-50 hidden bg-gray-900/10 backdrop-blur-md flex items-center justify-center transition-opacity">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 transform scale-95 transition-transform duration-300" id="modal-edit-content">
        <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Edit Kelas</h3>
            <button type="button" onclick="closeModal('modal-edit')" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
        </div>
        <form id="form-edit" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kelas</label>
                <input type="text" name="nama_kelas" id="edit-nama-kelas" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm transition-all">
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal('modal-edit')" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2 bg-primary hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors shadow-sm focus:ring-4 focus:ring-blue-100">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        const content = document.getElementById(id + '-content');
        modal.classList.remove('hidden');
        // Sedikit delay agar animasi scale terlihat smooth
        setTimeout(() => {
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        const content = document.getElementById(id + '-content');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }

    function openEditModal(id, namaKelas) {
        document.getElementById('form-edit').action = `/admin/kelas/${id}`;
        document.getElementById('edit-nama-kelas').value = namaKelas;
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
                title: 'Hapus Kelas?',
                text: "Pastikan kelas ini tidak memiliki siswa!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('global-loader').classList.remove('hidden');
                    document.getElementById('global-loader').classList.add('flex');
                    form.submit();
                }
            })
        });
    });
</script>
@endsection