<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Restaurante
 *
 * @OA\Schema(
 *     schema="Restaurante",
 *     type="object",
 *     title="Restaurante",
 *     description="Modelo de restaurante",
 *     @OA\Property(property="id_restaurante", type="integer", format="int64", example=1),
 *     @OA\Property(property="nombre_restaurante", type="string", example="La Parrilla Feliz"),
 *     @OA\Property(property="direccion_restaurante", type="string", example="Calle Falsa 123, Ciudad"),
 *     @OA\Property(property="telefono_restaurante", type="string", example="+34 123 456 789")
 * )
 */
class Restaurante extends Model
{
	protected $table = 'restaurantes';
	protected $primaryKey = 'id_restaurante';
	public $timestamps = false;

	protected $fillable = [
		'nombre_restaurante',
		'direccion_restaurante',
		'telefono_restaurante'
	];
}
