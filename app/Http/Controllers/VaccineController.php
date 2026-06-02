<?php

namespace App\Http\Controllers;

use App\Http\Services\VaccinesService;
use App\Models\Vaccine;
use Illuminate\Http\Request;
use function Symfony\Component\String\u;

class VaccineController extends Controller
{
    protected $baseRepositoryVaccine;
    public function __construct(VaccinesService $baseRepository)
    {
        $this->baseRepositoryVaccine = $baseRepository;
    }

    public function all(Request $request){
        $vaccines = Vaccine::all();
        return response()->json($vaccines);
    }

    public function show(Request $request, $vaccine_id){
        $vaccine = $this->baseRepositoryVaccine->getById($vaccine_id);
        if(!$vaccine){
            return response()->json('vaccine not found', 404);
        }
        return response()->json($vaccine);
    }

    public function store(Request $request){
        $vaccine = $this->baseRepositoryVaccine->create($request->all());
        return response()->json($vaccine);
    }

    public function update(Request $request, $vaccine_id){
        $vaccine = $this->baseRepositoryVaccine->update($vaccine_id, $request->all());
        if(!$vaccine){
            return response()->json('vaccine not found', 404);
        }
        return response()->json($vaccine);
    }

    public function destroy(Request $request, $vaccine_id){
        $vaccine = $this->baseRepositoryVaccine->delete($vaccine_id);
        if(!$vaccine){
            return response()->json('vaccine not found', 404);
        }
        $vaccine->delete();
        return response()->json('Vaccine deleted successfully', 200);
    }
}
