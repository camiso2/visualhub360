<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Custom\ApiResponseTrait;
use Illuminate\Validation\Rule;
use App\Models\DocumentsClients;
use App\Models\Client;
use App\Models\ImageDocumentsClient;
use Illuminate\Support\Facades\File;

class DocumentsClientController extends Controller
{
    use ApiResponseTrait;
    /**
     * @OA\Post(
     *     path="/api/documentsClient",
     *     summary="Registrar un nuevo documento de cliente con múltiples imágenes",
     *     tags={"Gestión de Documentos de Clientes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"client_id","name_company"},
     *                 @OA\Property(property="name_company", type="string", example="Joyas del Sur S.A."),
     *                 @OA\Property(property="description", type="string", example="Documentos de garantía del cliente"),
     *                 @OA\Property(property="client_id", type="integer", example=56),
     *                 @OA\Property(
     *                     property="document_files[]",
     *                     type="array",
     *                     @OA\Items(type="string", format="binary"),
     *                     description="Múltiples imágenes del documento"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Documento de cliente creado correctamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Cliente no pertenece a la empresa"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor"
     *     )
     * )
     */
    public function createDocumentClient(Request $request)
    {
        try {


            $user = auth()->user();

            // Log de datos iniciales
            // Loguea todos los archivos recibidos bajo la clave esperada
            Log::info('Archivos recibidos:', ['files' => $request->file('document_files')]);

            // Loguea todos los inputs de texto
            Log::info('Inputs de texto recibidos:', ['inputs' => $request->all()]);

            // Validaciones
            $validator = Validator::make($request->all(), [
                'name_company' => 'required|string|max:255',
                'description' => 'nullable|string|max:500',
                'client_id' => 'required|integer',
                'document_files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json($this->errorValidator($validator->errors()), 422);
            }

            // Validar cliente
            $client = Client::where('id', $request->client_id)
                ->where('company_id', $user->company_id)
                ->first();

            if (!$client) {
                return response()->json(
                    $this->errorGeneric('El cliente no pertenece a tu empresa o no existe.', 403),
                    403
                );
            }

            // Carpeta destino
            $destination = public_path('documents_clients');
            if (!File::exists($destination)) {
                File::makeDirectory($destination, 0755, true);
            }

            $imageIds = [];
            $mainImageId = null;

            // Procesar y guardar imágenes
            if ($request->hasFile('document_files')) {
                foreach ($request->file('document_files') as $index => $image) {
                    $uniqueName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $path = 'documents_clients/' . $uniqueName;
                    $image->move($destination, $uniqueName);

                    // Guardar registro en tabla de imágenes
                    $imageRecord = ImageDocumentsClient::create([
                        'company_id' => $user->company_id,
                        'client_id' => $request->client_id,
                        'image' => $path,
                    ]);

                    $imageIds[] = $imageRecord->id;

                    if ($index === 0) {
                        $mainImageId = $imageRecord->id;
                    }
                }
            }

            // Crear el documento del cliente
            $documentClient = DocumentsClients::create([
                'company_id' => $user->company_id,
                'branch_id' => $user->branch->id,
                'client_id' => $request->client_id,
                'user_id' => $user->id,
                'name_company' => $request->name_company,
                'description' => $request->description,
                'image_id' => json_encode($imageIds), // guardamos todos los IDs como JSON
            ]);



            return response()->json(
                $this->successfullMessage(
                    201,
                    'Documento de cliente creado correctamente',
                    true,
                    1,
                    [
                        'document_client' => $documentClient,
                        'image_ids' => $imageIds,
                        'branch' => $user->branch
                    ]
                ),
                201
            );

        } catch (\Exception $e) {
            Log::error("Error al crear documento de cliente: " . $e->getMessage());
            return response()->json(
                $this->errorGeneric('Error al crear documento de cliente: ' . $e->getMessage(), 500),
                500
            );
        }
    }

    /**
     * @OA\Get(
     * path="/api/documentsClient/{client_id}/history",
     * summary="Listar historial de interacciones de documentos del cliente con sus imágenes y sucursal",
     * tags={"Gestión de Documentos de Clientes"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="client_id",
     * in="path",
     * required=true,
     * description="ID del cliente",
     * @OA\Schema(type="integer", example=56)
     * ),
     * @OA\Response(
     * response=200,
     * description="Historial de documentos del cliente obtenido correctamente"
     * ),
     * @OA\Response(
     * response=403,
     * description="Cliente no pertenece a la empresa"
     * ),
     * @OA\Response(
     * response=404,
     * description="El cliente no tiene documentos registrados"
     * ),
     * @OA\Response(
     * response=500,
     * description="Error interno del servidor"
     * )
     * )
     */
    public function getClientDocumentsHistory($client_id)
    {
        try {
            $user = auth()->user();

            // 1. Validar existencia y pertenencia del cliente
            $client = Client::where('id', $client_id)
                ->where('company_id', $user->company_id)
                ->first();

            if (!$client) {
                return response()->json(
                    $this->errorGeneric('El cliente no pertenece a tu empresa o no existe.', 403),
                    403
                );
            }

            // 2. Consulta de Documentos con Eager Loading (Relaciones directas)
            $documents = DocumentsClients::where('client_id', $client_id)
                ->with(['branch', 'user'])
                ->latest()
                ->get();

            if ($documents->isEmpty()) {
                return response()->json(
                    $this->errorGeneric('El cliente no tiene documentos registrados.', 404),
                    404
                );
            }

            // 3. Carga Eficiente de Imágenes
            $allImageIds = collect();

            // Iteramos sobre cada documento para obtener todos los IDs de imagen
            foreach ($documents as $document) {

                // 🚨 CORRECCIÓN 1: Evitar json_decode() en un array
                // Verificamos si es una cadena (JSON sin decodificar). Si no lo es, asumimos que el cast funcionó.
                $ids = is_string($document->image_id)
                    ? json_decode($document->image_id, true)
                    : $document->image_id;

                // Si el resultado es un array
                if (is_array($ids)) {
                    $allImageIds = $allImageIds->merge($ids);
                }
            }

            // Obtenemos los IDs únicos y los convertimos a array para el whereIn()
            $allImageIds = $allImageIds->unique()->values();

            // b. Cargar todos los registros completos de imágenes en una sola consulta
            $images = ImageDocumentsClient::whereIn('id', $allImageIds->toArray())
                ->get()
                ->keyBy('id'); // Indexamos por ID para O(1)

            // Asegúrate de que tu modelo 'Client' esté importado y que la variable $clientId tenga el ID.
            $dataClient = Client::find($client_id);

            // 4. Adjuntar los datos de las imágenes al documento
            $documents = $documents->map(function ($document) use ($images) {

                // 🚨 CORRECCIÓN 2 (Línea ~235): Evitar json_decode() en un array
                // Si el atributo es una cadena, decodificar; de lo contrario, usar el valor como está.
                $documentImageIds = is_string($document->image_id)
                    ? json_decode($document->image_id, true)
                    : $document->image_id;



                // Aseguramos que la lista sea iterable
                if (is_array($documentImageIds)) {
                    $document->related_images = collect($documentImageIds)->map(function ($imageId) use ($images) {
                        // Obtenemos el objeto completo de ImageDocumentsClient
                        return $images->get($imageId);
                    })->filter()->values();
                } else {
                    $document->related_images = [];
                }

                return $document;
            });

            $client = Client::find($client_id);

            // Agregamos el cliente dentro de cada documento
            $documents->each(function ($doc) use ($client) {
                $doc->client_data = $client;
            });

            // 5. Retorno de la Respuesta Personalizada (200 OK)
            return response()->json(
                $this->successfullMessage(
                    201,
                    'Historial de documentos del cliente obtenido correctamente',
                    true,
                    $documents->count(),
                    ['documents' => $documents]
                ),
                201
            );

        } catch (\Exception $e) {
            Log::error("Error al obtener historial de documentos del cliente: " . $e->getMessage(), ['client_id' => $client_id]);
            return response()->json(
                $this->errorGeneric('Error interno del servidor al obtener historial de documentos: ' . $e->getMessage(), 500),
                500
            );
        }
    }

    /**
     * @OA\Delete(
     * path="/api/admin/document-clients/{document_id}/image/{image_id}",
     * summary="Eliminar una imagen específica de un documento de cliente",
     * tags={"Gestión de Documentos de Clientes"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="document_id",
     * in="path",
     * required=true,
     * description="ID del documento principal",
     * @OA\Schema(type="integer", example=25)
     * ),
     * @OA\Parameter(
     * name="image_id",
     * in="path",
     * required=true,
     * description="ID de la imagen a eliminar",
     * @OA\Schema(type="integer", example=53)
     * ),
     * @OA\Response(
     * response=200,
     * description="Imagen eliminada y documento actualizado correctamente"
     * ),
     * @OA\Response(
     * response=403,
     * description="Acceso denegado o documento/imagen no pertenecen a la empresa"
     * ),
     * @OA\Response(
     * response=404,
     * description="El documento o la imagen no fueron encontrados"
     * ),
     * @OA\Response(
     * response=500,
     * description="Error interno del servidor al eliminar"
     * )
     * )
     */
    public function deleteDocumentImage($document_id, $image_id)
    {
        try {
            $user = auth()->user();

            // Solo 'Administrador General' o 'Administrador Sucursal' tienen permiso.
            if ($user->role_id !== null || $user->role_id === 'Administrador Sucursal') {
                return response()->json($this->errorGeneric('No tiene permisos para crear usuarios', 403), 403);
            }

            // 1. Validar y obtener el Documento Principal (Aislamiento Multiempresa)
            $documentClient = DocumentsClients::where('id', $document_id)
                ->where('company_id', $user->company_id)
                ->first();

            if (!$documentClient) {
                return response()->json(
                    $this->errorGeneric('Documento no encontrado o acceso denegado.', 403),
                    403
                );
            }

            // 2. Validar y obtener el Registro de la Imagen (Aislamiento Multiempresa)
            $imageRecord = ImageDocumentsClient::where('id', $image_id)
                ->where('company_id', $user->company_id)
                ->first();

            if (!$imageRecord) {
                return response()->json(
                    $this->errorGeneric('Imagen no encontrada o acceso denegado.', 404),
                    404
                );
            }

            // --- Lógica de Eliminación ---

            // A. Eliminación del Archivo Físico
            $filePath = public_path($imageRecord->image);
            if (File::exists($filePath)) {
                File::delete($filePath);
            } else {
                Log::warning('Intento de eliminar archivo no existente', ['path' => $filePath]);
            }

            // B. Eliminación Lógica del Registro de la Imagen (Soft Delete)
            $imageRecord->delete(); // Aplica Soft Delete

            // C. Actualizar el Documento Principal (Eliminar ID del Array JSON)

            // ⚠️ CRÍTICO: El cast debe funcionar aquí
            $imageIds = is_array($documentClient->image_id)
                ? $documentClient->image_id
                : json_decode($documentClient->image_id, true);

            // Filtramos el ID de la imagen a eliminar
            $updatedImageIds = collect($imageIds)->reject(function ($id) use ($image_id) {
                return (int) $id === (int) $image_id;
            })->values()->toArray();

            // Guardamos el array limpio de IDs de vuelta en el documento
            $documentClient->image_id = $updatedImageIds;
            $documentClient->save();


            // Log de confirmación
            Log::info('Imagen eliminada y documento actualizado correctamente', [
                'document_id' => $document_id,
                'image_id_eliminado' => $image_id,
            ]);

            // D. Retorno de la Respuesta Personalizada
            return response()->json(
                $this->successfullMessage(
                    201,
                    'Imagen eliminada y documento actualizado correctamente',
                    true,
                    1,
                    ['document_id' => $document_id]
                ),
                201
            );

        } catch (\Exception $e) {
            Log::error("Error al eliminar imagen de documento: " . $e->getMessage(), ['document_id' => $document_id, 'image_id' => $image_id]);
            return response()->json(
                $this->errorGeneric('Error interno del servidor al eliminar imagen: ' . $e->getMessage(), 500),
                500
            );
        }
    }

    /**
     * @OA\Post(
     * path="/api/admin/document-clients/{document_id}",
     * summary="Actualizar datos y/o agregar imágenes a una interacción (documento) existente",
     * tags={"Gestión de Documentos de Clientes"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="document_id",
     * in="path",
     * required=true,
     * description="ID del documento principal a actualizar",
     * @OA\Schema(type="integer", example=27)
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="multipart/form-data",
     * @OA\Schema(
     * @OA\Property(property="name_company", type="string", description="Nombre de la compañía (Opcional)", example="Nueva S.A.S."),
     * @OA\Property(property="description", type="string", description="Descripción del documento (Opcional)", example="Nuevos documentos de garantía."),
     * @OA\Property(
     * property="images[]",
     * type="array",
     * description="Array de nuevos archivos de imagen a subir (Opcional)",
     * @OA\Items(type="string", format="binary")
     * )
     * )
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Documento e imágenes actualizados correctamente"
     * ),
     * @OA\Response(
     * response=403,
     * description="Acceso denegado o documento no pertenece a la empresa"
     * ),
     * @OA\Response(
     * response=422,
     * description="Error de validación"
     * ),
     * @OA\Response(
     * response=404,
     * description="Documento no encontrado"
     * ),
     * @OA\Response(
     * response=500,
     * description="Error interno del servidor"
     * )
     * )
     */
    public function updateDocumentClient(Request $request, $document_id)
    {
        try {
            $user = auth()->user();

            // Solo 'Administrador General' o 'Administrador Sucursal' tienen permiso.
            if ($user->role_id !== null || $user->role_id === 'Administrador Sucursal') {
                return response()->json($this->errorGeneric('No tiene permisos para crear usuarios', 403), 403);
            }

            // 1. Validaciones
            $validator = Validator::make($request->all(), [
                // Hacemos los campos de texto opcionales si solo se van a subir imágenes, pero los validamos si se envían.
                'name_company' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:500',

                // Las imágenes son opcionales, pero si se envían, se validan.
                'images' => 'nullable|array',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json($this->errorValidator($validator->errors()), 422);
            }

            // 2. Obtener y Validar Documento Principal (Aislamiento Multiempresa)
            $documentClient = DocumentsClients::where('id', $document_id)
                ->where('company_id', $user->company_id)
                ->first();

            if (!$documentClient) {
                return response()->json(
                    $this->errorGeneric('Documento no encontrado o acceso denegado.', 404),
                    404
                );
            }

            $newImageIds = [];
            $destination = public_path('documents_clients');

            // Carpeta destino
            if (!File::exists($destination)) {
                File::makeDirectory($destination, 0755, true);
            }

            // 3. Procesar y guardar NUEVAS imágenes (si las hay)
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $uniqueName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $path = 'documents_clients/' . $uniqueName;
                    $image->move($destination, $uniqueName);

                    // Guardar registro en tabla de imágenes
                    $imageRecord = ImageDocumentsClient::create([
                        'company_id' => $user->company_id,
                        'client_id' => $documentClient->client_id,
                        'image' => $path,
                    ]);

                    $newImageIds[] = $imageRecord->id;
                }
            }

            // 4. Actualizar campos de texto (name_company y description)
            $updateData = [];

            if ($request->filled('name_company')) {
                $updateData['name_company'] = $request->name_company;
            }
            if ($request->filled('description')) {
                $updateData['description'] = $request->description;
            }

            // 5. Actualizar el array de imágenes SOLO si se subieron nuevas imágenes
            if (!empty($newImageIds)) {

                // Forzamos la decodificación del JSON existente (solución al bug)
                $currentImageIds = is_array($documentClient->image_id)
                    ? $documentClient->image_id
                    : json_decode($documentClient->image_id, true);

                if (!is_array($currentImageIds)) {
                    $currentImageIds = [];
                }

                // Fusionamos los IDs nuevos con los IDs existentes
                $updatedImageIds = collect($currentImageIds)->merge($newImageIds)->unique()->values()->toArray();

                $updateData['image_id'] = $updatedImageIds;
            }

            // 6. Aplicar la actualización si hay datos para guardar
            if (!empty($updateData)) {
                $documentClient->update($updateData);
            }

            // Log de confirmación
            Log::info('Documento actualizado correctamente', [
                'document_id' => $document_id,
                'nuevos_datos' => $updateData,
                'new_image_ids' => $newImageIds,
            ]);

            // 7. Retorno de la Respuesta Personalizada
            $message = 'Documento actualizado correctamente.';
            if (!empty($newImageIds)) {
                $message = count($newImageIds) . ' imagen(es) agregada(s) y documento actualizado correctamente.';
            }

            return response()->json(
                $this->successfullMessage(
                    201,
                    $message,
                    true,
                    1,
                    [
                        'document_id' => $document_id,
                        'updated_fields' => array_keys($updateData),
                        'new_images_count' => count($newImageIds),
                    ]
                ),
                200
            );

        } catch (\Exception $e) {
            Log::error("Error al actualizar documento de cliente: " . $e->getMessage(), ['document_id' => $document_id]);
            return response()->json(
                $this->errorGeneric('Error interno del servidor al actualizar documento: ' . $e->getMessage(), 500),
                500
            );
        }
    }
}
