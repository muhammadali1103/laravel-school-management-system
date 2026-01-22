<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_structure_id',
        'student_id',
        'amount',
        'discount',
        'paid_amount',
        'due_date',
        'paid_date',
        'status',
        'fee_type',
        'payment_method',
        'payment_notes',
        'remarks',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    /**
     * Get the student for this fee
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feeStructure()
    {
        return $this->belongsTo(FeeStructure::class);
    }

    /**
     * Get net amount after discount
     */
    public function getNetAmountAttribute()
    {
        return $this->amount - $this->discount;
    }

    /**
     * Get outstanding balance
     */
    public function getOutstandingBalanceAttribute()
    {
        return $this->net_amount - $this->paid_amount;
    }

    /**
     * Check if fee is overdue
     */
    public function isOverdue()
    {
        return $this->status !== 'paid' && $this->due_date < Carbon::now();
    }

    /**
     * Update payment status based on paid amount
     */
    public function updatePaymentStatus()
    {
        if ($this->paid_amount >= $this->net_amount) {
            $this->status = 'paid';
        } elseif ($this->paid_amount > 0) {
            $this->status = 'partial';
        } else {
            $this->status = 'pending';
        }

        $this->save();
    }
}

