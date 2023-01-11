<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    use HasFactory;
    protected $fillable = ["description","deadline","status","task_id"];
    public function parent(){
        return $this->belongsTo(task::class,'task_id');
    }
}
