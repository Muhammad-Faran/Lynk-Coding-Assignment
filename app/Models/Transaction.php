<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'amount',
        'paid_amount',
        'balance',
        'payer',
        'due_on',
        'vat',
        'is_vat_inclusive',
        'status',
    ];

    public static function generateTransactionId()
    {
        return 'TX' . now()->format('YmdHis') . \Str::random(2);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $transaction->transaction_id = self::generateTransactionId();
        });
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'payer', 'id');
    }

    public function getStatusBadgeAttribute()
    {
        $status = $this->attributes['status'];

        switch ($status) {
            case 'Overdue':
                return '<span class="badge bg-danger">' . $status . '</span>';
            case 'Outstanding':
                return '<span class="badge bg-info">' . $status . '</span>';
            case 'Paid':
                return '<span class="badge bg-success">' . $status . '</span>';
            default:
                return '<span class="badge bg-secondary">' . $status . '</span>';
        }
    }
}
