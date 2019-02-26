<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table = 'loans';

    protected $fillable = [
        'package_id',
        'user_id',
        'start_date',
        'due_date',
        'amount',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'start_date',
        'due_date',
    ];

    public static $rules = [
        'user_id' => 'required',
        'package_id' => 'required',
        'start_date' => 'required|date',
        'amount' => 'required',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function package()
    {
        return $this->belongsTo('App\Models\Package');
    }

    public function repayments()
    {
        return $this->hasMany('App\Models\Repayment');
    }

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        self::created(function ($loan) {
            for ($i = 0; $i < $loan->package->getRepaymentTimes(); $i++) {
                $additionalMonths = $loan->package->repayment_frequency_in_months * ($i + 1);
                $loan->repayments()->create([
                    'user_id' => $loan->user_id,
                    'due_date' => $loan->start_date->addMonths($additionalMonths),
                    // TODO of course this amount would be much more complicated
                    'amount' => $loan->amount * (1 + $loan->package->interest_rate / 100) / $loan->package->getRepaymentTimes(),
                ]);
            }
        });
    }

    public function getFirstPayment()
    {
        return $this->repayments()->orderBy('due_date')->first();
    }

    public function getFirstUnpaidPayment()
    {
        return $this->repayments()->whereNull('paid_date')->orderBy('due_date')->first();
    }
}