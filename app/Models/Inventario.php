<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    const COLUMN_ID = 'id';
    //TO-DO
    const COLUMN_NAME = 'name';
    const COLUMN_MARCA = 'marca';
    const COLUMN_DEPARTAMENTO = 'Departamento';
    const COLUMN_TIPOHARDWARE = 'TipoHardware';   

    protected $guarded = [self::COLUMN_ID];
}
