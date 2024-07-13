<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class invoices_details extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'note',
        'value_status',
        'status',
        'section',
        'product',
        'invoice_number',
        'id_Invoice',
        'payment_date'
        
    ];

    public function sec(): BelongsTo
    {
        return $this->belongsTo(sections::class, 'section');
    }
}
