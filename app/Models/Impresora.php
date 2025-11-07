<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Impresora extends Model
{
    protected $table = 'impresora';
    protected $primaryKey = 'id';
    public $timestamps = false;
}