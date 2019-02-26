<?php

namespace Tests\Feature;


use App\Models\Loan;
use App\Models\Package;
use Mockery;

class PayARepaymentTest extends BaseTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPayForALoan()
    {
        $user = $this->login();

        $package = factory(Package::class)->create();
        $loan = factory(Loan::class)->create([
            'user_id' => $user->id,
            'package_id' => $package->id,
        ]);

        $response = $this->post("/api/loans/{$loan->id}/pay", []);
        $this->assertEquals($response->content(), $loan->getFirstUnpaidPayment()->generatePayUrl());
    }
}
