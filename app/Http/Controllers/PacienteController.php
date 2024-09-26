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

class PacienteController extends Controller
{

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePacienteRequest $request, PacienteRepositoryInterface $pacienteRepositoryInterface)
    {
        $details =[
            'user_id' => $request->user_id, // ID del usuario que creó el paciente (admin o médico)
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
    public function show(string $id)
    {
        $paciente = $this->pacienteRepositoryInterface->getById($id);
        return ApiResponseClass::sendResponse(new PacienteResource($paciente),'',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $updateDetails =[
            'user_id' => $request->user_id, // ID del usuario que creó el paciente (admin o médico)
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
             $paciente = $this->pacienteRepositoryInterface->update($updateDetails,$id);

             DB::commit();
             return ApiResponseClass::sendResponse('Paciente update Successful','',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->pacienteRepositoryInterface->delete($id);
        return ApiResponseClass::sendResponse('Product Delete Successful','',204);
    }
}
