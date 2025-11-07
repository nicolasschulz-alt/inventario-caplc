<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class MarcaDispositivo extends Model
{
    protected $table = 'marca_dispositivo';
    protected $primaryKey = 'id';
    public $timestamps = false;
}