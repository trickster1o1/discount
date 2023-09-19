<?php

namespace App\Models;

use App\Models\Admin\Program;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramComment extends Model
{
    use HasFactory;
    protected $fillable = ['program_id','name','email','comment','status'];
    function program() {
        return $this->belongsTo(Program::class);
    }
}
