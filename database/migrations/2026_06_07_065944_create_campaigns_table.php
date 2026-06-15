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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('judul');
            $table->text('deskripsi');
            $table->string('kategori')->nullable();

            $table->decimal('target', 15, 2);

            $table->decimal('terkumpul', 15, 2)
                  ->default(0);

            $table->string('gambar')
                  ->nullable();

            $table->enum('status', [
                'pending',
                'aktif',
                'selesai',
                'ditolak'
            ])->default('pending');

            $table->timestamp('tanggal_mulai')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
