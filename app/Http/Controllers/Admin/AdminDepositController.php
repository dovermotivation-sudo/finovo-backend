<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\DepositSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminDepositController extends Controller
{
    /**
     * Display a list of all deposits.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $query = Deposit::with('user')->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $deposits = $query->paginate(20);
        $pendingCount = Deposit::where('status', 'pending')->count();

        return view('admin.deposits.index', compact('deposits', 'status', 'pendingCount'));
    }

    /**
     * Show detailed view of a deposit.
     */
    public function show($id)
    {
        $deposit = Deposit::with('user')->findOrFail($id);
        return view('admin.deposits.show', compact('deposit'));
    }

    /**
     * Approve a deposit request.
     */
    public function approve(Request $request, $id)
    {
        $deposit = Deposit::findOrFail($id);

        if ($deposit->status !== 'pending') {
            return back()->with('error', 'This deposit request has already been processed.');
        }

        DB::transaction(function () use ($deposit, $request) {
            // Update deposit record
            $deposit->update([
                'status' => 'approved',
                'remarks' => $request->remarks,
                'approved_at' => now(),
            ]);

            // Add amount to user's portfolio value
            $user = $deposit->user;
            $user->portfolio_value += $deposit->amount;
            $user->save();
        });

        return redirect()->route('admin.deposits.index')->with('success', 'Deposit approved successfully and funds credited to user portfolio.');
    }

    /**
     * Reject a deposit request.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string|max:500',
        ]);

        $deposit = Deposit::findOrFail($id);

        if ($deposit->status !== 'pending') {
            return back()->with('error', 'This deposit request has already been processed.');
        }

        $deposit->update([
            'status' => 'rejected',
            'remarks' => $request->remarks,
            'rejected_at' => now(),
        ]);

        return redirect()->route('admin.deposits.index')->with('success', 'Deposit request rejected.');
    }

    /**
     * Show database configurable settings for BEP20/TRC20.
     */
    public function settings()
    {
        $settings = [
            'bep20_address' => DepositSetting::getValue('bep20_address'),
            'bep20_qr_code' => DepositSetting::getValue('bep20_qr_code'),
            'trc20_address' => DepositSetting::getValue('trc20_address'),
            'trc20_qr_code' => DepositSetting::getValue('trc20_qr_code'),
        ];

        return view('admin.deposits.settings', compact('settings'));
    }

    /**
     * Update settings.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'bep20_address' => 'required|string|max:255',
            'trc20_address' => 'required|string|max:255',
            'bep20_qr_code' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'trc20_qr_code' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update addresses
        DepositSetting::updateOrCreate(['key' => 'bep20_address'], ['value' => $request->bep20_address]);
        DepositSetting::updateOrCreate(['key' => 'trc20_address'], ['value' => $request->trc20_address]);

        // Handle BEP20 QR Code
        if ($request->hasFile('bep20_qr_code')) {
            // Delete old QR code if exists
            $oldQr = DepositSetting::getValue('bep20_qr_code');
            if ($oldQr) {
                Storage::disk('public')->delete($oldQr);
            }

            $path = $request->file('bep20_qr_code')->store('qr_codes', 'public');
            DepositSetting::updateOrCreate(['key' => 'bep20_qr_code'], ['value' => $path]);
        }

        // Handle TRC20 QR Code
        if ($request->hasFile('trc20_qr_code')) {
            // Delete old QR code if exists
            $oldQr = DepositSetting::getValue('trc20_qr_code');
            if ($oldQr) {
                Storage::disk('public')->delete($oldQr);
            }

            $path = $request->file('trc20_qr_code')->store('qr_codes', 'public');
            DepositSetting::updateOrCreate(['key' => 'trc20_qr_code'], ['value' => $path]);
        }

        return redirect()->route('admin.deposits.settings')->with('success', 'Deposit settings updated successfully.');
    }
}
