<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'report_date',
        'total_sales',
        'total_transactions',
        'best_selling_product'
    ];

    public function bestProduct()
    {
        return $this->belongsTo(Product::class, 'best_selling_product');
    }
}
