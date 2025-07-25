<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Http\Controllers\Controller;


/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API de Wewelcom - Restaurantes y Autenticación",
 *     description="API para la gestión de restaurantes y autenticación de usuarios en la plataforma Wewelcom.",
 *     @OA\Contact(email="danielpalenzuelamora90@gmail.com")
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000/api/v1",
 *     description="Servidor de Desarrollo Local"
 * )
 *
 * @OA\Server(
 *     url="https://tudominio.com/api/v1",
 *     description="Servidor de Producción"
 * )
 *
 * @OA\Tag(
 *     name="Autenticación",
 *     description="Operaciones de registro, login y logout de usuarios."
 * )
 *
 * @OA\Tag(
 *     name="Restaurantes",
 *     description="Gestión de información de restaurantes."
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Token de autenticación. Introduce 'Bearer ' seguido de tu token."
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="apiKey",
 *     type="apiKey",
 *     name="X-API-KEY",
 *     in="header",
 *     description="API Key para acceder a recursos protegidos."
 * )
 * @OA\Schema(
 *     schema="UserRegister",
 *     type="object",
 *     required={"name", "email", "password"},
 *     @OA\Property(property="name", type="string", example="Daniel"),
 *     @OA\Property(property="email", type="string", format="email", example="daniel@example.com"),
 *     @OA\Property(property="password", type="string", format="password", example="secret123")
 * )
 */


class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/registro",
     *     tags={"Autenticación"},
     *     summary="Registro de un nuevo usuario",
     *     description="Registra un nuevo usuario en la plataforma",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserRegister")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario registrado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="mensaje", type="string", example="Usuario registrado con éxito")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="mensaje", type="string", example="Faltan campos por rellenar o los campos no son válidos"),
     *             @OA\Property(property="errores", type="object")
     *         )
     *     )
     * )
     */

    public function registro(Request $request)
    {
        try {
            $validacion = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'mensaje' => 'Faltan campos por rellenar o los campos no son válidos',
                'errores' => $e->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $validacion['name'],
            'email' => $validacion['email'],
            'password' => Hash::make($validacion['password']),
        ]);

        return response()->json([
            'mensaje' => 'Usuario registrado con éxito',
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Autenticación"},
     *     summary="Inicio de sesión de usuario",
     *     description="Autentica un usuario y devuelve un token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="usuario@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="Password123!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJhbGciOiJI..."),
     *             @OA\Property(property="mensaje", type="string", example="Inicio de sesión exitoso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas",
     *         @OA\JsonContent(
     *             @OA\Property(property="mensaje", type="string", example="Las credenciales proporcionadas son incorrectas")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="mensaje", type="string", example="Faltan campos por rellenar o los campos no son válidos"),
     *             @OA\Property(property="errores", type="object")
     *         )
     *     )
     * )
     */


    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'mensaje' => 'Faltan campos por rellenar o los campos no son válidos',
                'errores' => $e->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['mensaje' => 'Las credenciales proporcionadas son incorrectas'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'mensaje' => 'Inicio de sesión exitoso'], 200);
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     tags={"Autenticación"},
     *     summary="Cerrar sesión",
     *     description="Elimina los tokens de acceso para cerrar sesión",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Sesión cerrada con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sesión cerrada con éxito")
     *         )
     *     )
     * )
     */


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Sesión cerrada con éxito'], 200);
    }
}
