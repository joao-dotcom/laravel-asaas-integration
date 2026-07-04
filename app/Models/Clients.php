<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    protected $table = "clients";

    protected $fillable = [
        'user_id',
        'cpfCnpj',
        'name',
        'email',
        'phone_number',
        'mobile_phone',
        'address',
        'addressNumber',
        'complement',
        'customer_id',
    ];
}
