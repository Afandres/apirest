<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Apprentice;
use Validator;

class ApprenticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apprentices = Apprentice::get();

        return response()
            ->json($apprentices);
            
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'identificacion' => 'required',
            'nombre' => 'required',
            'asistencia' => 'required|boolean',
        ]);

        $apprentice = Apprentice::create($validatedData);

        return response()->json(['id' => $apprentice->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $apprentices = Apprentice::where("apprentices.identificacion", $id)->first();
        return response()->json([
            "ok" => true,
            "data" => $apprentices,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $apprentice = Apprentice::where('identificacion', $identificacion)->first();

        if (!$apprentice) {
            return response()->json(['error' => 'Aprendiz no encontrado'], 404);
        }

        $asistencia = $request->input('asistencia');

        $apprentice->asistencia = $asistencia;
        $apprentice->save();

        return response()->json(['message' => 'Asistencia actualizada'], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $apprentices = Apprentice::find($id);
            if ($apprentices == false) {
                return response()->json([
                    "ok" => false,
                    "error" => "No se encontro",
                ]);
            }
            $apprentices->delete();
            return response()->json([
                "ok" => true,
                "mensaje" => "Registro eliminado",
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "ok" => false,
                "error" => $ex->getMessage(),
            ]);
        }
    }
}
?>