<?php
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
 *
 */
