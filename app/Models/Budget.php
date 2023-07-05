<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'summary_id',
        'btypes_id', // Add this line
        'amount',
        'created_by',
    ];


    public function summary()
    {
        return $this->belongsTo(Summary::class);
    }

    public function budgetType()
    {
        return $this->belongsTo(Btypes::class, 'btypes_id');
    }
}
