<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class PermisoEstablecimiento extends Model
{
    protected $table = 'permiso_establecimiento';
    protected $primaryKey = 'id';
    public $timestamps = false;
}