<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Mail;
 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\Admin\AdminReferralController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\Admin\AdminDepositController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\Admin\AdminSupportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/crypto', [DashboardController::class, 'crypto'])->name('crypto');
    Route::get('/derivative', [DashboardController::class, 'derivative'])->name('derivative');
    Route::get('/fix-flex', [DashboardController::class, 'fixFlex'])->name('fix-flex');
    Route::get('/compare', [DashboardController::class, 'compare'])->name('compare');
});

// Language switching route
Route::post('/language/{locale}', [LanguageController::class, 'switchLanguage'])->name('language.switch');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'super_admin'])->group(function () {
    Route::get('/super-admin/dashboard', [SuperAdminController::class, 'dashboard'])->name('super-admin.dashboard');
    Route::get('/super-admin/users', [SuperAdminController::class, 'users'])->name('super-admin.users');
    Route::get('/super-admin/users/{id}/edit', [SuperAdminController::class, 'editUser'])->name('super-admin.users.edit');
    Route::post('/super-admin/users/{id}', [SuperAdminController::class, 'updateUser'])->name('super-admin.users.update');
    Route::delete('/super-admin/users/delete', [SuperAdminController::class, 'deleteUsers'])->name('super-admin.users.delete');
    Route::get('/super-admin/plans', [SuperAdminController::class, 'plans'])->name('super-admin.plans');
    Route::get('/super-admin/plans/{id}/edit', [SuperAdminController::class, 'editPlan'])->name('super-admin.plans.edit');
    Route::post('/super-admin/plans/{id}', [SuperAdminController::class, 'updatePlan'])->name('super-admin.plans.update');
});

// Root URL → check login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login'); 
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});

// KYC Routes for Users
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/kyc-application', [KycController::class, 'index'])->name('kyc.application');
    Route::post('/kyc-application', [KycController::class, 'store'])->name('kyc.store');
    Route::get('/kyc-status', [KycController::class, 'status'])->name('kyc.status');
    Route::post('/kyc-resubmit', function() {
        \App\Models\KycDocument::where('user_id', auth()->id())
            ->where('status', 'rejected')
            ->delete();
        return redirect()->route('kyc.application');
    })->name('kyc.resubmit');
});

// Deposits Routes for Users
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/deposits', [DepositController::class, 'index'])->name('deposits.index');
    Route::post('/deposits', [DepositController::class, 'store'])->name('deposits.store');
});

// Withdrawals Routes for Users
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals', [WithdrawalController::class, 'store'])->name('withdrawals.store');
});

// KYC Routes for Admin
Route::middleware(['auth', 'super_admin'])->prefix('admin')->group(function () {
    Route::get('/kyc', [KycController::class, 'adminIndex'])->name('admin.kyc.index');
    Route::get('/kyc/{id}', [KycController::class, 'adminShow'])->name('admin.kyc.show');
    Route::post('/kyc/{id}/approve', [KycController::class, 'approve'])->name('admin.kyc.approve');
    Route::post('/kyc/{id}/reject', [KycController::class, 'reject'])->name('admin.kyc.reject');
    Route::delete('/kyc/delete', [KycController::class, 'deleteKycDocuments'])->name('admin.kyc.delete');
});

// Deposits Routes for Admin
Route::middleware(['auth', 'super_admin'])->prefix('admin')->group(function () {
    Route::get('/deposits', [AdminDepositController::class, 'index'])->name('admin.deposits.index');
    Route::get('/deposits/{id}', [AdminDepositController::class, 'show'])->name('admin.deposits.show');
    Route::post('/deposits/{id}/approve', [AdminDepositController::class, 'approve'])->name('admin.deposits.approve');
    Route::post('/deposits/{id}/reject', [AdminDepositController::class, 'reject'])->name('admin.deposits.reject');
    Route::get('/deposit-settings', [AdminDepositController::class, 'settings'])->name('admin.deposits.settings');
    Route::post('/deposit-settings', [AdminDepositController::class, 'updateSettings'])->name('admin.deposits.settings.update');
});

// Withdrawals Routes for Admin
Route::middleware(['auth', 'super_admin'])->prefix('admin')->group(function () {
    Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])->name('admin.withdrawals.index');
    Route::get('/withdrawals/{id}', [AdminWithdrawalController::class, 'show'])->name('admin.withdrawals.show');
    Route::post('/withdrawals/{id}/approve', [AdminWithdrawalController::class, 'approve'])->name('admin.withdrawals.approve');
    Route::post('/withdrawals/{id}/reject', [AdminWithdrawalController::class, 'reject'])->name('admin.withdrawals.reject');
});

// Support Ticket Routes for Users
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/support', [SupportTicketController::class, 'index'])->name('support.index');
    Route::post('/support', [SupportTicketController::class, 'store'])->name('support.store');
    Route::get('/support/{id}', [SupportTicketController::class, 'show'])->name('support.show');
});

// Support Ticket Routes for Admin
Route::middleware(['auth', 'super_admin'])->prefix('admin')->group(function () {
    Route::get('/support', [AdminSupportController::class, 'index'])->name('admin.support.index');
    Route::get('/support/{id}', [AdminSupportController::class, 'show'])->name('admin.support.show');
    Route::post('/support/{id}/reply', [AdminSupportController::class, 'reply'])->name('admin.support.reply');
});

// Referral Routes for Users
Route::middleware(['auth', 'verified'])->prefix('referrals')->group(function () {
    Route::get('/', [ReferralController::class, 'index'])->name('referrals.index');
    Route::get('/info', [ReferralController::class, 'getReferralInfo'])->name('referrals.info');
    Route::get('/stats', [ReferralController::class, 'getStats'])->name('referrals.stats');
    Route::get('/list', [ReferralController::class, 'getReferrals'])->name('referrals.list');
    Route::get('/rewards', [ReferralController::class, 'getRewards'])->name('referrals.rewards');
});

// Referral Routes for Admin
Route::middleware(['auth', 'super_admin'])->prefix('admin/referrals')->group(function () {
    Route::get('/', [AdminReferralController::class, 'index'])->name('admin.referrals.index');
    Route::get('/settings', [AdminReferralController::class, 'settings'])->name('admin.referrals.settings');
    Route::post('/settings', [AdminReferralController::class, 'updateSettings'])->name('admin.referrals.settings.update');
    Route::get('/{id}', [AdminReferralController::class, 'show'])->name('admin.referrals.show');
    Route::post('/{id}/process-reward', [AdminReferralController::class, 'processReward'])->name('admin.referrals.process-reward');
    Route::get('/rewards/list', [AdminReferralController::class, 'rewards'])->name('admin.referrals.rewards');
    Route::post('/rewards/{id}/credit', [AdminReferralController::class, 'creditReward'])->name('admin.referrals.rewards.credit');
    Route::post('/rewards/{id}/cancel', [AdminReferralController::class, 'cancelReward'])->name('admin.referrals.rewards.cancel');
    Route::get('/stats/data', [AdminReferralController::class, 'getStats'])->name('admin.referrals.stats');
    Route::delete('/delete', [AdminReferralController::class, 'deleteReferrals'])->name('admin.referrals.delete');
});

// MT5 Routes for Admin
Route::middleware(['auth', 'super_admin'])->prefix('admin')->group(function () {
    Route::get('/mt5', [\App\Http\Controllers\Admin\AdminMt5Controller::class, 'index'])->name('admin.mt5.index');
    Route::get('/mt5/{id}', [\App\Http\Controllers\Admin\AdminMt5Controller::class, 'show'])->name('admin.mt5.show');
    Route::post('/mt5/{id}/attach', [\App\Http\Controllers\Admin\AdminMt5Controller::class, 'attach'])->name('admin.mt5.attach');
});

require __DIR__.'/auth.php';
