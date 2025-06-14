<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel configuration
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\Entry;

echo "=== TIMEZONE TEST ===\n";
echo "Current PHP timezone: " . date_default_timezone_get() . "\n";
echo "Laravel app timezone: " . config('app.timezone') . "\n";
echo "Current time (PHP): " . date('Y-m-d H:i:s') . "\n";
echo "Current time (Carbon): " . Carbon::now()->format('Y-m-d H:i:s') . "\n";
echo "Current time (Carbon with tz): " . Carbon::now(config('app.timezone'))->format('Y-m-d H:i:s') . "\n";

echo "\n=== TESTING SCHEDULE TIME HANDLING ===\n";

// Test the Schedule time accessors
$schedule = new Schedule();
$schedule->start_time = '08:00:00';
$schedule->end_time = '17:00:00';

echo "Raw start_time: " . $schedule->getRawOriginal('start_time') ?? 'null' . "\n";
echo "Formatted start_time: " . $schedule->start_time . "\n";
echo "Raw end_time: " . $schedule->getRawOriginal('end_time') ?? 'null' . "\n";
echo "Formatted end_time: " . $schedule->end_time . "\n";

echo "\n=== TESTING ENTRY DATETIME HANDLING ===\n";

// Test Entry datetime handling
$entry = new Entry();
$entry->entry_time = Carbon::now();
$entry->exit_time = Carbon::now()->addHours(8);

echo "Entry time: " . $entry->entry_time->format('Y-m-d H:i:s') . "\n";
echo "Exit time: " . $entry->exit_time->format('Y-m-d H:i:s') . "\n";
echo "Entry timezone: " . $entry->entry_time->timezone->getName() . "\n";
echo "Exit timezone: " . $entry->exit_time->timezone->getName() . "\n";

echo "\n=== TEST COMPLETE ===\n";
