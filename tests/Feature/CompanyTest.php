<?php

namespace Tests\Feature;

use App\Models\Company;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Laravel\Passport\Passport;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();

    }

    /** @test */
    public function a_company_can_be_added_through_the_api()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/companies',$this->data());

        $this->assertCount(1, Company::all());
    }

    /** @test */
    public function a_name_is_required()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/companies',array_merge($this->data(),['name' => '']));

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function a_name_is_max_50_characters()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/companies',
            array_merge($this->data(),['name' => str_repeat('a', 51)])
        );

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function a_address_street_is_required()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/companies',array_merge($this->data(),['address_street' => '']));

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function a_address_street_is_max_50_characters()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/companies',
            array_merge($this->data(),['address_street' => str_repeat('a', 51)])
        );

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function a_address_zip_code_is_required()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/companies',array_merge($this->data(),['address_zip_code' => '']));

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function a_address_zip_code_is_max_50_characters()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/companies',
            array_merge($this->data(),['address_zip_code' => str_repeat('1', 11)])
        );

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function a_address_city_is_required()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/companies',array_merge($this->data(),['address_city' => '']));

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function a_address_city_is_max_50_characters()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/companies',
            array_merge($this->data(),['address_city' => str_repeat('1', 51)])
        );

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function a_address_country_is_required()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/companies',array_merge($this->data(),['address_country' => '']));

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function a_address_country_is_max_50_characters()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/companies',
            array_merge($this->data(),['address_country' => str_repeat('1', 51)])
        );

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function a_debtor_limit_is_required()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/companies',array_merge($this->data(),['debtor_limit' => '']));

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function a_debtor_limit_is_max_10_characters()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/companies',
            array_merge($this->data(),['debtor_limit' => 10000000000.00])
        );

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function a_debtor_limit_is_should_be_numeric()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/companies',
            array_merge($this->data(),['debtor_limit' => 'test'])
        );

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function a_status_is_required()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/companies',array_merge($this->data(),['status' => '']));

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function a_status_is_only_be_active_or_inactive()
    {
        $this->actingAsLoginUser();

        $response = $this->post('/api/companies',array_merge($this->data(),['status' => 'test']));

        $response->assertStatus(400)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertCount(0, Company::all());
    }

    private function actingAsLoginUser()
    {
        Passport::actingAs(factory(User::class)->create());
    }

    private function data()
    {
        return [
            'name' => 'test name',
            'address_street' => 'test street',
            'address_zip_code' => '12345',
            'address_city' => 'test city',
            'address_country' => 'test country',
            'debtor_limit' => 10000,
            'status' => 'active'
        ];
    }

}
