<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class ConexionImpresora extends Model
{
    protected $table = 'conexion_impresora';
    protected $primaryKey = 'id';
    public $timestamps = false;
}