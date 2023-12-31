<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\solicitudes;

class SolicitudesController extends Controller
{

    public function updateSolicitud(Request $request, $id)

    {
        $solicitud = solicitudes::find($id);

        if (!$solicitud) {
            return response()->json(['message' => 'solicitud no encontrado'], 404);
        }

        $solicitud->update($request->all());

        return response()->json(['message' => 'solicitud actualizado con éxito']);
    }


    public function getSolicitud()
    {
        $solicitud = solicitudes::all();
        return response()->json(solicitudes::all(), 200);
    }

    public function deleteSolicitudById($id)
    {
        $solicitud = solicitudes::find($id);
        if (is_null($solicitud)) {
            return response()->json(['message' => 'Solicitud no encontrada'], 404);
        }
        $solicitud->delete();
        return response()->json(['message' => 'Solicitud eliminada exitosamente'], 200);
    }

    public function nuevasolicitud(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'NUE' => 'required|string|max:100', // Asegura que NUE sea único en la tabla
            'ruta_archivo' => 'required|file|max:2048|mimetypes:imagen/jpeg,image/png,application/pdf,application/msword,aplication/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);

        if (!$request->has('expire')) {
            $request->merge(['expire' => null]);
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $uploadedFile = $request->file('ruta_archivo');
        $extension = $uploadedFile->getClientOriginalExtension();

        $allowedExtensions = ['pdf', 'docx', 'jpeg', 'jpg', 'png'];

        if (!in_array($extension, $allowedExtensions)) {
            return response()->json(['error' => 'Solo se permiten imagenes en formato (jpeg, png) y archivos PDF y Word (docx)'], 422);
        }

        $rutaArchivo = $uploadedFile->store('public/files');

        $solicitud = Solicitudes::create([
            'NUE' => $request->NUE,
            'ruta_archivo' => $rutaArchivo
        ]);

        return response()->json(['Solicitud' => $solicitud], 200);
    }

    //Función para obtener y descargar el archivo
    public function getArchivo($ruta_archivo)
    {
        $filePath = public_path('storage/files/' . $ruta_archivo);

        if (file_exists($filePath)) {
            $headers = [
                'Content-Type' => mime_content_type($filePath),
                'Content-Disposition' => 'attachment; filename="' . basename($filePath) . '"',
            ];

            return response()->download($filePath, null, $headers);
        } else {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }
    }
}
