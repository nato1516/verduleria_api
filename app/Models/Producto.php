<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    
    protected $fillable = [
        'nombre',
        'precio',
        'precioXmayor',
        'image_path',
        'activo',
        'descripcion',
        'categoria',
        'modal_id'
    ];
}
