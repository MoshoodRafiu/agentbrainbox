<?php

namespace App\Http\Controllers;

use App\Http\Resources\MerchantResource;
use App\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MerchantController extends Controller
{
    public function index()
    {
        return MerchantResource::collection(Merchant::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_name' => 'required|unique:merchants',
            'business_email' => 'required|unique:merchants',
            'business_phone' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'business_address' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        Merchant::create($request->all());
        return response()->json(['success' => true, 'message' => 'Merchant registered'], 200);
    }

    public function show(Merchant $merchant)
    {
        return new MerchantResource($merchant);
    }

    public function update(Request $request, Merchant $merchant)
    {
        $validator = Validator::make($request->all(), [
            'business_name' => 'required|unique:merchants,business_name,'.$merchant->id,
            'business_email' => 'required|unique:merchants,business_email,'.$merchant->id,
            'business_phone' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'business_address' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $merchant->update($request->all());
        return response()->json(['success' => true, 'message' => 'Merchant updated'], 200);
    }
}
