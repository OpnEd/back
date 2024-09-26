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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();

            // Clave foránea para el usuario que creó el registro (admin o médico)
            $table->foreignId('user_id')->constrained('users');

            // Clave foránea para el responsable del paciente (cliente)
            $table->foreignId('responsable_id')->constrained('users');

            // Información del paciente
            $table->string('name');
            $table->string('species');
            $table->string('race')->nullable();
            $table->string('sex')->nullable();
            $table->date('birth_date')->nullable();
            $table->float('weight')->nullable();
            $table->string('hair')->nullable();
            $table->unsignedBigInteger('chip_number')->nullable();
            $table->text('other_features')->nullable();
            $table->text('zootechnical_purpose')->nullable();
            $table->string('provenance')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
