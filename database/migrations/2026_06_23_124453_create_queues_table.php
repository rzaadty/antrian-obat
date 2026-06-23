<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('queues', function (Blueprint $table) {
        $table->id();
        $table->date('queue_date');
        $table->integer('queue_number');
        $table->string('no_resep');
        $table->string('nama_pasien');
        $table->enum('status', ['menunggu', 'dipanggil', 'selesai'])->default('menunggu');
        $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null'); 
        // admin_id nullable agar saat antrian baru dibuat (belum dipanggil), nilainya bisa kosong
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('queues');
    }
};
