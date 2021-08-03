<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserManagement extends Controller
{
    public function index()
    {
        $sort = request()->sort ?? 'created_at';
        $sortBy = request()->sort_by ?? 'asc';

        $users = User::orderBy($sort, $sortBy)->paginate('10');

        return Inertia::render('UserManagement', [
            'users' => $users
        ]);
    }


}
