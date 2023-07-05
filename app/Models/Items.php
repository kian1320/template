<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    protected $table = 'items';

    protected $fillable = [
        'name',
        'serial_number',
        'location',
        'created_by',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function repairs()
    {
        return $this->hasMany(Repairs::class, 'item_id', 'id');
    }
}
