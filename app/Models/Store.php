<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'owner_id',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
