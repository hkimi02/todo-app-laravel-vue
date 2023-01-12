<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    use HasFactory;
    protected $fillable = ["name","duedate"];
    public function subtasks(){
        return $this->hasMany(SubTask::class);
    }
}
