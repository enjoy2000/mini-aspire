<?php

namespace Tests\Feature;

use App\Models\Loan;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;


/**
 * Class CreateLoanTest
 * @package Tests\Feature
 *
 * TODO verify other methods
 */
class CreateLoanTest extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateLoanGenerateRepaymentSchedule()
    {
        $user = $this->login();
        $package = factory(Package::class)->create();

        $response = $this->post('/api/loans', [
            'user_id' => $user->id,
            'package_id' => $package->id,
            'start_date' => Carbon::now(),
            'amount' => 2000.0,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'package',
            'start_date',
            'created_at',
            'updated_at',
            'amount',
        ]);



        $firstRepayment = Loan::find($response->json('id'))->getFirstPayment();
        # first payment has due date equal start date + repayment_frequency_in_months
        $startDate = $response->json('start_date');
        $estimateDueDate = (new Carbon($startDate))
            ->addMonths($package->repayment_frequency_in_months);
        $this->assertEquals($firstRepayment->due_date->toDateString(), $estimateDueDate->toDateString());

        $paymentTimes = $package->getRepaymentTimes();
        $amountForEachRepayment = 2000 * (1 + $package->interest_rate / 100) / $paymentTimes;
        $this->assertEquals($firstRepayment->amount, number_format($amountForEachRepayment, 2));
    }
}
