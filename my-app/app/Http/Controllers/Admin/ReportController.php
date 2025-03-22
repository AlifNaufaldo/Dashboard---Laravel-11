<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    // Menampilkan halaman laporan
    public function index()
    {
        return view('admin.reports.index');
    }

    // Menampilkan hasil laporan berdasarkan filter tanggal
    public function generate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])->get();

        return view('admin.reports.result', compact('transactions', 'startDate', 'endDate'));
    }

    // Export laporan ke PDF
    public function exportPdf(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])->get();

        $pdf = PDF::loadView('admin.reports.pdf', compact('transactions', 'startDate', 'endDate'));
        return $pdf->download('laporan_penjualan_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.pdf');
    }
}
