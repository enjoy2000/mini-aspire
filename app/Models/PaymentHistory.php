<?php
/**
 * Created by PhpStorm.
 * User: hatdao
 * Date: 7/30/18
 * Time: 10:20 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $table = 'payment_histories';

    public function repayment()
    {
        return $this->belongsTo('App\Models\Repayment');
    }
}