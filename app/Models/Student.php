<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'email', 'task'];

    public $incrementing = false; // Disable auto-incrementing
    protected $keyType = 'string'; 
}