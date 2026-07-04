<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    protected $table = "invoices";

    protected $fillable = [
        'payment_id',
        'billing_type',
        'value',
        'due_date',
        'description',
        'external_reference',
    ];
}
