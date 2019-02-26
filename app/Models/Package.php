<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';

    protected $fillable = [
        'interest_rate',
        'period_in_months',
        'repayment_frequency_in_months',
        'arrangement_fee',
    ];

    public function loans()
    {
        return $this->hasMany('App\Models\Loan');
    }

    public function getRepaymentTimes()
    {
        return $this->period_in_months / $this->repayment_frequency_in_months;
    }
}
