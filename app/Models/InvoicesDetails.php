<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicesDetails extends Model
{
    use HasFactory;
    // In InvoicesDetails model
public function invoice()
{
    return $this->belongsTo(Invoices::class, 'invoice_id');
}

}
