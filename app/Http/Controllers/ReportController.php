<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function indexPage(Request $request)
    {
        return view('reportIndex', ['name' => 'James']);
    }

    public function report(Request $request)
    {
        if (empty($request->input('name'))) {
            return abort(400, 'Name is required');
        }

        $account = Account::where('name', $request->name)->first();
        if (!$account){
            return response('account not found', 404);
        }

        $history = AccountHistory::where('account_id', $account->id);
        if (!empty($request->input('date-from'))) {
            $history->where(DB::raw('DATE(created_at)'), '>=', $request->input('date-from'));
        }
        if (!empty($request->input('date-to'))) {
            $history->where(DB::raw('DATE(created_at)'), '<=', $request->input('date-to'));
        }

        $history = $history->get();

        return view('reportResult', [
            'history' => $history,
            'total' => $history->sum('change'),
            'totalUsd' => $history->sum('change_usd'),
        ]);
    }
}