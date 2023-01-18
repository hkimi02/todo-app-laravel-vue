<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    use HasFactory;
    protected $fillable = ["description","deadline","status"];
    protected $table = "subtasks";
    public function task(){
        return $this->belongsTo(task::class,'task_id');
    }
}
