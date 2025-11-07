<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class PcApp extends Model
{
    protected $table = 'pc_app';
    protected $primaryKey = 'id';
    public $timestamps = false;
}