<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function info($id, Request $request)
    {
        return response()->json(Account::findOrFail($id));
    }

    public function create(Request $request)
    {
        $data = $request->all();

        if (isset($data['currency'])) {
            try {
                $data['currency_id'] = Currency::where('code', $data['currency'])->firstOrFail()->id;
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'error' => 'Unknown currency',
                ], 400);
            }
        }

        $validator = Validator::make($data, Account::$rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $account = Account::create($data);
        return response()->json([
            'id' => $account->id,
        ]);
    }

    public function refill($id, Request $request)
    {
        if (empty($request->input('amount'))) {
            return response()->json([
                'error' => 'amount is required',
            ], 400);
        }

        $account = Account::where('id', $id)->lockForUpdate()->firstOrFail();
        $account->amount += $request->input('amount');
        $account->save();

        return response()->json([
            'id' => $account->id,
            'amount' => $account->amount,
        ]);
    }

    public function transaction($id, Request $request)
    {
        if ((int)$id === (int)$request->to) {
            return response()->json([
                'error' => 'Accounts is equal',
            ], 409);
        }
        if ($id < $request->to) {
            $accountFrom = Account::where('id', $id)->lockForUpdate()->firstOrFail();
            $accountTo = Account::where('id', $request->to)->lockForUpdate()->firstOrFail();
        } else {
            $accountTo = Account::where('id', $request->to)->lockForUpdate()->firstOrFail();
            $accountFrom = Account::where('id', $id)->lockForUpdate()->firstOrFail();
        }

        $rates = Currency::whereIn('id' [1])->rates()->currentRate();

        $accountFrom->amount -= $request->amount;
        $accountTo->amount += $request->amount;

        DB::transaction(function () use ($accountFrom, $accountTo) {
            $accountFrom->save();
            $accountTo->save();
        });

        return response()->json([
            'id' => $accountFrom->id,
            'amount' => $accountFrom->amount,
        ]);
    }
}