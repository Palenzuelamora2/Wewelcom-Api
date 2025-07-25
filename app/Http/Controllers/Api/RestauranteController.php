<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurante;
use Illuminate\Validation\ValidationException;


class RestauranteController extends Controller
{
    /**
     * Funcion para validar los datos del restaurante
     */
    private function validarDatosRestaurante(Request $request)
    {
        return $request->validate([
            'nombre_restaurante' => 'required|string|max:100',
            'direccion_restaurante' => 'required|string|max:100',
            'telefono_restaurante' => 'required|string|max:20',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/restaurantes",
     *     tags={"Restaurantes"},
     *     summary="Obtiene todos los restaurantes",
     *     @OA\Response(
     *         response=200,
     *         description="Listado de restaurantes",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="restaurantes",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Restaurante")
     *             )
     *         )
     *     )
     * )
     */
    public function obtenerTodosRestaurantes()
    {
        $restaurantes = Restaurante::all();

        return response()->json([
            'restaurantes' => $restaurantes
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/restaurantes",
     *     tags={"Restaurantes"},
     *     summary="Crear un nuevo restaurante",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Restaurante")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Restaurante creado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Restaurante creado con éxito"),
     *             @OA\Property(property="restaurante", ref="#/components/schemas/Restaurante")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error en la creación del restaurante"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */

    public function crearRestaurante(Request $request)
    {
        try {
            // Validamos los datos
            $validacion = $this->validarDatosRestaurante($request);
            // Crear restaurante
            $restaurante = Restaurante::create($validacion);
            // Devolvemos el restaurante creado.
            return response()->json([
                'message' => 'Restaurante creado con éxito',
                'restaurante' => $restaurante
            ], 201);
        } catch (ValidationException $e) {
            // En caso de error de validación
            return response()->json([
                'message' => 'Error en la creación del restaurante',
                'errors' => $e->errors() // Cambiado de getMessage() a errors() para mejor detalle
            ], 422);
        } catch (\Exception $e) {
            // Captura otros errores inesperados
            return response()->json([
                'message' => 'Error interno del servidor al crear el restaurante',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/restaurantes/{nombre}",
     *     tags={"Restaurantes"},
     *     summary="Buscar restaurante por nombre",
     *     @OA\Parameter(
     *         name="nombre",
     *         in="path",
     *         required=true,
     *         description="Nombre (parcial o completo) del restaurante a buscar",
     *         @OA\Schema(type="string", example="Nuevo Restaurante")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de restaurantes encontrados",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Restaurante")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontró ningún restaurante",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No se encontró el restaurante con el nombre Nuevo Restaurante")
     *         )
     *     )
     * )
     */

    public function buscarRestaurante($nombre)
    {
        $restaurante = Restaurante::where('nombre_restaurante', 'LIKE', "%{$nombre}%")->get();

        if ($restaurante->isEmpty()) {
            return response()->json([
                'message' => 'No se encontró el restaurante con el nombre ' . $nombre,
            ], 404);
        }

        return response()->json($restaurante, 200);
    }
    /**
     * @OA\Put(
     *     path="/restaurantes/{id}",
     *     tags={"Restaurantes"},
     *     summary="Actualizar restaurante",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del restaurante a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Restaurante")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurante actualizado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Restaurante actualizado con éxito"),
     *             @OA\Property(property="restaurante", ref="#/components/schemas/Restaurante")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Restaurante no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No se encontró el restaurante con el id 1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error en la actualización del restaurante"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */

    public function editarRestaurante(Request $request, $id)
    {
        $restaurante_editar = Restaurante::find($id);

        if (!$restaurante_editar) {
            return response()->json([
                'message' => 'No se encontró el restaurante con el id ' . $id,
            ], 404);
        }

        try {
            $validacion = $this->validarDatosRestaurante($request);
            $restaurante_editar->update($validacion);

            return response()->json([
                'message' => 'Restaurante actualizado con éxito',
                'restaurante' => $restaurante_editar
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error en la actualización del restaurante',
                'errors' => $e->errors() // Cambiado de getMessage() a errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error interno del servidor al actualizar el restaurante',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/restaurantes/{id}",
     *     tags={"Restaurantes"},
     *     summary="Eliminar restaurante",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del restaurante a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurante eliminado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Restaurante con ID 1 eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Restaurante no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No se encontró el restaurante con el id 1")
     *         )
     *     )
     * )
     */
    public function eliminarRestaurante(string $id)
    {
        $restaurante = Restaurante::find($id);

        if (!$restaurante) {
            return response()->json([
                'message' => "No se encontró el restaurante con ID $id"
            ], 404);
        }

        try {
            $restaurante->delete();
            return response()->json([
                'message' => "Restaurante con ID $id eliminado correctamente"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error interno del servidor al eliminar el restaurante',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
