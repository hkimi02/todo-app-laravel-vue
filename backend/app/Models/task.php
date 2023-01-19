<?php

namespace App\Models;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class task extends Model
{
    use HasFactory;
    protected $fillable = ["name","duedate"];
    public function subtasks(){
        return $this->hasMany(SubTask::class);
    }
    public function category()
    {
        return $this->belongsToMany(Categories::class, 'categoriestask');
    }
    public function task(){
        return $this->belongsTo(User::class,'users');
    }
}
