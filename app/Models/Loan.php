<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Loan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'borrower_id',
        'wallet_id',
        'amount',
        'remaining_balance',
        'duration_months',
        'purpose',
        'status',
        'contract_address',
        'disbursed_at',
        'due_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'remaining_balance' => 'decimal:2',
        'disbursed_at' => 'datetime',
        'due_date' => 'datetime',
    ];

    /**
     * Get the borrower (user) that owns the loan.
     */
    public function borrower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }

    /**
     * Get the wallet associated with this loan.
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Get the repayments for this loan.
     */
    public function repayments(): HasMany
    {
        return $this->hasMany(Repayment::class);
    }

    /**
     * Scope a query to only include active loans (approved or disbursed with remaining balance).
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', ['approved', 'disbursed'])
            ->where('remaining_balance', '>', 0);
    }

    /**
     * Scope a query to only include overdue loans.
     */
    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('status', 'disbursed')
            ->where('remaining_balance', '>', 0)
            ->where('due_date', '<', now());
    }

    /**
     * Scope a query to only include pending loans.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include disbursed loans.
     */
    public function scopeDisbursed(Builder $query): Builder
    {
        return $query->where('status', 'disbursed');
    }

    /**
     * Check if the loan is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'disbursed'
            && $this->remaining_balance > 0
            && $this->due_date
            && $this->due_date->isPast();
    }

    /**
     * Calculate the repayment progress percentage.
     */
    public function getProgressPercentageAttribute(): float
    {
        if ($this->amount <= 0) {
            return 0;
        }

        $paid = $this->amount - $this->remaining_balance;
        return round(($paid / $this->amount) * 100, 1);
    }
}
