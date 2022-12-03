<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankContact extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'bank_accounts';
}
