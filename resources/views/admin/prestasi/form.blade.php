@extends('layouts.app')
@section('title', isset($prestasi) ? 'Edit Prestasi' : 'Tambah Prestasi')
@section('header_title', isset($prestasi) ? 'Edit Prestasi' : 'Tambah Prestasi')
@section('header_subtitle', 'Form input data prestasi siswa')

@section('content')
<form action="{{ isset($prestasi) ? route('admin.prestasi.update', $prestasi->id) : route('admin.prestasi.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($prestasi)) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="text-primary font-semibold mb-6 flex items-center gap-2">
                <i class="fa-solid fa-trophy"></i> Informasi Prestasi
            </h4>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lomba</label>
                    <input type="text" name="nama_lomba" value="{{ old('nama_lomba', $prestasi->nama_lomba ?? '') }}" placeholder="Masukkan nama lomba" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm transition-all">
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="kategori_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary outline-none text-sm">
                            <option value="">Pilih kategori</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_id', $prestasi->kategori_id ?? '') == $k->id ? 'selected' : '' }}>{{ $k->jenis_prestasi }} ({{ $k->nama_kategori }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat</label>
                        <select name="tingkat_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary outline-none text-sm">
                            <option value="">Pilih tingkat</option>
                            @foreach($tingkat as $t)
                                <option value="{{ $t->id }}" {{ old('tingkat_id', $prestasi->tingkat_id ?? '') == $t->id ? 'selected' : '' }}>{{ $t->nama_tingkat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="w-1/2 pr-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', isset($prestasi) ? $prestasi->tanggal->format('Y-m-d') : '') }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary outline-none text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" placeholder="Masukkan deskripsi prestasi..." required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary outline-none text-sm">{{ old('deskripsi', $prestasi->deskripsi ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h4 class="text-primary font-semibold mb-5 flex items-center gap-2">
                    <i class="fa-solid fa-user-graduate"></i> Informasi Siswa
                </h4>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Siswa</label>
                    <select name="siswa_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary outline-none text-sm">
                        <option value="">Pilih siswa</option>
                        @foreach($siswa as $siswa)
                            <option value="{{ $siswa->id }}" {{ old('siswa_id', $prestasi->siswa_id ?? '') == $siswa->id ? 'selected' : '' }}>{{ $siswa->nama }} ({{ $siswa->nisn }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Prestasi</label>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition-colors relative cursor-pointer" onclick="document.getElementById('file_upload').click()">
                        <i class="fa-solid fa-cloud-arrow-up text-4xl text-primary mb-3"></i>
                        <p class="text-sm font-medium text-gray-700">Upload bukti (sertifikat/foto)</p>
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, PDF maksimal 5MB</p>
                        <input type="file" name="file_bukti" id="file_upload" class="hidden" accept=".png,.jpg,.jpeg,.pdf" {{ isset($prestasi) ? '' : 'required' }} onchange="updateFileName(this)">
                    </div>
                    <p id="file-name" class="text-xs text-green-600 mt-2 font-medium"></p>
                    @if(isset($prestasi))
                        <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah bukti lama.</p>
                    @endif
                </div>

                <hr class="border-gray-100 my-5">

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Prestasi Unggulan</p>
                        <p class="text-xs text-gray-400">Jadikan prestasi ini sebagai unggulan</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="unggulan" value="1" class="sr-only peer" {{ old('unggulan', $prestasi->unggulan ?? false) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('admin.prestasi.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-8 py-2.5 bg-primary hover:bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md shadow-blue-200 transition-all">Simpan</button>
            </div>

        </div>
    </div>
</form>

<script>
    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : '';
        document.getElementById('file-name').innerText = fileName ? 'File terpilih: ' + fileName : '';
    }
    
    // Error Handling SweetAlert
    @if($errors->any())
        Swal.fire({ icon: 'error', title: 'Periksa kembali inputan Anda', text: '{{ $errors->first() }}', confirmButtonColor: '#3b82f6' });
    @endif
</script>
@endsection