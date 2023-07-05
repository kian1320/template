<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;
    protected $table = 'expenses';

    protected $fillable = [
        'date_issued',
        'voucher',
        'check',
        'encashment',
        'description',
        'type_id',
        'amount',

    ];

    public function summary()
    {
        return $this->belongsTo(Summary::class);
    }




    public function type()
    {
        return $this->belongsTo(Types::class, 'type_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expenses::class);
    }
}
