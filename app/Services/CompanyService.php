<?php
namespace App\Services;

use Validator;
use App\Models\Company as Company;
use Illuminate\Validation\Rule;

class CompanyService
{
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:50',
            'address_street' => 'required|max:50',
            'address_zip_code' => 'required|max:10',
            'address_city' => 'required|max:50',
            'address_country' => 'required|max:50',
            'debtor_limit' => 'required|numeric|between:0.00,9999999999.99',
            'status' => ['required',Rule::in([
                Company::STATUS_ACTIVE,
                Company::STATUS_INACTIVE,
            ]),]
        ]);
    }

    public function create(array $data)
    {
        return Company::create($data);
    }

    public function update($id, array $data)
    {
        return Company::where('id',$id)->update($data);
    }

    public function delete($id)
    {
        return Company::destroy($id);
    }
}
