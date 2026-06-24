@extends('layouts.app')

@section('title', 'Manajemen Tahun Ajaran')
@section('header_title', 'Manajemen Tahun Ajaran')
@section('header_subtitle', 'Kelola data tahun ajaran sekolah')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-5 border-b border-gray-50 flex justify-between items-center">
        <h3 class="text-gray-800 font-medium">Daftar Tahun Ajaran</h3>
        <a href="{{ route('admin.tahun-ajaran.create') }}" class="bg-blue-200 hover:bg-blue-300 text-gray px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Tahun Ajaran
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-medium w-16">No</th>
                    <th class="px-6 py-4 font-medium">Tahun Ajaran</th>
                    <th class="px-6 py-4 font-medium text-center">Status</th>
                    <th class="px-6 py-4 font-medium text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($tahunAjaran as $index => $ta)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-500">{{ $tahunAjaran->firstItem() + $index }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $ta->tahun }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($ta->status == 'aktif')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold"><i class="fa-solid fa-check mr-1"></i> Aktif</span>
                        @else
                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                            @if($ta->status == 'nonaktif')
                            <form action="{{ route('admin.tahun-ajaran.set-aktif', $ta->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="text-green-500 hover:text-green-700 transition-colors text-xs font-medium bg-green-50 px-2 py-1 rounded border border-green-100" title="Set sebagai Tahun Ajaran Aktif">
                                    Set Aktif
                                </button>
                            </form>
                            @endif

                            <a href="{{ route('admin.tahun-ajaran.edit', $ta->id) }}" class="text-blue-500 hover:text-blue-700 transition-colors" title="Edit">
                                <i class="fa-regular fa-pen-to-square text-lg"></i>
                            </a>

                            <form action="{{ route('admin.tahun-ajaran.destroy', $ta->id) }}" method="POST" class="delete-form inline-block">
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
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data tahun ajaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-5 border-t border-gray-50">
        {{ $tahunAjaran->links() }}
    </div>
</div>

<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                title: 'Hapus Tahun Ajaran?',
                text: "Data ini tidak bisa dihapus jika sedang terhubung dengan data siswa!",
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