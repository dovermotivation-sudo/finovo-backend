<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\KycDocument;
use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    // Show admin dashboard with stats
    public function dashboard()
    {
        $data = [
            'totalUsers' => User::where('role', 'user')->count(),
            'totalInvestment' => User::where('role', 'user')->sum('portfolio_value'),
            'totalReturns' => User::where('role', 'user')->sum('total_returns'),
            'recentUsers' => User::where('role', 'user')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            'topInvestors' => User::where('role', 'user')
                ->orderBy('portfolio_value', 'desc')
                ->take(5)
                ->get(),
            // KYC Statistics
            'totalKyc' => KycDocument::count(),
            'pendingKyc' => KycDocument::where('status', 'pending')->count(),
            'verifiedKyc' => KycDocument::where('status', 'verified')->count(),
            'rejectedKyc' => KycDocument::where('status', 'rejected')->count(),
            'recentKyc' => KycDocument::with('user')
                ->orderBy('submitted_at', 'desc')
                ->take(5)
                ->get(),
            // Deposit Statistics
            'totalDeposits' => Deposit::count(),
            'pendingDeposits' => Deposit::where('status', 'pending')->count(),
            'approvedDeposits' => Deposit::where('status', 'approved')->count(),
            'rejectedDeposits' => Deposit::where('status', 'rejected')->count(),
            'totalDepositedAmount' => Deposit::where('status', 'approved')->sum('amount'),
            'recentDeposits' => Deposit::with('user')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            // Withdrawal Statistics
            'totalWithdrawals' => Withdrawal::count(),
            'pendingWithdrawals' => Withdrawal::where('status', 'pending')->count(),
            'approvedWithdrawals' => Withdrawal::where('status', 'approved')->count(),
            'rejectedWithdrawals' => Withdrawal::where('status', 'rejected')->count(),
            'totalWithdrawnAmount' => Withdrawal::where('status', 'approved')->sum('amount'),
            'recentWithdrawals' => Withdrawal::with('user')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            // Support Statistics
            'totalTickets' => SupportTicket::count(),
            'pendingTickets' => SupportTicket::where('status', 'open')->count(),
            'resolvedTickets' => SupportTicket::where('status', 'resolved')->count(),
            'recentTickets' => SupportTicket::with('user')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
        ];

        return view('super-admin.dashboard', $data);
    }
    // Show all users with role 'user'
    public function users()
    {
        $users = User::where('role', 'user')->orderBy('created_at', 'desc')->get();
        return view('super-admin.user', compact('users'));
    }

    // Show edit form for a specific user
    public function editUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== 'user') {
            abort(403, 'Unauthorized action.');
        }

        return view('super-admin.edit-user', compact('user'));
    }

    // Handle user update request
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // dd($request->all());
        if ($user->role !== 'user') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'portfolio_value' => 'required|numeric',
            'total_returns' => 'required|numeric',
            'growth_rate' => 'required|numeric',
        ]);

        $user->update([
            'name' => $request->name,
            'portfolio_value' => $request->portfolio_value,
            'total_returns' => $request->total_returns,
            'growth_rate' => $request->growth_rate,
        ]);

        return redirect()->route('super-admin.users')->with('success', 'User updated successfully.');
    }


    // Delete multiple users
    public function deleteUsers(Request $request)
    {
        $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ]);

        $deletedCount = User::whereIn('id', $request->users)
            ->where('role', 'user')
            ->delete();

        return redirect()->route('super-admin.users')->with('success', $deletedCount . ' user(s) deleted successfully.');
    }
}
