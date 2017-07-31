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

    public function displayReport(Request $request)
    {
        $data = $this->report($request);
        $data['downloadUrl'] = '/report-download?' . http_build_query($request->query());
        return view('reportResult', $data);
    }

    public function downloadReport(Request $request)
    {
        header('Content-Type: text/csv');
        header('Content-Transfer-Encoding: binary');
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="report.csv');

        $data = $this->report($request);
        $out = fopen('php://output', 'w');
        foreach($data['history'] as $item) {
            fputcsv($out, [
                $item->created_at,
                $item->change,
                $item->change_usd,
            ]);
        }
        fputcsv($out, [
            '', $data['total'], $data['totalUsd']
        ]);
        fclose($out);
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

        return [
            'history' => $history,
            'total' => $history->sum('change'),
            'totalUsd' => $history->sum('change_usd'),
        ];
    }
}