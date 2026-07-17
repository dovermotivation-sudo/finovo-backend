<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::find(4);
if ($user) {
    if (!$user->portfolio_value) {
        $user->portfolio_value = 1000;
        $user->save();
    }
    
    for($i=6; $i>=0; $i--) {
        $percentage = rand(-100, 500) / 100; // -1% to 5%
        App\Models\DailyReturn::updateOrCreate(
            ['user_id' => 4, 'return_date' => now()->subDays($i)->format('Y-m-d')],
            [
                'return_percentage' => $percentage,
                'return_amount' => round($user->portfolio_value * $percentage / 100, 2),
                'notes' => 'dummy data for demo'
            ]
        );
    }
    echo "Generated dummy data for user 4 (Client User).\n";
} else {
    echo "User 4 not found.\n";
}

