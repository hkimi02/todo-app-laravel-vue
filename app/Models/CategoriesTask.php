<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesTask extends Model
{
    use HasFactory;
    protected $table="categoriestask";
    protected $fillable = ["task_id","categories_id"];
}
