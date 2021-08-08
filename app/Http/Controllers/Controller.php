<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function comeback($message, $success = true)
    {
        if ($success) {
            ActivityLog::create(['log' => Auth::user()->name . ' | ' . $message]);
            return redirect()->back()->with('message', $message);
        } else {
            ActivityLog::create(['log' => Auth::user()->name . ' | ' . $message]);
            return redirect()->back()->withErrors(['message' => $message]);
        }
    }

    public function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function administratorManage()
    {
        return [
            'manages' => [
                0 => [
                    'pivot' => [
                        'read' => 1,
                        'add' => 1,
                        'update' => 1,
                        'delete' => 1,
                    ]
                ]
            ]
        ];
    }
}
