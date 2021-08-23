<?php

namespace Tests\Feature;

use App\Models\Company;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_company_can_be_added_through_the_api()
    {
        $this->withoutExceptionHandling();
        
        $this->actingAs(factory(User::class)->create());

        $response = $this->post('/companies',[
            'name' => 'test name',
            'address_street' => 'test street',
            'address_zip_code' => '12345',
            'address_city' => 'test city',
            'address_country' => 'test country',
            'debtor_limit' => 10000,
            'status' => 'active'
        ]);

        $this->assertCount(1, Company::all());
    }

}
