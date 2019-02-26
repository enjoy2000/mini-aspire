<?php
/**
 * Created by PhpStorm.
 * User: hatdao
 * Date: 7/30/18
 * Time: 10:20 PM
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    protected $table = 'repayments';

    protected $fillable = [
        'due_date',
        'paid_date',
        'amount',
    ];

    public static $rules = [
        'due_date' => 'date|required',
        'amount' => 'required',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'due_date',
        'paid_date',
    ];

    public function loan()
    {
        return $this->belongsTo('App\Models\Loan');
    }

    public function paymentHistories()
    {
        return $this->hasMany('App\Models\PaymentHistory');
    }

    public function getNeedToPayAmount($payDate = null)
    {
        if ($payDate === null) {
            $payDate = Carbon::now();
        }
        // TODO more complicated :D
        return $this->due_date >= $payDate ? $this->amount : $this->amount + $this->loan()->package()->arrangement_fee;
    }

    public function generatePayUrl()
    {
        // TODO implement payment
        return 'http://lvh.me';
    }
}
