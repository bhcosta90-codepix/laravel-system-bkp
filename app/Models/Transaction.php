<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'debit_id',
        'bank',
        'account_from_id',
        'account_to_id',
        'kind',
        'key',
        'description',
        'status',
        'value',
        'cancel_description',
    ];
}
