<?php 

namespace src\Models;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
  
  protected $fillable = [
    'name', 'description', 'created_at', 'updated_at'
  ];

}