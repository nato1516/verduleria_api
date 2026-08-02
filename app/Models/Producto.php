<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    
    protected $fillable = [
        'nombre',
        'precio',
        'precio_mayor',
        'image_path',
        'activo',
        'descripcion',
        'categoria',
        'modal_id'
    ];
}
