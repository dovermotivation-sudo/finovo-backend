<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DailyReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ApiController extends Controller
{
    /**
     * Endpoint for external script to update daily returns for all users.
     * Expects a POST request with an API_TOKEN in header or body, and an array of updates.
     */
    public function updateDailyReturnsAll(Request $request)
    {
        $token = $request->input('token') ?? $request->header('Authorization');
        
        // Simple token check (could also use Sanctum or an env token)
        $expectedToken = env('API_UPDATE_TOKEN', 'secret-update-token-123');
        
        if (str_replace('Bearer ', '', $token) !== $expectedToken) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'updates' => 'required|array',
            'updates.*.user_id' => 'required|exists:users,id',
            'updates.*.percentage' => 'required|numeric|between:-100,100',
            'updates.*.note' => 'nullable|string'
        ]);

        $date = $request->input('date');
        $updates = $request->input('updates');

        $processed = 0;
        foreach ($updates as $update) {
            $user = User::find($update['user_id']);
            if (!$user) continue;
            
            DailyReturn::updateOrCreate(
                ['user_id' => $user->id, 'return_date' => $date],
                [
                    'return_percentage' => $update['percentage'],
                    'return_amount'     => round($user->portfolio_value * abs($update['percentage']) / 100, 2),
                    'notes'             => $update['note'] ?? 'Updated via API',
                ]
            );
            $processed++;
        }

        return response()->json([
            'success' => true,
            'message' => "Successfully updated daily returns for $processed users on $date",
            'date' => $date,
            'processed' => $processed
        ]);
    }
}
