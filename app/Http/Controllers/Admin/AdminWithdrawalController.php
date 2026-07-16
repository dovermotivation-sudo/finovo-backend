<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminWithdrawalController extends Controller
{
    /**
     * Display a list of all withdrawals.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $query = Withdrawal::with('user')->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $withdrawals = $query->paginate(20);
        $pendingCount = Withdrawal::where('status', 'pending')->count();

        return view('admin.withdrawals.index', compact('withdrawals', 'status', 'pendingCount'));
    }

    /**
     * Show detailed view of a withdrawal.
     */
    public function show($id)
    {
        $withdrawal = Withdrawal::with('user')->findOrFail($id);
        return view('admin.withdrawals.show', compact('withdrawal'));
    }

    /**
     * Approve a withdrawal request.
     */
    public function approve(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'This withdrawal request has already been processed.');
        }

        $withdrawal->update([
            'status' => 'approved',
            'transaction_id' => $request->transaction_id,
            'remarks' => $request->remarks,
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.withdrawals.index')->with('success', 'Withdrawal request approved successfully.');
    }

    /**
     * Reject a withdrawal request.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string|max:500',
        ]);

        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'This withdrawal request has already been processed.');
        }

        DB::transaction(function () use ($withdrawal, $request) {
            $withdrawal->update([
                'status' => 'rejected',
                'remarks' => $request->remarks,
                'rejected_at' => now(),
            ]);

            // Refund the amount + fee back to user's portfolio value
            $user = $withdrawal->user;
            $user->portfolio_value += ($withdrawal->amount + $withdrawal->fee);
            $user->save();
        });

        return redirect()->route('admin.withdrawals.index')->with('success', 'Withdrawal request rejected and funds refunded to user portfolio.');
    }
}
