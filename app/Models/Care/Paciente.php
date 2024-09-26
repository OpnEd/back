<?php

namespace App\Models\Care;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'responsable_id',
        'name',
        'species',
        'race',
        'sex',
        'birth_date',
        'weight',
        'hair',
        'chip_number',
        'other_features',
        'zootechnical_purpose',
        'provenance',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'weight' => 'float',
    ];

    // Relación con el usuario que creó el registro (admin o médico)
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con el responsable del paciente (cliente)
    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    // Aquí aplicamos el Global Scope
    protected static function booted()
    {
        static::addGlobalScope('team', function (Builder $builder) {
            // Obtener el usuario autenticado
            $user = Auth::user();

            // Si el usuario está autenticado, filtrar por su equipo
            if ($user) {
                $builder->whereHas('creador', function ($query) use ($user) {
                    $query->where('team_id', $user->team_id);
                });
            }
        });
    }
}
