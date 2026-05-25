<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengaturan', function (Blueprint $table) {
            $table->string('kop_baris_1')->default('PEMERINTAH KABUPATEN BATU BARA')->after('id');
            $table->string('kop_baris_2')->default('DINAS PENDIDIKAN')->after('kop_baris_1');
            $table->string('kop_baris_3')->default('UPT. SD NEGERI 31 TANAH TINGGI')->after('kop_baris_2');
            $table->string('kop_baris_4')->default('Jln Tanah Lapang Dusun VII Desa Tanah Tinggi Kecamatan Air Putih')->after('kop_baris_3');
            $table->string('kop_baris_5')->default('NPSN 10204282 Kode Pos 21256')->after('kop_baris_4');
            $table->string('logo_kop')->nullable()->after('kop_baris_5');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaturan', function (Blueprint $table) {
            $table->dropColumn(['kop_baris_1', 'kop_baris_2', 'kop_baris_3', 'kop_baris_4', 'kop_baris_5', 'logo_kop']);
        });
    }
};
