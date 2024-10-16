<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Models\Care\Paciente;
use App\Http\Requests\StorePacienteRequest;
use App\Http\Requests\UpdatePacienteRequest;
use App\Http\Resources\PacienteResource;
use Illuminate\Support\Facades\DB;
use App\Interfaces\PacienteRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class PacienteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            // new Middleware('auth:sanctum', except: ['index', 'show']), // si se han de excluir algunos métodos
            new Middleware('auth:sanctum'),
        ];
    }

    private PacienteRepositoryInterface $pacienteRepositoryInterface;

    public function __construct(PacienteRepositoryInterface $pacienteRepositoryInterface)
    {
        $this->pacienteRepositoryInterface = $pacienteRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->pacienteRepositoryInterface->index();
        return ApiResponseClass::sendResponse(PacienteResource::collection($data),'',200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePacienteRequest $request, PacienteRepositoryInterface $pacienteRepositoryInterface)
    {
        // Autorización de la creación de Paciente
        Gate::authorize('create', Paciente::class);

        // Obtén el usuario autenticado
        $user = $request->user();

        $details =[
            'user_id' => $user->id, // ID del usuario que creó el paciente (admin o médico)
            'responsable_id' => $request->responsable_id, // ID del responsable del paciente (cliente)
            'name' => $request->name, // Nombre del paciente
            'species' => $request->species, // Especie del paciente
            'race' => $request->race, // Raza del paciente (si es aplicable)
            'sex' => $request->sex, // Sexo del paciente
            'birth_date' => $request->birth_date,
            'weight' => $request->weight, // Peso del paciente
            'hair' => $request->hair, // Tipo de pelaje
            'chip_number' => $request->chip_number, // Número de chip del paciente
            'other_features' => $request->other_features, // Otras características del paciente
            'zootechnical_purpose' => $request->zootechnical_purpose, // Propósito zootécnico del paciente
            'provenance' => $request->provenance, // Procedencia del paciente
        ];

        DB::beginTransaction();

        try{

            // $paciente = $request->user()->pacientes()->create($details);
             $paciente = $pacienteRepositoryInterface->store($details);

             DB::commit();
             return ApiResponseClass::sendResponse(new PacienteResource($paciente),'Paciente create Successful',201);

        }catch(\Exception $ex){

            return ApiResponseClass::rollback($ex);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Paciente $paciente)
    {
        $pacienteShow = $this->pacienteRepositoryInterface->getById($paciente);
        return ApiResponseClass::sendResponse(new PacienteResource($pacienteShow),'',200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paciente $paciente)
    {
        // Autorización para modificar el paciente
        Gate::authorize('update', $paciente);

        /* Gate::authorize('modify', $id); */
        // Obtén el usuario autenticado
        $user = $request->user();

        $updateDetails =[
            'user_id' => $user->id, // ID del usuario que creó el paciente (admin o médico)
            'responsable_id' => $request->responsable_id, // ID del responsable del paciente (cliente)
            'name' => $request->name, // Nombre del paciente
            'species' => $request->species, // Especie del paciente
            'race' => $request->race, // Raza del paciente (si es aplicable)
            'sex' => $request->sex, // Sexo del paciente
            'birth_date' => $request->birth_date, // Fecha de nacimiento en formato 'Y-m-d'
            'weight' => $request->weight, // Peso del paciente
            'hair' => $request->hair, // Tipo de pelaje
            'chip_number' => $request->chip_number, // Número de chip del paciente
            'other_features' => $request->other_features, // Otras características del paciente
            'zootechnical_purpose' => $request->zootechnical_purpose, // Propósito zootécnico del paciente
            'provenance' => $request->provenance, // Procedencia del paciente
        ];

        DB::beginTransaction();

        try{

             $paciente = $this->pacienteRepositoryInterface->update($updateDetails,$paciente);

             DB::commit();

             return ApiResponseClass::sendResponse('Paciente update Successful','',201);

        }catch(\Exception $ex){

            return ApiResponseClass::rollback($ex);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Paciente $paciente)
    {
        // Autorización para eliminar el paciente
        Gate::authorize('delete', $paciente);

        // Inicia una transacción de base de datos
        DB::beginTransaction();

        try {

            $paciente = Paciente::find($paciente->id);

            if (!$paciente) {
                return ApiResponseClass::sendError('Paciente no encontrado', [], 404);
            }

            // Llama al método delete del repositorio
            $this->pacienteRepositoryInterface->delete($paciente);

            // Si no hay errores, confirma la transacción
            DB::commit();

            // Devuelve una respuesta exitosa
            return ApiResponseClass::sendResponse('Paciente eliminado con éxito', '', 200);

        } catch (\Exception $ex) {
            // Reversa la transacción en caso de error
            DB::rollback();

            // Maneja el error y devuelve una respuesta adecuada
            return ApiResponseClass::rollback($ex);
        }
    }
}
