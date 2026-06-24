@extends('layouts.app')

@section('title', isset($tahunAjaran) ? 'Edit Tahun Ajaran' : 'Tambah Tahun Ajaran')
@section('header_title', isset($tahunAjaran) ? 'Edit Tahun Ajaran' : 'Tambah Tahun Ajaran')
@section('header_subtitle', 'Masukkan format tahun yang benar (contoh: 2024/2025)')

@section('content')
<div class="max-w-xl bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <form action="{{ isset($tahunAjaran) ? route('admin.tahun-ajaran.update', $tahunAjaran->id) : route('admin.tahun-ajaran.store') }}" method="POST">
        @csrf
        @if(isset($tahunAjaran))
            @method('PUT')
        @endif

        <div class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran</label>
                <input type="text" name="tahun" value="{{ old('tahun', $tahunAjaran->tahun ?? '') }}" placeholder="Misal: 2024/2025" required
                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm @error('tahun') border-red-500 @enderror">
                @error('tahun') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <p class="text-xs text-yellow-600 mb-3 bg-yellow-50 p-2 rounded border border-yellow-100">
                    <i class="fa-solid fa-circle-info mr-1"></i> Jika di-set "Aktif", tahun ajaran aktif sebelumnya akan otomatis menjadi nonaktif.
                </p>
                <div class="flex gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" value="aktif" {{ old('status', $tahunAjaran->status ?? '') == 'aktif' ? 'checked' : '' }} class="text-primary focus:ring-primary w-4 h-4">
                        <span class="text-sm text-gray-700">Aktif</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" value="nonaktif" {{ old('status', $tahunAjaran->status ?? 'nonaktif') == 'nonaktif' ? 'checked' : '' }} class="text-primary focus:ring-primary w-4 h-4">
                        <span class="text-sm text-gray-700">Nonaktif</span>
                    </label>
                </div>
                @error('status') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-50">
            <a href="{{ route('admin.tahun-ajaran.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">Batal</a>
            <button type="submit" class="px-6 py-2 bg-blue-200 hover:bg-blue-300 text-gray rounded-lg text-sm font-medium transition-colors shadow-sm focus:ring-4 focus:ring-blue-100">
                Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection