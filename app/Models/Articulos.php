<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Importa el trait HasFactory

class articulos extends Model
{
    use HasFactory; // Usa el trait HasFactory para las fábrica

    protected $table = 'articulos'; // Nombre de la tabla

    protected $fillable = ['id','nombre', 'descripcion', 'marca', 'precio', 'imagen']; // Campos que pueden ser asignados masivamente
    
    public $timestamps = false; // Desactivar las marcas de tiempo
}
