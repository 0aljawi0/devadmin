<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class UserManagement extends Controller
{
    public function index()
    {
        $sort = request()->sort ?? 'created_at';
        $sortBy = request()->sort_by ?? 'asc';

        $users = User::orderBy($sort, $sortBy)
                    ->with('role')
                    ->paginate('10');

        $roles = Role::orderBy('title', 'asc')->get();

        return Inertia::render('Management/UserManagement', [
            'users' => $users,
            'roles' => $roles->map(function($item) {
                return [
                    'title' => $item->title,
                    'value' => $item->id
                ];
            })
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return $this->comeback('User added successfully');
    }

    public function update_profile(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|max:50',
            'role_id' => 'required',
        ]);

        $user->fill($request->all())->save();
        return $this->comeback('User profile changed successfully');
    }

    public function update_password(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user->fill(['password' => Hash::make($request->password)])->save();
        return $this->comeback('User password changed successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->comeback('User deleted successfully');
    }

    public function destroy_bulk(Request $request)
    {
        $count = 0;

        foreach ($request->check as $item) {
            $data = User::find($item);
            $data->delete();
            $count++;
        }

        return $this->comeback($count . ' User deleted successfully');
    }
}
