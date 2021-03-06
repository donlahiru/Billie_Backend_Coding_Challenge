<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CompanyService as CompanyService;

class CompanyController extends Controller
{
    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

    public function store(CompanyService $companyService)
    {
        try {
            $validator = $companyService->validator($this->_request->all());

            if($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validator->errors()->toArray()
                ],400);
            }

            $result = $companyService->create($validator->getData());
            if($result) {
                return response()->json([
                    'error' => false,
                    'message' => 'Successfully created.'
                ],200);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'error in saving.'
                ],400);
            }

        } catch (\Exception $e){
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ],401);
        }

    }

    public function update($id, CompanyService $companyService)
    {
        try {
            $validator = $companyService->validator($this->_request->all());

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validator->errors()->toArray()
                ], 400);
            }

            $result = $companyService->update($id, $validator->getData());
            if($result) {
                return response()->json([
                    'error' => false,
                    'message' => 'Successfully updated.'
                ], 200);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Error in updating.'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ],401);
        }
    }

    public function destroy($id, CompanyService $companyService)
    {
        try {
            $result = $companyService->delete($id);

            if($result) {
                return response()->json([
                    'error' => false,
                    'message' => 'Successfully deleted.'
                ], 200);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Error in deleting.'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ],401);
        }
    }
}
