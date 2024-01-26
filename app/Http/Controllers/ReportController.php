<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reportData = [];
        if ($request->filled('start_date') || $request->filled('end_date') || $request->filled('status')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $status = $request->input('status');

            $query = DB::table('transactions')
                ->select(
                    DB::raw('DATE_FORMAT(due_on, "%M") as month'),
                    DB::raw('YEAR(due_on) as year'),
                    DB::raw('SUM(CASE WHEN status = "Paid" THEN amount ELSE 0 END) as paid'),
                    DB::raw('SUM(CASE WHEN status = "Outstanding" THEN amount ELSE 0 END) as outstanding'),
                    DB::raw('SUM(CASE WHEN status = "Overdue" THEN amount ELSE 0 END) as overdue')
                );

            if ($startDate) {
                $query->whereDate('due_on', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('due_on', '<=', $endDate);
            }

            if ($status) {
                $query->where('status', $status);
            }

            $reportData = $query
                ->groupBy(DB::raw('MONTH(due_on)'), DB::raw('YEAR(due_on)'))
                ->get();
        }

        return view('reports.index', compact('reportData'));
    }
}
