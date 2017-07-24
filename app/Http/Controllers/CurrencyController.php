<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\CurrencyRate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    public function createRate($code, Request $request)
    {
        try {
            $currencyId = Currency::where('code', $code)->firstOrFail()->id;
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Unknown currency',
            ], 400);
        }

        $data = $request->all();
        $data['currency_id'] = $currencyId;

        $validator = Validator::make($data, CurrencyRate::$rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $account = CurrencyRate::create($data);
        return response()->json([
            'id' => $account->id,
        ]);
    }
}