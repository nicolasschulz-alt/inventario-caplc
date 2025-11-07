<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class App extends Model
{
    protected $table = 'app';
    protected $primaryKey = 'id';
    public $timestamps = false;
}