<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Importa el trait HasFactory

class Post extends Model
{
    use HasFactory; // Usa el trait HasFactory para las fábricas

    protected $fillable = ['id','nombre', 'descripcion', 'marca', 'precio', 'imagen']; // Campos que pueden ser asignados masivamente
}
