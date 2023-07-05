<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lexpenses extends Model
{
    use HasFactory;
    protected $table = 'lexpenses';

    protected $fillable = [
        'date_issued',
        'voucher',
        'check',
        'encashment',
        'description',
        'type_id',
        'amount',

    ];

    public function type()
    {
        return $this->belongsTo(Types::class);
    }
}
