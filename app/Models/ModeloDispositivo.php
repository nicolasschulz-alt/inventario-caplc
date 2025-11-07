<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class ModeloDispositivo extends Model
{
    protected $table = 'modelo_dispositivo';
    protected $primaryKey = 'id';
    public $timestamps = false;
}