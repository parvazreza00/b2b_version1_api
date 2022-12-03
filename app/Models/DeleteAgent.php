<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeleteAgent extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'deleted_agent';
}
