<?php

namespace App\Models;

use App\Models\task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $fillable = ["name"];
    public function tasks()
    {
        return $this->belongsToMany(task::class, 'categoriestask');
    }
}
