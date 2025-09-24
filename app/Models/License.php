<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $fillable = [
        'license_key',
        'registered_to',
        'valid_until',
        'is_active'
    ];

    public function isValid(): bool
    {
        return $this->is_active &&
            (!$this->valid_until || now()->lte($this->valid_until));
    }
}
