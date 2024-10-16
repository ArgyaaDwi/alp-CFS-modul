<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class TransactionController extends Controller
{
    public function viewTransaction()
    {
        $admin = Auth::user();
        $transactions = Transaction::with(['detailTransaction', 'user', 'city'])->get();
        return view('pages.role_admin.transaction.transaction', compact('admin', 'transactions'));
    }
    public function detailTransaction($id)
    {
        $admin = Auth::user();
        $transactions = Transaction::with(['detailTransaction', 'user', 'city'])->find($id);
        return view('pages.role_admin.transaction.detail_transaction', compact('admin', 'transactions'));
    }
    // public function generatePDF($id)
    // {
    //     $transaction = Transaction::with(['detailTransaction', 'user', 'city'])->find($id);
    //     if (!$transaction) {
    //         return redirect()->back()->withErrors('Transaction not found');
    //     }
    //     $pdf = PDF::loadview('pages.role_admin.transaction.invoice', compact('transaction'));
    //     return $pdf->download('invoice.pdf');
    // }
    public function deleteTransaction($id)
    {
        $transactions = Transaction::where('id', $id)->first();
        if (!$transactions) {
            return redirect()->route('admin.transaction.index')->with('error', 'Transaksi tidak ditemukan.');
        }
        Transaction::where('id', $id)->delete();
        return redirect()->route('admin.transaction.index')->with('success', 'Berhasil menghapus <strong style="color:green;">' . e($transactions->transaction_code) . '</strong> dari produk');
    }
}
