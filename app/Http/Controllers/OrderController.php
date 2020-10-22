<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        return OrderResource::collection(Order::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_name' => 'required',
            'business_email' => 'required',
            'business_phone' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'business_address' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'business_name' => 'required',
            'business_email' => 'required',
            'business_phone' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'business_address' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
    }
}
