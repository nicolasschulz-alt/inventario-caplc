<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Sala extends Model
{
    protected $table = 'sala';
    protected $primaryKey = 'id';
    public $timestamps = false;
}