<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Btypes extends Model
{
    use HasFactory;


    protected $table = 'btypes';



    protected $fillable = [
        'name',
        'created_by',

    ];


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function budget()
    {
        return $this->hasOne(Budget::class, 'btypes_id');
    }
}
