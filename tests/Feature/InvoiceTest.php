<?php

namespace Tests\Feature;

use App\Models\Company;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Models\Invoice;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    /** @test */
    public function a_invoice_can_be_added_through_the_api()
    {
        $this->actingAsLoginUser();
        $company_id = $this->savedCompany();

        $response = $this->post('/api/invoices',array_merge($this->data(),['company_id' => $company_id]));

        $this->assertCount(1, Invoice::all());
    }

    /** @test */
    public function total_invoice_amount_should_be_less_than_debtor_limit()
    {
        $this->actingAsLoginUser();
        $company_id = $this->savedCompany(2000);

        $response = $this->post('/api/invoices',array_merge($this->data(),['company_id' => $company_id]));

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Invoice::all());
    }

    /** @test */
    public function a_company_id_is_required()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/invoices',array_merge($this->data(),['company_id' => '']));

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Invoice::all());
    }

    private function actingAsLoginUser()
    {
        Passport::actingAs(factory(User::class)->create());
    }

    private function savedCompany($limit = 10000)
    {
        $company = factory(Company::class)->create(['debtor_limit' => $limit]);
        return $company->id;
    }

    private function data()
    {
        return [
            "company_id" => 1,
            "debtor" => [
               "name" => "test abc",
               "address_street" => "street 2",
               "address_zip_code" => 222222,
               "address_city" => "kurunegala",
               "address_country" => "UK"
            ],
            "items" => [
                [
                    "item_description" => "test item1",
                    "quantity" => 10,
                    "amount" => 1000
                ],
                [
                    "item_description" => "test item3",
                    "quantity" => 3,
                    "amount" => 3000
                ]
            ]
        ];
    }
}
