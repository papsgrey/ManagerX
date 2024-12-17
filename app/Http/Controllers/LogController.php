<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    public function showLogs()
    {
        $logFile = storage_path('logs/laravel.log');
        $logEntries = [];

        if (File::exists($logFile)) {
            $logContent = File::lines($logFile);

            foreach ($logContent as $line) {
                if (preg_match('/^\[(.*?)\] (\w+)\.(.*?): (.*)/', $line, $matches)) {
                    $logEntries[] = [
                        'timestamp' => $matches[1],
                        'level' => $matches[2],
                        'message' => $matches[4],
                    ];
                }
            }

            // Reverse to show the newest entries first
            $logEntries = array_reverse($logEntries);
        }

        return view('admin.default.logs', compact('logEntries'));
    }
}
