<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog as Log;
use Inertia\Inertia;

class ActivityLog extends Controller
{
    public function index()
    {
        $logs = Log::limit(20)->latest()->get();

        return Inertia::render('Management/ActivityLog', [
            'logs' => $logs
        ]);
    }
}
